<!-- 用户权限修改和添加的表单 -->
<template>
    <!--常用表单元素样式-->
    <!--通用导航条 -->
    <div>
        <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
        <div class="col-md-12">
            <div class="smart-widget widget-purple">
                <div class="smart-widget-header">
                    {{this.$route.meta.title}}
                </div>
                <div class="smart-widget-inner">
                    <div class="smart-widget-body">

                        <!--为表单添加验证过滤-->
                        <form class="form-horizontal no-margin" @submit.prevent="validateBeforeSubmit">
                            <!-- <form class="form-horizontal no-margin"> -->

                            <div class="form-group">
                                <label class="control-label col-lg-2">权限名称：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('name:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="权限名称" name="name"
                                        v-model="userPremissions.details.name">
                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('name'),'msg':[{'isShow':errors.has('name:required'),'msg':errors.first('name:required')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">权限描述：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('desc:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="权限描述" name="desc"
                                        v-model="userPremissions.details.desc">
                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('desc'),'msg':[{'isShow':errors.has('desc:required'),'msg':errors.first('desc:required')}]}">
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
    import { mapGetters } from 'vuex'
    export default {
        data() {
            return {
                // 初始化导航栏数据
                toBreadcrumb: [
                    { path: 'main', name: '主页' },
                    { path: this.$route.path, name: this.$route.meta.title },
                ],

            }
        },
        computed: mapGetters([
            'userPremissions'
        ]),
        //addTerm.vue
        created() {
            var route_path = this.$route.path;
            if (route_path.indexOf('/user/premissions/edit') != -1 && (this.$route.params.id)) {
                this.$store.state.userPremisison.userPremissions.isUpdate = true;
                //查询该id的 相关资源的基本信息
                var paramObj = { vue: this, index: this.$route.params.id };
                this.$store.dispatch('USERPREMISSIONDETAIL', paramObj);
            } else if (route_path.indexOf('/user/premissions/add') != -1) {
                this.$store.state.userPremisison.userPremissions.isUpdate = false;
            }
            else {
                this.$router.go(-1);
            }
        },

        methods: {
            validateBeforeSubmit() {

                this.$validator.validateAll().then((result) => {
                    if (result) {
                        //修改
                        if (this.userPremissions.isUpdate) {
                            var paramObj = { vue: this, index: this.$route.params.id, resData: this.userPremissions.details };
                            this.$store.dispatch('UPDATEUSERPREMISSION', paramObj);

                        } else {
                            // 添加
                            var paramObj = { vue: this, resData: this.userPremissions.details };
                            console.log(paramObj.resData);
                            this.$store.dispatch('ADDUSERPREMISSION', paramObj);
                        }
                        return;
                    }
                    this.$message({
                        type: "error",
                        message: '请按照要求填写表单'
                    });
                });
            },
        },
    }

</script>