<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 13:21
 */

namespace App\Http\Controllers\Blog;

use App\Models\Blog\Topic;

class TopicController extends BaseController
{

    protected $topic = '';


    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function posts(Topic $topic)
    {
        $posts = $topic->posts()->paginate(2);
//        dd($posts->total());

        return view('blog/post/index',compact('posts'));
    }

}