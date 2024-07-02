<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Exports\PostsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Facades\DB;
class PostListController extends Controller
{
    //
    
        public function postlist(Request $request){
            $pageSize = $request->input('page_size', 10);
            session(['pagesize'=>$pageSize]);
            
            if(Auth::check()){
                if(auth()->user()->type == 1){
                    $postlist = Post::where('created_user_id', auth()->user()->id )
                                    
                                    ->paginate($pageSize);
                    $users = User::all();
                   
                    return view('post.postlist', compact('postlist', 'users','pageSize'));
                }else{
                    
                    $postlist=Post::with('user')->paginate($pageSize);
                    $users = User::all();
                    return view('post.postlist', compact('postlist', 'users','pageSize'));
                }
            }
            else{
                $postlist=Post::where('status',1)->paginate($pageSize);
                $users = User::all();
                return view('post.postlist', compact('postlist', 'users','pageSize'));
               
            }
           

        }
        public function cardView(Request $request){
          
            $pageSize = $request->input('page_size', 10);
            session(['pagesize'=>$pageSize]);
            if(Auth::check()){
                if(auth()->user()->type == 1){
                    $postlist = Post::where('created_user_id', auth()->user()->id )
                                    
                                    ->paginate($pageSize);
                    $users = User::all();
                   
                    return view('post.postlist_card', compact('postlist', 'users','pageSize'));
                }else{
                    
                    $postlist=Post::with('user')->paginate($pageSize);
                    $users = User::all();
                    return view('post.postlist_card', compact('postlist', 'users','pageSize'));
                }
            }
            else{
                $postlist=Post::where('status',1)->paginate($pageSize);
                $users = User::all();
                return view('post.postlist_card', compact('postlist', 'users','pageSize'));
            }
    

        }
        public function createpost(){
            return view('post.create_post');
        }
        //post create
        public function create(Request $request){
            
            $request->validate(
                [
                'title'=>'required|unique:posts|max:255',
                'description'=>'required|max:255'

                ],
                [
                'title.required'=>'Title can\'t be blank.',
                'title.unique' => 'The title has already been taken.',
                'description.required'=>'Description can\'t be balnk.' ,
                'description.max' => 'Description must not exceed 255 characters.',
                ]);
            // dd($request->title);

            $title = $request->title;
            $valid_title=Post::where('title',$title);
            $des=$request->description;
            return view('post.post_confirm_create',compact('title','des'));
                
        }
        //post create store
        public function store(Request $request){
        $request->validate([
                'title' => 'required|unique:posts|max:255',
                'description' => 'required|max:255',
            ], [
                'title.required' => 'Title can\'t be blank.',
                'title.unique' => 'The title has already been taken.',
                'description.required' => 'Description can\'t be blank.',
                'description.max' => 'Description must not exceed 255 characters.',
            ]);       
            Post::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'created_user_id'=>Auth::user()->id,
                'updated_user_id'=>Auth::user()->id,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                
            ]);
            //dd($data);
            Session::flash('postcreated', 'Post created successfully.');
            return view('post.create_post');
        }
        
        //post edit 
        public function edit($id){
        
            $post = Post::find($id);
            //dd($post);
            return view('post.edit_post',compact('post'));
        }
        public function post_edit_confirm(Request $request,$id){
            $request->validate(
                [
                'title'=>'required',
                'description'=>'required|max:255'

                ],
                [
                'title.required'=>'Title can\'t be blank.',
                'description.required'=>'Description can\'t be balnk' ,
                'description.max' => 'Description must not exceed 255 characters.',
                ]);
                $status = $request->status ? 1 : 0;
            // dd($status);
                $post=$request;
                $unique=Post::where('title',$request->title)->where('id',$id)->first();
                if($unique){
                    return view('post.post_edit_confirm',compact('post','status'));
                }
                else{
                    Session::flash('error','The title has already been taken.');
                    return redirect()->route('postlist');
                }
            
        }
        //post updated from database
        public function update(Request $request ,$id){
           //dd($id);
            $title=$request->title;
            $des=$request->description;
            $status = $request->status ? 1 : 0;
            //dd($status);
            $unique=Post::where('title',$title)->where('id',$id)->first();
            //dd($unique);
            if($unique){
                $update =Post::where('id',$id)->update(['title'=>$title,
                'description'=>$des,
                'status'=>$status,
                'updated_user_id'=>auth()->user()->id,'updated_at'=>Carbon::now()]);
                Session::flash('postedites','Post Updated Successfully.');
                return redirect()->route('postlist');
            }
            else{
                Session::flash('error','Title already taken.');
                return redirect()->route('postlist');
            }
            
           
        }
        //upload_post ui
        public function upload_post(){
            return view('post.upload_post');
        }
        //upload_post validation
        public function uploaded_post(Request $request)
        {
            $request->validate([
                'csvfile' => 'required|file'
            ]);

            // Retrieve and process the uploaded file
            $file = $request->file('csvfile');
            $tempPath = sys_get_temp_dir().'/'.uniqid().'csv';

            
            $file_type= $request->file('csvfile')->getClientOriginalExtension();
            if($file_type !== 'csv'){
                return redirect()->back()->with('error', 'File must be csv type.')->withInput();
            }
           
            try {
                // Move the uploaded file to a temporary location
                $file->move(sys_get_temp_dir(), $tempPath);

                // Read the content of the file
                $csv = Reader::createFromPath($tempPath, 'r');
                $csv->setHeaderOffset(0);
                $records = $csv->getRecords();
              
                foreach ($records as $record) {
                          // Validate the CSV data structure
                          if (count($record) !== 3) {
                            DB::rollBack();
                            return redirect()->back()->with('error', 'Each row in the CSV must have exactly 3 columns.')->withInput();
                        }
                        $existingPost = Post::where('title', $record['title'])->first();
                        if ($existingPost) {
                            
                            return redirect()->back()->with('error','Post title already exists:'.$record['title'])->withInput();
                           
                        }
                }
                foreach ($records as $record) {
                            
                    if (count($record) !== 3) {
                        
                        return redirect()->back()->with('error', 'Each row in the CSV must have exactly 3 columns.')->withInput();
                    }
                    
                        // Create or update posts based on CSV data
                        Post::create([
                            'title' => $record['title'],
                            'description' => $record['description'],
                            'status' => $record['status'],
                            'created_user_id' => Auth::id(),
                            'updated_user_id' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                }
                 
                    return redirect()->route('postlist')->with('success', 'CSV data imported successfully.'); 

            }catch (\Exception $e) {
                return back()->withInput()->withErrors(['error' => $e->getMessage()]);
            } 
        }
        //post download with csv format
        public function export(Request $request)
        { 
            if(auth()->user()->type == 0){
                $text = $request->input('text', '');
              // dd($text);
               if($text == null){
                return Excel::download(new PostsExport, 'posts.csv', \Maatwebsite\Excel\Excel::CSV);
               }
               else{

                $posts = Post::where('title', 'like', '%'.$text.'%')
                                ->orWhere('description', 'like', '%'.$text.'%')
                                ->paginate(5);
                return new StreamedResponse(function () use ($posts) {
                         $handle = fopen('php://output', 'w');
                        fputcsv($handle, ['ID', 'Title', 'Description','Status','created_user_id',
                                            'updated_user_id','deleted_user_id','created_at','updated_at','deleted_at']);
                        foreach ($posts as $post) {
                             fputcsv($handle, [$post->id, $post->title, $post->description,
                                     $post->status,$post->created_user_id,$post->updated_user_id,$post->deleted_user_id,
                                    $post->created_at,$post->updated_at,$post->deleted_at]);
                        }
                            fclose($handle);
                        }, 200, [
                             'Content-Type' => 'text/csv',
                            'Content-Disposition' => 'attachment; filename="posts.csv"',
                        ]);                                            
               }
               
            }
            else{
               
                $text = $request->input('text', '');
                //dd($text);
                $posts = Post::where('title', 'like', '%'.$text.'%')
                        ->where('created_user_id',auth()->user()->id)
                        ->orWhere('description', 'like', '%'.$text.'%')
                        ->where('created_user_id',auth()->user()->id)
                        ->paginate(5);
        
                return new StreamedResponse(function () use ($posts) {
                    $handle = fopen('php://output', 'w');
                    fputcsv($handle, ['ID', 'Title', 'Description','Status','created_user_id',
                                    'updated_user_id','deleted_user_id','created_at','updated_at','deleted_at']);
                        foreach ($posts as $post) {
                            fputcsv($handle, [$post->id, $post->title, $post->description,
                                    $post->status,$post->created_user_id,$post->updated_user_id,$post->deleted_user_id,
                                    $post->created_at,$post->updated_at,$post->deleted_at]);
                        }
                    fclose($handle);
                }, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="posts.csv"',
                ]);
            }
            
        }
        //search post for table
        public function search(Request $request){
            $text = $request->text;

            $pageSize = $request->input('page_size', session('page_size', 10)); // Default to 10 if not set

            // Update session with the new page size if provided
            if ($request->has('page_size')) {
                session(['page_size' => $request->input('page_size')]);
            }
            if(auth()->user()->type == 1){
                $postlist = Post::where(function ($query) use ($text) {
                                $query->where('title', 'like', '%' . $text . '%')
                                      ->orWhere('description', 'like', '%' . $text . '%');
                            })
                            ->where('created_user_id', auth()->user()->id)
                            ->paginate($pageSize);
                           
            }
            
            else{
                $postlist = Post::where('title', 'like', '%'.$text.'%')
                                ->orWhere('description', 'like', '%'.$text.'%')
                                ->paginate($pageSize);
            }
            
            return view('post.postlist', compact('postlist', 'pageSize'));
        }
        //search psot for card
        public function search_card(Request $request){
            $text = $request->text;

            $pageSize = $request->input('page_size', session('page_size', 10)); // Default to 10 if not set

            // Update session with the new page size if provided
            if ($request->has('page_size')) {
                session(['page_size' => $request->input('page_size')]);
            }
            if(auth()->user()->type == 1){
                $postlist = Post::where(function ($query) use ($text) {
                                $query->where('title', 'like', '%' . $text . '%')
                                      ->orWhere('description', 'like', '%' . $text . '%');
                            })
                            ->where('created_user_id', auth()->user()->id)
                            ->paginate($pageSize);
                           
            }
            
            else{
                $postlist = Post::where('title', 'like', '%'.$text.'%')
                                ->orWhere('description', 'like', '%'.$text.'%')
                                ->paginate($pageSize);
            }
            
            return view('post.postlist_card', compact('postlist', 'pageSize'));
        }

}

