<template>
    <view :style="themeColor()">
        <view class="bg-[#f8f8f8] min-h-screen overflow-hidden" v-if="!loading">
            <view class="pb-[200rpx]" v-if="type != 'logistics'">
                <view v-if="detail.status_name" class="flex justify-between items-center pl-[40rpx] pr-[50rpx] bg-linear h-[170rpx]">
                    <view class="text-[36rpx] font-500 leading-[42rpx] text-[#fff]">{{ detail.status_name }}</view>
                    <view>
                        <image v-if="['1','2','4','6','7'].indexOf(detail.status) != -1" class="w-[110rpx] h-[110rpx]" :src="img('addon/shop/detail/payment.png')" />
                        <image v-if="['8'].indexOf(detail.status) != -1" class="w-[110rpx] h-[110rpx]" :src="img('addon/shop/detail/complete.png')" />
                        <image v-if="['3','5','-1'].indexOf(detail.status) != -1" class="w-[110rpx] h-[110rpx]" :src="img('addon/shop/detail/close.png')" />
                    </view>
                </view>

                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] rounded-[16rpx] flex justify-between flex-wrap mt-[20rpx]">
                    <view class="w-[150rpx] h-[150rpx] flex-2" @click="goodsEvent(detail.order_goods.goods_id)">
                        <u--image class="rounded-[10rpx] overflow-hidden" width="150rpx" height="150rpx" :src="img(detail.order_goods.goods_image_thumb_small ? detail.order_goods.goods_image_thumb_small : '')" model="aspectFill">
                            <template #error>
                                <u-icon name="photo" color="#999" size="50"></u-icon>
                            </template>
                        </u--image>
                    </view>
                    <view class="ml-[20rpx] flex flex-1 flex-col justify-between text-[#303133]">
                        <view>
                            <text class="text-[28rpx] text-item leading-[40rpx]">{{ detail.order_goods.goods_name }}</text>
                            <view class="flex" v-if="detail.order_goods.sku_name">
                                <view class="text-[24rpx] mt-[10rpx] text-[#999] truncate max-w-[450rpx] leading-[28rpx]">{{ detail.order_goods.sku_name }}</view>
                            </view>
                        </view>
                        <view class="flex justify-between items-center leading-[28rpx]">
                            <view class="price-font">
                                <text class="text-[24rpx]">￥</text>
                                <text class="text-[32rpx] font-500">{{ parseFloat(detail.order_goods.price).toFixed(2).split('.')[0] }}</text>
                                <text class="text-[22rpx] font-500">.{{ parseFloat(detail.order_goods.price).toFixed(2).split('.')[1] }}</text>
                            </view>
                            <text class="text-right text-[26rpx]">x{{ detail.order_goods.num }}</text>
                        </view>
                    </view>
                </view>
                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] mt-[20rpx] rounded-[16rpx]">
                    <view class="flex justify-between text-[28rpx] leading-[32rpx] ">
                        <view>{{t('refundType')}}</view>
                        <view>{{ detail.refund_type_name }}</view>
                    </view>
                    <view class="flex justify-between text-[28rpx] leading-[32rpx]  mt-[30rpx]">
                        <view>{{t('refundCause')}}</view>
                        <view class="w-[400rpx] multi-hidden text-right">{{ detail.reason || '--' }}</view>
                    </view>
                    <view class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view>{{t('refundNo')}}</view>
                        <view>{{ detail.order_refund_no }}</view>
                    </view>
                    <view class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view>{{t('createTime')}}</view>
                        <view>{{ detail.create_time }}</view>
                    </view>
                    <view class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view>{{t('createExplain')}}</view>
                        <view class="flex-1 ml-[20rpx] flex justify-end">{{ detail.remark }}</view>
                    </view>
                </view>

                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] mt-[20rpx] rounded-[16rpx]">
                    <view class="flex justify-between text-[28rpx] leading-[32rpx]">
                        <view>{{t('record')}}</view>
                        <view class="flex items-center" @click="redirect({url: '/addon/shop/pages/refund/log', param: { order_refund_no: orderRefundNo }})">
                            <text>{{t('check')}}</text>
                            <text class="iconfont iconxiangyoujiantou text-xs"></text>
                        </view>
                    </view>
                </view>

                <view class="flex tab-bar justify-end items-center bg-[#fff] fixed left-0 right-0 bottom-0 min-h-[100rpx] px-1 flex-wrap">
                    <view class="flex w-[70rpx] flex-col justify-center items-center" @click="redirect({ url: '/addon/shop/pages/index', mode: 'reLaunch' })">
                        <text class="iconfont iconshouye text-[32rpx]"></text>
                        <!-- <text class="text-xs mt-1">{{t('index')}}</text> -->
                    </view>
                    <view class="flex justify-end mr-[30rpx]">
                        <view class="text-[26rpx] leading-[52rpx] px-[23rpx] border-[2rpx] border-solid border-[#999] rounded-full ml-[20rpx] text-[#303133]" @click="cancelRefundFn(detail)" v-if="['6','7','8','-1'].indexOf(detail.status) == -1">{{t('refundApply')}}</view>
                    </view>
                </view>
            </view>
            <view  v-else>
                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] rounded-[16rpx] flex justify-between flex-wrap mt-[20rpx]">
                    <view class="w-[150rpx] h-[150rpx] flex-2" @click="goodsEvent(detail.order_goods.goods_id)">
                        <u--image class="rounded-[10rpx] overflow-hidden" width="150rpx" height="150rpx" :src="img(detail.order_goods.sku_image ? detail.order_goods.sku_image : '')" model="aspectFill">
                            <template #error>
                                <u-icon name="photo" color="#999" size="50"></u-icon>
                            </template>
                        </u--image>
                    </view>
                    <view class="ml-[20rpx] flex flex-1 flex-col justify-between">
                        <view>
                            <text class="text-[28rpx] text-item leading-[40rpx]">{{ detail.order_goods.goods_name }}</text>
                            <view class="flex" v-if="detail.order_goods.sku_name">
                                <text class="text-[24rpx] mt-[10rpx] text-[#999] truncate max-w-[450rpx] leading-[28rpx]">{{ detail.order_goods.sku_name }}</text>
                            </view>
                        </view>
                        <view class="flex justify-between items-center leading-[28rpx]">
                            <view class="price-font">
                                <text class="text-[24rpx]">￥</text>
                                <text class="text-[32rpx] font-500">{{ parseFloat(detail.order_goods.price).toFixed(2).split('.')[0] }}</text>
                                <text class="text-[22rpx] font-500">.{{ parseFloat(detail.order_goods.price).toFixed(2).split('.')[1] }}</text>
                            </view>
                            <text class="text-right text-[26rpx]">x{{ detail.order_goods.num }}</text>
                        </view>
                    </view>
                </view>
                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] rounded-[16rpx] mt-[20rpx]">
                    <view class="flex justify-between text-[28rpx] leading-[32rpx] ">
                        <view>联系人</view>
                        <view>{{ detail.refund_address.contact_name }}</view>
                    </view>
                    <view class="flex justify-between text-[28rpx] leading-[32rpx]  mt-[30rpx]">
                        <view>手机号</view>
                        <view>{{ detail.refund_address.mobile }}</view>
                    </view>
                    <view class="flex justify-between text-[28rpx] leading-[32rpx] mt-[30rpx]">
                        <view>退货地址</view>
                        <view class="w-[460rpx] text-sm" v-if="detail.refund_address">{{ detail.refund_address.full_address || '--' }}</view>
                    </view>
                </view>
                <view class="bg-[#fff] mx-[30rpx] p-[20rpx] rounded-[16rpx] mt-[20rpx]">
                    <u--form labelPosition="left" :model="formData" :rules="rules" ref="deliveryForm" labelWidth="140rpx" :labelStyle="{'fontSize': '28rpx'}">
                        <u-form-item label="物流公司" prop="express_company" borderBottom="true" ref="item1">
                            <u--input pl border="none" v-model="formData.express_company" placeholder="请输入物流公司" placeholderClass="text-sm" fontSize="28rpx"></u--input>
                        </u-form-item>
                        <u-form-item label="物流单号" prop="express_number" borderBottom="true" ref="item1">
                            <u--input border="none" placeholder="请输入物流单号" v-model="formData.express_number" placeholderClass="text-sm" fontSize="28rpx"></u--input>
                        </u-form-item>
                        <u-form-item label="物流说明" borderBottom ref="item1">
                            <u--input border="none" placeholder="选填" v-model="formData.remark" placeholderClass="text-sm" fontSize="28rpx"></u--input>
                        </u-form-item>
                    </u--form>
                </view>
                <view class="mx-[30rpx]">
                    <u-button class="mt-[20rpx]" type="primary" shape="circle" @click="deliverySave">提交</u-button>
                </view>
            </view>
            <logistics-tracking ref="materialRef"></logistics-tracking>
            <u-modal :show="cancelRefundshow" :content="t('cancelRefundContent')" :showCancelButton="true" :closeOnClickOverlay="true" @cancel="refundCancel" @confirm="refundConfirm"></u-modal>
        </view>

        <u-loading-page bg-color="rgb(248,248,248)" :loading="loading" loadingText="" fontSize="16" color="#303133"></u-loading-page>
    </view>
