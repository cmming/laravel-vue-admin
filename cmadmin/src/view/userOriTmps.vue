<template>
    <div v-ansyimgpage="{'ansy':2000}">
        <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
        <!--数据筛选区域-->
        <div class="container bg-white padding-lg">
            <div class="row">
                <div class="col-md-1 col-sm-2 font-600">筛选区：</div>
                <!-- <div class="col-md-11 col-sm-10 pull-left">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <span>开始日期：</span>
                            <el-date-picker type="date" placeholder="选择日期" v-model="searchData.btime"></el-date-picker>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <span>结束日期：</span>
                            <el-date-picker type="date" placeholder="选择日期" v-model="searchData.etime"></el-date-picker>
                        </div>

                    </div>
                </div> -->
                <div class="col-md-6 col-sm-12">
                    <span class="search_time_title">创建时间：</span>
                    <el-date-picker @change="setStartDate" type="date" placeholder="开始日期" v-model="searchData.btime"></el-date-picker>

                    <el-date-picker @change="setEndDate" type="date" placeholder="结束日期" v-model="searchData.etime"></el-date-picker>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="电影名称标题" v-model="searchData.title">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success no-shadow" tabindex="-1" @click="search">搜索</button>
                            <button type="button" class="btn btn-success dropdown-toggle no-shadow" data-toggle="dropdown" tabindex="-1" @click="search_tar = !search_tar">条件</button>
                            <ul class="dropdown-menu pull-right" :class="{'show_block':search_tar}" role="menu">
                                <li><a href="javascript:void(0)">电影标题</a></li>
                                <li><a href="javascript:void(0)">Another action</a></li>
                                <li><a href="javascript:void(0)">Something else here</a></li>
                            </ul>
                        </div>
                        <!-- /input-group-btn -->
                    </div>
                    <!-- /input-group -->
                </div>
            </div>
            <!--数据操作区域-->
            <div class="m-top-xs row">
                <div class="font-600 col-md-1 col-sm-2">操作区:</div>
                <div class="col-md-11 col-sm-10">
                    <button type="button" class="btn btn-danger btn-sm" @click="del(chooseItem)"> 
                        <i class="fa fa-trash-o fa-fw"></i>
                        删除
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" @click="edit(chooseItem)">
                        <i class="fa fa-edit fa-fw"></i>
                        修改
                    </button>
                    <!-- <button type="button" class="btn btn-success btn-sm" @click="edit(chooseItem)">
                        <i class="fa fa-check-circle-o fa-fw"></i>
                        阅读
                    </button> -->
                </div>
            </div>
            <!--控制展示行-->
            <div class="m-top-xs row">
                <div class="font-600 col-md-1 col-sm-12">控制列:</div>
                <v-selectForShowCol class="inline-block col-md-11 col-sm-12" :tableHeader="tableHeader"></v-selectForShowCol>
            </div>
        </div>
        <!--数据展示区域-->

        <div class="m-top-md bg-white padding-xs" style="overflowX:auto">
            <div v-show="userOriTmp.allPage">
                <table class="table table-responsive table-condensed table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>单选</th>
                            <th v-for="(headerItem,key) in tableHeader" v-show="headerItem.val">{{headerItem.name}}</th>
                            <!--<th>操作</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,key) in userOriTmp.list">
                            <td>
                                <div class="custom-radio">
                                    <input type="radio" :id="key" name="chooseItem" :value="item.mid" v-model="chooseItem">
                                    <label :for="key"></label>
                                </div>
                            </td>
                            <td v-show="tableHeader[0].val">{{item.tid}}</td>
                            <td v-show="tableHeader[1].val">{{item.title}}</td>
                            <td v-show="tableHeader[2].val">{{item.ctime}}</td>
                            <td v-show="tableHeader[3].val">{{item.att|user_ori_att}}</td>
                            <td v-show="tableHeader[4].val">{{item.enable}}</td>
                        </tr>
                    </tbody>
                </table>
                <!--分页组件-->
                <v-page :curPage="curpage" :allPage="userOriTmp.allPage" @btn-click='listen'></v-page>
            </div>
            <div v-show="!userOriTmp.allPage">
                <div class="alert" ng-hide="orderView">
                    <strong>抱歉！</strong> 没有相关数据
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import allAjax from '../api/request.js'
    import { mapGetters, mapActions } from 'vuex'
    // 引入图片
    import testSrc from '../assets/images/img11.jpg'

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
                    { 'name': '视频类型', 'val': 1 },
                    { 'name': '电影名称标题', 'val': 1 },
                    { 'name': '创建时间', 'val': 1 },
                    { 'name': '收费配置', 'val': 1 },
                    { 'name': '可用状态', 'val': 1 },
                ],
                dataList: [],
                chooseItem: '',
                searchData: { "page": '1', "btime": "", "etime": "", "title": "" },
                allPage: '',
                curpage: 1,
                restaurants: [],
                search_tar: false

            }
        },
        computed: {
            ...mapGetters([
                'userOriTmp'
            ]),
        },
        created() {
            this.getData();
        },
        methods: {

            // 监视分页 点击事件
            listen(data) {
                this.userOriTmp.curpage = data;
                this.userOriTmp.searchData.page = data;
                this.getData();
                if (data == this.userOriTmp.allPage) {
                    this.$message({
                        type: 'warning',
                        message: '最后一页!'
                    });
                }
            },
            getData() {
                var paramsObj = { vue: this, resData: this.getDataFormat(this.userOriTmp.searchData) };
                this.$store.dispatch('GETUSERORITMPLIST', paramsObj);
            },
            del(index) {
                this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    var resData = {};
                    resData._method = 'delete', self = this;
                    allAjax.userOriTmps.delete.call(this, index, function (response) {
                        // console.log(response.status);
                        if (response.data.code == 200) {
                            self.$message({
                                type: "success",
                                message: '数据删除成功！'
                            });
                            self.getData();
                        } else {
                            this.$message({
                                type: 'error',
                                message: response.data.msg
                            });
                        }
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });

            },
            edit(index) {
                if (index) {
                    this.$router.push('/UserOriTmps/edit/' + index);
                }
            },
            //日期的格式化
            setStartDate(val) {
                this.searchData.btime = val;
            },
            setEndDate(val) {
                this.searchData.etime = val;
            },
            //添加搜索
            search() {

                var resData = this.getDataFormat(this.searchData), self = this;
                var paramsObj = { vue: this, resData: this.getDataFormat(this.searchData) };
                this.$store.dispatch('GETUSERORITMPLIST', paramsObj);
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