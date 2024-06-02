<!--
 - MineAdmin is committed to providing solutions for quickly building web applications
 - Please view the LICENSE file that was distributed with this source code,
 - For the full copyright and license information.
 - Thank you very much for using MineAdmin.
 -
 - @Author X.Mo<root@imoi.cn>
 - @Link   https://gitee.com/xmo/mineadmin-vue
-->
<template>
  <div class="w-full">
    <a-spin :loading="formLoading" :tip="options.loadingText" class="w-full ma-form-spin">
      <div
          v-if="options.showFormTitle"
          :class="['ma-form-title', options.formTitleClass]"
          :style="options.formTitleStyle"
      >
        {{ options.formTitle }}
      </div>
      <a-form
          ref="maFormRef"
          :class="['ma-form', options?.customClass]"
          :disabled="options?.disabled"
          :label-align="options?.labelAlign"
          :layout="options?.layout"
          :model="form"
          :rules="options?.rules"
          :size="options?.size"
          @submit="formSubmit"
      >
        <slot name="formContent">
          <template v-for="(component, componentIndex) in columns" :key="componentIndex">
            <component
                :is="getComponentName(component?.formType ?? 'input')"
                :ref="setDialogRef"
                :component="component"
            >
              <template v-for="slot in Object.keys($slots)" #[slot]="component">
                <slot :name="slot" v-bind="component"/>
              </template>
            </component>
          </template>
          <div v-if="options.showButtons" class="text-center">
            <a-space>
              <slot name="formBeforeButtons"/>
              <slot name="formButtons">
                <a-button v-if="options.submitShowBtn" :status="options.submitStatus" :type="options.submitType"
                          html-type="submit">
                  <template v-if="options?.submitIcon" #icon>
                    <component :is="options.submitIcon"/>
                  </template>
                  {{ options.submitText }}
                </a-button>
                <a-button v-if="options.resetShowBtn" :status="options.resetStatus" :type="options.resetType"
                          @click="resetForm">
                  <template v-if="options?.resetIcon" #icon>
                    <component :is="options.resetIcon"/>
                  </template>
                  {{ options.resetText }}
                </a-button>
              </slot>
              <slot name="formAfterButtons"/>
            </a-space>
          </div>
        </slot>
      </a-form>
    </a-spin>
  </div>
</template>

<script setup>
import {getCurrentInstance, nextTick, onMounted, provide, ref, watch} from 'vue'
import {cloneDeep, get, isNil, set} from 'lodash'
import defaultOptions from './js/defaultOptions.js'
import {
  getComponentName,
  handleFlatteningColumns,
  insertGlobalCssToHead,
  insertGlobalFunctionsToHtml,
  interactiveControl,
  toHump
} from './js/utils.js'
import {handlerCascader, loadDict} from './js/networkRequest.js'
import arrayComponentDefault from './js/defaultArrayComponent.js'
import ColumnService from './js/columnService.js'
import {Message} from '@arco-design/web-vue'

const formLoading = ref(false)
const maFormRef = ref()
const dialogRefs = ref({})
const flatteningColumns = ref([])
const dictList = ref({})
const cascaderList = ref([])
const form = ref({})

const props = defineProps({
  modelValue: {type: Object, default: {}},
  columns: {type: Array},
  options: {type: Object, default: {}},
})
const emit = defineEmits(['submit', 'update:modelValue'])

watch(
    () => props.modelValue,
    vl => form.value = vl,
    {immediate: true, deep: true}
)

watch(
    () => form.value,
    vl => {
      interactiveControl(vl, flatteningColumns.value, {getColumnService, dictList})
      emit('update:modelValue', vl)
    },
    {deep: true}
)

const options = ref({})

