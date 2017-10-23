<!-- 用户角色修改和添加的表单 -->
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
                                <label class="col-lg-2 control-label">角色名称：</label>
                                <div class="col-lg-10">
                                    <div class="checkbox inline-block" v-for="(item,key) in userRoles.lists">
                                        <div class="custom-checkbox">
                                            <input type="checkbox" name='permissions[]' v-model="user.roles" :id="key" class="checkbox-grey" :value="item.id">
                                            <label :for="key"></label>
                                        </div>
                                        <div class="inline-block vertical-top">
                                            {{item.name}} &nbsp;
                                        </div>
                                    </div>
                                </div>

                                <!-- <div :class="{'col-lg-6': true, 'has-error': (errors.has('name:required'))}">
                                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="角色名称" name="name"
                                        v-model="userRoles.details.name">
                                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('name'),'msg':[{'isShow':errors.has('name:required'),'msg':errors.first('name:required')}]}">
                                    </v-errorMsg>
                                </div> -->
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
            'userRoles',
            'user'
        ]),
        //addTerm.vue
        created() {
            // 获取所有的权限
            var paramObj = { vue: this, resData: '' };
            this.$store.dispatch('USERROLELIST', paramObj);

            var paramObj = { vue: this, resData: this.$route.params.id };
            //获取 当前 角色拥有的 权限
            this.$store.dispatch('USERSROLES', paramObj);
            console.log(this.user.roles);
            
             
        },

        methods: {
            validateBeforeSubmit() {

                this.$validator.validateAll().then((result) => {
                    if (result) {
                        //提交 角色 的权限
                        var data = {};
                        for(var i in this.user.roles){
                            this.user.roles[i]&&(data['roles['+i+']'] = this.user.roles[i]);

                        }
                        
                        var paramObj = { vue: this, index: this.$route.params.id, resData: data};
                        console.log(paramObj);
                        this.$store.dispatch('USERSTOREROLES', paramObj);
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