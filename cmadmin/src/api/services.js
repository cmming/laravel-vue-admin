// 将所有的请求写在这里
// 分模块导出

// TOKEN 相关的

const token = {
  /**
   * admin登录接口
   * 
   * @param {json} data 发送的数据
   * @param {Function} fn 接口的成功回调函数
   */
  adminLogin(t, data, fn) {
    t.$http.post('/adminLogin', data).then(fn);
  },
  /**
   * 退出登录
   * 
   * @param {json} data 发送的数据
   * @param {Function} fn 接口的成功回调函数
   */
  logout(t, data, fn) {
    t.$http.get('/adminLogout').then(fn);
  },
  /**
   * 刷新token 
   * 
   */
  refreshToken(t) {
    t.$http.get('/refreshToken');
  },

}

// 系统对用户的个性化配置
const userSys = {
  getInfo(t, fn) {
    t.$http.get('/userInfo').then(fn);
  },
}

//读者的资源请求
const userOriFiles = {
  /**
   * 
   * 获取资源的列表 get
   * @param {any} data 
   * @param {any} fn 
   */
  list(t, data, fn) {
    t.$http.get('/userOriFiles?' + data).then(fn);
  },
  /**
   * 
   * 一个用户资源模块的详情
   * @param {any} data 
   * @param {any} fn 
   */
  show(t, data, fn) {
    t.$http.get('/userOriFiles/' + data).then(fn);
  },
  /**
   * 
   * 更新一个用户资源模块 PUT/PATCH
   * @param {any} data 
   * @param {any} fn 
   */
  update(t, index, data, fn) {
    t.$http.put('/userOriFiles/' + index, data).then(fn);
  },
  /**
   * 
   * 添加一个用户资源模块 post
   * @param {any} data 
   * @param {any} fn 
   */
  store(data, fn) {
    console.log(data);
    this.$http.post('/userOriFiles', data).then(fn);
  },
  /**
   * 
   * 删除一个用户资源模块 delete DELETE
   * @param {any} data 
   * @param {any} fn 
   */
  delete(t, data, fn) {
    t.$http.delete('/userOriFiles/' + data, ).then(fn);
  },
}


// 用户 原创 申请

const userOriTmps = {
  /**
   * 
   * 添加一个用户原创
   * @param {any} data 
   * @param {any} fn 
   */
  store(t, data, fn) {
    t.$http.post('/userOriTmps', data).then(fn);
  },

  /**
   * 
   * 更新一个用户原创
   * @param {any} data 
   * @param {any} fn 
   */
  update(t, index, data, fn) {
    t.$http.put('/userOriTmps/' + index, data).then(fn);
  },

  /**
   * 
   * 一个用户原创的详情
   * @param {any} data 
   * @param {any} fn 
   */
  show(t, data, fn) {
    t.$http.get('/userOriTmps/' + data).then(fn);
  },

  /**
   * 
   * 获取用户申请列表 get
   * @param {any} data 
   * @param {any} fn 
   */
  list(t, data, fn) {
    t.$http.get('/userOriTmps?' + data).then(fn);
  },

  /**
   * 
   * 删除一个用户申请资源模块 delete DELETE
   * @param {any} data 
   * @param {any} fn 
   */
  delete(t, data, fn) {
    t.$http.delete('/userOriTmps/' + data).then(fn);
  },
}

const userPremission = {
  /**
   * 
   * 获取用户权限列表 get
   * @param {any} data 
   * @param {any} fn 
   */
  list(t, data, fn) {
    t.$http.get('/userPremissions?' + data).then(fn);
  },

  /**
   * 
   * 添加一个用户权限
   * @param {any} data 
   * @param {any} fn 
   */
  store(t, data, fn) {
    t.$http.post('/userPremissions', data).then(fn);
  },

  /**
   * 
   * 一个用户权限的详情
   * @param {any} data 
   * @param {any} fn 
   */
  show(t, data, fn) {
    t.$http.get('/userPremissions/' + data).then(fn);
  },

  /**
   * 
   * 更新一个用户权限
   * @param {any} data 
   * @param {any} fn 
   */
  update(t, index, data, fn) {
    t.$http.put('/userPremissions/' + index, data).then(fn);
  },
  routers(t, index, fn) {
    t.$http.get('/userPremissions/routers/' + index).then(fn);
  },
  /**
   * 保存 权限
   * @Author   cm
   * @DateTime 2017-10-11
   * @param    {[type]}   t    [description]
   * @param    {[type]}   data [description]
   * @param    {Function} fn   [description]
   */
  storeRouter(t, index, data, fn) {
    t.$http.post('userPremissions/routers/' + index, data).then(fn);
  }

}


