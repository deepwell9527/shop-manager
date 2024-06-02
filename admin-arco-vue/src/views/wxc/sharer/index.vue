<template>
  <SharerList v-bind="bind"/>
</template>

<script setup>
import {useRoute} from 'vue-router';
import SharerList from "@/views/wxc/sharer/components/sharerList.vue";

const route = useRoute()
const parentSharerId = route.query.parent_sharer_id ?? 0
const bind = {
  parentSharerId: Number(parentSharerId),
}

</script>
<script> export default {name: 'wxc:sharer'} </script>