<!-- 封装 文本编辑器 -->
<template>
  <div>
    <textarea :id="tinymceId"></textarea>
  </div>
</template>
<script type="text/javascript">
export default {
  //接受的参数
  // props:['setting','setup','value'],
  props: {
    //编辑器的 id 属性
    id: {
      type: String
    },
    // 表示 编辑器中的内容
    value: {
      type: String,
      default: '请输入内容'
    },
    // 工具栏
    toolbar: {
      type: Array,
      required: false,
      default () {
        return ['removeformat undo redo |  bullist numlist | outdent indent | forecolor | fullscreen code', 'bold italic blockquote | h2 p  media link | alignleft aligncenter alignright']
      }
    },
    // 
    menubar: {
      default: ''
    },
    // 默认高度
    height: {
      type: Number,
      required: false,
      default: 360
    }

  },
  data() {
    return {
      hasChange: false,
      hasInit: false,
      tinymceId: this.id || 'vue-tinymce-' + +new Date(),
    }
  },
  // 监视内容区域 实现双向数据绑定
  watch: {
    value(val) {
      if (!this.hasChange && this.hasInit) {
      	 // 当传入值变化时跟新富文本内容
        this.$nextTick(() => window.tinymce.get(this.tinymceId).setContent(val))
      }
    }
  },
  // 计算 各种属性 ，在元素创建以后，挂载之前的这一段时间
  mounted() {
    const _this = this;
    window.tinymce.init({
      // 选择器 格式化区域
      selector: `#${this.tinymceId}`,
      height: this.height,
      toolbar: this.toolbar,
      menubar: this.menubar,
      plugins: 'advlist,autolink,code,paste,textcolor, colorpicker,fullscreen,link,lists,media,wordcount, imagetools',
      // selector:"textarea",
      //汉化
      language: 'zh_CN',
      init_instance_callback: editor => {
        if (_this.value) {
          editor.setContent(_this.value)
        }
        _this.hasInit = true
        editor.on('NodeChange Change KeyUp', () => {
          this.hasChange = true
          this.$emit('input', editor.getContent({ format: 'raw' }))
        })
      },
      //自定义 按钮
      setup(editor) {
        editor.addButton('h2', {
          title: '小标题', // tooltip text seen on mouseover
          text: '小标题',
          onclick() {
            editor.execCommand('mceToggleFormat', false, 'h2')
          },
          onPostRender() {
            const btn = this
            editor.on('init', () => {
              editor.formatter.formatChanged('h2', state => {
                btn.active(state)
              })
            })
          }
        })
        editor.addButton('p', {
          title: '正文',
          text: '正文',
          onclick() {
            editor.execCommand('mceToggleFormat', false, 'p')
          },
          onPostRender() {
            const btn = this
            editor.on('init', () => {
              editor.formatter.formatChanged('p', state => {
                btn.active(state)
              })
            })
          }
        })
      }
    });
  },
  methods: {
  	//设置文本区域的内容
    setContent(value) {
      window.tinymce.get(this.tinymceId).setContent(value)
    },
    //获取文本区域的内容
    getContent() {
      window.tinymce.get(this.tinymceId).getContent()
    },
    //上传图片的组件
    imageSuccessCBK(arr) {
      const _this = this
      arr.forEach(v => {
        window.tinymce.get(_this.tinymceId).insertContent(`<img class="wscnph" src="${v.url}" >`)
      })
    }
  },
  //销毁组件
  destroyed() {
     window.tinymce.get(this.tinymceId).destroy()
  }
}

</script>
