<template>
    <header class="top-nav">
            <div class="top-nav-inner">
                <!--导航左边部分-->
                <div class="nav-header">
                    <button type="button" class="navbar-toggle pull-left sidebar-toggle" id="sidebarToggleSM" @click="showMenu">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <ul class="nav-notification pull-right" @click="showRigthPhone=!showRigthPhone">
                        <li :class="{'open':showRigthPhone}">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog fa-lg"></i></a>
                            <span class="badge badge-danger bounceIn">1</span>
                            <ul class="dropdown-menu dropdown-sm pull-right user-dropdown">
                                <li class="user-avatar">
                                    <img src="" alt="" class="img-circle">
                                    <div class="user-content">
                                        <h5 class="no-m-bottom">{{userInfo.userName}}</h5>
                                        <div class="m-top-xs">
                                            <a href="profile.html" class="m-right-sm">Profile</a>
                                            <a @click="siginOut">退出</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="inbox.html">
                                    Inbox
                                    <span class="badge badge-danger bounceIn animation-delay2 pull-right">1</span>
                                </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                    Notification
                                    <span class="badge badge-purple bounceIn animation-delay3 pull-right">2</span>
                                </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="sidebarRight-toggle">
                                    消息
                                    <span class="badge badge-success bounceIn animation-delay4 pull-right">7</span>
                                </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:void(0)">Setting</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!--在pc上显示-->
                    <a href="index.html" class="brand">
                        <i class="fa fa-database"></i><span class="brand-name">蓝光vr</span>
                    </a>
                </div>
                <!--导航右边部分 三部分-->
                <div class="nav-container">
                    <!--出现mini导航栏的触发按钮-->
                    <button type="button" class="navbar-toggle pull-left sidebar-toggle" id="sidebarToggleLG">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--搜索按钮-->
                    <ul class="nav-notification">
                        <li class="search-list">
                            <div class="search-input-wrapper">
                                <div class="search-input">
                                    <input type="text" class="form-control input-sm inline-block">
                                    <a href="javascript:void(0)" class="input-icon text-normal"><i class="ion-ios7-search-strong"></i></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!--最右边的一列用户信息-->
                    <div class="pull-right m-right-sm">
                        <!--带用户头像的下拉-->
                        <div class="user-block hidden-xs" :class = "{'open':showRigthPc}">
                            <a href="javascript:void(0)" id="userToggle" data-toggle="dropdown">
                                <img src="" alt="" class="img-circle inline-block user-profile-pic">
                                <div class="user-detail inline-block" @click="showRigthPc = !showRigthPc">
                                    {{userInfo.userName}}
                                    123PC
                                    <i class="fa fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="panel border dropdown-menu user-panel">
                                <div class="panel-body paddingTB-sm">
                                    <ul>
                                        <!--<li>
                                            <a href="profile.html">
                                                <i class="fa fa-edit fa-lg"></i><span class="m-left-xs">My Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="inbox.html">
                                                <i class="fa fa-inbox fa-lg"></i><span class="m-left-xs">Inboxes</span>
                                                <span class="badge badge-danger bounceIn animation-delay3">2</span>
                                            </a>
                                        </li>-->
                                        <li>
                                            <a @click="siginOut">
                                                <i class="fa fa-power-off fa-lg"></i><span class="m-left-xs">登出</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./top-nav-inner -->
        </header>
</template>
<script>
    import allAjax from '../../api/request.js'
    import {mapGetters,mapActions} from 'vuex'
    export default {
        data() {
            return {
                b: "",
                // 手机时候右边的下拉
                showRigthPhone: false,
                showRigthPc:false,
                userInfo:{
                    userName:''
                },
            }
        },
        props: ['msg'],
        computed: mapGetters([
            'loading',
            // 'userInfo'
        ]),
        mounted(){
            // console.log(this.$store.state);
            this.userInfo.userName=localStorage.userName;
        },
        methods: {
            showMenu: function() {
                this.msg.phoneMenuShow = !this.msg.phoneMenuShow;
                console.log(this.msg.phoneMenuShow);
            },
            // 退出登录
            siginOut:function(){
                localStorage.removeItem('token');
                localStorage.removeItem('refresh_expired_at');
                localStorage.removeItem('userName');
                // this.$store.dispatch('CLEARUSERINFO');
                this.$router.push('./login');
            }
        }
    }
</script>