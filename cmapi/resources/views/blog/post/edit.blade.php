<script src="{{ URL::asset('/blog/static/tinymce/tinymce.min.js')}}"></script>
@extends("blog.layout.main")
@section("content")
    <!-- 文章添加 -->
    <form class="form-horizontal" action="{{url('/blog/posts/'.$post->id)}}" method="POST">
        <!--form 表单不支持 PUT 这里使用 method_field("PUT")让表单 进行支持put 方式  -->
        {{method_field("PUT")}}
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-lg-2 control-label">标题</label>
            <div class="col-lg-10">
                <input name="title" type="text" class="form-control" placeholder="这里是标题" value="{{$post->title}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label">文章类型</label>

            <div class="col-lg-10">
                @foreach($topics as $topic)
                    <div class="checkbox inline-block">
                        <div class="custom-checkbox">
                            <input name="topics[]" type="checkbox" id={{'inlineCheckbox'.$topic['id']}} class="checkbox-grey"
                                   @if(in_array($topic['id'],$postTopics))
                                   checked="checked"
                                   @endif
                                   value={{$topic['id']}}>
                            <label for={{'inlineCheckbox'.$topic['id']}}></label>
                        </div>
                        <div class="inline-block vertical-top">
                            {{$topic['name']}}
                        </div>
                    </div>
                @endforeach

            </div><!-- /.col -->
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label">内容</label>
            <div class="col-lg-10">
            <textarea id="content" name="content" class="form-control" style="height:400px;max-height:500px;"
                      placeholder="这里是内容">{{$post->content}}</textarea>
            </div>
        </div>
        <div class="col-lg-offset-2 col-lg-10">
            @include('blog.layout.error')
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>

    </form>

    <script>
        tinyMCE.init({

            selector: 'textarea',
            height: '300px',
            //汉化
            language: 'zh_CN',
            plugins: 'advlist,autolink,code,paste,textcolor, colorpicker,fullscreen,link,lists,media,wordcount, imagetools',

        });
    </script>
@endsection

