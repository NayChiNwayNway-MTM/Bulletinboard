<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Testing\File;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\PostService;


class PostModelTest extends TestCase
{
    public function test_title_and_description_are_required()
    {
        // Test when title and description are both null
        //            $response = $this->post('/posts', [
        //                'title' => null,
        //                'description' => null,
        //            ]);
        //
        //            $response->assertSessionHasErrors(['title', 'description']);
        //
        //            // Test when title is null and description is provided
        //            $response = $this->post('/posts', [
        //                'title' => null,
        //                'description' => 'Some description',
        //            ]);
        //
        //            $response->assertSessionHasErrors('title');
        //
        //            // Test when title is provided and description is null
        //            $response = $this->post('/posts', [
        //                'title' => 'Some title',
        //                'description' => null,
        //            ]);
        //
        //            $response->assertSessionHasErrors('description');

    }
    public function test_Post_store(): void
    {
      
        $data = [
            'title' => 'title03',
            'description' => 'description1',
            'created_user_id' => 1,
            'updated_user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        // Create the post using the Post model
        Post::create($data);

        // Assert that the post exists in the database
        $this->assertDatabaseHas('posts', $data);

    }
    public function testUpdatePost()
    {
        $post = Post::create([
            'title' => 'TestTitle05',
            'description' => 'description05',
            'created_user_id' => 1,
            'updated_user_id' => 1,
        ]);
       $data =  $post->update([
            'title' => 'UpdatedTitle05',
            'description' => 'updated description05',
            'updated_user_id' => 1,
        ]);
        $this->assertDatabaseHas('posts',[
            'id' => $post->id,
            'title' => 'UpdatedTitle05',
            'description' => 'updated description05',
            'updated_user_id' => 1,
        ]);
    }
    public function testDeletePost()
    {
       

        // Retrieve the post using findOrFail to ensure it exists
        $post = Post::findOrFail(16);

        
        $post->delete();

        // Assert that the post no longer exists in the database
        $this->assertDatabaseMissing('posts', ['id' => 16]);
    }

    public function testUploadValidCSV()
    {
   
        Storage::fake('public'); // Use fake storage for testing

        // Create a valid CSV file using File class
        $file = File::create('test.csv', 'Title 1,Title 2,Title 3', 'text/csv');

        // Simulate a POST request with the valid CSV file
        $response = $this->post('/uploadedpost', ['csvfile' => $file]);

        // Assert that no validation errors occurred
        $response->assertSessionDoesntHaveErrors('csvfile');

        // Assert that posts were created due to the valid CSV file
        $this->assertGreaterThan(0, Post::count());
    
    }
    public function testUploadInvalidFileType()
    {
        Storage::fake('public'); // Use fake storage for testing

        // Create an invalid file type (e.g., PNG) using File class
        $file = File::create('test.png', '', 'image/png');

        // Simulate a POST request with the invalid file type
        $response = $this->post('/uploadedpost', ['csvfile' => $file]);

        // Assert that validation errors occurred
        $response->assertSessionHasErrors('csvfile');
    }
    public function testDownloadFile()
    {
      
                    $post = new Post();
                    $post->title = 'Test Post';
                    $post->description = 'This is a test post content.';
                    $post->created_user_id = 1;
                    $post->updated_user_id = 1;
                    $post->created_at = Carbon::now();
                    $post->updated_at = Carbon::now();
                    $post->save();
            
                    // Confirm the post exists in the database
                    $this->assertDatabaseHas('posts', [
                        'title' => 'Test Post',
                        'description' => 'This is a test post content.',
                        'created_user_id' => 1,
                        'updated_user_id' => 1,
                    ]);
            
                    // Simulate downloading a post
                    $response = $this->get('/download-post/' . $post->id);
            
                    // Assert the response status is OK
                    $response->assertStatus(200);
            
                    // Assert the content is correct
                    $response->assertSee('Test Post');
                    $response->assertSee('This is a test post content.');
    }
    
}