<template>
  <ma-form ref="crudForm" v-model="form" :columns="columnsOptions" @submit="handlerSubmit">
    <template #form-commission_rate>
      <a-input-number v-model="form['commission_rate']" v-bind="rateInputAttrs">
        <template #append>
          %
        </template>
      </a-input-number>
    </template>
  </ma-form>
</template>

<script setup>

import {reactive, ref} from "vue";
import {Message} from "@arco-design/web-vue";
import wxcProduct from "@/api/wxc/wxcProduct.js";

const props = defineProps({
  ids: {
    type: Array,
    required: true
  }
})

const crudForm = ref()
const form = ref({
  use_commission: 0,
  commission_rate: 0,
})
const rateInputAttrs = {
  max: 99.99,
  min: 0.01,
  precision: 2,
  step: 0.1,
  placeholder: "0.00",
  style: {
    width: '120px'
  }
}

const columnsOptions = reactive([
  {
    dataIndex: "use_commission",
    title: "商品佣金",
    formType: "switch",
    onControl: (val, maFormObject) => {
      const service = maFormObject.getColumnService()
      if (val) {
        service.get('commission_rate').setAttr('display', true)
      } else {
        service.get('commission_rate').setAttr('display', false)
      }
    }
  },
  {
    title: "佣金比例",
    dataIndex: "commission_rate",
    formType: "input-number",
    rules: [
      {required: true, message: '请填写佣金比例'}
    ],
  },
])

const handlerSubmit = (data, done) => {
  data.product_id_list = props.ids
  console.log(data)
  done(true)
  wxcProduct.updateSpec(data).then(res => {
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
