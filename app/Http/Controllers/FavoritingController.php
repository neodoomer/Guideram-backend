<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\Favoriting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FavoritingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addToFavourite(request $request,$id)
    {
        $expert=Expert::where("expert_id",$id)->first();
        $user=Auth()->user();
   
        if(!isset($expert)){
           return response()->json(["message" => "Invalid Expert ID"],404);
        }
        if($expert->expert_id==$user->id)
         return response()->json(["message" => "You Can't Add yourself to the Favourites"],404);
        Favoriting::create([
            "expert_id" => $expert->expert_id,
             "user_id" => $user->id
        ]);
        return response()->json([
            "message"=>"Added to favorites successfully",
         ],200);
    }
}
