<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10
 * Time: 16:34
 */

namespace App\Http\Controllers\Blog;

use App\Models\Blog\Post;
use App\Models\Blog\Topic;
use App\Models\Blog\Comment;

class PostController extends BaseController
{
    protected $post = '';
    protected $topic = '';

    public function __construct(Post $post, Topic $topic, Comment $comment)
    {
        $this->post = $post;
        $this->topic = $topic;
        $this->comment = $comment;
    }

    //获取博客文章的 列表
    public function index()
    {
        //获取 分页的 文章
        $posts = $this->post->orderBy('created_at', 'desc')->withCount(['comments'])->paginate(6);
        if(request('page')>$posts->lastPage()){
            return back();
        }else{
            return view('blog/post/index', compact('posts'));
        }
    }

    //文章 详情
    public function detail(Post $post)
    {

        //使用 模型 不能跟新 所以使用 DB 门脸类
        \DB::connection('mysql_blog')
            ->table('posts')
            ->where('id', $post['id'])
            ->update(['page_view' => ($post['page_view'] + 1)]);

        //将 所有的评论 反给 文章
        $comments = $post->comments;


        return view('blog/post/detail', compact('post', 'comments'));
    }

    public function add()
    {

        //获取所有的文章类型
        $topics = $this->topic->all();


        return view('blog/post/add', compact('topics'));
    }

    public function store()
    {
        if (!\Auth::guard('blog')->check()) {
            return \Redirect::back()->withErrors("必须登录才能写文章！");
        }
        $this->validate(request(), [
            'title' => 'required|string|max:100|min:3',
            'content' => 'required|string|min:10',
            'topics' => 'required|array'
        ]);

        // 添加用户
        $user_id = \Auth::guard('blog')->id();
        $parpams = array_merge(request(['title', 'content']), compact('user_id'));
        $post = $this->post->create($parpams);

        //选中的类型
        $checkTopics = $this->topic->findMany(request('topics'));


        foreach ($checkTopics as $checkTopic) {
            $post->storeTopic($checkTopic);
        }

        return redirect("/blog/posts");
    }

    public function edit(Post $post)
    {
        if($post->user_id!=\Auth::guard('blog')->id()){
            return \Redirect::back();
        }

        //获取所有的文章类型
        $topics = $this->topic->all();

        //这篇 文章的类型
        $postTopics = $post->topics()->get(['post_topic_rel.topic_id']);

        $postTopics = array_column($postTopics->toArray(), 'topic_id');

//        dd($postTopics,$topics->toArray());

        return view('blog/post/edit', compact('post', 'topics', 'postTopics'));
    }

    public function update(Post $post)
    {
        if (!\Auth::guard('blog')->check()) {
            return \Redirect::back()->withErrors("必须登录才能写文章！");
        }
        // 数据验证
        $this->validate(request(), [
            'title' => 'required|max:255|min:4',
            'content' => 'required|min:10',
            'topics' => 'required|array'
        ]);

        // 编辑权限的添加
//        $this->authorize('update',$post);
        if($post->user_id!=\Auth::guard('blog')->id()){
            return \Redirect::back()->withErrors("不能修改别人的文章！");
        }

        //选中的类型
        $checkTopics = $this->topic->findMany(request('topics'));
        //该文章拥有的类型
        $postTopics = $post->topics;

//        dd($checkTopics,$postTopics);

        //添加的 文章类型
        $addPostTopics = $checkTopics->diff($postTopics);
        foreach ($addPostTopics as $addPostTopic) {
            $post->storeTopic($addPostTopic);
        }

        //删除 的文章类型
        $deletePostTopics = $postTopics->diff($checkTopics);

        foreach ($deletePostTopics as $deletePostTopic) {
            $post->deleteTopic($deletePostTopic);
        }
//        dd(request(['title', 'content']));
        $post->update(request(['title', 'content']));
        return redirect("/blog/posts");
    }

    public function commentsStore(Post $post)
    {
        // 权限验证
        if (!\Auth::guard('blog')->check()) {
            return \Redirect::back()->withErrors("必须登录才能评论！");
        }


        // 提交
        // 处理数据
        $params = ['user_id' => \Auth::guard('blog')->id(), 'post_id' => $post['id']] + request(['content','p_comments_id','p_user_id']);

        $this->comment->create($params);
        // 重定向

        return back();
    }

    public function delete(Post $post){

        $post->delete();
        return redirect("/blog/posts");
    }


}