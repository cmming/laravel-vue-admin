//引入的接口文件
import {
  menu
} from "../../api/services.js"
// 事件订阅者
import {
  APPMENU,
  MENULIST,
  DELETEMENUITEM,
  UPDATEMENUITEM,
  STOREMENUITEM
} from "../types"

const state = {
  menu: {
    lists: [],
    indexMenu:[],
    details: {
       parent_title: '',
       parent_id:'',
       id:'',
       title: '',
       path: '',
       sort:1,
       childMenu:[],
       iconFont:'',
       type:'',
       componentPath:''
    },
    typeArr:{'menu':'菜单','function':'功能','button':'按钮'},
    //左边的目录
    leftMenu:[]
  }
}

const getters = {
  menu: (state) => {
    return state.menu;
  }
}


const mutations = {
	MENULIST(state,data){
		state.menu.lists = data.menu;
		state.menu.indexMenu = data.indexMenu;
	},
	APPMENU(state,data){
		state.menu.leftMenu = data.menu;
	},
}


const actions = {
	MENULIST({ commit },params){
		menu.list(params.vue,function(response){

			commit(MENULIST,response.data);
		});
	},
	APPMENU({ commit },params){
		menu.userMenus(params.vue,function(response){

			commit(APPMENU,response.data);
		});
	},
	DELETEMENUITEM({commit},params){
		menu.delete(params.vue,params.resData,function(response){
			if(response.status == 204){
				menu.list(params.vue,function(response){
					commit(MENULIST,response.data);
				});
				menu.userMenus(params.vue,function(response){
					commit(APPMENU,response.data);
				});
			}
		});
	},
	UPDATEMENUITEM({commit},params){
		menu.update(params.vue,params.resData,function(response){
			if(response.status == 204){
				menu.list(params.vue,function(response){
					commit(MENULIST,response.data);
				});
				menu.userMenus(params.vue,function(response){
					commit(APPMENU,response.data);
				});
			}
		});
	},
	STOREMENUITEM({commit},params){
		menu.store(params.vue,params.resData,function(response){
			if(response.status == 201){
				menu.list(params.vue,function(response){
					commit(MENULIST,response.data);
				});
				menu.userMenus(params.vue,function(response){
					commit(APPMENU,response.data);
				});
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
