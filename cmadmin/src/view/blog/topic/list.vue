<template>
  <el-card>
    <el-card class="m-bottom-md">
      <!-- 响应式布局 -->
      <el-row :gutter="10">
        <el-col :lg="4" :xs="24" class="m-bottom-sm">
          <el-input class="filter-item" placeholder="标题" v-model="blogTopic.searchData.name">
          </el-input>
        </el-col>
        <el-col :lg="3" :xs="24" class="m-bottom-sm">
          <el-select clearable style="width: 90px" class="filter-item" v-model="blogTopic.searchData.importance" placeholder="重要性">
            <el-option style="width: 90px;" v-for="item in importanceOptions" :key="item" :label="item" :value="item">
            </el-option>
          </el-select>
        </el-col>
        <el-col :lg="5" :xs="24" class="m-bottom-sm">
          <el-date-picker :editable="false" :clearable="true" v-model="blogTopic.searchData.timeRange" @change="timeRangeChange" type="daterange" placeholder="选择日期范围">
          </el-date-picker>
        </el-col>
        <el-col :lg="6" :xs="24" class="fr">
          <el-row>
            <el-col :lg="8" :xs="8">
              <el-button class="filter-item" type="primary" icon="search" @click="search()">搜索</el-button>
            </el-col>
            <el-col :lg="8" :xs="8">
              <el-button class="filter-item" type="success" icon="edit" @click="add()">添加</el-button>
            </el-col>
            <el-col :lg="8" :xs="8">
              <el-button class="filter-item" type="danger" icon="document" @click="handleDownload" :loading="blogTopic.searchData.isExcel">excel</el-button>
            </el-col>
          </el-row>
        </el-col>
      </el-row>
    </el-card>
    <el-table border fit highlight-current-row :data="blogTopic.lists" border style="width: 100%" :default-sort="{prop: 'date', order: 'descending'}" @sort-change="sort">
      <el-table-column prop="id" label="编号" sortable="custom">
      </el-table-column>
      <el-table-column prop="name" label="名称" sortable="custom">
      </el-table-column>
      <el-table-column prop="created_at" label="创建时间" sortable="custom">
      </el-table-column>
      <el-table-column align="center" label="操作" width="150">
        <template scope="scope">
          <el-button size="small" type="info" @click="edit(scope.row.id)">
          	<i class="fa fa-edit"></i>
          	修改
          </el-button>
        </template>
      </el-table-column>

    </el-table>
    <el-row v-show="!loading" class="m-top-sm" :gutter="0">
      <el-col :offset="5" :lg="14" :xs="0" class="over-flow-auto">
        <div class="pagination-container">
          <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :page-sizes="[10,15,30, 50]" :page-size="blogTopic.searchData.limit" layout="total, sizes, prev, pager, next, jumper" :total="blogTopic.meta.pagination.total">
          </el-pagination>
        </div>
      </el-col>
      <el-col :lg="0" :xs="24" class="over-flow-auto">
        <div class="pagination-container">
          <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :page-sizes="[10,15,30, 50]" :page-size="blogTopic.searchData.limit" layout="prev, pager, next" :total="blogTopic.meta.pagination.total">
          </el-pagination>
        </div>
      </el-col>
    </el-row>
    
  </el-card>

</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      importanceOptions: [1, 2, 3],
    };
  },
  computed: mapGetters([ "loading", "blogTopic"]),
  created() {
    this.list();
  },
  methods: {
    list() {
      var resData = this.getDataFormat(this.blogTopic.searchData);
      var paramObj = { vue: this, resData: resData };
      this.$store.dispatch("BLOGTOPICS", paramObj);
    },
    //添加搜索
    search() {
      // 搜索的话，将page 进行 重置为1
      this.blogTopic.searchData.page = 1;
      var resData = this.getDataFormat(this.blogTopic.searchData);
      this.list();
    },
    formatter(row, column) {
      console.log(row, column);
      return row.address + 1;
    },
    //列排序函数
    sort(data, da) {
      console.log(data);
    },
    // 时间搜索
    timeRangeChange(data) {
      if (data != "") {
        var dataArr = data.split(" - ");
        this.blogTopic.searchData.btime = dataArr[0];
        this.blogTopic.searchData.etime = dataArr[1];
      } else {
        this.blogTopic.searchData.btime = "";
        this.blogTopic.searchData.etime = "";
      }

      this.list();
    },
    // 页面的 大小发生改变
    handleSizeChange(data) {
      this.blogTopic.searchData.limit = data;
      this.list();
    },
    // 页码发生改变
    handleCurrentChange(data) {
      this.blogTopic.searchData.page = data;
      this.list();
    },
    handleDownload() {
      //http://www.jb51.net/article/120684.htm
      // this.downloadLoading = true
      require.ensure([], () => {
        const { export_json_to_excel } = require("@/vendor/Export2Excel");
        const tHeader = ["编号", "名字", "昵称", "创建时间"];
        const filterVal = ["uid", "uname", "nick", "ctime"];
        this.blogTopic.searchData.isExcel = true;
        var resData = this.getDataFormat(this.blogTopic.searchData);
        var paramObj = { vue: this, resData: resData };
        this.$store.dispatch("USEREXCEL", paramObj);
        const list = this.blogTopic.excelData;
        const data = this.formatJson(filterVal, list);
        console.log(data);
        export_json_to_excel(tHeader, data, "列表excel");
        // this.downloadLoading = false
      });
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v =>
        filterVal.map(j => {
          if (j === "timestamp") {
            return parseTime(v[j]);
          } else {
            return v[j];
          }
        })
      );
    },
    edit(id){
      console.log(id);
      this.$router.push('/blog/topics/edit/'+id);
    },
    add(){
      this.$router.push('/blog/topics/add');
    },
    // search(){

    // }
  }
};
</script>
