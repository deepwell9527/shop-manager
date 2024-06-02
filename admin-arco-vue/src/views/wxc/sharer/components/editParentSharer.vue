<template>
  <ma-form ref="crudForm" v-model="form" :columns="columnsOptions" @submit="handlerSubmit">

  </ma-form>
</template>

<script setup>

import {reactive, ref} from "vue";
import wxcSharer from "@/api/wxc/wxcSharer.js";
import {Message} from "@arco-design/web-vue";

const props = defineProps({
  ids: {
    type: Array,
    required: true
  }
})

const crudForm = ref()
const form = ref()

const columnsOptions = reactive([
  {
    dataIndex: "parent_sharer_id",
    title: "上级分享员",
    formType: "select",
    dict: {
      // 远程通用接口请求，新版代码生成都有一个 remote 接口
      remote: 'wxc/sharer/remote',
      // 指定组件接收的props
      props: {label: 'nickname', value: 'sharer_id'},
      // 开启分页
      openPage: true,
      // 远程请求配置项
      remoteOption: {
        // 设置查询的字段
        select: ['nickname', 'openid', 'sharer_id'],
        // 设置数据过滤
        filter: {
          //sharer_id: ['!=', props.ids],
        },
      },
    }
  },
])

const handlerSubmit = (data, done) => {
  data.sharer_id_list = props.ids
  done(true)
  wxcSharer.updateSpec(data).then(res => {
    if (res.code === 200 && res.success) {
      Message.success('设置成功')
      emitSuccess()
    }
  })
  done(false)
}

// 向父组件提供一个事件方法：当请求成功时
const emit = defineEmits(['success'])
const emitSuccess = () => {
  emit('success')
}

</script>
