// 接口的一级目录
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

import {
  gbs,
  bes,
  cbs
} from './httpSetting.js'


var instance = axios.create({
  //配置不同的接口地址
  baseURL: process.env.API_ROOT,
  // baseURL: '/api',
  // 规定所有的请求只有5s的等待
  timeout: 5000,
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  },
  // 对所有的请求数据统一转换为json字符串
  transformRequest: [bes],
});

// //添加请求拦截器
instance.interceptors.request.use(
  cbs.requestInterceptors.fn, 
  cbs.requestInterceptors.errFn, 
);

//添加响应拦截器 将刷新token 的动作放在后台 前台制作token 过期的操作
instance.interceptors.response.use(
  cbs.responseInterceptors.fn,
  cbs.responseInterceptors.errorFn
  );

Vue.use(VueAxios, instance)

export default instance


