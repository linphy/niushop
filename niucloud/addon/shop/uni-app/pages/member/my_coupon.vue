<template>
    <view class="bg-[#f8f8f8] min-h-screen overflow-hidden" :style="themeColor()" v-if="memberStore.info">
        <view class="fixed left-0 top-0 right-0 z-10">
            <scroll-view scroll-x="true" class="scroll-Y box-border px-[24rpx] bg-white">
                <view class="flex whitespace-nowrap justify-around">
                    <view :class="['text-[27rpx] leading-[90rpx]', { 'class-select': couponStatus === item.status }]" @click="statusClickFn(item.status)" v-for="(item, index) in statusList">{{ item.name }}</view>
                </view>
            </scroll-view>
        </view>

        <mescroll-body ref="mescrollRef" top="90rpx" @init="mescrollInit" @down="downCallback" @up="getMyCouponListFn">
            <view class="py-[20rpx] px-[24rpx]" v-if="list.length">
                <template v-for="(item, index) in list">

                    <view v-if="couponStatus != 1"
						class="flex items-center relative w-[100%] rounded-[20rpx] overflow-hidden bg-[#fff] py-[10rpx] background-size" :class="{'mt-[20rpx]':index}" :style="{ backgroundImage: couponStatus == 3 ?  ('url(' + img('addon/shop/coupon/coupn_expired.png') + ')') : 'none'  }">
						<view class="relative box-border flex-1 border-0 border-r-[1px] border-[#FFBDBD] border-dashed flex items-center">
							<view class="pl-[40rpx] w-[200rpx] box-border">
								<view class="price-font flex items-center text-[var(--primary-color)]">
									<text class="text-[38rpx] leading-[45rpx] text-center font-500">￥</text>
                                    <text class="text-[56rpx] font-semibold text-left leading-[70rpx] truncate">{{ item.coupon_price }}</text>
								</view>
							</view>
                            <view class="flex-1 box-border ml-[10rpx]">
                                <view class="text-[30rpx] leading-[35rpx] text-left font-500">
                                    <text v-if="item.min_condition_money === '0.00'">无门槛</text>
                                    <text v-else>满{{ item.coupon_min_price }}元可用</text>
                                </view>
                                <view class="text-[20rpx] leading-[23rpx] mt-[4rpx] text-left flex items-center">
                                    <text class="bg-[var(--primary-color)] text-[#fff] text-[20rpx] h-[28rpx] leading-[28rpx] px-[10rpx] text-center rounded-[16rpx] mr-[6rpx] shrink-0">{{ item.type_name }}</text>
                                    <text class="truncate max-w-[190rpx]">{{ item.title }}</text>
                                </view>
                                <view class="w-[100%] mt-[4rpx] mb-[11px] text-[20rpx] leading-[23rpx]">
                                    <text v-if="item.valid_type == 1">领取之日起{{ item.length || '' }}天内有效</text>
                                    <text v-else> 有效期至{{ item.expire_time ? item.expire_time.slice(0, 10) : '' }}</text>
                                </view>
                            </view>
						</view>
						<view class="pr-[20rpx] pl-[30rpx]">
                            <button class="w-[150rpx] h-[60rpx] text-[24rpx] !border-0 !bg-[#cccccc] rounded-full !text-[#fff] leading-[60rpx] remove-border" disabled v-if="couponStatus == 2">{{statusList[couponStatus-1].name}}</button>
                            <button class="w-[150rpx] h-[60rpx] text-[24rpx]  !bg-[#f6f6f6] !opacity-80 rounded-full !text-[#999] leading-[60rpx] border-[2rpx]  border-solid border-[#999]" disabled v-if="couponStatus == 3">{{statusList[couponStatus-1].name}}</button>
                        </view>
                        <view class="absolute top-0 right-[190rpx]  h-[10rpx] w-[20rpx] rounded-br-[20rpx] rounded-bl-[20rpx] bg-[#F6F6F6] "></view>
						<view class="absolute bottom-0 right-[190rpx] h-[10rpx] w-[20rpx] rounded-tr-[20rpx] rounded-tl-[20rpx] bg-[#F6F6F6]"></view>
					</view>
                    <view v-else class="flex items-center relative w-[100%] rounded-[20rpx] overflow-hidden bg-[#fff] py-[10rpx] background-size" :class="{'mt-[20rpx]' : index}" :style="{ backgroundImage: 'url(' + img('addon/shop/coupon/coupn_bg.png') + ')'  }">
                        <view class="relative box-border flex-1 border-0 border-r-[1px] border-[#FFBDBD] border-dashed flex items-center">
                            <view class="pl-[40rpx] w-[200rpx] box-border">
                                <view class="price-font flex items-center text-[var(--primary-color)]">
                                    <text class="text-[38rpx] leading-[45rpx] text-center font-500">￥</text>
                                    <text class="text-[56rpx] font-semibold text-left leading-[70rpx] truncate">{{ item.coupon_price }}</text>
                                </view>
                            </view>
                            <view class="flex-1 box-border ml-[10rpx]">
                                <view class="text-[30rpx] leading-[35rpx] text-left font-500">
                                    <text v-if="item.min_condition_money === '0.00'">无门槛</text>
                                    <text v-else>满{{ item.coupon_min_price }}元可用</text>
                                </view>
                                <view class="text-[20rpx] leading-[23rpx] mt-[4px] text-left flex items-center">
                                    <text class="bg-[var(--primary-color)] text-[#fff] text-[20rpx] text-center h-[28rpx] leading-[28rpx] px-[10rpx] rounded-[16rpx] mr-[6rpx] shrink-0">{{ item.type_name }}</text>
                                    <text class="truncate max-w-[190rpx]">{{ item.title }}</text>
                                </view>
                                <view class="w-[100%] mt-[4px]  mb-[11px] text-[20rpx] leading-[23rpx]">
                                    <text>有效期至<text>{{ item.expire_time ? item.expire_time.slice(0, 10) : '' }}</text></text>
                                </view>
                            </view>
                        </view>
                        <view class="pr-[20rpx] pl-[30rpx]" v-if="couponStatus === 1">
                            <u-button text="去使用" :customStyle="{width:'150rpx',height:'60rpx',color:'var(--primary-color)', fontSize:'24rpx',lineHeight:'60rpx', padding:'0',backgroundColor:'transparent',border:'2rpx solid var(--primary-color)'}"  shape="circle"  @click="toLink(item.coupon_id)"></u-button>
                        </view>
                        <view class="absolute top-0 right-[190rpx]  h-[10rpx] w-[20rpx] rounded-br-[20rpx] rounded-bl-[20rpx] bg-[#F6F6F6] "></view>
						<view class="absolute bottom-0 right-[190rpx] h-[10rpx] w-[20rpx] rounded-tr-[20rpx] rounded-tl-[20rpx] bg-[#F6F6F6]"></view>
                    </view>
                </template>
            </view>
            <view class="noData my-[20rpx] mx-[24rpx] bg-[#fff] rounded-[20rpx] flex items-center justify-center" v-if="!list.length && loading">
                <mescroll-empty :option="{'tip' : '暂无优惠券'}"></mescroll-empty>
            </view>
        </mescroll-body>
        <pay ref="payRef"></pay>
    </view>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { img, redirect } from '@/utils/common'
