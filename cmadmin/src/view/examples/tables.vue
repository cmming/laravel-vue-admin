<template>
  <el-card>
    <el-card class="m-bottom-md">
      <!-- 响应式布局 -->
      <el-row :gutter="10">
        <el-col :lg="4" :xs="24" class="m-bottom-sm">
          <el-input class="filter-item" placeholder="标题" v-model="searchData.title">
          </el-input>
        </el-col>
        <el-col :lg="3" :xs="24" class="m-bottom-sm">
          <el-select clearable style="width: 90px" class="filter-item" v-model="searchData.importance" placeholder="重要性">
            <el-option style="width: 90px;" v-for="item in importanceOptions" :key="item" :label="item" :value="item">
            </el-option>
          </el-select>
        </el-col>
        <el-col :lg="5" :xs="24" class="m-bottom-sm">
          <el-date-picker :editable="false" :clearable="true" v-model="searchData.timeRange" @change="timeRangeChange" type="daterange" placeholder="选择日期范围">
          </el-date-picker>
        </el-col>
        <el-col :lg="6" :xs="24" class="fr">
          <el-row>
            <el-col :lg="8" :xs="8">
              <el-button class="filter-item" type="primary" icon="search">搜索</el-button>
            </el-col>
            <el-col :lg="8" :xs="8">
              <el-button class="filter-item" type="success" icon="edit">添加</el-button>
            </el-col>
            <el-col :lg="8" :xs="8">
              <el-button class="filter-item" type="danger" icon="document" @click="handleDownload" :loading="user.searchData.isExcel">excel</el-button>
            </el-col>
          </el-row>
        </el-col>
      </el-row>
    </el-card>
    <el-table border fit highlight-current-row :data="user.lists" border style="width: 100%" :default-sort="{prop: 'date', order: 'descending'}" @sort-change="sort">
      <el-table-column prop="uid" label="编号" sortable="custom">
      </el-table-column>
      <el-table-column prop="uname" label="名字" sortable="custom">
      </el-table-column>
      <el-table-column prop="nick" label="昵称" sortable="custom">
      </el-table-column>
      <!-- filter 使用 -->
      <el-table-column prop="ctime" label="创建时间">
        <template scope="scope">
          <!-- <el-tag>{{scope.row.address | test}}</el-tag> -->
          {{scope.row.ctime}}
        </template>
      </el-table-column>
      <el-table-column align="center" label="操作" width="150">
        <template scope="scope">
          
          <el-button size="small" type="info" @click="addUserRole(scope.row.uid)">
          	<i class="fa fa-sitemap"></i>
          	角色管理
          </el-button>
        </template>
      </el-table-column>

    </el-table>
    <el-row v-show="!loading" class="m-top-sm" :gutter="0">
      <el-col :offset="5" :lg="14" :xs="0" class="over-flow-auto">
        <div class="pagination-container">
          <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :page-sizes="[10,15,30, 50]" :page-size="user.searchData.limit" layout="total, sizes, prev, pager, next, jumper" :total="user.meta.pagination.total">
          </el-pagination>
        </div>
      </el-col>
      <el-col :lg="0" :xs="24" class="over-flow-auto">
        <div class="pagination-container">
          <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :page-sizes="[10,15,30, 50]" :page-size="user.searchData.limit" layout="prev, pager, next" :total="user.meta.pagination.total">
          </el-pagination>
        </div>
      </el-col>
    </el-row>
  </el-card>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      searchData: {
        title: '',
        importance: '',
        timeRange: '',
        curpage: 1,
        limit: 8,
        total: 1000,
      },
      importanceOptions: [1, 2, 3],
    }
  },
  computed: mapGetters([
    'user',
    'loading'
  ]),
  created() {
    this.list();
  },
  methods: {
    list() {
      var resData = this.getDataFormat(this.user.searchData);
      var paramObj = { vue: this, resData: resData };
      this.$store.dispatch('USERLIST', paramObj);
    },
    //添加搜索
    search() {
      // 搜索的话，将page 进行 重置为1
      this.user.searchData.page = 1;
      var resData = this.getDataFormat(this.user.searchData);
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
      if (data != '') {
        var dataArr = data.split(' - ');
        this.user.searchData.btime = dataArr[0];
        this.user.searchData.etime = dataArr[1];
      } else {
        this.user.searchData.btime = '';
        this.user.searchData.etime = '';
      }

      this.list();
    },
    // 页面的 大小发生改变
    handleSizeChange(data) {
      this.user.searchData.limit = data;
      this.list();
    },
    // 页码发生改变
    handleCurrentChange(data) {
      this.user.searchData.page = data;
      this.list();
    },
    handleDownload() {
      //http://www.jb51.net/article/120684.htm 
      // this.downloadLoading = true
      require.ensure([], () => {
        const { export_json_to_excel } = require('../../vendor/Export2Excel')
        const tHeader = ['编号', '名字', '昵称', '创建时间']
        const filterVal = ['uid', 'uname', 'nick', 'ctime'];
        this.user.searchData.isExcel = true;
        var resData = this.getDataFormat(this.user.searchData);
      	var paramObj = { vue: this, resData: resData };
      	this.$store.dispatch('USEREXCEL', paramObj);
        const list = this.user.excelData;
        const data = this.formatJson(filterVal, list)
        console.log(data);
        export_json_to_excel(tHeader, data, '列表excel')
        // this.downloadLoading = false
      })
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    },
    addUserRole(index){
        this.$router.push('/user/'+index+'/roles');
    },

  }
}

</script>
