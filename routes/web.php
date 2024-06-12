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
    //user
    Route::get('/login','UserController@login');
    Route::get('/register','UserController@register')->name('register');
    Route::post('/register','UserController@registration')->name('registration');
    Route::get('/user','UserController@userlist')->name('user');
    Route::get('/signup','UserController@signup')->name('signup');
    Route::post('/signup','UserController@create')->name('signup');
    Route::get('/profile','UserController@profile')->name('profile');
    Route::post('/editprofile','UserController@editprofile')->name('editprofile');
    Route::get('/pass','UserController@forgetpassword')->name('forgetpassword');
    Route::post('/restpass','UserController@resetpassword')->name('resetpassword');
    Route::post('/updatepass','UserController@update_password')->name('updatepassword');
    //post
    Route::get('/postlist','PostListController@postlist')->name('postlist');
    Route::get('/createpost','PostListController@createpost');
    Route::resource('/post','PostListController');
    Route::post('/post_edit_confirm/{id}','PostListController@post_edit_confirm')->name('post_edit_confirm');
   
});
