//引入的接口文件
import {
  router
} from "../../api/services.js"

import {
  ADDROUTER,
  ROUTERLIST,
  UPDATEROUTER,
  GETALLROUTER
} from "../types"


const state = {
  router: {
    //由用户的角色 生成的动态路由
    lists: [],
    //编辑 路由
    allRouter:[],
    details: {
      parent_id: '',
      parent_title: '',
      title: '',
      iconFont: '',
      path: '',
      componentPath: '',
      type: '',
      sort: 1
    },
    typeArr: { 'menu': '菜单', 'function': '功能', 'button': '按钮' },
  },
  addRouters:[]
}

const getters = {
  router: (state) => {
    return state.router;
  },
  addRouters:(state)=>{
    return state.addRouters;
  }
}


const mutations = {
  ROUTERLIST(state, data) {
    state.router.lists = data;
    state.addRouters = data;
  },
  GETALLROUTER(state, data) {
    state.router.allRouter = data;
  },
}



const actions = {
  ADDROUTER({ commit }, params) {
    router.store(params.vue, params.resData, function(response) {
      if (response.status == 201) {
      	router.all(params.vue, function(response) {
          commit(GETALLROUTER, response.data);
        });
      }
    });
  },
  ROUTERLIST({ commit }, params) {
    router.list(params.vue, function(response) {
      params.data = response;
      commit(ROUTERLIST, response.data);
    });
  },
  UPDATEROUTER({ commit }, params) {
    router.update(params.vue,params.resData,function(response){
    	if(response.status == 204){
    		router.all(params.vue, function(response) {
          commit(GETALLROUTER, response.data);
        });
    	}
    });
  },
  GETALLROUTER({ commit }, params) {
    router.all(params.vue, function(response) {
      commit(GETALLROUTER, response.data);
    });
  },

}


export default {
  state,
  getters,
  mutations,
  actions
}
