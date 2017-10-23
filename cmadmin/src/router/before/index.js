/**
 * @Author   cm
 * @DateTime 2017-10-21
 * @license  [license]
 * 1.path == login -->跳转到需要判断用户是否登录的页面，便于实现自动登录
 * 2.用过一个字段 在store 中定义一个role 的字段来判断用户是否的权限是否为空，非空就通过 role 来判断用户是否拥有权限
 *   
 * @param    {[type]}   options.meta [前置路由 的meta]
 * @param    {[type]}   options.path [前置路由 的path]
 * @param    {[type]}   from         [目标路由]
 * @param    {Function} next         [下一步的函数]
 * @return   {[type]}                [description]
 */
const before = ({ meta, path }, from, next) => {
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
    } 
    next()
  }

  export default before;