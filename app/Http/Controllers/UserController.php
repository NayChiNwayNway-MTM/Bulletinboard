<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    //userlist
    public function userlist(){
        return view('user.index');
    }
    //user signup
    public function signup(){
        return view('user.create_account');
    }
    //user when signup create account and chek validation
    public function create(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:6',
            'confirm-password'=>'required|same:password'
        ],
        [
            'name.required'=>'Name can\'t be blank',
            'email.required'=>'Email can\'t be blank',
            'password.required'=>'Password can\'t be blank'
            
        ]);
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        return redirect()->route('postlist');
    }
    //user login
    public function login(){
        return view('user.login');
    }
    //user register
    public function register(){
        return view('user.register');
    }
    //register validate and go confrim page
    public function registration(Request $request){
       // dd($request->profile);
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:6',
            'confirmpass'=>'required|same:password',
            'profile'=>'required|image|mimes:jpeg,jpg,png,svg|max:2048'
        ],
        [
            'name.required'=>'Name can\'t blank',
            'email.required'=>'Email can\'t blank',
            'profile.required'=>'Profile can\'t blank'
        ]);
        $users=$request;
        $imageName=time().'.'.$request->profile->extension();
        $success=$request->profile->move(public_path('uploads'),$imageName);
        $imagePath = 'uploads/' . $imageName;
        if($success){
            return view('user.confirm_register',compact('users','imagePath'));
        }
        
    }
    //show profile info
    public function profile(){
        return view('user.show_profile');
    }
    //show edit profile ui
    public function editprofile(){
        return view('user.edit_profile');
    }
    //update profile validation and store database

    //forget password ui
    public function forgetpassword(){
        return view('user.forget_password');
    }
    //reset pass and store database
    public function resetpassword(Request $request){
        $request->validate([
            'email'=>'required|email'
        ]);
        //TDO::sent email verification code
        //TDO::get id
        return view('user.update_password');
    }
    //update password and save to database
    public function update_password(){
        dd("ada");
        //TDO::get id ,check validation,and save to database
        //
    }


    
}
