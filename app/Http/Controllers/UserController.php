<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator ;
use Throwable;

class UserController extends Controller
{
    /**
     * create User
     * @param Request $request
     * @return  User
     */
    public function create(Request $request)
    {
        try{

            //validation
            $validateUser=Validator::make($request->all(),
            [
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'photo'=>'image|mimes:jpg,png,jpeg,svg|max:2048',
                'password'=>'required'
            ]
        );
        if($validateUser->fails()){
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
            'password'=>Hash::make($request->password)
        ]);
        return response()->json([
            'status'=> true,
            'message'=>'user create successfully',
            'token'=>$user->createToken("API TOKEN")->plainTextToken
        ],200);

        }catch(Throwable $th){
            return response()->json([
                'status'=> false,
                'message'=>$th->getMessage(),
            ],500);
        }
}

//not working for now

// public function login(Request $request)
// {
//     $request->validate([
//         'email'=>'required|email',
//         'password'=>'required'
//     ]);

// //check user
// $user=User::where("email",$request->email)->first();
// if(!isset($user)){
//     $user=Expert::where("email",$request->email)->first();
// }
// if(isset($user)){
//     if(Hash::check($request->password,$user->password)){
//       $userToken=$user->createToken("API TOKEN")->plainTextToken;
// return response()->json([
//         "status"=>1,
//         "message"=>"user Logged In",
//         'token'=>$userToken
//     ],200);
//     }
//     else{
//         return response()->json([
//             "status"=>0,
//             "message"=>"Password doesn't match"
//         ],404);
//     }
// }
// else{
//     return response()->json([
//         "status"=>0,
//         "message"=>"user not found"
//     ],404);
// }
// }
}
