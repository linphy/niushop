<template>
    <div class="main-container">
        <el-card class="card !border-none mb-[15px]" shadow="never">
            <el-page-header :content="id ? t('updateStore') : t('addStore')" :icon="ArrowLeft" @back="back" />
        </el-card>
        <el-card class="box-card !border-none" shadow="never" v-loading="loading">
            <el-form :model="formData" label-width="140px" ref="formRef" :rules="formRules" class="page-form">
                <el-form-item :label="t('storeName')" prop="store_name">
                    <el-input v-model.trim="formData.store_name" clearable :placeholder="t('storeNamePlaceholder')"
                              class="input-width" />
                </el-form-item>
                <el-form-item :label="t('storeDesc')">
                    <el-input v-model.trim="formData.store_desc" type="textarea" rows="4" clearable
                              :placeholder="t('storeDescPlaceholder')" class="input-width" />
                </el-form-item>
                <el-form-item :label="t('storeLogo')">
                    <upload-image v-model="formData.store_logo" />
                </el-form-item>
                <el-form-item :label="t('storeMobile')" prop="store_mobile">
                    <el-input v-model.trim="formData.store_mobile" clearable :placeholder="t('storeMobilePlaceholder')"
                              class="input-width" @keyup="filterNumber($event)"
                              @blur="formData.store_mobile = $event.target.value" />
                </el-form-item>
                <el-form-item :label="t('tradeTime')" prop="trade_time">
                    <div>
                        <el-input v-model.trim="formData.trade_time" clearable :placeholder="t('tradeTimePlaceholder')"
                                  class="input-width" />
                        <p class="text-[12px] text-[#999]">{{ t('tradeTimeTips') }}</p>
                    </div>
                </el-form-item>
                <el-form-item :label="t('storeAddress')" prop="address_area">
                    <el-select v-model="formData.province_id" value-key="id" clearable class="w-[200px]"  ref="provinceRef">
                        <el-option :label="t('provincePlaceholder')" :value="0"/>
                        <el-option v-for="(item, index) in areaList.province" :key="index" :label="item.name"  :value="item.id"/>
                    </el-select>
                    <el-select v-model="formData.city_id" value-key="id" clearable class="w-[200px] ml-3" ref="cityRef">
                        <el-option :label="t('cityPlaceholder')" :value="0"/>
                        <el-option v-for="(item, index) in areaList.city " :key="index" :label="item.name"  :value="item.id"/>
                    </el-select>
                    <el-select v-model="formData.district_id" value-key="id" clearable class="w-[200px] ml-3"  ref="districtRef">
                        <el-option :label="t('districtPlaceholder')" :value="0"/>
                        <el-option v-for="(item, index) in areaList.district " :key="index" :label="item.name"  :value="item.id"/>
                    </el-select>
                </el-form-item>
                <el-form-item prop="address">
                    <el-input v-model.trim="formData.address" clearable :placeholder="t('addressPlaceholder')"  class="input-width"/>
                </el-form-item>

                <el-form-item>
                    <div id="container" class="w-[800px] h-[520px] relative" v-loading="mapLoading"></div>
                </el-form-item>
            </el-form>
        </el-card>
        <div class="fixed-footer-wrap">
            <div class="fixed-footer !z-[9999]">
                <el-button type="primary" @click="onSave(formRef)">{{ t('save') }}</el-button>
                <el-button @click="back()">{{ t('cancel') }}</el-button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, reactive, computed, onMounted, watch } from 'vue'
import { t } from '@/lang'
import type { FormInstance } from 'element-plus'
import { getStoreInfo, addStore, editStore } from '@/addon/shop/api/delivery'
import { getMap, getAreaListByPid, getAreaByCode } from '@/app/api/sys'
import { useRoute } from 'vue-router'
import { createMarker, latLngToAddress, addressToLatLng } from '@/utils/qqmap'
import { filterNumber, debounce } from '@/utils/common'

