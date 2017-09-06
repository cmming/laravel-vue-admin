import Vue from 'vue'

Vue.directive('toggleMenu', function(el, data) {
    console.log(el, data.value.className);
});

// 拖动指令
Vue.directive('chageClass',
  function (el, binding) {
      el.onclick=function(){
        var toggleClassArray=binding.value.split(',');
        console.log(el.className);
        el.className=el.className==toggleClassArray[0]?toggleClassArray[1]:toggleClassArray[0];
      }
  });
  // 用来显示密码输入框的状态
Vue.directive('chageInputTpye',
  function (el, binding) {
      el.onclick=function(){
        var toggleClassArray=binding.value.split(',');
        var input=el.nextElementSibling;
        el.className=el.className==toggleClassArray[0]?toggleClassArray[1]:toggleClassArray[0];
        input.type=input.type==toggleClassArray[2]?toggleClassArray[3]:toggleClassArray[2];
      }
  });

  // 当前页面的img全部都是延迟加载 使用方式 一个标签底下的所有元素都会被延迟加载时间为指令后面的数字
// v-ansyimgpage="{'ansy':2000}" 使用json形式传递参数，便于后面的扩展性
//<img :src="imgUrl" width="200px" height="200px" style="border:1px solid black">
Vue.directive('ansyimgpage', {
  // 已经来就绑定
  bind: function (el, binding) {
    var elem_child = el.childNodes;
    for (var i = 0; i < elem_child.length; i++) { //遍历子元素
      if (elem_child[i].nodeName == "IMG") {
        var src = elem_child[i].getAttribute("src");
        elem_child[i].setAttribute('src', lodingImg);
        elem_child[i].setAttribute('data-src', src);
      }
    }
  },
  // 当前元素插入以后
  inserted: function (el, binding) {
    window.onscroll = function () {
      var sTop = document.body.scrollTop || document.documentElement.scrollTop;
      var cHeight = document.documentElement.clientHeight || document.body.clientHeight;
      var elem_child = el.childNodes;
      // 使用 块集变量 let 方便内部使用
      for (let i = 0; i < elem_child.length; i++) { //遍历子元素
        if (elem_child[i].nodeName == "IMG") {
          if (sTop + cHeight >= elem_child[i].offsetTop) {
            var datasrc = elem_child[i].getAttribute("data-src");
            window.setTimeout(function () {
              elem_child[i].setAttribute("src", datasrc);
            }, binding.value.ansy)
          }
        }
      }
    };
  },
});


// Vue.directive('chageClass',{
//   　bind: function(el, binding){
// 　　　　console.log('bind:',binding.value);
// 　　},
// 　　inserted: function(el, binding){
// 　　　　console.log('insert:',binding.value);
// 　　},
// 　　update: function(el, binding, vnode, oldVnode){
// 　　　　el.focus();
// 　　　　console.log(el.dataset.name);//这里的数据是可以动态绑定的
// 　　　　console.table({
// 　　　　　　name:binding.name,
// 　　　　　　value:binding.value,
// 　　　　　　oldValue:binding.oldValue,
// 　　　　　　expression:binding.expression,
// 　　　　　　arg:binding.arg,
// 　　　　　　modifiers:binding.modifiers,
// 　　　　　　vnode:vnode,
// 　　　　　　oldVnode:oldVnode
// 　　　　});
// 　　},
// 　　componentUpdated: function(el, binding){
// 　　　　console.log('componentUpdated:',binding.name);
// 　　}
// });