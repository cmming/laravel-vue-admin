<template>
    <div class="error-wrapper">
        <div class="error-inner">
            <div class="error-type" style="visibility: initial">{{error.code}}</div>
            <h1>{{error.title}}</h1>
            <p>{{error.reason}}</p>
            <div class="m-top-md">
                <a href="javascript:void(0)" class="btn btn-default btn-lg text-upper" @click = "goBack">返回上一页</a>
            </div>
        </div><!-- ./error-inner -->
    </div><!-- ./error-wrapper -->
</template>
<script>
    //  error={code:"",title,'',reason:'',backPage:''}
    export default {
        props: ['error'],
        methods:{
            goBack(){
                history.go(-2); 
            }
        }
    }
</script>