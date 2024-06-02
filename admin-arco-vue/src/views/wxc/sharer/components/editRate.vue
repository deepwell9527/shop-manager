<template>
  <ma-form ref="crudForm" v-model="form" :columns="columnsOptions" @submit="handlerSubmit">
    <template #form-first_tier_rate>
      <a-input-number v-model="form['first_tier_rate']" v-bind="rateInputAttrs">
        <template #append>
          %
        </template>
      </a-input-number>
    </template>
    <template #form-sec_tier_rate>
      <a-input-number v-model="form['sec_tier_rate']" v-bind="rateInputAttrs">
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
import {useSiteStore} from "@/store/index.js";

const props = defineProps({
  ids: {
    type: Array,
    required: true
  }
})

const siteStore = useSiteStore()
const crudForm = ref()
const form = ref({
  rate_mode: 1,
  level_id: 1,
  first_tier_rate: 0,
  sec_tier_rate: 0
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
    dataIndex: "rate_mode",
    title: "分佣比例",
    formType: "radio",
    rules: {
      required: true,
    },
    dict: {
      // 指定字典名称
      name: 'rate_mode',
      // 设置解析数据的label 和 value
      props: {label: 'title', value: 'key'},
      // 对数据进行字典翻译
      translation: true
    },
    // 定义字段交互控制
    onControl: (val, maFormObject) => {
      const service = maFormObject.getColumnService()
      if (val === '1') {
        service.get('level_id').setAttr('display', true)
        service.get('first_tier_rate').setAttr('display', false)
        service.get('sec_tier_rate').setAttr('display', false)
      }
      if (val === '2') {
        service.get('level_id').setAttr('display', false)
        service.get('first_tier_rate').setAttr('display', true)
        service.get('sec_tier_rate').setAttr('display', true)
      }
    }
  },
  {
    dataIndex: "level_id",
    title: "等级身份",
    formType: "select",
    rules: {
      required: true,
      message: '请选择等级'
    },
    dict: {
      data: () => siteStore.fetchSharerLevelDict()
    }
  },
  {
    dataIndex: "first_tier_rate",
    title: "一级比例",
    formType: "input-number",
    max: 99.99,
    min: 0.01,
    precision: 2,
    step: 0.1,
    placeholder: "0.00",
    rules: {
      required: true,
      message: '请设置一级分佣比例'
    },
  },
  {
    dataIndex: "sec_tier_rate",
    title: "二级比例",
    formType: "input-number",
    max: 99.99,
    min: 0.01,
    precision: 2,
    step: 0.1,
    placeholder: "0.00",
  },
])

const handlerSubmit = (data, done) => {
  data.sharer_id_list = props.ids
  let putData = organizeParam(data)
  done(true)
  wxcEcSharer.updateSpec(putData).then(res => {
    if (res.code === 200 && res.success) {
      Message.success('设置成功')
      emitSuccess()
    }
  })
  done(false)
}

const organizeParam = (data) => {
  switch (data.rate_mode) {
    case '1':
      return {
        sharer_id_list: data.sharer_id_list,
        rate_mode: data.rate_mode,
        level_id: data.level_id
      }
    case '2':
      return {
        sharer_id_list: data.sharer_id_list,
        rate_mode: data.rate_mode,
        first_tier_rate: data.first_tier_rate,
        sec_tier_rate: data.sec_tier_rate
      }
  }
}

// 向父组件提供一个事件方法：当请求成功时
const emit = defineEmits(['success'])
const emitSuccess = () => {
  emit('success')
}

</script>
