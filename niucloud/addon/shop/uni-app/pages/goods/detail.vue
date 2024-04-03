<template>
	<view :style="themeColor()">
		<view class="bg-[#f6f6f6] min-h-[100vh] relative" v-if="Object.keys(goodsDetail).length">
			<!-- 自定义头部 -->
			<view class="flex items-center fixed left-0 right-0 z-10 bg-transparent detail-head" :class="{'!bg-[#fff]' :detailHeadBgChange}" :style="navbarInnerStyle">
				<text class="iconfont iconjiantou3" :style="navbarInnerArrowStyle" @click="goback()"></text>
				<view class="w-[60rpx] ml-auto h-[60rpx] flex items-center justify-center bg-[rgba(255,255,255,.3)] rounded-full border-[2rpx] border-solid border-transparent" :class="{'border-[#d8d8d8]': detailHeadBgChange}" @click="collectFn">
					<text class="iconfont" :class="{'text-[#ff0000] iconshoucang_shoucang': isCollect, 'text-[#303133] icona-shoucang-weishoucang' : !isCollect}"></text>
				</view>
			</view>
			 
			<view class="swiper-box">
				<u-swiper :list="goodsDetail.goods.goods_image" :autoplay="false" height="100vw"></u-swiper>
			</view>
			
			<view class="-mt-[40rpx] relative bg-white mx-[20rpx] rounded-[16rpx] p-[20rpx]">
				<view class="flex items-baseline">
					<view class="text-[var(--price-text-color)] flex items-baseline">
						<text class="text-[32rpx] font-medium price-font">￥</text>
						<text class="text-[48rpx] price-font">{{ parseFloat(goodsDetail.sale_price).toFixed(2).split('.')[0] }}</text>
						<text class="text-[32rpx] mr-[10rpx] price-font">.{{ parseFloat(goodsDetail.sale_price).toFixed(2).split('.')[1] }}</text>
						<text class="text-[26rpx] text-[#999] line-through price-font">
							￥{{ goodsDetail.market_price }}
						</text>
					</view>
					<view class="text-[26rpx] text-[#999] flex items-baseline ml-auto">
						<text>销量</text>
						<text class="mx-[2rpx]">{{ goodsDetail.goods.sale_num }}</text>
						<text>{{ goodsDetail.goods.unit }}</text>
					</view>
				</view>
				<view class="mt-[24rpx] font-medium text-[32rpx] multi-hidden leading-[40rpx]">
					{{ goodsDetail.goods.goods_name }}
				</view>
				<view class="flex flex-wrap mt-[16rpx]" v-if="goodsDetail.label_info && goodsDetail.label_info.length">
					<view v-for="item in goodsDetail.label_info" :key="item.label_id"
						class="text-[#FA6400] leading-[36rpx] text-[22rpx] h-[40rpx] px-[10rpx] border-[2rpx] border-solid border-[#FA6400] rounded-[4rpx] mr-[15rpx] box-border truncate">
						{{ item.label_name }}
					</view>
				</view>
			</view>

			<view class="mt-[20rpx] bg-white mx-[20rpx] rounded-[16rpx] px-[20rpx] py-[16rpx]">
				<view @click="servicesDataShow = !servicesDataShow" v-if="goodsDetail.service && goodsDetail.service.length"
					class="flex items-center h-[64rpx]">
					<text class="text-[#666] text-[26rpx] leading-[30rpx] font-400 shrink-0">服务</text>
					<view class="text-[#343434] text-[26rpx] leading-[30rpx] font-400 truncate ml-auto">
						{{ goodsDetail.service[0].service_name }}
					</view>
					<text class="iconfont iconxiangyoujiantou text-[22rpx] text-[#999] ml-[4rpx]"></text>
				</view>
				<view @click="buyFn" v-if="goodsDetail.goodsSpec && goodsDetail.goodsSpec.length" 
					class="flex items-center h-[64rpx]">
					<text class="text-[#666] text-[26rpx] leading-[30rpx] font-400 shrink-0">已选</text>
					<view class="ml-auto text-[#343434] text-[26rpx] leading-[30rpx] font-400">
						{{ goodsDetail.sku_spec_format }}
					</view>
					<text class="iconfont iconxiangyoujiantou text-[22rpx] text-[#999] ml-[4rpx]"></text>
				</view>
				<view class="flex items-center h-[64rpx]" @click="distributionDataOpen"
					v-if="goodsDetail.goods.goods_type == 'real'&&goodsDetail.delivery_type_list&&goodsDetail.delivery_type_list.length" >
					<text class="text-[#666] text-[26rpx] leading-[30rpx] font-400 shrink-0">配送</text>
					<view class="ml-auto flex items-center text-[#343434] text-[26rpx] leading-[30rpx] font-400">
						{{goodsDetail.delivery_type_list[selectDeliveryType]}}
					</view>
					<text class="iconfont iconxiangyoujiantou text-[22rpx] text-[#999] ml-[4rpx]"></text>
				</view>
				<view @click="couponListShow = true" v-if="couponList.length" class="flex items-center h-[64rpx]">
					<text class="text-[#666] text-[26rpx] leading-[30rpx] font-400 shrink-0">领券</text>
					<view class="ml-auto flex items-center whitespace-nowrap overflow-hidden h-[44rpx] flex-wrap content-between">
						<block v-for="(item, index) in couponList" :key="index">
							<text v-if="index < 3" class="text-xs rounded-sm border-[2rpx] px-[6rpx] py-[2rpx] border-solid border-[var(--primary-color)] text-[var(--primary-color)] mt-[4rpx]" :class="{'mr-[8rpx]': index < 2}">
								{{ item.title }}
							</text>
						</block>
					</view>
					<text class="iconfont iconxiangyoujiantou text-[22rpx] text-[#999] ml-[4rpx]"></text>
				</view>

			</view>

			<view class="mt-[20rpx] bg-white mx-[20rpx] rounded-[16rpx] px-[20rpx]">
				<view class="flex items-center justify-between h-[80rpx]">
					<text class="text-[28rpx] text-[#303133] font-bold">宝贝评价({{ evaluate.count }})</text>
					<view v-if="evaluate.count" class="h-[80rpx] leading-[80rpx]" @click="toLink(goodsDetail.goods_id)">
						<text class="text-[24rpx] text-[#666] mr-[4rpx]">查看全部</text>
						<text class="iconfont iconxiangyoujiantou text-[22rpx] text-[#999]"></text>
					</view>
					<text v-if="!evaluate.count" class="text-[24rpx] text-[#666]">暂无评价</text>
				</view>
				<view>
					<view class="pb-[20rpx] flex justify-between" v-for="(item, index) in evaluate.list" :key="index">
						<view class="flex flex-col">
							<view class="flex items-center">
								<u-avatar :src="img(item.member_head)" :size="'30rpx'" leftIcon="none"></u-avatar>
								<text class="ml-[10rpx] text-[22rpx] text-[#999]">{{ item.member_name }}</text>
							</view>
							<view class="text-[26rpx] text-[#303133] leading-[36rpx] mt-[10rpx] multi-hidden">{{ item.content }}</view>
						</view>
						<u--image v-if="item.image_mid && item.image_mid.length" class="rounded-[8rpx] ml-[50rpx] overflow-hidden" width="80rpx" height="80rpx" :src="img(item.image_mid[0])" model="aspectFill" @click="imgListPreview(item.images[0])">
							<template #error>
								<u-icon name="photo" color="#999" size="50"></u-icon>
							</template>
						</u--image>
					</view>
				</view>
			</view>

			<view class="my-[20rpx] bg-white mx-[20rpx] rounded-[16rpx] px-[20rpx] pd-[10px]">
				<view class="text-[28rpx] h-[80rpx] leading-[80rpx] font-bold">商品详情</view>
				<view class="u-content">
					<u-parse :content="goodsDetail.goods.goods_desc" :tagStyle="{img: 'vertical-align: top;',p:'overflow: hidden;word-break:break-word;' }"></u-parse>
				</view>
			</view>
			
			<!-- tabber -->
			<view class="tab-bar-placeholder"></view>
			<view class="w-[100%] flex justify-between px-[27rpx] bg-[#fff] box-border fixed left-0 bottom-0 tab-bar">
				<view class="flex items-center">
					<view class="flex flex-col justify-center items-center mr-[39rpx]" @click="redirect({ url: '/addon/shop/pages/index', mode: 'reLaunch' })">
						<view class="iconfont iconshouye1 text-[42rpx]"></view>
						<text class="text-[18rpx] mt-1">首页</text>
					</view>
					<view class="flex flex-col justify-center items-center mr-[39rpx]">
						<view class="iconfont iconfenxiang3 text-[42rpx]"></view>
						<text class="text-[18rpx] mt-1">分享</text>
					</view>
					<view class="flex flex-col justify-center items-center" @click="redirect({ url: '/addon/shop/pages/goods/cart' })">
						<view class="relative flex items-center">
							<text class="iconfont icongouwuche3 text-[40rpx]"></text>
							<view v-if="cartTotalNum"
								:class="['absolute left-[26rpx] top-0 rounded-[25rpx] h-[25rpx] min-w-[25rpx] text-center leading-[25rpx] bg-[#FF4646] text-[#fff] text-[20rpx] font-500 box-border', cartTotalNum > 9 ? 'px-[10rpx]' : '']">
								{{ cartTotalNum }}
							</view>
						</view>
						<text class="text-[18rpx] mt-1">购物车</text>
					</view>
				</view>
				<view class="flex" v-if="goodsDetail.goods.status == 1">
					<button
						class="!w-[200rpx] !h-[72rpx] text-[26rpx] !text-[#fff] !m-0 !mr-[20rpx] leading-[72rpx] rounded-full remove-border"
						style="background: linear-gradient(127deg, #FFB000 0%, #FFA029 100%);" @click="buyFn('join_cart')">
						加入购物车</button>
					<button
						v-if="isShowSingleSku"
						class="!w-[200rpx] !h-[72rpx] text-[26rpx] !text-[#fff] !bg-[#FF4646] !m-0 leading-[72rpx] rounded-full remove-border"
						@click="buyFn('buy_now')">立即购买</button>
					<button
						v-else
						class="!w-[200rpx] !h-[72rpx] text-[26rpx] !text-[#fff] !bg-[#ccc] !m-0 leading-[72rpx] rounded-full remove-border"
						>已售罄</button>
				</view>
				<view class="flex flex-1 ml-[40rpx]" v-else>
					<button class="w-[100%] !h-[72rpx] text-[26rpx] !text-[#fff] !bg-[#ccc] !m-0 leading-[72rpx] rounded-full remove-border">该商品已下架</button>
				</view>
			</view>
			<!-- 服务 -->
			<view @touchmove.prevent.stop>
				<u-popup class="popup-type" :show="servicesDataShow" @close="servicesDataShow = false">
					<view class="min-h-[480rpx]">
						<view class="flex items-center justify-center py-[34rpx] relative">
							<text class="text-[32rpx] leading-[36rpx] font-500">商品服务</text>
							<view class="absolute right-[37rpx]  iconfont iconguanbi text-[36rpx]" @click="servicesDataShow = false"></view>
						</view>
						<scroll-view class="h-[520rpx]" scroll-y="true">
							<view class="pl-[22rpx] pt-[28rpx] pr-[37rpx]">
								<view class="flex mb-[28rpx]" v-for="(item, index) in goodsDetail.service">
									<image class="max-w-[34rpx] max-h-[34rpx] mr-[14rpx]" :src="img(item.image || 'addon/shop/icon_service.png')" mode="aspectFit" />
									<view class="flex-1">
										<view class="text-[26rpx] leading-[36rpx] text-[#222] mb-[4rpx] w-[643rpx]">{{ item.service_name }}</view>
										<view class="text-[22rpx] leading-[36rpx] text-[#888] w-[643rpx]">{{ item.desc }}</view>
									</view>
								</view>
							</view>
						</scroll-view>
						<view class="px-[32rpx] pb-[67rpx] pt-[42rpx]">
							<button
								class="!w-[100%] !h-[72rpx] text-[26rpx] !bg-[#FF4646]  !m-0  leading-[72rpx] rounded-full text-white"
								@click="servicesDataShow = false">确定</button>
						</view>
					</view>
				</u-popup>
			</view>
			<!-- 配送 -->
			<view @touchmove.prevent.stop>
				<u-popup class="popup-type" :show="distributionDataShow" @close="distributionDataShow = false">
					<view class="min-h-[360rpx]">
						<view class="flex items-center justify-center py-[34rpx] relative">
							<text class="text-[32rpx] leading-[36rpx] font-500">配送方式</text>
							<view class="absolute right-[37rpx]  iconfont iconguanbi text-[36rpx]" @click="distributionDataShow = false"></view>
						</view>
						<scroll-view class="h-[520rpx]" scroll-y="true">
							<view class="pl-[22rpx] pt-[28rpx] pr-[37rpx]">
								<view class="flex mb-[28rpx]" v-for="(item, index) in goodsDetail.delivery_type_list" @click="distributionListFn(item,index)">
									<image class="w-[34rpx] h-[34rpx] mr-[14rpx]" :src="img('addon/shop/icon_service.png')" mode="aspectFit" />
									<view class="flex-1">
										<view class="text-[26rpx] leading-[36rpx] text-[#222] mb-[4rpx]">{{ item }}</view>
										<view class="text-[22rpx] leading-[36rpx] text-[#888]">{{ item }}</view>
									</view>
								</view>
							</view>
						</scroll-view>
					</view>
				</u-popup>
			</view>
			<!-- 优惠券 -->
			<view @touchmove.prevent.stop>
				<u-popup class="popup-type" :show="couponListShow" @close="couponListShow = false">
					<view class="min-h-[480rpx]">
						<view class="flex items-center justify-center py-[34rpx] relative">
							<text class="text-[32rpx] leading-[36rpx] font-500">优惠券</text>
							<view class="absolute right-[37rpx]  iconfont iconguanbi text-[36rpx]" @click="couponListShow = false">
							</view>
						</view>
						<scroll-view class="h-[520rpx]" scroll-y="true">
							<view class="px-[20rpx]">
								<view
									class="mb-[30rpx] flex items-center border-[2rpx] border-solid border-[rgba(0,0,0,.1)] rounded"
									v-for="(item, index) in couponList" :key="index">
									<view
										class="flex flex-col items-center py-[20rpx] w-[240rpx] border-0 border-r-[2rpx] border-dashed border-[rgba(0,0,0,.1)]">
										<view class="text-xs price-font">
											<text class="text-[28rpx]">￥</text>
											<text class="text-[48rpx]">{{ item.price }}</text>
										</view>
										<text class="text-xs mt-[12rpx]">{{ Number(item.min_condition_money) ? ('满' + item.min_condition_money + '元可以使用') : '无门槛优惠券' }}</text>
									</view>
									<view class="ml-[20rpx] flex-1 flex flex-col py-[20rpx]">
										<text class="text-xs">{{ item.title }}</text>
										<text class="text-xs text-[#ABABAB] mt-[12rpx]">{{ item.valid_type == 1 &&
											('领取之日起' + item.length + '天内有效') || item.valid_type == 2 &&
											('领取之日起至' + item.valid_end_time) }}</text>
									</view>
									<text v-if="item.btnType === 'collecting'"
										class="bg-[var(--primary-color)] rounded-2xl text-[#fff] text-xs mr-[20rpx] py-[8rpx] px-[16rpx]"
										@click="getCouponFn(item, index)">领取</text>
									<text v-else
										class="!bg-[#fff] rounded-2xl text-[#ABABAB] text-xs mr-[20rpx] py-[8rpx] px-[16rpx]">{{
											item.btnType
											=== 'collected' ? '已领玩' : '已领取' }}</text>
								</view>
							</view>
						</scroll-view>
						<view class="px-[32rpx] pb-[67rpx] pt-[42rpx]">
							<button
								class="!w-[100%] !h-[72rpx] text-[26rpx] !bg-[var(--primary-color)] !text-[#fff] !m-0 rounded-full leading-[72rpx]"
								@click="couponListShow = false">确定</button>
						</view>
					</view>
				</u-popup>
			</view>
			<ns-goods-sku ref="goodsSkuRef" :goods-detail="goodsDetail" @change="specSelectFn"></ns-goods-sku>
		</view>
		<u-loading-page bg-color="rgb(248,248,248)" :loading="loading" loadingText="" fontSize="16" color="#303133"></u-loading-page>
	</view>
