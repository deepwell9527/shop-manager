<template>
  <div class="ma-content-block lg:flex justify-between p-4">
    <!-- CRUD 组件 -->
    <ma-crud ref="crudRef" :columns="columns" :options="options">
      <!--   值太长，缩略，并提供复制   -->
      <template #secret="{ record }">
        <a-typography-paragraph copyable ellipsis style="margin-bottom: 0">
          {{ record.secret }}
        </a-typography-paragraph>
      </template>
      <template #token="{ record }">
        <a-typography-paragraph copyable ellipsis style="margin-bottom: 0">
          {{ record.token }}
        </a-typography-paragraph>
      </template>
      <template #aes_key="{ record }">
        <a-typography-paragraph copyable ellipsis style="margin-bottom: 0">
          {{ record.aes_key }}
        </a-typography-paragraph>
      </template>
      <template #server_url="{ record }">
        <a-typography-paragraph :copy-text="`${callbackUrl}${record.app_id}`" copyable ellipsis
                                style="margin-bottom: 0">
          **********
        </a-typography-paragraph>
      </template>

      <!--  为客户端提供随机生成消息令牌和密钥的操作    -->
      <template #form-token>
        <a-input v-model="tokenVal" disabled placeholder="点击刷新按钮生成令牌">
          <template #append>
            <a-button @click="refreshAppToken()">
              <template #icon>
                <icon-refresh/>
              </template>
            </a-button>
          </template>
        </a-input>
      </template>
      <template #form-aes_key>
        <a-input v-model="aesKeyVal" disabled placeholder="点击刷新按钮生成密钥">
          <template #append>
            <a-button @click="refreshAppKey()">
              <template #icon>
                <icon-refresh/>
              </template>
            </a-button>
          </template>
        </a-input>
      </template>
    </ma-crud>
  </div>
</template>
<script setup>
import {onMounted, reactive, ref} from 'vue'
import wxcShop from '@/api/wxc/wxcShop'
import tool from "@/utils/tool.js";

const crudRef = ref()
const tokenVal = ref()
const aesKeyVal = ref()
const callbackUrl = 'http://api.test.shop-manager.0203384.com/wxc/shop/callback/msgAndEvent?uuid=' + tool.getUUID() + '&app_id='

onMounted(() => {
})

const options = reactive({
  id: 'wxc_shop',
  rowSelection: {
    showCheckedAll: true
  },
  pk: 'shop_id',
  operationColumn: true,
  operationColumnWidth: 160,
  formOption: {
    viewType: 'modal',
    width: 600
  },
  api: wxcShop.getList,
  add: {
    show: true,
    api: wxcShop.save,
    auth: ['wxc:shop:save']
  },
  edit: {
    show: true,
    api: wxcShop.update,
    auth: ['wxc:shop:update']
  },
  delete: {
    show: true,
    api: wxcShop.deletes,
    auth: ['wxc:shop:delete']
  }
})

const columns = reactive([
  {
    title: "",
    dataIndex: "shop_id",
    formType: "input",
    addDisplay: false,
    editDisplay: false,
    hide: true
  },
  {
    title: "小店id",
    dataIndex: "app_id",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入小店id"
    }
  },
  {
    title: "小店密钥",
    dataIndex: "secret",
    formType: "input",
    commonRules: {
      required: true,
      message: "请输入小店密钥"
    },
    width: 80
  },
  {
    title: "消息令牌",
    dataIndex: "token",
    formType: "input",
    commonRules: {
      required: true,
      message: "请输入消息令牌"
    },
    width: 80
  },
  {
    title: "消息密钥",
    dataIndex: "aes_key",
    formType: "input",
    commonRules: {
      required: true,
      message: "请输入消息密钥"
    },
    width: 80
  },
  {
    title: "服务器地址",
    dataIndex: "server_url",
    formType: "input",
    addDisplay: false,
    editDisplay: false,
    width: 80
  },
  {
    title: "添加时间",
    dataIndex: "created_at",
    formType: "date",
    addDisplay: false,
    editDisplay: false,
    showTime: true
  },
  {
    title: "修改时间",
    dataIndex: "updated_at",
    formType: "date",
    addDisplay: false,
    editDisplay: false,
    showTime: true
  }
])

const refreshAppToken = () => {
  tokenVal.value = tool.genRandomStr(32)
  crudRef.value.crudFormRef.form.token = tokenVal.value
};

const refreshAppKey = () => {
  aesKeyVal.value = tool.genRandomStr(43)
  crudRef.value.crudFormRef.form.aes_key = aesKeyVal.value
};

</script>
<script> export default {name: 'wxc:shop'} </script>