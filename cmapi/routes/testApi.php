<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/16
 * Time: 15:42
 */
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
$api->get('test', [
	//路由别名
	'as' => 'test.test',
	//
	'uses' => 'TestController@test',
]);