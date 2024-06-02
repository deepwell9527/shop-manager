<template>
  <a-link @click="handlerCheckSharerBaseInfo(record)">{{ record.nickname }}</a-link>
  <!-- 分享员基础信息弹窗 -->
  <a-modal
      v-model:visible="sharerBaseInfoModalVisible" :footer="false"
      body-class="flex items-center justify-center"
      title="分享员基础信息"
  >
    <a-descriptions :column="1" :data="sharerBaseInfo" size="large"/>
  </a-modal>
</template>

<script setup>

import {defineProps, ref} from "vue";

const props = defineProps({
  record: {
    type: Object,
    default: () => {
      return {}
    }
  }
})

const sharerBaseInfoModalVisible = ref(false)
let sharerBaseInfo = []
const handlerCheckSharerBaseInfo = (record) => {
  sharerBaseInfo = []
  let keyMap = {nickname: '微信昵称', 'openid': 'openid', 'unionid': 'unionid'};
  for (const recordKey in record) {
    if (keyMap[recordKey]) {
      sharerBaseInfo.push({
        label: keyMap[recordKey],
        value: record[recordKey]
      })
    }
  }
  sharerBaseInfoModalVisible.value = true
}

</script>
