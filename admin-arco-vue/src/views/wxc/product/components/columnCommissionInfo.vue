<template>
  <a-space>
    <a-switch :before-change="handlerBeforeChange" :checked-value="1"
              :default-checked="false" :model-value="spec.use_commission"></a-switch>
    <template v-if="spec.use_commission === 1">
      {{ spec.commission_rate }}%
    </template>
  </a-space>
  <!--  弹窗  -->
  <a-modal v-model:visible="visible" :default-visible="false" :footer="false" title="商品佣金" width="400px">
    <edit-commission-info :ids="ids" @success="handlerSuccess"></edit-commission-info>
  </a-modal>
</template>

<script setup>

import {reactive, ref, watch} from "vue";
import EditCommissionInfo from "@/views/wxc/product/components/editCommissionInfo.vue";

const props = defineProps({
  record: {
    type: Object,
    default: {}
  },
  column: {
    type: Object,
    default: {}
  },
  crudRef: {
    type: Object,
    default: {}
  }
})

const spec = reactive(props.record.spec ?? {
  use_commission: 0,
  commission_rate: 0
})

watch(
    () => props.record,
    (val) => {
      spec.use_commission = val.spec.use_commission
      spec.commission_rate = val.spec.commission_rate
    }
)

const visible = ref(false)
const ids = [props.record.product_id]

const handlerBeforeChange = () => {
  visible.value = true
  return false
}

const handlerSuccess = () => {
  visible.value = false
  props.crudRef.refresh()
}

</script>
