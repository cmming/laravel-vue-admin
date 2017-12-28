import Vue from 'vue'
import Router from 'vue-router'
// 设置title脚本
// import setTitle from '../util/setTitle/setTitle.js'

import before from './before/index'

import axios from 'axios'

import {constRouterMap,ansycRouterMap} from './RouterMap/index'

import { Message } from 'element-ui';

// const _import = require('./import/_import_'+process.env.NODE_ENV+'.js')


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
  // routes
  routes: constRouterMap,
})

import store from '../store'
import http from '../api/http'


//有不支持变量导入文件 所以只能 从后台接口中 后去路由 然后结合 管理员的角色 生成动态的路由
const filterAsyncRouter = (ansycRouterMap) => {
  ansycRouterMap.map((item, i) => {
    // item.component = resolve => require(['../view/examples/tables.vue'], resolve);
    item.component = resolve => require([eval(item.componentPath)], resolve);
    if (item.has_son) {
      filterAsyncRouter(item.children);
    }
  });
  return ansycRouterMap;
}

//由于 不支持 变量作为文件的名称 所以只能通过 路由中的 role 字段 去过滤匹配
const arrayExistsSameValues = function(a1, a2) {
    var exists = false;
    if(a1 instanceof Array && a2 instanceof Array)
    {
        for (var i=0,iLen=a1.length; i<iLen; i++)
        {
            for (var j=0,jLen=a2.length; j<jLen; j++)
            {
                if (a1[i]===a2[j])
                {
                    return true;
                }
            }
        }
    }
    return exists;
};

//为路由添加 权限控制选项
const filterAsyncRouterByRole = (ansycRouterMap,userSysRole) => {
  ansycRouterMap.map((item, i) => {
    item['haspremission'] = arrayExistsSameValues(item.meta.role,userSysRole)
    if (item.has_son) {
      filterAsyncRouterByRole(item.children,userSysRole);
    }
  });
  return ansycRouterMap;
}

const tokenValudate = ()=>{
  return new Promise(resolve=>{
    http.get('validateToken').then((data)=>{
      if(data.data===1){
        resolve()
      }
    });
  });
}

// 路由登录验证 会有很多问题（用户可以篡改客户端的数据）->所以在最后要将 打包后的index.html  改为php 页面，一直验证session是否存在，如果不存在直接将 前端存储的登录状态清空（），同时跳转到登录页面
router.beforeEach((to, from, next) => {  
  // 设置title
  document.getElementsByTagName('title')[0].innerHTML = to.meta.title;
  // 将页面自动滑动到页面的顶部
  window.scroll(0, 0);
  // 依据localStorage是否存在来判断用户是否登录
  // var { auth = true } = meta;
  var auth = to.meta.auth;
  //判断路由是否存在
  var isLogin = localStorage.getItem('token') ? Boolean(localStorage.getItem('token')) : false;
  // auth 表示需要验证的页面 isLogin表示验证通过的数据session 
  if (auth && !isLogin) {
    return next({ path: '/login' })
    // 只要跳到登录页面就自动清除localStorage
  } else if(isLogin) {
    if (store.getters.sysUserRole.length <=0 ) {
        store.dispatch('USERINFO',{vue:{$http:http},router:router,ansycRouterMap:ansycRouterMap}).then(()=>{
          console.log('promise');
      });
    }

    next()
  }
  //判断 页面的路由是否能够匹配
  if(to.matched.length===0){
    // next('/error/404')
    //匹配失败 就直接返回上一次页面，或者直接跳转到登陆页面
    from.path ? next({ path:from.path}) : next('/');
    // console.log('no');
  }else{
    // console.log('ok');
    //匹配成功 就直接条到下一级
    next()
  }
  //验证 前端的token 是否正确，正确的话，直接 进入系统主页，或者跳转到上一个页面
  if(to.path=='/login'&&isLogin){
    //验证 token 是否存在 且合法
    http.get('validateToken').then((data)=>{
      if(data.data===1){
        console.log(from.path);
        (from.path&&from.path!='/') ? next({ path:from.path }) : next('/main');
        Message({
          showClose: true,
          message: '自动登录成功！',
          type: 'success'
        });
      }else{
        next()
      }
    });
  }
  // console.log(from.path,to.path);


});


export default router
