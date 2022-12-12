<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\BinaryOp\Equal;
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
        'expert_id'=>$user->user_id,
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
