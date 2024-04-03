<template>
    <el-tree :data="data" :props="{ label: 'menu_name' }" show-checkbox :expand-on-click-node="false"
        @check-change="handleCheckChange" node-key="menu_key" ref="treeRef" />
</template>
<script lang="ts" setup>
import { debounce } from '@/utils/common'
import { ref, computed, onMounted, nextTick } from 'vue'

const prop = defineProps({
    data: {
        type: Object,
        default: () => { }
    },
    modelValue: {
        type: Array,
        default: () => []
    }
})
const data = ref([])
data.value.push(prop.data)

const emit = defineEmits(['update:modelValue', 'change'])
const value = computed({
    get() {
        return prop.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})
const treeRef = ref(null)

//选择控制
onMounted(() => {
    nextTick(() => {
        const newArr: any = []
        prop.modelValue.forEach(el => checked(el, data.value, newArr))
        treeRef.value.setCheckedKeys(newArr)
    })
})
const checked = (key: string, data: any, newArr: any) => {
    data.forEach((el: any) => {
        if (key == el.menu_key) {
            if (!el.children || el.children.length == 0) {
                newArr.push(key)
            }
        } else {
            if (el.children && el.children.length > 0) {
                checked(key, el.children, newArr)
            }
        }
    })
}
const handleCheckChange = debounce((e) => {
    value.value = treeRef.value.getCheckedNodes(false, true).map(el => el.menu_key)
})
</script>
