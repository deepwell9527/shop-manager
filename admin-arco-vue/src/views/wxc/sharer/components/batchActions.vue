<template>
  <a-space class="lg:flex block">
    <!--  操作  -->
    <a-button
        v-for="(item, index) in actions"
        class="w-full lg:w-auto mt-2 lg:mt-0" status="normal"
        type="secondary"
        @click="handlerClickAction(item)"
    >
      {{ item.title }}
    </a-button>
  </a-space>
  <!--  弹窗  -->
  <a-modal v-model:visible="visible" :default-visible="false" :footer="false" :width="modalWidth">
    <template #title>
      {{ modalTitle }}
    </template>
    <component :is="modelFormCom" :ids="ids" @success="handlerSuccess"></component>
  </a-modal>
</template>

<script setup>

import {ref} from "vue";
import EditRate from "@/views/wxc/sharer/components/editRate.vue";
import EditWithdrawalFee from "@/views/wxc/sharer/components/editWithdrawalFee.vue";
import EditIsOrderLock from "@/views/wxc/sharer/components/editIsOrderLock.vue";
import EditIsRebate from "@/views/wxc/sharer/components/editIsRebate.vue";
import EditParentSharer from "@/views/wxc/sharer/components/editParentSharer.vue";
import {Message} from "@arco-design/web-vue";

const props = defineProps({
  ids: Array
})
const actions = [
  {
    'title': '修改分佣比例',
    'component': EditRate
  },
  {
    'title': '修改提现手续费',
    'component': EditWithdrawalFee,
    'width': '300px'
  },
  {
    'title': '下单锁客设置',
    'component': EditIsOrderLock,
    'width': '400px'
  },
  {
    'title': '自购返佣设置',
    'component': EditIsRebate,
    'width': '400px'
  },
  {
    'title': '解绑上级',
  },
  {
    'title': '设置/修改上级',
    'component': EditParentSharer,
  }
]

const visible = ref(false);
const modalTitle = ref('');
const modalWidth = ref('500px');
let modelFormCom = EditRate;

const handlerClickAction = (item) => {
  if (!props.ids.length) {
    Message.error('请选择分享员')
    return
  }
  visible.value = true
  modalTitle.value = item.title
  modelFormCom = item.component
  modalWidth.value = item.width ?? '500px'
}
const handlerSuccess = () => {
  visible.value = false
  emitDone()
}

// 向父组件提供一个事件方法：当操作完成时
const emit = defineEmits(['done'])
const emitDone = () => {
  emit('done')
}

</script>
