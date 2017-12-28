@extends("blog.layout.main")

@section("content")

    <div class="post">
        <blockquote>
            <p>
                {{$user->name}}
            </p>
            <footer>
                {{--关注：4｜粉丝：0｜--}}
                文章：{{$user->posts_count}}
            </footer>
        </blockquote>
    </div>
    <div class="post">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_1" data-toggle="tab" aria-expanded="true">文章</a>
                </li>
                {{--<li class="">--}}
                {{--<a href="#tab_2" data-toggle="tab" aria-expanded="false">关注</a>--}}
                {{--</li>--}}
                {{--<li class="">--}}
                {{--<a href="#tab_3" data-toggle="tab" aria-expanded="false">粉丝</a>--}}
                {{--</li>--}}
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    @if(!count($posts))
                        <div class="m-top-md">
                            没有发布文章。
                        </div>
                    @endif
                    @foreach($posts as $post)
                        <div class="post">
                            <a href="{{url('/blog/posts/'.$post->id)}}">
                                <h2 class="title inline-block">{{str_limit($post['title'],40)}}</h2>
                            </a>
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
                            <i class="iconfont icon-comment"></i>{{$post->comments_count}}</span>
                                <!--<span class='sm-hide'><i class='iconfont icon-zan'></i>0</span>-->
                                <span>
                            <i class="iconfont icon-time"></i>{{$post['created_at']->diffForHumans()}}</span>
                            </div>
                            <div class="text-content">
                                {{--{{str_limit({!!$post['content']!!},100)}}--}}

                            </div>
                        </div>
                    @endforeach
                    {{$posts->links()}}
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="blog-post" style="margin-top: 30px">
                        <p class="">Jadyn Medhurst Jr.</p>
                        <p class="">关注：1 | 粉丝：1｜ 文章：0</p>

                        <div>
                            <button class="btn btn-default like-button" like-value="1" like-user="6"
                                    _token="MESUY3topeHgvFqsy9EcM916UWQq6khiGHM91wHy"
                                    type="button">取消关注
                            </button>
                        </div>

                    </div>
                    <div class="blog-post" style="margin-top: 30px">
                        <p class="">Mrs. Felicita D&#039;Amore DVM</p>
                        <p class="">关注：0 | 粉丝：1｜ 文章：1</p>

                        <div>
                            <button class="btn btn-default like-button" like-value="1" like-user="55"
                                    _token="MESUY3topeHgvFqsy9EcM916UWQq6khiGHM91wHy"
                                    type="button">取消关注
                            </button>
                        </div>

                    </div>
                    <div class="blog-post" style="margin-top: 30px">
                        <p class="">Maybell VonRueden</p>
                        <p class="">关注：0 | 粉丝：2｜ 文章：0</p>

                        <div>
                            <button class="btn btn-default like-button" like-value="1" like-user="3"
                                    _token="MESUY3topeHgvFqsy9EcM916UWQq6khiGHM91wHy"
                                    type="button">取消关注
                            </button>
                        </div>

                    </div>
                    <div class="blog-post" style="margin-top: 30px">
                        <p class="">Miss Melyssa Bogan DDS</p>
                        <p class="">关注：2 | 粉丝：2｜ 文章：3</p>

                        <div>
                            <button class="btn btn-default like-button" like-value="1" like-user="2"
                                    _token="MESUY3topeHgvFqsy9EcM916UWQq6khiGHM91wHy"
                                    type="button">取消关注
                            </button>
                        </div>

                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>


    </div>

@endsection