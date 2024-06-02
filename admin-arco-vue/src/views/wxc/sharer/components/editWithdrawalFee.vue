<template>
  <ma-form ref="crudForm" v-model="form" :columns="columnsOptions" @submit="handlerSubmit">
    <template #form-withdrawal_fee>
      <a-input-number v-model="form['withdrawal_fee']" v-bind="rateInputAttrs">
        <template #append>
          %
        </template>
      </a-input-number>
    </template>
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
  withdrawal_fee: 0
})
const rateInputAttrs = {
  max: 99.99,
  min: 0.01,
  precision: 2,
  step: 0.1,
  style: {
    width: '120px'
  }
}
const columnsOptions = reactive([
  {
    dataIndex: "withdrawal_fee",
    title: "比例",
    formType: "input-number",
    placeholder: "手续费（所占提现金额的比例）",
    rules: {
      required: true,
      message: '请设置手续费（所占提现金额的比例）'
    },
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
