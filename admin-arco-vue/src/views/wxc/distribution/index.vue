<template>
  <div>
    <!--  分销模式设置  -->
    <a-card :bordered="false" title="模式设置">
      <!--  分销模式说明      -->
      <a-alert type="normal">
        <p>一级分销：分享员推广的商品被用户购买后抽取佣金，分享员佣金=一级分佣比例*订单实付金额</p>
        <p>
          二级分销：分享员推广的商品被用户购买后除自己抽取佣金外，还要给其直接上级抽佣，当前分享员佣金=一级分佣比例*订单实付金额，上级分享员=二级分佣比例*订单实付金额</p>
        <p>分享员需要开启推广下级分享员功能，才能邀请下级分享员。</p>
      </a-alert>

      <!--   分销模式选择     -->
      <a-radio-group :model-value="curDMode" class="mt-4" @change="handelDModeChange">
        <template v-for="item in dModeList" :key="item">
          <a-popover position="bottom">
            <a-radio :value="item.value">
              <template #radio="{ checked }">
                <a-space :class="{ 'custom-radio-card-checked': checked }"
                         align="center"
                         class="custom-radio-card"
                >
                  <div class="custom-radio-card-mask">
                    <div class="custom-radio-card-mask-dot"/>
                  </div>
                  <div>
                    <a-typography-title :bold="true" :heading="6">
                      {{ item.label }}
                    </a-typography-title>
                    <a-typography-text class="text-gray-400" type="secondary">
                      {{ item.desc }}
                    </a-typography-text>
                  </div>
                </a-space>
              </template>
            </a-radio>
            <!--     提示      -->
            <template #content>
              <a-image
                  :src="item.descImg"
                  width="400"
              />
            </template>
          </a-popover>

          <!--  切换分销模式确定对话框  -->
          <a-modal v-model:visible="item.confirmModal.visible" @cancel="cancelSwitchDMode"
                   @ok="confirmSwitchDMode">
            <template #title>
              确定将分销模式切换为{{ item.label }}吗？
            </template>
            <a-typography-text type="danger">
              {{ item.switchTip }}
            </a-typography-text>
          </a-modal>

        </template>
      </a-radio-group>
    </a-card>

    <!--  等级设置  -->
    <a-card :bordered="false" title="等级设置">
      <!--  等级说明      -->
      <a-alert type="normal">
        <ol>
          <li>
            1、一级分销佣金比例优先级说明：优先取商品分佣比例，其次取分享员单独设置的分佣比例，前两者都没有设置时，才会按照此处设置的一份分销比例计算佣金
          </li>
          <li>2、修改分佣比例，修改之后支付的订单将按照新的比例计算佣金。修改之前的订单还是按照修改前的分佣比例计算佣金
          </li>
          <li>3、同步历史订单时拉取到的分享员订单，按照同步时的分佣比例计算佣金</li>
          <li>
            4、分销模式和分享员等级方案作用于所有店铺
          </li>
        </ol>
      </a-alert>

      <!--   等级列表   -->
      <ma-crud ref="levelListRef" :columns="columns" :options="options">

      </ma-crud>

    </a-card>

  </div>
</template>

<script setup>
// 分销模式配置
import {reactive, ref} from "vue";
import wxcEcSharerLevel from "@/api/wxc/wxcSharerLevel.js";
import wxcEcDistribution from "@/api/wxc/wxcDistribution.js";
import {error, success} from "@/utils/common.js";

const curDMode = ref(1)
const dModeList = reactive([
  {
    value: 1,
    label: '一级分销',
    desc: '分享员推广的商品被用户购买后抽取佣金',
    descImg: '/distribution/first-tier-desc.png',
    switchTip: '切换模式之后立即生效。切换成一级分享，不会解除分享员绑定的下级分享员，只是下级分享员推广订单不会再给上级分享员计算佣金',
    confirmModal: {
      visible: false,
    }
  },
  {
    value: 2,
    label: '二级分销',
    desc: '分享员推广的商品被用户购买后除自己抽取佣金外，还要给其直接上级抽佣',
    descImg: '/distribution/sec-tier-desc.png',
    switchTip: '模式切换之后立即生效，开启了推广分享员功能的分享员可以发展二级分享员',
    confirmModal: {
      visible: false,
    }
  }
])

