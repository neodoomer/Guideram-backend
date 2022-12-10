<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use function Symfony\Component\String\b;

class UserController extends Controller
{
    public function login()
    {
        $formField=request()->validate([
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6'
        ]);
        if(auth()->attempt($formField))
        {
            request()->session()->regenerate();

            return redirect('/home')->with('message','successfully logged in');
        }
        return back()->withErrors(['email'=>'invalid credentials'])->onlyInput('email');
    }
    public function register()
    {
        $formField=request()->validate([
            'is_expert' => 'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6',
            'name'=>'required'
        ]);
        $formField['password']=bcrypt($formField['password']);

        $user=User::create($formField);

        auth()->login($user);

        return redirect('/home')->with('message' , 'user registered and logged in');
        
    }
    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('message','user logged out');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
