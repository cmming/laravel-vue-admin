export const constRouterMap = [

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
