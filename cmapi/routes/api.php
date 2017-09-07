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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::post("/login", '\App\Http\Controllers\Api\AuthenticateController@login')->name('login');
//Route::post("/register", '\App\Http\Controllers\Api\AuthenticateController@store')->name('register');
//
////用户相关接口
//Route::group(['middleware' => 'jwt.auth', 'providers' => 'jwt'],function(){
//    Route::get("/users", '\App\Http\Controllers\Api\UserController@index');
//});
//Route::group(['middleware' => 'verifyToken'],function(){
//    Route::get("/users", '\App\Http\Controllers\Api\UserController@index');
//});

$api = app('Dingo\Api\Routing\Router');


$api->version('v1', [
    // 命名空间
    'namespace' => 'App\Http\Controllers\Api\V1',
],function ($api){
    $api->post('login', [
        //路由别名
        'as' => 'authorizations.login',
        //
        'uses' => 'AuthenticateController@login',
    ]);
    $api->post('register', [
        //路由别名
        'as' => 'authorizations.register',
        //
        'uses' => 'AuthenticateController@store',
    ]);
    $api->group(['middleware' => ['verifyToken']], function ($api){
//    $api->group(['middleware' => ['verifyToken','jwt.refresh']], function ($api){
        //退出登录
        $api->post('logout', [
            //路由别名
            'as' => 'authorizations.logout',
            //
            'uses' => 'AuthenticateController@logout',
        ]);
        //获取用户信息
        $api->get('users', [
            //路由别名
            'as' => 'users.index',
            //
            'uses' => 'UserController@index',
        ]);
        //获取一个用户的信息
        $api->get('users/{user}', [
            //路由别名
            'as' => 'users.show',
            //
            'uses' => 'UserController@show',
        ]);
        //更新一个用户信息
        $api->put('users/{user}', [
            //路由别名
            'as' => 'users.update',
            //
            'uses' => 'UserController@update',
        ]);
        //添加一个用户信息
        $api->post('users', [
            //路由别名
            'as' => 'users.store',
            //
            'uses' => 'UserController@store',
        ]);
        //删除一个用户
        $api->delete('users', [
            //路由别名
            'as' => 'users.destroy',
            //
            'uses' => 'UserController@destroy',
        ]);
    });
});