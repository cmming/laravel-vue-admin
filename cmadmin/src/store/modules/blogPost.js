//引入的接口文件
import {
    blogPosts
} from "../../api/services.js"
// 事件订阅者
import {
    BLOGPOSTS
} from "../types"


const state = {
	blogPosts:{
		//列表数据 meta.pagination.total
        lists: [],
        allPage: '',
        details:{'title':''},
        curpage: 1,
        meta:{pagination:{total:0}},
        // 搜索参数
        searchData: {"timeRange":'', "name": '', "btime": "2016-10-20", "etime": "", "page": 1, "limit": 15,"isExcel":false},
        excelData:[],
        roles:[]
	}
}

const getters = {
    blogPost: (state) => {
        return state.blogPosts
    }
}

const mutations = {
    BLOGPOSTS(state, data) {
        //列表数据 赋值
        state.blogPosts.lists = data.data;
        state.blogPosts.meta = data.meta;
        //  总页数赋值
        state.blogPosts.allPage = data.meta.pagination.total_pages;
        //当前页的设置
        state.blogPosts.curpage = data.meta.pagination.current_page;
    },
}

const actions = {
	BLOGPOSTS({ commit }, params) {
        blogPosts.list(params.vue, params.resData, function (response) {
            commit(BLOGPOSTS, response.data);
        });
    },

}


export default {
    state,
    getters,
    mutations,
    actions
}