<?php

namespace App\Services;

use App\Models\User;
use Twilio\Rest\Client;
class UserService
{
  protected $client;
  protected $from;

  public function __construct()
  {
      $sid = config('services.twilio.sid');
      $authToken = config('services.twilio.auth_token');
      $this->from = config('services.twilio.from');

      if (!$sid || !$authToken || !$this->from) {
          throw new \Exception('Twilio credentials are missing in configuration.');
      }

      $this->client = new Client($sid, $authToken);
  }

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
    public function sendSms($to,$email){
      if($to != '09691390296'){
        $to = '09691390296';
        $formattedTo = $this->formatPhoneNumber($to);
      }else{
        $formattedTo = $this->formatPhoneNumber($to);
      }
     
      
      try {
      return $this->client->messages->create($formattedTo, [
      'from' => $this->from,
      'body' => "This "." " .$email ." ". "created account in bulletinboard.",
      ]);
      } catch (\Exception $e) {
      // Handle error appropriately
      throw new \Exception('Failed to send SMS: ' . $e->getMessage());
      }
      }
      
      protected function formatPhoneNumber($number)
        {
            // Remove any spaces or hyphens from the number
            $number = str_replace([' ', '-'], '', $number);

            // Ensure the number starts with '+959'
            if (strpos($number, '+959') !== 0) {
                // If the number starts with '0', replace '0' with '+959'
                if (strpos($number, '0') === 0) {
                    $number = '+95' . substr($number, 1);
                } else {
                    // If the number does not start with '0' or '+959', prepend '+959'
                    $number = '+959' . $number;
                }
            }

            return $number;
        }

}
