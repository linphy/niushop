<template>
	<view class="bg-[#F6F6F6] min-h-screen overflow-hidden order-list" :style="themeColor()">
		<view class="fixed left-0 top-0 right-0 z-10" v-if="statusLoading">
			<scroll-view scroll-x="true" class="scroll-Y box-border px-[30rpx] bg-white">
				<view class="flex whitespace-nowrap justify-between">
					<view :class="['text-[28rpx] leading-[90rpx]', { 'class-select': orderState === item.status.toString() }]" @click="orderStateFn(item.status)" v-for="(item, index) in orderStateList">{{ item.name }}</view>
				</view>
			</scroll-view>
		</view>

		<mescroll-body ref="mescrollRef" top="90rpx" @init="mescrollInit" @down="downCallback" @up="getShopOrderFn">
			<view class="mx-[30rpx] mt-[20rpx]" v-if="list.length">
				<template v-for="(item, index) in list" :key="index">
					<view class="mb-[20rpx] bg-[#fff] p-[20rpx] rounded-[16rpx]">
						<view @click="toLink(item)">
							<view class="flex justify-between items-center">
								<view class="text-[#303133] text-[28rpx] font-400 leading-[30rpx]">{{ t('orderNo') }}：{{ item.order_no }}</view>
								<view class="text-[#EF900A] text-[28rpx]">{{ item.status_name.name }}</view>
							</view>
							<view class="flex box-border mt-[30rpx]" v-for="(subitem, index) in item.order_goods" :key="index">
								<view class="w-[150rpx] h-[150rpx]">
									<u--image class="rounded-[10rpx] overflow-hidden" width="150rpx" height="150rpx" :src="img(subitem.goods_image_thumb_small ? subitem.goods_image_thumb_small : '')" model="aspectFill">
										<template #error>
											<u-icon name="photo" color="#999" size="50"></u-icon>
										</template>
									</u--image>
								</view>
								<view class="ml-[20rpx] flex flex-1 flex-col justify-between box-border">
									<view>
										<text class="text-[28rpx] text-item  leading-[40rpx] text-[#303133]">{{ subitem.goods_name }}</text>
										<view  v-if="subitem.sku_name">
											<view class="text-[24rpx] truncate mt-[10rpx] text-[#999] leading-[28rpx] max-w-[480rpx]">{{ subitem.sku_name }}</view>
										</view>
									</view>
									<view class="flex justify-between items-center text-[#303133]">
										<view class="text-right leading-[28rpx] price-font">
											<text class="text-[24rpx]">￥</text>
											<text class="text-[32rpx] font-500">{{parseFloat(subitem.price).toFixed(2).split('.')[0] }}</text>
											<text class="text-[22rpx] font-500">.{{parseFloat(subitem.price).toFixed(2).split('.')[1] }}</text>
										</view>
										<text class="text-right text-[26rpx]">x{{ subitem.num }}</text>
									</view>
								</view>
							</view>
						</view>
						<view class="flex justify-between items-center  mt-[20rpx]">
							<text class="text-[#666] text-[24rpx]">{{ item.create_time }}</text>
							<view class="flex items-center">
								<view class="text-[#999] text-[22rpx] mr-[4rpx]">{{ t('actualPayment') }}：</view>
								<view class="text-[var(--price-text-color)] price-font">
									<text class="text-[26rpx]">￥</text>
									<text class="text-[36rpx] font-500">{{ parseFloat(item.order_money).toFixed(2).split('.')[0]  }}</text>
									<text class="text-[24rpx] font-500">.{{ parseFloat(item.order_money).toFixed(2).split('.')[1]  }}</text>
								</view>
							</view>
						</view>
						<view class="flex justify-end text-[28rpx] mt-[20rpx] items-center" v-if="(item.status == 1) || (item.status == 3) || (item.status == 5 && evaluateConfig.is_evaluate == 1)">
							<view
									class="inline-block text-[24rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full text-[#303133] box-border"
									v-if="item.status == 1" @click.stop="orderBtnFn(item, 'close')">{{ t('orderClose') }}</view>
								<view
									class="inline-block text-[24rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid text-[#fff] border-primary bg-primary rounded-full ml-[20rpx] box-border"
									@click.stop="orderBtnFn(item, 'pay')" v-if="item.status == 1">{{ t('topay') }}</view>
								<view
									class="inline-block text-[24rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid text-[#fff] border-primary bg-primary rounded-full ml-[20rpx] box-border"
									@click.stop="orderBtnFn(item, 'finish')" v-if="item.status == 3">{{ t('orderFinish') }}</view>
								<view
									class="inline-block text-[24rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full ml-[20rpx]  text-[#303133] box-border"
									v-if="item.status == 5 && evaluateConfig.is_evaluate == 1"
									@click.stop="orderBtnFn(item, 'evaluate')">{{ t('evaluate') }}</view>
						</view>
					</view>
				</template>
			</view>
			<view class="mx-[30rpx] mt-[20rpx] bg-[#fff] rounded-[16rpx] flex items-center justify-center noData" v-if="!list.length && loading">
				<mescroll-empty :option="{tip : '暂无订单'}"></mescroll-empty>
			</view>
		</mescroll-body>
		<pay ref="payRef" @close="payClose"></pay>
	</view>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { t } from '@/locale'
