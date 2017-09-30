<template>
    <!--常用表单元素样式-->
    <!--通用导航条 -->
    <div>
        <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
        <div class="col-md-12">
            <div class="smart-widget widget-purple">
                <div class="smart-widget-header">
                    修改用户原创
                </div>
                <div class="smart-widget-inner">
                    <div class="smart-widget-body">

                        <!--为表单添加验证过滤-->
                        <form class="form-horizontal no-margin" @submit.prevent="validateBeforeSubmit">
                            <!-- <form class="form-horizontal no-margin"> -->

                            <div class="form-group">
                                <label class="control-label col-lg-2">文件的名称：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('file_name:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="文件的名称" name="file_name"
                                        v-model="userOriFiles.details.file_name">
                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('file_name'),'msg':[{'isShow':errors.has('file_name:required'),'msg':errors.first('file_name:required')}]}">
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
    import breadcrumb from '../components/common/breadcrumb.vue'
    import errorMsg from '../components/common/formError.vue'
    import allAjax from '../api/request.js'
    import { mapGetters } from 'vuex'
    export default {
        data() {
            return {
                // 初始化导航栏数据
                toBreadcrumb: [
                    { path: 'main', name: '主页' },
                    { path: this.$route.path, name: this.$route.meta.title },
                ],
                formData: {
                    "file_name": "",
                },
                isShowVideo: false,

            }
        },
        components: {
            'v-breadcrumb': breadcrumb,
            'v-errorMsg': errorMsg
        },
        computed: mapGetters([
            'userOriFiles'
        ]),
        //addTerm.vue
        created() {
            var route_path = this.$route.path;
            // this.formdata.update_id = update_id;
            if (route_path.indexOf('/UserOriFiles/edit') != -1 && (this.$route.params.id)) {
                //查询该id的 相关资源的基本信息
                var paramObj = { vue: this, resData: this.$route.params.id };
                this.$store.dispatch('GETUSERORIFILEDETAIL', paramObj);
            }
        },

        methods: {
            validateBeforeSubmit() {
                //修改
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        // var resData = this.formData;
                        // resData._method = 'put';
                        // var self = this;
                        // console.log(this.$route.params.id);
                        var paramObj = {vue: this, index: this.$route.params.id,resData:this.userOriFiles.details};
                        this.$store.dispatch('SETUSERORIFILEDETAIL',paramObj);
                        // allAjax.userOriFiles.update.call(this, this.$route.params.id, resData, function (response) {
                        //     console.log(response.status);
                        //     if (response.status == 200) {
                        //         self.$message({
                        //             type: "success",
                        //             message: '信息修改成功！'
                        //         });
                        //         window.location.href = '#/userOriFiles'
                        //     }
                        // });
                        return;
                    }
                    self.$message({
                        type: "error",
                        message: '请按照要求填写表单'
                    });
                });
            },
        },
    }

</script>