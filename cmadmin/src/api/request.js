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
        signup(data,fn){
            this.$http.post('/login',data).then(fn);
        },
        signout(data,fn){
            this.$http.post('/',data).then(fn);
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
    },

};

export default allAjax;