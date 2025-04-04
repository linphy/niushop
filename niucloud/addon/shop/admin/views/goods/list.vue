<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">

            <div class="flex justify-between items-center">
                <span class="text-page-title">{{ pageName }}</span>
                <el-button type="primary" @click="addEvent">{{ t('addGoods') }}</el-button>
            </div>

            <el-card class="box-card !border-none my-[10px] table-search-wrap" shadow="never">
                <el-form :inline="true" :model="goodsTable.searchParam" ref="searchFormRef">
                    <el-form-item :label="t('goodsName')" prop="goods_name">
                        <el-input v-model.trim="goodsTable.searchParam.goods_name" :placeholder="t('goodsNamePlaceholder')" maxlength="60" />
                    </el-form-item>
                    <el-form-item :label="t('goodsCategory')" prop="goods_category">
                        <!-- <el-cascader v-model="goodsTable.searchParam.goods_category" :options="goodsCategoryOptions" :placeholder="t('goodsCategoryPlaceholder')" clearable :props="{ value: 'value', label: 'label', emitPath:false }"/> -->
                        <el-cascader v-model="goodsTable.searchParam.goods_category" ref="cascader" :options="goodsCategoryOptions"  :placeholder="t('goodsCategoryPlaceholder')" clearable :props="goodsCategoryProps"/>
                    </el-form-item>
                    <el-form-item :label="t('goodsType')" prop="goods_type">
                        <el-select v-model="goodsTable.searchParam.goods_type" :placeholder="t('goodsTypePlaceholder')" clearable>
                            <el-option v-for="item in goodsType" :key="item.type" :label="item.name" :value="item.type" />
                        </el-select>
                    </el-form-item>

                    <el-form-item :label="t('brand')" prop="brand_id">
                        <el-select v-model="goodsTable.searchParam.brand_id" :placeholder="t('brandPlaceholder')" clearable>
                            <el-option v-for="item in brandOptions" :key="item.brand_id" :label="item.brand_name" :value="item.brand_id" />
                        </el-select>
                    </el-form-item>
                    <el-form-item :label="t('labelIds')" prop="label_ids">
                        <el-select v-model="goodsTable.searchParam.label_ids" :placeholder="t('labelIdsPlaceholder')" clearable>
                            <el-option v-for="item in labelOptions" :key="item.label_id" :label="item.label_name" :value="item.label_id" />
                        </el-select>
                    </el-form-item>
                    <el-form-item :label="t('saleNum')" prop="sale_num">
                        <div class="region-input">
                            <input type="text" :placeholder="t('startSaleNumPlaceholder')" maxlength="10" v-model.trim="goodsTable.searchParam.start_sale_num" @keyup="filterDigit($event)">
                            <span class="separator">-</span>
                            <input type="text" :placeholder="t('endSaleNumPlaceholder')" maxlength="10" v-model.trim="goodsTable.searchParam.end_sale_num" @keyup="filterDigit($event)">
                        </div>
                    </el-form-item>
                    <el-form-item :label="t('skuPrice')" prop="sku_price">
                        <div class="region-input">
                            <input type="text" :placeholder="t('startPricePlaceholder')" maxlength="10" v-model.trim="goodsTable.searchParam.start_price" @keyup="filterDigit($event)">
                            <span class="separator">-</span>
                            <input type="text" :placeholder="t('endPricePlaceholder')" maxlength="10" v-model.trim="goodsTable.searchParam.end_price" @keyup="filterDigit($event)">
                        </div>
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="loadGoodsList()">{{ t('search') }}</el-button>
                        <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
            </el-card>

            <div class="mt-[10px]">

                <el-tabs v-model="goodsTable.searchParam.status" class="goods-tabs" @tab-click="tabHandleClick">
                    <el-tab-pane :label="t('statusOn')" name="1"></el-tab-pane>
                    <el-tab-pane :label="t('statusOff')" name="0"></el-tab-pane>
                    <el-tab-pane :label="t('statusAll')" name=""></el-tab-pane>
                </el-tabs>

                <div class="mb-[10px] flex items-center">
                    <el-checkbox v-model="toggleCheckbox" size="large" class="px-[14px]" @change="toggleChange" :indeterminate="isIndeterminate" />
                    <el-button @click="batchGoodsStatus(1)" size="small" v-if="goodsTable.searchParam.status != '1'">{{ t('batchOnGoods') }}</el-button>
                    <el-button @click="batchGoodsStatus(0)" size="small" v-if="goodsTable.searchParam.status != '0'">{{ t('batchOffGoods') }}</el-button>
                    <el-button @click="batchDeleteGoods" size="small">{{ t('batchDeleteGoods') }}</el-button>
                    <el-button @click="batchSetGoods" size="small">{{ t('batchSetting') }}</el-button>
                </div>

                <el-table :data="goodsTable.data" size="large" v-loading="goodsTable.loading" ref="goodsListTableRef" @sort-change="sortChange" @selection-change="handleSelectionChange">
                    <template #empty>
                        <span>{{ !goodsTable.loading ? t('emptyData') : '' }}</span>
                    </template>
                    <el-table-column type="selection" width="55" />

                    <el-table-column prop="goods_id" :label="t('goodsInfo')" min-width="300">
                        <template #default="{ row }">
                            <div class="flex items-center cursor-pointer" @click="previewEvent(row)">
                                <div class="min-w-[70px] h-[70px] flex items-center justify-center">
                                    <el-image v-if="row.goods_cover_thumb_small" class="w-[70px] h-[70px]" :src="img(row.goods_cover_thumb_small)" fit="contain">
                                        <template #error>
                                            <div class="image-slot">
                                                <img class="w-[70px] h-[70px]" src="@/addon/shop/assets/goods_default.png" />
                                            </div>
                                        </template>
                                    </el-image>
                                    <img v-else class="w-[70px] h-[70px]" src="@/addon/shop/assets/goods_default.png" fit="contain" />
                                </div>
                                <div class="ml-2  flex flex-col items-start">
                                    <span :title="row.goods_name" class="multi-hidden">{{ row.goods_name }}</span>
                                    <span class="text-primary text-[12px]">{{ row.goods_type_name }}</span>
                                    <span class="px-[4px]  text-[12px] text-[#fff] rounded-[4px] bg-primary leading-[18px]" v-if="row.is_gift == 1">赠品</span>
                                </div>
                            </div>
                        </template>
                    </el-table-column>

                    <el-table-column prop="price" :label="t('skuPrice')" min-width="120" align="right" sortable="custom">
                        <template #default="{ row }">
                            <div class="cursor-pointer price-wrap" @click="editPriceEvent(row)">
                                <span>￥{{ row.goodsSku.price }}</span>
                                <el-icon class="icon-wrap ml-[5px] invisible">
                                    <EditPen />
                                </el-icon>
                            </div>
                        </template>
                    </el-table-column>

                    <el-table-column prop="stock" :label="t('stock')" min-width="120" sortable="custom">
                        <template #default="{ row }">
                            <div class="cursor-pointer stock-wrap" @click="editStockEvent(row)">
                                <span>{{ row.stock }}</span>
                                <el-icon class="icon-wrap ml-[5px] invisible">
                                    <EditPen />
                                </el-icon>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column prop="sale_num" :label="t('saleNum')" min-width="100" sortable="custom" />
                    <el-table-column prop="status" :label="t('status')" min-width="100">
                        <template #default="{ row }">
                            <div v-if="row.status == 1">{{ t('statusOn') }}</div>
                            <div v-if="row.status == 0">{{ t('statusOff') }}</div>
                        </template>
                    </el-table-column>
                    <el-table-column prop="sort" :label="t('sort')" min-width="120" sortable="custom">
                        <template #default="{ row }">
                            <el-input v-model.trim="row.sort" class="w-[70px]" maxlength="8" @blur="sortInputListener(row.sort, row)" />
                        </template>
                    </el-table-column>

                    <el-table-column prop="create_time" :label="t('createTime')" min-width="150" sortable="custom">
                        <template #default="{ row }">
                            <div>{{ row.create_time }}</div>
                        </template>
                    </el-table-column>

                    <el-table-column :label="t('operation')" fixed="right" align="right" min-width="120">
                        <template #default="{ row }">
                            <el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
                            <el-button type="primary" link @click="spreadEvent(row)">{{ t('spreadGoods') }}</el-button>
                            <el-button type="primary" link @click="memberPriceEvent(row)">{{ t('memberPrice') }}</el-button>
                            <el-button type="primary" v-if="row.status == 1" link @click="statusChange(row, 0)">{{ t('statusActionOff') }}</el-button>
                            <el-button type="primary" v-else link @click="statusChange(row, 1)">{{ t('statusActionOn') }}</el-button>
                            <el-button type="primary" link @click="copyEvent(row)">{{ t('copyGoods') }}</el-button>
                            <el-button type="primary" v-if="row.status != 1" link @click="deleteEvent(row.goods_id)">{{ t('delete') }}</el-button>
                        </template>
                    </el-table-column>

                </el-table>
                <div class="mt-[16px] flex justify-end">
                    <!-- <div class="flex items-center flex-1">
                        <el-checkbox v-model="toggleCheckbox" size="large" class="px-[14px]" @change="toggleChange" :indeterminate="isIndeterminate" />
                        <el-button @click="batchGoodsStatus(1)" size="small">{{ t('batchOnGoods') }}</el-button>
                        <el-button @click="batchGoodsStatus(0)" size="small">{{ t('batchOffGoods') }}</el-button>
                        <el-button @click="batchDeleteGoods" size="small">{{ t('batchDeleteGoods') }}</el-button>
                    </div> -->

                    <el-pagination v-model:current-page="goodsTable.page" v-model:page-size="goodsTable.limit"
                        layout="total, sizes, prev, pager, next, jumper" :total="goodsTable.total"
                        @size-change="loadGoodsList()" @current-change="loadGoodsList" />
                </div>

            </div>

        </el-card>

        <!-- 商品库存编辑弹出框 -->
        <goods-stock-edit-popup ref="goodsStockEditPopupRef" @load="loadGoodsList" />

        <!-- 商品价格编辑弹出框 -->
        <goods-price-edit-popup ref="goodsPriceEditPopupRef" @load="loadGoodsList" />

        <!-- 商品推广弹出框 -->
        <goods-spread-popup ref="goodsSpreadPopupRef" />

        <!-- 会员价弹出框 -->
        <goods-member-price-popup ref="memberPricePopupRef" @load="loadGoodsList" />

        <!-- 批量设置弹出框 -->
        <goods-batch-settings-popup ref="goodsBatchSettingPopupRef" @load="loadGoodsList" />
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { debounce, img, filterDigit, setTablePageStorage, getTablePageStorage } from '@/utils/common'
import { ElMessage, ElMessageBox, FormInstance } from 'element-plus'
import { useRoute, useRouter } from 'vue-router'
import { cloneDeep, multiply } from 'lodash-es'
import goodsMemberPricePopup from '@/addon/shop/views/goods/components/goods-member-price-popup.vue'
import goodsStockEditPopup from '@/addon/shop/views/goods/components/goods-stock-edit-popup.vue'
import goodsPriceEditPopup from '@/addon/shop/views/goods/components/goods-price-edit-popup.vue'
import goodsSpreadPopup from '@/addon/shop/views/goods/components/goods-spread-popup.vue'
import goodsBatchSettingsPopup from '@/addon/shop/views/goods/components/goods-batch-settings-popup.vue'
import { getGoodsPageList, getCategoryTree, getGoodsType, getBrandList, getLabelList, editGoodsSort, editGoodsStatus, copyGoods, deleteGoods } from '@/addon/shop/api/goods'
import { getMemberLevelAll } from '@/app/api/member'

