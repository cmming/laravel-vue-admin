
// import * as types from '../'
import * as types from '../types'

// 定义数据
// 获取用户信息 用户信息最好不要弄个vuex管理 应该使用localStorage使用
const state = {
    userInfo: {userName:""}
};
const getters = {
    userInfo: (state) => {
        return state.userInfo;
    }
};
// 4.action 的具体操作
const mutations = {
    [types.UPDATEUSERINFO](state,data) {
        console.log(state.userInfo);
        state.userInfo.userName = data;
    },
    [types.GETUSERINFO](state) {
        state.userInfo.userName =window.localStorage.userName
    },
    [types.CLEARUSERINFO](state){
        localStorage.removeItem('token');
        localStorage.removeItem('refresh_expired_at');
        localStorage.removeItem('userName');
    }

};

export default {
    state,
    getters,
    mutations
}