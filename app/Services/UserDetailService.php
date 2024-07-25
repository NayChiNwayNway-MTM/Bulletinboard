<?php 
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class UserDetailService{
  public function showdetail($id){
    return User::showdetail($id);
  }
  public function search_user($request){
    $name = $request->name;
    $email = $request->email;
    $start_date = $request->from;
   // $start_date = explode(' ', $request->from)[0];
    //dd($start_date);
    $end_date = $request->to;
   // dd($name);
   $pageSize=session('pageSize');
    if (auth()->user()->type == 0) {
     return  User::search_user($name,$email,$start_date,$end_date,$pageSize);
    } else {
    return   User::search_user_admin($name,$email,$start_date,$end_date,$pageSize);
       

        }
    return User::getcreated_user($pageSize);
            
  }
  public function search_card($request){
    $name = $request->name;
    $email = $request->email;
    $start_date = $request->from;
   // $start_date = explode(' ', $request->from)[0];
    //dd($start_date);
    $end_date = $request->to;
   // dd($name);
   $pageSize=session('pageSize');
    if (auth()->user()->type == 0) {
      return User::search_card_user($name,$email,$start_date,$end_date,$pageSize);
        
       
    } else {
      return User::search_card_admin($name,$email,$start_date,$end_date,$pageSize);
       

        }
    return User::created_user($pageSize);
       
              
  }
}

?>