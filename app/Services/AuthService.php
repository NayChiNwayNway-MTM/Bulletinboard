<?php
namespace App\Services;
use App\Models\User;
class AuthService{

  public function create($request){
    return User::create($request);
  }
  
}
?>