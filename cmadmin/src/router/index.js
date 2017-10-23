import Vue from 'vue'
import Router from 'vue-router'
// 设置title脚本
// import setTitle from '../util/setTitle/setTitle.js'

import before from './before/index'

import axios from 'axios'


Vue.use(Router)

/**
 * path 路由路径
 * type 路由类型
 * meta.auth 是否需要登录
 * meta.title 页面的title 和菜单的名称
 * meta.role 路由与角色的关系
 * meta.dropDown 菜单是否有子菜单
 */

// 将路由切割为 通用路由和异步路由两个部分 
// 为所有的路由添加 iconFont（非必须参数） 和 type(必须参数，路由的类型)：menu(菜单) button（按钮） function(功能页面，不出现在菜单上) 
// meta:{role:['']} 路由与权限的关系，还是路由与角色的关系？？？
// 路由的权限直接关联的是 premission ,最后生成的动态路由实际是由后台动态生成的，人工维护成本太大，
// 最终生成的目录中的 meta.role 是通过后台查询生成的与用户角色关联的数据。应为登陆后前台只知道用户的角色，
// 不可能将用户的权限都发给前台，否则用户角色这个概念就失去意义

// 通用路由
const constRouterMap = [

  { path: '/', redirect: '/login', type: 'function' },
  {
    path: '/login',
    type: 'function',
    meta: { auth: false, title: "登录" },
    component: resolve => require(['../view/signin.vue'], resolve)
  },
  {
    path: '/signup',
    type: 'function',
    meta: { auth: false, title: "注册" },
    component: resolve => require(['../view/signup.vue'], resolve)
  },
  {
    path: '/admin',
    type: 'function',
    component: resolve => require(['../view/mainIndex.vue'], resolve),
    children: [{
      path: '/main',
      type: 'menu',
      iconFont: 'fa fa-home',
      meta: { auth: true, title: "主页", },
      component: resolve => require(['../view/main.vue'], resolve)
    }, ]
  }
];


