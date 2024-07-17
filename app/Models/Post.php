<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;
use App\Exports\PostsExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Post extends Model
{
  
    use HasFactory;
    protected $fillable=[
        'title','description','status','created_user_id','updated_user_id','created_at','updated_at','likes'
    ];
    public function user(){
        return $this->belongsTo(User::class,'created_user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //for postlist table
    public static function postlist($pageSize){
                    
        if(Auth::check()){
            if(auth()->user()->type == 1){
                $postlist = Post::where('created_user_id', auth()->user()->id )
                                ->latest()
                                ->paginate($pageSize);
                $users = User::all();
               
                return ['postlist'=>$postlist ,'users'=>$users,'pageSize'=>$pageSize];
            }else{
                
                $postlist=Post::with('user')->latest()->paginate($pageSize);
                $users = User::all();
                return ['postlist'=>$postlist, 'users'=>$users,'pageSize'=>$pageSize];
            }
        }
        else{
            $postlist=Post::where('status',1)->latest()->paginate($pageSize);
            $users = User::all();
            return ['postlist'=>$postlist,'users'=>$users,'pageSize'=>$pageSize];
           
        }
    }
    //for postlist card
    public static function cardView($pageSize){
        if(Auth::check()){
            if(auth()->user()->type == 1){
                $postlist = Post::where('created_user_id', auth()->user()->id )
                                ->latest()
                                ->paginate($pageSize);
                $users = User::all();
               
                return ['postlist'=>$postlist, 'users'=>$users,'pageSize'=>$pageSize];
            }else{
                
                $postlist=Post::with('user')->latest()->paginate($pageSize);
                $users = User::all();
                return ['postlist'=>$postlist, 'users'=>$users,'pageSize'=>$pageSize];
            }
        }
        else{
            $postlist=Post::where('status',1)->latest()->paginate($pageSize);
            $users = User::all();
            return ['postlist'=>$postlist, 'users'=>$users,'pageSize'=>$pageSize];
        }
    }
    //for allpostlist table
    public static function all_postlist($pageSize){
        if(Auth::check()){
            if(auth()->user()->type == 1){
                $postlist = Post::with('user')->where('status','1')->latest()->paginate($pageSize);
                $users = User::all();
               
                return ['postlist'=> $postlist, 'users'=>$users,'pageSize'=>$pageSize];
            }else{
                
                $postlist=Post::with('user')->latest()->paginate($pageSize);
                $users = User::all();
                return ['postlist'=> $postlist, 'users'=>$users,'pageSize'=>$pageSize];
            }
        }
    }
    //for allpostlist card
    public static function all_postlist_card($pageSize){
        if(Auth::check()){
            if(auth()->user()->type == 1){
                $postlist = Post::with('user')->where('status','1')->latest()->paginate($pageSize);
                $users = User::all();
               
                return ['postlist'=>$postlist, 'users'=>$users,'pageSize'=>$pageSize];
            }
            else{
                
                $postlist=Post::with('user')->latest()->paginate($pageSize);
                $users = User::all();
                return ['postlist'=>$postlist, 'users'=>$users,'pageSize'=>$pageSize];
            }
        }
    }
    //for created post store database
    public static function store($request){
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
        return ;
    }
    //for post edit
    public static function edit($id){
        $post = Post::find($id);
        return['post'=>$post];
    }
    //for post_edit_confirm
    public static function post_edit_confirm($request,$id){
        $status = $request->status ? 1 : 0;
        // dd($status);
            $post=$request;
            $unique=Post::where('title',$request->title)->where('id',$id)->first();
          
            if($unique){
                return ['post'=>$post,'status'=>$status,'unique'=>$unique];
            }
            else{
                
                return ['error'=>'The Title is already exist'];
            }
    }
    //update post
    public static function updatepost($request,$id){
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
            return ['postedites'=>'Post Updated Successfully.'];
        }
        else{
            Session::flash('error','Title already taken.');
            return ['error'=>'Title already taken.'];
        }
    }

    //upload post
    public static function upload_post($request){
        // Retrieve and process the uploaded file
        $file = $request->file('csvfile');
        $tempPath = sys_get_temp_dir().'/'.uniqid().'csv';

        
        $file_type= $request->file('csvfile')->getClientOriginalExtension();
        if($file_type !== 'csv'){
            return ['error'=> 'File must be csv type.'];
        }
       
        try {
            // Move the uploaded file to a temporary location
            $file->move(sys_get_temp_dir(), $tempPath);

            // Read the content of the file
            $csv = Reader::createFromPath($tempPath, 'r');
            $csv->setHeaderOffset(0);
            $records = $csv->getRecords();
            if (empty(iterator_to_array($records))) {
                return ['error' => 'CSV file does not contain data rows. Please fill data before uploading.'];
            }
        foreach ($records as $record) {
                    
                    
                      // Validate the CSV data structure
                      if (count($record) !== 3) {
                        DB::rollBack();
                        return ['error'=> 'Each row in the CSV must have exactly 3 columns.'];
                    }
                    $existingPost = Post::where('title', $record['title'])->first();
                    if ($existingPost) {
                        
                        return[ 'error'=>'Post title already exists:'.$record['title']];
                       
                    }
            }
            if (empty(iterator_to_array($records))) {
                return ['error' => 'CSV file does not contain data rows. Please fill data before uploading.'];
            }
            
            foreach ($records as $record) {
                 
                if (count($record) !== 3) {
                    
                    return ['error'=>'Each row in the CSV must have exactly 3 columns.'];
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
             
                return ['success'=>'CSV data imported successfully.']; 

        }catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        } 
    }
    //download post
    public static function export($request){

        if(auth()->user()->type == 0){
            $text = $request->input('text', '');
          // dd($text);
           if($text == null){
            return Excel::download(new PostsExport, 'posts.csv', \Maatwebsite\Excel\Excel::CSV);
           }
           else{

            $posts = Post::where('title', 'like', '%'.$text.'%')
                            ->orWhere('description', 'like', '%'.$text.'%')
                            ->get();
            return['posts'=>$posts];
                                                   
           }
           
        }
        else{
           
            $text = $request->input('text', '');
            //dd($text);
            $posts = Post::where('title', 'like', '%'.$text.'%')
                    ->where('created_user_id',auth()->user()->id)
                    ->orWhere('description', 'like', '%'.$text.'%')
                    ->where('created_user_id',auth()->user()->id)
                    ->get();
                    return['posts'=>$posts];
          
        }
    }
    //dowmload allpost
    public static function download_allpost($request){
        if(auth()->user()->type == 0){
            $text = $request->input('text', '');
          //dd($text);
           if($text == null){
            return['null'=>'null'];
            
           }
           else{

            $posts = Post::where('title', 'like', '%'.$text.'%')
                            ->orWhere('description', 'like', '%'.$text.'%')
                            ->get();
            return ['posts'=>$posts];
                                                      
           }
           
        }
        else{
           
            $text = $request->input('text', '');
           // dd($text);
          //  $posts = Post::where('status', 1)
          //  ->orWhere('title', 'like', '%'.$text.'%')
          //  ->orWhere('description', 'like', '%'.$text.'%')
          //  ->get();
          $posts = Post::where('status', 1)
          ->where(function ($query) use ($text) {
              $query->where('title', 'like', '%'.$text.'%')
                    ->orWhere('description', 'like', '%'.$text.'%');
          })
          ->get();

          return ['posts'=>$posts];
           
        }
        
    }

    //for search
    public static function search($text,$pageSize){

      if(auth()->user()->type == 1){
                return Post::where(function ($query) use ($text) {
                                $query->where('title', 'like', '%' . $text . '%')
                                      ->orWhere('description', 'like', '%' . $text . '%');
                            })
                            ->where('created_user_id', auth()->user()->id)
                            ->latest()
                            ->paginate($pageSize);
                           
            }
            
            else{
               return  Post::where('title', 'like', '%'.$text.'%')
                                ->orWhere('description', 'like', '%'.$text.'%')
                                ->latest()
                                ->paginate($pageSize);
            }
           
    }
    //for search_card
    public static function search_card($text,$pageSize){
        if(auth()->user()->type == 1){
           return Post::where(function ($query) use ($text) {
                            $query->where('title', 'like', '%' . $text . '%')
                                  ->orWhere('description', 'like', '%' . $text . '%');
                        })
                        ->where('created_user_id', auth()->user()->id)
                        ->latest()
                        ->paginate($pageSize);
                       
        }
        
        else{
            return Post::where('title', 'like', '%'.$text.'%')
                            ->orWhere('description', 'like', '%'.$text.'%')
                            ->latest()
                            ->paginate($pageSize);
        }
        
        
    }
    //for search_allpost_table
    public static function search_allpost_table($text,$pageSize){
        if(Auth::check()){
            if(auth()->user()->type == 1){
             
                return Post::where('status', 1)
                ->where(function ($query) use ($text) {
                    $query->where('title', 'like', '%'.$text.'%')
                          ->orWhere('description', 'like', '%'.$text.'%');
                })->latest()
                ->paginate($pageSize);  
            }
        
            else{
                return Post::where('title', 'like', '%'.$text.'%')
                                ->orWhere('description', 'like', '%'.$text.'%')
                                ->latest()
                                ->paginate($pageSize);
            }
        }else{
            $postlist=Post::where('status',1)->paginate($pageSize);
            $users = User::all();
            
        }
    }
    //for search_allpost_card
    public static function search_allpost_card($text,$pageSize){
        if(auth()->user()->type == 1){
            return Post::where('status',1)
                        ->where(function ($query) use ($text) {
                            $query->where('title', 'like', '%' . $text . '%')
                                  ->orWhere('description', 'like', '%' . $text . '%');
                        })
                        ->latest()
                        ->paginate($pageSize);
                       
        } 
        else{
            return Post::where('title', 'like', '%'.$text.'%')
                            ->orWhere('description', 'like', '%'.$text.'%')
                            ->latest()
                            ->paginate($pageSize);
        }
    }
    //for barchart
    public static function barchart($request){
       
            $users =User::count();
            $posts = Post::count();
            $active=Post::where('status',1)->count();
            $inactive=Post::where('status',0)->count();
            $postsPerMonth=Post::selectRaw('MONTH(created_at) as month,COUNT(*) as count')
                        ->groupBy('month')
                        ->orderBy('month')->get();
            $userActivity = Post::select(
                            'posts.created_user_id',
                            DB::raw('COUNT(*) as post_count'),
                            'users.name'
                        )
                        ->join('users', 'posts.created_user_id', '=', 'users.id')
                        ->groupBy('posts.created_user_id', 'users.name')
                        ->get();
        return ['users'=>$users,'posts'=>$posts,'active'=>$active,'inactive'=>$inactive,'postPerMonth'=>$postsPerMonth,'userActivity'=>$userActivity];
    }
    //for toggle_Like
    public static function toggle_Like($request,$post){
        $user = $request->user();
        $existingLike = Like::where('user_id', $user->id)
                            ->where('post_id', $post->id)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $count = $post->likes()->count();
            return ['status' => 'unliked', 'count' => $count];

        } else {
            $like = new Like();
            $like->user_id = $user->id;
            $like->post_id = $post->id;
            $like->save();
            $count = $post->likes()->count();
            return ['status' => 'liked', 'count' => $count];
        }
    }

    //for postdeletecontroller 
    //delete post 
    public static function deletepost($id){
        $postid=Post::find($id);
        if($postid){
            return ['success'=>true,'post'=>$postid];
        }   
    }
    //destroy post
    public static function destroy($id)
    {
        $post = Post::find($id);       
            if (!$post) {
                return ['message' => 'Post not found'];
            }        
       
            $post->delete();
            return ['message' => 'Post deleted successfully'];
    }
    //postdetails
    public static function postdetails($id){
        $postdetail=Post::find($id);
        $postcreated=Post::where('id',$id)->pluck('created_user_id');
        $user=User::where('id',$postcreated)->pluck('name');
        session(['user'=>$user]);
        return ['postdetail'=>$postdetail,'user'=>$user];
    }
}