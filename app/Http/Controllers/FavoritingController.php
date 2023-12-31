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
    public function addToFavourite($id)
    {
        $expert = Expert::where("expert_id", $id)->first();
        $user = Auth()->user();

        if (!isset($expert)) {
            return response()->json(["message" => "Invalid Expert ID"], 404);
        }
        if ($expert->expert_id == $user->id)
            return response()->json(["message" => "You Can't Add yourself to the Favourites"], 404);
        $user->favoriting()->syncWithoutDetaching([
            $user->user_id =>
            [
                "expert_id" => $expert->expert_id
            ]
        ]);
        return response()->json([
            "message" => "Added to favorites successfully",
        ], 200);
    }

    public function is_favorite($id)
    {
        $expert = Expert::where("expert_id", $id)->first();
        $user = Auth()->user();

        if (!isset($expert)) {
            return response()->json(["message" => "Invalid Expert ID"], 404);
        }
        $fav = Favoriting::where("expert_id", $id)
            ->where("user_id", $user['user_id'])->first();

        if (isset($fav))
            return response()->json([
                "data" => true,
                "message" => "This Expert is in Your Favorite list <3"
            ], 200);
        return response()->json([
            "data" => false,
            "message" => "This Expert is not in Your Favorite list"
        ], 200);
    }
    public function favorite_list()
    {
        $user=Auth()->user();
        $data = Expert::join('users','experts.expert_id','users.user_id')
                        ->join('favoritings','favoritings.expert_id','experts.expert_id')
                        ->where('favoritings.user_id','=',$user['user_id'])
                        ->select('experts.*','users.*')
                        ->get();
        return response()->json([
            "data" => $data,
            "message" => "Success"
        ], 200);
    }
}
