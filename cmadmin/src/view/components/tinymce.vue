<!-- 富文本编辑器 -->
<!-- tinymce 该编辑器，支持 各种自定义，以及插件 -->
<template>
	<el-card>
	<el-card class='m-bottom-md'>
		公司做的后台主要是一个cms系统，公司也是以自媒体为核心的，所以富文本是后台很核心的功能。在选择富文本的过程中也走了不少的弯路，市面上常见的富文本都基本用过了，最终选择了Tinymce 相关文章 官网
	</el-card>
		<Tinymce :id='ceshi' v-model="content" @input='inputMethod'></Tinymce>
		<div class='editor-content' v-html='content'></div>
		<button type="button" class="btn btn-primary" @click='tijia'>提交</button>
	</el-card>

</template>
<script type="text/javascript">


	import Tinymce from '@/components/Tinymce'

	export default{
		components: { Tinymce },
		data(){
			return {
				ceshi:'ceshi',
				content: '请输入内容'
			}
		},
		methods:{
			inputMethod(data){
				console.log(data);
			},
			tijia(){
				this.$message({
					type:'success',
					message: '提交数据成功'+this.content
				});
			}
		},
	}



</script>