const router = useRouter()
const route = useRoute()
const pageName = route.meta.title
const repeat = ref(false)

const goodsTable = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    searchParam: {
        goods_name: '',
        goods_category: [],
        goods_type: '',
        brand_id: '',
        label_ids: '',
        start_sale_num: '',
        end_sale_num: '',
        start_price: '',
        end_price: '',
        status: route.query.status || '1',
        order: '',
        sort: ''
    }
})

const searchFormRef = ref<FormInstance>()

// 正则表达式
const regExp = {
    number: /^\d{0,10}$/,
    digit: /^\d{0,10}(.?\d{0,2})$/
}

// 商品分类
const goodsCategoryOptions: any = reactive([])
const goodsCategoryProps = {
    checkStrictly: true,
    emitPath: false
}
// 商品类型
const goodsType: any = reactive([])

// 品牌列表下拉框
const brandOptions: any = reactive([])

// 标签组列表下拉框
const labelOptions: any = reactive([])

// 初始化数据
const initData = () => {
    // 查询商品分类树结构
    getCategoryTree().then((res) => {
        const data = res.data
        if (data) {
            const goodsCategoryTree: any = []
            // 增加全部筛选选择
            goodsCategoryTree.push({
                value: '',
                label: '全部',
                children: []
            })
            data.forEach((item: any) => {
                const children: any = []
                if (item.child_list) {
                    children.push({
                        value: item.category_id,
                        label: '全部'
                    })
                    item.child_list.forEach((childItem: any) => {
                        children.push({
                            value: childItem.category_id,
                            label: childItem.category_name
                        })
                    })
                }
                goodsCategoryTree.push({
                    value: item.category_id,
                    label: item.category_name,
                    children
                })
            })
            goodsCategoryOptions.splice(0, goodsCategoryOptions.length, ...goodsCategoryTree)
        }
    })

    // 商品类型
    getGoodsType().then((res) => {
        const data = res.data
        if (data) {
            for (const k in data) {
                goodsType.push(data[k])
            }
        }
    })

    // 商品品牌
    getBrandList({}).then((res) => {
        const data = res.data
        if (data) {
            brandOptions.push(...data)
        }
    })

    // 商品标签
    getLabelList({}).then((res) => {
        const data = res.data
        if (data) {
            labelOptions.push(...data)
        }
    })
}

