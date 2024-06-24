<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserDetailController extends Controller
{
    //
    public function showdetail($id){
        $user=User::find($id);
       
        $created=User::where('id',$user->created_user_id)->pluck('name');
        return response()->json(['detail'=>$user,'created_user'=>$created]);
    }
}