// 初始化
const init = async () => {
  const containerList = import.meta.glob('./containerItem/*.vue', {eager: true})
  const componentList = import.meta.glob('./formItem/*.vue', {eager: true})
  const _this = getCurrentInstance()?.appContext ?? undefined
  if (_this) {
    for (const path in containerList) {
      const name = path.match(/([A-Za-z0-9_-]+)/g)[1]
      const containerName = `Ma${toHump(name)}`
      if (!_this.components[containerName]) {
        _this.app.component(containerName, containerList[path].default)
      }
    }

    for (const path in componentList) {
      const name = path.match(/([A-Za-z0-9_-]+)/g)[1]
      const componentName = `Ma${toHump(name)}`
      if (!_this.components[componentName]) {
        _this.app.component(componentName, componentList[path].default)
      }
    }
  }

  formLoading.value = true

  handleFlatteningColumns(props.columns, flatteningColumns.value)

  // 收集数据列表
  flatteningColumns.value.map(item => {
    if (item.cascaderItem && item.cascaderItem.length > 0) {
      cascaderList.value.push(...item.cascaderItem)
    }
  })

  // 初始化数据
  flatteningColumns.value.map(async item => {

    if (isNil(form.value[item.dataIndex])) {
      form.value[item.dataIndex] = undefined
      if (arrayComponentDefault.includes(item.formType)) {
        form.value[item.dataIndex] = []
      }
    }

    // 处理带点的字段
    if (item.dataIndex.indexOf('.') > -1) {
      const value = cloneDeep(form.value[item.dataIndex])
      delete form.value[item.dataIndex]
      set(form.value, item.dataIndex, value)
    }

    // 字典
    if (!cascaderList.value.includes(item.dataIndex) && item.dict) {
      await loadDict(
          dictList.value,
          item,
          options.value.sourceList,
          {formModel: form.value, getColumnService, columns: flatteningColumns.value}
      )
    }

    // 联动
    await handlerCascader(
        get(form.value, item.dataIndex),
        item,
        flatteningColumns.value,
        dictList.value,
        form.value,
        false
    )
  })

  await nextTick(() => {
    interactiveControl(form.value, flatteningColumns.value, {getColumnService, dictList})
    formLoading.value = false
  })
}

const setDialogRef = async (ref) => {
  await nextTick(() => {
    if (ref?.getDataIndex) {
      dialogRefs.value[ref.getDataIndex()] = ref
      if (!form.value[ref.getDataIndex()]) {
        form.value[ref.getDataIndex()] = {}
      }
    }
  })
}

// maEvent.handleCommonEvent(options.value, 'onCreated')

onMounted(async () => {
  updateOptions()
  insertGlobalCssToHead(options.value.globalCss)
  insertGlobalFunctionsToHtml(options.value.globalFunction)
  // maEvent.handleCommonEvent(options.value, 'onMounted')
  options.value.init && await init()
  // maEvent.handleCommonEvent(options.value, 'onInit')
})

const done = (status) => formLoading.value = status
const validateForm = async () => {
  const valid = await maFormRef.value.validate()
  if (valid) {
    let message = ''
    for (let name in valid) message += valid[name].message + "、"
    Message.error(message.substring(0, message.length - 1))
  }
  return valid
}
const resetForm = async () => await maFormRef.value.resetFields()
const clearValidate = async () => await maFormRef.value.clearValidate()

const formSubmit = async () => {
  if (await validateForm()) {
    return false
  }
  emit('submit', form.value, done)
}

/**
 * 获取column属性服务类
 * @returns ColumnService
 */
const getColumnService = (strictMode = true) => {
  return new ColumnService(
      {
        columns: flatteningColumns.value,
        cascaders: cascaderList.value,
        dicts: dictList.value,
        refs: dialogRefs.value
      },
      strictMode
  )
}

const getFormRef = () => maFormRef.value
const getDictList = () => dictList.value
const getColumns = () => flatteningColumns.value
const getCascaderList = () => cascaderList.value
const getFormData = () => form.value
const updateOptions = () => options.value = Object.assign(cloneDeep(defaultOptions), props.options)

provide('options', options.value)
provide('columns', flatteningColumns)
provide('dictList', dictList)
provide('formModel', form)
provide('formLoading', formLoading)
provide('getColumnService', getColumnService)

defineExpose({
  init, getFormRef, getColumns, getDictList, getColumnService, getCascaderList, getFormData,
  validateForm, resetForm, clearValidate, updateOptions
})
</script>

<style lang="less" scoped>
.ma-form-title {
  font-size: 18px;
  text-align: center;
}
</style>