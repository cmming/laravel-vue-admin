<template>
    <!--常用表单元素样式-->
    <!--通用导航条 -->
    <div>
        <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
        <div class="col-md-12">
            <div class="smart-widget widget-purple">
                <div class="smart-widget-header">
                    {{isUpdate?'修改管理员信息':'添加管理员'}}
                </div>
                <div class="smart-widget-inner">
                    <div class="smart-widget-body">
                        <!--为表单添加验证过滤-->
                        <form class="form-horizontal no-margin" @submit.prevent="validateBeforeSubmit">
                            <!-- <form class="form-horizontal no-margin"> -->

                            <div class="form-group">
                                <label class="control-label col-lg-2">用户名称：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('name:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="用户名称" name="name"
                                        v-model="formData.name">

                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('name'),'msg':[{'isShow':errors.has('name:required'),'msg':errors.first('name:required')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">注册邮箱：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('email:required'))}">
                                    <input autocomplete="off" v-validate="'required|email'" type="text" class="form-control input-sm" placeholder="邮箱" name="email"
                                        v-model="formData.email">

                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('email'),'msg':[{'isShow':errors.has('email:required'),'msg':errors.first('email:required')},{'isShow':errors.has('email:email'),'msg':errors.first('email:email')}]}">
                                    </v-errorMsg>
                                </div>
                                <!-- /.col -->
                            </div>

                            <div class="form-group" v-if="!isUpdate">
                                <label class="control-label col-lg-2">密码：</label>
                                <div :class="{'col-lg-6': true, 'has-error': (errors.has('password:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="密码" name="password"
                                        v-model="formData.password">

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
    import breadcrumb from '../components/common/breadcrumb.vue'
    import errorMsg from '../components/common/formError.vue'
    import allAjax from '../api/request.js'
    export default {
        data() {
            return {
                // 初始化导航栏数据
                toBreadcrumb: [
                    { path: 'main', name: '主页' },
                    { path: '管理员管理', name: '添加管理员' },
                ],
                //isUpdate 
                isUpdate: 0,
                formData: {
                    "name": "",
                    "email": "",
                    "password": ""
                },

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
            if (route_path == '/users/add') {

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
                allAjax.users.userShow.call(this, resData, function (response) {
                    console.log(response);
                    if (response.status == 200) {
                        self.formData.name = response.data.data.name;
                        self.formData.email = response.data.data.email;
                    }
                });
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
                            allAjax.users.userStore.call(this, resData, function (response) {
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
                            allAjax.users.userUpdate.call(this,'/users/'+ this.$route.params.id,resData, function (response) {
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