<template>
    <aside :class="{'sidebar-menu':true,'fixed':true,'active':msg.phoneMenuShow}" style="overflow:scroll">
        <div class="sidebar-inner scrollable-sidebar">
            <!--上半部分的导航条  bg-palette1控制颜色-->
            <div class="main-menu">
                <ul class="accordion">
                    <!--带事件控制-->
                    <!--<li  v-for='(menu,key) in menuData' -->
                    <li v-for='(menu,key) in router.lists' class="openable" :class="menu.bgPalette">
                        <a v-if="menu.type==='menu'&&menu.children!==undefined" href="javascript:void(0)" @click="showMenu(key)">
                            <span class="menu-content block">
										<span class="menu-icon"><i class="block fa fa-lg" :class="menu.iconFont"></i></span>
                            <span class="text m-left-sm">{{menu.title}}</span>
                            <span class="submenu-icon" :class="{'downIcon':(showIndex===key)}"></span>
                            </span>
                            <span class="menu-content-hover block">
									{{menu.title}}
								</span>
                        </a>
                        <router-link v-if="menu.type==='menu'&&menu.children===undefined" :to="menu.path" href="javascript:void(0)" @click="showMenu(key)">
                            <span class="menu-content block">
                                        <span class="menu-icon"><i class="block fa fa-lg" :class="menu.iconFont"></i></span>
                            <span class="text m-left-sm">{{menu.title}}</span>
                            </span>
                            <span class="menu-content-hover block">
                                        Form
                                </span>
                        </router-link>
                        <ul v-if="menu.type==='menu'&&menu.children!==undefined" :class="{'submenu':true, 'bg-palette4':true,'block':true}" v-show="showIndex===key">
                            <li v-for="children in menu.children">
                                <router-link v-if="children.type==='menu'" :to="children.path"><span class="submenu-label">{{children.title}}</span></router-link>
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
               
            }
        },
        props: ['msg'],
        computed: mapGetters([
            'menu',
            'router'
        ]),
        created() {
            var paramObj = { vue: this};
            // this.$store.dispatch('APPMENU',paramObj);
            this.$store.dispatch('ROUTERLIST',paramObj);
            // console.log(this.menu.leftMenu,this.router.lists);
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