initData()

// 当前选中tab页面
const tabHandleClick = (tab: any, event: Event) => {
    goodsTable.searchParam.status = tab.props.name
    loadGoodsList()
}

// 批量复选框
const toggleCheckbox = ref()

// 复选框中间状态
const isIndeterminate = ref(false)

// 监听批量复选框事件
const toggleChange = (value: any) => {
    isIndeterminate.value = false
    goodsListTableRef.value.toggleAllSelection()
}

const goodsListTableRef = ref()

// 选中数据
const multipleSelection: any = ref([])

// 监听表格单行选中
const handleSelectionChange = (val: []) => {
    multipleSelection.value = val

    toggleCheckbox.value = false
    if (multipleSelection.value.length > 0 && multipleSelection.value.length < goodsTable.data.length) {
        isIndeterminate.value = true
    } else {
        isIndeterminate.value = false
    }

    if (multipleSelection.value.length == goodsTable.data.length && goodsTable.data.length && multipleSelection.value.length) {
        toggleCheckbox.value = true
    }
}

// 商品预览
const previewEvent = (data: any) => {
    const url = router.resolve({
        path: '/preview/wap',
        query: {
            page: `/addon/shop/pages/goods/detail?goods_id=${data.goods_id}`
        }
    })
    window.open(url.href)
}

