<?php 
namespace App\Services;
use App\Models\Post;
class PostDeleteService{
  public function delete($id){
    return Post::deletepost($id);
  }
  public function destroy($id){
    return Post::destroy($id);
  }
  public function postdetails($id){
    return Post::postdetails($id);
  }
}
?>