import { img, redirect } from '@/utils/common';
import { getShopOrderStatus, getShopOrder, orderClose, orderFinish } from '@/addon/shop/api/order';
import { getEvaluateConfig } from '@/addon/shop/api/shop';
import MescrollBody from '@/components/mescroll/mescroll-body/mescroll-body.vue';
import MescrollEmpty from '@/components/mescroll/mescroll-empty/mescroll-empty.vue';
import useMescroll from '@/components/mescroll/hooks/useMescroll.js';
import { onLoad, onPageScroll, onReachBottom } from '@dcloudio/uni-app';

const { mescrollInit, downCallback, getMescroll } = useMescroll(onPageScroll, onReachBottom);
let list = ref<Array<Object>>([]);
let loading = ref<boolean>(false);
let statusLoading = ref<boolean>(false);
let orderState = ref('')
let orderStateList = ref([]);
const evaluateConfig = ref("")

onLoad((option) => {
	orderState.value = option.status || "";
	evaluateEvent()
	getShopOrderStatusFn();
});

const evaluateEvent = () => {
	getEvaluateConfig().then((data) => {
		evaluateConfig.value = data.data
	})
}

const getShopOrderFn = (mescroll) => {
	loading.value = false;
	let data: object = {
		page: mescroll.num,
		limit: mescroll.size,
		status: orderState.value
	};

	getShopOrder(data).then((res) => {
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

const getShopOrderStatusFn = () => {
	statusLoading.value = false;
	orderStateList.value = [];
	let obj = { name: '全部', status: '' };
	orderStateList.value.push(obj);

	getShopOrderStatus().then((res) => {
		Object.values(res.data).forEach((item, index) => {
			orderStateList.value.push(item);
		});
		statusLoading.value = true;
	}).catch(() => {
		statusLoading.value = true;
	})
}

const orderStateFn = (status) => {
	orderState.value = status.toString();
	list.value = [];
	getMescroll().resetUpScroll();
};

const toLink = (data) => {
	redirect({ url: '/addon/shop/pages/order/detail', param: { order_id: data.order_id } })
}

// 支付
const payRef = ref(null)
const orderBtnFn = (data, type = '') => {
	if (type == 'pay')
		payRef.value?.open(data.order_type, data.order_id, `/addon/shop/pages/order/detail?order_id=${data.order_id}`);
	else if (type == 'close') {
		close(data);
	} else if (type == 'finish') {
		finish(data);
	} else if (type == 'evaluate') {
		if (!data.is_evaluate) {
			redirect({ url: '/addon/shop/pages/evaluate/order_evaluate', param: { order_id: data.order_id } })
		} else {
			redirect({ url: '/addon/shop/pages/evaluate/order_evaluate_view', param: { order_id: data.order_id } })
		}
	}
}

//关闭订单
const close = (item: any) => {
	uni.showModal({
		title: '提示',
		content: '您确定要关闭该订单吗？',
		success: res => {
			if (res.confirm) {
				orderClose(item.order_id).then((data) => {
					getMescroll().resetUpScroll();
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
					getMescroll().resetUpScroll();
				})
			}
		}
	})
}
</script>
<style>
.order-list .mescroll-body {
	padding-bottom: constant(safe-area-inset-bottom) !important;
	padding-bottom: env(safe-area-inset-bottom) !important;
}
</style>
<style lang="scss" scoped>
.text-item {
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
}

.font-scale {
	transform: scale(0.75);
}

.text-color {
	color: var(--primary-color);
}

.bg-color {
	background-color: var(--primary-color);
}

.class-select {
	position: relative;
	font-weight: 500;
	color: var(--primary-color);
	&::before {
		content: "";
		position: absolute;
		bottom: 0;
		height: 4rpx;
		border-radius: 4rpx;
		background-color: var(--primary-color);
		width: 40rpx;
		left: 50%;
		transform: translateX(-50%);
	}
}
.noData{
	height: calc(100vh - 130rpx - constant(safe-area-inset-bottom));
	height: calc(100vh - 130rpx - env(safe-area-inset-bottom));
 }
</style>
