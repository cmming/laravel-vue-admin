// 将所有的请求写在这里
// 分模块导出

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
}


export {
    userOriFiles,
    userOriTmps,
};