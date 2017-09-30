// 用户 原创 申请 

// 引入接口文件
import {
    userOriTmps
} from "../../api/services.js"

import {
    STOREUSERORITMP,
    UPDATEUSERORITMP,
    GETUSERORITMPLIST,
    SETUSERORITMPLIST,
    DELETEUSERORITMP,
    USERORIDETAIL
} from "./types.js"

// 1. 定义 state 
const state = {
    userOriTmp: {
        list: [],
        detail: [],
        allPage: '',
        curPage: 1,
        searchData: { "page": '1', "btime": "", "etime": "", "title": "" },
        formData: {
            "vid": '',
            // "vid": this.$route.params.id,
            "tid": "",
            "title": "",
            // "fname": "",
            "des": "",
            "att": {
                "fee": "",
                "free_time": "",
                "be_fp": ""
            }
        },
    }
}

const getters = {
    userOriTmp: (state) => {
        return state.userOriTmp
    }
}


const mutations = {
    // 为页面的详情 数据进行填充
    USERORIDETAIL(state, res) {
        for (let i in state.userOriTmp.formData) {
            if (i == "att") {
                state.userOriTmp.formData[i] = JSON.parse(res.data.data[i]);
            } else {
                state.userOriTmp.formData[i] = res.data.data[i];
            }
        }
    },
    SETUSERORITMPLIST(state, res) {
        state.userOriTmp.list = res.data.data;
        state.userOriTmp.allPage = res.data.meta.pagination.total_pages;
    }
}

const actions = {
    // 添加
    STOREUSERORITMP({ commit }, params) {
        userOriTmps.store(params.vue, params.resData, function (res) {
            // 只需要做好跳转就行 没有 mutation
            if (res.status == 201) {
                // 跳转到 list 
                params.vue.$router.push('/UserOriTmps');
            }
        });
    },
    // 更新数据
    UPDATEUSERORITMP({ commit }, params) {
        userOriTmps.update(params.vue, params.index, params.resData, function (res) {
            if (res.status == 204) {
                // 跳转到 list 
                params.vue.$router.push('/UserOriTmps');
            }
        })
    },
    // 获取 一个 原创申请 的详情
    USERORIDETAIL({ commit }, params) {
        userOriTmps.show(params.vue, params.index, function (res) {
            commit(USERORIDETAIL, res);
        });
    },
    // 获取 原创 列表
    GETUSERORITMPLIST({ commit }, params) {
        userOriTmps.list(params.vue, params.resData, function (res) {
            // 发送一个 mutation 对 view数据 进行修改
            commit(SETUSERORITMPLIST, res);
        });
    },
    // 删除 
    DELETEUSERORITMP({ commit }, params) {
        userOriFiles.delete(params.vue, params.resData, function (response) {
            //成功的回调
            console.log(response.status);
            if (response.status == 204) {
                // 再次请求一下 commit
                // 格式化 请求参数
                var resData = params.vue.getDataFormat(state.userOriTmp.searchData);
                console.log(resData);
                // 再次请求一下 commit
                userOriTmps.list(params.vue, params.resData, function (res) {
                    // 发送一个 mutation 对 view数据 进行修改
                    commit(SETUSERORITMPLIST, res);
                });
            }
        })
    }

}

export default {
    state,
    getters,
    mutations,
    actions
}