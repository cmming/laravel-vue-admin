<template>
    <div class="modal fade in showModal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
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
                    <button type="button" class="btn btn-primary">
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
        props:['modalData'],
        mounted(){
            console.log(this.modalData);
            console.log('1');
        },
        methods:{
            close:function(){
                var modalClassName=document.getElementById('myModal').className='modal fade in';
            }
        },
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