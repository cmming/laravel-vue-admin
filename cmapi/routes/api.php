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
		$api->post('adminLogin', [
			//路由别名
			'as' => 'AppUserController.adminLogin',
			//
			'uses' => 'AppUserController@login',
		]);
		$api->get('adminLogout', [
			//路由别名
			'as' => 'AppUserController.adminLogout',
			//mergeChunks
			'uses' => 'AppUserController@logout',
		]);

		$api->post('adminRegister', [
			//路由别名
			'as' => 'AppUserController.adminRegister',
			//mergeChunks
			'uses' => 'AppUserController@store',
		]);

		$api->group(['middleware' => ['verifyToken', 'verifyTokenAfter']], function ($api) {




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
				$api->post('mergeChunks', [
					//路由别名
					'as' => 'file.mergeChunks',
					//
					'uses' => 'UploadController@mergeChunks',
				]);
				$api->post('checkIsUploaded', [
					//路由别名
					'as' => 'file.checkIsUploaded',
					//
					'uses' => 'UploadController@checkIsUploaded',
				]);
				//用户资源列表
				$api->get('userOriFiles', [
					//路由别名
					'as' => 'userOriFiles.index',
					//
					'uses' => 'UserOriFilesController@index',
				]);
				//获取一个原创的详情
				$api->get('userOriFiles/{userOriFile}', [
					//路由别名
					'as' => 'userOriFiles.show',
					//
					'uses' => 'UserOriFilesController@show',
				]);
				//更新 一个用户原创的详情
				$api->put('userOriFiles/{userOriFile}', [
					//路由别名
					'as' => 'userOriFiles.update',
					//
					'uses' => 'UserOriFilesController@update',
				]);
				//添加一个用户原创
				$api->post('userOriFiles', [
					//路由别名
					'as' => 'userOriFiles.store',
					//
					'uses' => 'UserOriFilesController@store',
				]);
				//删除一个用户原创
				$api->delete('userOriFiles/{userOriFile}', [
					//路由别名
					'as' => 'userOriFiles.destroy',
					//
					'uses' => 'UserOriFilesController@destroy',
				]);
			});

			//用户申请权限
			$api->group(['middleware'=>'can:userOri'], function ($api) {
				//用户原创列表
				$api->get('userOriTmps', [
					//路由别名
					'as' => 'userOriTmp.index',
					//
					'uses' => 'UserOriTmpController@index',
				]);
				//获取一个原创的详情
				$api->get('userOriTmps/{userOriTmp}', [
					//路由别名
					'as' => 'userOriTmp.show',
					//
					'uses' => 'UserOriTmpController@show',
				]);
				//更新 一个用户原创的详情
				$api->put('userOriTmps/{userOriTmp}', [
					//路由别名
					'as' => 'userOriTmp.update',
					//
					'uses' => 'UserOriTmpController@update',
				]);
				//添加一个用户原创
				$api->post('userOriTmps', [
					//路由别名
					'as' => 'userOriTmp.store',
					//
					'uses' => 'UserOriTmpController@store',
				]);
				//删除一个用户原创
				$api->delete('userOriTmps/{userOriTmp}', [
					//路由别名
					'as' => 'userOriTmp.destroy',
					//
					'uses' => 'UserOriTmpController@destroy',
				]);
			});

			//用户权限
			$api->group(['middleware'=>'can:userRolePremission'], function ($api) {
				//用户权限 列表
				$api->get('userPremissions', [
					//路由别名
					'as' => 'userPremissions.index',
					//
					'uses' => 'userPremissionsController@index',
				]);
				//创建用户权限
				$api->post('userPremissions', [
					//路由别名
					'as' => 'userPremissions.store',
					//
					'uses' => 'userPremissionsController@store',
				]);
				$api->get('userPremissions/{userPremissions}',[
					//路由别名
					'as' => 'userPremissions.show',
					//
					'uses' => 'userPremissionsController@show',
				]);
				//跟新一个用户权限
				$api->put('userPremissions/{userPremission}', [
					//路由别名
					'as' => 'userPremissions.update',
					//
					'uses' => 'userPremissionsController@update',
				]);

				//用户角色列表
				$api->get('userRoles',[
					//路由别名
					'as' => 'userRoles.index',
					//
					'uses' => 'userRolesController@index',
				]);
				$api->post('userRoles',[
					//路由别名
					'as' => 'userRoles.store',
					//
					'uses' => 'userRolesController@store',
				]);
				$api->get('userRoles/{userRoles}',[
					//路由别名
					'as' => 'userRoles.show',
					//
					'uses' => 'userRolesController@show',
				]);
				$api->put('userRoles/{userRoles}',[
					//路由别名
					'as' => 'userRoles.update',
					//
					'uses' => 'userRolesController@update',
				]);

				//角色 权限
				$api->get('userRoles/{UserRole}/premissions',[
					//路由别名
					'as' => 'userRoles.premissions',
					//
					'uses' => 'userRolesController@premissions',
				]);
				$api->post('userRoles/{UserRole}/premissions',[
					//路由别名
					'as' => 'userRoles.premissionStore',
					//
					'uses' => 'userRolesController@premissionStore',
				]);

				$api->get('users',[
					'as' => 'user.index',
					//
					'uses' => 'UserController@index',
				]);
				$api->get('user/{user_id}/roles',[
					'as' => 'user.roles',
					//
					'uses' => 'UserController@roles',
				]);
				$api->post('user/{user_id}/roles',[
					'as' => 'user.storeRoles',
					//
					'uses' => 'UserController@storeRoles',
				]);

				//目录
				$api->get('menus',[
					//路由别名
					'as' => 'menus.index',
					//
					'uses' => 'MenuController@index',
				]);
				$api->delete('menus/{id}',['as' => 'menus.destory', 'uses' => 'MenuController@destory',]);
				$api->put('menus',['as' => 'menus.update', 'uses' => 'MenuController@update',]);
				$api->post('menus',['as' => 'menus.store', 'uses' => 'MenuController@store',]);

				$api->get('premissonResources/{id}',['as' => 'premissonResources.premissonResources', 'uses' => 'userPremissionsResourcesController@premissonResources',]);
				$api->post('premissonResources',['as' => 'premissonResources.store', 'uses' => 'userPremissionsResourcesController@store',]);


				$api->get('userMenus',['as' => 'userMenus.index', 'uses' => 'MenuController@getMenu',]);
			});

			//数据中心

		});


	});

	$api->get('refreshToken', [
		//路由别名
		'as' => 'AppUserController.refreshToken',
		//
		'uses' => 'AppUserController@refreshToken',
	]);

	//测试接口 仅仅在开发环境能用
	if (config('uploadFile.APP_ENV') == 'local') {
		include_once "testApi.php";
	}
	//管理员的接口 在前端 增加 帐号类型 就能 将 admin 和 普通的 user 进行整合
	//共用接口
	include "commoneApi.php";
});