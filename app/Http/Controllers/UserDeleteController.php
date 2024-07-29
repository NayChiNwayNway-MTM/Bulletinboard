<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Post;
use App\Services\UserDeleteService;
class UserDeleteController extends Controller
{
    //
    protected $userDeleteService;
    public function __construct(UserDeleteService $userDeleteService)
    {
        $this->userDeleteService=$userDeleteService;
    }
    public function delete($id){
        $result=$this->userDeleteService->deleteuser($id);
        if(isset($result)){
            return response()->json(['success'=>true,'userinfo'=>$result['userinfo']]);
        }
         
    }
    public function confirm($id){
        $result=$this->userDeleteService->confirm($id);
        if(isset($result)){
            return response()->json(['success'=>"User Successfully Deleted."]);
        }
       
    }
}
