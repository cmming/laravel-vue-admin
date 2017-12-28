@extends("blog.layout.main")

@section("content")
<div class="post">
    <form class="form-horizontal" action="{{url('/blog/user/me/setting')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                <input class="form-control" name="name" type="text" value="{{$me->name}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">邮箱</label>
            <div class="col-sm-10">
                <input class="form-control" name="email" type="text" value="{{$me->email}}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-lg-offset-2">
                @include('blog.layout.error')
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-lg-offset-2">
                <button type="submit" class="btn btn-default">修改</button>
            </div>
        </div>
    </form>
</div>


@endsection