// 监听排序
const sortChange = (event: any) => {
    let sort = ''
    if (event.order == 'ascending') {
        sort = 'asc'
    } else if (event.order == 'descending') {
        sort = 'desc'
    }
    if (sort) {
        goodsTable.searchParam.order = event.prop
        goodsTable.searchParam.sort = sort
    }
    loadGoodsList()
}

// 修改商品上下架状态
const statusChange = (row: any, value: any) => {
    if (value) {
        editGoodsStatus({
            goods_ids: row.goods_id,
            status: value
        }).then((res) => {
            loadGoodsList()
        })
    } else {
        ElMessageBox.confirm(t('statusChangeTips'), t('warning'),
            {
                confirmButtonText: t('confirm'),
                cancelButtonText: t('cancel'),
                type: 'warning'
            }
        ).then(() => {
            editGoodsStatus({
                goods_ids: row.goods_id,
                status: value
            }).then((res) => {
                loadGoodsList()
            })
        })
    }
}

// 批量设置上下架
const batchGoodsStatus = (status: any) => {
    if (multipleSelection.value.length == 0) {
        ElMessage({
            type: 'warning',
            message: `${t('batchEmptySelectedGoodsTips')}`
        })
        return
    }

    const goodsIds: any = []
    multipleSelection.value.forEach((item: any) => {
        goodsIds.push(item.goods_id)
    })

    editGoodsStatus({
        goods_ids: goodsIds,
        status
    }).then((res) => {
        loadGoodsList()
    })
}
/** ***************** 批量设置-start *************************/
const goodsBatchSettingPopupRef = ref()
const batchSetGoods = () => {
    if (multipleSelection.value.length == 0) {
        ElMessage({
            type: 'warning',
            message: `${t('batchEmptySelectedGoodsTips')}`
        })
        return
    }
    goodsBatchSettingPopupRef.value.show(multipleSelection.value)
}
/** ***************** 批量设置-end *************************/


