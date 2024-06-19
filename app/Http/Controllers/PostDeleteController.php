<?php

namespace App\Http\Controllers;

use App\Models\PostList;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class PostDeleteController extends Controller
{
    
        public function delete($id){
            $postid=PostList::find($id);
            if($postid){
                return response()->json(['success'=>true,'post'=>$postid]);
            }       
        }
        //post destory
        public function destroy($id){    
            $post = PostList::find($id);       
            if (!$post) {
                return response()->json(['message' => 'Post not found'], 404);
            }        
        PostList::where('id',$id)->update(['deleted_at'=>Carbon::now(),'deleted_user_id'=>auth()->user()->id]);
            return response()->json(['message' => 'Post deleted successfully'], 200);
        }
        //post search
        public function search($text) {
            if(auth()->user()->type == 1){
                $posts = PostList::where('title', 'like', '%'.$text.'%')
                            ->where('created_user_id',auth()->user()->id)
                            ->orWhere('description', 'like', '%'.$text.'%')
                            ->whereNull('deleted_at')
                            ->where('created_user_id',auth()->user()->id)
                            ->paginate(5);

                return response()->json([
                    
                    'posts' => $posts->items(), 
                    'pagination' => (string) $posts->appends(['text' => $text])->links('pagination::bootstrap-4')
                ]); 
            }
            else{
                $posts = PostList::where('title', 'like', '%'.$text.'%')
                                ->orWhere('description', 'like', '%'.$text.'%')
                                ->whereNull('deleted_at') 
                                ->paginate(5);
                
                return response()->json([
                                
                    'posts' => $posts->items(), 
                    'pagination' => (string) $posts->appends(['text' => $text])->links('pagination::bootstrap-4')

                 ]);
            }
        }
        //get post details
        public function postdetails($id){
            $postdetail=PostList::find($id);
            $postcreated=PostList::where('id',$id)->pluck('created_user_id');
            $user=User::where('id',$postcreated)->pluck('name');
            
            return response()->json(['postdetail'=>$postdetail,'user'=>$user]);
        }

   
}
