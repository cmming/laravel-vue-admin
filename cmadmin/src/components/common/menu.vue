<template>
    <aside :class="{'sidebar-menu':true,'fixed':true,'active':msg.phoneMenuShow}" style="overflow:scroll">
        <div class="sidebar-inner scrollable-sidebar">
            <!--上半部分的导航条  bg-palette1控制颜色-->
            <div class="main-menu">
                <ul class="accordion">
                    <!--带事件控制-->
                    <!--<li  v-for='(menu,key) in menuData' -->
                    <li v-for='(menu,key) in menu.leftMenu' class="openable" :class="menu.bgPalette">
                        <a v-if="menu.childMenu!==undefined" href="javascript:void(0)" @click="showMenu(key)">
                            <span class="menu-content block">
										<span class="menu-icon"><i class="block fa fa-lg" :class="menu.iconFont"></i></span>
                            <span class="text m-left-sm">{{menu.title}}</span>
                            <span class="submenu-icon" :class="{'downIcon':(showIndex===key)}"></span>
                            </span>
                            <span class="menu-content-hover block">
									{{menu.title}}
								</span>
                        </a>
                        <router-link v-if="menu.childMenu===undefined" :to="menu.path" href="javascript:void(0)" @click="showMenu(key)">
                            <span class="menu-content block">
                                        <span class="menu-icon"><i class="block fa fa-lg" :class="menu.iconFont"></i></span>
                            <span class="text m-left-sm">{{menu.title}}</span>
                            </span>
                            <span class="menu-content-hover block">
                                        Form
                                </span>
                        </router-link>
                        <ul v-if="menu.childMenu!==undefined" :class="{'submenu':true, 'bg-palette4':true,'block':true}" v-show="showIndex===key">
                            <li v-for="childMenu in menu.childMenu">
                                <router-link :to="childMenu.path"><span class="submenu-label">{{childMenu.title}}</span></router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <!-- sidebar-inner -->
    </aside>
</template>
<script>
import { mapGetters } from 'vuex'
    export default {
        data() {
            return {
                //controll childMenu
                showIndex: '',
                childMenuShow: false,
                // 菜单文件必要的配置 from 后台传来的目录数据 使用时间戳 作为 编号最方便
                menuData: [
                    {
                        id:1,
                        title: "用户权限",
                        iconFont: "fa fa-cogs",
                        childMenu: [
                            {
                                id:1,
                                title: '用户权限管理',
                                path: '/user/premissions'
                            },
                            {
                                id:2,
                                title: '用户角色管理',
                                path: '/user/roles'
                            },
                            {
                                id:3,
                                title: "用户列管理",
                                path: "/users"
                            },
                            {
                                id:4,
                                title: "菜单管理",
                                path: "/menus"
                            },
                        ]
                    },
                    {
                        id:1,
                        title: "文件",
                        iconFont: "fa fa-file",
                        childMenu: [{
                            id:1,
                            title: "上传文件",
                            path: "/files/add"
                        }, {
                            id:2,
                            title: "用户原创文件列表",
                            path: "/userOriFiles"
                        }, {
                            id:3,
                            title: "用户原创申请",
                            path: "/UserOriTmps"
                        },]
                    }],
            }
        },
        props: ['msg'],
        computed: mapGetters([
            'menu'
        ]),
        created() {
            var paramObj = { vue: this};
            this.$store.dispatch('APPMENU',paramObj);
            console.log(this.menu.leftMenu,this.menu);
        },
        mounted() {
            this.menu.leftMenu.forEach(function (element, index) {
                index = index % 4;
                element.bgPalette = "bg-palette" + (index + 1);
            }, this);
        },
        methods: {
            showMenu(index) {
                if (this.showIndex === index) {
                    this.showIndex = '';
                } else {
                    this.showIndex = index;
                }
            },
        },

    }

</script>