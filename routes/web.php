<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();//これだけで認証系のルーてぅングができる｜


Route::group(['middleware' => 'auth'], function () {//認証された人だけ｜
    

    Route::resource('posts', 'PostController')->only(['index', 'create', 'store', 'edit', 'update']);//｜

    Route::resource('users', 'UserController')->only(['index', 'show', 'edit', 'update']);//

    Route::resource('comments', 'CommentController')->only(['store']);//｜

    Route::resource('likes', 'LikeController')->only(['store', 'destroy']);//

    Route::resource('follows' ,'FollowController')->only(['store', 'destroy']);

    //Route::resource('tags', 'TagController');//

     Route::get('posts/create', 'PostController@create')->name('posts.create');
    
});


Route::get('/', 'IndexController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/json/{s_word}', 'HomeController@mapinfo')->name('json');//マップ