</template>

<script setup lang="ts">
import { ref, computed, getCurrentInstance, nextTick } from 'vue';
import { onLoad, onShow } from '@dcloudio/uni-app'
import { img, redirect } from '@/utils/common';
import { t } from '@/locale';
import { getGoodsDetail, collect, cancelCollect, getEvaluateList } from '@/addon/shop/api/goods';
import { getShopCouponList, getCoupon } from '@/addon/shop/api/coupon';
import nsGoodsSku from '@/addon/shop/components/ns-goods-sku/ns-goods-sku.vue';
import useCartStore from '@/addon/shop/stores/cart'
import { useLogin } from '@/hooks/useLogin'
import useMemberStore from '@/stores/member'
import { useShare }from '@/hooks/useShare'
import { onPageScroll } from '@dcloudio/uni-app';

// 分享
const{setShare,onShareAppMessage,onShareTimeline} = useShare()
onShareAppMessage()
onShareTimeline()

// 会员信息
const memberStore = useMemberStore()
const userInfo = computed(() => memberStore.info)

// 购物车数量
const cartStore = useCartStore();
let cartTotalNum = computed(() => cartStore.totalNum)

let goodsSkuRef = ref(null);
let goodsDetail = ref({});

let loading = ref<boolean>(false);
let servicesDataShow = ref<boolean>(false)
let distributionDataShow =  ref<boolean>(false) //配送
let couponListShow = ref<boolean>(false) //优惠券
onLoad((option) => {
	getGoodsDetail({
		goods_id: option.goods_id || '',
		sku_id: option.sku_id || '',
	}).then(res => {
		if (JSON.stringify(res.data) === '[]') {
			uni.showToast({ title: '找不到该商品', icon: 'none' })
			setTimeout(() => {
				redirect({ url: '/addon/shop/pages/index', mode: 'reLaunch' })
			}, 600)
			return false
		}

		goodsDetail.value = res.data;
		isCollect.value = goodsDetail.value.goods.is_collect;
		goodsDetail.value.delivery_type_list = goodsDetail.value.goods.delivery_type_list ? Object.values(goodsDetail.value.goods.delivery_type_list).map(el => el.name) : [];
		goodsDetail.value.goods.goods_image = goodsDetail.value.goods.goods_image_thumb_big;
		goodsDetail.value.goods.goods_image.forEach((item, index) => {
			goodsDetail.value.goods.goods_image[index] = img(item);
		})
		
		// 分享 - start
		if(res.data.goods){
			let share = {
				title: res.data.goods.goods_name,
				desc: res.data.goods.sub_title,
				url: res.data.goods.goods_cover_thumb_small
			}
			uni. setNavigationBarTitle({
				title: res.data.goods.goods_name
			})
			setShare({
				wechat:{
					...share
				},
				weapp:{
					...share
				}
			});
		}
		// 分享 - end

		// 获取优惠券列表
		getShopCouponListFn();

		// 获取评价
		getEvaluateListFn();

        nextTick(() => {
            setTimeout(()=>{
                const query = uni.createSelectorQuery().in(instance);
                query.select('.swiper-box').boundingClientRect(data => {
                    swiperHeight = data ? data.height : 0;
                }).exec();
                query.select('.detail-head').boundingClientRect(data => {
                    if(data) {
                        detailHead = data.height ? data.height : 0;
                    }
                }).exec();
            }, 400)
        })
	})
})

