// 核心文件，先引用vue和vuex 然后user(Vuex),把定义好的 modules 引入进来然后返回一个Vuex.store
import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

// import * as getters from './getters'
// import * as actions from './actions.js'

import loading from './modules/loading.js'
import token from './modules/token'
import userOriFile from './modules/userOriFile'
import userOriTmp from './modules/userOriTmp'
import userPremisison from './modules/userPremisison.js'
import userRole from './modules/userRole.js'
import user from './modules/user.js'
import menu from './modules/menu.js'
// import userInfo from './modules/userInfo.js'

// 导出多个模块的数据 ->应该仅仅包含
export default new Vuex.Store({
    // getters,
    // actions,
    modules: {
        loading,
        // userInfo
        token,
        userOriFile,
        userOriTmp,
        userPremisison,
        userRole,
        user,
        menu
    },

});