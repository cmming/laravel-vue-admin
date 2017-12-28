
//引入的接口文件
import {
    userSys
} from "../../api/services.js"
// 事件订阅者
import {
    USERINFO
} from "../types"


/**
 * 判断用户权限是否拥有路由权限
 */
 function hasPremission(a1, a2) {
    var exists = false;
    if(a1 instanceof Array && a2 instanceof Array)
    {
        for (var i=0,iLen=a1.length; i<iLen; i++)
        {
            for (var j=0,jLen=a2.length; j<jLen; j++)
            {
                if (a1[i]===a2[j])
                {
                    return true;
                }
            }
        }
    }
    return exists;
};

/**
 * 为路由添加 权限控制选项
 */
function filterAsyncRouterByRole(ansycRouterMap,userSysRole){
  var accessedRouters = ansycRouterMap.filter((item) => {
    // console.log(item.meta.role,userSysRole,hasPremission(item.meta.role,userSysRole));
    if(hasPremission(item.meta.role,userSysRole)){
        if(item.has_son){
             filterAsyncRouterByRole(item.children,userSysRole);
        }
        return true;
    }
    return false;
  });
  return accessedRouters;
}


// 定义数据
// 获取用户信息 用户信息最好不要弄个vuex管理 应该使用localStorage使用
const state = {
    userInfo: {
        userBaseInfo:localStorage.userBaseInfo ? JSON.parse(localStorage.userBaseInfo): '',
    },
    sysUserRole:[]
};
const getters = {
    userInfo: (state) => {
        return state.userInfo;
    },
    sysUserRole: (state) => {
        return state.sysUserRole;
    }
};


const mutations = {
    USERINFO(state,data){
        state.sysUserRole = data.roles;
        state.userInfo.userBaseInfo = data.userInfo;
        localStorage.userBaseInfo = JSON.stringify(data.userInfo);
    },


};

const actions = {
    USERINFO({commit},params){
        //使用 Promise 创建同步操作 非常方便的关联 view和model
        return new Promise(resolve=>{
            userSys.getInfo(params.vue, function(response) {
              commit(USERINFO, response.data);
              //根据 用户的系统角色 进行路由 权限验证
              // console.log(filterAsyncRouterByRole(params.ansycRouterMap,response.data.roles),response.data.roles);
              params.router.addRoutes(filterAsyncRouterByRole(params.ansycRouterMap,response.data.roles));
            });
            resolve();
        })
        
    },
}

export default {
    state,
    getters,
    mutations,
    actions
}