<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/11
 * Time: 17:55
 */

namespace App\Models\Blog;


class Topic extends BaseModel
{
    protected $connection = 'mysql_blog';

    protected $table = 'topics';

    protected $fillable = ['name'];

    //获取 该类型下的所有文章
    public function posts(){
        return $this->belongsToMany('App\Models\Blog\Post','post_topic_rel','topic_id','post_id');
    }

}