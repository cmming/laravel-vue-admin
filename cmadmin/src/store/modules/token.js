//引入的接口文件
import {
    token
} from "../../api/services.js"
// 事件订阅者
import {
    SETTOKEN,
    UPDATETOKEN,
    DELETETOKEN,
    LOGINERROR
} from "../types"

const state = {
    token: {
        token: localStorage.token ? localStorage.token : '',
        expired_at: localStorage.expired_at ? localStorage.expired_at : '',
        refresh_time: localStorage.refresh_time ? localStorage.refresh_time : '',
        refresh_expired_at: localStorage.refresh_expired_at ? localStorage.refresh_expired_at : '',
        // 登录时候的错误提示
        requestError: false,
        errorMsg: ""
    },
}

const getters = {
    token: (state) => {
        return state.token
    }
}


const mutations = {
    // 设置 相关的 token
    SETTOKEN(state, data, vue) {
        if (data.code == 200) {
            state.token.token = data.data.token;
            state.token.expired_at = data.data.expired_at;
            state.token.refresh_time = data.data.refresh_time;
            state.token.refresh_expired_at = data.data.refresh_expired_at;
            vue.$router.push('main');
        } else {
            state.token.requestError = true;
            state.token.errorMsg = data.error;
        }

    },
    LOGINERROR(state, data) {
        state.token.requestError = true;
        state.token.errorMsg = data.error;
    }

    // 跟新 token 相关数据
    // UPDATETOKEN(state, data) { },
    // // 删除 token 相关数据
    // DELETETOKEN(state, data) { },
}


const actions = {
    // 登录的时候 进行初次设置 token 
    SETTOKEN({ commit }, params) {
        let vue = params.vue;
        token.adminLogin(vue, params.resData, function (response) {
            if (response.data.code == 200) {
                localStorage.token = response.data.data.token;
                localStorage.expired_at = response.data.data.expired_at;
                localStorage.refresh_time = response.data.data.refresh_time;
                localStorage.refresh_expired_at = response.data.data.refresh_expired_at;
                localStorage.userName = response.data.user.uname;
                vue.$router.push('main');
            } else {
                commit('LOGINERROR', response.data);
            }
        })
    },
    // 使用 刷新token的接口进行 设置
    // 退出登录 将所有的 token 相关数据删除
    DELETETOKEN({ commit }, params) {
        token.logout(params.vue, params.resData, function (response) {
            if (response.data.code == 200) {
                localStorage.removeItem("token");
                localStorage.removeItem("expired_at");
                localStorage.removeItem("refresh_time");
                localStorage.removeItem("refresh_expired_at");
                localStorage.removeItem("userName");
                params.vue.$router.push('/login');
            }
        })
    },
    UPDATETOKEN({ commit }, response) {
        token.refreshToken(params.vue, params.resData, function (response) {
            if (response.data.code == 200) {
                localStorage.token = response.data.data.token;
                localStorage.expired_at = response.data.data.expired_at;
                localStorage.refresh_time = response.data.data.refresh_time;
                localStorage.refresh_expired_at = response.data.data.refresh_expired_at;
            }
        })
    },
}

export default {
    state,
    getters,
    mutations,
    actions
}