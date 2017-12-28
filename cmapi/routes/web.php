<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/test', function () {
    return 'view';
});

//Route::get('/blog/posts','\App\Http\Controllers\Blog\PostController@index');

//博客 的路由
include 'blog.php';

include 'wechat.php';

