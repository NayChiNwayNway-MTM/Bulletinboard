<?php

namespace App\Http\Controllers;

use App\Models\PostList;
use Illuminate\Http\Request;

class PostDeleteController extends Controller
{
    //
    public function delete($id){
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
    public function search($text){
        $post=PostList::paginate(5);

        $posts = PostList::where('title', 'like', '%'.$text.'%')
                     ->orWhere('description', 'like', '%'.$text.'%')
                     ->get();
        return response()->json(['posts'=>$posts,'post'=>$post]);
    }
   
}
