<template>
  <div class="ma-content-block lg:flex justify-between p-4">
    <!-- CRUD 组件 -->
    <ma-crud ref="crudRef" :columns="columns" :options="options">

      <!--   昵称   -->
      <template #nickname="{record}">
        <column-nickname :record="record"/>
      </template>

      <!--   佣金比例   -->
      <template #spec.rate_mode="{record,column}">
        <column-rate-mode :column="column" :dict-trans="crudRef.dictTrans" :record="record"/>
      </template>

      <!--   下单锁客   -->
      <template #spec.is_order_lock="{record, column}">
        <a-space>
          <a-switch :default-checked="Boolean(record.spec.is_order_lock)" disabled></a-switch>
          <template v-if="record.spec.is_order_lock===1">
            时效：{{ formatTime(record.spec.lock_expires_in) }}
          </template>
        </a-space>
      </template>

      <!--   自购返佣   -->
      <template #spec.is_rebate="{record, column}">
        <a-switch :default-checked="Boolean(record.spec.is_rebate)" disabled></a-switch>
      </template>

      <!--   下级分享员员   -->
      <template #subs="{record}">
        <a-link @click="handlerCheckSharerSubs(record)">查看</a-link>
      </template>

      <!--   列表头操作   -->
      <template #tableBeforeButtons>
        <a-button status="success" type="primary" @click="sync()">
          同步
          <template #icon>
            <icon-refresh/>
          </template>
        </a-button>
        <a-button status="normal" type="primary" @click="bind()">
          <template #icon>
            <icon-user-add/>
          </template>
          邀请
        </a-button>
      </template>
      <template #tableAfterButtons="{ selectedIds }">
        <BatchActions :ids="selectedIds" @done="crudRef.refresh()"/>
      </template>
    </ma-crud>

    <!--  邀请弹窗  -->
    <ma-form-modal
        ref="bindRef"
        v-model:visible="bindModalVisible"
        :column="bindColumns"
        :submit="getBindQrCode"
        :width=500
        title="邀请"
    >
    </ma-form-modal>

    <!-- 邀请二维码弹窗 -->
    <a-modal
        v-model:visible="qrCodeVisible" :footer="false" :mask-closable="false"
        body-class="flex items-center justify-center"
        title="邀请二维码"
        @cancel="cancelQrCodeModal"
    >
      <a-image
          :src="qrCode"
          height="400"
          width="400"
      />
    </a-modal>
  </div>
</template>

<script setup>
import {reactive, ref} from 'vue'
import wxcEcSharer from '@/api/wxc/wxcSharer'
import MaFormModal from '@/components/ma-form-modal/index.vue'
import BatchActions from "@/views/wxc/sharer/components/batchActions.vue"
import {Message} from "@arco-design/web-vue"
import {useSiteStore} from '@/store'
import {useRouter} from 'vue-router'
import {addTag} from "@/utils/common.js";
import ColumnNickname from "@/views/wxc/sharer/components/columnNickname.vue";
import ColumnRateMode from "@/views/wxc/sharer/components/columnRateMode.vue";

const props = defineProps({
  // 父级分享员id
  parentSharerId: {
    type: Number,
    default: 0
  }
})

const siteStore = useSiteStore()
const crudRef = ref()
const bindRef = ref()
const bindModalVisible = ref(false)
const qrCodeVisible = ref(false)
const qrCode = ref()

// 列表配置
const options = reactive({
  id: 'wxc_sharer',
  rowSelection: {
    showCheckedAll: true
  },
  pk: 'sharer_id',
  operationColumn: true,
  operationColumnWidth: 160,
  formOption: {
    viewType: 'modal',
    width: 600
  },
  api: wxcEcSharer.getList,
  beforeRequest: (params) => {
    params.parent_sharer_id = props.parentSharerId
  },
  edit: {
    api: wxcEcSharer.updateSpec,
    auth: [],
    role: [],
    text: '编辑',
    show: true,
    // action: (record) => {
    //   console.log(record)
    // }
  },
  showTools: false,
})

