<?php 
namespace App\Services;
use App\Models\User;
class UserDeleteService{

  public function deleteuser($id){
    return User::deleteuser($id);
  }
  public function confirm($id){
    return User::confirm($id);
  }
  
}
?>