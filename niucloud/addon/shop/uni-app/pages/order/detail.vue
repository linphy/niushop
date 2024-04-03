<template>
    <view :style="themeColor()">   
        <view class="bg-[#f8f8f8] min-h-screen overflow-hidden" v-if="!loading">
            <view v-if="!loading" class="pb-20rpx">
                <!-- #ifndef H5 -->
                <view v-if="detail.status_name" class="pl-[40rpx] pr-[50rpx] bg-linear" :style="headStyle">
                <!-- #endif -->
                <!-- #ifdef H5 -->
                <view v-if="detail.status_name" class="pl-[40rpx] pr-[50rpx] bg-linear h-[262rpx]">
                <!-- #endif -->
                    <!-- #ifdef MP-WEIXIN -->
                    <top-tabbar  :title="title" :param="param" />
                    <!-- #endif -->
                    <view class="flex justify-between items-center pt-[30rpx]">
                        <view class="text-[#fff]">
                            <view class="text-[36rpx] font-500 leading-[42rpx]">{{ detail.status_name.name }}</view>
                        </view>
                        <view>
                            <image v-if="detail.status == 1" class="w-[110rpx] h-[110rpx]" :src="img('addon/shop/detail/payment.png')" />
                            <image v-if="detail.status == 2" class="w-[110rpx] h-[110rpx]" :src="img('addon/shop/detail/payment.png')" />
                            <image v-if="detail.status == 3" class="w-[110rpx] h-[110rpx]" :src="img('addon/shop/detail/receive.png')" />
                            <image v-if="detail.status == 5" class="w-[110rpx] h-[110rpx]" :src="img('addon/shop/detail/complete.png')" />
                            <image v-if="detail.status == -1" class="w-[110rpx] h-[110rpx]" :src="img('addon/shop/detail/close.png')" />
                        </view>
                    </view>
                </view>
                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] mt-[-86rpx] rounded-[16rpx]" v-if="detail.delivery_type != 'virtual'">
                    <view v-if="detail.delivery_type == 'express'">
                        <view class="text-[#303133]">
                            <view class="flex items-center">
                                <image class="w-[28rpx] h-[32rpx] mr-[10rpx] flex-shrink-0" :src="img('addon/shop/detail/address.png')" />
                                <text class="text-[32rpx] font-500 leading-[38rpx]">{{detail.taker_address}}</text>
                                <text class="text-[22rpx] ml-[10rpx] leading-[26rpx]">{{detail.taker_full_address.split(detail.taker_address)[0]}}</text>
                            </view>
                            <view class="mt-[6rpx] text-[24rpx] leading-[28rpx] ">
                                <text>{{ detail.taker_name }}</text>
                                <text class="ml-[15rpx]">{{ detail.taker_mobile }}</text>
                            </view>
                        </view>
                        
                    </view>
                    <view v-if="detail.delivery_type == 'store'">
                        <view class="flex">
                            <view>
                                <u--image class="rounded-[10rpx] overflow-hidden" width="100rpx" height="100rpx"
                                    :src="img(detail.store.store_logo ? detail.store.store_logo : '')" model="aspectFill">
                                    <template #error>
                                        <u-icon name="photo" color="#999" size="50"></u-icon>
                                    </template>
                                </u--image>
                            </view>
                            <view class="flex flex-col ml-[20rpx]">
                                <text class="text-[24rpx]">{{ detail.store.store_name }}</text>
                                <text class="text-[24rpx] mt-[15rpx]">{{ detail.store.trade_time }}</text>
                                <text class="text-[24rpx] mt-[10rpx] leading-[35rpx]">{{ detail.store.full_address }}</text>
                            </view>
                        </view>
                    </view>
                    <view class="flex" v-if="detail.delivery_type == 'local_delivery'">
                        <view @click="getAddress" class="min-w-[100rpx] flex items-center justify-center">
                            <u-icon name="map" size="25"></u-icon>
                        </view>
                        <view class="flex flex-col ml-[20rpx]">
                            <text class="text-[24rpx]">{{ detail.taker_name }}</text>
                            <text class="text-[24rpx] mt-[15rpx]">{{ detail.taker_mobile }}</text>
                            <text class="text-[24rpx] mt-[10rpx] leading-[35rpx]">{{ detail.taker_full_address }}</text>
                        </view>
                    </view>
                </view>
                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] rounded-[16rpx]"
                    :style="detail.delivery_type == 'virtual' ? 'margin-top: -70rpx' : 'margin-top: 20rpx'">
                    <view class="order-goods-item flex justify-between flex-wrap mt-[30rpx]"
                        v-for="(goodsItem, goodsIndex) in detail.order_goods" :key="goodsIndex">
                        <view class="w-[150rpx] h-[150rpx] flex-2" @click="goodsEvent(goodsItem.goods_id)">
                            <u--image class="rounded-[10rpx] overflow-hidden" width="150rpx" height="150rpx"
                                :src="img(goodsItem.goods_image_thumb_small ? goodsItem.goods_image_thumb_small : '')"
                                model="aspectFill">
                                <template #error>
                                    <u-icon name="photo" color="#999" size="50"></u-icon>
                                </template>
                            </u--image>
                        </view>
                        <view class="ml-[20rpx] flex flex-1 flex-col justify-between">
                            <view>
                                <text class="text-[28rpx] text-item leading-[40rpx]">{{ goodsItem.goods_name }}</text>
                                <view v-if="goodsItem.sku_name">
                                    <view class="text-[24rpx] mt-[10rpx] text-[#999] truncate max-w-[450rpx] leading-[28rpx]">{{ goodsItem.sku_name }}</view>
                                </view>
                            </view>
                            <view class="flex justify-between items-center leading-[28rpx]">
                                <view class="price-font">
                                    <text class="text-[24rpx]">￥</text>
                                    <text class="text-[32rpx] font-500">{{ parseFloat(goodsItem.price).toFixed(2).split('.')[0] }}</text>
                                    <text class="text-[22rpx] font-500">.{{ parseFloat(goodsItem.price).toFixed(2).split('.')[1] }}</text>
                                </view>
                                <text class="text-right text-[26rpx]">x{{ goodsItem.num }}</text>
                            </view>
                        </view>
                        <view class="flex justify-end  self-end w-[100%] mt-[10rpx]" v-if="(goodsItem.status != '1') || (goodsItem.is_enable_refund == 1)">	
                            <view v-if="goodsItem.status != '1'"
                                class="text-[26rpx] text-[#303133] leading-[46rpx] px-[10rpx] border-[2rpx] border-solid border-[#999] rounded-[23rpx]"
                                @click="redirect({ url: '/addon/shop/pages/refund/detail', param: { order_refund_no : goodsItem.order_refund_no } })">查看退款</view>
                            <view v-else-if="goodsItem.is_enable_refund == 1"
                                class="text-[26rpx] text-[#303133]  leading-[46rpx] px-[10rpx] border-[2rpx] border-solid border-[#999] rounded-[23rpx] ml-[20rpx]"
                                @click="applyRefund(goodsItem.order_goods_id)">申请退款</view>
                        </view>
                    </view>
                </view>
                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] mt-[20rpx] rounded-[16rpx]">
                    <view class="flex justify-between text-[28rpx] leading-[32rpx]">
                        <view>{{ t('orderNo') }}</view>
                        <view class="flex items-center">
                            <text>{{ detail.order_no }}</text>
                            <text class="w-[2rpx] h-[20rpx] bg-[#999] mx-[10rpx]"></text>
                            <text class="text-[#EF900A]" @click="copy(detail.order_no)">复制</text>
                        </view>
                    </view>
                    <view v-if="detail.out_trade_no"
                        class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view>{{ t('orderTradeNo') }}</view>
                        <view>{{ detail.out_trade_no }}</view>
                    </view>
                    <view
                        class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view>{{ t('createTime') }}</view>
                        <view>{{ detail.create_time }}</view>
                    </view>
                    <view
                        class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view>{{ t('deliveryType') }}</view>
                        <view>{{ detail.delivery_type_name }}</view>
                    </view>
                    <view v-if="detail.pay"
                        class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view>{{ t('payTypeName') }}</view>
                        <view>{{ detail.pay.type_name }}</view>
                    </view>
                    <view v-if="detail.pay"
                        class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view>{{ t('payTime') }}</view>
                        <view>{{ detail.pay.pay_time }}</view>
                    </view>
                </view>

                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] mt-[20rpx] rounded-[16rpx]">
                    <view class="flex justify-between leading-[32rpx]">
                        <view class="text-[28rpx]">{{ t('goodsMoney') }}</view>
                        <view class="price-font font-500">
                            <text class="text-[24rpx]">￥</text>
                            <text class="text-[28rpx]">{{ parseFloat(detail.goods_money).toFixed(2).split('.')[0] }}</text>
                            <text class="text-[22rpx]">.{{ parseFloat(detail.goods_money).toFixed(2).split('.')[1] }}</text>
                        </view>
                    </view>
                    <view class="flex justify-between text-[28rpx] leading-[32rpx]  mt-[30rpx]">
                        <view class="text-[28rpx]">{{ t('discountMoney') }}</view>
                        <view class="price-font font-500">
                            <text class="text-[24rpx]">-￥</text>
                            <text class="text-[28rpx]">{{ parseFloat(detail.discount_money).toFixed(2).split('.')[0] }}</text>
                            <text class="text-[22rpx]">.{{ parseFloat(detail.discount_money).toFixed(2).split('.')[1] }}</text>
                        </view>
                    </view>
                    <view
                        class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view class="text-[28rpx]">{{ t('deliveryMoney') }}</view>
                        <view class="price-font font-500">
                            <text class="text-[24rpx]">￥</text>
                            <text class="text-[28rpx]">{{ parseFloat(detail.delivery_money).toFixed(2).split('.')[0] }}</text>
                            <text class="text-[22rpx]">.{{ parseFloat(detail.delivery_money).toFixed(2).split('.')[1] }}</text>
                        </view>
                    </view>
                    <view class="flex justify-end text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view class="text-[28rpx]">{{ t('orderMoney') }}：</view>
                        <view class="text-[var(--price-text-color)] price-font font-500">
                            <text class="text-[24rpx]">￥</text>
                            <text class="text-[28rpx]">{{ parseFloat(detail.order_money).toFixed(2).split('.')[0] }}</text>
                            <text class="text-[22rpx]">.{{ parseFloat(detail.order_money).toFixed(2).split('.')[1] }}</text>
                        </view>
                    </view>
                </view>

                <view class="flex z-2 justify-end items-center bg-[#fff] fixed left-0 right-0 bottom-0 min-h-[100rpx] px-1 flex-wrap  pb-ios">
                    <view class="flex w-[70rpx] flex-col justify-center items-center" @click="orderBtnFn('index')">
                        <text class="iconfont iconshouye text-[32rpx]"></text>
                        <!-- <text class="text-xs mt-1">{{ t('index') }}</text> -->
                    </view>
                    <view class="flex justify-end mr-[30rpx]">
                        <view class="text-[26rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full ml-[20rpx] text-[#303133]" v-if="showLogistics(detail)" @click="orderBtnFn('logistics')">
                            {{ t('logisticsTracking') }}
                        </view>
                        <view class="text-[26rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full ml-[20rpx] text-[#303133]" v-if="detail.status == 1" @click="orderBtnFn('close')">{{ t('orderClose') }}</view>
                        <view class=" text-[26rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid text-[#fff] bg-primary border-primary rounded-full ml-[20rpx]" @click="orderBtnFn('pay')" v-if="detail.status == 1">{{ t('topay') }}</view>
                        <view class="text-[26rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid text-[#fff] bg-primary border-primary rounded-full ml-[20rpx]" v-if="detail.status == 3" @click="orderBtnFn('finish')" >{{ t('orderFinish') }}</view>
                        <block v-if="detail.status == 5">
                            <view v-if="detail.is_evaluate == 1 || (detail.is_evaluate != 1 && evaluateConfig.is_evaluate == 1)"
                                class="text-[26rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full ml-[20rpx] !text-[#303133]"
                                @click="orderBtnFn('evaluate')">{{ t('evaluate') }}</view>
                        </block>
                    </view>
                </view>
            </view>
            <view class="tab-bar-placeholder"></view>
            <pay ref="payRef" @close="payClose"></pay>
            <logistics-tracking ref="materialRef"></logistics-tracking>
        </view>

        <u-loading-page bg-color="rgb(248,248,248)" :loading="loading" loadingText="" fontSize="16" color="#303133"></u-loading-page>
    </view>
