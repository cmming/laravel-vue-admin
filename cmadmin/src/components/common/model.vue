<template>
    <div class="modal fade in" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click='close'>
					×
				</button>
                    <h4 class="modal-title" id="myModalLabel">
                        模态框（Modal）标题
                    </h4>
                </div>
                <div class="modal-body">
                    在这里添加一些文本
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click='close'>关闭
				</button>
                    <button type="button" class="btn btn-primary" @click='close'>
					提交更改
				</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
</template>
<script>
    export default{
        data(){
            return {
            }
        },
        props:['isShow'],
        methods:{
            close:function(){
                var modalClassName=document.getElementById('myModal').className='modal fade in';
            },
        },
        watch:{
            isShow:function(val){
                if(!val){
                    var modalClassName=document.getElementById('myModal').className='modal fade in';
                }else{
                    var modalClassName=document.getElementById('myModal').className='modal fade in showModal';
                }
                this.$emit("callBackIsOpen",true);
            }
        }
    }
</script>
<style scoped>
    .showModal{
        display: block;
    }
    .modal-dialog{
        top:20vh
    }
</style>