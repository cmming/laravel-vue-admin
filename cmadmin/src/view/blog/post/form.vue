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
                <label class="control-label col-lg-2">名称</label>
                <div :class="{'col-lg-6': true, 'has-error': (errors.has('name:required'))}">
                    <input autocomplete="off" v-validate="'required'" type="text" class="form-control input-sm" placeholder="博客类型名称" name="name"
                        v-model="blogTopic.details.name">
                    <v-errorMsg :errorMsgAlert="{'isShow':errors.has('name'),'msg':[{'isShow':errors.has('name:required'),'msg':errors.first('name:required')}]}">
                    </v-errorMsg>
                </div>
                <!-- /.col -->
            </div>
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
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      // 初始化导航栏数据
      toBreadcrumb: [
        { path: "main", name: "主页" },
        { path: this.$route.path, name: this.$route.meta.title }
      ]
    };
  },
  computed: mapGetters(["userRoles", "user", "blogTopic"]),
  //addTerm.vue
  created() {
    if (this.$route.path.indexOf("edit")!=-1) {
      var paramObj = { vue: this, index: this.$route.params.id };
      this.$store.dispatch("BLOGTOPICDETAIL", paramObj);
    }
  },

  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          if (this.$route.path.indexOf("edit")!=-1) {
            var paramObj = {
              vue: this,
              index: this.$route.params.id,
              resData: this.blogTopic.details
            };
            console.log(paramObj);
            this.$store.dispatch("UPDATEBLOGTOPIC", paramObj);
            return;
          } else {
              var paramObj = {
              vue: this,
              resData: this.blogTopic.details
            };
            console.log(paramObj);
            this.$store.dispatch("STOREBLOGTOPIC", paramObj);
            return;
          }
        }
        this.$message({
          type: "error",
          message: "请按照要求填写表单"
        });
      });
    }
  }
};
</script>