<template>
    <div v-ansyimgpage="{'ansy':2000}">
        <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
        <!--数据筛选区域-->
        <div class="container bg-white padding-lg">
            <div class="row">
                <div class="col-md-1 col-sm-2 font-600" style="text-align:center">筛选区：</div>
                <div class="col-md-11 col-sm-10 pull-left">
                    <div class="row">
                        <!-- <div class="col-md-2 col-sm-12">
                        </div> -->
                        <!-- <div class="col-md-6 col-sm-12">
                            <span class = "search_time_title">创建时间：</span>
                            <el-date-picker @change="setStartDate" type="date" placeholder="开始日期" v-model="searchData.btime"></el-date-picker>

                            <el-date-picker @change="setEndDate" type="date" placeholder="结束日期" v-model="searchData.etime"></el-date-picker>
                        </div> -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="文件名称" v-model="searchData.file_name">
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
                    <button type="button" class="btn btn-danger btn-sm" @click="del(chooseItem)"> 
                        <i class="fa fa-trash-o fa-fw"></i>
                        删除
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" @click="edit(chooseItem)">
                        <i class="fa fa-check-circle-o fa-fw"></i>
                        修改
                    </button>
                    <button type="button" class="btn btn-success btn-sm" @click="addUserFilesStore(chooseItem)">
                        <i class="fa fa-check-circle-o fa-fw"></i>
                        发布视频
                    </button>
                </div>
            </div>
            <!--控制展示行-->
            <div class="m-top-xs row">
                <div class="font-600 col-md-1 col-sm-12" style="text-align:center;">控制列:</div>
                <v-selectForShowCol class="inline-block col-md-11 col-sm-12" :tableHeader="tableHeader"></v-selectForShowCol>
            </div>
        </div>
        <!--数据展示区域-->

        <div class="m-top-md bg-white padding-xs" style="overflowX:auto">
            <div v-show="userOriFiles.allPage">
                <table class="table table-responsive table-condensed table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>单选</th>
                            <th v-for="(headerItem,key) in tableHeader" v-show="headerItem.val">{{headerItem.name}}</th>
                            <!--<th>操作</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,key) in userOriFiles.lists">
                            <td>
                                <div class="custom-radio">
                                    <input type="radio" :id="key" name="chooseItem" :value="item.id" v-model="chooseItem">
                                    <label :for="key"></label>
                                </div>
                            </td>
                            <td v-show="tableHeader[0].val">{{item.id}}</td>
                            <td v-show="tableHeader[1].val">{{item.file_name}}</td>
                            <td v-show="tableHeader[2].val">{{item.file_size|bytesToSize}}</td>
                            <td v-show="tableHeader[3].val">{{item.file_type}}</td>
                            <td v-show="tableHeader[4].val">{{item.file_url}}</td>
                        </tr>
                    </tbody>
                </table>
                <!--分页组件-->
                <v-page :curPage="userOriFiles.curpage" :allPage="userOriFiles.allPage" @btn-click='listen'></v-page>
            </div>
            <div v-show="!userOriFiles.allPage">
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
                    { path: 'orderInquery', name: '管理员列表' },
                ],
                // 列表数据
                tableHeader: [
                    { 'name': '编号', 'val': 1 },
                    { 'name': '文件名', 'val': 1 },
                    { 'name': '文件大小', 'val': 1 },
                    { 'name': '文件类型', 'val': 1 },
                    { 'name': '文件下载地址', 'val': 1 },
                ],
                dataList: [],
                chooseItem: '',
                searchData: { "file_name": '', "btime": "", "etime": "", "page": '1', },

            }
        },
        computed: mapGetters([
            'userOriFiles'
        ]),
        created() {
            // this.getData();
            this.list();
        },
        methods: {
            // 使用dispatched 发送请求
            list(){
                var self = this;
                var resData = 'page=' + this.userOriFiles.curpage;
                var paramObj = {vue:this,resData:resData};
                this.$store.dispatch('GETUSERORIFILElIST',paramObj);
            },
            // 监视分页 点击事件
            listen(data) {
                this.userOriFiles.curpage = data;
                this.searchData.page = data;
                this.list();
                if (data == this.userOriFiles.allPage) {
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
                    var paramObj = {vue:this,resData:index};
                    this.$store.dispatch('GETETUSERORIFILEDETAIL',paramObj);
                    // allAjax.userOriFiles.delete.call(this, index, function (response) {
                    //     console.log(response.status);
                    //     if (response.status == 204) {
                    //         self.$message({
                    //             type: "success",
                    //             message: '数据删除成功！'
                    //         });
                    //         self.getData();
                    //         // window.location.href = '#/users'
                    //     }
                    // });
                    this.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
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
                    this.$router.push('/UserOriFiles/edit/' + index);
                }

            },
            //发布视频
            addUserFilesStore(index) {
                if (index) {
                    this.$router.push('/UserOriFiles/add/' + index);
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

                console.log(this.getDataFormat(this.searchData));
                allAjax.userOriFiles.list.call(this, resData, function (response) {
                    if (response.status == 200) {
                        console.log(response.data);
                        self.dataList = response.data.data;
                        self.allPage = response.data.meta.pagination.total_pages;
                    } else {
                        self.allPage = 0;
                        self.$message({
                            type: "warning",
                            message: response.data
                        });
                    }
                });
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