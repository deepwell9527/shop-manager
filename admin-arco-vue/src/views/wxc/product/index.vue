<template>
  <div class="ma-content-block lg:flex justify-between p-4">
    <!-- CRUD 组件 -->
    <ma-crud ref="crudRef" :columns="columns" :options="options">

      <!--   价格   -->
      <template #price="{record}">
        <template v-if="record.min_price === record.max_price">
          {{ record.min_price / 100 }}
        </template>
        <template v-else>
          {{ record.min_price / 100 }}~{{ record.max_price / 100 }}
        </template>
      </template>

      <template #commission_info="{record}">
        <column-commission-info :crudRef="crudRef" :record="record"></column-commission-info>
      </template>

      <template #tableBeforeButtons>
        <a-button status="success" type="primary" @click="sync()">
          同步商品
          <template #icon>
            <icon-refresh/>
          </template>
        </a-button>
      </template>

      <template #tableAfterButtons="{ selectedIds }">
        <BatchActions :crudRef="crudRef" :ids="selectedIds"/>
      </template>
    </ma-crud>
  </div>
</template>
<script setup>
import {reactive, ref} from 'vue'
import wxcProduct from '@/api/wxc/wxcProduct'
import {Message} from '@arco-design/web-vue'
import ColumnCommissionInfo from "@/views/wxc/product/components/columnCommissionInfo.vue";
import BatchActions from "@/views/wxc/product/components/batchActions.vue";

const crudRef = ref()

const options = reactive({
  id: 'wxc_product',
  rowSelection: {
    showCheckedAll: true
  },
  pk: 'product_id',
  operationColumn: true,
  operationColumnWidth: 160,
  formOption: {
    viewType: 'tag',
    width: 600,
    tagId: 'wxc_ec_product',
    tagName: '微信视频号电商商品信息',
    titleDataIndex: 'product_id'
  },
  api: wxcProduct.getList,
})

const columns = reactive([
  {
    title: "商品ID",
    dataIndex: "product_id",
    formType: "input",
    search: true,
    addDisplay: false,
    editDisplay: false,
  },
  {
    title: "商品名称",
    dataIndex: "title",
    formType: "input",
    search: true,
  },
  {
    dataIndex: "app_id",
    common: true,
  },
  {
    title: "类目",
    dataIndex: "cats_desc",
    formType: "input",
  },
  {
    title: "状态",
    dataIndex: "status",
    formType: "select",
    search: true,
    dict: {
      // 指定字典名称
      name: 'sku_status',
      // 设置解析数据的label 和 value
      props: {label: 'title', value: 'key'},
      // 对数据进行字典翻译
      translation: true
    }
  },
  {
    title: "价格（元）",
    dataIndex: "price",
    formType: "input",
  },
  {
    title: "商品佣金",
    dataIndex: "commission_info",
    formType: "input",
  },
])

const sync = () => {
  wxcProduct.syncProduct().then(res => {
    //success(res.message)
    Message.success(res.message)
  })
}

</script>
<script> export default {name: 'wxc:product'} </script>