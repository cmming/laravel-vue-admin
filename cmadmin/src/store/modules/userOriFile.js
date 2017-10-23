//引入的接口文件
import {
  userOriFiles
} from "../../api/services.js"
// 事件订阅者
import {
  SETUSERORIFILElIST,
  GETUSERORIFILElIST,
  SETUSERORIFILEDETAIL,
  GETUSERORIFILEDETAIL,
} from "../types"

// 定义用户的自定义数据资源

const state = {
  userOriFiles: {
    //列表数据
    lists: [],
    // 一个数据的详情
    details: {},
    allPage: '',
    curpage: 1,
    // 搜索参数
    searchData: { "file_name": '', "btime": "", "etime": "", "page": '1', },
    //视频播放参数
    playerOptions: {
      muted: true,
      language: 'zh',
      playbackRates: [0.7, 1.0, 1.5, 2.0],
      sources: [{
        type: "video/mp4",
        // src: "https://cdn.theguardian.tv/webM/2015/07/20/150716YesMen_synd_768k_vp8.webm"
        src: ""
      }],
      // 视频的海报
      // poster: "/static/images/author.jpg",
    },
  }

}
// 对外暴露数据
const getters = {
  userOriFiles: (state) => {
    return state.userOriFiles
  }
}

// 定义 事件的 订阅 (事件类型)和发布者（回调函数 ACTION） 这里面相当于 视图
const mutations = {
  //设置 USERORIFILElIST列表数据 
  SETUSERORIFILElIST(state, data) {
    //列表数据 赋值
    state.userOriFiles.lists = data.data;
    //  总页数赋值
    state.userOriFiles.allPage = data.meta.pagination.total_pages;
    //当前页的设置
    state.userOriFiles.curpage = data.meta.pagination.current_page;
  },
  // 设置一条数据的详情
  SETUSERORIFILEDETAIL(state, res) {
    // 接口状态赋值 还未 统一定义好
    state.userOriFiles.details = res.data.data
    state.userOriFiles.playerOptions.sources[0].src = res.data.data.file_url;
    console.log(state.userOriFiles.playerOptions, res.data.data.file_url);
  },
}

//action
//异步操作  将数据与视图层分离
const actions = {
  //获取数据
  GETUSERORIFILElIST({ commit }, params) {
    userOriFiles.list(params.vue, params.resData, function (response) {
      commit(SETUSERORIFILElIST, response.data);
    })
  },
  // 获取一个详情
  GETUSERORIFILEDETAIL({ commit }, params) {
    userOriFiles.show(params.vue, params.resData, function (response) {
      commit(SETUSERORIFILEDETAIL, response);
    })
  },
  // 跟新 一个详情
  SETUSERORIFILEDETAIL({ commit }, params) {
    userOriFiles.update(params.vue, params.index, params.resData, function (response) {
      // 这样太粗暴，不能将，之前的用户浏览网页的 当前信息保留下来，
      // commit(SETUSERORIFILEDETAIL, response, params.vue);
      if (response.status == 204) {
        //因为页面跳转变 了 直接 用一个mutatio 来处理这个跳转，或者直接在 action 中进行 跳转的操作，mutation 和action 仅仅是用来处理 view 和 数据分离 没有绝对的界限，到时候如果这个action 被复用了，只需要，将这部草早创建一个新的 mutation 用来处理view 层级的事情，从而让  action 能被复用
        params.vue.$router.push('/UserOriFiles');
      }
    })
  },
  // 删除数据
  // 一个删除的动作 分割为 三个部分 删除并判断是否成功删除，跟新列表
  DELETEUSERORIFILE({ commit }, params) {
    userOriFiles.delete(params.vue, params.resData, function (response) {
      //成功的回调
      console.log(response.status);
      if (response.status == 204) {
        // 再次请求一下 commit
        // 格式化 请求参数
        var resData = params.vue.getDataFormat(state.userOriFiles.searchData);
        console.log(resData);
        // 再次请求一下 commit
        userOriFiles.list(params.vue, resData, function (response) {
          commit(SETUSERORIFILElIST, response.data);
        })
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
