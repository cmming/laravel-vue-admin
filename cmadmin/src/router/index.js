import Vue from 'vue'
import Router from 'vue-router'
// 设置title脚本
// import setTitle from '../util/setTitle/setTitle.js'

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
        meta: { auth: true, title: "用户列表", },
        component: resolve => require(['../view/users.vue'], resolve)
      },
      {
        path: '/users/edit/:id',
        meta: { auth: true, title: "修改用户信息", },
        component: resolve => require(['../view/createUser.vue'], resolve)
      },
      {
        path: '/users/add',
        meta: { auth: true, title: "添加用户", },
        component: resolve => require(['../view/createUser.vue'], resolve)
      }
    ]
  }
];

// 定义路由对象
const router = new Router({
  routes
})

// 路由登录验证 会有很多问题（用户可以篡改客户端的数据）->所以在最后要将 打包后的index.html  改为php 页面，一直验证session是否存在，如果不存在直接将 前端存储的登录状态清空（），同时跳转到登录页面
router.beforeEach(({ meta, path }, from, next) => {
  
  document.getElementsByTagName('title')[0].innerHTML = meta.title;
  window.scroll(0, 0);
  // 依据localStorage是否存在来判断用户是否登录
  // var { auth = true } = meta;
  var auth = meta.auth;
  var isLogin = localStorage.getItem('token') ? Boolean(localStorage.getItem('token')) : false;
  // auth 表示需要验证的页面 isLogin表示验证通过的数据session 
  if (auth && !isLogin) {
      return next({ path: '/login' })
      // 只要跳到登录页面就自动清除localStorage
  } 
  next()
});


export default router
