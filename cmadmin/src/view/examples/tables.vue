<template>

  <el-card>
  	<el-card class="m-bottom-md">
  		<el-input style="width: 200px;" class="filter-item" placeholder="标题" v-model="searchData.title">
      	</el-input>

      	<el-select clearable style="width: 90px" class="filter-item" v-model="searchData.importance" placeholder="重要性">
        	<el-option v-for="item in importanceOptions" :key="item" :label="item" :value="item">
        </el-option>
      </el-select>
  	</el-card>
    <el-table border fit highlight-current-row :data="tableData" border style="width: 100%" :default-sort="{prop: 'date', order: 'descending'}" @sort-change="sort">
      <el-table-column prop="date" label="日期" sortable="custom" width="180">
      </el-table-column>
      <el-table-column prop="name" label="姓名" sortable="custom" width="180">
      </el-table-column>
      <!-- filter 使用 -->
      <el-table-column prop="address" label="地址">
        <template scope="scope">
          <el-tag>{{scope.row.address | test}}</el-tag>
        </template>
      </el-table-column>
    </el-table>
  </el-card>
</template>
<script>
export default {
  data() {
    return {
      tableData: [{
        date: '2016-05-02',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1518 弄'
      }, {
        date: '2016-05-04',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1517 弄'
      }, {
        date: '2016-05-01',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1519 弄'
      }, {
        date: '2016-05-03',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1516 弄'
      }],
      searchData:{
      	title:'',
      	importance:''
      },
      importanceOptions: [1, 2, 3],
    }
  },
  methods: {
    formatter(row, column) {
      console.log(row, column);
      return row.address + 1;
    },
    //列排序函数
    sort(data, da) {
      console.log(data);
    }
  }
}

</script>
