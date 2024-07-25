<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserDetailService;
use App\Http\Controllers\when;
use Illuminate\Support\Facades\Auth;

class UserDetailController extends Controller
{
    //
    protected $userDetailService;
    public function __construct(UserDetailService $userDetailService)
    {
        $this->userDetailService=$userDetailService;
    }
    public function showdetail($id){
        $result = $this->userDetailService->showdetail($id);
        if(isset($result)){
            return response()->json(['detail'=>$result['detail'],'created_user'=>$result['created_user']]);
        }
    }
    //search user for table
    public function search_user(Request $request) {
        $pageSize=session('pageSize');
        $result = $this->userDetailService->search_user($request);
       $users = $result['users'];
            $names=[];
             foreach( $users as $user){
               $names[$user->id]=$user->createdBy ?$user->createdBy->name : 'Unknown';
            }
             return view('user.index',compact('users'),compact('names','pageSize'));           
    }
        
          //search user for table
    public function search_card(Request $request) {
        $result = $this->userDetailService->search_card($request);
        $name = $request->name;
        $email = $request->email;
        $start_date = $request->from;
       // $start_date = explode(' ', $request->from)[0];
        //dd($start_date);
        $end_date = $request->to;
       // dd($name);
       $pageSize=session('pageSize');
        $users=$result['users'];
            $names=[];
             foreach($users as $user){
               $names[$user->id]=$user->createdBy ?$user->createdBy->name : 'Unknown';
            }
             return view('user.user_card_view',compact('users'),compact('names','pageSize'));           
    }
}
    
    



