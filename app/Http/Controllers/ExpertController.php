<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Expert;
use App\Models\Work_time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ExpertController extends Controller
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
            'experience'=>"required"
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
    $photoPath=$request->file('photo')?$request->file('photo')->store('public/images'):null;
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
    ],200);
    }




    public function update(Request $request,$id){
        if(!isset($request->cost)&&!isset($request->duration)&&!isset($request->from)&&!isset($request->to)&&!isset($request->day))
        {
            return response()->json([
                "status"=>true,
                "message"=>"invalid input "
            ],404);
        }
        $expert=Expert::where("expert_id","=",$id)->first();
        if(!isset($expert)){
            return response()->json([
                "status"=>false,
                "message"=>"wronge Id"
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
            $worktimesForUser=Work_time::where("expert_id","=",$id)->get();

            //check if the time crossed or reapeted
             foreach($worktimesForUser as $time){
                if($request->day==$time->day){
                    if(($request->from-$time->from >=0&&$request->to-$time->to <=0)||($request->from-$time->from <=0&&$request->to-$time->to >=0)){
                        return response()->json([
                            "status"=>false,
                            "message"=>"The Time Is Crossed With Another One Or Repeated"
                        ],404);
                    }
                    }
             }
            $worktime=Work_time::create([
                'day'=>$request->day,
                'to'=>$request->to,
                'from'=>$request->from ,'expert_id'=>$expert->expert_id
            ]);
            $expert->save();
        }
        return response()->json([
            "status"=>true,
            "message"=>'modified successfully',
            "worktimesForUser"=>$worktimesForUser],200);
    }







    public function get()
    {
        return DB::table('experts')
        ->join('users','user_id','=','expert_id')
        ->select('users.*','experts.*')
        ->where('user_id' , '=' ,request()->id)
        ->get();
    }
    public function index()
    {
        return Expert::filter(request(['type']))->get();
    }

}
