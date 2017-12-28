<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 13:21
 */

namespace App\Http\Controllers\Blog;

use App\Models\Blog\Comment;

class CommentController extends BaseController
{

    protected $comment = '';


    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }



}