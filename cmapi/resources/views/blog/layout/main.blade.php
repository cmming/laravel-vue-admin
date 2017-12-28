<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>开放博客平台-陈明</title>
    <link rel="stylesheet" href="{{ URL::asset('/blog/static/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('/blog/static/share/css/share.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('/blog/css/base.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('/blog/css/simplify.min.css')}}">
    <script src="{{ URL::asset('/blog/static/jquery/jquery.min.js')}}"></script>
    <script src="{{ URL::asset('/blog/static/bootstrap/js/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_470811_x0xuuy2egnzh0k9.css">

</head>

<body>
<!-- 导航栏 -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- <div class="container-fluid"> -->
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1"
                    aria-expanded="false">
                <span class="sr-only">导航按钮</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{--<a class="navbar-brand" href="#">网站商标</a>--}}
            <a class="navbar-brand" href="{{url('/blog/posts')}}">
                <img src="{{ URL::asset('/blog/images/king.jpg')}}" alt="" class="img-responsive center-block">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                {{--<li class="active">--}}
                <li>
                    <a href="{{url('/blog/posts')}}">
                        首页
                    </a>
                </li>
                <li>
                    <a href="{{url('/blog/posts/add')}}">写文章</a>
                </li>
                <li>
                    <a href="#">通知</a>
                </li>
            </ul>
            <!-- 右侧的 -->
            <ul class="nav navbar-nav navbar-right">
                {{--<li>--}}
                    {{--<a href="#">友情连接</a>--}}
                {{--</li>--}}
                {{--是否登录--}}
                @if(!\Auth::guard('blog')->check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">未登录
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{url('/blog/signIn')}}">登录</a>
                            </li>
                            <li>
                                <a href="{{url('/blog/signUp')}}">注册</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">{{\Auth::guard('blog')->user()->name}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/blog/user/'.\Auth::guard('blog')->id())}}">我的主页</a></li>
                            <li><a href="{{url('/blog/user/me/setting')}}">个人设置</a></li>
                            <li><a href="{{url('/blog/logout')}}">登出</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<!-- 页面的主题部分 -->
<section class="container post-main">

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <!-- 文章内容 -->
            @yield("content")

        </div>


        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 hide-mobile ">
            <div class="panel panel-default">
                <div class="panel-heading">快速分享</div>
                <div class="panel-body">
                    <div class="share-container">
                        <div class="social-share" data-sites="wechat,weibo,qq,qzone,tencent"></div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">专题</div>
                <div class="panel-body">
                    @foreach($topics as $topic)
                        <a href="{{url('/blog/posts/topic/'.$topic['id'])}}" class="btn btn-xs btn-link btn-tags">{{$topic['name']}}</a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @yield("pagenation")
        </div>
    </div>


</section>
<!-- 页面的底部 -->
<style>
    .footer-container {
        display: block;
        text-align: center;
        height: auto;
    }

    .footer-container .infos {
        line-height: 52px;
        margin-top: 32px;
        margin-bottom:10px;
    }

    .footer-container .links {
        margin: 0 auto;
        max-width: 600px;
        line-height: 26px;
        margin-bottom:32px;
    }

    .footer-container .links a {
        margin-left: 10px;
    }
</style>
<footer>
    <div class="col-xs-12 footer-container">
        <div class="infos">
            Design by Chmi 鄂ICP备17016476号                </div>
        <div class="links">
            <a target="_blank" href="http://lgair.cn/" title="云挂机" class="">云挂机</a>
            <a target="_blank" href="http://chenming.club/wedding/" title="蓝光 vr婚庆" class="">蓝光 vr婚庆 </a>
            <a target="_blank" href="http://www.17huang.com/" title="一起晃手游网" class="">一起晃手游网 </a>

        </div>
    </div>
</footer>
<script src="{{ URL::asset('blog/static/share/js/jquery.share.min.js')}}"></script>

@yield("js")
</body>

</html>