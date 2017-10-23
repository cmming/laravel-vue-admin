import Vue from 'vue'
import axios from 'axios'
// axios请求的请求配置文件
import store from '../store'
// 报错的 组件
import {
    Notification
} from 'element-ui';

// 全局设置
var gbs = {
    baseURL: process.env.API_ROOT,
    timeout: 5000,
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
}

// 请求的参数处理

var bes = function (data) {
    // 对 data 进行任意转换处理
    // return JSON.stringify(data);
    // return until.serializeObject(data);
    let ret = ''
    for (let it in data) {
        var obj = data[it];
        if (!(typeof (obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length)) {
            ret += encodeURIComponent(it) + '=' + encodeURIComponent(data[it]) + '&'
        } else {
            ret += encodeURIComponent(it) + '=' + JSON.stringify(data[it]) + '&'
        }
    }
    return ret
    // return data;
}

// 回调
var cbs = {
    //请求的拦截器
    requestInterceptors: {
        fn: function (config) {
            //每次 都将请求的 头部 进行取值 取保最新
            if (localStorage.token) {
                config.headers['Authorization'] = localStorage.getItem("token");
            }
            store.state.loading.loading = true;
            return config;
        },
        errFn: function (error) {
            //请求错误时做些事
            // 1.隐藏之前的loading组件 显示加载动画
            store.state.loading.loading = false;
            //请求错误时做些事
            return Promise.reject(error);
        }
    },
    // 响应拦截器
    responseInterceptors: {
        fn: function (response) {
            // console.log(response);
            //根据请求头部进行token 的主动刷新判断
            if (response.headers.lastmodified) {
                var lastmodified = response.headers.lastmodified;
                if (lastmodified > localStorage.refresh_time && lastmodified < localStorage.expired_at) {
                    axios.get(process.env.API_ROOT + "/refreshToken", {
                        headers: {
                            'Authorization': localStorage.getItem("token")
                        }
                    }).then(function (response) {
                        if (response.data.code == 200) {
                            localStorage.token = response.data.data.token;
                            localStorage.expired_at = response.data.data.expired_at;
                            localStorage.refresh_time = response.data.data.refresh_time;
                            localStorage.refresh_expired_at = response.data.data.refresh_expired_at;
                        }
                    });
                }
            }
            // 如果响应头部 有 Authorization 就自动 更新 token
            if (response.headers.Authorization) {
                localStorage.token = response.headers.Authorization;
            }
            var reStatus = response.status, alertMsg = '';
            switch (reStatus) {
                case 2041:
                    localStorage.removeItem('token');
                    window.location.href = '#/login';
                    break;
                case 201:
                    alertMsg = '数据添加成功'
                    break;
                case 204:
                    // delete 表示删除成功 put 或者 patch 表示 资源更新 成功
                    if (response.config.method == 'delete') {
                        alertMsg = '数据删除成功'
                    } else if (response.config.method == 'put' || 'patch') {
                        alertMsg = '数据更新成功'
                    }
                    break;
                default:
                    break;
            }
            if (alertMsg != '') {
                Notification.success({
                    title: '系统提示',
                    message: alertMsg,
                    //不关闭弹框
                    duration: 3000,
                })
            }
            // // 隐藏加载动画
            store.state.loading.loading = false;
            // return new Promise(() => {});
            return response;
        },
        // 错误的 响应
        errorFn: function (error) {
            //请求错误时做些事 1。改变请求的全局状态
            store.state.loading.loading = false;
            // console.log(error.response);
            if (error && error.response && error.response.status) {
                var errorStatus = error.response.status,
                    errorAlertMsg = '', errorAlertTitle = '';
                switch (errorStatus) {
                    case 400:
                        errorAlertTitle = '重新登录提示' + errorStatus;
                        errorAlertMsg = '长时间为操作，自动退出'
                        localStorage.removeItem('token');
                        window.location.href = '#/login';
                        break;
                    //token 过期
                    case 401:
                        errorAlertTitle = '重新登录提示' + errorStatus;
                        errorAlertMsg = '长时间为操作，自动退出'
                        localStorage.removeItem('token');
                        window.location.href = '#/login';
                        break;

                    case 405:
                        errorAlertTitle = '请求错误' + errorStatus;
                        errorAlertMsg = '请求方式错误'
                        break;
                    case 422:
                        errorAlertTitle = '前台非法输入字符';
                        if (error.response.data.errors) {
                            for (let i in error.response.data.errors) {
                                errorAlertMsg += (error.response.data.errors[i]['field'] + error.response.data.errors[i]['code']);
                            }
                        }
                        // window.location.href = '#/422';
                        break;
                    default:
                        errorAlertTitle = '未知错误' + errorStatus;
                        errorAlertMsg = '未知错误'
                        break;
                }

                if (errorAlertMsg != '' && errorAlertTitle != '') {
                    Notification.error({
                        title: errorAlertTitle,
                        message: errorAlertMsg,
                        //弹框 提示3秒
                        duration: 3000,
                        // customClass:""
                    });
                }
            }
            return Promise.reject(error);
        }
    }
}

export {
    gbs,
    bes,
    cbs
}
