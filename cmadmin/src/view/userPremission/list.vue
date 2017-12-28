<!-- 权限列表页面 -->
<template>
  <div>
    <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
    <!--数据筛选区域-->
    <!-- <div class="container bg-white padding-lg"> -->
    <el-card>
      <div class="row">
        <div class="col-md-1 col-sm-2 font-600" style="text-align:center">筛选区：</div>
        <div class="col-md-11 col-sm-10 pull-left">
          <div class="row">
            <div class="col-md-3">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="文件名称" v-model="userPremissions.searchData.file_name">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-success no-shadow" tabindex="-1" @click="search">搜索</button>
                </div>
                <!-- /input-group-btn -->
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
      </div>
      <!--数据操作区域-->
      <div class="m-top-xs row">
        <div class="font-600 col-md-1 col-sm-2" style="text-align:center">操作区:</div>
        <div class="col-md-11 col-sm-10">
          <!-- <button type="button" class="btn btn-danger btn-sm" @click="del(chooseItem)"> 
                        <i class="fa fa-trash-o fa-fw"></i>
                        删除
                    </button> -->
          <button type="button" class="btn btn-warning btn-sm" @click="edit(chooseItem)">
            <i class="fa fa-check-circle-o fa-fw"></i> 修改
          </button>
          <button type="button" class="btn btn-success btn-sm" @click="addUserPremissions">
            <i class="fa fa-plus"></i> 添加权限
          </button>
          <button type="button" class="btn btn-primary btn-sm" @click="addUserPremissionsMenu(chooseItem)">
            <i class="fa fa-cogs"></i> 配置资源
          </button>
        </div>
      </div>
      <!--控制展示行-->
      <div class="m-top-xs row">
        <div class="font-600 col-md-1 col-sm-12" style="text-align:center;">控制列:</div>
        <v-selectForShowCol class="inline-block col-md-11 col-sm-12" :tableHeader="tableHeader"></v-selectForShowCol>
      </div>
      <!-- </div> -->
      <!-- </el-card> -->
      <!--数据展示区域-->
      <!-- <el-card> -->
      <div class="m-top-md bg-white padding-xs" style="overflowX:auto">
        <div v-show="userPremissions.allPage">
          <table class="table table-responsive table-condensed table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th>单选</th>
                <th v-for="(headerItem,key) in tableHeader" v-show="headerItem.val">{{headerItem.name}}</th>
                <!--<th>操作</th>-->
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item,key) in userPremissions.lists">
                <td>
                  <div class="custom-radio">
                    <input type="radio" :id="key" name="chooseItem" :value="item.id" v-model="chooseItem">
                    <label :for="key"></label>
                  </div>
                </td>
                <td v-show="tableHeader[0].val">{{item.id}}</td>
                <td v-show="tableHeader[1].val">{{item.name}}</td>
                <td v-show="tableHeader[2].val">{{item.desc}}</td>
                <td v-show="tableHeader[3].val">{{item.created_at}}</td>
                <td v-show="tableHeader[4].val">{{item.updated_at}}</td>
              </tr>
            </tbody>
          </table>
          <!--分页组件-->
          <v-page :curPage="userPremissions.curpage" :allPage="userPremissions.allPage" @btn-click='listen'></v-page>
        </div>
        <div v-show="!userPremissions.allPage">
          <div class="alert" ng-hide="orderView">
            <strong>抱歉！</strong> 没有相关数据
          </div>
        </div>
      </div>
    </el-card>
    <el-dialog title="配置用户角色" v-model="dialogVisible" size="tiny">
      <div class="select-tree">
        <el-scrollbar tag="div" class='is-empty' wrap-class="el-select-dropdown__wrap" view-class="el-select-dropdown__list">
          <el-tree ref="tree" :data="userPremissions.allRouter" show-checkbox check-strictly node-key="id" v-loading="loading" :props="defaultProps" :default-expanded-keys="userPremissions.premissionsRouters" :default-checked-keys="userPremissions.premissionsRouters">
          </el-tree>
        </el-scrollbar>
      </div>
      <span slot="footer" class="dialog-footer">
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button type="primary" @click="configUserRoles">确 定</el-button>
          </span>
    </el-dialog>
  </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {
      // 初始化导航栏数据
      toBreadcrumb: [
        { path: 'main', name: '主页' },
        { path: this.$route.path, name: this.$route.meta.title },
      ],
      // 列表数据
      tableHeader: [
        { 'name': '编号', 'val': 1 },
        { 'name': '权限名', 'val': 1 },
        { 'name': '描述', 'val': 1 },
        { 'name': '创建时间', 'val': 1 },
        { 'name': '修改时间', 'val': 1 },
      ],
      chooseItem: '',
      dialogVisible: false,
      defaultProps: {
          children: 'children',
          label: 'title',
          id: "id",
      },

    }
  },
  computed: mapGetters([
    'userPremissions',
    'menu',
    'loading',
    'router'
  ]),
  created() {
    this.list();
  },
  methods: {
    //获取所有的路由
    // 使用dispatched 发送请求
    list() {
      var resData = this.getDataFormat(this.userPremissions.searchData);
      var paramObj = { vue: this, resData: resData };
      this.$store.dispatch('USERPREMISSIONLIST', paramObj);
    },
    // 监视分页 点击事件
    listen(data) {
      this.userPremissions.curpage = data;
      this.userPremissions.searchData.page = data;
      this.list();
      if (data == this.userPremissions.allPage) {
        this.$message({
          type: 'warning',
          message: '最后一页!'
        });
      }
    },
    // 删除一条数据
    del(index) {
      this.$confirm('此操作将永久删除该数据文件, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        var paramObj = { vue: this, resData: index };
        this.$store.dispatch('DELETEUSERORIFILE', paramObj);
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除'
        });
      });

    },
    //展示详情
    edit(index) {
      //使用模态框 显示
      if (index) {
        this.$router.push('/user/premissions/edit/' + index);
      }

    },
    //添加权限
    addUserPremissions() {
      this.$router.push('/user/premissions/add');
    },
    //日期的格式化
    setStartDate(val) {
      this.userPremissions.searchData.btime = val;
    },
    setEndDate(val) {
      this.userPremissions.searchData.etime = val;
    },
    //添加搜索
    search() {
      // 搜索的话，将page 进行 重置为1
      this.userPremissions.searchData.page = 1;
      var resData = this.getDataFormat(this.userPremissions.searchData);
      this.list();
    },
    addUserPremissionsMenu(index){
        if(index==''){
            this.$message.error('请选中一个数据,然后再进行资源配置');
        }else{
            var paramObj = { vue: this,index:this.chooseItem};
            // this.$store.dispatch('PREMISSIONRESOURCES',paramObj);
            this.$store.dispatch('PREMISIONROUTERS',paramObj);
            this.dialogVisible =true;
            // this.getAllRouter();
            // var paramObj = { vue: this};
            // this.$store.dispatch('MENULIST',paramObj);
        }
    },
    configUserRoles(index){
        // 为一个 权限进行 资源配置
        var addItem = {'routers_id':JSON.stringify(this.$refs.tree.getCheckedKeys())},
        paramObj = { vue: this,'index':this.chooseItem,resData:addItem};
        this.$store.dispatch('STOREPREMISSIONROUTER',paramObj);
        this.dialogVisible =false;
    }
  }
}

</script>
<style lang="css" scoped>
.table th,
.table td {
  text-align: center;
  vertical-align: middle!important;
}

.font-600 {
  padding: 10px 0;
}

</style>
