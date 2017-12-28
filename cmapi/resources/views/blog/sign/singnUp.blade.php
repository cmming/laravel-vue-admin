@extends("blog.layout.sign")

{{--@section("contents")--}}


    <div class="sign-in-wrapper">
        <div class="sign-in-inner">
            <div class="login-brand text-center">
                <i class="fa fa-database m-right-xs"></i>
                Blog
                <strong class="text-skin">注册</strong>
            </div>

            <form action="{{url('/blog/signUp')}}" method="post">
                {{csrf_field()}}
                <div class="form-group m-bottom-md">
                    <input name="name" type="text" class="form-control" placeholder="名称">
                </div>
                <div class="form-group m-bottom-md">
                    <input name="email" type="text" class="form-control" placeholder="邮箱">
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="密码">
                </div>
                <div class="form-group">
                    <input name="password_confirmation" type="password" class="form-control" placeholder="确认密码">
                </div>
                {{--<div class="form-group">--}}
                    {{--<div class="custom-checkbox">--}}
                        {{--<input type="checkbox" id="chkAccept">--}}
                        {{--<label for="chkAccept"></label>--}}
                    {{--</div>--}}
                    {{--同意协议--}}
                {{--</div>--}}
                @include('blog.layout.error')
                <div class="m-top-md p-top-sm">
                    <button type="submit" class="btn btn-default btn-block">注册</button>
                </div>

                <div class="m-top-md p-top-sm">
                    <div class="font-12 text-center m-bottom-xs">拥有帐号?</div>
                    <a href="{{url('/blog/signIn')}}" class="btn btn-default block">登录</a>
                </div>
            </form>
        </div>
        <!-- ./sign-in-inner -->
    </div>



{{--@section--}}