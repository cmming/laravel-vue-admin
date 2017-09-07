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
         * 用户注册
         * 
         * @param {json} data 用户注册信息 
         * @param {any} fn  接口成功回调
         */
        register(data,fn){
            this.$http.post('/register',data).then(fn);
        },
        logout(data,fn){
            this.$http.post('/logout').then(fn);
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
    },

};

export default allAjax;