onShow(() => {
	// 删除配送方式
	uni.removeStorageSync('distributionType');
	cartStore.getList();
})

const specSelectFn = (id) => {
	goodsDetail.value.skuList.forEach((item, index) => {
		if (item.sku_id == id) {
			Object.assign(goodsDetail.value, item);
		}
	})
}

// 判断单规格库存是否为0
const isShowSingleSku = computed(() => {
	let isSingleSpec = false // 是否为单规格，true：多规格，false：单规格
	goodsDetail.value.skuList.forEach((item,index)=>{
		if(item.sku_spec_format){
			isSingleSpec = true
		}
	})

	// 单规格，库存为0，显示已售罄
	if(!isSingleSpec && goodsDetail.value.stock <= 0){
	    return false;
	}else if(!isSingleSpec && goodsDetail.value.stock > 0){
	    // 单规格，库存大于0，可以购买
        return true;
    }
	return true;
})

const buyFn = (type) => {
	goodsSkuRef.value.open(type)
}

// 收藏
let isCollect = ref(0);
const collectFn = () => {
	// 检测是否登录
	if (!userInfo.value) {
		useLogin().setLoginBack({ url: '/addon/shop/pages/goods/detail', param: { sku_id: goodsDetail.value.sku_id } })
		return false
	}
	let api = isCollect.value ? cancelCollect(goodsDetail.value.goods_id) : collect(goodsDetail.value.goods_id);
	api.then(res => {
		isCollect.value = !isCollect.value;
		if (isCollect.value) {
			uni.showToast({
				title: '收藏成功',
				icon: 'none'
			});
		} else {
			uni.showToast({
				title: '取消收藏',
				icon: 'none'
			});
		}
	})
}

