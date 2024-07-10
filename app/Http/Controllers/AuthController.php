<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\type;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService=$authService;
    }
     //user signup
     public function signup(){
        return view('user.create_account');
    }
    //user when signup create account and chek validation
    public function create(Request $request){
        // Validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm-password' => 'required|same:password'
        ],
        [
            'name.required' => 'Name can\'t be blank.',
            'email.required' => 'Email can\'t be blank.',
            'password.required' => 'Password can\'t be blank.'
        ]);

        // Restore or update user if email exists and is soft-deleted
            $result=$this->authService->create($request);
           // dd($result);
           
               // dd($user->name);
                if(isset($result['data'])){
                    $user = $result['data'];
                    // Authenticate the updated user
                    auth()->login($user);
    
                    // Update created_user_id and updated_user_id with the authenticated user's ID
                    if (Auth::check()) {
                        $user->update([
                            'created_user_id' => Auth::user()->id,
                            'updated_user_id' => Auth::user()->id
                        ]);
                    }
 
                    return redirect()->route('postlist');
                }
                if(isset($result['existingEmail'])){
                    $existingEmail=$result['existingEmail'];
                    auth()->login($existingEmail);
                    if(Auth::check()){
                        $existingEmail->update([
                            'created_user_id' => Auth::user()->id,
                            'updated_user_id' => Auth::user()->id
                        ]);
                    }  
                    return redirect()->route('postlist');
                }
                if(isset($result['existingName'])){
                    $existingName=$result['existingName'];
                    auth()->login($existingName);
                    if(Auth::check()){
                        $existingName->update([
                            'created_user_id' => Auth::user()->id,
                            'updated_user_id' => Auth::user()->id
                        ]);
                    }
                    return redirect()->route('postlist');
                }
                $errors =$result['back'];
                if(isset($errors)){
                    return back()->withErrors($errors)->withInput();
                }
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
           return redirect()->to('login')->with('incorrect','Incorrect,Try again.')->withInput();
        }

    }
}
