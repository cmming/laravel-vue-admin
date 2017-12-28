<template>
  <div>
  	<el-card>
  		htmlMarkDown
  	</el-card>	
     <div class="editor-container m-top-md">
      <md-editor id='contentEditor' ref="contentEditor" v-model='content' :height="300" :zIndex='20'></md-editor>
    </div>
    <el-button @click='markdown2Html' style="margin-top:20px;" type="primary">转为HTML<i class="el-icon-document el-icon--right"></i></el-button>
    <div v-html="html"></div>
  </div>
</template>
<script>
import MdEditor from '@/components/markdownEditor'

export default {
  components: { MdEditor },
  data() {
    return {
      content: '## Simplemde1',
      html: ''
    }
  },
  methods: {
  	// 转换 html
    markdown2Html() {
      import ('showdown').then(showdown => {
        const converter = new showdown.Converter()
        this.html = converter.makeHtml(this.content)
      })
    }
  }
}

</script>
