//引入的接口文件
import {
  userOriFiles
} from "../../api/request1"
// 事件订阅者
import {
  SETUSERORIFILElIST,
  GETUSERORIFILElIST,
  SETUSERORIFILEDETAIL,
  GETETUSERORIFILEDETAIL
} from "./types"

// 定义用户的自定义数据资源

const state = {
  userOriFiles: {
    //列表数据
    lists: [],
    // 一个数据的详情
    details: {},
  }

}

// 暴漏数据

const getters = {
  userOriFiles: (state) => {
    return state.userOriFiles
  }
}



// 定义 事件的 订阅 (事件类型)和发布者（回调函数 ACTION） 这里面相当于 视图
const mutations = {
  //获取USERORIFILElIST列表数据 
  SETUSERORIFILElIST(state, list) {
    state.userOriFiles.lists = list
  }
}

//action
//异步操作  将数据与视图层分离
const actions = {
    GETUSERORIFILElIST({commit},dataform){
        console.log(dataform);
        userOriFiles.list.call(this,dataform,function(response){
            commit(SETUSERORIFILElIST, response.data.data);
        })
    }

}

export default {
    state,
    getters,
    mutations,
    actions
}
