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
    public function delete($id){
        PostList::destroy($id);
        return redirect()->route('postlist');
    }
}
