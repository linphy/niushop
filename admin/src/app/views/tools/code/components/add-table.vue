<template>
    <el-dialog v-model="showDialog" :title="t('addCode')" width="800px" :destroy-on-close="true">
        <div>
            <el-table :data="filterTableData" size="large" v-loading="tableTableData.loading" height="400">

                <template #empty>
                    <span>{{ !tableTableData.loading ? t('emptyData') : '' }}</span>
                </template>

                <el-table-column prop="Name" :label="t('tableName')" min-width="150" />
                <el-table-column prop="Comment" :label="t('tableComment')" min-width="120" />

                <el-table-column align="right" min-width="150">
                    <template #header>
                        <el-input v-model.trim="search" size="small" :placeholder="t('searchPlaceholder')" />
                    </template>
                    <template #default="scope">
                        <el-button size="small" type="primary" @click="confirm(scope.row)">{{ t('addBtn') }}</el-button>
                    </template>
                </el-table-column>

            </el-table>
        </div>

    </el-dialog>
</template>

<script lang="ts" setup>
import { ref, reactive, computed } from 'vue'
import { t } from '@/lang'
import { addGenerateTable, generateTable } from '@/app/api/tools'
import { useRouter } from 'vue-router'

const router = useRouter()
const showDialog = ref(false)
const search = ref('')
const tableTableData = reactive({
    loading: true,
    data: [],
    searchParam: {
        table_name: '',
        table_content: ''
    }
})

const filterTableData = computed(() =>
    tableTableData.data.filter(
        (data:any) =>
            !search.value ||
            data.Name.toLowerCase().includes(search.value.toLowerCase()) || data.Comment.toLowerCase().includes(search.value.toLowerCase())
    )
)

/**
 * 获取代码生成列表
 */
const loadTableList = () => {
    tableTableData.loading = true

    generateTable().then(res => {
        tableTableData.loading = false
        tableTableData.data = res.data
    }).catch(() => {
        tableTableData.loading = false
    })
}
loadTableList()

/**
 * 确认
 * @param row
 */
const confirm = (row: any) => {
    const name: string = row.Name
    tableTableData.loading = true
    addGenerateTable({ 'table_name': name }).then(res => {
        tableTableData.loading = false
        showDialog.value = false
        router.push({ path: '/tools/code/edit', query: { id: res.data.id } })
    }).catch(() => {
        tableTableData.loading = false
    })
}

const setFormData = async (row: any = null) => {
    loadTableList()
}

defineExpose({
    showDialog,
    setFormData
})

</script>

<style lang="scss" scoped></style>
