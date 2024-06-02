<template>
  <ma-form ref="crudForm" v-model="form" :columns="columnsOptions" @submit="handlerSubmit">

  </ma-form>
</template>

<script setup>

import {reactive, ref} from "vue";
import wxcEcSharer from "@/api/wxc/wxcSharer.js";
import {Message} from "@arco-design/web-vue";

const props = defineProps({
  ids: {
    type: Array,
    required: true
  }
})

const crudForm = ref()
const form = ref({
  is_rebate: 0,
})

const columnsOptions = reactive([
  {
    dataIndex: "is_rebate",
    title: "开启自购",
    formType: "switch",
  },
])

const handlerSubmit = (data, done) => {
  data.sharer_id_list = props.ids
  done(true)
  wxcEcSharer.updateSpec(data).then(res => {
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
