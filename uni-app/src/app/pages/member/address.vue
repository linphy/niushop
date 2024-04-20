<template>
    <view v-if="!loading" :style="themeColor()">
        <view class="border-0 !border-b !border-[#eee] border-solid fixed top-0 left-0 right-0 z-99 bg-[#fff]" v-if="!source">
            <u-tabs :list="tabs" @click="switchTab" :current="current" itemStyle="width:50%;height:88rpx;box-sizing: border-box;"></u-tabs>
        </view>
        <scroll-view scroll-y="true" :class="{ 'pt-[88rpx]' : !source }" >
            <u-swipe-action>
                <view class="p-[30rpx]" v-show="current == 0">
                    <u-swipe-action-item :options="addressOptions" @click="swipeClick" v-for="item in addressList">
                        <view class="border-0 !border-b !border-[#f5f5f5] border-solid pb-[30rpx] flex items-center">
                            <view class="flex-1 line-feed" @click="selectAddress(item)">
                                <view class="font-bold my-[10rpx] text-sm line-feed">{{ item.full_address }}</view>
                                <view class="text-sm flex items-center">
                                    <view>{{ item.name }}</view>
                                    <text class="text-[26rpx] text-gray-subtitle">{{ mobileHide(item.mobile) }}</text>
                                    <view class="bg-primary text-white text-xs px-[10rpx] leading-none flex items-center h-[32rpx] ml-[10rpx] rounded  min-w-[50rpx]" v-if="item.is_default == 1">{{ t('default') }}</view>
                                </view>
                            </view>
                            <text class="iconfont iconbianji shrink-0 text-[40rpx] p-[20rpx] pr-0" @click="editAddress(item.id)"></text>
                        </view>
                    </u-swipe-action-item>
                    <view v-if="!addressList.length" class="pt-[20vh]">
                        <mescroll-empty :option="{tip : '暂无收货地址'}"></mescroll-empty>
                    </view>
                </view>
                <view class="p-[30rpx]" v-show="current == 1">
                    <u-swipe-action-item :options="addressOptions" @click="swipeClick" v-for="item in locationAddressList">
                        <view class="border-0 !border-b !border-[#f5f5f5] border-solid pb-[30rpx] flex items-center">
                            <view class="flex-1" @click="selectAddress(item)">
                                <view class="font-bold my-[10rpx] text-sm line-feed">{{ item.full_address }}</view>
                                <view class="text-sm flex items-center">
                                    <view>{{ item.name }}</view>
                                    <text class="text-[26rpx] text-gray-subtitle">{{ mobileHide(item.mobile) }}</text>
                                    <view class="bg-primary text-white text-xs px-[10rpx] leading-none flex items-center h-[32rpx] ml-[10rpx] rounded min-w-[50rpx]" v-if="item.is_default == 1">{{ t('default') }}</view>
                                </view>
                            </view>
                            <text class="iconfont iconbianji shrink-0 text-[40rpx] p-[20rpx] pr-0" @click="editAddress(item.id)"></text>
                        </view>
                    </u-swipe-action-item>
                    <view v-if="!locationAddressList.length" class="pt-[20vh]">
                        <mescroll-empty :option="{tip : '暂无收货地址'}"></mescroll-empty>
                    </view>
                </view>
            </u-swipe-action>
            <u-tabbar :fixed="true" :safeAreaInsetBottom="true" :border="false" zIndex="99">
                <view class="p-[24rpx] pt-0 w-full">
                    <u-button type="primary" shape="circle" :text="t('createAddress')" @click="addAddress"></u-button>
                </view>
            </u-tabbar>
        </scroll-view>
    </view>
</template>

<script setup lang="ts">
    import { ref, reactive, computed, watch } from 'vue'
    import { onLoad } from '@dcloudio/uni-app'
    import { redirect, img, mobileHide } from '@/utils/common'
    import { getAddressList, deleteAddress } from '@/app/api/member'
    import { t } from '@/locale'
    import MescrollEmpty from '@/components/mescroll/mescroll-empty/mescroll-empty.vue';

    const loading = ref(true)
    const current = ref(0)
    const tabs = ref([
        { name: '快递地址', key: 'address' },
        { name: '同城配送地址', key: 'location_address' }
    ])
    const addressList = ref<object[]>([])
    const locationAddressList = ref<object[]>([])
    const type = ref('')
    const source = ref('')

    onLoad((data) => {
        type.value = data.type || ''
        source.value = data.source || ''
        if (data.type) current.value = data.type == 'address' ? 0 : 1
    })

    getAddressList({}).then(({ data }) => {
        const address = [], locationAddress = []
        data.forEach(item => {
            item.type == 'address' ? address.push(item) : locationAddress.push(item)
        })
        addressList.value = address
        locationAddressList.value = locationAddress
        loading.value = false
    }).catch(() => {
        loading.value = false
    })

    const switchTab = (event)=> {
        current.value = event.index
    }

    const addAddress = ()=> {
        const url = `/app/pages/member/${tabs.value[ current.value ].key}_edit`
        redirect({ url, param: { type: tabs.value[ current.value ].key, source : source.value } })
    }

    const editAddress = (id: number)=> {
        const url = `/app/pages/member/${tabs.value[ current.value ].key}_edit`
        redirect({ url, param: { id, type: tabs.value[ current.value ].key, source : source.value} })
    }

    const addressOptions = ref([
        {
            text: t('delete'),
            style: {
                backgroundColor: '#F56C6C'
            }
        }
    ])

    const selectAddress = (data: object) => {
        const selectAddress = uni.getStorageSync('selectAddressCallback')
        if (selectAddress) {
            selectAddress.address_id = data.id

            uni.setStorage({
                key: 'selectAddressCallback',
                data: selectAddress,
                success() {
                    redirect({url: selectAddress.back, mode: 'redirectTo'})
                }
            })
        }
    }

    const swipeClick = (event: any) => {
        const list = current.value ? locationAddressList : addressList
        const data = list.value[event.index]

        deleteAddress(data.id).then(() => {
            list.value.splice(event.index, 1)
        }).catch()
    }
</script>

<style lang="scss" scoped>
    :deep(.u-tabs__wrapper__nav__line) {
        bottom: 0;
        background: var(--primary-color) !important;
    }
    .line-feed{
        word-wrap:break-word;
        word-break: break-all;
    }
</style>
