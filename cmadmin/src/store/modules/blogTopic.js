//引入的接口文件
import {
    blogTopic
} from "../../api/services.js"
// 事件订阅者
import {
    BLOGTOPICS,
    BLOGTOPICDETAIL,
    STOREBLOGTOPIC,
    UPDATEBLOGTOPIC,

    USERLIST,
    USERSROLES,
    USERSTOREROLES,
    USEREXCEL
} from "../types"


const state = {
	blogTopic:{
		//列表数据 meta.pagination.total
        lists: [],
        allPage: '',
        details:{'name':''},
        curpage: 1,
        meta:{pagination:{total:0}},
        // 搜索参数
        searchData: {"timeRange":'', "name": '', "btime": "2016-10-20", "etime": "", "page": 1, "limit": 15,"isExcel":false},
        excelData:[],
        roles:[]
	}
}

const getters = {
    blogTopic: (state) => {
        return state.blogTopic
    }
}

const mutations = {
    BLOGTOPICS(state, data) {
        //列表数据 赋值
        state.blogTopic.lists = data.data;
        state.blogTopic.meta = data.meta;
        //  总页数赋值
        state.blogTopic.allPage = data.meta.pagination.total_pages;
        //当前页的设置
        state.blogTopic.curpage = data.meta.pagination.current_page;
    },
    BLOGTOPICDETAIL(state, data) {
        //列表数据 赋值
        state.blogTopic.details = data.data; 
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
	BLOGTOPICS({ commit }, params) {
        blogTopic.list(params.vue, params.resData, function (response) {
            commit(BLOGTOPICS, response.data);
        });
    },
    BLOGTOPICDETAIL({ commit }, params) {
        blogTopic.show(params.vue, params.index, function (response) {
            commit(BLOGTOPICDETAIL, response.data);
        });
    },
    UPDATEBLOGTOPIC({ commit }, params) {
        blogTopic.update(params.vue, params.index, params.resData,function (response) {
            if (response.status == 204) {
                // 跳转到 list 
                params.vue.$router.push('/blog/topics');
            }   
        });
    },

    STOREBLOGTOPIC({ commit }, params) {
        blogTopic.store(params.vue, params.resData,function (response) {
            if (response.status == 201) {
                // 跳转到 list 
                params.vue.$router.push('/blog/topics');
            }   
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