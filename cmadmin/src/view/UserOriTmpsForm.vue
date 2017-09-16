<template>
    <!--常用表单元素样式-->
    <!--通用导航条 -->
    <div>
        <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
        <div class="col-md-12">
            <div class="smart-widget widget-purple">
                <div class="smart-widget-header">
                    {{isUpdate?'修改发布的资源':'添加发布资源'}}
                </div>
                <div class="smart-widget-inner">
                    <div class="smart-widget-body">

                        <div class="modal fade" :class="{'show_block in':isShowVideo}" id="largeModal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span @click="closeAndChoseModel" aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                                        <h4 class="modal-title">视频选取免费时间</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- <div class="row m-bottom-lg">
                                                <div class="col-lg-offset-2 col-lg-8"> -->
                                        <video-player class="video-player-box" ref="videoPlayer" :options="playerOptions" customEventName="customstatechangedeventname"
                                            @pause="onPlayerPause($event)">
                                        </video-player>
                                        <!-- </div>
                                            </div> -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="closeAndChoseModel">关闭</button>
                                        <button type="button" class="btn btn-primary" @click="closeAndChoseModel">选中</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!--为表单添加验证过滤-->
                        <form class="form-horizontal no-margin" @submit.prevent="validateBeforeSubmit">
                            <!-- <form class="form-horizontal no-margin"> -->

                            <div class="form-group">
                                <label class="col-lg-2 control-label">资源类型：</label>
                                <div class="col-lg-10">
                                    <div class="radio inline-block">
                                        <div class="custom-radio m-right-xs">
                                            <input type="radio" id="tid2" value="2" v-model="formData.tid" name="tid" v-validate="'required|in:2,4'">
                                            <label for="tid2"></label>
                                        </div>
                                        <div class="inline-block vertical-top">普通视频</div>
                                    </div>
                                    <div class="radio inline-block">
                                        <div class="custom-radio m-right-xs">
                                            <input type="radio" id="tid4" name="tid" value="4" v-model="formData.tid">
                                            <label for="tid4"></label>
                                        </div>
                                        <div class="inline-block vertical-top">VR视频</div>
                                    </div>

                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('tid'),'msg':[{'isShow':errors.has('tid'),'msg':errors.first('tid:required')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">是否分屏：</label>
                                <div class="col-lg-10">
                                    <div class="radio inline-block">
                                        <div class="custom-radio m-right-xs">
                                            <input type="radio" id="be_fp0" value="0" v-model="formData.att.be_fp" name="be_fp" v-validate="'required|in:0,1'">
                                            <label for="be_fp0"></label>
                                        </div>
                                        <div class="inline-block vertical-top">分屏</div>
                                    </div>
                                    <div class="radio inline-block">
                                        <div class="custom-radio m-right-xs">
                                            <input type="radio" id="be_fp1" name="be_fp" value="1" v-model="formData.att.be_fp">
                                            <label for="be_fp1"></label>
                                        </div>
                                        <div class="inline-block vertical-top">不分屏</div>
                                    </div>

                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('tid'),'msg':[{'isShow':errors.has('tid'),'msg':errors.first('tid:required')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">资源标题：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('title:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="资源标题" name="title"
                                        v-model="formData.title">
                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('title'),'msg':[{'isShow':errors.has('title:required'),'msg':errors.first('title:required')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <!-- <div class="form-group">
                                <label class="control-label col-lg-2">文件的名称：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('fname:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="文件的名称" name="fname"
                                        v-model="formData.fname">
                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('fname'),'msg':[{'isShow':errors.has('fname:required'),'msg':errors.first('fname:required')}]}">
                                    </v-errorMsg>
                                </div>
                            </div> -->

                            <div class="form-group">
                                <label class="col-lg-2 control-label">资源介绍</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('des:required'))}">
                                    <textarea v-validate="'required'" class="form-control" rows="3" name="des" v-model="formData.des"></textarea>

                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('des'),'msg':[{'isShow':errors.has('des:required'),'msg':errors.first('des:required')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">收费金额：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('des:required'))}">
                                    <input autocomplete="off" v-validate="'required|numeric'" type="text" class="form-control input-sm" placeholder="收费金额（单位：元）"
                                        name="fee" v-model="formData.att.fee">

                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('fee'),'msg':[{'isShow':errors.has('fee:required'),'msg':errors.first('fee:required')},{'isShow':errors.has('fee:numeric'),'msg':errors.first('fee:numeric')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">免费观看时间：</label>
                                <div :class="{'col-lg-4': true, 'has-error': (errors.has('des:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="免费观看时间" name="free_time"
                                        v-model="formData.att.free_time" disabled>
                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('free_time'),'msg':[{'isShow':errors.has('free_time:required'),'msg':errors.first('free_time:required')}]}">
                                    </v-errorMsg>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-success" @click="isShowVideo=true">请选择视频时间</button>
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

<style>
    .video-player.video-player-box>div {
        width: auto;
    }

    .vjs-big-play-button {
        display: none !important;
    }
</style>

<script>
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
                    "vid": this.$route.params.id,
                    "tid": "",
                    "title": "",
                    // "fname": "",
                    "des": "",
                    "att": {
                        "fee": "",
                        "free_time": "",
                        "be_fp": ""
                    }
                },
                //视频播放参数
                playerOptions: {
                    muted: true,
                    language: 'zh',
                    playbackRates: [0.7, 1.0, 1.5, 2.0],
                    sources: [{
                        type: "video/mp4",
                        src: ""
                    }],
                    // poster: "/static/images/author.jpg",
                },
                isShowVideo: false,

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
            if (route_path.indexOf('/UserOriFiles/add') != -1 && (this.$route.params.id)) {

                //查询该id的 相关资源的基本信息
                var self = this;
                var resData = this.$route.params.id, self = this;
                allAjax.userOriFiles.show.call(this, resData, function (response) {
                    // console.log(response);
                    if (response.status == 200) {
                        // self.formData.fname = response.data.data.file_name;
                        self.playerOptions.sources[0].src = response.data.data.file_url;
                    }
                });

            } else if (route_path.indexOf('/UserOriTmps/edit') != -1 && (this.$route.params.id)) {
                this.isUpdate = true;
                //查询 该用户 同时显示在页面上
                var resData = this.$route.params.id, self = this;
                allAjax.userOriTmps.show.call(this, resData, function (response) {
                    // console.log(response);
                    if (response.status == 200) {
                        self.formData.tid = response.data.data.tid;
                        self.formData.title = response.data.data.title;
                        self.formData.des = response.data.data.des;
                        // self.formData.fname = response.data.data.fname;
                        let att = JSON.parse(response.data.data.att);
                        self.formData.att.fee = att.fee;
                        self.formData.att.free_time = att.free_time;
                        self.formData.att.be_fp = att.be_fp;
                        // self.formData.att = response.data.data.att;
                        self.playerOptions.sources[0].src = response.data.data.down_url;
                    }
                });
            } else {
                this.$route.go(-1);
            }
        },
        mounted() {

            // console.log('this is current player instance object', this.player)
            setTimeout(() => {
                // console.log('dynamic change options', this.player)
                this.player.muted(false)
            }, 2000);
        },

        computed: {
            player() {
                return this.$refs.videoPlayer.player
            }
        },
        methods: {
            validateBeforeSubmit() {
                //添加
                if (!this.isUpdate) {
                    this.$validator.validateAll().then((result) => {
                        if (result) {
                            var resData = this.formData;
                            var self = this;
                            allAjax.userOriTmps.store.call(this, resData, function (response) {
                                // console.log(response.status,response);
                                if (response.status == 201) {
                                    self.$message({
                                        type: "success",
                                        message: '资源申请成功成功！'
                                    });
                                    window.location.href = '#/UserOriTmps'
                                }
                            });
                            return;
                        }
                        self.$message({
                            type: "error",
                            message: '请按照要求填写表单'
                        });
                    });
                } else {
                    //修改
                    this.$validator.validateAll().then((result) => {
                        if (result) {
                            // console.log(this.formData);
                            var resData = this.formData;
                            resData._method = 'put';
                            var self = this;
                            allAjax.userOriTmps.update.call(this, this.$route.params.id, resData, function (response) {
                                // console.log(response);
                                if (response.data.code == 200) {
                                    self.$message({
                                        type: "success",
                                        message: '信息修改成功！'
                                    });
                                    window.location.href = '#/UserOriTmps'
                                }else{
                                    self.$message({
                                        type: "error",
                                        message: '信息修改失败！'
                                    });
                                }
                            });
                            return;
                        }
                        self.$message({
                            type: "error",
                            message: '请按照要求填写表单'
                        });
                    });
                }

            },
            //视频暂停
            onPlayerPause(player) {
                // console.log('player pause!', player)
                // console.log(player, player.currentTime());
            },
            closeAndChoseModel() {
                //暂停视屏
                this.player.pause();
                //让用户确认是否选择当前时间为免费时间
                // console.log(this.player, this.player.currentTime());
                this.formData.att.free_time = this.formatSeconds(this.player.currentTime());

                //关闭弹框
                this.isShowVideo = false;
                //将时间自动填到后面去

                //关闭弹窗
                this.isShowVideo = false;
            }
        },
    }

</script>