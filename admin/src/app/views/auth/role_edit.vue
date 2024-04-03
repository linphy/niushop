<template>
    <div class="main-container" v-loading="loading">
        <div class="detail-head">
            <div class="left" @click="router.push({ path: '/auth/role' })">
                <span class="iconfont iconxiangzuojiantou !text-xs"></span>
                <span class="ml-[1px]">{{ t('returnToPreviousPage') }}</span>
            </div>
            <span class="adorn">|</span>
            <span class="right">{{ pageName }}</span>
        </div>
        <el-form :model="formData" label-width="90px" ref="formRef" :rules="formRules" class="page-form mt-[30px]" v-if="!loading">
            <el-row>
                <el-col :span="24">
                    <el-form-item :label="t('roleName')" prop="role_name">
                        <el-input v-model="formData.role_name" :placeholder="t('roleNamePlaceholder')" clearable :disabled="formData.uid" class="input-width" maxlength="10" :show-word-limit="true" />
                    </el-form-item>
                </el-col>
                <el-col :span="24">
                    <el-form-item :label="t('status')">
                        <el-radio-group v-model="formData.status">
                            <el-radio :label="1">{{ t('startUsing') }}</el-radio>
                            <el-radio :label="0">{{ t('statusDeactivate') }}</el-radio>
                        </el-radio-group>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <div class="px-[15px]" v-if="!loading">
            <el-tabs v-model="activeName" class="demo-tabs">
                <el-tab-pane :label="t('system')" name="system">
                    <div class="flex items-center justify-between">
                        <div>
                            <el-checkbox v-model="checkAll" :label="t('selectAll')" />
                        </div>
                    </div>
                    <!-- :check-strictly="checkStrictly" -->
                    <el-tree :data="menusData" :props="{ label: 'menu_name' }" show-checkbox @check-change="handleCheckChange" :expand-on-click-node="false" node-key="menu_key" ref="treeRef" />
                </el-tab-pane>
                <el-tab-pane :label="t('application')" name="application">
                    <div v-for="(item, index) in addonList" :key="index"
                        class="p-[15px] border-[1px] border-solid border-[#e4e7ed] mt-[15px]">
                        <addon-role v-if="item.children" v-model="(formData.addon as any)[(item as any).key]" :data="(item as any)" />
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
        <div class="fixed-footer-wrap" v-if="!loading">
            <div class="fixed-footer">
                <el-button type="primary" @click="onSave(formRef)">{{ t('save') }}</el-button>
                <el-button @click="router.push({ path: '/auth/role' })">{{ t('cancel') }}</el-button>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { reactive, ref, toRefs, watch, toRaw, onMounted, nextTick } from 'vue'
import { t } from '@/lang'
import { getSystem, getRoleInfo, getAddonList, editRole, addRole } from '@/app/api/sys'
import { debounce } from '@/utils/common'
import { useRoute, useRouter } from 'vue-router'
import addonRole from '@/app/views/auth/components/addon-role.vue'
import { ElMessage } from 'element-plus'

const route = useRoute()
const router = useRouter()
const pageName = route.meta.title
const state = reactive({
    loading: false,
    activeName: "system",
    checkAll: false,
    formData: {
        role_name: '',
        status: 1,
        addon: {},
        system: []
    },
    menusData: [],
    addonList: [],
})
let formRef = ref(null)
let formRules = ref({
    role_name: [
        { required: true, message: t('roleNamePlaceholder'), trigger: 'blur' }
    ],
    rules: [
        {
            validator: (rule: any, value: string, callback: any) => {
                if (!value.length) callback(new Error(t('rulesPlaceholder')))
                else callback()
            },
            trigger: 'blur'
        }
    ]
})
let { loading, formData, activeName, checkAll, menusData, addonList, } = toRefs(state)

onMounted(async () => {
    // 获取全部系统权限
    loading.value = true
    let menusData = await getSystem({status: 1})
    if (menusData.data) state.menusData = menusData.data
    //获取应用列表
    let addonList = await getAddonList()
    if (addonList.data) state.addonList = addonList.data.map((el:any)=>{el.menu_name = el.title;el.menu_key = el.key;return el})
    if (route.query.role_id) { getRoleInfoFn(route.query.role_id) } else { loading.value = false }
})

//获取分组详情
const getRoleInfoFn = (id: any) => {
    getRoleInfo(id).then(res => {
        state.formData = Object.assign(formData.value, res.data)
        formData.value.addon = Object.assign(formData.value.addon, formData.value.rules.addon)
        formData.value.system = Object.assign(formData.value.system, formData.value.rules.system)
        loading.value = false
        nextTick(() => {
            var newArr: any = []
            formData.value.system.forEach(el => checked(el, toRaw(menusData.value), newArr))
            treeRef.value.setCheckedKeys(newArr)
        })

    }).catch(() => {
        loading.value = false
    })
}
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
//系统权限全选择
let treeRef = ref(null)
watch(checkAll, () => {
    if (checkAll.value) {
        treeRef.value.setCheckedNodes(toRaw(menusData.value))
    } else {
        treeRef.value.setCheckedNodes([])
    }
})
//系统权限选择控制
const handleCheckChange = debounce((e) => {
    state.formData.system = treeRef.value.getCheckedNodes(false, true).map(el => el.menu_key)
})
/**
 * 确认
 * @param formEl
 */
const onSave = async (formEl: FormInstance | undefined) => {
    // if (loading.value || !formEl) return
    const save = formData.value.role_id ? editRole : addRole


    await formEl.validate(async (valid) => {
        if (valid) {
            // loading.value = true
            if (!formData.value.system.length) {
                ElMessage({
                    message: `${t('systemErr')}`,
                })
                return false
            }
            var arr = Object.values(formData.value.addon).filter((el: any) => {
                if (el.length) {
                    return true
                }
            })
            if (!arr.length) {
                ElMessage({
                    message: `${t('applicationErr')}`,
                })
                return false
            }
            const data = Object.assign({}, formData.value);
            data.rules = {
                system: data.system,
                addon: data.addon
            }
            save(data).then(res => {
                router.push({ path: "/auth/role" })
            }).catch(() => {
                loading.value = false
                // showDialog.value = false
            })
        }
    })
}
</script>
<style lang="scss" scoped>
.main-container {
    min-height: calc(100vh - 84px);
}
</style>
