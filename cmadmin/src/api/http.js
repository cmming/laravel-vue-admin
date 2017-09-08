
// 接口的一级目录
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import store from '../store'
// 全局方法错误请求的方法
import { Notification } from 'element-ui';


var instance = axios.create({
  //配置不同的接口地址
  baseURL: process.env.API_ROOT,
  // baseURL: '/api',
  // 规定所有的请求只有1s的等待
  timeout: 5000,
  headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  // 对所有的请求数据统一转换为json字符串
  transformRequest: [function (data) {
    // 对 data 进行任意转换处理
    // return JSON.stringify(data);
    // return until.serializeObject(data);
    let ret = ''
    for (let it in data) {
      ret += encodeURIComponent(it) + '=' + encodeURIComponent(data[it]) + '&'
    }
    return ret
    // return data;
  }],
});

// //添加请求拦截器
instance.interceptors.request.use(function (config) {
  // 在发送请求之前做某件事
  // if(config.method  === 'post'){
  //     // JSON 转换为 FormData
  //     const formData = new FormData()
  //     Object.keys(config.data).forEach(key => formData.append(key, config.data[key]))
  //     config.data = formData
  // }

  if (localStorage.token) {
    config.headers['Authorization'] = 'Bearer ' + localStorage.getItem("token");
  }
  // 在发送请求之前做某事
  // 1.加载一个loading的样式组件
  store.state.loading.loading = true;
  return config;
}, function (error) {
  //请求错误时做些事
  // 1.隐藏之前的loading组件 显示加载动画
  store.state.loading.loading = false;
  // 全局方法错误请求的方法
  // Notification.error({
  //   title: '错误',
  //   message: '请求失败，联系管理员'
  // });
  // return Promise.reject(error);
});

//添加响应拦截器 将刷新token 的动作放在后台 前台制作token 过期的操作
instance.interceptors.response.use(function (response) {
  // console.log(response.status);
  var reStatus = response.status;
  switch (reStatus) {
    case 401:
      localStorage.removeItem('token');
      window.location.href = '#/login';
      break;
    default:
      break;
  }
  // // 隐藏加载动画
  store.state.loading.loading = false;

  return response;
}, function (error) {
  //请求错误时做些事 1。改变请求的全局状态
  store.state.loading.loading = false;
  console.log(error.response.status);
  if (error.response.status) {
  // if (0) {
    var errorStatus = error.response.status;
    switch (errorStatus) {
      //token 过期
      case 401:
        var now = 3, timer = null;
        var showAlert = Notification.error({
          title: '错误',
          message: error.response.data + '，' + now + 's,即将跳转到登录页面，请重新登录',
          //不关闭弹框
          duration: 0,
          // customClass:""
        });
        timer = setInterval(function () {
          if (now > 0) {
            //修改提示框中的时间
            showAlert.$el.getElementsByClassName('el-notification__content')[0].innerHTML = error.response.data + '，<span style ="color:red;font-size:20px">' + now + 's</span>后,即将跳转到登录页面，请重新登录';
            now--;
          } else {
            //清除定时器
            clearInterval(timer);
            //关闭提示框
            showAlert.close();
            localStorage.removeItem('token');
            window.location.href = '#/login';
          }
        }, 1000);
        break;
      case 422:
        var errorMsg = '错误码：' + errorStatus;
        console.log(error.response.data.errors);
        if (error.response.data.errors) {
          for(let i in error.response.data.errors){
            errorMsg+=(error.response.data.errors[i]['field']+error.response.data.errors[i]['code']);
          }
        }
        Notification.error({
          title: '错误',
          message: errorMsg,
          //不关闭弹框
          duration: 0,
          // customClass:""
        });
        break;
      default:

        break;

    }
  }


  // 全局方法错误请求的方法
  // Notification.error({
  //   title: '错误',
  //   message: '响应失败，联系管理员'
  // });
  return Promise.reject(error);
});

Vue.use(VueAxios, instance)
