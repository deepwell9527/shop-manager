<template>
  <a-space direction="vertical">
    <a-tag :color="rateModeVal===1?'blue':'green'" bordered>
      {{ rateModeText }}
    </a-tag>
    <span>
      <template v-if="rateModeVal === 1">
        {{ levelIdText }}
      </template>
      <template v-else>
        <p>一级佣金比例：{{ firstTierRateVal }}%</p>
        <p>二级佣金比例：{{ secTierRateVal }}%</p>
      </template>
    </span>
  </a-space>
</template>

<script setup>

import {computed, defineProps} from "vue";
import {get} from "lodash";

const props = defineProps({
  record: {
    type: Object,
    default: () => {
      return {}
    }
  },
  column: {
    type: Object,
    default: () => {
      return {}
    }
  },
  dictTrans: {
    type: Function,
    default: () => {
      return ''
    }
  }
})

const rateModeIdx = props.column.dataIndex
// todo 待优化,先这样写死吧
const levelIdIdx = 'spec.level_id'
const firstTierRateIdx = 'spec.first_tier_rate'
const secTierRateIdx = 'spec.sec_tier_rate'

// 计算属性
const rateModeVal = computed(() => {
  return Number(get(props.record, rateModeIdx))
})
const rateModeText = computed(() => {
  return props.dictTrans(rateModeIdx, rateModeVal.value)
})
const levelIdVal = computed(() => {
  return Number(get(props.record, levelIdIdx))
})
const levelIdText = computed(() => {
  return props.dictTrans(levelIdIdx, levelIdVal.value)
})
const firstTierRateVal = computed(() => {
  return get(props.record, firstTierRateIdx)
})
const secTierRateVal = computed(() => {
  return get(props.record, secTierRateIdx)
})

</script>
