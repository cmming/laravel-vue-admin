//引入的接口文件
import {
    userRole
} from "../../api/services.js"
// 事件订阅者
import {
    USERROLELIST,
    ADDUSERROLE,
    USERROLEDETAIL,
    UPDATEUSERROLE,
    USERROLEPREMISSIONS,
    STOREUSERROLEPREMISSION
} from "../types"


const state = {
    userRoles: {
        //列表数据
        lists: [],
        allPage: '',
        curpage: 1,
        // 搜索参数
        searchData: { "name": '', "btime": "", "etime": "", "page": '1', },
        isUpdate: false,
        details: {},
        // 所有的 权限
        premissions:[]
    }
}

const getters = {
    userRoles: (state) => {
        return state.userRoles
    }
}


const mutations = {
    USERROLELIST(state, data) {
        //列表数据 赋值
        state.userRoles.lists = data.data;
        //  总页数赋值
        state.userRoles.allPage = data.meta.pagination.total_pages;
        //当前页的设置
        state.userRoles.curpage = data.meta.pagination.current_page;
    },
    USERROLEDETAIL(state,data){
        state.userRoles.details = data.data
    },
    USERROLEPREMISSIONS(state,data){
        state.userRoles.premissions = data
    }

}


const actions = {
    USERROLELIST({ commit }, params) {
        userRole.list(params.vue, params.resData, function (response) {
            commit(USERROLELIST, response.data);
        });
    },
    ADDUSERROLE({ commit }, params) {
        userRole.store(params.vue, params.resData, function (response) {
            if(response.status == 201){
                params.vue.$router.push('/user/roles');
            }
        });
    },
    USERROLEDETAIL({commit},params){
        userRole.show(params.vue,params.index,function(response){
            if(response.status == 200){
                commit(USERROLEDETAIL, response.data);
            }
        });
    },
    UPDATEUSERROLE({commit},params){
        userRole.update(params.vue,params.index,params.resData,function(response){
            if(response.status == 204){
                //直接跳转即可
                params.vue.$router.push('/user/roles');
            }
        });
    },
    USERROLEPREMISSIONS({commit},params){
        userRole.premissions(params.vue, params.resData, function (response) {
            commit(USERROLEPREMISSIONS, response.data);
        });
    },
    STOREUSERROLEPREMISSION({commit},params){
         userRole.storePremisison(params.vue,params.index,params.resData, function (response) {
            if(response.status == 204){
                params.vue.$router.push('/user/roles');
            }
        });
    }
}


export default {
    state,
    getters,
    mutations,
    actions
}