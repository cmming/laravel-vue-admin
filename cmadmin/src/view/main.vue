<template>
    <div>
        <div>
            主页
            <button @click = 'showModel'>展示</button>
            <v-model :isShow = "modalShow" @callBackIsOpen = "setModalVal"></v-model>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                modalShow:false,
            }
        },
        methods:{
            // 调用组件后的 数据回调
            showModel(){
                this.modalShow = !this.modalShow
            },
            // 回调设置 父组件的相关数据
            setModalVal(val){
                this.modalShow = val
            },

        }
    }
</script>