</template>

<script setup lang="ts">
import { ref, reactive, computed } from 'vue';
import { onLoad } from '@dcloudio/uni-app'
import { t } from '@/locale'
import { img, redirect, copy } from '@/utils/common';
import { getRefundDetail, refundDelivery, editRefundDelivery, closeRefund } from '@/addon/shop/api/refund';
import logisticsTracking from '@/addon/shop/pages/order/components/logistics-tracking/logistics-tracking.vue'

let detail = ref<Object>({});
let loading = ref<boolean>(true);
let orderRefundNo = ref('');
let type = ref('');
let isEditDelivery = ref(false);
// 物流信息
const formData = ref({
	express_number: '',
	express_company: '',
	remark: ''
})

// 物流验证
const rules = {
	'express_number': {
		type: 'string',
		required: true,
		message: '请输入物流单号',
		trigger: ['blur', 'change']
	},
	'express_company': {
		type: 'string',
		required: true,
		message: '请输入物流公司',
		trigger: ['blur', 'change']
	}
}

onLoad((option) => {
	orderRefundNo.value = option.order_refund_no;
	type.value = option.type;
	isEditDelivery.value = option.is_edit_delivery;

	refundDetailFn(orderRefundNo.value);
});

const refundDetailFn = (refundNo) => {
	loading.value = true;
	getRefundDetail(refundNo).then((res) => {
		detail.value = res.data;
		// 赋值物流信息
		if(isEditDelivery.value && detail.value.delivery){
			formData.value.express_number = detail.value.delivery.express_number
			formData.value.express_company = detail.value.delivery.express_company
			formData.value.remark = detail.value.delivery.remark
		}
		loading.value = false;
	}).catch(() => {
		loading.value = false;
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

// 撤销维权
let cancelRefundshow = ref(false);
let currRefundOn = "";
const cancelRefundFn = (data) => {
	currRefundOn = data.order_refund_no;
	cancelRefundshow.value = true;
}

const refundConfirm = ()=>{
	closeRefund(currRefundOn).then((res) => {
		cancelRefundshow.value = false;
		refundDetailFn(orderRefundNo.value);
	}).catch(() => {
		cancelRefundshow.value = false;
	})
}

const refundCancel = ()=>{
	cancelRefundshow.value = false;
}

// 提交物流信息
let deliveryForm = ref()
const deliverySave = ()=>{
	deliveryForm.value.validate().then(res => {
		let obj = {delivery: formData.value,order_refund_no: detail.value.order_refund_no}
		let api = isEditDelivery.value ? editRefundDelivery(obj) : refundDelivery(obj);
		api.then((res) => {
			setTimeout(()=>{
				redirect({ url: '/addon/shop/pages/refund/list' })
			},500)
		}).catch(() => {
		})
	})
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

.text-color {
	color: $u-primary;
}
.bg-linear {
	background: linear-gradient( 94deg, #E73835 15%, #FE8448 87%);
}
</style>
