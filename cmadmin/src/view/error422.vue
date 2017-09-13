<template>
    <div>
        <v-errorPage :error="errorMsg"></v-errorPage>
    </div>
</template>

<script>
    import errorPage from '../components/common/error.vue'

    export default {
        data() {
            return {
                errorMsg: { code: 422, title: '非法请求', reason: '你请求的参数中有非法字符，为了避免错误请按照要求填写', backPage: '' }

            }
        },
        components: {
            'v-errorPage': errorPage,
        },
    }

</script>