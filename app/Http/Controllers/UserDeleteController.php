<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        $user_delete=User::find($id);
        $user_delete->delete();
        return response()->json(['success'=>"User Successfully Deleted."]);
    }
}
