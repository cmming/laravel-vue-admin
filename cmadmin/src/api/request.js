// 将所有的请求写在这里
// 接口的二级目录
const allAjax = {
    userData: {
        
        /**
         * 登录接口
         * 
         * @param {json} data 发送的数据
         * @param {Function} fn 接口的成功回调函数
         */
        login(data, fn) {
            this.$http.post('/login',data).then(fn);
        },
        /**
         * admin登录接口
         * 
         * @param {json} data 发送的数据
         * @param {Function} fn 接口的成功回调函数
         */
        adminLogin(data, fn) {
            this.$http.post('/adminLogin',data).then(fn);
        },
        /**
         * 用户注册
         * 
         * @param {json} data 用户注册信息 
         * @param {any} fn  接口成功回调
         */
        register(data,fn){
            this.$http.post('/register',data).then(fn);
        },
        logout(data,fn){
            this.$http.post('/adminLogout').then(fn);
        }
    },

   
    users:{
        /**
         * 
         * 
         * @param {any} data 
         * @param {any} fn 
         */
        userLisr(data,fn){
            this.$http.get('/users?'+data).then(fn);
        },
         /**
         * 
         * 一个用户的详情
         * @param {any} data 
         * @param {any} fn 
         */
        userShow(data,fn){
            this.$http.get('/users/'+data).then(fn);
        },
         /**
         * 
         * 更新一个用户
         * @param {any} data 
         * @param {any} fn 
         */
        userUpdate(url,data,fn){
            this.$http.post(url,data).then(fn);
        },
         /**
         * 
         * 添加一个用户
         * @param {any} data 
         * @param {any} fn 
         */
        userStore(data,fn){
            console.log(data);
            this.$http.post('/users',data).then(fn);
        },
        /**
         * 
         * 删除一个用户
         * @param {any} data 
         * @param {any} fn 
         */
        userDelete(url,data,fn){
            this.$http.post(url,data).then(fn);
        },
    },
     //用户资源模块
     userOriFiles:{
        /**
         * 
         * 获取资源的列表
         * @param {any} data 
         * @param {any} fn 
         */
        list(data,fn){
            this.$http.get('/userOriFiles?'+data).then(fn);
        },
         /**
         * 
         * 一个用户资源模块的详情
         * @param {any} data 
         * @param {any} fn 
         */
        show(data,fn){
            this.$http.get('/userOriFiles/'+data).then(fn);
        },
         /**
         * 
         * 更新一个用户资源模块
         * @param {any} data 
         * @param {any} fn 
         */
        update(index,data,fn){
            this.$http.post('/userOriFiles/'+index,data).then(fn);
        },
         /**
         * 
         * 添加一个用户资源模块
         * @param {any} data 
         * @param {any} fn 
         */
        store(data,fn){
            console.log(data);
            this.$http.post('/userOriFiles',data).then(fn);
        },
        /**
         * 
         * 删除一个用户资源模块
         * @param {any} data 
         * @param {any} fn 
         */
        delete(data,fn){
            this.$http.post('/userOriFiles/'+data,{_method:'delete'}).then(fn);
        },
    },
    //用户原创申请模块
    userOriTmps:{
        /**
         * 
         * 获取原创的列表
         * @param {any} data 
         * @param {any} fn 
         */
        list(data,fn){
            this.$http.get('/userOriTmps?'+data).then(fn);
        },
         /**
         * 
         * 一个用户原创的详情
         * @param {any} data 
         * @param {any} fn 
         */
        show(data,fn){
            this.$http.get('/userOriTmps/'+data).then(fn);
        },
         /**
         * 
         * 更新一个用户原创
         * @param {any} data 
         * @param {any} fn 
         */
        update(index,data,fn){
            this.$http.post('/userOriTmps/'+index,data).then(fn);
        },
         /**
         * 
         * 添加一个用户原创
         * @param {any} data 
         * @param {any} fn 
         */
        store(data,fn){
            console.log(data);
            this.$http.post('/userOriTmps',data).then(fn);
        },
        /**
         * 
         * 删除一个用户原创
         * @param {any} data 
         * @param {any} fn 
         */
        delete(data,fn){
            this.$http.post('/userOriTmps/'+data,{_method:'delete'}).then(fn);
        },
    },
};

export default allAjax;