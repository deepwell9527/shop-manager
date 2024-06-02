<template>
  <div class="ma-content-block lg:flex justify-between p-4">
    <!-- CRUD 组件 -->
    <ma-crud :options="options" :columns="columns" ref="crudRef">
    </ma-crud>
  </div>
</template>
<script setup>
import { ref, reactive } from 'vue'
import wxcAfterSale from '@/api/wxc/wxcAfterSale'
import { Message } from '@arco-design/web-vue'
import tool from '@/utils/tool'
import * as common from '@/utils/common'

const crudRef = ref()




const options = reactive({
  id: 'wxc_after_sale',
  rowSelection: {
    showCheckedAll: true
  },
  pk: 'after_sale_order_id',
  operationColumn: false,
  operationColumnWidth: 160,
  formOption: {
    viewType: 'modal',
    width: 600
  },
  api: wxcAfterSale.getList
})

const columns = reactive([
  {
    title: "售后单号",
    dataIndex: "after_sale_order_id",
    formType: "input",
    addDisplay: false,
    editDisplay: false,
    hide: true,
    commonRules: {
      required: true,
      message: "请输入售后单号"
    }
  },
  {
    title: "租户ID",
    dataIndex: "site_id",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入租户ID"
    }
  },
  {
    title: "视频号小店ID",
    dataIndex: "app_id",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入视频号小店ID"
    }
  },
  {
    title: "售后单当前状态",
    dataIndex: "status",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入售后单当前状态"
    }
  },
  {
    title: "买家身份标识",
    dataIndex: "openid",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入买家身份标识"
    }
  },
  {
    title: "买家在开放平台的唯一标识符",
    dataIndex: "unionid",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入买家在开放平台的唯一标识符"
    }
  },
  {
    title: "售后相关商品信息",
    dataIndex: "product_info",
    formType: "editor",
    hide: true,
    commonRules: {
      required: true,
      message: "请输入售后相关商品信息"
    }
  },
  {
    title: "售后详情",
    dataIndex: "details",
    formType: "editor",
    hide: true,
    commonRules: {
      required: true,
      message: "请输入售后详情"
    }
  },
  {
    title: "退款详情",
    dataIndex: "refund_info",
    formType: "editor",
    hide: true,
    commonRules: {
      required: true,
      message: "请输入退款详情"
    }
  },
  {
    title: "用户退货信息",
    dataIndex: "return_info",
    formType: "editor",
    hide: true,
    commonRules: {
      required: true,
      message: "请输入用户退货信息"
    }
  },
  {
    title: "商家上传的信息",
    dataIndex: "merchant_upload_info",
    formType: "editor",
    hide: true,
    commonRules: {
      required: true,
      message: "请输入商家上传的信息"
    }
  },
  {
    title: "退款原因",
    dataIndex: "reason",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入退款原因"
    }
  },
  {
    title: "退款原因解释",
    dataIndex: "reason_text",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入退款原因解释"
    }
  },
  {
    title: "售后类型",
    dataIndex: "type",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入售后类型"
    }
  },
  {
    title: "纠纷id",
    dataIndex: "complaint_id",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入纠纷id"
    }
  },
  {
    title: "订单号",
    dataIndex: "order_id",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入订单号"
    }
  },
  {
    title: "微信支付退款的响应",
    dataIndex: "refund_resp",
    formType: "editor",
    hide: true,
    commonRules: {
      required: true,
      message: "请输入微信支付退款的响应"
    }
  },
  {
    title: "操作剩余时间（秒数）",
    dataIndex: "deadline",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入操作剩余时间（秒数）"
    }
  },
  {
    title: "售后单创建时间戳",
    dataIndex: "created_at",
    formType: "date",
    addDisplay: false,
    editDisplay: false,
    hide: true,
    commonRules: {
      required: true,
      message: "请输入售后单创建时间戳"
    },
    showTime: true
  },
  {
    title: "售后单更新时间戳",
    dataIndex: "updated_at",
    formType: "date",
    addDisplay: false,
    editDisplay: false,
    hide: true,
    commonRules: {
      required: true,
      message: "请输入售后单更新时间戳"
    },
    showTime: true
  }
])
</script>
<script> export default { name: 'wxc:afterSale' } </script>