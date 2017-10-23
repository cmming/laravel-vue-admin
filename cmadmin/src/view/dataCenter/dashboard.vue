<template>
  <div class="dashboard">
    <el-card>
      <v-breadcrumb :breadcrumbData="toBreadcrumb"></v-breadcrumb>
      <el-card>
        <el-row :gutter=20>
          <el-col :lg=12>
            <div ref="gotobedbar1" id="gotobedbar1" style="height:300px">132</div>
          </el-col>
          <el-col :lg=12>
            <div>
              <el-date-picker
                v-model="timeRange" @change = "timeRangeChange" type="daterange" placeholder="选择日期范围">
              </el-date-picker>
            </div>
            <div ref="gotobedbar2" id="gotobedbar2" style="height:300px">132</div>
          </el-col>
        </el-row>
      </el-card>
    </el-card>
  </div>
</template>
<script type="text/javascript">
// 引入 ECharts 主模块
var echarts = require('echarts/lib/echarts');
// 引入柱状图
require('echarts/lib/chart/bar');
// 引入提示框和标题组件
require('echarts/lib/component/tooltip');
require('echarts/lib/component/title');
require('echarts/lib/component/toolbox');
// 时间轴组件
require('echarts/lib/component/dataZoom');

require('echarts/lib/chart/line');
require('echarts/lib/chart/pie');
require('echarts/lib/chart/scatter');
require('echarts/lib/chart/radar');

