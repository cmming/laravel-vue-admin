<template>
	<div class="sign-in-wrapper">
		<div class="sign-in-inner">
			<div class="login-brand text-center">
				<i class="fa fa-database m-right-xs" v-show="false"></i> 综合 <strong class="text-skin">管理后台</strong>
			</div>

			<form>
				<!-- <div class="form-group col-lg-12 m-bottom-md">
					<i class="fa fa-user icon-absolute-left"></i>
					<input autocomplete="off" type="text" class="form-control" v-model="formData.email" placeholder="邮箱"
						v-validate="'required|email'" name="email">
					 <v-errorMsg 
					:errorMsgAlert="{'isShow':errors.has('email'),'msg':[{'isShow':errors.has('email:required'),'msg':errors.first('email:required')},{'isShow':errors.has('email:email'),'msg':errors.first('email:email')}]}">
					</v-errorMsg> 
				</div> -->
				<div class="form-group col-lg-12 m-bottom-md">
					<i class="fa fa-user icon-absolute-left"></i>
					<input autocomplete="off" type="text" class="form-control" v-model="formData.name" placeholder="登录名"
						v-validate="'required'" name="name">
					 <v-errorMsg 
					:errorMsgAlert="{'isShow':errors.has('name'),'msg':[{'isShow':errors.has('name:required'),'msg':errors.first('name:required')}]}">
					</v-errorMsg> 
				</div>
				<div class="form-group col-lg-12">
					<i class="fa  fa-lock icon-absolute-left"></i>
					<i class="fa fa-eye icon-absolute-right" v-chageInputTpye="'fa fa-eye-slash icon-absolute-right,fa fa-eye icon-absolute-right,password,text'"></i>
					<input autocomplete="off" type="password" @keyup.enter="login" class="form-control" v-model="formData.password" placeholder="密码">
				</div>

				<div class="form-group col-lg-12">
					<div class="custom-checkbox">
						<input type="checkbox" id="chkRemember">
						<label for="chkRemember"></label>
					</div>
					记住密码
				</div>

				<div class="m-top-md p-top-sm col-lg-12">
					<a @click="login" class="btn btn-success block">
						<i class="fa fa-spinner fa-spin m-right-xs" v-show="loading"></i>登录</a>
				</div>

				<div class="m-top-md p-top-sm text-center">
					<span v-show="token.requestError" class="err_msg">
						{{token.errorMsg}}
					</span>
				</div>

				<div class="m-top-md p-top-sm col-lg-12">
					<div class="font-12 text-center m-bottom-xs" v-show="false">
						<a href="javascript:void(0)" class="font-12">忘记密码</a>
					</div>
					<div class="font-12 text-center m-bottom-xs" v-show="false">没有帐号</div>
					<a href="#/signup" class="btn btn-default block">创建帐号</a>
				</div>
			</form>
		</div>
		<!-- ./sign-in-inner -->
	</div>
</template>
<script>
	import { mapGetters } from 'vuex'
	export default {
		// 到时候还可以依据不同的情况返回不同的数据
		computed: {
			loading:function(){
				// 模块名称
				return this.$store.state.loading.loading
			},
			...mapGetters([
				'token'
            ]),
		},
		data() {
			return {
				formData: {
					email: "",
					name: "",
					password: "",
				},
				loadding: false,
			}
		},
		methods: {
			login() {
				this.$validator.validateAll().then(() => {
					this.loadding = true;
					// 登录 进行初始化 token
					var paramsObj = {vue:this,resData:this.formData};
					this.$store.dispatch('SETTOKEN',paramsObj);
                }).catch(() => {
                    // eslint-disable-next-line
                    // alert('未通过');
					this.$message({
						showClose:true,
						message:'按照提示输入内容才能登陆',
						type:'warning'
					});
                });
				
			},
			// 键盘时间
		},

	}

</script>