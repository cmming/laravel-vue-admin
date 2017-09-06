<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/login", '\App\Http\Controllers\Api\AuthenticateController@login')->name('login');
Route::post("/register", '\App\Http\Controllers\Api\AuthenticateController@store')->name('register');

//用户相关接口
Route::group(['middleware' => 'jwt.auth', 'providers' => 'jwt'],function(){
    Route::get("/users", '\App\Http\Controllers\Api\UserController@index');
});
Route::group(['middleware' => 'verifyToken'],function(){
    Route::get("/users1", '\App\Http\Controllers\Api\UserController@index');
});