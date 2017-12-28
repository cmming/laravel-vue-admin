<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/11
 * Time: 17:48
 */

//博客
$api->group(['middleware'=>'can:blog','namespace' => 'Blog',], function ($api) {
    //用户原创列表
    $api->get('blog/topics', ['as' => 'Topics.index', 'uses' => 'TopicController@index',]);
    //获取一个原创的详情
    $api->get('blog/topics/{id}', ['as' => 'Topics.show', 'uses' => 'TopicController@show',]);
    //更新 一个用户原创的详情
    $api->put('blog/topics/{id}', ['as' => 'Topics.update', 'uses' => 'TopicController@update',]);
    //添加一个用户原创
    $api->post('blog/topics', ['as' => 'Topics.store', 'uses' => 'TopicController@store',]);
    //删除一个用户原创
    $api->delete('blog/topics/{id}', ['as' => 'Topics.destroy', 'uses' => 'TopicController@destroy',]);


    //用户文章管理
    $api->get('blog/posts', ['as' => 'Post.index', 'uses' => 'PostController@index',]);
});