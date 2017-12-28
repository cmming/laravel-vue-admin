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

//由于动态路由要执行编译，所以必须 在项目内部 引入
// import {ansycRouterMap1} from 'D:/xampp/htdocs/laravel/cmadmin/src/router/RouterMap/ansycRouterMap.js'
// 后台生成的动态路由
import {ansycRouterMap1} from 'D:/xampp/htdocs/laravel/cmapi/storage/api/router/ansycRouterMap.js'

export const constRouterMap = [

  { path: '/', redirect: '/login', type: 'function' },
  {
    path: '/login',
    type: 'function',
    meta: { auth: false, title: "登录" },
    component: resolve => require(['../../view/signin.vue'], resolve)
  },
  {
    path: '/signup',
    type: 'function',
    meta: { auth: false, title: "注册" },
    component: resolve => require(['../../view/signup.vue'], resolve)
  },
  {
    path: '/admin',
    type: 'function',
    component: resolve => require(['../../view/mainIndex.vue'], resolve),
    children: [{
      path: '/main',
      type: 'menu',
      iconFont: 'fa fa-home',
      meta: { auth: true, title: "主页", },
      component: resolve => require(['../../view/main.vue'], resolve)
    }, ]
  }
];

// console.log(ansycRouterMap);


export const ansycRouterMap = ansycRouterMap1;