// 优惠券
let couponList = ref([]);
const getShopCouponListFn = () => {
	getShopCouponList({
		category_id: goodsDetail.value.goods.goods_category || '',
		goods_id: goodsDetail.value.goods_id || ''
	}).then(res => {
		couponList.value = res.data.data.map((el: any) => {
			if (el.sum_count != -1 && el.receive_count === el.sum_count) {
				el.btnType = 'collected'//已领完
			}
			if (!userInfo.value) {
				el.btnType = 'collecting'//领用
			} else {
				if (el.is_receive && el.limit_count === el.member_receive_count) {
					el.btnType = 'using'//去使用
				} else {
					el.btnType = 'collecting'//领用
				}
			}
			return el
		});
	})
}

// 领取优惠券
const getCouponFn = (data, index) => {
	// 检测是否登录
	if (!userInfo.value) {
		useLogin().setLoginBack({ url: '/addon/shop/pages/goods/detail', param: { sku_id: goodsDetail.value.sku_id } })
		return false
	}
	getCoupon({
		coupon_id: data.id || '',
		number: 1,
	}).then(res => {
		couponList.value[index].btnType = 'using'
	})
}

// 获取评价
const evaluate = ref({
	count : 0
})
const getEvaluateListFn = () => {
	getEvaluateList(goodsDetail.value.goods_id).then(res => {
		evaluate.value = res.data
	})
}
//进入评论
const toLink = () => {
	redirect({ url: '/addon/shop/pages/evaluate/list', param: { goods_id: goodsDetail.value.goods_id } })
}

