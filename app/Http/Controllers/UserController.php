<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Services\UserService;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //userlist 
    public function userlist(Request $request)
    {
        $pageSize = $request->input('page_size', 10);
        session(['pageSize' => $pageSize]);

        if ($request->has('page_size')) {
            session(['page_size' => $pageSize]);
        }

        $userType = auth()->user()->type;
        $authUserId = auth()->user()->id;

        $data = $this->userService->getUsers($userType, $pageSize, $authUserId);

        return view('user.index', [
            'users' => $data['users'],
            'names' => $data['names'],
            'pageSize' => $pageSize
        ]);
    }
    //user list for card
    public function cardView(Request $request){
        $pageSize = $request->input('page_size', 9);
        session(['pageSize'=>$pageSize]);

       // dd($pageSize);

        if ($request->has('page_size')) {
            session(['page_size' => $request->input('page_size')]);
        }

        $data = $this->userService->getUsersCard($pageSize);
        return view('user.user_card_view',[
            'users'=>$data['users'],
            'names'=>$data['names'],
            'pageSize'=>$pageSize
        ]);
    }
    //user register ui
    public function register(){
        return view('user.register');
    }
    //register validate and go confrim page
    public function registration(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirmpass' => 'required|same:password',
            'profile' => 'required|image|mimes:jpeg,jpg,png,svg|max:2048'
        ], [
            'name.required' => 'Name can\'t be blank.',
            'email.required' => 'Email can\'t be blank.',
            'profile.required' => 'Profile can\'t be blank.',
            'password.min'=>'Password at least six characer.',
            'confirmpass.same' => 'Confirm Password must Same Password.',
        ]);

        // Save the type in session
        session(['type' => $request->input('type')]);

        
        // Handle the image upload
        $imageName = time() . '.' . $request->profile->extension();
        $request->profile->move(public_path('uploads'), $imageName);
        $imagePath = 'uploads/' . $imageName;
        session(['image' => $imagePath]);
        
        $result=$this->userService->registration($request,$imagePath);
        
        if(isset($result['error'])){
            return redirect()->back()->withInput()->with(['error'=>$result['error']]);
        }
        if(isset($result['nameerror'])){
            return redirect()->back()->withInput()->with(['nameerror'=>$result['nameerror']]);
        }
      
        return view('user.confirm_register',
        ['users'=>$request,
        'imagePath'=>$imagePath]);
        
    }

    //register save to database
    public function saveregister(Request $request)
    {
        // Validate the input
        session(['type' => $request->input('type')]);
        $type =session('type');
        //dd(session('type'));
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirmpass' => 'required|same:password',
        ], [
            'name.required' => 'Name can\'t be blank.',
            'email.required' => 'Email can\'t be blank.',
        ]);

        $result = $this->userService->saveRegister($request,$type);
       if(isset($result['error'])){
        return redirect()->back()->with(['error'=>$result['error']]);
       }
       if(isset($result['nameerror'])){
        return redirect()->back()->with(['nameerror'=>$request['nameerror']]);
       }
       
       return view('user.register'); 
      
    }
    //show profile info
    public function profile($id){
        $user_data=User::find($id);
        return view('user.show_profile',compact('user_data'));
    }
    //show edit profile ui
    public function editprofile($id){
       $user=User::find($id);
        return view('user.edit_profile',compact('user'));
    }
    //update profile validation and store database
    public function update_profile(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'email'=>'required' ,
                  
        ],[
            'name.required'=>'Name can\'t blank.',
            'email.reqied'=>'Email can\'t blank.'
        ]);
        $type=$request->input('type');
        $result=$this->userService->update_profile($request,$id,$type);
        return redirect()->route('profile',['id'=>$result['id']]);
    }
    //forget password ui
    public function showforgetpassword(){
       
        return view('user.forget_password');
    }
    //reset pass and store token to database
    public function submitforgetpassword(Request $request){
        $request->validate([
            'email'=>'required|email'
        ]);
        $result = $this->userService->submitforgetpassword($request);
      if(isset($result['reset_pass'])){
        return redirect()->route('login')->with(['reset_pass'=>$result['reset_pass']]);
      }
       if(isset($result['error'])){
        return redirect()->route('forget.password.get')->with(['error'=>$result['error']]);
       }
       
    }
    //reset password ui
    public function reset_password(Request $request,$token){
        $user_token=$token;
        $email = $request->query('email');
        //dd($email);
        return view('user.reset_password',compact('user_token','email'));

        //TDO::get id ,check validation,and save to database
        //
    }
    //reset password and store new password
    public function submit_reset_password(Request $request){
       // dd($request->email);
        $request->validate([
            'password'=>'required',
            'password_confirm'=>'required'
        ]);
        $result =$this->userService->submit_reset_password($request);
    
        if(isset($result['error'])){
            return redirect()->route('login')->with('error',$result['error']);
        }
      
        return redirect('/login')->with('message', $result['message']);
    }
    //change password ui
    public function change_password(){
        return view('user.change_password');
    }
    //change password and new password is store database
    public function changed_password(Request $request){
        $request->validate([
            'cur_pass'=>'required',
            'new_pass'=>'required|min:6',
            'con_new_pass'=>'required|same:new_pass'
        ],
        [
           'cur_pass.required'=>'Current Password can\'t be blank.' ,
           'new_pass.required'=>'New Password can\'t be blank.',
           'con_new_pass.required'=>'Confirm New Password can\'t be blank.',
           'new_pass.min' => 'New Password must be at least 6 characters.',
            'con_new_pass.same' => 'New Password and Confirm New Password must match.',
        ]);
        $result = $this->userService->changed_password($request);
        
        if(isset($result['success'])){

            return redirect()->route('user')->with('success', $result['success']);
        }
        if(isset($result['error'])){
           
            return redirect()->route('changepassword')->with('error', $result['error']);
            dd($result);
        }
    }


    
}
