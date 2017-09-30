// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'



import { Loading,Select,Option ,DatePicker,Upload,Button,Autocomplete,Scrollbar,Form,FormItem,Input,Col,Switch,TimePicker,CheckboxGroup,Checkbox,RadioGroup,Radio,Tree,MessageBox,Message } from 'element-ui';

Vue.use(Loading,DatePicker,MessageBox,Message);
Vue.component(Select.name, Select)
Vue.component(Option.name, Option)
Vue.component(DatePicker.name, DatePicker)
Vue.component(Upload.name, Upload)
Vue.component(Button.name, Button)
Vue.component(Autocomplete.name, Autocomplete)
Vue.component(Scrollbar.name, Scrollbar)
Vue.component(Form.name, Form)
Vue.component(FormItem.name, FormItem)
Vue.component(Input.name, Input)
Vue.component(Col.name, Col)
Vue.component(Switch.name, Switch)
Vue.component(TimePicker.name, TimePicker)
Vue.component(CheckboxGroup.name, CheckboxGroup)
Vue.component(Checkbox.name, Checkbox)
Vue.component(RadioGroup.name, RadioGroup)
Vue.component(Radio.name, Radio)
Vue.component(Tree.name, Tree)

Vue.prototype.$loading = Loading.service
Vue.prototype.$msgbox = MessageBox
Vue.prototype.$alert = MessageBox.alert
Vue.prototype.$confirm = MessageBox.confirm
Vue.prototype.$prompt = MessageBox.prompt
Vue.prototype.$notify = Notification
Vue.prototype.$message = Message


// 表单验证自定义的指令
import './validate/index.js'


// 请求的拦截器
import './api/index.js';


//视频插件
require('video.js/dist/video-js.css')
require('vue-video-player/src/custom-theme.css')
import VueVideoPlayer from 'vue-video-player'
Vue.use(VueVideoPlayer)
//自定义插件
import plugins from './plugins/index'
Vue.use(plugins);

// 数据状态集中处理
import store from './store'



//已入一个自定义指令 （最终采用 模型方式）
import directive from './directive/open.js'

// 引入自定义的过滤器(最终也采用 模型方式 便于管理)
import filters from './filter'

// 自己定义的全局样式组件
import deleteModel from './components/common/delete-weight.vue'
import breadcrumb from './components/common/breadcrumb.vue'
import errorMsg from './components/common/formError.vue'
import page from './components/common/page.vue'
import selectForShowCol from './components/common/selectForShowCol.vue'
import model from './components/common/model.vue'


Vue.component('v-deleteModel', deleteModel)
Vue.component('v-breadcrumb', breadcrumb)
Vue.component('v-errorMsg', errorMsg)
Vue.component('v-page', page)
Vue.component('v-selectForShowCol', selectForShowCol)
Vue.component('v-model', model)

import '../node_modules/element-ui/lib/theme-default/index.css'
import '../node_modules/bootstrap/dist/css/bootstrap.min.css'
import './assets/css/animate.min.css'
import './assets/css/simplify.min.css'
// import './assets/css/font-awesome.min.css'
import 'font-awesome/css/font-awesome.min.css'
import './assets/css/cm.css'



// import './assets/dist/static/jquery'
// import './assets/dist/webuploader'




Vue.config.productionTip = false

/* eslint-disable no-new */
// new Vue({
//   el: '#app',
//   router,
//   template: '<App/>',
//   components: { App }
// })
var cmVue= new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