//预览图片
const imgListPreview = (item) => {
	if (item === '') return false
	var urlList = []
	urlList.push(img(item))  //push中的参数为 :src="item.img_url" 中的图片地址
	uni.previewImage({
		indicator: "number",
		loop: true,
		urls: urlList
	})
}


// 返回上一页
const goback=()=> {
	uni.navigateBack({
		delta: 1
	});
}

/************ 选择配送方式-start ****************/ 
const selectDeliveryType = ref(0);
const distributionDataOpen = (()=>{
	distributionDataShow.value = true;
});
const distributionListFn = ((data,index)=>{
	selectDeliveryType.value =  index;
	distributionDataShow.value = false;
	uni.setStorageSync('distributionType', data);
});
/************ 选择配送方式-end ****************/ 


/************ 自定义头部-start ****************/ 
// 获取系统状态栏的高度
let systemInfo = uni.getSystemInfoSync();
let platform = systemInfo.platform;
let menuButtonInfo = {};
// 如果是小程序，获取右上角胶囊的尺寸信息，避免导航栏右侧内容与胶囊重叠(支付宝小程序非本API，尚未兼容)
// #ifdef MP-WEIXIN || MP-BAIDU || MP-TOUTIAO || MP-QQ
menuButtonInfo = uni.getMenuButtonBoundingClientRect();
// #endif


