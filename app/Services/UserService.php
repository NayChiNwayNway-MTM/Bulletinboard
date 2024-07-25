<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    //for userlist
    public function getUsers($userType, $pageSize, $authUserId)
    {
        if ($userType == 0) {
            return User::getUsersWithCreators($pageSize);
        } else {
            return User::getUsersCreatedByAuthUser($pageSize, $authUserId);
        }
    }
    //for userlist card
    public function getUsersCard($pageSize){
      if(auth()->user()->type == 0){
        return User::getUserswithCreatorsCard($pageSize);
      }
      else{
        return User::getUsersCreatedByAuthUserCard($pageSize);
      }
    }
    //for registraion
    public function registration($request,$imagePath){
      return User::registration($request,$imagePath);
    }
    //for saveRegister
    public function saveRegister($request,$type){
      return User::saveRegister($request,$type);
    }
    //for update_profile
    public function update_profile($request,$id,$type){
      if(auth()->user()->type == 0){
        return User::update_profile_admin($request,$id,$type);
      }
      else{
        return User::update_profile_user($request,$id);
      }
    }
    //for submitforgetpassword
    public function submitforgetpassword($request){
      return User::submitforgetpassword($request);
    }
    //for submit_reset_password
    public function submit_reset_password($request){
      return User::submit_reset_password($request);
    }
    //for changed_password
    public function changed_password($request){
      return User::changed_password($request);
    }
}
