<template>
	<view class="bg-[#F6F6F6] min-h-screen overflow-hidden" :style="themeColor()">

		<mescroll-body ref="mescrollRef" @init="mescrollInit" @down="downCallback" @up="getRefundListFn">
			<view class="mx-[30rpx] pt-[20rpx]" v-if="list.length">
				<view class="mb-[20rpx] bg-[#fff] p-[20rpx] rounded-[16rpx]" v-for="(item,index) in list" :key="index">
					<view @click="toLink(item)">
						<view class="text-[#303133] flex justify-between items-center">
							<view class="text-[26rpx] leading-[30rpx]">{{item.order_refund_no}}</view>
							<view class="text-[28rpx] leading-[32rpx] text-[#EF900A]">{{item.status_name}}</view>
						</view>
						<view class="flex mt-[30rpx]">
							<view class="w-[150rpx] h-[150rpx] flex-2">
								<u--image class="rounded-[10rpx] overflow-hidden" width="150rpx" height="150rpx" :src="img(item.order_goods.goods_image_thumb_small ? item.order_goods.goods_image_thumb_small : '')" model="aspectFill">
									<template #error>
										<u-icon name="photo" color="#999" size="50"></u-icon>
									</template>
								</u--image>
							</view>
							<view class="ml-[20rpx] flex flex-1 flex-col justify-between text-[#303133]">
								<view>
									<text class="text-[28rpx] text-item leading-[40rpx]">{{ item.order_goods.goods_name }}</text>
									<view class="flex" v-if="item.order_goods.sku_name">
										<view class="text-[24rpx] truncate mt-[10rpx] text-[#999] leading-[28rpx] max-w-[480rpx]">{{ item.order_goods.sku_name }}</view>
									</view>
								</view>
								<view class="flex justify-between items-center">
									<view class="text-right leading-[28rpx] price-font">
										<text class="text-[24rpx]">￥</text>
										<text class="text-[32rpx] font-500">{{parseFloat(item.order_goods.price).toFixed(2).split('.')[0] }}</text>
										<text class="text-[22rpx] font-500">.{{parseFloat(item.order_goods.price).toFixed(2).split('.')[1] }}</text>
									</view>
									<text class="text-right text-[26rpx]">x{{ item.order_goods.num }}</text>
								</view>
							</view>
						</view>
					</view>
					<view class="flex  items-center mt-[20rpx] justify-end">
						<view class="mr-[20rpx] flex items-center">
							<text class="text-[#999] text-[22rpx] mr-[4rpx]">{{ t('actualPayment') }}：</text>
							<view class="price-font">
								<text class="text-[26rpx]">￥</text>
								<text class="text-[36rpx] font-500">{{ parseFloat(item.order_goods.order_goods_money).toFixed(2).split('.')[0] }}</text>
								<text class="text-[24rpx] font-500">.{{ parseFloat(item.order_goods.order_goods_money).toFixed(2).split('.')[1] }}</text>
							</view>
						</view>
						<view class="flex items-center">
							<text class="text-[#999] text-[22rpx] mr-[4rpx]">{{t('refundMoney')}}：</text>
							<view class="price-font text-[var(--price-text-color)]">
								<text class="text-[26rpx]">￥</text>
								<text class="text-[36rpx] font-500">{{ parseFloat(item.apply_money).toFixed(2).split('.')[0] }}</text>
								<text class="text-[24rpx] font-500">.{{ parseFloat(item.apply_money).toFixed(2).split('.')[1] }}</text>
							</view>
						</view>
					</view>
					<view class="mt-[20rpx] flex flex-wrap justify-end">
						<view class="text-[24rpx] text-[#303133] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full ml-[20rpx]" @click.stop="refundBtnFn(item,'cancel')" v-if="['6','7','8','-1'].indexOf(item.status) == -1">{{t('refundApply')}}</view>
						<view v-if="['3'].indexOf(item.status) != -1" class="text-[24rpx] text-[#303133] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full ml-[20rpx]" @click.stop="refundBtnFn(item,'edit')" >编辑退款信息</view>
						<view v-if="['2'].indexOf(item.status) != -1" class=" text-[24rpx] text-[#303133] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full ml-[20rpx]" @click.stop="refundBtnFn(item,'logistics')">填写发货物流</view>
						<view v-if="['5'].indexOf(item.status) != -1" class="text-[24rpx] text-[#303133] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full ml-[20rpx]" @click.stop="refundBtnFn(item,'editLogistics')">编辑发货物流</view>
					</view>
				</view>
			</view>
			<view class="flex justify-center items-center w-[100%] h-[100vh] bg-[#fff]" v-if="!list.length && loading">
				<mescroll-empty :option="{tip : '暂无订单'}"></mescroll-empty>
			</view>
			
		</mescroll-body>
		<u-modal :show="cancelRefundshow" :content="t('cancelRefundContent')" :showCancelButton="true" :closeOnClickOverlay="true" @cancel="refundCancel" @confirm="refundConfirm"></u-modal>
	</view>
</template>

<script setup lang="ts">
	import { ref } from 'vue';
	import { t } from '@/locale'
	import { img, redirect } from '@/utils/common';
	import { getRefundList, closeRefund } from '@/addon/shop/api/refund';
	import MescrollBody from '@/components/mescroll/mescroll-body/mescroll-body.vue';
	import MescrollEmpty from '@/components/mescroll/mescroll-empty/mescroll-empty.vue';
	import useMescroll from '@/components/mescroll/hooks/useMescroll.js';
	import { onLoad, onPageScroll, onReachBottom } from '@dcloudio/uni-app';

	const { mescrollInit, downCallback, getMescroll } = useMescroll(onPageScroll, onReachBottom);
	let list = ref<Array<Object>>([]);
	let loading = ref<boolean>(false);
	let cancelRefundshow = ref(false);

	const getRefundListFn = (mescroll) => {
		loading.value = false;
		let data : object = {
			page: mescroll.num,
			limit: mescroll.size
		};

		getRefundList(data).then((res) => {
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

	const toLink = (data) => {
		redirect({ url: '/addon/shop/pages/refund/detail', param: { order_refund_no : data.order_refund_no } })
	}

	let currRefundOn = "";
	const refundBtnFn = (data, type) => {
		if(type == 'cancel'){
			currRefundOn = data.order_refund_no;
			cancelRefundshow.value = true;
		}else if(type == 'edit'){
			redirect({ url: '/addon/shop/pages/refund/edit_apply', param: { order_refund_no : data.order_refund_no } })
		}else if(type == 'logistics'){
			redirect({ url: '/addon/shop/pages/refund/detail', param: { order_refund_no : data.order_refund_no, type: 'logistics' } })
		}else if(type == 'editLogistics'){
			redirect({ url: '/addon/shop/pages/refund/detail', param: { order_refund_no : data.order_refund_no, type: 'logistics', is_edit_delivery: true } })
		}
	}

	const refundConfirm = ()=>{
		closeRefund(currRefundOn).then((res) => {
			cancelRefundshow.value = false;
			getMescroll().resetUpScroll();
		}).catch(() => {
			cancelRefundshow.value = false;
		})
	}

	const refundCancel = ()=>{
		cancelRefundshow.value = false;
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
</style>
