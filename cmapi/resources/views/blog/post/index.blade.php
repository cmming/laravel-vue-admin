@extends("blog.layout.main")

@section("content")
    @if($posts->total())

        @foreach($posts as $post)
            <div class="post">
                <a href="{{url('/blog/posts/'.$post->id)}}">
                    <h2 class="title">{{str_limit($post['title'],40)}}</h2>
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
                            <i class="iconfont icon-time"></i>{{$post['created_at']}}</span>
                </div>
                <div class="text-content">
                    {{--{{str_limit({!!$post['content']!!},100)}}--}}

                </div>
            </div>
        @endforeach

    @else
        <div class="alert alert-danger bg-white">
            {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
            {{--<strong>Title!</strong>--}}
            没有数据！！
        </div>

    @endif


@endsection




@section("pagenation")


    {{$posts->links()}}


@endsection