const batchDeleteGoods = () => {
    if (multipleSelection.value.length == 0) {
        ElMessage({
            type: 'warning',
            message: `${t('batchEmptySelectedGoodsTips')}`
        })
        return
    }

    ElMessageBox.confirm(t('batchGoodsDeleteTips'), t('warning'),
        {
            confirmButtonText: t('confirm'),
            cancelButtonText: t('cancel'),
            type: 'warning'
        }
    ).then(() => {
        if (repeat.value) return
        repeat.value = true

        const goodsIds: any = []
        multipleSelection.value.forEach((item: any) => {
            goodsIds.push(item.goods_id)
        })

        deleteGoods({
            goods_ids: goodsIds
        }).then(() => {
            loadGoodsList()
            repeat.value = false
        }).catch(() => {
            repeat.value = false
        })
    })
}

// 修改排序号
const sortInputListener = debounce((sort, row) => {
    if (isNaN(sort) || !regExp.number.test(sort)) {
        ElMessage({
            type: 'warning',
            message: `${t('sortTips')}`
        })
        return
    }
    if(sort>99999999){
        row.sort = 99999999
    }
    editGoodsSort({
        goods_id: row.goods_id,
        sort
    }).then((res) => {
        // loadGoodsList();
    })
})

/**
 * 获取商品列表
 */
const loadGoodsList = (page: number = 1) => {
    if (goodsTable.searchParam.start_sale_num && !regExp.digit.test(goodsTable.searchParam.start_sale_num)) {
        ElMessage({
            type: 'warning',
            message: `${t('startSaleNumTips')}`
        })
        return
    }
    if (goodsTable.searchParam.end_sale_num && !regExp.digit.test(goodsTable.searchParam.end_sale_num)) {
        ElMessage({
            type: 'warning',
            message: `${t('endSaleNumTips')}`
        })
        return
    }
    if (Number(goodsTable.searchParam.start_sale_num) > Number(goodsTable.searchParam.end_sale_num)) {
        ElMessage({
            type: 'warning',
            message: `${t('shopSaleNumTips')}`
        })
        return
    }
    if (goodsTable.searchParam.start_price && !regExp.digit.test(goodsTable.searchParam.start_price)) {
        ElMessage({
            type: 'warning',
            message: `${t('startPriceTips')}`
        })
        return
    }
    if (goodsTable.searchParam.end_price && !regExp.digit.test(goodsTable.searchParam.end_price)) {
        ElMessage({
            type: 'warning',
            message: `${t('endPriceTips')}`
        })
        return
    }
    if (Number(goodsTable.searchParam.start_price) > Number(goodsTable.searchParam.end_price)) {
        ElMessage({
            type: 'warning',
            message: `${t('shopPriceTips')}`
        })
        return
    }
    goodsTable.loading = true
    goodsTable.page = page

    const searchData = cloneDeep(goodsTable.searchParam)

    getGoodsPageList({
        page: goodsTable.page,
        limit: goodsTable.limit,
        ...searchData
    }).then(res => {
        goodsTable.loading = false
        goodsTable.data = res.data.data
        goodsTable.total = res.data.total
        multipleSelection.value = []
        setTablePageStorage(goodsTable.page, goodsTable.limit, searchData)
    }).catch(() => {
        goodsTable.loading = false
    })
}

