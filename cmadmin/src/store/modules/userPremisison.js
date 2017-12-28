//引入的接口文件
import {
    userPremission,
    premissionsResources,
    router
} from "../../api/services.js"
// 事件订阅者
import {
    USERPREMISSIONLIST,
    ADDUSERPREMISSION,
    UPDATEUSERPREMISSION,
    USERPREMISSIONDETAIL,
    PREMISSIONRESOURCES,
    STOREPREMISSIONRESOURCES,
    PGETALLROUTER,
    PREMISIONROUTERS,
    STOREPREMISSIONROUTER
} from "../types"


const state = {
    userPremissions: {
        //列表数据
        lists: [],
        allPage: '',
        curpage: 1,
        // 搜索参数
        searchData: { "name": '', "btime": "", "etime": "", "page": '1', },
        isUpdate: false,
        details: {},
        permisisonsResources:[],
        premissionsRouters:[],
        allRouter:[]
    }
}

const getters = {
    userPremissions: (state) => {
        return state.userPremissions
    }
}


const mutations = {
    USERPREMISSIONLIST(state, data) {
        //列表数据 赋值
        state.userPremissions.lists = data.data;
        //  总页数赋值
        state.userPremissions.allPage = data.meta.pagination.total_pages;
        //当前页的设置
        state.userPremissions.curpage = data.meta.pagination.current_page;
    },
    USERPREMISSIONDETAIL(state,data){
        state.userPremissions.details = data.data
    },
    PREMISSIONRESOURCES(state,data){
        if(data!=''){
            console.log(data.premisison_resource.resources_id,JSON.parse(data.premisison_resource.resources_id));
            state.userPremissions.permisisonsResources = JSON.parse(data.premisison_resource.resources_id);
        }else{
            state.userPremissions.permisisonsResources = [];
        }
    },
    PREMISIONROUTERS(state,data){
        state.userPremissions.premissionsRouters = data;
    },
    PGETALLROUTER(state, data) {
        state.userPremissions.allRouter = data;
      },

}


const actions = {
    USERPREMISSIONLIST({ commit }, params) {
        userPremission.list(params.vue, params.resData, function (response) {
            commit(USERPREMISSIONLIST, response.data);
        });
    },
    ADDUSERPREMISSION({ commit }, params) {
        userPremission.store(params.vue, params.resData, function (response) {
            console.log(response);
            if(response.status == 201){
                params.vue.$router.push('/user/premissions');
            }
        });
    },
    USERPREMISSIONDETAIL({commit},params){
        userPremission.show(params.vue,params.index,function(response){
            if(response.status == 200){
                commit(USERPREMISSIONDETAIL, response.data);
            }
        });
    },
    UPDATEUSERPREMISSION({commit},params){
        userPremission.update(params.vue,params.index,params.resData,function(response){
            if(response.status == 204){
                //直接跳转即可
                params.vue.$router.push('/user/premissions');
            }
        });
    },
    PREMISSIONRESOURCES({ commit }, params) {
        premissionsResources.premissonResources(params.vue,params.index,function(response){
            if(response.status == 200){
                commit(PREMISSIONRESOURCES,response.data)
            }
        });
    },
    STOREPREMISSIONRESOURCES({commit},params){
        premissionsResources.storePremissonResources(params.vue,params.resData,function(response){

        });
    },
    // 权限和路由的关系
    PREMISIONROUTERS({ commit }, params) {
        userPremission.routers(params.vue,params.index,function(response){
            if(response.status == 200){
                commit(PREMISIONROUTERS,response.data)
                //请求获取所有的路由
                router.all(params.vue, function(response) {
                    if(response.status == 200){
                      commit(PGETALLROUTER, response.data);
                    }
                });
            }
        });
    },
    // 保存 更新权限 的权限
    STOREPREMISSIONROUTER({ commit }, params) {
        userPremission.storeRouter(params.vue,params.index,params.resData,function(response){
            if(response.status == 204){
                //直接跳转即可
                // params.vue.$router.push('/user/premissions');
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