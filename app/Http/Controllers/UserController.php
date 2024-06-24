<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    //userlist
    public function userlist(){
        $created_user=User::find(auth()->user()->created_user_id);
        $all_users=User::select('id', 'name')->get()->whereNull('deleted_at');

        $created_all_user_id=User::select('created_user_id')->whereNull('deleted_at')->get();
        //dd($created_all_user_id);
        $users=User::whereNull('deleted_at')->Paginate(5);
        $created_all_user_id = User::whereNull('deleted_at')->pluck('created_user_id')->toArray();

        $names = [];
        foreach ($created_all_user_id as $index => $created_user_id) {
            $user = User::select('name')->where('id', $created_user_id)->whereNull('deleted_at')->first();
            //dd($users);
            $names[$index] = $user ? $user->name : 'Unknown';
        }
        return view('user.index',compact('users'),compact('created_all_user_id','names'));
    }
   
    //user register ui
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
        
        session(['type'=>$request->input('type')]);//get type admin or user

        $users=$request;
        $imageName=time().'.'.$request->profile->extension();
        $success=$request->profile->move(public_path('uploads'),$imageName);
        $imagePath = 'uploads/' . $imageName;
        session(['image'=>$imagePath]);
        $existingemail = User::withTrashed()
        ->where('email',$request->email)->first();
            if($existingemail){
                 if($existingemail->deleted_at){
                    return view('user.confirm_register',compact('users','imagePath'));
                }
                else{
                    return redirect()->back()->with(['error'=>'The email has already exist.']);
                }
            }
                    
            else{
               
                    return view('user.confirm_register',compact('users','imagePath'));
            }

    }
    //register save to database
    public function saveregister(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:6',
            'confirmpass'=>'required|same:password',           
        ],
        [
            'name.required'=>'Name can\'t blank',
            'email.required'=>'Email can\'t blank',          
        ]);
      $image_path = session('image');
      $type =session('type');
      if($type == 'user'){
        $type_value = 1;
      }
      else{
        $type_value =0;
      }
     
        $existingemail = User::withTrashed()
        ->where('email',$request->email)->first();
        
            if($existingemail){
                
                 if($existingemail->deleted_at){

                    $existingemail->restore();

                    $existingemail->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>$request->password,
                    'profile'=>$image_path,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'dob'=>$request->dob,
                    'created_user_id'=>auth()->user()->id,
                    'updated_user_id'=>auth()->user()->id,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now()

                   ]);
                   
                   Session::flash('register','Register Successfully');
                   return redirect()->back()->with(['register'=>'Register Successfully.']);
                   
                }
                else{
                    return redirect()->back()->with(['error'=>'The email has already exist.']);
                }
            }
                    
            else{
                if(auth()->user()->type == 0){
                    User::create([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'password'=>Hash::make($request->password),
                        'profile'=>$image_path,
                        'type'=>$type_value,                      
                        'phone'=>$request->phone,
                        'address'=>$request->address,
                        'dob'=>$request->dob,
                        'created_user_id'=>auth()->user()->id,
                        'updated_user_id'=>auth()->user()->id,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now()
                    ]);
                    Session::flash('register','Register Successfully');
                        return view('user.register');
                }
                else{
                    User::create([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'password'=>Hash::make($request->password),
                        'profile'=>$image_path,
                        'phone'=>$request->phone,
                        'address'=>$request->address,
                        'dob'=>$request->dob,
                        'created_user_id'=>auth()->user()->id,
                        'updated_user_id'=>auth()->user()->id,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now()
    
                       ]);
                       Session::flash('register','Register Successfully');
                        return view('user.register');
                }
                
            }

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
            'name.required'=>'Name can\'t blank',
            'email.reqied'=>'Email can\'t blank'
        ]);
       //check type admin
        if(auth()->user()->type == 0){
            $type=$request->input('type');
           
            if($type == 'user'){
                $type_value =1;
            }
            else{
                $type_value=0;

            }
            if($request->new_profile){
                $imageName=time().'.'.$request->new_profile->extension();
                $success=$request->new_profile->move(public_path('uploads'),$imageName);
                $imagePath = 'uploads/' . $imageName;
                User::where('id',$id)->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'dob'=>$request->dob,
                    'address'=>$request->address,
                    'type'=>$type_value,
                    'profile'=>$imagePath,
                    'updated_at'=>Carbon::now()
                ]);
            }
            else{
                User::where('id',$id)->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'dob'=>$request->dob,
                    'address'=>$request->address,
                    'type'=>$type_value,
                    'updated_at'=>Carbon::now()
                ]);
            }
            Session::flash('profileedited',"Edit Profile Successfully");
            return redirect()->route('profile',['id' => $id]);
        }
        else{
            if($request->new_profile){
                $imageName=time().'.'.$request->new_profile->extension();
                $success=$request->new_profile->move(public_path('uploads'),$imageName);
                $imagePath = 'uploads/' . $imageName;
                User::where('id',$id)->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'dob'=>$request->dob,
                    'address'=>$request->address,
                    'profile'=>$imagePath,
                    'updated_at'=>Carbon::now()
                ]);
            }
            else{
                User::where('id',$id)->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'dob'=>$request->dob,
                    'address'=>$request->address,
                    'updated_at'=>Carbon::now()
                ]);
            }
            Session::flash('profileedited',"Edit Profile Successfully");
            return redirect()->route('profile',['id' => $id]);
        }
       
        
    }
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
