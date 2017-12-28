/**
 * @Author   cm
 * @DateTime 2017-10-21
 * @license  [license]
 * 1.path == login -->跳转到需要判断用户是否登录的页面，便于实现自动登录
 * 2.用过一个字段 在store 中定义一个role 的字段来判断用户是否的权限是否为空，非空就通过 role 来判断用户是否拥有权限（GetInfo）
 * 3.通过 getInfo中的 role 获取页面的动态路由 谈后通过响应数据，设置到路由中的动态路由中 router.addRoutes
 *   
 * @param    {[type]}   options.meta [前置路由 的meta]
 * @param    {[type]}   options.path [前置路由 的path]
 * @param    {[type]}   from         [目标路由]
 * @param    {Function} next         [下一步的函数]
 * @return   {[type]}                [description]
 */
import router from '../index.js'
import store from '../../store'
import http from '../../api/http'


// const _import = require('../import/_import_' + process.env.NODE_ENV)
// 一个处理 动态路由 路由的函数


const filterAsyncRouter = (ansycRouterMap) => {
  ansycRouterMap.map((item, i) => {
    // item.componentPath = r => require.ensure([], () => r(require(item.componentPath)),r);
    item.componentPath = resolve => require([item.componentPath], resolve);
    if (item.has_son) {
      filterAsyncRouter(item.children);
    }
  });
  return ansycRouterMap;
}


const before = ({ meta, path }, from, next) => {
  let self = this;
  // 设置title
  document.getElementsByTagName('title')[0].innerHTML = meta.title;
  // 将页面自动滑动到页面的顶部
  window.scroll(0, 0);
  // 依据localStorage是否存在来判断用户是否登录
  // var { auth = true } = meta;
  var auth = meta.auth;
  //后台应该 将过期时间传过来 也可以作为跳转的要求
  var isLogin = localStorage.getItem('token') ? Boolean(localStorage.getItem('token')) : false;
  // auth 表示需要验证的页面 isLogin表示验证通过的数据session 
  if (auth && !isLogin) {
    return next({ path: '/login' })
    // 只要跳到登录页面就自动清除localStorage
  } else {
    if (store.getters.addRouters.length <= 0 || 1) {
      http.get('/routers').then(function(response) {
        var ansycRouterMap = filterAsyncRouter(response.data);
        console.log(ansycRouterMap, response);
        //处理 生成动态路由
        // console.log(ansycRouterMap);
        // router.options = router.options.concat(ansycRouterMap);
        // console.log(router.options.concat(ansycRouterMap));
        router.addRoutes(ansycRouterMap) // 动态添加可访问路由表
        // router.addRoutes(store.getters.addRouters) // 动态添加可访问路由表
      });
      // store.dispatch('ROUTERLIST',{vue:{$http:http}}).then((data)=>{
      //     // console.log(store.getters.addRouters.length,store.getters.addRouters);
      //     var ansycRouterMap = filterAsyncRouter(store.getters.addRouters);
      //     console.log(ansycRouterMap,data);
      //     //处理 生成动态路由
      //     // console.log(ansycRouterMap);
      //     router.addRoutes(store.getters.addRouters) // 动态添加可访问路由表
      // });
    }
    next()
  }
}

export default before;