// 这个部分最终由后台维护生成。 调试部分先从前台入手
// 
const ansycRouterMap = [

  // 文件相关的路由
  {
    path: '/files',
    type: 'menu',
    iconFont: 'fa fa-file',
    meta: { auth: true, title: "文件", role: [], dropDown: true },
    component: resolve => require(['../view/mainIndex.vue'], resolve),
    children: [{
        path: '/files/add',
        type: 'menu',
        meta: { auth: true, title: "上传文件", },
        component: resolve => require(['../view/uploadFile.vue'], resolve)
      },
      {
        path: '/userOriFiles',
        type: 'menu',
        meta: { auth: true, title: "用户原创文件列表", },
        component: resolve => require(['../view/userOriFiles.vue'], resolve)
      },
      {
        path: '/UserOriFiles/add',
        type: 'function',
        meta: { auth: true, title: "添加用户原创资源", },
        component: resolve => require(['../view/UserOriTmpsForm.vue'], resolve)
      },
      {
        path: '/UserOriFiles/edit/:id',
        type: 'function',
        meta: { auth: true, title: "修改用户原创", },
        component: resolve => require(['../view/userOriFileForm.vue'], resolve)
      },
      {
        path: '/UserOriFiles/add/:id',
        type: 'function',
        meta: { auth: true, title: "添加原创申请", },
        component: resolve => require(['../view/UserOriTmpsForm.vue'], resolve)
      },
      {
        path: '/UserOriTmps',
        type: 'menu',
        meta: { auth: true, title: "用户原创列表", },
        component: resolve => require(['../view/UserOriTmps.vue'], resolve)
      },
      {
        path: '/UserOriTmps/edit/:id',
        type: 'function',
        meta: { auth: true, title: "修改用户原创申请", },
        component: resolve => require(['../view/UserOriTmpsForm.vue'], resolve)
      },
    ]
  },
  // 权限相关的路由
  {
    path: '/users',
    type: 'menu',
    iconFont: 'fa fa-cogs',
    meta: { auth: true, title: "用户权限", role: [], dropDown: true },
    component: resolve => require(['../view/mainIndex.vue'], resolve),
    children: [{
        type: 'menu',
        path: '/user/premissions',
        meta: { auth: true, title: "用户权限列表", },
        component: resolve => require(['../view/userPremission/list.vue'], resolve)
      },
      {
        type: 'function',
        path: '/user/premissions/edit/:id',
        meta: { auth: true, title: "修改用户权限", },
        component: resolve => require(['../view/userPremission/form.vue'], resolve)
      },
      {
        type: 'function',
        path: '/user/premissions/add',
        meta: { auth: true, title: "添加用户权限", },
        component: resolve => require(['../view/userPremission/form.vue'], resolve)
      },
      // 用户角色管理
      {
        type: 'menu',
        path: '/user/roles',
        meta: { auth: true, title: "用户角色列表", },
        component: resolve => require(['../view/userRole/list.vue'], resolve)
      },
      {
        type: 'function',
        path: '/user/roles/edit/:id',
        meta: { auth: true, title: "修改用户角色", },
        component: resolve => require(['../view/userRole/form.vue'], resolve)
      },
      {
        type: 'function',
        path: '/user/roles/add',
        meta: { auth: true, title: "添加用户角色", },
        component: resolve => require(['../view/userRole/form.vue'], resolve)
      },
      {
        type: 'function',
        path: '/user/roles/:id/premission',
        meta: { auth: true, title: "角色权限管理", },
        component: resolve => require(['../view/userRole/rolePremission.vue'], resolve)
      },
      {
        type: 'menu',
        path: '/users',
        meta: { auth: true, title: "用户列表", },
        component: resolve => require(['../view/user/list.vue'], resolve)
      },
      {
        path: '/user/:id/roles',
        meta: { auth: true, title: "用户角色管理", },
        component: resolve => require(['../view/user/roles.vue'], resolve)
      },
      {
        type: 'menu',
        path: '/menus',
        meta: { auth: true, title: "菜单管理", },
        component: resolve => require(['../view/menu/list.vue'], resolve)
      },
      {
        type: 'function',
        path: '/menu/add',
        meta: { auth: true, title: "添加菜单管理", },
        component: resolve => require(['../view/menu/form.vue'], resolve)
      },
      {
        type: 'function',
        path: '/menu/edit/:id',
        meta: { auth: true, title: "添加菜单管理", },
        component: resolve => require(['../view/menu/form.vue'], resolve)
      },
      {
        type: 'function',
        path: '/user/premissions/menus',
        meta: { auth: true, title: "权限菜单管理", },
        component: resolve => require(['../view/menu/form.vue'], resolve)
      },
      {
        type: 'function',
        path: '/dataCenter/dashboard',
        meta: { auth: true, title: "数据中心-仪表盘", },
        component: resolve => require(['../view/dataCenter/dashboard.vue'], resolve)
      },
    ]
  },
  // 数据中心
  {
    path: '/dataCenter',
    type: 'menu',
    iconFont: 'fa fa-area-chart',
    meta: { auth: true, title: "数据中心", role: [], dropDown: true },
    component: resolve => require(['../view/mainIndex.vue'], resolve),
    children: [
      {
        type: 'menu',
        path: 'dashboard',
        meta: { auth: true, title: "数据中心-仪表盘", },
        component: resolve => require(['../view/dataCenter/dashboard.vue'], resolve)
      },
    ]
  }

];

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
    children: [{
        path: '/422',
        meta: { auth: false, title: "非法输入" },
        component: resolve => require(['../view/error422.vue'], resolve)
      },
      {
        path: '/main',
        meta: { auth: true, title: "主页", },
        component: resolve => require(['../view/main.vue'], resolve)
      },
      {
        path: '/files/add',
        meta: { auth: true, title: "上传文件", },
        component: resolve => require(['../view/uploadFile.vue'], resolve)
      },
      {
        path: '/userOriFiles',
        meta: { auth: true, title: "用户原创文件列表", },
        component: resolve => require(['../view/userOriFiles.vue'], resolve)
      },
      {
        path: '/UserOriFiles/add',
        meta: { auth: true, title: "添加用户原创资源", },
        component: resolve => require(['../view/UserOriTmpsForm.vue'], resolve)
      },
      {
        path: '/UserOriFiles/edit/:id',
        meta: { auth: true, title: "修改用户原创", },
        component: resolve => require(['../view/userOriFileForm.vue'], resolve)
      },
      {
        path: '/UserOriFiles/add/:id',
        meta: { auth: true, title: "添加原创申请", },
        component: resolve => require(['../view/UserOriTmpsForm.vue'], resolve)
      },
      {
        path: '/UserOriTmps',
        meta: { auth: true, title: "用户原创列表", },
        component: resolve => require(['../view/UserOriTmps.vue'], resolve)
      },
      {
        path: '/UserOriTmps/edit/:id',
        meta: { auth: true, title: "修改用户原创申请", },
        component: resolve => require(['../view/UserOriTmpsForm.vue'], resolve)
      },
      // 用户权限管理
      {
        path: '/user/premissions',
        meta: { auth: true, title: "用户权限列表", },
        component: resolve => require(['../view/userPremission/list.vue'], resolve)
      },
      {
        path: '/user/premissions/edit/:id',
        meta: { auth: true, title: "修改用户权限", },
        component: resolve => require(['../view/userPremission/form.vue'], resolve)
      },
      {
        path: '/user/premissions/add',
        meta: { auth: true, title: "添加用户权限", },
        component: resolve => require(['../view/userPremission/form.vue'], resolve)
      },
      // 用户角色管理
      {
        path: '/user/roles',
        meta: { auth: true, title: "用户角色列表", },
        component: resolve => require(['../view/userRole/list.vue'], resolve)
      },
      {
        path: '/user/roles/edit/:id',
        meta: { auth: true, title: "修改用户角色", },
        component: resolve => require(['../view/userRole/form.vue'], resolve)
      },
      {
        path: '/user/roles/add',
        meta: { auth: true, title: "添加用户角色", },
        component: resolve => require(['../view/userRole/form.vue'], resolve)
      },
      {
        path: '/user/roles/:id/premission',
        meta: { auth: true, title: "角色权限管理", },
        component: resolve => require(['../view/userRole/rolePremission.vue'], resolve)
      },
      {
        path: '/users',
        meta: { auth: true, title: "用户列表", },
        component: resolve => require(['../view/user/list.vue'], resolve)
      },
      {
        path: '/user/:id/roles',
        meta: { auth: true, title: "用户角色管理", },
        component: resolve => require(['../view/user/roles.vue'], resolve)
      },
      {
        path: '/menus',
        meta: { auth: true, title: "菜单管理", },
        component: resolve => require(['../view/menu/list.vue'], resolve)
      },
      {
        path: '/menus/demo',
        meta: { auth: true, title: "菜单管理升级", },
        component: resolve => require(['../view/menu/list1.vue'], resolve)
      },
      {
        path: '/menu/add',
        meta: { auth: true, title: "添加菜单管理", },
        component: resolve => require(['../view/menu/form.vue'], resolve)
      },
      {
        path: '/menu/edit/:id',
        meta: { auth: true, title: "添加菜单管理", },
        component: resolve => require(['../view/menu/form.vue'], resolve)
      },
      {
        path: '/user/premissions/menus',
        meta: { auth: true, title: "权限菜单管理", },
        component: resolve => require(['../view/menu/form.vue'], resolve)
      },
      {
        path: '/dataCenter/dashboard',
        meta: { auth: true, title: "数据中心-仪表盘", },
        component: resolve => require(['../view/dataCenter/dashboard.vue'], resolve)
      },
      {
        path: '/example/table',
        meta: { auth: true, title: "综合实例-表格", },
        component: resolve => require(['../view/examples/tables.vue'], resolve)
      },

    ]
  }
];

// 定义路由对象
const router = new Router({
  routes
})

// 路由登录验证 会有很多问题（用户可以篡改客户端的数据）->所以在最后要将 打包后的index.html  改为php 页面，一直验证session是否存在，如果不存在直接将 前端存储的登录状态清空（），同时跳转到登录页面
router.beforeEach(before);


export default router
