<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
;

class PostModelTest extends TestCase
{
    /**
     * A basic unit test example.
     */
   
     
     use RefreshDatabase;

     public function test_non_fillable_attributes_are_not_set()
     {
         $post = new Post([
             'title' => 'post',
             'description' => 'Sample Post Description',
            
         ]);
 
         // Check that the non-fillable attribute 'status' is not set
         $this->assertArrayNotHasKey('title', $post->getAttributes());
     }
 
    
 
}
