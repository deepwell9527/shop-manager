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
  is_order_lock: 0,
  lock_expires_in: 0,
  custom: false,
  custom_value: 1,
  custom_time_type: 4
})

const columnsOptions = reactive([
  {
    dataIndex: "is_order_lock",
    title: "下单锁客",
    formType: "switch",
    onControl: (val, maFormObject) => {
      const service = maFormObject.getColumnService()
      if (val) {
        service.get('lock_expires_in').setAttr('display', true)
        service.get('custom').setAttr('display', true)
      } else {
        service.get('lock_expires_in').setAttr('display', false)
        service.get('custom').setAttr('display', false)
      }
    }
  },
  {
    dataIndex: "lock_expires_in",
    title: "时效",
    formType: "radio",
    rules: [
      {required: true},
      {match: /^[1-9]\d*$/, message: '请选择时效'}
    ],
    dict: {
      data: () => Object.values(timeMapping)
    },
  },
  {
    dataIndex: "custom",
    title: "自定义时效",
    formType: "switch",
    onControl: (val, maFormObject) => {
      const service = maFormObject.getColumnService()
      if (val) {
        if (form.value.is_order_lock) {
          service.get('lock_expires_in').setAttr('display', false)
        }
        service.get('custom_value').setAttr('display', true)
        service.get('custom_time_type').setAttr('display', true)
      } else {
        if (form.value.is_order_lock) {
          service.get('lock_expires_in').setAttr('display', true)
        }
        service.get('custom_value').setAttr('display', false)
        service.get('custom_time_type').setAttr('display', false)
      }
    }
  },
  {
    title: "",
    formType: "grid",
    cols: [
      {
        formList: [
          {
            title: "时长",
            dataIndex: "custom_value",
            formType: "input-number",
            step: 1,
            min: 1,
            rules: [
              {required: true, message: '请填写时长'}
            ],
          },
          {
            title: "单位",
            dataIndex: "custom_time_type",
            formType: "select",
            rules: [
              {required: true, message: '请选择时长单位'}
            ],
            dict: {
              data: () => Object.values(timeTypeMapping),
            }
          },
        ],
      }
    ],

  },
])

const handlerSubmit = (data, done) => {
  let postData = {}
  postData.sharer_id_list = props.ids
  postData.is_order_lock = data.is_order_lock
  if (data.custom) {
    let lockExpiresIn = transferToTime(data.custom_value, data.custom_time_type)
    if (!lockExpiresIn) {
      Message.error('时效异常')
      return
    }
    postData.lock_expires_in = lockExpiresIn
  } else {
    postData.lock_expires_in = data.lock_expires_in
  }

  done(true)
  wxcEcSharer.updateSpec(postData).then(res => {
    if (res.code === 200 && res.success) {
      Message.success('设置成功')
      emitSuccess()
    }
  })
  done(false)
}

const transferToTime = (val, type) => {
  // 根据timeTypeMapping配置，将时长转换为秒
  if (timeTypeMapping[type]) {
    return val * timeTypeMapping[type].unit
  }
  return 0
}

// 向父组件提供一个事件方法：当请求成功时
const emit = defineEmits(['success'])
const emitSuccess = () => {
  emit('success')
}

const timeMapping = {
  3600: {
    label: '1小时',
    value: 3600
  },
  10800: {
    label: '3小时',
    value: 10800
  },
  21600: {
    label: '6小时',
    value: 21600
  },
  43200: {
    label: '12小时',
    value: 43200
  },
  86400: {
    label: '1天',
    value: 86400
  },
  259200: {
    label: '3天',
    value: 259200
  },
  432000: {
    label: '5天',
    value: 432000
  },
  604800: {
    label: '7天',
    value: 604800
  },
  864000: {
    label: '10天',
    value: 864000
  },
  1296000: {
    label: '15天',
    value: 1296000
  },
  2592000: {
    label: '1个月',
    value: 2592000
  },
  7776000: {
    label: '3个月',
    value: 7776000
  },
  15552000: {
    label: '6个月',
    value: 15552000
  },
  31104000: {
    label: '1年',
    value: 31104000
  }
}

const timeTypeMapping = {
  1: {
    label: '分钟',
    value: 1,
    unit: 60
  },
  2: {
    label: '小时',
    value: 2,
    unit: 3600
  },
  3: {
    label: '天',
    value: 3,
    unit: 86400
  },
  4: {
    label: '月',
    value: 4,
    unit: 2592000
  },
  5: {
    label: '年',
    value: 5,
    unit: 31104000
  },
}

</script>
