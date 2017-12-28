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

], function ($api) {
	//自定义jwt验证
	$api->group(['middleware' => ['userChangeMidleware']], function ($api) {
		$api->post('adminLogin', ['as' => 'AppUserController.adminLogin', 'uses' => 'AppUserController@login',]);
		$api->get('adminLogout', ['as' => 'AppUserController.adminLogout', 'uses' => 'AppUserController@logout',]);

		$api->post('adminRegister', ['as' => 'AppUserController.adminRegister', 'uses' => 'AppUserController@store',]);

		//获取动态路由
		$api->get('routers',['as'=>'routers.index','uses'=>'RouterController@index']);

		$api->group(['middleware' => ['verifyToken', 'verifyTokenAfter']], function ($api) {

			//检测token 是否合法
			$api->get('validateToken',['as'=>'AppUserController.validateToken','uses'=>'AppUserController@validateToken']);

			$api->get('userInfo', ['as' => 'AppUserController.userInfo', 'uses' => 'AppUserController@userInfo',]);


			//用户原创文件上传权限
			$api->group(['middleware'=>'can:userOri'], function ($api) {
				//文件上传之前进行检测 分片
				$api->get('upload', [
					//路由别名
					'as' => 'file.chunkNum',
					//
					'uses' => 'UploadController@chunkNum',
				]);
				//文件上传
				$api->post('upload', [
					//路由别名
					'as' => 'file.upload',
					//
					'uses' => 'UploadController@index',
				]);
				//文件上传 检测 api
				$api->post('uploadCheck', [
					//路由别名
					'as' => 'file.uploadCheck',
					//
					'uses' => 'UploadController@uploadCheck',
				]);
				//文件上传 进度 api
				$api->post('selectProgressByfileMd5', [
					//路由别名
					'as' => 'file.selectProgressByfileMd5',
					//
					'uses' => 'UploadController@selectProgressByfileMd5',
				]);
				//mergeChunks
				//合并请求的接口
				$api->post('mergeChunks', ['as' => 'file.mergeChunks', 'uses' => 'UploadController@mergeChunks',]);
				$api->post('checkIsUploaded', ['as' => 'file.checkIsUploaded', 'uses' => 'UploadController@checkIsUploaded',]);
				//用户资源列表
				$api->get('userOriFiles', ['as' => 'userOriFiles.index', 'uses' => 'UserOriFilesController@index',]);
				//获取一个原创的详情
				$api->get('userOriFiles/{userOriFile}', ['as' => 'userOriFiles.show', 'uses' => 'UserOriFilesController@show',]);
				//更新 一个用户原创的详情
				$api->put('userOriFiles/{userOriFile}', ['as' => 'userOriFiles.update', 'uses' => 'UserOriFilesController@update',]);
				//添加一个用户原创
				$api->post('userOriFiles', ['as' => 'userOriFiles.store', 'uses' => 'UserOriFilesController@store',]);
				//删除一个用户原创
				$api->delete('userOriFiles/{userOriFile}', ['as' => 'userOriFiles.destroy', 'uses' => 'UserOriFilesController@destroy',]);
			});

			//用户申请权限
			$api->group(['middleware'=>'can:userOri'], function ($api) {
				//用户原创列表
				$api->get('userOriTmps', ['as' => 'userOriTmp.index', 'uses' => 'UserOriTmpController@index',]);
				//获取一个原创的详情
				$api->get('userOriTmps/{userOriTmp}', ['as' => 'userOriTmp.show', 'uses' => 'UserOriTmpController@show',]);
				//更新 一个用户原创的详情
				$api->put('userOriTmps/{userOriTmp}', ['as' => 'userOriTmp.update', 'uses' => 'UserOriTmpController@update',]);
				//添加一个用户原创
				$api->post('userOriTmps', ['as' => 'userOriTmp.store', 'uses' => 'UserOriTmpController@store',]);
				//删除一个用户原创
				$api->delete('userOriTmps/{userOriTmp}', ['as' => 'userOriTmp.destroy', 'uses' => 'UserOriTmpController@destroy',]);
			});

			//用户权限
			$api->group(['middleware'=>'can:userRolePremission'], function ($api) {
				//用户权限 列表
				$api->get('userPremissions', ['as' => 'userPremissions.index', 'uses' => 'UserPremissionsController@index',]);
				//创建用户权限
				$api->post('userPremissions', ['as' => 'userPremissions.store', 'uses' => 'UserPremissionsController@store',]);
				$api->get('userPremissions/{userPremissions}',['as' => 'userPremissions.show', 'uses' => 'UserPremissionsController@show',]);
				//跟新一个用户权限
				$api->put('userPremissions/{userPremission}', ['as' => 'userPremissions.update', 'uses' => 'UserPremissionsController@update',]);
				$api->get('userPremissions/routers/{id}',['as'=>'userPremissions.router','uses'=>'UserPremissionsController@routers']);
				$api->post('userPremissions/routers/{id}',['as'=>'userPremissions.storeRouter','uses'=>'UserPremissionsController@storeRouter']);

				//用户角色列表
				$api->get('userRoles',['as' => 'userRoles.index', 'uses' => 'UserRolesController@index',]);
				$api->post('userRoles',['as' => 'userRoles.store', 'uses' => 'UserRolesController@store',]);
				$api->get('userRoles/{userRoles}',['as' => 'userRoles.show', 'uses' => 'UserRolesController@show',
				]);
				$api->put('userRoles/{userRoles}',['as' => 'userRoles.update', 'uses' => 'UserRolesController@update',]);

				//角色 权限
				$api->get('userRoles/{UserRole}/premissions',['as' => 'userRoles.premissions', 'uses' => 'UserRolesController@premissions',]);
				$api->post('userRoles/{UserRole}/premissions',['as' => 'userRoles.premissionStore', 'uses' => 'UserRolesController@premissionStore',
				]);

				$api->get('users',['as' => 'user.index', 'uses' => 'UserController@index',]);
				$api->get('user/{user_id}/roles',['as' => 'user.roles', 'uses' => 'UserController@roles',]);
				$api->post('user/{user_id}/roles',['as' => 'user.storeRoles', 'uses' => 'UserController@storeRoles',
				]);

				//目录
				$api->get('menus',['as' => 'menus.index', 'uses' => 'MenuController@index']);
				$api->delete('menus/{id}',['as' => 'menus.destory', 'uses' => 'MenuController@destory',]);
				$api->put('menus',['as' => 'menus.update', 'uses' => 'MenuController@update',]);
				$api->post('menus',['as' => 'menus.store', 'uses' => 'MenuController@store',]);

				$api->get('premissonResources/{id}',['as' => 'premissonResources.premissonResources', 'uses' => 'UserPremissionsResourcesController@premissonResources',]);
				$api->post('premissonResources',['as' => 'premissonResources.store', 'uses' => 'UserPremissionsResourcesController@store',]);

				//获取目录
				$api->get('userMenus',['as' => 'userMenus.index', 'uses' => 'MenuController@getMenu']);

				//前段路由模块
				$api->get('routers',['as'=>'routers.index','uses'=>'RouterController@index']);
				$api->get('routers/all',['as'=>'routers.all','uses'=>'RouterController@all']);
				$api->post('routers',['as'=>'routers.store','uses'=>'RouterController@store']);
				$api->get('createRouterMap',['as'=>'routers.createRouterMap','uses'=>'RouterController@createRouterMap']);
				$api->put('routers',['as'=>'routers.update','uses'=>'RouterController@update']);
			});

			//数据中心

            //博客的接口
            include "blogApi.php";

		});


	});

	$api->get('refreshToken', [
		//路由别名
		'as' => 'AppUserController.refreshToken',
		//
		'uses' => 'AppUserController@refreshToken',
	]);


	//测试接口 仅仅在开发环境能用
	// if (config('uploadFile.APP_ENV') == 'local') {
	// 	include_once "testApi.php";
	// }
	include_once "testApi.php";
	//管理员的接口 在前端 增加 帐号类型 就能 将 admin 和 普通的 user 进行整合
	//共用接口
	include "commoneApi.php";


});