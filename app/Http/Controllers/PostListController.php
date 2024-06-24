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
use Illuminate\Support\Facades\Validator;
use Exception;
class PostListController extends Controller
{
    //
    
    public function postlist(){

    if(auth()->user()->type == 1){
        $postlist = Post::where('created_user_id', auth()->user()->id )
                        
                        ->paginate(5);
        $users = User::all();
        return view('post.postlist', compact('postlist', 'users'));
    }else{
      
        $postlist=Post::paginate(5);
        $users = User::all();
        return view('post.postlist', compact('postlist', 'users'));
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
               'title.required'=>'Title can\'t be blank',
               'title.unique' => 'The title has already been taken.',
               'description.required'=>'Description can\'t be balnk' ,
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
            'title.required' => 'Title can\'t be blank',
            'title.unique' => 'The title has already been taken.',
            'description.required' => 'Description can\'t be blank',
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
    // start post create with restoration
//    public function store(Request $request)
//    {
//        // Validate request data
//        $request->validate([
//            'title' => 'required|max:255',
//            'description' => 'required|max:255',
//        ], [
//            'title.required' => 'Title can\'t be blank',
//            'title.unique' => 'The title has already been taken.',
//            'description.required' => 'Description can\'t be blank',
//            'description.max' => 'Description must not exceed 255 characters.',
//        ]);
//
//        // Check if a post with the same title exists (including soft deleted ones)
//        $existingPost = Post::withTrashed()
//            ->where('title', $request->title)
//            ->first();
//
//        if ($existingPost) {
//            if ($existingPost->deleted_at) {
//                // Restore the soft deleted post
//                $existingPost->restore();
//
//                // Update the restored post with new description if needed
//                $existingPost->update([
//                    'description' => $request->description,
//                    'created_user_id' => Auth::user()->id,
//                    'created_at' => now(),
//                ]);
//
//                // Flash success message
//                Session::flash('postcreated', 'Post created successfully after restoration.');
//            } else {
//                // Post with the same title exists and is not soft deleted
//                return redirect()->back()->withErrors(['title' => 'The title has already been taken.']);
//            }
//        } else {
//            // Create new post
//            Post::create([
//                'title' => $request->title,
//                'description' => $request->description,
//                'created_user_id' => Auth::user()->id,
//                'created_at' => now(),
//            ]);
//
//            // Flash success message
//            Session::flash('postcreated', 'Post created successfully.');
//        }
//
//        // Redirect or return view as per your application flow
//        return view('post.create_post');
//    }
    // end post create with restoration
    //post edit 
    public function edit($id){
       
        $post = Post::find($id);
        //dd($post);
        return view('post.edit_post',compact('post'));
    }
    public function post_edit_confirm(Request $request,$id){
        $request->validate(
            [
            'title'=>'required|unique:posts|max:255',
            'description'=>'required|max:255'

            ],
            [
               'title.required'=>'Title can\'t be blank',
               'title.unique' => 'The title has already been taken.',
               'description.required'=>'Description can\'t be balnk' ,
               'description.max' => 'Description must not exceed 255 characters.',
            ]);
            $status = $request->status ? 1 : 0;
           // dd($status);
            $post=$request;
           // $post_update=PostList::find($id);
            //$post_update->update($request->except('_token'));
            //return redirect()->route('postlist')->with('success','Edit post successfully');
            return view('post.post_edit_confirm',compact('post','status'));
    }
        //post updated from database
        public function update(Request $request ,$id){
           //dd($id);
            $title=$request->title;
            $des=$request->description;
            $status = $request->status ? 1 : 0;
            //dd($status);
            $update =Post::where('id',$id)->update(['title'=>$title,
                                                        'description'=>$des,
                                                        'status'=>$status,
                                                        'updated_user_id'=>auth()->user()->id,'updated_at'=>Carbon::now()]);
            Session::flash('postedites','Post Updated Successfully');
            return redirect()->route('postlist');
        }
        //upload_post ui
        public function upload_post(){
            return view('post.upload_post');
        }
        //upload_post validation
        public function uploaded_post(Request $request){
            $request->validate([
                'csvfile' => 'required|file'
            ]);
          
    

             $path = $request->file('csvfile')->getRealPath(); 
            $file_type= $request->file('csvfile')->getClientOriginalExtension();
            if($file_type !== 'csv'){
                return redirect()->back()->with('error', 'File must be csv type.')->withInput();
            }
            try {
                    $csv = Reader::createFromPath($path, 'r');
                    $csv->setHeaderOffset(0);

                     $header = $csv->getHeader();

                    //Check if the header has exactly 3 columns
                    if (count($header) !== 3) {
                        return redirect()->back()->with('error', 'CSV must have exactly 3 columns.')->withInput();
                    }
                    $records = Statement::create()->process($csv);
                   
                    foreach ($records as $record) {

                        if (count($record) !== 3) {
                           
                            return redirect()->back()->with('error', 'Each row in the CSV must have exactly 3 columns.')->withInput();
                        }
                      
                    //   $existingPost = Post::withTrashed() //check post deleted
                    //   ->where('title',$record['title'])
                    //   ->first();
                       
                //        if ($existingPost) {
                //           //dd($existingPost->deleted_at);
                //            if ($existingPost->deleted_at) {
                //               
                //                // Restore the soft deleted post
                //                $existingPost->restore();
                //                
                //                // Update the restored post with new description if needed
                //                $existingPost->update([
                //                    'title' => $record['title'],
                //                    'description' => $record['description'],
                //                    'status' => $record['status'],
                //                    'created_user_id' => Auth::id(),
                //                    'updated_user_id' => Auth::id(),
                //                    'created_at' => Carbon::now(),
                //                    'updated_at' => Carbon::now(),
                //                ]);
                //
                //            } else {
                //                // Post with the same title exists and is not soft deleted
                //                return redirect()->back()->with(['error' => 'The title has already been taken.'])->withInput();
                //            }
                //        } else {
                                // Create new post
                            Post::Create([
                                'title' => $record['title'],
                                'description' => $record['description'],
                                'status' => $record['status'],
                                'created_user_id' => Auth::id(),
                                'updated_user_id' => Auth::id(),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                             ]);
                       //  }
           
                    
            }
    
            return redirect()->route('postlist')->with('success', 'CSV data imported successfully.');
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'There was an error processing the CSV file.')->withInput();
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
       
       
}
