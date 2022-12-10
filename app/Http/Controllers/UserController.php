<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
            //validation
            $validateUser=Validator::make($request->all(),
            [
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'photo'=>'image|mimes:jpg,png,jpeg,svg|max:2048',
                'isExpert'=>'boolean',
                'password'=>'required',
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
            'password'=>Hash::make($request->password),
            'isExpert'=>$request->isExpert
        ]);
        return response()->json([
            'status'=> true,
            'message'=>'user create successfully',
            'token'=>$user->createToken("API TOKEN")->plainTextToken,
            'user'=>$user,
        ],200);


}

//not working for now to mohamad

// public function login(Request $request)
// {
//     $user = User::where('email', $request->email)->first();

//     if (! $user || ! Hash::check($request->password, $user->password)) {
//         return response()->json([
//             'status'=> false,
//             'message'=>'error in credintails provided',

//         ],401);
//     }

//     return response()->json([
//         'status'=> true,
//         'message'=>'User login successfully.',
//         'token'=>$user->createToken('api')->plainTextToken
//     ],200);
// }




}