const route = useRoute()
const id: number = parseInt(route.query.id as string)
const loading = ref(false)
const pageName = route.meta.title
interface areaType{
    province: any[],
    city: any[],
    district: any[]
}
const areaList = reactive<areaType>({
    province: [],
    city: [],
    district: []
})
const provinceRef = ref()
const cityRef = ref()
const districtRef = ref()

/**
 * 获取省
 */
getAreaListByPid(0).then(res => {
    areaList.province = res.data
})

let mapKey: string = ''
onMounted(() => {
    const mapScript = document.createElement('script')
    getMap().then(res => {
        mapKey = res.data.key
        mapScript.type = 'text/javascript'
        mapScript.src = 'https://map.qq.com/api/gljs?libraries=tools,service&v=1.exp&key=' + res.data.key
        document.body.appendChild(mapScript)
    })
    mapScript.onload = () => {
        setTimeout(() => {
            initMap()
        }, 500)
    }
})

/**
 * 初始化地图
 */
let map: any
let marker: any
const mapLoading = ref(true)
const initMap = () => {
    const TMap = (window as any).TMap
    const LatLng = TMap.LatLng
    const center = new LatLng(formData.latitude, formData.longitude)

    map = new TMap.Map('container', {
        center,
        zoom: 14
    })

    map.on('tilesloaded', () => {
        mapLoading.value = false
    })

    marker = createMarker(map)

    map.on('click', (evt: any) => {
        map.setCenter(evt.latLng)
        marker.updateGeometries({
            id: 'center',
            position: evt.latLng
        })
        latLngChange(evt.latLng.lat, evt.latLng.lng)
    })

    latLngChange(center.lat, center.lng)
}

const storeArea = reactive({
    province_id: 0,
    city_id: 0,
    district_id: 0
})

const latLngChange = (lat: number, lng: number) => {
    latLngToAddress({ mapKey, lat, lng }).then(({ message, result }) => {
        if (message == 'query ok' || message == 'Success') {
            formData.latitude = result.location.lat
            formData.longitude = result.location.lng
            formData.address = result.formatted_addresses.recommend

            getAreaByCode(result.ad_info.adcode).then(({ data }) => {
                storeArea.province_id = data.province ? data.province.id : 0
                storeArea.city_id = data.city ? data.city.id : 0
                storeArea.district_id = data.district ? data.district.id : 0
            })
        } else {
            console.error(message, result)
        }
    }).catch(err => {
        console.log(err)
    })
}

/**
 * 表单数据
 */
const initialFormData = {
    store_id: 0,
    store_name: '',
    store_desc: '',
    store_logo: '',
    store_mobile: '',
    province_id: 0,
    province_name: '',
    city_id: 0,
    city_name: '',
    district_id: 0,
    district_name: '',
    address: '',
    full_address: '',
    longitude: 116.397190,
    latitude: 39.908626,
    trade_time: ''
}

const formData: Record<string, any> = reactive({ ...initialFormData })

const setFormData = async (id: number = 0) => {
    loading.value = true
    Object.assign(formData, initialFormData)
    const data = await (await getStoreInfo(id)).data
    Object.keys(formData).forEach((key: string) => {
        if (data[key] != undefined) formData[key] = data[key]
    })
    loading.value = false
}
if (id) setFormData(id)

const formRef = ref<FormInstance>()

// 表单验证规则
const formRules = computed(() => {
    return {
        store_name: [
            { required: true, message: t('storeNamePlaceholder'), trigger: 'blur' }
        ],
        store_logo: [
            { required: true, message: t('storeLogoPlaceholder'), trigger: 'blur' }
        ],
        store_mobile: [
            { required: true, message: t('storeMobilePlaceholder'), trigger: 'blur' }
        ],
        trade_time: [
            { required: true, message: t('tradeTimePlaceholder'), trigger: 'blur' }
        ],
        address_area: [
            {
                validator: (rule: any, value: any, callback: any) => {
                    if (!formData.province_id) {
                        callback(new Error(t('provincePlaceholder')))
                    }
                    if (!formData.city_id) {
                        callback(new Error(t('cityPlaceholder')))
                    }
                    if (areaList.district.length && !formData.district_id) {
                        callback(new Error(t('districtPlaceholder')))
                    }
                    callback()
                }
            }
        ],
        address: [
            { required: true, message: t('addressPlaceholder'), trigger: 'blur' }
        ]
    }
})

