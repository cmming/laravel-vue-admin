<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10
 * Time: 16:39
 */


namespace App\Models\Blog;


class Post extends BaseModel
{
    protected $connection = 'mysql_blog';

    protected $table = 'posts';

    protected $fillable = ['title', 'content', 'user_id','page_view'];

    //获取 文章的所有 类型

    public function topics(){
        return $this->belongsToMany('App\Models\Blog\Topic','post_topic_rel','post_id','topic_id');
    }
    //保存 文章的 类型

    public function storeTopic($topic){
        return $this->topics()->save($topic);
    }
    // 删除 文章的类型
    public function deleteTopic($topic){
        return $this->topics()->detach($topic);
    }



    //获取文章所有的回复
    public function comments(){
        return $this->hasMany('App\Models\Blog\Comment','post_id','id')->where('p_comments_id','=',null);
    }
}