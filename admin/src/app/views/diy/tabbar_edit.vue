<template>
    <div class="main-container">
        <el-card class="card !border-none" shadow="never">
            <el-page-header :content="pageName" :icon="ArrowLeft" @back="back()" />
        </el-card>

        <el-card class="box-card mt-[15px] !border-none" shadow="never" v-loading="loading">
            <div class="flex">
                <div class="w-[360px] h-[400px] absolute mr-[30px] border-[1px] border-gray-300">
                    <div class="flex items-center justify-between absolute h-[60px] left-[0px] right-[0px] bottom-[0px] border-[1px] border-primary" :style="{ 'backgroundColor': diyBottomData.value.backgroundColor }">
                        <div class="flex flex-1 flex-col items-center justify-center" v-for="(item, index) in diyBottomData.value.list" :key="'b' + index">
                            <el-image class="w-[22px] h-[22px] mb-[5px] leading-1" :src="img(item.iconPath)" :fit="contain"  v-if="['1', '2'].includes(diyBottomData.value.type.toString())">
                                <template #error>
                                    <div class="image-slot flex justify-center items-center mt-1">
                                        <el-icon><Picture class="text-3xl text-gray-500" /></el-icon>
                                    </div>
                                </template>
                            </el-image>
                            <span class="text-[12px]" v-if="['1', '3'].includes(diyBottomData.value.type.toString())" :style="{ 'color': diyBottomData.value.textColor }">{{ item.text }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex-1 ml-[430px]">
                    <div class="flex items-center border-l-[3px] border-primary pl-[5px] leading-[1.1] mt-[10px]">
                        <span class="text-[14px]">{{ t('editing') }}</span>
                        <span class="text-[14px] text-primary mx-[3px]">{{ diyBottomData.info.title }}</span>
                        <span class="text-[14px]">{{ t('bottomNav') }}</span>
                        <span class="text-[12px] ml-[8px] text-gray-500">{{ t('bottomNavHint') }}</span>
                    </div>
                    <el-form :model="diyBottomData.value" label-width="100px" ref="formRef">
                        <el-tabs v-model="activeName" class="demo-tabs mt-[15px]">
                            <el-tab-pane :label="t('navImage')" name="navPicture">
                                <div ref="navItemRef">
                                    <div v-for="(item,index) in diyBottomData.value.list" :key="'a'+index" :data-id="index"  class="item-wrap border-2 border-dashed pt-[18px] m-[10px] mb-[15px] relative list-item" :class="{ 'not-sort': useDrag }">
                                        <el-form-item :label="t('navIconOne')">
                                            <div class="flex align-center">
                                                <div class="flex flex-col justify-center items-center">
                                                    <upload-image v-model="item.iconPath" width="60px" height="60px" :limit="1" />
                                                    <span class="mr-[10px] text-sm">{{t('uploadImgUnselected')}}</span>
                                                </div>
                                                <div class="flex flex-col justify-center items-center">
                                                    <upload-image v-model="item.iconSelectPath" width="60px" height="60px" :limit="1" />
                                                    <span class="mr-[10px] text-sm">{{t('uploadImgSelected')}}</span>
                                                </div>
                                            </div>
                                        </el-form-item>
                                        <el-form-item :label="t('navTitleOne')">
                                            <el-input class="!w-[215px]" v-model.trim="item.text" :placeholder="t('titleContent')" maxlength="5" show-word-limit />
                                        </el-form-item>
                                        <el-form-item :label="t('navLinkOne')">
                                            <diy-link v-model="item.link" @confirm="diyLinkFn" />
                                        </el-form-item>
                                        <el-icon class="close-icon cursor-pointer -top-[11px] -right-[8px]" @click="deleteNav(index)">
                                            <CircleCloseFilled />
                                        </el-icon>
                                    </div>
                                </div>

                                <el-button type="primary" class="mt-[15px]" v-show="diyBottomData.value.list.length < 5" @click="addNav">{{ t('addnav') }}</el-button>
                            </el-tab-pane>
                            <el-tab-pane :label="t('styleSet')" name="setStyle">
                                <el-form-item :label="t('navType')">
                                    <el-radio-group v-model="diyBottomData.value.type" class="ml-4">
                                        <el-radio label="1" size="large">{{ t('imageText') }}</el-radio>
                                        <el-radio label="2" size="large">{{ t('image') }}</el-radio>
                                        <el-radio label="3" size="large">{{ t('text') }}</el-radio>
                                    </el-radio-group>
                                </el-form-item>
                                <el-form-item :label="t('textColor')">
                                    <div class="flex align-center">
                                        <el-color-picker v-model="diyBottomData.value.textColor" />
                                        <el-input class="ml-[10px]" v-model.trim="diyBottomData.value.textColor" disabled />
                                        <el-button class="ml-[10px]" type="primary" @click="diyBottomData.value.textColor = '#333333'">{{ t('reset') }}</el-button>
                                    </div>
                                </el-form-item>
                                <el-form-item :label="t('textSelectColor')">
                                    <div class="flex align-center">
                                        <el-color-picker v-model="diyBottomData.value.textHoverColor" />
                                        <el-input class="ml-[10px]" v-model.trim="diyBottomData.value.textHoverColor" disabled />
                                        <el-button class="ml-[10px]" type="primary" @click="diyBottomData.value.textHoverColor = '#333333'">{{ t('reset') }}</el-button>
                                    </div>
                                </el-form-item>
                                <el-form-item :label="t('backgroundColor')">
                                    <div class="flex align-center">
                                        <el-color-picker v-model="diyBottomData.value.backgroundColor" />
                                        <el-input class="ml-[10px]" v-model.trim="diyBottomData.value.backgroundColor" disabled />
                                        <el-button class="ml-[10px]" type="primary" @click="diyBottomData.value.backgroundColor = '#FFFFFF'">{{ t('reset') }}</el-button>
                                    </div>
                                </el-form-item>
                            </el-tab-pane>
                        </el-tabs>
                    </el-form>
                </div>
            </div>
        </el-card>
        <div class="fixed-footer-wrap">
            <div class="fixed-footer">
                <el-button type="primary" @click="onSave(formRef)">{{ t('save') }}</el-button>
                <el-button @click="back()">{{ t('back') }}</el-button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, reactive, onMounted, nextTick } from 'vue'
