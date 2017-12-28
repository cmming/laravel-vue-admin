@extends("blog.layout.main")

@section("content")

    <!-- 文章内容 -->
    <div class="post">
        <h2 class="title">
            {{$post['title']}}
            @if($post->user_id==\Auth::guard('blog')->id())
                <a title="编辑" style="margin: auto" href="{{ url('/blog/posts/'.$post->id.'/edit') }}">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
            @endif
            @if($post->user_id==\Auth::guard('blog')->id())
                <a title="删除" style="margin: auto"  href='javascript:if(confirm("确实要删除吗?"))location="{{ url('/blog/posts/'.$post->id.'/delete') }}"'>
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </a>
            @endif
        </h2>

        <div class="icons">
            {{--<a href="">--}}
                            {{--<span>--}}
                                {{--<i class="iconfont icon-cate"></i>后端</span>--}}
            {{--</a>--}}
            <span class="sm-hide hide-mobile">
                            <i class="iconfont icon-tag"></i>
                @foreach($post->topics as $topic)
                    <a href="{{url('/blog/posts/topic/'.$topic['id'])}}">
                                {{$topic['name']}}
                            </a>
                @endforeach
                    </span>
            <span class="sm-hide">
                            <i class="iconfont icon-see"></i>{{$post['page_view']}}</span>
            <span class="sm-hide">
                            <i class="iconfont icon-comment"></i>0</span>
            <!--<span class='sm-hide'><i class='iconfont icon-zan'></i>0</span>-->
            <span>
                            <i class="iconfont icon-time"></i>{{$post['updated_at']}}</span>
        </div>

        <div class="text-content-detail">
            {!! $post['content'] !!}
        </div>
    </div>

    <!-- 评论列表 -->
    <div class="comments-container">

        <div class="comments">
            <div class="comment-title">
                <h3>评论 {{count($comments)}}</h3>
                <!-- <div class="divider"></div> -->
            </div>
            @foreach($comments as $comment)
                <div class="panel panel-default">
                    <div class="panel-heading">
                                <span class="panel-title">
                                    {{--{{dd($comment->user)}}--}}
                                    <span class="comment-user">{{$comment->user->name}}</span>

                                    <span class="comment-time hide-mobile">在
                                        <span class="text-muted">{{$comment['created_at']}}</span>
                                    </span> 评论
                                </span>
                        <div class="pull-right">
                            <span class="comment_reply pointer"
                                  data-comment-user-name={{$comment->user->name}}
                                          data-comment-id= {{$comment['id']}}
                                  data-user-id= {{$comment['user_id']}}
                            >
                                回复
                            </span>
                        </div>
                    </div>
                    <div class="panel-body">
                        {{$comment['content']}}
                    </div>
                </div>
                {{--{{$comment->comments_reply()}}--}}
                @if(count($comment->comments_reply))
                    @foreach($comment->comments_reply as $comment_reply)
                        <div class="panel panel-default comment-left">
                            <div class="panel-heading">
                        <span class="panel-title">
                            <span class="comment-user">{{$comment_reply->user->name}}</span>

                            <span class="comment-time hide-mobile">在
                                <span class="text-muted">
                                    {{$comment_reply['created_at']}}
                                    {{--{{dd($comment_reply->comments_reply_user->name)}}--}}
                                </span>
                                回复</span>
                            {{$comment_reply->comments_reply_user->name}}
                            <div class="pull-right">
                                <span class="comment_reply pointer"
                                      data-comment-user-name={{$comment_reply->user->name}}
                                              data-comment-id= {{$comment['id']}}
                                      data-user-id= {{$comment_reply['user_id']}}
                                >
                                回复
                                </span>
                            </div>
                        </span>
                            </div>
                            <div class="panel-body">
                                {{$comment_reply['content']}}
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach

        </div>

        <!-- 提价评论 -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title pointer form-panel-title">发表评论</span>
                <div class="pull-right">
                    <span class="comment_post pointer">评论文章</span>
                </div>
            </div>
            <div class="panel-body">
                <form action="{{url('/blog/posts/'.$post->id.'/comments')}}" method="POST" class="form-horizontal"
                      role="form">
                    {{csrf_field()}}
                    <textarea name="content" id="comment" class="form-control comments-area" rows="3"
                              placeholder="登录后才能评论！！"></textarea>

                    @include('blog.layout.error')
                    <div class="btn-container ">
                        <!-- 表情 -->
                        <!-- 发表评论 -->
                        <button type="submit" class="btn btn-primary pull-right">发表</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section("js")

    <script>
        $('.comment_reply').on('click', function () {
            $('.p_comments_id').remove();
            $('.p_user_id').remove();
            $('form').append('<input class="p_comments_id" type="hidden" name="p_comments_id" value="' + $(this).attr('data-comment-id') + '"/>');
            $('form').append('<input class="p_user_id" type="hidden" name="p_user_id" value="' + $(this).attr('data-user-id') + '"/>');
            $('.form-panel-title').html('回复' + $(this).attr('data-comment-user-name'));
        });
        $('.comment_post').on('click', function () {
            $('.p_comments_id').remove();
            $('.p_user_id').remove();
            $('.form-panel-title').html('发表评论');
        });
    </script>

@endsection