<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\when;
use Illuminate\Support\Facades\Auth;

class UserDetailController extends Controller
{
    //
    public function showdetail($id){
        $user=User::find($id);
       
        $created=User::where('id',$user->created_user_id)->pluck('name');
        return response()->json(['detail'=>$user,'created_user'=>$created]);
    }
    //search user
    public function search_user(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $start_date = $request->from;
        $end_date = $request->to;
       // dd($name);
       $pageSize=session('pageSize');
        if (auth()->user()->type == 0) {
            $users = User::whereNull('deleted_at')
                         ->when($name, function ($query) use ($name) {
                             return $query->where('name', 'like', '%' . $name . '%');
                         })
                         ->when($email, function ($query) use ($email) {
                             return $query->where('email', 'like', '%' . $email . '%');
                         })
                         ->when($start_date, function ($query) use ($start_date) {
                             return $query->whereDate('created_at', '>=', $start_date);
                         })
                         ->when($end_date, function ($query) use ($end_date) {
                             return $query->whereDate('created_at', '<=', $end_date);
                         })
                         ->paginate($pageSize);
           
        } else {
            $users = User::where('created_user_id', Auth::id())
            ->whereNull('deleted_at')
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($email, function ($query) use ($email) {
                return $query->where('email', 'like', '%' . $email . '%');
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
           
            ->paginate($pageSize);

            }
        
            $created_user = User::whereNull('deleted_at')
             ->where('created_user_id', auth()->user()->id)
             ->with('createdBy') // Eager load the createdBy relationship
             ->paginate($pageSize);
            $names=[];
             foreach($users as $user){
               $names[$user->id]=$user->createdBy ?$user->createdBy->name : 'Unknown';
            }
             return view('user.index',compact('users'),compact('names','pageSize'));           
        }
        
       
    }
    



