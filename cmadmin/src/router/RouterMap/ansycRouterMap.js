// 后期或者可以用一个js文件替换
export const ansycRouterMap1 = [
    {
        "id": 1,
        "title": "文件",
        "path": "/files",
        "componentPath": "../../view/mainIndex.vue",
        "type": "menu",
        "iconFont": "fa fa-file",
        "sort": 12,
        "has_son": 1,
        "meta": {
            "auth": true,
            "title": "文件",
            "role": [
                1
            ]
        },
        "component": resolve => require(['../../view/mainIndex.vue'], resolve),
        "children": [
            {
                "id": 2,
                "title": "上传文件",
                "path": "/files/add",
                "componentPath": "../../view/uploadFile.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 17,
                "has_son": 0,
                "parent_id": 1,
                "meta": {
                    "auth": true,
                    "title": "上传文件",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/uploadFile.vue'], resolve)
            },
            {
                "id": 3,
                "title": "用户原创文件列表",
                "path": "/userOriFiles",
                "componentPath": "../../view/userOriFiles.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 1,
                "meta": {
                    "auth": true,
                    "title": "用户原创文件列表",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userOriFiles.vue'], resolve)
            },
            {
                "id": 8,
                "title": "添加用户原创资源",
                "path": "/UserOriFiles/add12",
                "componentPath": "../../view/UserOriTmpsForm.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 1,
                "meta": {
                    "auth": true,
                    "title": "添加用户原创资源",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/UserOriTmpsForm.vue'], resolve)
            },
            {
                "id": 9,
                "title": "修改用户原创",
                "path": "/UserOriFiles/edit/:id",
                "componentPath": "../../view/userOriFileForm.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 1,
                "meta": {
                    "auth": true,
                    "title": "修改用户原创",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userOriFileForm.vue'], resolve)
            },
            {
                "id": 10,
                "title": "添加原创申请",
                "path": "/UserOriFiles/add/:id",
                "componentPath": "../../view/userOriFileForm.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 1,
                "meta": {
                    "auth": true,
                    "title": "添加原创申请",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userOriFileForm.vue'], resolve)
            },
            {
                "id": 16,
                "title": "用户原创列表",
                "path": "/UserOriTmps",
                "componentPath": "../../view/UserOriTmps.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 1,
                "meta": {
                    "auth": true,
                    "title": "用户原创列表",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/UserOriTmps.vue'], resolve)
            },
            {
                "id": 17,
                "title": "修改用户原创申请",
                "path": "/UserOriTmps/edit/:id",
                "componentPath": "../../view/UserOriTmpsForm.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 1,
                "meta": {
                    "auth": true,
                    "title": "修改用户原创申请",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/UserOriTmpsForm.vue'], resolve)
            }
        ]
    },
    {
        "id": 11,
        "title": "用户权限",
        "path": "/user/manage",
        "componentPath": "../../view/mainIndex.vue",
        "type": "menu",
        "iconFont": "fa fa-gears",
        "sort": 1,
        "has_son": 1,
        "meta": {
            "auth": true,
            "title": "用户权限",
            "role": [
                1
            ]
        },
        "component": resolve => require(['../../view/mainIndex.vue'], resolve),
        "children": [
            {
                "id": 12,
                "title": "用户权限列表",
                "path": "/user/premissions",
                "componentPath": "../../view/userPremission/list.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "用户权限列表",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userPremission/list.vue'], resolve)
            },
            {
                "id": 13,
                "title": "修改用户权限",
                "path": "/user/premissions/edit/:id",
                "componentPath": "../../view/userPremission/form.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "修改用户权限",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userPremission/form.vue'], resolve)
            },
            {
                "id": 14,
                "title": "添加用户权限",
                "path": "/user/premissions/add",
                "componentPath": "../../view/userPremission/form.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "添加用户权限",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userPremission/form.vue'], resolve)
            },
            {
                "id": 15,
                "title": "菜单管理",
                "path": "/menus",
                "componentPath": "../../view/menu/list.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "菜单管理",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/menu/list.vue'], resolve)
            },
            {
                "id": 18,
                "title": "用户角色列表",
                "path": "/user/roles",
                "componentPath": "../../view/userRole/list.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "用户角色列表",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userRole/list.vue'], resolve)
            },
            {
                "id": 19,
                "title": "修改用户角色",
                "path": "/user/roles/edit/:id",
                "componentPath": "../../view/userRole/form.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "修改用户角色",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userRole/form.vue'], resolve)
            },
            {
                "id": 20,
                "title": "添加用户角色",
                "path": "/user/roles/add",
                "componentPath": "../../view/userRole/form.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "添加用户角色",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userRole/form.vue'], resolve)
            },
            {
                "id": 21,
                "title": "角色权限管理",
                "path": "/user/roles/:id/premission",
                "componentPath": "../../view/userRole/rolePremission.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "角色权限管理",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/userRole/rolePremission.vue'], resolve)
            },
            {
                "id": 22,
                "title": "用户列表",
                "path": "/users",
                "componentPath": "../../view/user/list.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "用户列表",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/user/list.vue'], resolve)
            },
            {
                "id": 23,
                "title": "添加菜单管理",
                "path": "/menu/add",
                "componentPath": "../../view/menu/form.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "添加菜单管理",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/menu/form.vue'], resolve)
            },
            {
                "id": 24,
                "title": "修改菜单管理",
                "path": "/menu/edit/:id",
                "componentPath": "../../view/menu/form.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "修改菜单管理",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/menu/form.vue'], resolve)
            },
            {
                "id": 25,
                "title": "权限菜单管理",
                "path": "/user/premissions/menus",
                "componentPath": "../../view/menu/form.vue",
                "type": "function",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 11,
                "meta": {
                    "auth": true,
                    "title": "权限菜单管理",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/menu/form.vue'], resolve)
            }
        ]
    },
    {
        "id": 26,
        "title": "数据中心",
        "path": "/dataCenter",
        "componentPath": "../../view/mainIndex.vue",
        "type": "menu",
        "iconFont": "fa fa-line-chart",
        "sort": 1,
        "has_son": 1,
        "meta": {
            "auth": true,
            "title": "数据中心",
            "role": [
                1
            ]
        },
        "component": resolve => require(['../../view/mainIndex.vue'], resolve),
        "children": [
            {
                "id": 27,
                "title": "数据中心-仪表盘",
                "path": "/dataCenter/dashboard",
                "componentPath": "../../view/dataCenter/dashboard.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 26,
                "meta": {
                    "auth": true,
                    "title": "数据中心-仪表盘",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/dataCenter/dashboard.vue'], resolve)
            },
            {
                "id": 28,
                "title": "综合实例-表格",
                "path": "/example/table",
                "componentPath": "../../view/examples/tables.vue",
                "type": "menu",
                "iconFont": "",
                "sort": 1,
                "has_son": 0,
                "parent_id": 26,
                "meta": {
                    "auth": true,
                    "title": "综合实例-表格",
                    "role": [
                        1
                    ]
                },
                "component": resolve => require(['../../view/examples/tables.vue'], resolve)
            }
        ]
    }
]