</template>

<script setup lang="ts">
import { ref, reactive, computed } from 'vue';
import { onLoad } from '@dcloudio/uni-app'
import { t } from '@/locale'
import { img, redirect, copy } from '@/utils/common';
import { getShopOrderDetail, orderClose, orderFinish } from '@/addon/shop/api/order';
import { getEvaluateConfig } from '@/addon/shop/api/shop';
import { useSubscribeMessage } from '@/hooks/useSubscribeMessage';
import logisticsTracking from '@/addon/shop/pages/order/components/logistics-tracking/logistics-tracking.vue'

// 获取系统状态栏的高度
let menuButtonInfo = {};
// 如果是小程序，获取右上角胶囊的尺寸信息，避免导航栏右侧内容与胶囊重叠(支付宝小程序非本API，尚未兼容)
// #ifdef MP-WEIXIN || MP-BAIDU || MP-TOUTIAO || MP-QQ
menuButtonInfo = uni.getMenuButtonBoundingClientRect();
// #endif
let title = ref('订单详情')
let param = ref({
	arrowLink:'/addon/shop/pages/order/list',
	isShowArrow:true,
	tabbarBg:'transparent',
	arrowColor:'#fff',
	titleColor:'#fff'
})
const headStyle = computed(() => {
	let style = ''
	style += 'height:' + (Number(menuButtonInfo.height) + menuButtonInfo.top +  139) + 'px;';
	return style
})
let detail = ref<Object>({});
let loading = ref<boolean>(true);
let type = ref('')
let orderId = ref('')
let orderStepsShow = ref(false)
let evaluateConfig = ref<Object>({});

