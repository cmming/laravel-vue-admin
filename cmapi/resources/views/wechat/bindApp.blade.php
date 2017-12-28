@extends("wechat.layout.bind")

{{--@section("contents")--}}

<div class="sign-in-wrapper">
    <div class="sign-in-inner">
        <div class="login-brand text-center">
            <i class="fa fa-database m-right-xs"></i>
            App
            <strong class="text-skin">绑定帐号</strong>
        </div>

        <form action="{{url('/wechat/bindApp')}}" method="post">
            {{csrf_field()}}
            <div class="form-group m-bottom-md">
                <input name="name" type="text" class="form-control" placeholder="帐号">
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="密码">
            </div>

            @include('wechat.layout.error')
            <div class="m-top-md p-top-sm">
                <button type="submit" class="btn btn-default btn-block">绑定</button>
            </div>

        </form>
    </div><!-- ./sign-in-inner -->
</div><!-- ./sign-in-wrapper -->


{{--@section--}}
