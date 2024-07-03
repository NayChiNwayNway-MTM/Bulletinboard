<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\type;

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
            'name.required'=>'Name can\'t be blank.',
            'email.required'=>'Email can\'t be blank.',
            'password.required'=>'Password can\'t be blank.'
           
        ]);
       
       $data = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'created_user_id'=>1,
            'updated_user_id'=>1,      
        ]);
        //dd($request->id);
        auth()->login($data);
        //dd(auth()->user()->id);
        if (Auth::check()) {
            $data->update(['created_user_id' => Auth::user()->id,
                            'updated_user_id'=>Auth::user()->id]);
        }
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
    //user login
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
       $credential=$request->except('_token');
        if (Auth::attempt($credential)) {
            if(auth()->user()->type == 0){
                return redirect()->route('all_postlist'); 
            }
            else{
                return redirect()->route('postlist');
            }
                         
        } else {
           return redirect()->to('login')->with('incorrect','Incorrect,Try again.');
        }

    }
}
