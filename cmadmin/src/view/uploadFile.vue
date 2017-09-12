<template>
    <!--常用表单元素样式-->
    <!--通用导航条 -->
    <div>
        <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
        <div class="col-md-12">
            <div class="smart-widget widget-purple">
                <div class="smart-widget-header">
                    添加视频
                </div>
                <div class="smart-widget-inner">
                    <div class="smart-widget-body">
                        <div class="container">
                            <div id="uploader" class="wu-example col-lg-offset-1 col-lg-10">
                                <!--用来存放文件信息-->
                                <div id="thelist" class="uploader-list">
                                </div>
                                <div id="btns" style="display:none">
                                    <button id="ctlBtn" class="btn btn-success">开始上传</button>
                                    <button id="cancle" @click='cancleUpload' type="button" class="btn btn-danger marginTB-xs">重新选择</button>
                                </div>
                                <div class="queueList">
                                    <div id="dndArea" class="placeholder">
                                        <!-- <div id="filePicker" v-webUploader>选择文件</div> -->
                                        <div id="filePicker">选择文件</div>
                                        <p>或将视频拖到这里</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./smart-widget-inner -->
            </div>
            <!-- ./smart-widget -->
        </div>
    </div>
</template>

<script>
    // import * from '../assets/dist/webuploader.js'
    import '../assets/dist/static/style.css';
    import '../assets/dist/webuploader.css';
    import breadcrumb from '../components/common/breadcrumb.vue'
    import errorMsg from '../components/common/formError.vue'
    import allAjax from '../api/request.js'
    export default {
        data() {
            return {
                // 初始化导航栏数据
                toBreadcrumb: [
                    { path: 'main', name: '主页' },
                    { path: this.$route.path, name: this.$route.meta.title },
                ],
                uploader: null,
                fileMd5: '',
            }
        },
        components: {
            'v-breadcrumb': breadcrumb,
            'v-errorMsg': errorMsg
        },

        mounted() {
            this.$nextTick(function(){
            this.createUploader()
            })
        },
        methods: {
            createUploader() {
                console.log($('#thelist'));
                var _this = this,
                    $wrap = $('#uploader'),

                    $list = $('#thelist'),
                    state = 'pending';
                // state = 'uploading';
                //监听分块上传过程中的三个时间点  
                $.ajaxSetup({
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem("token")
                    }
                })
                WebUploader.Uploader.register({
                    "before-send-file": "beforeSendFile",
                    "before-send": "beforeSend",
                    "after-send-file": "afterSendFile",
                }, {
                        //时间点1：所有分块进行上传之前调用此函数  
                        beforeSendFile: function (file) {
                            var deferred = WebUploader.Deferred();
                            //1、计算文件的唯一标记，用于断点续传  
                            (new WebUploader.Uploader()).md5File(file, 0, 6 * 1024 * 1024 * 1024)
                                .progress(function (percentage) {
                                    $('.item').find("p.state").text("正在读取文件信息...");
                                })
                                .then(function (val) {
                                    _this.fileMd5 = val;

                                    $('.item').find("p.state").text("成功获取文件信息...");
                                    //获取文件信息后进入下一步  
                                    deferred.resolve();
                                });
                            return deferred.promise();
                        },
                        //时间点2：如果有分块上传，则每个分块上传之前调用此函数  
                        beforeSend: function (block) {
                            var deferred = WebUploader.Deferred();

                            $.ajax({
                                type: "POST",
                                cache: false,
                                async: false,  // 同步
                                url: "/api/uploadCheck",
                                data: {
                                    //文件唯一标记  
                                    fileMd5: _this.fileMd5,
                                    //当前分块下标  
                                    chunk: block.chunk,
                                    //当前分块大小  
                                    chunkSize: block.end - block.start
                                },
                                dataType: "json",
                                success: function (response) {
                                    //   console.log(response,response.ifExist);
                                    if (response.ifExist) {
                                        //分块存在，跳过  
                                        deferred.reject();

                                    } else {
                                        //分块不存在或不完整，重新发送该分块内容  
                                        deferred.resolve();
                                    }
                                }
                            });

                            this.owner.options.formData.fileMd5 = _this.fileMd5;
                            deferred.resolve();
                            return deferred.promise();
                        },
                        //时间点3：所有分块上传成功后调用此函数  
                        afterSendFile: function (file) {
                            console.log(file);
                            //如果分块上传成功，则通知后台合并分块  
                            $.ajax({
                                type: "POST",
                                url: "/api/mergeChunks",
                                data: {
                                    fileMd5: _this.fileMd5,
                                    chunks: file.blocks.length,
                                    ext: file.ext
                                },
                                success: function (response) {
                                    _this.$message({
                                        type: "success",
                                        message: '文件上传成功'
                                    });
                                }
                            });
                        }
                    });

                _this.uploader = WebUploader.create({
                    dnd: '#dndArea',
                    // swf文件路径
                    swf: '../assets/dist/Uploader.swf',
                    // swf: 'http://cdn.staticfile.org/webuploader/0.1.0/Uploader.swf',
                    // 文件接收服务端。
                    // server: './upload.php',
                    server: '/api/upload',
                    // 选择文件的按钮。可选。
                    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                    pick: '#filePicker',
                    paste: '#uploader',
                    chunked: true,
                    chunkSize: 2 * 1024 * 1024,
                    chunkRetry: 2, //如果某个分片由于网络问题出错，允许自动重传次数
                    auto: false,
                    accept: {
                        title: 'Video',
                        extensions: 'mp4,wmv,avi',
                        mimeTypes: 'video/*'
                    }
                });

                $('.webuploader-pick').on('click', function () {
                    $(this).val('处理中..');
                });
                // 添加“添加文件”的按钮，
                // uploader.addButton('#filePicker2');


                // $('#cancle').on('click',function(){
                //     $('#dndArea').show();
                //     $('#btns').hide();
                //     $list.html('');
                // });
                $('#ctlBtn').on('click', function () {
                    if ($(this).hasClass('disabled')) {
                        return false;
                    }

                    if (state === 'pending') {
                        $('#ctlBtn').text('暂停上传');
                        state = 'uploading';
                        _this.uploader.upload();
                    } else if (state === 'paused') {
                        state = 'uploading';
                        $('#ctlBtn').text('暂停上传');
                        _this.uploader.upload();
                    } else if (state === 'uploading') {
                        state = 'paused';
                        $('#ctlBtn').text('开始上传');
                        _this.uploader.stop(true);
                    }
                });

                _this.uploader.on('fileQueued', function (file) {
                    $('#dndArea').hide();
                    $('#btns').show();
                    console.log(file);
                    $list.append('<div id="' + file.id + '" class="item">' +
                        '<h4 class="info page-title m-bottom-md">' + file.name + '</h4>' +
                        '<p class="state">等待上传...</p>' +
                        '</div>');


                    var $li = $('#' + file.id), $percent = $li.find('.progress .progress-bar');


                    // 避免重复创建
                    if (!$percent.length) {
                        $percent = $('<div class="progress progress-striped active" >' +
                            '<div class="progress-bar" id="progress-bar" role="progressbar" >' +
                            '</div>' +
                            '</div>').appendTo($li).find('.progress-bar');
                    }
                });

                _this.uploader.onUploadBeforeSend = function (file, data, headers) {
                    // data.md5 = fileMd5;
                    //将文件MD5传给后台
                    data.md5 = _this.fileMd5;
                    headers.Authorization = 'Bearer ' + localStorage.getItem("token");
                    data.ext = file.file.ext;
                };

                _this.uploader.on('uploadProgress', function (file, percentage) {
                    var $li = $('#' + file.id), $percent = $li.find('.progress .progress-bar');
                    // if(percentage>=0.01)
                    var percentageNum = (percentage * 100).toFixed(2)
                    $li.find('p.state').text('上传中' + percentageNum + '%');
                    $li.find('p.state em').text(percentageNum + '%')
                    $percent.css('width', percentageNum + '%');
                    $('#progress-bar').text(percentageNum + '%')
                });

                // 当某个文件（分片）上传到服务端响应后 object file ret 服务端的相应值
                _this.uploader.on('uploadAccept', function (object, ret) {
                    // console.log(object, ret);
                    // $('#' + file.id).find('p.state').text('上传出错,请重新选择，我们支持续传！！');
                });

                //上传成功
                _this.uploader.on('uploadSuccess', function (file) {
                    $('.progress .progress-bar').css('width', 100 + '%');
                    $('#progress-bar').text(100 + '%');
                    $('#' + file.id).find('p.state').text('已上传');
                });
                //上传错误
                _this.uploader.on('uploadError', function (file) {
                    $('#' + file.id).find('p.state').text('上传出错,请重新选择，我们支持续传！！');
                });
                //上传完成
                _this.uploader.on('uploadComplete', function (file) {
                    // $('#' + file.id).find('.progress').fadeOut();
                    // location.reload();
                });
                //上传之前的错误触发
                _this.uploader.onError = function (code) {
                    switch (code) {
                        case 'Q_TYPE_DENIED':
                            self.$message({
                                type: "error",
                                message: 'Eroor: 文件格式错误！'
                            });
                            break;
                        case 'Q_EXCEED_SIZE_LIMIT':
                            alert('Eroor: ' + '文件格式超过最大值');
                            self.$message({
                                type: "error",
                                message: 'Eroor:文件格式超过最大值!'
                            });
                            break;
                        default:
                            break;
                    }
                };
                var timer;
                clearInterval(timer);
                timer = setTimeout(function () {
                    let btn_top = $('#filePicker').height() - $('.webuploader-pick').siblings().eq(0).height();
                    let btn_left = $('#filePicker').width() - $('.webuploader-pick').siblings().eq(0).width();

                    $('.webuploader-pick').siblings().eq(0).css({ 'top': btn_top / 2, 'left': btn_left / 2 })
                    console.log($('#filePicker').height(), $('.webuploader-pick').siblings().eq(0), btn_left);
                }, 500);

            },
            cancleUpload() {
                this.uploader.destroy();

                this.$nextTick(function () {
                    $('#dndArea').show();
                    $('#btns').hide();
                    $('#thelist').html('');
                    $('.queueList').html(`<div id="dndArea" class="placeholder">
                                    <!-- <div id="filePicker" v-webUploader>选择文件</div> -->
                                    <div id="filePicker">选择文件</div>
                                    <p>或将视频拖到这里</p>
                                </div>`);

                    this.createUploader()
                })
            },
        },


    }

</script>