// 导航栏内部盒子的样式
const navbarInnerStyle = computed(() => {
	let style = '';
	// 导航栏宽度，如果在小程序下，导航栏宽度为胶囊的左边到屏幕左边的距离
	// #ifdef MP
	let rightButtonWidth = menuButtonInfo.width ? menuButtonInfo.width * 2 + 'rpx' : '70rpx';
	style += 'height:' + menuButtonInfo.height + 'px;';
	style += 'padding-right:calc(' + rightButtonWidth + ' + 30rpx);';
	style += 'padding-left:calc(' + rightButtonWidth + ' + 30rpx);';
	style += 'padding-top:' + menuButtonInfo.top + 'px;';
	style += 'padding-bottom: 8px;';
	
	style += 'font-size: 32rpx;';
	if (platform === 'ios') {
		// 苹果(iOS)设备
		style += 'font-weight: 500;';
	} else if (platform === 'android') {
	  // 安卓(Android)设备
		style += 'font-size: 36rpx;';
	}
	// #endif
	
	// #ifdef H5
	style += 'height: 100rpx;';
	style += 'padding-right: 30rpx;';
	style += 'padding-left: 30rpx;';
	
	style += 'font-size: 32rpx;';
	if (platform === 'ios') {
		// 苹果(iOS)设备
		style += 'font-weight: 500;';
	} else if (platform === 'android') {
	  // 安卓(Android)设备
		style += 'font-size: 36rpx;';
	}
	// #endif
	return style;
})

