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

//上传控件

Vue.directive('webUploader', {
  // 已经来就绑定
  bind: function (el, binding) {
    
  },
  // 当前元素插入以后
  inserted: function (el, binding) {
    console.log(el.id);
    // jQuery(function () {
    var $wrap = $('#uploader'),
    
    $list = $('#thelist'),
    state = 'ready',

    uploader;
    uploader = WebUploader.create({
      dnd: '#dndArea',
      // swf文件路径
      swf: '../assets/dist/Uploader.swf',
      // swf: 'http://cdn.staticfile.org/webuploader/0.1.0/Uploader.swf',
      // 文件接收服务端。
      // server: './upload.php',
      server: '/api/upload',
      // 选择文件的按钮。可选。
      // 内部根据当前运行是创建，可能是input元素，也可能是flash.
      pick: '#'+el.id,
      chunked: true,
      chunkSize: 2 * 1024 * 1024,
      auto: true,
      accept: {
        title: 'Video',
          extensions: 'mp4,wmv',
          mimeTypes: 'video/*'
      }
    });
    $('#ctlBtn').on('click', function () {
      console.log(1);
      if ($(this).hasClass('disabled')) {
        return false;
      }

      if (state === 'ready') {
        uploader.upload();

      } else if (state === 'paused') {
        uploader.upload();
      } else if (state === 'uploading') {
        uploader.stop();
      }
    });


    uploader.on('fileQueued', function (file) {
      $('#dndArea').hide();
      $('#cancle').show();
      console.log(file.source.ext);
      $list.append('<div id="' + file.id + '" class="item">' +
        '<h4 class="info">' + file.name + '</h4>' +
        '<p class="state">等待上传...</p>' +
        '</div>');

      console.log(this)
      // 返回的是 promise 对象
    //   this.md5File(file, 0, 1 * 1024 * 1024)

    //     // 可以用来监听进度
    //     .progress(function (percentage) {
    //       // console.log('Percentage:', percentage);
    //     })
    //     // 处理完成后触发
    //     .then(function (ret) {
    //       fileMd5 = ret;
    //     });
    });

    uploader.onUploadBeforeSend = function (file, data) {
      // data.md5 = fileMd5;
      data.md5 = 'fileMd5';
      data.ext = file.file.ext;
    };


    uploader.on('uploadProgress', function (file, percentage) {
      console.log(file);
      var $li = $('#' + file.id),
        $percent = $li.find('.progress .progress-bar');

      // 避免重复创建
      if (!$percent.length) {
        $percent = $('<div class="progress progress-striped active" >' +
          '<div class="progress-bar" id="progress-bar" role="progressbar" >' +
          '</div>' +
          '</div>').appendTo($li).find('.progress-bar');
      }

      
      // if(percentage>=0.01)
      var percentageNum = (percentage * 100).toFixed(2)
      $li.find('p.state').text('上传中'+percentageNum + '%');
      $li.find('p.state em').text(percentageNum + '%')
      $percent.css('width',percentageNum + '%');
      $('#progress-bar').text(percentageNum + '%')
    });


    //上传成功
    uploader.on('uploadSuccess', function (file) {
      $('#' + file.id).find('p.state').text('已上传');
    });
    //上传错误
    uploader.on('uploadError', function (file) {
      $('#' + file.id).find('p.state').text('上传出错');
    });
    //上传完成
    uploader.on('uploadComplete', function (file) {
      // $('#' + file.id).find('.progress').fadeOut();
      // location.reload();
    });
  // });
 },
  update: function(el, binding, vnode, oldVnode){
    console.log($('#'+el.id).siblings().eq(0));
　　　　console.log(el.dataset.name);//这里的数据是可以动态绑定的
　　　　console.table({
　　　　　　name:binding.name,
　　　　　　value:binding.value,
　　　　　　oldValue:binding.oldValue,
　　　　　　expression:binding.expression,
　　　　　　arg:binding.arg,
　　　　　　modifiers:binding.modifiers,
　　　　　　vnode:vnode,
　　　　　　oldVnode:oldVnode
　　　　});
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