/**
 * 获取市
 */
watch(() => formData.province_id, (nval) => {
    if (nval) {
        getAreaListByPid(formData.province_id).then(res => {
            areaList.city = res.data

            const cityId = formData.city_id
            if (cityId) {
                let isExist = false
                for (let i = 0; i < res.data.length; i++) {
                    if (cityId == res.data[i].id) {
                        isExist = true
                        break
                    }
                }
                if (isExist) {
                    formData.city_id = cityId
                    return
                }
            }
            formData.city_id = 0
            areaChange()
        })
    } else {
        formData.city_id = 0
    }
})

/**
 * 获取区
 */
watch(() => formData.city_id, (nval) => {
    if (nval) {
        getAreaListByPid(formData.city_id).then(res => {
            areaList.district = res.data

            const districtId = formData.district_id
            if (districtId) {
                let isExist = false
                for (let i = 0; i < res.data.length; i++) {
                    if (districtId == res.data[i].id) {
                        isExist = true
                        break
                    }
                }
                if (isExist) {
                    formData.district_id = districtId
                    return
                }
            }
            areaChange()
            formData.district_id = 0
        })
    } else {
        formData.district_id = 0
    }
})

watch(() => formData.district_id, (nval) => {
    if (nval) {
        areaChange()
    }
})

const areaChange = debounce(() => {
    setTimeout(() => {
        const address = [
            formData.province_id ? provinceRef.value.states.selectedLabel : '',
            formData.city_id ? cityRef.value.states.selectedLabel : '',
            formData.district_id ? districtRef.value.states.selectedLabel : ''
        ]

        addressToLatLng({ mapKey, address: address.join('') }).then(({ message, result }) => {
            if (message == 'Success' || message == 'query ok') {
                const latLng = new (window as any).TMap.LatLng(result.location.lat, result.location.lng)
                map.setCenter(latLng)
                marker.updateGeometries({
                    id: 'center',
                    position: latLng
                })
                formData.latitude = result.location.lat
                formData.longitude = result.location.lng
            } else {
                console.error(message, result)
            }
        })
    }, 500)
}, 500)

/**
 * 地图点选获取市
 */
watch(() => storeArea.province_id, (nval) => {
    if (nval) {
        getAreaListByPid(storeArea.province_id).then(res => {
            areaList.city = res.data
            formData.province_id = storeArea.province_id
            formData.city_id = storeArea.city_id
        })
    }
})

/**
 * 地图点选获取区
 */
watch(() => storeArea.city_id, (nval) => {
    if (nval) {
        getAreaListByPid(storeArea.city_id).then(res => {
            areaList.district = res.data
            formData.city_id = storeArea.city_id
            formData.district_id = storeArea.district_id
        })
    }
})

/**
 * 地图点选获取区
 */
watch(() => storeArea.district_id, (nval) => {
    if (nval) {
        formData.district_id = storeArea.district_id
    }
})

const onSave = async (formEl: FormInstance | undefined) => {
    if (loading.value || !formEl) return
    await formEl.validate(async (valid) => {
        if (valid) {
            loading.value = true

            const data = formData
            formData.province_name = formData.province_id ? provinceRef.value.states.selectedLabel : '',
                formData.city_name = formData.city_id ? cityRef.value.states.selectedLabel : '',
                formData.district_name = formData.district_id ? districtRef.value.states.selectedLabel : ''
            const address = [
                data.province_id ? provinceRef.value.states.selectedLabel : '',
                data.city_id ? cityRef.value.states.selectedLabel : '',
                data.district_id ? districtRef.value.states.selectedLabel : '',
                data.address
            ]
            data.full_address = address.join('')

            const save = id ? editStore : addStore
            save(data).then(res => {
                loading.value = false
                history.back()
            }).catch(() => {
                loading.value = false
            })
        }
    })
}

const back = () => {
    history.back()
}
</script>

<style lang="scss" scoped></style>
