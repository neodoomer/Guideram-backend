<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RatingController extends Controller
{
    public function create($id,Request $request){
        $request->validate([
            "rate"=>"required|integer|between:1,5"
        ]);
     $expert=Expert::where("expert_id",$id)->first();
     $user=Auth()->user();

     if(!isset($expert)){
        return response()->json(["message" => "Invalid Expert ID"],404);
     }
     if($expert->expert_id==$user->id)
         return response()->json(["message" => "You Can't rate yourself"],404);
     Rating::create([
        "expert_id" => $expert->expert_id,
        "user_id" => $user->id,
        "rate"=>$request->rate
     ]);
     //$expert->rate_count++;
     $expertRates=Rating::where("expert_id",$expert->expert_id)->get();
     $expert->rate=($expert->rate*$expert->rate_count + $request->rate)/++$expert->rate_count;
     $expert->save();
     return response()->json([
        "message"=>"rated successfully",
     ],200);
    }
}