// 列表字段配置
const columns = reactive([
  {
    title: "分享员",
    dataIndex: "nickname",
    formType: "input",
    search: true,
    width: 150,
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
    title: "分佣比例",
    dataIndex: "spec.rate_mode",
    width: 150,
    formType: "radio",
    dict: {
      // 指定字典名称
      name: 'rate_mode',
      // 设置解析数据的label 和 value
      props: {label: 'title', value: 'key'},
      // 对数据进行字典翻译
      translation: true
    }
  },
  {
    dataIndex: "spec.level_id",
    title: "等级身份",
    formType: "select",
    search: true,
    rules: {
      required: true,
      message: '请选择等级'
    },
    dict: {
      data: () => siteStore.fetchSharerLevelDict()
    },
    hide: true,
  },
  {
    title: "提现手续费",
    dataIndex: "spec.withdrawal_fee",
    formType: "input",
  },
  {
    title: "分享员类型",
    dataIndex: "sharer_type",
    formType: "select",
    search: true,
    commonRules: {
      required: true,
      message: "请输入分享员类型"
    },
    dict: {
      // 指定字典名称
      name: 'sharer_type',
      // 设置解析数据的label 和 value
      props: {label: 'title', value: 'key'},
      // 对数据进行字典翻译
      translation: true
    }
  },
  {
    title: "下单锁客",
    dataIndex: "spec.is_order_lock",
    formType: "input",
    width: 150
  },
  {
    title: "上级分享员",
    dataIndex: "parent.nickname",
    formType: "input",
  },
  {
    title: "下级分享员",
    dataIndex: "subs",
    formType: "button",
    display: false,
  },
  {
    title: "自购返佣",
    dataIndex: "spec.is_rebate",
    formType: "input"
  },
  {
    title: "绑定时间",
    dataIndex: "bind_time",
    formType: "range",
    search: true,
    showTime: true,
    width: 150,
    editDisplay: false,
  }
])

const formatTime = (seconds) => {
  // 定义时间单位的秒数
  const minute = 60;
  const hour = minute * 60;
  const day = hour * 24;
  const month = day * 30; // 假设一个月平均30天
  const year = month * 12; // 按每年12个月

  // 计算时间描述
  const years = Math.floor(seconds / year);
  const months = Math.floor((seconds % year) / month);
  const days = Math.floor((seconds % month) / day);
  const hours = Math.floor((seconds % day) / hour);
  const minutes = Math.floor((seconds % hour) / minute);

  // 构建时间描述字符串
  let timeDescription = '';
  if (years > 0) timeDescription += `${years}年`;
  if (months > 0) timeDescription += `${months}月`;
  if (days > 0) timeDescription += `${days}天`;
  if (hours > 0) timeDescription += `${hours}小时`;
  if (minutes > 0) timeDescription += `${minutes}分钟`;

  return timeDescription || '';
}

const bindColumns = reactive([
  {
    dataIndex: "app_id",
    title: "店铺",
    rules: [{
      required: true,
      message: "请选择店铺"
    }],
    formType: "select",
    dict: {
      // 远程通用接口请求，新版代码生成都有一个 remote 接口
      remote: 'wxc/shop/remote',
      // 指定组件接收的props
      props: {label: 'base_info.nickname', value: 'app_id'},
      // 开启分页
      openPage: false,
      // 远程请求配置项
      remoteOption: {
        // 设置查询的字段
        select: ['app_id', 'shop_id'],
        // 关联模型
        relations: [
          // 定义关联，关联该用户的登录日志信息
          {
            name: 'baseInfo', // 关联名
            model: 'App.Wxc.Model.WxcShopInfo', // 关联模型的命名空间，使用 . 代替 \，可咨询后端人员
            type: 'hasOne', // 关联类型，hasOne：一对一，hasMany：一对多，belongsTo：一对多（反向），belongsToMany：多对多
            foreignKey: 'shop_id',
            localKey: 'shop_id',
          },
        ]
      }
    }
  },
  {
    dataIndex: "username",
    title: "微信号",
    placeholder: "不填，获得的二维码可以邀请多个用户",
  },
])

const sync = () => {
  wxcEcSharer.sync().then(res => {
    Message.success(res.message)
  })
}

const bind = () => {
  bindModalVisible.value = true
}

const getBindQrCode = async (data) => {
  wxcEcSharer.bind(data).then(res => {
    if (res.code !== 200 && res.success) {
      Message.error(res.message)
    } else if (res.data.errcode !== 0) {
      Message.error(res.data.errmsg)
    } else {
      qrCode.value = 'data:image/png;base64,' + res.data.qrcode_img_base64
      qrCodeVisible.value = true
    }
  })
}

const cancelQrCodeModal = () => {
  qrCodeVisible.value = false;
}

const router = useRouter()

// 新开一个页面展示指定分享员的下级
const handlerCheckSharerSubs = (record) => {
  const path = '/wxc/sharer/index?parent_sharer_id=' + record.sharer_id
  router.push(path)
  // 页面tag栏，新增一个tag
  addTag({
    name: 'wxc:sharer:index', path: path, title: record.nickname + '的下级'
  })
}

</script>

<style scoped>

</style>