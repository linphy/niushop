<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">

            <div class="flex justify-between items-center">
                <span class="text-page-title">{{ pageName }}</span>
                <el-button type="primary" @click="addEvent">
                    {{ t('addEvaluate') }}
                </el-button>
            </div>

            <el-card class="box-card !border-none my-[10px] table-search-wrap" shadow="never">
                <el-form :inline="true" :model="evaluateTable.searchParam" ref="searchFormRef">
                    <el-form-item :label="t('goodsName')" prop="goods_name">
                        <el-input v-model.trim="evaluateTable.searchParam.goods_name" :placeholder="t('goodsNamePlaceholder')" class="input-width" maxlength="60" />
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="loadEvaluateList()">{{ t('search') }}</el-button>
                        <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
            </el-card>

            <div class="mt-[10px]">
                <el-table :data="evaluateTable.data" size="large" v-loading="evaluateTable.loading">
                    <template #empty>
                        <span>{{ !evaluateTable.loading ? t('emptyData') : '' }}</span>
                    </template>
                    <el-table-column :label="t('goodsInfo')" min-width="120" align="left">
                        <template #default="{ row }">
                            <div class="flex cursor-pointer">
                                <div class="flex items-center min-w-[50px] mr-[10px]">
                                    <el-image v-if="row.goods.goods_cover_thumb_small" class="w-[50px] h-[50px]" :src="img(row.goods.goods_cover_thumb_small)" fit="contain">
                                        <template #error>
                                            <div class="image-slot">
                                                <img class="w-[50px] h-[50px]" src="@/addon/shop/assets/goods_default.png" />
                                            </div>
                                        </template>
                                    </el-image>

                                    <img v-else class="w-[50px] h-[50px]" src="@/addon/shop/assets/goods_default.png" fit="contain" />
                                </div>
                                <div class="flex">
                                    <p class="multi-hidden">{{ row.goods.goods_name }}</p>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('content')" min-width="240" align="left">
                        <template #default="{ row }">
                            <div>
                                <p class="text-[14px]">{{ row.content }}</p>
                                <div class="flex flex-wrap mt-[10px]" v-if="row.images?.length > 0">
                                    <div v-for="(imageItem, imageIndex) in row.images" :key="imageIndex" class="mr-4">
                                        <el-image v-if="imageItem" class="w-[40px] h-[40px]" :src="img(imageItem)" fit="contain" :preview-src-list="[img(imageItem)]" :zoom-rate="1.2" :max-scale="7" :min-scale="0.2">
                                            <template #error>
                                                <div class="image-slot">
                                                    <img class="w-[40px] h-[40px]" src="@/addon/shop/assets/goods_default.png" />
                                                </div>
                                            </template>
                                        </el-image>
                                        <img v-else class="w-[40px] h-[40px]" src="@/addon/shop/assets/goods_default.png" />
                                    </div>
                                </div>
                                <p class="mt-[15px] text-[14px]" v-if="row.explain_first"><span class="text-[#ff7f5b]">{{ t('explainFirst') }}：</span>{{ row.explain_first }}</p>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('scores')" min-width="110" align="left">
                        <template #default="{ row }">
                            <el-rate v-model="row.scores" disabled />
                        </template>
                    </el-table-column>
                    <el-table-column prop="audit_name" :label="t('auditName')" min-width="80" />
                    <el-table-column prop="create_time" :label="t('createTime')" min-width="120" />
                    <el-table-column :label="t('operation')" fixed="right" min-width="100" align="right">
                        <template #default="{ row }">
                            <div>
                                <el-button type="primary" link @click="adoptEvent(row.evaluate_id)" v-if="row.is_audit == 1">{{ t('adopt') }}</el-button>
                                <el-button type="primary" link @click="refuseEvent(row.evaluate_id)" v-if="row.is_audit == 1">{{ t('refuse') }}</el-button>
                                <el-button type="primary" link @click="replyEvent(row.evaluate_id)" v-if="row.explain_first == ''">{{ t('reply') }}</el-button>
                                <el-button type="primary" link @click="deleteEvent(row.evaluate_id)">{{ t('delete') }}</el-button>
                                <el-button type="primary" link @click="toppingEvent(row.evaluate_id, 'topping')" v-if="row.is_audit == 2 && row.topping == 0">{{ t('topping') }}</el-button>
                                <el-button type="primary" link @click="toppingEvent(row.evaluate_id, 'cancel_topping')" v-if="row.topping == 1">{{ t('cancelTopping') }}</el-button>
                            </div>
                        </template>
                    </el-table-column>

                </el-table>
                <div class="mt-[16px] flex justify-end">
                    <el-pagination v-model:current-page="evaluateTable.page" v-model:page-size="evaluateTable.limit"
                        layout="total, sizes, prev, pager, next, jumper" :total="evaluateTable.total"
                        @size-change="loadEvaluateList()" @current-change="loadEvaluateList" />
                </div>
            </div>
        </el-card>

        <evaluate-add ref="editEvaluateDialog" @complete="loadEvaluateList" />

        <el-dialog v-model="replyShowDialog" :title="t('explainFirst')" width="460px" class="diy-dialog-wrap" :destroy-on-close="true">
            <el-form :model="formData" label-width="90px" ref="formRef" :rules="formRules" class="page-form">
                <el-form-item :label="t('explainFirst')" prop="explain_first">
                    <el-input v-model.trim="formData.explain_first" type="textarea" rows="4" clearable
                        :placeholder="t('explainFirstPlaceholder')" class="input-width" maxlength="200" show-word-limit />
                </el-form-item>
            </el-form>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="replyShowDialog = false">{{ t('cancel') }}</el-button>
                    <el-button type="primary" @click="confirm(formRef)">{{ t('confirm') }}</el-button>
                </span>
            </template>
        </el-dialog>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, computed } from 'vue'
