<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Expert;
use App\Models\Work_time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConsultationController extends Controller
{
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
        if(!isset($expert->cost)){
            return response()->json([
                "message"=>"you can't make a free reservaition you have to add cost of the sesstion"
            ],400);
        }
        $expertUser=$expert->user;
        $expertUser->wallet+=$expert->cost;
        $user->wallet-=$expert->cost;
       $book= Consultation::create([
            "expert_id"=>$expert->expert_id,
            "user_id"=>$user->user_id,
            'day'=>$request->day,
            'from'=>$request->from
        ]);
        $expertUser->save();
        $user->save();

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

