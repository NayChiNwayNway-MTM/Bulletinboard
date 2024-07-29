<?php 

namespace App\Services;
use App\Models\Post;
class PostService{

  //postlist table
  public function postlist($pageSize){
    return Post::postlist($pageSize);
  }
  //postlist card
  public function cardView($pageSize){
    return Post::cardView($pageSize);
  }
  //allpostlist table
  public function all_postlist($pageSize){
    return Post::all_postlist($pageSize);
  }
  //allpostlist card
  public function all_postlist_card($pageSize){
    return Post::all_postlist_card($pageSize);
  }
  //store post as created post
  public function store($request){
    return Post::store($request);
  }
  //for post edit
  public function edit($id){
    return Post::edit($id);
  }
  //for post_edit_confirm
  public function post_edit_confirm($request,$id){
    return Post::post_edit_confirm($request,$id);
  }
  //post update
  public function update($request,$id){
    return Post::updatepost($request,$id);
  }
  //upload post
  public function upload_post($request){
    return Post::upload_post($request);
  }
  //for download psot
  public function export($request){
    return Post::export($request);
  }
  //for download allpost
  public function download_allpost($request){
   
    return Post::download_allpost($request);
    
  }
  //for search
  public function search($text,$pageSize){
    return Post::search($text,$pageSize);
  }
  //for search post
  public function search_card($text,$pageSize){
    return Post::search_card($text,$pageSize);
  }
  //for search_allpost_table
  public function search_allpost_table($text,$pageSize){
    return Post::search_allpost_table($text,$pageSize);
  }
  //for search_allpost_card
  public function search_allpost_card($text,$pageSize){
    return Post::search_allpost_card($text,$pageSize);
  }
  //for barchart
  public function barchart($request){
    return Post::barchart($request);
  }
  //for toggle_Like
  public function toggle_Like($request,$post){
    return Post::toggle_Like($request,$post);
  }

}
?>