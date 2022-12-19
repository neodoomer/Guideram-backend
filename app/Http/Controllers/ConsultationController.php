<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Expert;
use App\Models\Work_time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConsultationController extends Controller
{
    private function time_cutter($from,$to,$duration,$expertConsultaions,$day){
        $res = [];
        while($to-$duration>$from) {
            $is_taken=false;
            //logic for checking if the time is already taken
            foreach($expertConsultaions as $consult){
                if($consult->day==$day&&$consult->from==$from+$duration){
                    $is_taken=true;
                    break;
                }
            }
            $from = $from+$duration;
            if(!$is_taken){
            array_push($res,$from);
        }
        }
        return $res;
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
                "message"=>"you have to enter sesstion duration first"
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
                    array_push($sut,ConsultationController::time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,1,));
                    break;
                case 2:
                    array_push($sun,ConsultationController::time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,2));
                    break;
                case 3:
                    array_push($mon,ConsultationController::time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,3));
                    break;
                case 4:
                    array_push($tus,ConsultationController::time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,4));
                    break;
                case 5:
                    array_push($wed,ConsultationController::time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,5));
                    break;
                case 6:
                    array_push($ths,ConsultationController::time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,6));
                    break;
                case 7:
                    array_push($fri,ConsultationController::time_cutter($workTimeItem->from,$workTimeItem->to,$expert->duration,$expertConsultaions,7));
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

    public function booking($id,Request $request){
        $expert=Expert::where("expert_id","=",$id)->first();
        if(!isset($expert)){
        return response()->json(["message"=>"invalid Id"],404);
        }
        $user=auth()->user();
        $request->validate([
            "day"=>'required|integer|between:1,7',
            "from"=>'required|integer|between:1,23'
        ]);
        if($expert->expert_id==$user->user_id){
            return response()->json([
                "message"=>"you can't make reservaition on yourself"
            ],400);
        }
       $book= Consultation::create([
            "expert_id"=>$expert->expert_id,
            "user_id"=>$user->user_id,
            'day'=>$request->day,
            'from'=>$request->from
        ]);
        return response()->json([
            "message"=>"booking success",
            "book"=>$book
        ],200);
    }
    public function list_appointments($id){
        $consultations=Consultation::where("expert_id","=",$id)->get();
        return response()->json([
            "message"=>"list_appointments success",
            "data"=>$consultations
        ],200);
    }}

