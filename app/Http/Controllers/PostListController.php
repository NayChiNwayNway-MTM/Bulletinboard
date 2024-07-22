<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
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
use Illuminate\Support\Facades\Log;
use App\Services\PostService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class PostListController extends Controller
{
    //  
        protected $postService;
        public function __construct(PostService $postService)
        {
            $this->postService = $postService;
        }  
        public function postlist(Request $request){
            $pageSize = $request->input('page_size', 10);
            session(['pagesize'=>$pageSize]);

            $result=$this->postService->postlist($pageSize);
            return view('post.postlist',['postlist'=>$result['postlist'],'users'=>$result['users'],'pageSize'=>$result['pageSize']]);
         
        }
        public function cardView(Request $request){
          
            $pageSize = $request->input('page_size', 9);
            session(['pagesize'=>$pageSize]);

            $result =$this->postService->cardView($pageSize);
            return view('post.postlist_card',['postlist'=>$result['postlist'],'users'=>$result['users'],'pageSize'=>$result['pageSize']]);
        }
        // all postlist for table
        public function all_postlist(Request $request){
            $pageSize = $request->input('page_size', 10);
            session(['pagesize'=>$pageSize]);
            $result = $this->postService->all_postlist($pageSize);

            return view('post.all_postlist', ['postlist'=>$result['postlist'], 'users'=>$result['users'],'pageSize'=>$result['pageSize']]);
        }
        //all postlist for cardview
        public function all_postlist_card(Request $request){
            
            $pageSize = $request->input('page_size', 9);
            session(['pagesize'=>$pageSize]);
            $result = $this->postService->all_postlist_card($pageSize);
            return view('post.all_postlist_card',['postlist'=>$result['postlist'],'users'=>$result['users'],'pageSize'=>$result['pageSize']]);
       
           
    
        }

        //create post ui
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
         $this->postService->store($request);      
   
            //return view('post.postlist');
            return redirect()->route('postlist');
        }
        
        //post edit 
        public function edit($id){
            
            $result=$this->postService->edit($id);
            
            //dd($post);
            return view('post.edit_post',['post'=>$result['post']]);
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
                $result=$this->postService->post_edit_confirm($request,$id);
                
                if(isset($result['unique'])){
                    return view('post.post_edit_confirm',['post'=>$result['post'],'status'=>$result['status']]);
                    
                }else{
                    return redirect()->route('postlist')->with('error', 'The title has already been taken.');
                }
        }
        //post updated from database
        public function update(Request $request ,$id){
           //dd($id);
           $result = $this->postService->update($request,$id);
           //dd($result);
           if(isset($result['postedites'])){
            return redirect()->route('postlist')->with(['postedites'=>$result['postedites']]);
           }
           else{
            return redirect()->route('postlist')->with(['error'=>$result['error']]);
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

            $result = $this->postService->upload_post($request);
            if(isset($result['error'])){
                return redirect()->back()->with('error', $result['error'])->withInput();
            }
            if(isset($result['success'])){
                return redirect()->route('postlist')->with(['success'=>$result['success']]); 
            }
            
        }
        //post download with csv format
        public function export(Request $request)
        { 
            //$result = $this->postService->export($request);
            //$posts = $result['posts'];
            //return new StreamedResponse(function () use ($posts) {
            //    $handle = fopen('php://output', 'w');
            //    fputcsv($handle, ['ID', 'Title', 'Description','Status','created_user_id',
            //                        'updated_user_id','deleted_user_id','created_at','updated_at','deleted_at']);
            //                        foreach ($posts as $post) {
            //                            $status = $post->status == 1 ? 'Active' : 'Inactive';
            //                            fputcsv($handle, [
            //                                $post->id, 
            //                                $post->title, 
            //                                $post->description,
            //                                $status, // Use the converted status here
            //                                $post->created_user_id, 
            //                                $post->updated_user_id, 
            //                                $post->deleted_user_id,
            //                                $post->created_at, 
            //                                $post->updated_at, 
            //                                $post->deleted_at
            //                            ]);
            //                        }
            //        fclose($handle);
            //    }, 200, [
            //        'Content-Type' => 'text/csv',
            //        'Content-Disposition' => 'attachment; filename="posts.csv"',
            //    ]);   
            /////////////////////////////////////
            $result = $this->postService->export($request);
            $posts = $result['posts'];
        
            // Create a new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
        
            // Set header row
            $headers = ['ID', 'Title', 'Description', 'Status', 'Created User ID', 'Updated User ID', 'Deleted User ID', 'Created At', 'Updated At', 'Deleted At'];
            $sheet->fromArray($headers, NULL, 'A1');
        
            // Populate data rows
            $rowNumber = 2;
            foreach ($posts as $post) {
                $status = $post->status == 1 ? 'Active' : 'Inactive';
                $sheet->fromArray([
                    $post->id,
                    $post->title,
                    $post->description,
                    $status,
                    $post->created_user_id,
                    $post->updated_user_id,
                    $post->deleted_user_id,
                    $post->created_at,
                    $post->updated_at,
                    $post->deleted_at,
                ], NULL, 'A' . $rowNumber);
                $rowNumber++;
            }
        
            // Create Xlsx writer
            $writer = new Xlsx($spreadsheet);
        
            // Set the filename and download
            $filename = 'posts.xlsx';
        
            return response()->stream(
                function () use ($writer) {
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ]
            );

        }
          //post download with csv format
        public function download_allpost(Request $request)
        { 
                //    
                //   $result = $this->postService->download_allpost($request);
                //  // dd($result);
                //   if(isset($result['null'])){
                //    return Excel::download(new PostsExport, 'posts.csv', \Maatwebsite\Excel\Excel::CSV);
                //   } 
                //   else{
                //    $posts=$result['posts'];
                //    return new StreamedResponse(function () use ($posts) {
                //      $handle = fopen('php://output', 'w');
                //     fputcsv($handle, ['ID', 'Title', 'Description','Status','created_user_id',
                //                         'updated_user_id','deleted_user_id','created_at','updated_at','deleted_at']);
                //     foreach ($posts as $post) {
                //        $status = $post->status == 1 ? 'Active' : 'Inactive';
                //          fputcsv($handle, [$post->id, $post->title, $post->description,
                //                $status,$post->created_user_id,$post->updated_user_id,$post->deleted_user_id,
                //                 $post->created_at,$post->updated_at,$post->deleted_at]);
                //     }
                //         fclose($handle);
                //     }, 200, [
                //          'Content-Type' => 'text/csv',
                //         'Content-Disposition' => 'attachment; filename="posts.csv"',
                //     ]);  
                //      
                //   }
                //////////////////////////////////////

            // Fetch data from the service
            $result = $this->postService->download_allpost($request);

            // Get all posts, if the result is null, ensure you handle that case
            $posts = $result['posts'] ?? $this->getAllPosts();

            // Create a new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            if (empty($posts)) {
                // If no posts are available
                $sheet->setCellValue('A1', 'No posts available');
                // Optionally, you can format the cell to make it look better
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->getColumnDimension('A')->setWidth(30);
            } else {
                // Set header row
                $headers = ['ID', 'Title', 'Description', 'Status', 'Created User ID', 'Updated User ID', 'Deleted User ID', 'Created At', 'Updated At', 'Deleted At'];
                $sheet->fromArray($headers, NULL, 'A1');

                // Populate data rows
                $rowNumber = 2;
                foreach ($posts as $post) {
                    $status = $post->status == 1 ? 'Active' : 'Inactive';
                    $sheet->fromArray([
                        $post->id,
                        $post->title,
                        $post->description,
                        $status,
                        $post->created_user_id,
                        $post->updated_user_id,
                        $post->deleted_user_id,
                        $post->created_at,
                        $post->updated_at,
                        $post->deleted_at,
                    ], NULL, 'A' . $rowNumber);
                    $rowNumber++;
                }
            }

            // Create Xlsx writer
            $writer = new Xlsx($spreadsheet);

            // Set the filename and download
            $filename = 'posts.xlsx';

            return response()->stream(
                function () use ($writer) {
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ]
            );
            
        
        }
        private function getAllPosts()
        {
            // Assuming you have a Post model to get all posts
            return \App\Models\Post::all();
        }
        //search post for table
        public function search(Request $request){
            $text = $request->text;

            $pageSize = $request->input('page_size', session('page_size', 10)); // Default to 10 if not set

            // Update session with the new page size if provided
            if ($request->has('page_size')) {
                session(['page_size' => $request->input('page_size')]);
            }
            $result=$this->postService->search($text,$pageSize);
          // dd($result);
            return view('post.postlist')->with(['postlist'=>$result,'pageSize'=>$pageSize]);
        }
        //search psot for card
        public function search_card(Request $request){
            $text = $request->text;

            $pageSize = $request->input('page_size', session('page_size', 10)); // Default to 10 if not set

            // Update session with the new page size if provided
            if ($request->has('page_size')) {
                session(['page_size' => $request->input('page_size')]);
            }
            $result = $this->postService->search_card($text,$pageSize);
           return view('post.postlist_card')->with(['postlist'=>$result,'pageSize'=>$pageSize]);
        }
        //search all postlist for table
        public function search_allpost_table(Request $request){
            $text = $request->text;

            $pageSize = $request->input('page_size', session('page_size', 10)); // Default to 10 if not set

            // Update session with the new page size if provided
            if ($request->has('page_size')) {
                session(['page_size' => $request->input('page_size')]);
            }
            $result = $this->postService->search_allpost_table($text,$pageSize);
           
            
            return view('post.all_postlist')->with(['postlist'=>$result,'pageSize'=>$pageSize]);
        }
          //search all postlist for card
          public function search_allpost_card(Request $request){
            $text = $request->text;
            
            $pageSize = $request->input('page_size', session('page_size', 10)); // Default to 10 if not set

            // Update session with the new page size if provided
            if ($request->has('page_size')) {
                session(['page_size' => $request->input('page_size')]);
            }
            $result = $this->postService->search_allpost_card($text,$pageSize);
       

            return view('post.all_postlist_card')->with(['postlist'=>$result,'pageSize'=>$pageSize]);
        }

        //barchart
        public function barchart(Request $request){
            $result = $this->postService->barchart($request);
           //dd($result);
           // dd($userActivity);
            return view('barchart')->with(['users'=>$result['users'],'posts'=>$result['posts'],
                                            'active'=>$result['active'],'inactive'=>$result['inactive'],
                                            'postsPerMonth'=>$result['postPerMonth'],'userActivity'=>$result['userActivity']]);
        }

        //likes
        public function toggle_Like(Request $request, Post $post)
        {
            $result = $this->postService->toggle_Like($request,$post);

            return response()->json(['status' => $result['status'], 'count' => $result['count']]);
        }
}

