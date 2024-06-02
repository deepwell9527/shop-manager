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
    <component :is="modelFormCom" :ids="productIdList" @success="handlerSuccess"></component>
  </a-modal>
</template>

<script setup>

import {reactive, ref, watch} from "vue";
import EditCommissionInfo from "@/views/wxc/product/components/editCommissionInfo.vue";
import {Message} from "@arco-design/web-vue";

const props = defineProps({
  ids: Array,
  crudRef: {
    type: Object,
    default: {}
  },
})

const productIdList = ref(props.ids ?? [])

watch(
    () => props.ids,
    (newVal) => {
      productIdList.value = newVal
      console.log(productIdList.value)
    }
)

const actions = [
  {
    'title': '批量佣金设置',
    'component': EditCommissionInfo,
    'width': '400px'
  },
]

const visible = ref(false);
const modalTitle = ref('');
const modalWidth = ref('500px');
let modelFormCom = EditCommissionInfo;

const handlerClickAction = (item) => {
  if (!props.ids.length) {
    Message.error('请选择商品')
    return
  }
  visible.value = true
  modalTitle.value = item.title
  modelFormCom = item.component
  modalWidth.value = item.width ?? '500px'
}
const handlerSuccess = () => {
  visible.value = false
  props.crudRef.refresh()
}

</script>
