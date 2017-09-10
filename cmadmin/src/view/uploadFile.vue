<template>
    <!--常用表单元素样式-->
    <!--通用导航条 -->
    <div>
        <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
        <div class="col-md-12">
            <div class="smart-widget widget-purple">
                <div class="smart-widget-header">
                    {{isUpdate?'修改视频信息':'添加视频'}}
                </div>
                <div class="smart-widget-inner">
                    <div class="smart-widget-body">
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

                        <!--为表单添加验证过滤-->
                        <form class="form-horizontal no-margin" @submit.prevent="validateBeforeSubmit">
                            <!-- <form class="form-horizontal no-margin"> -->

                            <div class="form-group">
                                <label class="control-label col-lg-2">用户名称：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('name:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="用户名称" name="name" v-model="formData.name">

                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('name'),'msg':[{'isShow':errors.has('name:required'),'msg':errors.first('name:required')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">注册邮箱：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('email:required'))}">
                                    <input autocomplete="off" v-validate="'required|email'" type="text" class="form-control input-sm" placeholder="邮箱" name="email" v-model="formData.email">

                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('email'),'msg':[{'isShow':errors.has('email:required'),'msg':errors.first('email:required')},{'isShow':errors.has('email:email'),'msg':errors.first('email:email')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="form-group" v-if="!isUpdate">
                                <label class="control-label col-lg-2">密码：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('password:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="密码" name="password" v-model="formData.password">

                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('password'),'msg':[{'isShow':errors.has('password:required'),'msg':errors.first('password:required')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /form-group -->
                            <div class="form-group">
                                <div class="text-center m-top-md col-lg-9">
                                    <button type="submit" class="btn btn-info">提交</button>
                                    <!-- <button type="button" @click="store" class="btn btn-info">提交</button> -->
                                    <button type="reset" class="btn btn-danger">重置</button>
                                </div>
                            </div>
                        </form>

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
            //isUpdate 
            isUpdate: 0,
            formData: {
                "name": "",
                "email": "",
                "password": ""
            },
            uploader: ''

        }
    },
    components: {
        'v-breadcrumb': breadcrumb,
        'v-errorMsg': errorMsg
    },

    //addTerm.vue
    created() {
        var route_path = this.$route.path;
        // this.formdata.update_id = update_id;
        if (route_path == '/files/add') {

            //查询该id的消息内容
            // var self = this;
            // var resData = { 'type': "getMsgById", 'dataform': JSON.stringify({'update_id':update_id})};
            // allAjax.msg.getMsg.call(this, resData, function (response) {
            //     if (response.data.code === "200") {
            //         self.isUpdate = 1;
            //         self.formdata.recvid = response.data.data.recvid.split('|');
            //         self.formdata.content = response.data.data.content;
            //         self.formdata.title = response.data.data.title;
            //     }else{
            //         self.$message({
            //             type:"warning",
            //             message:response.data.message
            //         });
            //     }
            // });

        } else {
            this.isUpdate = true;
            //查询 该用户 同时显示在页面上
            var resData = this.$route.params.id, self = this;
            allAjax.users.userShow.call(this, resData, function(response) {
                console.log(response);
                if (response.status == 200) {
                    self.formData.name = response.data.data.name;
                    self.formData.email = response.data.data.email;
                }
            });
        }
    },

    mounted() {
        this.$nextTick(function(){
            this.createUploader()
        })
    },
    methods: {
        createUploader() {
            var _this = this,
                $wrap = $('#uploader'),

                $list = $('#thelist'),
                state = 'ready';
            // state = 'uploading';

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
                auto: false,
                accept: {
                    title: 'Video',
                    extensions: 'mp4,wmv',
                    mimeTypes: 'video/*'
                }
            });
            var timer;
            clearInterval(timer);
            timer = setTimeout(function(){
            $('.webuploader-pick').on('click', function() {
                $(this).val('处理中..');
            });
            // 添加“添加文件”的按钮，
            // uploader.addButton('#filePicker2');


            // $('#cancle').on('click',function(){
            //     $('#dndArea').show();
            //     $('#btns').hide();
            //     $list.html('');
            // });
            $('#ctlBtn').on('click', function() {
                console.log(1);
                console.log(_this.uploader);
                if ($(this).hasClass('disabled')) {
                    return false;
                }

                if (state === 'ready') {
                    $(this).html('暂停上传');
                    _this.uploader.upload();
                    state = 'uploading';
                    console.log(state);
                } else if (state === 'paused') {
                    $(this).html('继续上传');
                    state = 'uploading';
                    _this.uploader.upload();
                    console.log(state);
                } else if (state === 'uploading') {
                    state = 'paused';
                    console.log(state);
                    _this.uploader.stop();
                }
            });

            _this.uploader.on('fileQueued', function(file) {
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

                // console.log(_this.uploader)
                // // 返回的是 promise 对象
                //   _this.uploader.md5File(file, 0, 1 * 1024 * 1024)

                //     // 可以用来监听进度
                //     .progress(function (percentage) {
                //       // console.log('Percentage:', percentage);
                //     })
                //     // 处理完成后触发
                //     .then(function (ret) {
                //       fileMd5 = ret;
                //     });
            });

            _this.uploader.onUploadBeforeSend = function(file, data) {
                // data.md5 = fileMd5;
                data.md5 = 'fileMd5';
                data.ext = file.file.ext;
            };


            _this.uploader.on('uploadProgress', function(file, percentage) {
                console.log(file);
                var $li = $('#' + file.id), $percent = $li.find('.progress .progress-bar');
                // if(percentage>=0.01)
                var percentageNum = (percentage * 100).toFixed(2)
                $li.find('p.state').text('上传中' + percentageNum + '%');
                $li.find('p.state em').text(percentageNum + '%')
                $percent.css('width', percentageNum + '%');
                $('#progress-bar').text(percentageNum + '%')
            });

            //上传成功
            _this.uploader.on('uploadSuccess', function(file) {
                $('#' + file.id).find('p.state').text('已上传');
            });
            //上传错误
            _this.uploader.on('uploadError', function(file) {
                $('#' + file.id).find('p.state').text('上传出错');
            });
            //上传完成
            _this.uploader.on('uploadComplete', function(file) {
                // $('#' + file.id).find('.progress').fadeOut();
                // location.reload();
            });
            
                let btn_top = $('#filePicker').height() - $('.webuploader-pick').siblings().eq(0).height();
            let btn_left = $('#filePicker').width() - $('.webuploader-pick').siblings().eq(0).width();

            $('.webuploader-pick').siblings().eq(0).css({ 'top': btn_top / 2, 'left': btn_left / 2 })
            console.log($('#filePicker').height(), $('.webuploader-pick').siblings().eq(0), btn_left);
            },500);
            
        },
        cancleUpload() {
            this.uploader = null
            
            this.$nextTick(function(){
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

        validateBeforeSubmit() {
            //添加
            if (!this.isUpdate) {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        var resData = this.formData;
                        var self = this;
                        allAjax.users.userStore.call(this, resData, function(response) {
                            console.log(response.status);
                            if (response.status == 201) {
                                self.$message({
                                    type: "success",
                                    message: '创建用户成功！'
                                });
                                window.location.href = '#/users'
                            }
                        });
                        return;
                    }
                    alert('未通过');
                });
            } else {
                //修改
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        var resData = this.formData;
                        resData._method = 'put';
                        var self = this;
                        allAjax.users.userUpdate.call(this, '/users/' + this.$route.params.id, resData, function(response) {
                            console.log(response.status);
                            if (response.status == 200) {
                                self.$message({
                                    type: "success",
                                    message: '用户信息修改成功！'
                                });
                                window.location.href = '#/users'
                            }
                        });
                        return;
                    }
                    alert('未通过');
                });
            }

        },
        //添加联系人
        addContact() {
            if (this.inlineRadio == "手机") {
                this.formdata.recvid.push(this.userTel);
            } else if (this.inlineRadio == "邮箱") {
                this.formdata.recvid.push(this.email);
            }
        },
        //删除联系人
        delRecvid(key) {
            this.formdata.recvid.splice(key, 1)
        }
    },


}

</script>