import { t } from '@/lang'
import { getEvaluateList, deleteEvaluate, adoptEvaluate, refuseEvaluate, replyEvaluate, toppingEvaluate, cancelToppingEvaluate } from '@/addon/shop/api/goods'
import EvaluateAdd from '@/addon/shop/views/goods/components/evaluate-add.vue'
import { img } from '@/utils/common'
import { ElMessageBox, FormInstance } from 'element-plus'
import { useRoute } from 'vue-router'

const route = useRoute()
const pageName = route.meta.title

const evaluateTable = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    searchParam: {
        goods_name: ''
    }
})

const searchFormRef = ref<FormInstance>()

/**
 * 获取商品评价列表
 */
const loadEvaluateList = (page: number = 1) => {
    evaluateTable.loading = true
    evaluateTable.page = page

    getEvaluateList({
        page: evaluateTable.page,
        limit: evaluateTable.limit,
        ...evaluateTable.searchParam
    }).then(res => {
        evaluateTable.loading = false
        evaluateTable.data = res.data.data
        evaluateTable.total = res.data.total
        evaluateTable.data.map((item: any)=> {
            item.previewList = item.images.map((el:any)=> {
                return img(el)
            })
            return item
        })
    }).catch(() => {
        evaluateTable.loading = false
    })
}
loadEvaluateList()

const editEvaluateDialog: Record<string, any> | null = ref(null)
/**
 * 添加商品评价
 */
const addEvent = () => {
    editEvaluateDialog.value.setFormData()
    editEvaluateDialog.value.showDialog = true
}

/**
 * 删除商品评价
 */
const deleteEvent = (id: number) => {
    ElMessageBox.confirm(t('evaluateDeleteTips'), t('warning'),
        {
            confirmButtonText: t('confirm'),
            cancelButtonText: t('cancel'),
            type: 'warning'
        }
    ).then(() => {
        deleteEvaluate(id).then(() => {
            loadEvaluateList()
        }).catch(() => {
        })
    })
}

// 审核通过
const adoptEvent = (id: number) => {
    ElMessageBox.confirm(t('auditAdoptTips'), t('warning'),
        {
            confirmButtonText: t('confirm'),
            cancelButtonText: t('cancel'),
            type: 'warning'
        }
    ).then(() => {
        adoptEvaluate(id).then(() => {
            loadEvaluateList()
        }).catch(() => {
        })
    })
}

// 审核拒绝
const refuseEvent = (id: number) => {
    refuseEvaluate(id).then(() => {
        loadEvaluateList()
    })
}

// 置顶、取消置顶
const toppingEvent = (id: number, event:string) => {
    if (event == 'topping') {
        toppingEvaluate(id).then(() => {
            loadEvaluateList()
        })
    } else {
        cancelToppingEvaluate(id).then(() => {
            loadEvaluateList()
        })
    }
}

// 评价回复
const replyShowDialog = ref(false)
const initialFormData = {
    evaluate_id: 0,
    explain_first: ''
}
const formData: Record<string, any> = reactive({ ...initialFormData })
const formRef = ref<FormInstance>()
const replyEvent = (id: number) => {
    formData.evaluate_id = id
    formData.explain_first = ''
    replyShowDialog.value = true
}
const formRules = computed(() => {
    return {
        explain_first: [
            { required: true, message: t('explainFirstPlaceholder'), trigger: 'blur' }
        ]
    }
})
const confirm = async (formEl: FormInstance | undefined) => {
    if (!formEl) return
    await formEl.validate(async (valid) => {
        if (valid) {
            const data = formData
            replyEvaluate(data).then(res => {
                loadEvaluateList()
                replyShowDialog.value = false
            }).catch(err => {
                replyShowDialog.value = false
            })
        }
    })
}

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    loadEvaluateList()
}
</script>

<style lang="scss" scoped>
/* 多行超出隐藏 */
.multi-hidden {
    word-break: break-all;
    text-overflow: ellipsis;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}</style>
