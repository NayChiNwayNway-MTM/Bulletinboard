<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //userlist
    public function userlist(){
        $created_user=User::find(auth()->user()->created_user_id);
        $all_users=User::select('id', 'name')->get();
        $created_all_user_id=User::select('created_user_id')->get();
        $users=User::Paginate(5);
        $created_all_user_id = User::pluck('created_user_id')->toArray();
        $names = [];
        foreach ($created_all_user_id as $index => $created_user_id) {
            $user = User::select('name')->where('id', $created_user_id)->first();
            $names[$index] = $user ? $user->name : 'Unknown';
        }
        return view('user.index',compact('users'),compact('created_all_user_id','names'));
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
    //change password ui
    public function change_password(){
        return view('user.change_password');
    }
    //change password and new password is store database
    public function changed_password(Request $request){
        $request->validate([
            'cur-pass'=>'required',
            'new-pass'=>'required|min:6|confirmed',
            'new-con-pass'=>'required|min:6|confirmed'
        ],
        [
           'cur-pass.required'=>'Current Password can\'t be blank' ,
           'new-pass.required'=>'New Password can\'t be blank',
           'new-con-pass.required'=>'Confirm New Password can\'t be blank',
           'new-pass.min' => 'New Password must be at least 6 characters.',
            'new-con-pass.confirmed' => 'New Password and Confirm New Password must match.',
        ]);
        
        //TDO::check cur-pass is locate in database and true store database

    }


    
}
