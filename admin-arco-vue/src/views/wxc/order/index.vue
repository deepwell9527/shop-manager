<template>
  <div class="ma-content-block lg:flex justify-between p-4">
    <!-- CRUD 组件 -->
    <ma-crud ref="crudRef" :columns="columns" :options="options">

      <!--   小计/实付   -->
      <template #order_price="{record,column}">
        {{ (record.price_info.product_price + record.price_info.freight) / 100 }}
        /
        {{ record.price_info.order_price / 100 }}
      </template>

      <!--   商品信息   -->
      <template #product_info_list="{record,column}">
        <a-space direction="vertical">
          <a-link v-for="(item,index) in record.product_infos">{{ item.title }}</a-link>
        </a-space>
      </template>

      <!--   收货人/备注   -->
      <template #ext_things="{record,column}">
        <a-space direction="vertical">
          <span v-if="record.delivery_info.address_under_review">
            {{record.delivery_info.address_under_review.user_name}}
            {{record.delivery_info.address_under_review.tel_number}}
            {{record.delivery_info.address_under_review.city_name}}
          </span>
          <span v-else>
            {{record.delivery_info.address_info.user_name}}
            {{record.delivery_info.address_info.tel_number}}
            {{record.delivery_info.address_info.city_name}}
          </span>
          <span v-if="record.ext_info.merchant_notes">商家备注：{{record.ext_info.merchant_notes}}</span>
          <span v-if="record.ext_info.customer_notes">用户备注：{{record.ext_info.customer_notes}}</span>
        </a-space>
      </template>

      <!--   列表头操作   -->
      <template #tableBeforeButtons>
        <a-button status="success" type="primary" @click="sync()">
          同步历史订单
          <template #icon>
            <icon-refresh/>
          </template>
        </a-button>
      </template>
    </ma-crud>
  </div>
</template>
<script setup>
import {reactive, ref} from 'vue'
import wxcOrder from '@/api/wxc/wxcOrder'
import {useSiteStore} from "@/store/index.js";
import {Message} from "@arco-design/web-vue";

const crudRef = ref()
const siteStore = useSiteStore()

const options = reactive({
  id: 'wxc_order',
  rowSelection: {
    showCheckedAll: true
  },
  pk: 'order_id',
  operationColumn: false,
  operationColumnWidth: 160,
  formOption: {
    viewType: 'modal',
    width: 600
  },
  api: wxcOrder.getList,
  export: {
    show: true,
    url: 'wxc/order/export',
    auth: ['wxc:order:export']
  }
})

const columns = reactive([
  {
    title: "订单编号",
    dataIndex: "order_id",
    formType: "input",
  },
  {
    title: "所属店铺",
    dataIndex: "app_id",
    formType: "select",
    search: true,
    dict: {
      data: () => siteStore.fetchShopDict(),
      translation: true
    },
    editDisabled: true,
  },
  {
    title: "商品信息",
    dataIndex: "product_info_list",
    formType: "input",
  },
  {
    title: "小计/实付（元）",
    dataIndex: "order_price",
    formType: "input",
  },
  {
    title: "订单状态",
    dataIndex: "status",
    formType: "select",
    search: true,
    dict: {
      // 指定字典名称
      name: 'order_status',
      // 设置解析数据的label 和 value
      props: {label: 'title', value: 'key'},
      // 对数据进行字典翻译
      translation: true
    }
  },
  {
    title: "收货人/备注",
    dataIndex: "ext_things",
    formType: "input",
  },
  {
    title: "创建时间",
    dataIndex: "created_at",
    formType: "date",
    addDisplay: false,
    editDisplay: false,
    hide: true,
    commonRules: {
      required: true,
      message: "请输入"
    },
    showTime: true
  },
  {
    title: "更新时间",
    dataIndex: "updated_at",
    formType: "date",
    addDisplay: false,
    editDisplay: false,
    hide: true,
    commonRules: {
      required: true,
      message: "请输入"
    },
    showTime: true
  }
])

const sync = () => {
  wxcOrder.sync().then(res => {
    Message.success(res.message)
  })
}

</script>
<script> export default {name: 'wxc:order'} </script>