// 用户角色模块

const userRole = {
  /**
   * 
   * 获取用户角色列表 get
   * @param {any} data 
   * @param {any} fn 
   */
  list(t, data, fn) {
    t.$http.get('/userRoles?' + data).then(fn);
  },

  /**
   * 
   * 添加一个用户角色
   * @param {any} data 
   * @param {any} fn 
   */
  store(t, data, fn) {
    t.$http.post('/userRoles', data).then(fn);
  },

  show(t, data, fn) {
    t.$http.get('/userRoles/' + data).then(fn);
  },
  update(t, index, data, fn) {
    t.$http.put('/userRoles/' + index, data).then(fn);
  },
  /**
   * 获取 用户角色拥有的权限
   * 
   */
  premissions(t, data, fn) {
    t.$http.get('/userRoles/' + data + '/premissions').then(fn);
  },
  /**
   * 保存角色权限
   * @Author   cm
   * @DateTime 2017-10-11
   * @param    {[type]}   t    [description]
   * @param    {[type]}   data [description]
   * @param    {Function} fn   [description]
   */
  storePremisison(t, index, data, fn) {
    t.$http.post('/userRoles/' + index + '/premissions', data).then(fn);
  },



}

// 用户模块
const user = {
  list(t, data, fn) {
    t.$http.get('/users?' + data).then(fn);
  },
  roles(t, data, fn) {
    t.$http.get('/user/' + data + '/roles').then(fn);
  },
  storeRoles(t, index, data, fn) {
    t.$http.post('/user/' + index + '/roles', data).then(fn);
  }
}

/**
 * 目录文件 接口
 * @type {Object}
 */
const menu = {
  list(t, fn) {
    t.$http.get('/menus').then(fn);
  },
  delete(t, data, fn) {
    t.$http.delete('/menus/' + data).then(fn);
  },
  update(t, data, fn) {
    t.$http.put('/menus', data).then(fn);
  },
  store(t, data, fn) {
    t.$http.post('/menus', data).then(fn);
  },
  userMenus(t, fn) {
    t.$http.get('/userMenus').then(fn);
  },

}


//权限资源配置
const premissionsResources = {
  premissonResources(t, data, fn) {
    t.$http.get('/premissonResources/' + data).then(fn);
  },
  storePremissonResources(t, data, fn) {
    t.$http.post('/premissonResources', data).then(fn);
  },
}

// 路由部分api
const router = {
  store(t, data, fn) {
    t.$http.post('/routers', data).then(fn);
  },
  list(t, fn) {
    t.$http.get('/routers').then(fn);
  },
  addRouters(t, fn) {
    t.get('/routers').then(fn);
  },
  update(t, data, fn) {
    t.$http.put('/routers', data).then(fn);
  },
  all(t, fn) {
    t.$http.get('/routers/all').then(fn);
  },
}


// 博客 类型
const blogTopic = {
  list(t, data, fn) {
    t.$http.get('/blog/topics?' + data).then(fn);
  },
  show(t, data, fn) {
    t.$http.get('/blog/topics/' + data).then(fn);
  },
  store(t, data, fn) {
    t.$http.post('/blog/topics', data).then(fn);
  },
  update(t, index, data, fn) {
    t.$http.put('/blog/topics/' + index + '', data).then(fn);
  }
}


// 博客 内容接口
const blogPosts = {
  // 文章列表的接口
  list(t, data, fn) {
    t.$http.get('/blog/posts?' + data).then(fn);
  },

}


export {
  token,
  userOriFiles,
  userOriTmps,
  userPremission,
  userRole,
  user,
  menu,
  premissionsResources,
  router,
  userSys,
  blogTopic,
  blogPosts
};