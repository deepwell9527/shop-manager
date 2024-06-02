<template>
  <div class="ma-content-block lg:flex justify-between p-4">
    <!-- CRUD 组件 -->
    <ma-crud ref="crudRef" :columns="columns" :options="options">
    </ma-crud>
  </div>
</template>
<script setup>
import {reactive, ref} from 'vue'
import wxcEcSharerLevel from '@/api/wxc/wxcSharerLevel'

const crudRef = ref()


const options = reactive({
  id: 'wxc_ec_sharer_level',
  rowSelection: {
    showCheckedAll: true
  },
  pk: 'id',
  operationColumn: false,
  operationColumnWidth: 160,
  formOption: {
    viewType: 'modal',
    width: 600
  },
  api: wxcEcSharerLevel.getList,
  add: {
    show: true,
    api: wxcEcSharerLevel.save,
    auth: ['wxc:sharerLevel:save']
  },
  delete: {
    show: true,
    api: wxcEcSharerLevel.deletes,
    auth: ['wxc:sharerLevel:delete']
  }
})

const columns = reactive([
  {
    title: "",
    dataIndex: "id",
    formType: "input",
    addDisplay: false,
    editDisplay: false,
    hide: true,
    commonRules: {
      required: true,
      message: "请输入"
    }
  },
  {
    title: "租户ID",
    dataIndex: "site_id",
    formType: "input",
    search: true,
    hide: true,
    commonRules: {
      required: true,
      message: "请输入租户ID"
    }
  },
  {
    title: "等级ID",
    dataIndex: "level_id",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入等级ID"
    }
  },
  {
    title: "等级名称",
    dataIndex: "title",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入等级名称"
    }
  },
  {
    title: "一级分销佣金比例，分享员直接销售获得佣金的比例",
    dataIndex: "first_tier_rate",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入一级分销佣金比例，分享员直接销售获得佣金的比例"
    }
  },
  {
    title: "二级分销佣金比例，分享员的下级的客户购买后获得佣金的比例",
    dataIndex: "sec_tier_rate",
    formType: "input",
    search: true,
    commonRules: {
      required: true,
      message: "请输入二级分销佣金比例，分享员的下级的客户购买后获得佣金的比例"
    }
  },
  {
    title: "升级条件",
    dataIndex: "upgrade_criteria",
    formType: "form-group",
    search: true,
    commonRules: {
      required: true,
      message: "请输入升级条件"
    }
  },
  {
    title: "",
    dataIndex: "created_at",
    formType: "date",
    addDisplay: false,
    editDisplay: false,
    commonRules: {
      required: true,
      message: "请输入"
    },
    showTime: true
  },
  {
    title: "",
    dataIndex: "updated_at",
    formType: "date",
    addDisplay: false,
    editDisplay: false,
    commonRules: {
      required: true,
      message: "请输入"
    },
    showTime: true
  }
])
</script>
<script> export default {name: 'wxc:sharerLevel'} </script>