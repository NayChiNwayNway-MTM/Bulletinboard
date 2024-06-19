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
    Route::middleware('authmiddleware')->group(function(){
      
        //user
        Route::get('/register','UserController@register')->name('register');
        Route::post('/register','UserController@registration')->name('registration');
        Route::get('/user','UserController@userlist')->name('user');   
        Route::get('/profile','UserController@profile')->name('profile');
        Route::post('/editprofile','UserController@editprofile')->name('editprofile');
        Route::get('/pass','UserController@forgetpassword')->name('forgetpassword');
        Route::post('/restpass','UserController@resetpassword')->name('resetpassword');
        Route::post('/updatepass','UserController@update_password')->name('updatepassword');
        Route::get('/changepassword','UserController@change_password')->name('changepassword');
        Route::post('/changepassword','UserController@changed_password')->name('changedpassword');
        //userdelete
        Route::post('/user/userdelete/{id}','UserDeleteController@delete');
        Route::post('/user/deleteduser/{id}','UserDeleteController@confirm');
        //post
        Route::get('/postlist','PostListController@postlist')->name('postlist')->middleware('authmiddleware');   
        Route::resource('/post','PostListController');
        Route::post('/post_edit_confirm/{id}','PostListController@post_edit_confirm')->name('post_edit_confirm');
        Route::get('/postdelete','PostListController@postdelete')->name('postdelete'); 
        Route::get('/createpost','PostListController@createpost');
        Route::get('/uploadpost','PostListController@upload_post');
        Route::post('/uploadedpost','PostListController@uploaded_post')->name('uploadedpost');
        Route::get('/downloadpost','PostListController@download_post');   
        //postdelete
        Route::post('/delete/{id}','PostDeleteController@delete')->name('delete');
        Route::delete('postlist/deletedpost/{id}','PostDeleteController@destroy');   
        Route::post('/search/{text}','PostDeleteController@search')->name('search');
        Route::post('/postdetails/{id}','PostDeleteController@postdetails');
    });
   
});
