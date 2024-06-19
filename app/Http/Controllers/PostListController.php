<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class PostListController extends Controller
{
    //
    
    public function postlist(){

    if(auth()->user()->type == 1){
        $postlist = PostList::where('created_user_id', auth()->user()->id )
                        ->whereNull('deleted_at')
                        ->paginate(5);
        $users = User::all();
        return view('post.postlist', compact('postlist', 'users'));
    }else{
        $postlist=PostList::whereNull('deleted_at')->paginate(5);
        $users = User::all();
        return view('post.postlist', compact('postlist', 'users'));
    }
    
    //$get_type =auth()->user()->type;
    //$postlist = PostList::where('created_user_id', auth()->user()->id )
    //                    ->whereNull('deleted_at')
    //                    ->paginate(5);
    //$users = User::all();
    //return view('post.postlist', compact('postlist', 'users','get_type','admin_post'));
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
        //TDO::store database
        PostList::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'created_user_id'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
            
        ]);
        //dd($data);
        Session::flash('postcreated', 'Post created successfully.');
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
        //post updated from database
        public function update(){
            //TDO::change updated data to database
        }
        //upload_post ui
        public function upload_post(){
            return view('post.upload_post');
        }
        //upload_post validation
        public function uploaded_post(Request $request){
            $request->validate([
                'csvfile'=>'required'
            ]);

        }
        //download_post ui
        public function download_post(){
            dd("adaf");
        }
       
}
