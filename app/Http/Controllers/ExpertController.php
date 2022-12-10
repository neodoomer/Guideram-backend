<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Http\Requests\StoreExpertRequest;
use App\Http\Requests\UpdateExpertRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ExpertController extends Controller
{
    public function create(Request $request)
    {

        $validateUser=Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'photo'=>'image|mimes:jpg,png,jpeg,svg|max:2048',
            'isExpert'=>'boolean',
            'password'=>'required',
            'address'=>'required',
            'phone'=>'required',
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
        'expert_id'=>$user->id,
        "phone"=>$request->phone,
        "address"=>$request->address,
    ]);
    return response()->json([
        'status'=> true,
        'message'=>'Expert create successfully',
        'token'=>$user->createToken("API TOKEN")->plainTextToken,
        //for testing
        'user'=>$user,
        'expert'=>$expert,
        //
    ],200);
    }

}
