<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostList;
class PostListController extends Controller
{
    //
    public function postlist(){
        $postlist= PostList::Paginate(5);
        //dd($postlist);
        return view('post.postlist',compact('postlist'));
    }
    public function createpost(){
        return view('post.create_post');
    }
    //post create
    public function create(Request $request){
        $request->validate(
            [
            'title'=>'required',
            'description'=>'required|max:255'

            ],
            [
               'title.required'=>'Title can\'t be blank',
               'description.required'=>'Description can\'t be balnk' 
            ]);
           // dd($request->title);
           $title = $request->title;
           $des=$request->description;
           return view('post.post_confirm_create',compact('title','des'));
            
    }
    //post create store
    public function store(Request $request){
        $request->validate(
            [
            'title'=>'required',
            'description'=>'required|max:255'

            ],
            [
               'title.required'=>'Title can\'t be blank',
               'description.required'=>'Description can\'t be balnk' 
            ]);
           return view('post.create_post');
    }
    //post edit 
    public function edit($id){
       
        $post = PostList::find($id);
        //dd($post);
        return view('post.edit_post',compact('post'));
    }
    public function post_edit_confirm(Request $request,$id){
        //dd($request->title);
       // dd($request->id);
        $request->validate(
            [
            'title'=>'required',
            'description'=>'required|max:255'

            ],
            [
               'title.required'=>'Title can\'t be blank',
               'description.required'=>'Description can\'t be balnk' 
            ]);
            $post=$request;
           // $post_update=PostList::find($id);
            //$post_update->update($request->except('_token'));
            //return redirect()->route('postlist')->with('success','Edit post successfully');
            return view('post.post_edit_confirm',compact('post'));
        }
        public function update(Request $request,$id){
            echo "Dada";
        }
       
}
