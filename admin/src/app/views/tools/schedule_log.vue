<template>
    <div class="main-container">

        <el-card class="card !border-none" shadow="never">
            <el-page-header :icon="ArrowLeft" @back="$router.back()">
                <template #content>
                    <span class="text-large font-600 mr-3">{{ pageName }}</span>
                </template>
            </el-page-header>
        </el-card>

        <el-card class="box-card !border-none" shadow="never">

            <el-card class="box-card !border-none mb-[10px] table-search-wrap" shadow="never">
                <div class="flex justify-between">
                    <el-form :inline="true" :model="cronTableData.searchParam" ref="searchFormRef">
                        <el-form-item :label="t('name')" prop="key">
                            <el-select v-model="cronTableData.searchParam.key" placeholder="全部" filterable remote clearable>
                                <el-option label="全部" value="all" />
                                <el-option v-for="item in templateList" :key="item.key" :label="item.name" :value="item.key" />
                            </el-select>
                        </el-form-item>
                        <el-form-item :label="t('status')" prop="status">
                            <el-select v-model="cronTableData.searchParam.status" placeholder="全部" filterable remote clearable>
                                <el-option label="全部" value="all" />
                                <el-option label="成功" value="success" />
                                <el-option label="失败" value="error" />
                            </el-select>
                        </el-form-item>
                        <el-form-item :label="t('executeTime')" prop="execute_time">
                            <el-date-picker v-model="cronTableData.searchParam.execute_time" type="datetimerange" value-format="YYYY-MM-DD HH:mm:ss" :start-placeholder="t('startDate')" :end-placeholder="t('endDate')" />
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="loadCronLogList()">{{ t('search') }}</el-button>
                            <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </el-card>

            <div class="mt-[20px]">
                <el-table :data="cronTableData.data" size="large" v-loading="cronTableData.loading">
                    <template #empty>
                        <span>{{ !cronTableData.loading ? t('emptyData') : '' }}</span>
                    </template>
                    <el-table-column prop="id" :label="t('id')" min-width="80" />
                    <el-table-column prop="name" :label="t('name')" min-width="150" />
                    <el-table-column prop="key" :label="t('key')" min-width="150" />
                    <el-table-column prop="class" :label="t('class')" min-width="150" />
                    <el-table-column :label="t('executeResult')" min-width="150">
                        <template #default="{ row }">
                            {{ row.execute_result }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="status_name" :label="t('status')" min-width="100" />
                    <el-table-column prop="execute_time" :label="t('executeTime')" min-width="100" />
                    <el-table-column :label="t('operation')" align="right" fixed="right" width="130">
                        <template #default="{ row }">
                            <el-button type="primary" link @click="infoEvent(row)">{{ t('info') }}</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <div class="mt-[16px] flex justify-end">
                    <el-pagination v-model:current-page="cronTableData.page" v-model:page-size="cronTableData.limit"
                        layout="total, sizes, prev, pager, next, jumper" :total="cronTableData.total"
                        @size-change="loadCronLogList()" @current-change="loadCronLogList" />
                </div>
            </div>
        </el-card>

        <el-dialog v-model="showDialog" :title="t('cronInfo')" width="550px" :destroy-on-close="true">
            <el-form :model="formData" label-width="110px" ref="formRef" class="page-form" v-loading="loading">

                <el-form-item :label="t('name')" >
                    <div class="input-width"> {{ formData.name }} </div>
                </el-form-item>

                <el-form-item :label="t('key')" >
                    <div class="input-width"> {{ formData.key }} </div>
                </el-form-item>

                <el-form-item :label="t('class')" >
                    <div class="input-width"> {{ formData.class }} </div>
                </el-form-item>

                <el-form-item :label="t('executeResult')" >
                    <div class="input-width"> {{ formData.execute_result }} </div>
                </el-form-item>

                <el-form-item :label="t('status')" >
                    <div class="input-width"> {{ formData.status_name }} </div>
                </el-form-item>

                <el-form-item :label="t('executeTime')" >
                    <div class="input-width"> {{ formData.execute_time }} </div>
                </el-form-item>

            </el-form>

            <template #footer>
            <span class="dialog-footer">
                <el-button type="primary" @click="showDialog = false">{{ t('confirm') }}</el-button>
            </span>
            </template>
        </el-dialog>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, computed } from 'vue'
import { t } from '@/lang'
import { getCronLogList, getCronTemplate } from '@/app/api/sys'
import { ElMessageBox, FormInstance } from 'element-plus'
import { useRouter, useRoute } from 'vue-router'

const route = useRoute()
const pageName = route.meta.title

const cronTableData = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    searchParam: {
        schedule_id: route.query.id,
        key: '',
        status: 'all',
        execute_time: []
    }
})
const templateList = ref([])
const searchFormRef = ref<FormInstance>()

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    loadCronLogList()
}

const setTypeList = async () => {
    templateList.value = await (await getCronTemplate()).data
}
setTypeList()

/**
 * 获取日志列表
 */
const loadCronLogList = (page: number = 1) => {
    cronTableData.loading = true
    cronTableData.page = page

    getCronLogList({
        page: cronTableData.page,
        limit: cronTableData.limit,
        ...cronTableData.searchParam
    }).then(res => {
        cronTableData.loading = false
        cronTableData.data = res.data.data
        cronTableData.total = res.data.total
    }).catch(() => {
        cronTableData.loading = false
    })
}
loadCronLogList()

const showDialog = ref(false)
const loading = ref(true)
/**
 * 表单数据
 */
 const initialFormData = {
    id: '',
    name: '',
    key: '',
    execute_result: '',
    status_name: '',
    class: '',
    job: '',
    execute_time: ''
}
const formData: Record<string, any> = reactive({ ...initialFormData })

/**
 * 查看日志详情
 * @param row
 */
const infoEvent = (row: any) => {
    loading.value = true
    Object.assign(formData, initialFormData)

    if (row) {
        Object.keys(formData).forEach((key: string) => {
            if (row[key] != undefined) formData[key] = row[key]
        })
    }

    loading.value = false
    showDialog.value = true
}

</script>

<style lang="scss" scoped></style>
