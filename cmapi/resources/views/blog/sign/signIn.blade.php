@extends("blog.layout.sign")

{{--@section("contents")--}}

    <div class="sign-in-wrapper">
        <div class="sign-in-inner">
            <div class="login-brand text-center">
                <i class="fa fa-database m-right-xs"></i>
              Blog
                <strong class="text-skin">登录</strong>
            </div>

            <form action="{{url('/blog/signIn')}}" method="post">
                {{csrf_field()}}
                <div class="form-group m-bottom-md">
                    <input name="email" type="text" class="form-control" placeholder="邮箱">
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="密码">
                </div>

                <div class="form-group">
                    <div class="custom-checkbox">
                        <input name="is_remember" type="checkbox" id="chkRemember">
                        <label for="chkRemember"></label>
                    </div>
                    记住密码
                </div>
                @include('blog.layout.error')
                <div class="m-top-md p-top-sm">
                    <button type="submit" class="btn btn-default btn-block">登录</button>
                </div>

                <div class="m-top-md p-top-sm">
                    <div class="font-12 text-center m-bottom-xs">
                        <a href="#" class="font-12">忘记密码 ?</a>
                    </div>
                    <div class="font-12 text-center m-bottom-xs">没有帐号?</div>
                    <a href="{{url('/blog/signUp')}}" class="btn btn-default block">创建一个帐号</a>
                </div>
            </form>
        </div><!-- ./sign-in-inner -->
    </div><!-- ./sign-in-wrapper -->


{{--@section--}}