const pendingSwitchTo = ref(0)
const handelDModeChange = (value) => {
  console.log(value)
  let i = value - 1
  if (dModeList[i]) {
    dModeList[i].confirmModal.visible = true
    pendingSwitchTo.value = value
  }
}
const cancelSwitchDMode = () => {
  pendingSwitchTo.value = 0
}

const confirmSwitchDMode = () => {
  wxcEcDistribution.update({
    type: pendingSwitchTo.value
  }).then((res) => {
    if (res.code === 200) {
      curDMode.value = pendingSwitchTo.value
      success('切换成功')
    } else {
      error(res.message)
    }
  }).catch((e) => {
    console.log(e)
  })
}

const levelListRef = ref()

const options = reactive({
  id: 'wxc_ec_sharer_level',
  rowSelection: {
    showCheckedAll: true
  },
  pk: 'id',
  operationColumn: true,
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
  edit: {
    show: true,
    api: wxcEcSharerLevel.update,
    auth: ['wxc:sharerLevel:update']
  },
  delete: {
    show: true,
    api: wxcEcSharerLevel.deletes,
    auth: ['wxc:sharerLevel:delete']
  },
  showTools: true,
})

const columns = reactive([
  {
    title: "数据ID",
    dataIndex: "id",
    formType: "input",
    addDisplay: false,
    editDisplay: false,
    hide: true,
  },
  {
    title: "等级ID",
    dataIndex: "level_id",
    formType: "input",
    search: false,
    addDisplay: false,
    editDisplay: false,
  },
  {
    title: "等级名称",
    dataIndex: "title",
    formType: "input",
    search: false,
    commonRules: {
      required: true,
      message: "请输入等级名称"
    }
  },
  {
    title: "一级分销佣金比例",
    dataIndex: "first_tier_rate",
    formType: "input",
    search: false,
    commonRules: {
      required: true,
      message: "请输入一级分销佣金比例，分享员直接销售获得佣金的比例"
    }
  },
  {
    title: "二级分销佣金比例",
    dataIndex: "sec_tier_rate",
    formType: "input",
    search: false,
    commonRules: {
      required: true,
      message: "请输入二级分销佣金比例，分享员的下级的客户购买后获得佣金的比例"
    }
  },
  {
    title: "升级条件",
    dataIndex: "upgrade_criteria",
    formType: "form-group",
    search: false,
    commonRules: {
      required: true,
      message: "请输入升级条件"
    }
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


</script>

<script> export default {name: 'wxc:ecDistribution'} </script>

<style scoped>
.custom-radio-card {
  padding: 10px 16px;
  border: 1px solid var(--color-border-2);
  border-radius: 4px;
  width: 400px;
  height: 104px;
  box-sizing: border-box;
}

.custom-radio-card-mask {
  height: 14px;
  width: 14px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 100%;
  border: 1px solid var(--color-border-2);
  box-sizing: border-box;
}

.custom-radio-card-mask-dot {
  width: 8px;
  height: 8px;
  border-radius: 100%;
}

.custom-radio-card-title {
  color: var(--color-text-1);
  font-size: 14px;
  font-weight: bold;
  margin-bottom: 8px;
}

.custom-radio-card:hover,
.custom-radio-card-checked,
.custom-radio-card:hover .custom-radio-card-mask,
.custom-radio-card-checked .custom-radio-card-mask {
  border-color: rgb(var(--primary-6));
}

.custom-radio-card-checked {
  background-color: var(--color-primary-light-1);
}

.custom-radio-card:hover .custom-radio-card-title,
.custom-radio-card-checked .custom-radio-card-title {
  color: rgb(var(--primary-6));
}

.custom-radio-card-checked .custom-radio-card-mask-dot {
  background-color: rgb(var(--primary-6));
}
</style>