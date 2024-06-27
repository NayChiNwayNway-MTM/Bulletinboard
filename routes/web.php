<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    
        Route::get('/login','AuthController@loginForm')->name('login');
        Route::post('/user-login','AuthController@login')->name('userlogin');
        Route::get('/logout','AuthController@logout')->name('logout');
        Route::get('/signup','AuthController@signup')->name('signup');
        Route::post('/signup','AuthController@create')->name('signup');
        //forget password
        Route::get('/forget_password','UserController@showforgetpassword')->name('forget.password.get');
        Route::post('/forget_password','UserController@submitforgetpassword')->name('forget.password.post');
        Route::get('/resetpassword/{token}','UserController@reset_password')->name('resetpassword.get');
        Route::post('/resetpassword','UserController@submit_reset_password')->name('resetpassword.post');
        //change password
        Route::get('/changepassword','UserController@change_password')->name('changepassword');
        Route::post('/changepassword','UserController@changed_password')->name('changedpassword');

        //unauthorized user and auth user
        Route::get('/postlist','PostListController@postlist')->name('postlist');
        Route::post('/search/{text}','PostDeleteController@search')->name('search');  
    
        
        
        Route::middleware('authmiddleware')->group(function(){
      
        //user
            Route::get('/register','UserController@register')->name('register');
            Route::post('/register','UserController@registration')->name('registration');
            Route::post('/saveregister','UserController@saveregister')->name('saveregister');
            Route::get('/user','UserController@userlist')->name('user');   
            Route::get('/profile/{id}','UserController@profile')->name('profile');
            Route::get('/editprofile/{id}','UserController@editprofile')->name('editprofile');
            Route::post('/update/{id}','UserController@update_profile')->name('updateprofile');
            

            //userdelete
            Route::post('/user/userdelete/{id}','UserDeleteController@delete');
            Route::post('/user/deleteduser/{id}','UserDeleteController@confirm');
            //user detail
            Route::post('/user/detail/{id}','UserDetailController@showdetail');
            //user search
            Route::get('/search','UserDetailController@search_user')->name('search_user');
        

            //post
            
            
            Route::resource('/post','PostListController');
            Route::post('/post_edit_confirm/{id}','PostListController@post_edit_confirm')->name('post_edit_confirm');
            Route::get('/postdelete','PostListController@postdelete')->name('postdelete'); 
            Route::get('/createpost','PostListController@createpost');
            Route::get('/uploadpost','PostListController@upload_post');
            Route::post('/uploadedpost','PostListController@uploaded_post')->name('uploadedpost');
            
            //postdelete
            Route::post('/delete/{id}','PostDeleteController@delete')->name('delete');
            Route::delete('postlist/deletedpost/{id}','PostDeleteController@destroy');   
            
            Route::post('/postdetails/{id}','PostDeleteController@postdetails');

            //download post
            Route::get('/posts/export','PostListController@export')->name('posts.export'); 
        
       
    });
   
});
