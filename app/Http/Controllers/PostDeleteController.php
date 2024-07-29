<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Carbon\Carbon;
use App\Models\User;
use App\Services\PostDeleteService;
use Illuminate\Http\Request;
class PostDeleteController extends Controller
{   
        protected $postDeleteService;
        public function __construct(PostDeleteService $postDeleteService)
        {
            $this->postDeleteService=$postDeleteService;
        }
        public function delete($id){
            $result = $this->postDeleteService->delete($id);
            //dd($result);
            if(isset($result)){
                
                return response()->json(['success'=>true,'post'=>$result['post']]);
            }
                
        }
        //post destory
        public function destroy($id){  
             $result =$this->postDeleteService->destroy($id); 
             if(isset($result)){
                return response()->json(['message' => $result['message']]);
             }
           
        }
        //get post details
        public function postdetails($id){
            $result =$this->postDeleteService->postdetails($id);
            if(isset($result)){
                return response()->json(['postdetail'=>$result['postdetail'],'user'=>$result['user']]);
            }
           
        }

   
}
