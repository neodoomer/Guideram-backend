<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Expert;
use App\Models\Work_time;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class
ExpertController extends Controller
{

    public function create(Request $request) {

        $validateUser=Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'photo'=>'image|mimes:jpg,png,jpeg,svg|max:2048',
            'isExpert'=>'boolean',
            'password'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'experience'=>"required",
        ]
    );
    if($validateUser->fails() || !$request->is_expert){
        return response()->json([
            'status'=> false,
            'message'=>'validation erorr',
            'errors'=>$validateUser->errors()
        ],401);
    }
    //check if there is a photo
    $photoPath=$request->file('photo')?$request->file('photo')->store('images','public'):"";

    //creating user if succssed
    $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'photo'=>$photoPath,
        'password'=>Hash::make($request->password),
        'is_expert'=> $request->is_expert,
    ]);
    $expert=Expert::create([
        'expert_id'=>$user->user_id,
        "phone"=>$request->phone,
        "address"=>$request->address,
        'experience'=>$request->experience
    ]);
    return response()->json([
        'status'=> true,
        'message'=>'Expert create successfully',
        'token'=>$user->createToken("API TOKEN")->plainTextToken,
        'user_id'=>$user->user_id
    ],200);
    }




    public function update(Request $request,$id){
        if(!isset($request->cost)&&!isset($request->duration)&&!isset($request->from)&&!isset($request->to)&&!isset($request->day)&&!isset($request->consultation_type_id))
        {
            return response()->json([
                "status"=>false,
                "message"=>"invalid input "
            ],404);
        }
        $expert=Expert::where("expert_id","=",$id)->first();
        if(!isset($expert)){
            return response()->json([
                "status"=>false,
                "message"=>"invaild Id"
            ]);
        }
            if(isset($request->cost)){
            $expert->cost=$request->cost;

            $expert->save();
        }
            if(isset($request->duration)){
        $expert->duration=$request->duration;
        $expert->save();
    }

        if(isset($request->day)&&isset($request->from)&&isset($request->to)){
            $worktimesForUser=$expert->work_time()->get();
            //check if the time crossed or reapeted
             foreach($worktimesForUser as $time){
                if($request->day==$time->day){
                    if(!($time->from >= $request->to) && !($request->from >= $time->to)){
                        return response()->json([
                            "status"=>false,
                            "message"=>"The Time Is Crossed With Another One Or Repeated"
                        ],404);
                    }
                    }
                    if($request->from>$request->to){
                        return response()->json([
                            "status"=>false,
                            "message"=>"The Time Is Crossed With Another One Or Repeated",
                            "worktimesForUser"=>$worktimesForUser
                        ],404);
                    }
                    if($request->from >24 || $request->to>24)
                    return response()->json([
                        "status"=>false,
                        "message"=>"invalid input",
                        "worktimesForUser"=>$worktimesForUser
                    ],404);
             }
            $worktime=Work_time::
            create([
                'day'=>$request->day,
                'to'=>$request->to,
                'from'=>$request->from ,'expert_id'=>$expert->expert_id
            ]);

        }
        if(isset($request->consultation_type_id)){
            $expert->expert_consultation_types()->syncWithoutDetaching([
                'consultation_type_id'=>$request->consultation_type_id,
            ]);
        }

        return response()->json([
            "status"=>true,
            "message"=>'modified successfully'],200);
    }


    public function profile($id){
        $expert=Expert::where("expert_id","=",$id)->first();
        if(!isset($expert)){
            return response()->json([
                "message"=>"Expert Not Found ",
            ],404);
        }
        $user=$expert->join('users',"users.user_id","=","user_id")->where("expert_id","=",$expert->expert_id)->with("expert_consultation_types","work_time")->first();

        return response()->json([
            "message"=>"Expert Found successfully",
            "data"=>$user,
        ],200);
    }

    private function time_cutter($from,$to,$duration,$expertConsultaions,$day){
        $res = [];
        while($to-$duration>=$from) {
            $is_taken=false;
            //logic for checking if the time is already taken
            foreach($expertConsultaions as $consult){
                if($consult->day==$day&&$consult->from==$from+$duration){
                    $is_taken=true;
                    break;
                }
            }
            if(!$is_taken){
            array_push($res,$from);
        }
        $from = $from+$duration;
        }
        return $res;
    }

    public function list_by_type($type)
    {
        $data=User::join('experts',"experts.expert_id","=","user_id")
        ->join('expert_consultation_types','expert_consultation_types.expert_id','experts.expert_id')
        ->join('consultation_types', 'consultation_types.consultation_type_id', '=', 'expert_consultation_types.consultation_type_id')->select('users.*','experts.*')
        ->where('type','like',$type)->get();
        return  response()->json([
            "data"=>$data
        ],200);
    }
    public function index()
    {
        $data=Expert::join('users',"users.user_id","=","expert_id")->with("expert_consultation_types")->filter(request(['type','search']))->get();
        return response()->json([
            "data"=>$data
        ],200);
    }
    public function list_free($id) {
        $expert=Expert::where("expert_id","=",$id)->first();
        if(!isset($expert)){
            return response()->json([
                "status"=>false,
                "message"=>"invaild Id"
            ],404);
        }
        if( !isset($expert->duration)){
            return response()->json([
                "status"=>false,
                "message"=>"you have to enter session duration first"
            ],404);
        }
        $expertWorkTime=Work_time::where("expert_id","=",$id)->get();

        $expertConsultaions=Consultation::where("expert_id","=",$expert->expert_id)->get();
        //every obejce will be a day of cutted times
        $sut = [];
        $sun = [];
        $mon = [];
        $tus = [];
        $wed = [];
        $ths = [];
        $fri = [];

        foreach($expertWorkTime as $workTimeItem) {
            switch($workTimeItem->day) {
                case 1:
                    array_push($sut,$this->time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,1,));
                    break;
                case 2:
                    array_push($sun,$this->time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,2));
                    break;
                case 3:
                    array_push($mon,$this->time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,3));
                    break;
                case 4:
                    array_push($tus,$this->time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,4));
                    break;
                case 5:
                    array_push($wed,$this->time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,5));
                    break;
                case 6:
                    array_push($ths,$this->time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,6));
                    break;
                case 7:
                    array_push($fri,$this->time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,7));
                    break;
            }
        }
        return response()->json([
            "sut"=>$sut,
            "sun"=>$sun,
            "mon"=>$mon,
            "tus"=>$tus,
            "wed"=>$wed,
            "ths"=>$ths,
            "fri"=>$fri
        ],200);
    }

}
