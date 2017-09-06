import Vue from 'vue'
import Router from 'vue-router'
// 设置title脚本
import setTitle from '../util/setTitle/setTitle.js'

import axios from 'axios'

import Hello from '@/components/Hello'

Vue.use(Router)



const routes = [
  { path: '/', redirect: '/login' },
  {
    path: '/login',
    meta: { auth: false, title: "登录" },
    component: resolve => require(['../view/signin.vue'], resolve)
  },
  {
    path: '/signup',
    meta: { auth: false, title: "注册" },
    component: resolve => require(['../view/signup.vue'], resolve)
  },
  {
    path: '/admin',
    component: resolve => require(['../view/mainIndex.vue'], resolve),
    children: [
      {
        path: '/main',
        meta: { auth: true, title: "消息列表", },
        component: resolve => require(['../view/main.vue'], resolve)
      },
      {
        path: '/users',
        meta: { auth: true, title: "消息列表", },
        component: resolve => require(['../view/users.vue'], resolve)
      }
    ]
  }
];

// 定义路由对象
const router = new Router({
  routes
})



export default router