onLoad((option) => {
	orderId.value = option.order_id;
	orderDetailFn(orderId.value);
});

getEvaluateConfig().then(({ data }) => {
    evaluateConfig.value = data
})

const orderDetailFn = (id) => {
	loading.value = true;
	getShopOrderDetail(id).then((res) => {
		detail.value = res.data;
		loading.value = false;
	}).catch(() => {
		loading.value = false;
	})
}

//关闭订单
const close = (item: any) => {
	uni.showModal({
		title: '提示',
		content: '您确定要关闭该订单吗？',
		success: res => {
			if (res.confirm) {
				orderClose(item.order_id).then((data) => {
					orderDetailFn(item.order_id);
				})
			}
		}
	})
}

//订单完成
const finish = (item: any) => {
	uni.showModal({
		title: '提示',
		content: '您确定物品已收到吗？',
		success: res => {
			if (res.confirm) {
				orderFinish(item.order_id).then((data) => {
					orderDetailFn(item.order_id);
				})
			}
		}
	})
}

const goodsEvent = (id: number) => {
	redirect({
		url: '/addon/shop/pages/goods/detail',
		param: {
			goods_id: id
		}
	})
}

const payRef = ref(null)
const materialRef = ref(null)
const orderBtnFn = (type = '') => {
	if (type == 'pay')
		payRef.value?.open(detail.value.order_type, detail.value.order_id, `/addon/shop/pages/order/detail?order_id=${detail.value.order_id}`);
	else if (type == 'close') {
		close(detail.value);
	} else if (type == 'finish') {
		finish(detail.value);
	} else if (type == 'index') {
		redirect({
			url: '/addon/shop/pages/index',
            mode: 'reLaunch'
		});
	} else if (type == 'logistics') {
		if (detail.value.order_delivery.length > 0) {
			let params = {
				id: detail.value.order_delivery[0].id,
				mobile: detail.value.taker_mobile
			}
			let list = ref([])
			detail.value.order_delivery.forEach((item: any, index: number) => {
				item.mobile = detail.value.taker_mobile
				item.parcelName = `包裹${index + 1}`
				list.value.push(item)
			})
			materialRef.value.open(params);
			materialRef.value.packageList = list.value
		}
	} else if (type == 'evaluate') {
		if (!detail.value.is_evaluate) {
			redirect({ url: '/addon/shop/pages/evaluate/order_evaluate', param: { order_id: detail.value.order_id } })
		} else {
			redirect({ url: '/addon/shop/pages/evaluate/order_evaluate_view', param: { order_id: detail.value.order_id } })
		}
	}
}
const dateFormat = (res, type) => {
	let data;
	if (res.indexOf('/') != -1) {
		data = res.split("/");
	} else if (res.indexOf('-') != -1) {
		data = res.split("-");
	}

	let time;
	const index = new Date(res).getDay();
	const week = ['周日', '周一', '周二', '周三', '周四', '周五', '周六']
	if (type == "yearMonthDay")
		time = data[0] + '年' + data[1] + '月' + data[2] + '日';
	else if (type == "yearMonthDayWeek")
		time = data[0] + '年' + data[1] + '月' + data[2] + '日 ' + week[index];
	else if (type == "monthDayWeek")
		time = data[1] + '月' + data[2] + '日 ' + week[index];
	else
		time = data[1] + '月' + data[2] + '日';

	return time;
}

