// 将所有的请求写在这里
// 分模块导出

//读者的资源请求
const userOriFiles =  {
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
    show(data, fn) {
        this.$http.get('/userOriFiles/' + data).then(fn);
    },
    /**
    * 
    * 更新一个用户资源模块 PUT/PATCH
    * @param {any} data 
    * @param {any} fn 
    */
    update(index, data, fn) {
        this.$http.post('/userOriFiles/' + index, data).then(fn);
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
    delete(t,data, fn) {
        t.$http.delete('/userOriFiles/' + data,).then(fn);
    },
}


export { userOriFiles };