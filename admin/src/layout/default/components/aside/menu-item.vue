<template>
    <template v-if="meta.show">
        <el-sub-menu v-if="routes.children" :index="String(routes.name)">
            <template #title>
                <div class="w-[16px] h-[16px] relative flex items-center">
                    <icon v-if="meta.icon" :name="meta.icon" class="absolute !w-auto" />
                </div>
                <span class="ml-[10px]">{{ meta.title }}</span>
            </template>
            <menu-item v-for="(route, index) in routes.children" :routes="route" :key="index" />
        </el-sub-menu>
        <template v-else>
            <el-menu-item :index="String(routes.name)" @click="router.push({ name: routes.name })" v-if="meta.addon && meta.parent_route && meta.parent_route.addon == ''">
                <template #title>
                    <el-tooltip placement="right" effect="light">
                        <template #content>
                            该功能仅限{{ addons[meta.addon].title }}使用
                        </template>
                        <div class="w-[16px] h-[16px] relative flex items-center">
                            <icon v-if="meta.icon" :name="meta.icon" class="absolute !w-auto" />
                        </div>
                        <span class="ml-[10px]">{{ meta.title }}</span>
                    </el-tooltip>
                </template>
            </el-menu-item>
            <el-menu-item :index="String(routes.name)" @click="router.push({ name: routes.name })" v-else>
                <template #title>
                    <div class="w-[16px] h-[16px] relative flex items-center">
                        <icon v-if="meta.icon" :name="meta.icon" class="absolute !w-auto" />
                    </div>
                    <span class="ml-[10px]">{{ meta.title }}</span>
                </template>
            </el-menu-item>
        </template>
        <div v-if="routes.is_border" class="!border-0 !border-t-[1px] border-solid mx-[25px] bg-[#f7f7f7] my-[5px]"></div>
    </template>

</template>

<script lang="ts" setup>
import { useRouter } from 'vue-router'
import { computed } from 'vue'
import { img } from '@/utils/common'
import menuItem from './menu-item.vue'
import useSystemStore from '@/stores/modules/system'

const router = useRouter()
const props = defineProps({
    routes: {
        type: Object,
        required: true
    }
})
const systemStore = useSystemStore()
const meta = computed(() => props.routes.meta)

const addons = computed(() => {
    const addons:Record<string, any> = {}
    systemStore?.apps.forEach((item: any) => { addons[item.key] = item })
    systemStore?.addons.forEach((item: any) => { addons[item.key] = item })
    return addons
})

</script>

<style lang="scss">
.el-sub-menu{
    .el-icon{
        width: auto;
    }
}
</style>
