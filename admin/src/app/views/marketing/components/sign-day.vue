<template>
    <div v-for="(item,index) in gifts" :key="index"  class="day-sign">
        <component :is="item.component" v-model="formData[item.key]" ref="giftRefs" v-if="item.component" />
    </div>
</template>

<script lang="ts" setup>
import { ref, defineAsyncComponent, computed, watch } from 'vue'
import { getGiftDict } from '@/app/api/member'

const gifts = ref({})
const props = defineProps({
    modelValue: {
        type: Object,
        default: () => {
            return {}
        }
    }
})
const emits = defineEmits(['update:modelValue'])
const formData = ref({})
const value = computed({
    get () {
        return props.modelValue
    },
    set (value) {
        emits('update:modelValue', value)
    }
})
const giftRefs = ref([])

watch(() => value.value, (nval, oval) => {
    if ((!oval || !Object.keys(oval).length) && Object.keys(nval).length) {
        formData.value = value.value
    }
}, { immediate: true })

watch(() => formData.value, () => {
    value.value = formData.value
}, { deep: true })

const modules: any = import.meta.glob('@/**/*.vue')
getGiftDict().then(({ data }) => {
    Object.keys(data).forEach((key: string) => {
        data[key].component && (data[key].component = defineAsyncComponent(modules[data[key].component]))
    })
    gifts.value = data
})

const verify = async () => {
    let verify = true
    for (let i = 0; i < giftRefs.value.length; i++) {
        const item = giftRefs.value[i]
        !await item.verify() && (verify = false)
    }
    return verify
}

defineExpose({
    verify
})
</script>

<style lang="scss" scoped>
.day-sign:nth-child(1) :deep(.el-form-item__error) {
   left:48px;
}
.day-sign:nth-child(2) :deep(.el-form-item__error) {
   left:48px;
}
</style>
