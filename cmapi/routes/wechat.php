<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17
 * Time: 14:59
 */



Route::any('/wechat', '\App\Http\Controllers\WeChat\WeChatController@serve');



//Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    //获取用户信息
    Route::get('/wechat/user', '\App\Http\Controllers\WeChat\WeChatController@user');
    //绑定app 帐号
    Route::get('/wechat/bindApp', '\App\Http\Controllers\WeChat\WeChatController@bindApp');

    Route::post('/wechat/bindApp', '\App\Http\Controllers\WeChat\WeChatController@bindAppStore');

    //发送消息接口
    Route::post('/wechat/userMsgs', '\App\Http\Controllers\WeChat\WeChatController@userMsgs');

//});