export default {
  data() {
    return {
      // 初始化导航栏数据
      toBreadcrumb: [
        { path: '/main', name: '主页' },
        { path: this.$route.path, name: this.$route.meta.title },
      ],
      echartData: {
        // 表格的标题
        title: { text: '柱状图入门' },
        tooltip: {
          trigger: 'axis',
          axisPointer: { // 坐标轴指示器，坐标轴触发有效
            type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
          }
        },
        toolbox: {
          show: true,
          orient: 'horizontal', // 布局方式，默认为水平布局，可选为：
          // 'horizontal' ¦ 'vertical'
          x: 'right', // 水平安放位置，默认为全图右对齐，可选为：
          // 'center' ¦ 'left' ¦ 'right'
          // ¦ {number}（x坐标，单位px）
          y: 'top', // 垂直安放位置，默认为全图顶端，可选为：
          // 'top' ¦ 'bottom' ¦ 'center'
          // ¦ {number}（y坐标，单位px）
          color: ['#1e90ff', '#22bb22', '#4b0082', '#d2691e'],
          feature: {
            mark: { show: true },
            //数据视图
            dataView: { show: true, readOnly: false },
            // 
            magicType: { show: true, type: ['line', 'bar', 'stack', 'tiled'] },
            restore: { show: true },
            saveAsImage: { show: true }
          }
        },
        // dataZoom: {
        //   show: true,
        //   realtime: true,
        //   start: 0,
        //   end: 100
        // },
        dataZoom: [{
          type: 'slider',
          show: true,
          xAxisIndex: [0],
          start: 1,
          end: 100
        }, ],
        xAxis: {
          data: ["衬衫", "羊毛衫", "雪纺衫", "裤子", "高跟鞋", "袜子"]
        },
        yAxis: {},
        series: [{
          name: '销量',
          type: 'bar',
          data: [5, 20, 36, 10, 10, 20]
        }]
      },
      duiDie: {
        title: {
          text: '堆叠区域图学习'
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'cross',
            label: {
              backgroundColor: '#6a7985'
            }
          }
        },
        legend: {
          data: ['邮件营销', '联盟广告', '视频广告', '直接访问', '搜索引擎']
        },
        toolbox: {
          feature: {
            mark: { show: true },
            //数据视图 数据图形工具
            dataView: { show: true, readOnly: false },
            // 动态切换
            magicType: { show: true, type: ['line', 'bar', 'tiled'] },
            // 恢复数据的初始状态
            restore: { show: true },
            // 保存为 图片
            saveAsImage: { show: true },
            // 自定义 按钮
            myTool1: {
              show: true,
              title: '自定义扩展方法1',
              icon: 'path://M432.45,595.444c0,2.177-4.661,6.82-11.305,6.82c-6.475,0-11.306-4.567-11.306-6.82s4.852-6.812,11.306-6.812C427.841,588.632,432.452,593.191,432.45,595.444L432.45,595.444z M421.155,589.876c-3.009,0-5.448,2.495-5.448,5.572s2.439,5.572,5.448,5.572c3.01,0,5.449-2.495,5.449-5.572C426.604,592.371,424.165,589.876,421.155,589.876L421.155,589.876z M421.146,591.891c-1.916,0-3.47,1.589-3.47,3.549c0,1.959,1.554,3.548,3.47,3.548s3.469-1.589,3.469-3.548C424.614,593.479,423.062,591.891,421.146,591.891L421.146,591.891zM421.146,591.891',
              onclick: null
            },
          }
        },
        // 设置 表格的位置
        // grid: {
        //   left: '3%',
        //   right: '4%',
        //   bottom: '3%',
        //   containLabel: true
        // },
        // 时间轴
        dataZoom: {
          show: true,
          realtime: true,
          start: 0,
          end: 100
        },
        //x坐标类型
        xAxis: [{
          type: 'category',
          boundaryGap: false,
          data: []
        }],
        // y轴坐标类型 value 表示 是需要等会儿，数字设置
        yAxis: [{
          type: 'value'
        }],
        // 系列数据
        series: [{
            // 列的名称
            name: '邮件营销',
            // 列的类型 
            type: 'line',
            // 数据堆叠，同个类目轴上系列配置相同的stack值后，后一个系列的值会在前一个系列的值上相加。
            stack: '总量',
            // 区域填充样式
            areaStyle: { normal: {} },
            // 该系列中的填充数据
            data: []
          },
          {
            name: '联盟广告',
            type: 'line',
            stack: '总量',
            areaStyle: { normal: {} },
            data: []
          },
          {
            name: '视频广告',
            type: 'line',
            stack: '总量',
            areaStyle: { normal: {} },
            data: []
          },
          {
            name: '直接访问',
            type: 'line',
            stack: '总量',
            areaStyle: { normal: {} },
            data: []
          },
          {
            name: '搜索引擎',
            type: 'line',
            stack: '总量',
            label: {
              normal: {
                show: true,
                position: 'top'
              }
            },
            areaStyle: { normal: {} },
            data: []
          }
        ]
      },
      timeRange:''


    }
  },
  created() {
    this.duiDie.xAxis[0].data = this.getData(60);
    this.duiDie.series.map((item) => {
      item.data = this.randomData(60)
    });

  },
  mounted() {
    this.$nextTick(function() {
      this.init('gotobedbar1', this.echartData);
      this.init('gotobedbar2', this.duiDie, this.duiDie.series);
      // 自定义 按钮 事件定义
    this.duiDie.toolbox.feature.myTool1.onclick = this.myTool1()
    console.log(this.duiDie.toolbox.feature);

    });
  },
  methods: {
    init(id, opt) {
      // let dom = this.$refs.id,
      let dom = document.getElementById(id),
        myChart = echarts.init(dom);
      myChart.setOption(opt);
    },
    randomData(n) {
      var list = [];
      for (var i = 1; i <= n; i++) {
        list.push(Math.round(Math.random() * 1000));
      }
      return list;
    },
    getData(n) {
      var list = [];
      var d = new Date(); // 这个算法能自动处理闰年和非闰年。2012年是闰年，所以2月有29号
      var s = '';
      var i = 0;
      while (i < n) {
        d.setDate(d.getDate() - 1);
        var year = d.getFullYear();
        var mon = d.getMonth() + 1;
        var day = d.getDate();
        list.push(year + "-" + (mon < 10 ? ('0' + mon) : mon) + "-" + (day < 10 ? ('0' + day) : day));
        i++;
      }
      return list.reverse();
    },
    myTool1() {
      this.duiDie.xAxis[0].data = this.getData(90);
      this.duiDie.series.map((item) => {
        item.data = this.randomData(90)
      });
    },
    timeRangeChange(data){
      // alert(this.timeRange,data);
      console.log(data);
    }
  },


}

</script>