import { getMyCouponList } from '@/addon/shop/api/coupon'
import useMemberStore from '@/stores/member'
import MescrollBody from '@/components/mescroll/mescroll-body/mescroll-body.vue'
import MescrollEmpty from '@/components/mescroll/mescroll-empty/mescroll-empty.vue'
import useMescroll from '@/components/mescroll/hooks/useMescroll.js'
import { onPageScroll, onReachBottom } from '@dcloudio/uni-app'
import { t } from '@/locale'

const memberStore = useMemberStore()
const { mescrollInit, downCallback, getMescroll } = useMescroll(onPageScroll, onReachBottom)
const list = ref<Array<Object>>([]);
const loading = ref<boolean>(false);
const statusList = <Array<Object>>([
    { status: 1, name: '待使用' },
    { status: 2, name: '已使用' },
    { status: 3, name: '已过期' },
]);
const couponStatus = ref(1);

const statusClickFn = (status: any) => {
    couponStatus.value = status;
    list.value = []; //如果是第一页需手动制空列表
    getMescroll().resetUpScroll();
};

const getMyCouponListFn = (mescroll) => {
    loading.value = false;
    let data: object = {
        page: mescroll.num,
        limit: mescroll.size,
        status: couponStatus.value
    };

    getMyCouponList(data).then((res) => {
        let newArr = (res.data.data as Array<Object>);
        //设置列表数据
        if (mescroll.num == 1) {
            list.value = []; //如果是第一页需手动制空列表
        }
        list.value = list.value.concat(newArr);
        mescroll.endSuccess(newArr.length);
        loading.value = true;
    }).catch(() => {
        loading.value = true;
        mescroll.endErr(); // 请求失败, 结束加载
    })
}
const toLink = (coupon_id:any) => {
	redirect({ url: '/addon/shop/pages/goods/list',param:{coupon_id} })
}
</script>

<style lang="scss" scoped>
    .remove-border {
        &::after {
            border: none;
        }
    }

.class-select {
    position: relative;
    font-weight: bold;

    &::before {
        content: "";
        position: absolute;
        bottom: 0;
        height: 6rpx;
        background-color: $u-primary;
        width: 90%;
        left: 50%;
        transform: translateX(-50%);
    }
}

.background-size{
	background-repeat: no-repeat;
	background-position: right top;
	background-size: 27%;
}

.noData{
    height: calc(100vh - 130rpx - constant(safe-area-inset-bottom));
    height: calc(100vh - 130rpx - env(safe-area-inset-bottom));
}

</style>