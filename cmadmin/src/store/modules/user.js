//引入的接口文件
import {
    user
} from "../../api/services.js"
// 事件订阅者
import {
    USERLIST,
    USERSROLES,
    USERSTOREROLES,
    USEREXCEL
} from "../types"


const state = {
	user:{
		//列表数据 meta.pagination.total
        lists: [],
        allPage: '',
        curpage: 1,
        meta:{pagination:{total:0}},
        // 搜索参数
        searchData: { "uname": '', "btime": "2016-10-20", "etime": "", "page": 1, "limit": 15,"isExcel":false},
        excelData:[],
        roles:[]
	}
}

const getters = {
    user: (state) => {
        return state.user
    }
}

const mutations = {
	 USERLIST(state, data) {
        //列表数据 赋值
        state.user.lists = data.data;
        state.user.meta = data.meta;
        //  总页数赋值
        state.user.allPage = data.meta.pagination.total_pages;
        //当前页的设置
        state.user.curpage = data.meta.pagination.current_page;
    },
    USERSROLES(state, data) {
        state.user.roles = data;
    },
    USEREXCEL(state, data) {
        state.user.excelData = data.data;
        state.user.searchData.isExcel = false;
    },
}

const actions = {
	USERLIST({ commit }, params) {
        user.list(params.vue, params.resData, function (response) {
            commit(USERLIST, response.data);
        });
    },
    USERSROLES({ commit }, params) {
        user.roles(params.vue, params.resData, function (response) {
            commit(USERSROLES, response.data);
        });
    },
    USERSTOREROLES({ commit }, params) {
         user.storeRoles(params.vue, params.index,params.resData, function (response) {
             if(response.status == 204){
                params.vue.$router.push('/users');
            }
        });
    },
    USEREXCEL({ commit }, params) {
        user.list(params.vue, params.resData, function (response) {
            commit(USEREXCEL, response.data);
        });
    },

}


export default {
    state,
    getters,
    mutations,
    actions
}