import { t } from '@/lang'
import { img } from '@/utils/common'
import type { FormInstance, ElNotification } from 'element-plus'
import { ArrowLeft } from '@element-plus/icons-vue'
import { getDiyBottomConfig, setDiyBottomConfig } from '@/app/api/diy'
import Sortable from 'sortablejs'
import { range } from 'lodash-es'
import { useRoute,useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const pageName = route.meta.title

const activeName = ref<string>('navPicture')
const loading = ref<boolean>(false)
route.query.key = route.query.key || '';

// 底部导航数据
const diyBottomData = reactive({
    key:'',
    info:{},
    value:{
        backgroundColor: '#FFFFFF',
        textColor: '#333333',
        textHoverColor: '#333333',
        type: '1',
        list: []
    }
})

// 底部导航项数据
const diyBottomItemData = reactive({
    text: '',
    link: {
        name: '',
        title: '',
        parent: '',
        url: ''
    },
    iconSelectPath: '',
    iconPath: ''
})

// 添加导航
const addNav = (): void => {
    if (diyBottomData.value.list.length >= 5) return
    diyBottomData.value.list.push({ ...diyBottomItemData })
}

addNav()

// 删除导航
const deleteNav = (index:any): void => {
    const data = diyBottomData.value.list
    data.splice(index, 1)
}

const formRef = ref<FormInstance>()
/**
 * 获取导航数据
 */
const getDiyBottomFn = () => {
    loading.value = true

    getDiyBottomConfig({
        key:route.query.key
    }).then(res => {
        loading.value = false
        Object.keys(diyBottomData).forEach((item, index) => {
            diyBottomData[item] = res.data[item]
        })
    }).catch(() => {
        loading.value = false
    })
}
getDiyBottomFn()

// 保存导航数据
const onSave = async (formEl: FormInstance | undefined) => {
    if (verifyFn()) return false

    if (loading.value || !formEl) return
    await formEl.validate(async (valid) => {
        if (valid) {
            loading.value = true
            setDiyBottomConfig({key: diyBottomData.key, value: diyBottomData.value}).then(res => {
                loading.value = false
            }).catch(() => {
                loading.value = false
            })
        }
    })
}

const back = () => {
    router.push('/diy/tabbar')
}

// 验证
const verifyFn = (): boolean => {
    if (diyBottomData.value.list.length < 2) {
        ElNotification({
            type: 'error',
            message: t('leastTwoNav')
        })
        return true
    }
    try {
        const msg = ref<string>('')
        diyBottomData.value.list.forEach((item: any, index) => {
            if (!item.iconPath) msg.value = `${t('pleaseUpload')}${index + 1}${t('navIcon')}`
            if (!item.iconSelectPath) msg.value = `${t('pleaseUpload')}${index + 1}${t('navSelectIcon')}`
            if (!item.text) msg.value = `${t('pleaseEnter')}[${index + 1}${t('navTitle')}`
            if (!item.link.url) msg.value = `${t('pleaseChoose')}${index + 1}${t('navLink')}`
            if (msg.value) {
                ElNotification({
                    type: 'error',
                    message: msg.value
                })
                throw Error()
            }
        })
    } catch (e) {
        return true
    }
    return false
}

const navItemRef = ref()

onMounted(() => {
    const sortable = Sortable.create(navItemRef.value, {
        group: 'item-wrap',
        animation: 200,
        filter: '.not-sort', // 过滤.not-sort的元素
        onEnd: event => {
            const temp = diyBottomData.value.list[event.oldIndex!]
            diyBottomData.value.list.splice(event.oldIndex!, 1)
            diyBottomData.value.list.splice(event.newIndex!, 0, temp)
            nextTick(() => {
                sortable.sort(
                    range(diyBottomData.value.list.length).map(value => {
                        return value.toString()
                    })
                )
            })
        }
    })
})

const useDrag = ref(false)
const diyLinkFn = (val) => {
    useDrag.value = val
}
</script>
<style lang="scss" scoped>
.close-icon {
    display: none;
    position: absolute !important;
    font-size: 20px !important;
    color: #7d7b7b !important;
}

.list-item:hover .close-icon {
    display: block;
}
</style>
