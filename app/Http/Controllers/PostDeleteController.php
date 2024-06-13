<?php

namespace App\Http\Controllers;

use App\Models\PostList;
use Illuminate\Http\Request;

class PostDeleteController extends Controller
{
    //
    public function approve($id){
        $postid=PostList::find($id);
        if($postid){
            return response()->json(['success'=>true,'post'=>$postid]);
        }       
    }
    public function destroy($id){    
        $post = PostList::find($id);       
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }       
        $post->delete();       
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
   
}
