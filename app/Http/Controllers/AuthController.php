<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    
     //user signup
     public function signup(){
        return view('user.create_account');
    }
    //user when signup create account and chek validation
    public function create(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
            'confirm-password'=>'required|same:password'
        ],
        [
            'name.required'=>'Name can\'t be blank',
            'email.required'=>'Email can\'t be blank',
            'password.required'=>'Password can\'t be blank'
            
        ]);
       //dd(auth()->user()->name);
       $data = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'created_user_id'=>auth()->user()->id
       
        ]);
        auth()->login($data);
        //dd(auth()->user()->name);
       return redirect()->route('postlist');
    }
   
     //user login ui
     public function loginForm(){
        return view('user.login');
    }
    //user logout
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
       $credential=$request->except('_token');
        if (Auth::attempt($credential)) {
            return redirect()->route('postlist');
        } else {
           return redirect()->to('login');
        }

    }
}