// 导航栏内部盒子的样式
const navbarInnerArrowStyle = computed(() => {
	let style = '';
	// 导航栏宽度，如果在小程序下，导航栏宽度为胶囊的左边到屏幕左边的距离
	// #ifdef MP
	style += "padding-left: 10rpx;"
	style += "padding-right: 10rpx;"
	style += 'position: absolute;';
	style += 'left:calc( 100vw - ' + menuButtonInfo.right + 'px);';
	style += 'font-size: 32rpx;';
	style += 'font-weight: bold;';
	if (platform === 'ios') {
		// 苹果(iOS)设备
		style += 'font-weight: 700;';
	} else if (platform === 'android') {
	  // 安卓(Android)设备
	  
	}
	// #endif
	return style;
})

// 头部滚动
const instance = getCurrentInstance();
let swiperHeight = 0
let detailHead = 0

let detailHeadBgChange = ref(false)
onPageScroll((e)=>{
	let height = swiperHeight - detailHead - 20;
	detailHeadBgChange.value = false;
	if(e.scrollTop >= height){
		detailHeadBgChange.value = true;
	}
})
/************ 自定义头部-end ****************/ 
</script>
<style lang="scss" scoped>
	.remove-border {
		&::after {
			border: none;
		}
	}
:deep(.u-cell-group__wrapper) {
	.u-cell__body {
		padding: 23rpx 32rpx;
	}
}

.popup-type {
	:deep(.u-popup__content) {
		border-top-left-radius: 16rpx;
		border-top-right-radius: 16rpx;
		overflow: hidden;
	}
}


.tab-bar-placeholder {
	padding-bottom: calc(constant(safe-area-inset-bottom) + 100rpx);
	padding-bottom: calc(env(safe-area-inset-bottom) + 100rpx);
}

.tab-bar {
	padding-top: 16rpx;
	padding-bottom: calc(constant(safe-area-inset-bottom) + 16rpx);
	padding-bottom: calc(env(safe-area-inset-bottom) + 16rpx);
}
</style>
