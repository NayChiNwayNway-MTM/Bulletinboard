<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_user_id',
        'updated_user_id',
        'profile',
        'created_at',
        'updated_at',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany(Post::class.'created_user_id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_user_id');
    }
   //userlist with type is admin
    public static function getUsersWithCreators($pageSize)
    {
        // Get paginated users
        $users = self::whereNull('deleted_at')->paginate($pageSize);
        
        // Fetch the created users' names using a single query
        $createdUserIds = $users->pluck('created_user_id')->filter()->unique()->toArray();
        $createdUsers = self::whereIn('id', $createdUserIds)
                            ->whereNull('deleted_at')
                            ->pluck('name', 'id')
                            ->toArray();
        
        // Map names to the users' created_user_ids
        $names = [];
        foreach ($users as $user) {
            $names[$user->id] = $createdUsers[$user->created_user_id] ?? 'Unknown';
        }

        return ['users' => $users, 'names' => $names];
    }

    //userlist with type is user
    public static function getUsersCreatedByAuthUser($pageSize, $authUserId)
    {
        $users = self::whereNull('deleted_at')
                     ->where('created_user_id', $authUserId)
                     ->with('createdBy')
                     ->paginate($pageSize);

        // Initialize names array
        $names = [];

        // Collect names of creators
        foreach ($users as $user) {
            $names[$user->id] = $user->createdBy ? $user->createdBy->name : 'Unknown';
        }

        return ['users' => $users, 'names' => $names];
    }
    //userlist cardview for admin
    public static function getUserswithCreatorsCard($pageSize){
        $users = User::whereNull('deleted_at')->paginate($pageSize);
                
                // Fetch the created users' names using a single query
                $createdUserIds = $users->pluck('created_user_id')->filter()->unique()->toArray();
                
                $createdUsers = User::whereIn('id', $createdUserIds)
                                    ->whereNull('deleted_at')
                                    ->pluck('name', 'id')
                                    ->toArray();
            
                // Map names to the users' created_user_ids
                $names = [];
                foreach ($users as $user) {
                    $names[$user->id] = $createdUsers[$user->created_user_id] ?? 'Unknown';
                }
        return ['users'=>$users,'names'=>$names];
    }
    //userlist cardview for user
    public static function getUsersCreatedByAuthUserCard($pageSize){
        $users = User::whereNull('deleted_at')
        ->where('created_user_id', auth()->user()->id)
        ->with('createdBy')
        ->paginate($pageSize);

            // Initialize names array
            $names = [];

            // Collect names of creators
            foreach ($users as $user) {
                $names[$user->id] = $user->createdBy ? $user->createdBy->name : 'Unknown';
            }
        return ['users'=>$users,'names'=>$names];
    }
    //for registration
    public static function registration($request,$imagePath){
        // Check for existing email and name
        $existingEmail = User::withTrashed()->where('email', $request->email)->first();
        $existingName = User::withTrashed()->where('name', $request->name)->first();
        // If email or name already exists and is not deleted
        if ($existingEmail && !$existingEmail->deleted_at) {
            return ['error' => 'The email already exists.'];
        }

        if ($existingName && !$existingName->deleted_at) {
            return ['nameerror' => 'The name already exists.'];
        }

        // If email or name exists and is soft-deleted
        if (($existingEmail && $existingEmail->deleted_at) || ($existingName && $existingName->deleted_at)) {
            return ['imagePath'=>$imagePath];
        }

        
    }
    //for saveRegister
    public static function saveRegister($request,$type){
         // Retrieve session data
         $imagePath = session('image');
         //$type = session('type');
        // dd($type);
         $typeValue = ($type === 'user') ? 1 : 0;
        //dd($typeValue);
       // $typeValue=0;
        //dd($typeValue);
         // Check for existing email and name, including soft-deleted users
         $existingEmail = User::withTrashed()->where('email', $request->email)->first();
         $existingName = User::withTrashed()->where('name', $request->name)->first();
         
         // Restore or update user if email exists and is soft-deleted
         if ($existingEmail) {
             if ($existingEmail->deleted_at) {
                 $existingEmail->restore();
                 $existingEmail->update([
                     'name' => $request->name,
                     'email' => $request->email,
                     'password' => Hash::make($request->password),
                     'profile' => $imagePath,
                     'type' => $typeValue,
                     'phone' => $request->phone,
                     'address' => $request->address,
                     'dob' => $request->dob,
                     'created_at'=>Carbon::now(),
                     'updated_at'=>Carbon::now(),
                     'created_user_id' => auth()->user()->id,
                     'updated_user_id' => auth()->user()->id,
                 ]);
                 
                 Session::flash('register', 'Registered successfully.');
                 //return redirect()->route('user.register');
                 return ['back'];
             }
             return ['error' => 'The email already exists.'];
         }
 
         // Restore or update user if name exists and is soft-deleted
         if ($existingName) {
             if ($existingName->deleted_at) {
                 $existingName->restore();
                 $existingName->update([
                     'name' => $request->name,
                     'email' => $request->email,
                     'password' => Hash::make($request->password),
                     'profile' => $imagePath,
                     'type' => $typeValue,
                     'phone' => $request->phone,
                     'address' => $request->address,
                     'dob' => $request->dob,
                     'created_at'=>Carbon::now(),
                     'updated_at'=>Carbon::now(),
                     'created_user_id' => auth()->user()->id,
                     'updated_user_id' => auth()->user()->id,
                 ]);
                
                 Session::flash('register', 'Registered successfully.');
                 //return redirect()->route('user.register'); 
                 return ['back'];
             }
             return ['nameerror' => 'The name already exists.'];
         }
 
         // Create a new user if no existing user is found
         User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'profile' => $imagePath,
             'type' => $typeValue,
             'phone' => $request->phone,
             'address' => $request->address,
             'dob' => $request->dob,
             'created_at'=>Carbon::now(),
             'updated_at'=>Carbon::now(),
             'created_user_id' => auth()->user()->id,
             'updated_user_id' => auth()->user()->id,
         ]);
        // dd($typeValue);
         Session::flash('register', 'Registered successfully.');
         //return redirect()->route('user.register'); 
         return ['back'];
    }
    //for update_profile_admin
    public static function update_profile_admin($request,$id,$type){
        
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
        return ['id' => $id];
    }
    //for update_profile_user
    public static function update_profile_user($request,$id){
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
            return ['id' => $id];
    }
    //for submitforgetpassword
    public static function submitforgetpassword($request){
          
        $user=User::where('email',$request->email)->first();
        if (!$user) {
            // Handle case where user is not found
            return ['error' => 'User  email does not exist.'];
        }
        $userName=User::select('name')->where('email',$request->email)->first()->name;
        //dd($userName);
        if($user){
            $userEmail=$request->email;
            $token = Str::random(64);
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
           // dd($userEmail);
          
           $data = [
           'token'=>$token,
           'email' => $request->email,
            'name'=>$userName,
           ];
         Mail::to($userEmail)->send(new SendMail($data));
          // dd($bladeurl);
            //return view('user.reset_password');
            return ['reset_pass'=>'Email sent with password reset instructions.'];
        }
        else{
            return ['error'=>'Email does not exist.'];
        }
    }
    //for submit_reset_password
    public static function submit_reset_password($request){
        $check_token =DB::table('password_reset_tokens')
                    ->where([
                        'email'=>$request->email,
                        'token'=>$request->token,
                    ])->first();
        if(!$check_token){
            return ['error'=>'Invalid Token'];
        }
        User::where('email',$request->email)
            ->update([
                'password'=>Hash::make($request->password),
                'updated_at'=>Carbon::now()
            ]);
        DB::table('password_reset_tokens')->where('email',$request->email)->delete();
        return ['message'=>'Your password has been changed!'];
    }
    //for changed_password
    public static function changed_password($request){
        $current_pass=$request->cur_pass;
       $new_password=$request->new_pass;
       $confirm_pass=$request->con_new_pass;

       $user = User::find(auth()->user()->id);
       $hashedPassword = $user->password;
       if (Hash::check($current_pass, $hashedPassword)) {
            if ($new_password === $confirm_pass) {

                $user->password = Hash::make($new_password);
                $user->save();

                return ['success'=>'Password updated successfully.'];
            } else {
                return ['error' => 'New passwords do not match.'];
            }
        } else {
        
            return ['error' => 'Current password is incorrect.'];
        }

    }
}

