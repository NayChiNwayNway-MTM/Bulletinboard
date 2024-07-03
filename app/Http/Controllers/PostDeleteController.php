<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
class PostDeleteController extends Controller
{   
        public function delete($id){
            $postid=Post::find($id);
            if($postid){
                return response()->json(['success'=>true,'post'=>$postid]);
            }       
        }
        //post destory
        public function destroy($id){    
            $post = Post::find($id);       
            if (!$post) {
                return response()->json(['message' => 'Post not found'], 404);
         }        
       
        $post->delete();
            return response()->json(['message' => 'Post deleted successfully'], 200);
        }
        //get post details
        public function postdetails($id){
            $postdetail=Post::find($id);
            $postcreated=Post::where('id',$id)->pluck('created_user_id');
            $user=User::where('id',$postcreated)->pluck('name');
            session(['user'=>$user]);
            return response()->json(['postdetail'=>$postdetail,'user'=>$user]);
        }

   
}