loadGoodsList(getTablePageStorage(goodsTable.searchParam).page)

/**
 * 添加商品
 */
const addEvent = () => {
    router.push('/shop/goods/real_edit')
    // let url = router.resolve({
    //     path: '/shop/goods/real_edit',
    // });
    // window.open(url.href);
}

/**
 * 编辑商品
 * @param data
 */
const editEvent = (data: any) => {
    router.push(data.goods_edit_path + '?goods_id=' + data.goods_id)
    // let url = router.resolve({
    //     path: data.goods_edit_path,
    //     query: {goods_id: data.goods_id}
    // });
    // window.open(url.href);
}

const goodsPriceEditPopupRef: any = ref(null)

// 编辑商品价格
const editPriceEvent = (data: any) => {
    goodsPriceEditPopupRef.value.show(data)
}

const goodsStockEditPopupRef: any = ref(null)

// 编辑商品库存
const editStockEvent = (data: any) => {
    goodsStockEditPopupRef.value.show(data)
}

// 商品推广
const goodsSpreadPopupRef: any = ref(null)

const spreadEvent = (data: any) => {
    goodsSpreadPopupRef.value.show(data)
}

/** ***************** 会员价-start *************************/
// 会员等级
const memberLevel = ref([])
const getMemberLevelAllFn = () => {
    getMemberLevelAll().then(res => {
        memberLevel.value = res.data ? res.data : []
    })
}
getMemberLevelAllFn()

const memberPricePopupRef: any = ref(null)
const memberPriceEvent = (data: any) => {
    memberPricePopupRef.value.show(data, memberLevel.value)
}
/** ***************** 会员价-end *************************/

// 复制商品
const copyEvent = (data: any) => {
    ElMessageBox.confirm(t('goodsCopyTips'), t('warning'),
        {
            confirmButtonText: t('confirm'),
            cancelButtonText: t('cancel'),
            type: 'warning'
        }
    ).then(() => {
        if (repeat.value) return
        repeat.value = true

        copyGoods({
            goods_id: data.goods_id
        }).then((res: any) => {
            if (res.code == 1) {
                loadGoodsList()
            }
            repeat.value = false
        }).catch(err => {
            repeat.value = false
        })
    })
}

// 删除商品
const deleteEvent = (id: number) => {
    ElMessageBox.confirm(t('goodsDeleteTips'), t('warning'),
        {
            confirmButtonText: t('confirm'),
            cancelButtonText: t('cancel'),
            type: 'warning'
        }
    ).then(() => {
        if (repeat.value) return
        repeat.value = true
        deleteGoods({
            goods_ids: id
        }).then(() => {
            loadGoodsList()
            repeat.value = false
        }).catch(() => {
            repeat.value = false
        })
    })
}

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    goodsTable.searchParam.start_price = ''
    goodsTable.searchParam.end_price = ''
    goodsTable.searchParam.start_sale_num = ''
    goodsTable.searchParam.end_sale_num = ''

    loadGoodsList()
}
</script>
<style lang="scss">
    .el-cascader-panel .el-radio{
        position:absolute;
        z-index:10;
        padding:0 10px;
        width:132px;
        height:34px;
        line-height:34px;
    }
    .el-cascader-panel .el-radio__input{
        visibility:hidden;
    }
    .el-cascader-panel .el-input-node__postfix{
        top:10px;
    }
</style>
<style lang="scss" scoped>
    .price-wrap, .stock-wrap {
        &:hover {
            .icon-wrap {
                visibility: visible;
                color: var(--el-color-primary);
            }
        }
    }
</style>
