<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserDeleteController extends Controller
{
    //
    public function delete($id){
        $userinfo=User::find($id);
        if($userinfo){
            return response()->json(['success'=>true,'userinfo'=>$userinfo]);
        }
        else{
            return("Hello");
        }      
    }
    public function confirm($id){
        User::where('id',$id)->update(['deleted_at'=>Carbon::now(),'deleted_user_id'=>auth()->user()->id]);
       // $user_delete->delete();
        return response()->json(['success'=>"User Successfully Deleted."]);
    }
}