const applyRefund = (orderGoodsId: number) => {
	redirect({
		url: '/addon/shop/pages/refund/apply',
		param: {
			order_id: detail.value.order_id,
			order_goods_id: orderGoodsId
		}
	})
}

const getAddress = () => {
	uni.openLocation({
		latitude: Number(detail.value.taker_latitude),
		longitude: Number(detail.value.taker_longitude),
		success: function () { }
	});
}

const showLogistics = (data: any) => {
	let status = false
	if (data.delivery_type != 'express') return false;
	data.order_delivery.forEach(item => {
		if (item.sub_delivery_type === 'express' && data.status === '3') {
			status = true
		} else if (item.sub_delivery_type === 'express' && data.status === '5') {
			status = true
		} else {
			status = false
		}
	})
	return status
}

</script>
<style lang="scss" scoped>

.text-item {
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
}

.order-goods-item:nth-child(1) {
	margin-top: 0rpx;
}

.text-color {
	color: $u-primary;
}

.bg-color {
	background-color: $u-primary;
}

.bg-linear {
	background: linear-gradient( 94deg, #E73835 15%, #FE8448 87%);
}

.font-scale {
	transform: scale(0.9);
}

.triangle {
	@apply relative;

	&::before {
		content: "";
		@apply absolute;
		width: 0;
		height: 0;
		position: absolute;
		bottom: -40rpx;
		border: 20rpx solid #EEF3FF;
		border-left-color: transparent;
		border-right-color: transparent;
		border-bottom-color: transparent;
	}
}

.tab-bar-placeholder {
	padding-bottom: calc(constant(safe-area-inset-bottom) + 100rpx);
	padding-bottom: calc(env(safe-area-inset-bottom) + 100rpx);
}
</style>
