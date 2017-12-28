# cmadmin

> 蓝光管理后台

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report
```

For detailed explanation on how things work, checkout the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).


添加用户权限模块

1.权限的增删改

2.动态添加路由 （）

3.页面的首页添加一排历史记录快速入口 （就是一个历史记录的组件）

4.为了将项目 精简，必须将 menu组件中的那个 json 和路由json 进行整合，只有这样避免要控制两个数据

5.为了让actions 实现同步操作，可以使用 Promise

	`
		//控制异步代码的函数
		eg: return new Promise((resolve,reject) =>{
				//异步操作
				function a(){}
				//异步操作 成功后执行的
				resolve();
				//异步操作 执行失败后
				reject();
			});
	`


6.为域名进行 自动登录的判断


