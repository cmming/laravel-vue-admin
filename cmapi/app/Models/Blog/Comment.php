<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/11
 * Time: 17:55
 */

namespace App\Models\Blog;


class Comment extends BaseModel
{
    protected $connection = 'mysql_blog';

    protected $table = 'comments';

    protected $fillable = ['content','post_id','user_id','p_comments_id','p_user_id'];


    //评论 的 用户 反向 关联
    public function user(){
        return $this->belongsTo('App\Models\Blog\User','user_id','id');
    }

    //回复的评论 自己关联自己 很强 不能在orm 中尝试使用 DB
    public function comments_reply(){
        return $this->hasMany('App\Models\Blog\Comment','p_comments_id','id');
    }

    // 关联 自己的 所回复的
//    public function comments(){
//        return $this->hasOne('App\Models\Blog\Comment','id','p_comments_id');
//    }

    public function comments_reply_user(){
        return $this->belongsTo('App\Models\Blog\User','p_user_id','id');
    }


}