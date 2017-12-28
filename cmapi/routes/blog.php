<?php
/**
 * Created by PhpStorm.
 * User: 陈明
 * Date: 2017/11/10
 * Time: 16:26
 * Des
 */
//Route::group(['middleware' => 'auth:web'], function () {
Route::group(['middleware' => 'blogUserChange'], function () {

    //sign
    Route::get('/blog/signIn', '\App\Http\Controllers\Blog\UserController@signIn');
    Route::get('/blog/signUp', '\App\Http\Controllers\Blog\UserController@signUp');

    Route::post('/blog/signUp', '\App\Http\Controllers\Blog\UserController@signUpStore');
    Route::post('/blog/signIn', '\App\Http\Controllers\Blog\UserController@signInStore');

    Route::get('/blog/logout', '\App\Http\Controllers\Blog\UserController@logout');


// 文章
    Route::get('/', '\App\Http\Controllers\Blog\PostController@index');
    Route::get('/blog/posts', '\App\Http\Controllers\Blog\PostController@index');
    Route::get('/blog/posts/add', '\App\Http\Controllers\Blog\PostController@add');
    Route::get('/blog/posts/{post}/edit', '\App\Http\Controllers\Blog\PostController@edit');
    Route::get('/blog/posts/{post}/delete', '\App\Http\Controllers\Blog\PostController@delete');
    Route::get('/blog/posts/{post}', '\App\Http\Controllers\Blog\PostController@detail');


    Route::post('/blog/posts', '\App\Http\Controllers\Blog\PostController@store');
    Route::put('/blog/posts/{post}', '\App\Http\Controllers\Blog\PostController@update');
//Route::get('/postDetail','\App\Http\Controllers\Blog\PostsController@detail');


//文章 类型
    Route::get('/blog/post/topics', '\App\Http\Controllers\Blog\TopicController@index');
    Route::get('/blog/posts/topic/{topic}', '\App\Http\Controllers\Blog\TopicController@posts');


//文章留言
//Route::get('/blog/post/comments','\App\Http\Controllers\Blog\CommentController@index');
    Route::post('/blog/posts/{post}/comments', '\App\Http\Controllers\Blog\PostController@commentsStore');


    //个人主页
    Route::get('/blog/user/{user}', '\App\Http\Controllers\Blog\UserController@show');
    //个人设置 页面
    Route::get('/blog/user/me/setting', '\App\Http\Controllers\Blog\UserController@setting');
    Route::post('/blog/user/me/setting', '\App\Http\Controllers\Blog\UserController@settingSore');


});






