<template>
	<view class="bg-[#F6F6F6] min-h-screen overflow-hidden" :style="themeColor()">
		<view class="coupon-header">
			<!-- #ifndef H5 -->
			<view :style="{height: headStyle, backgroundImage: 'url(' + img('addon/shop/coupon/coupn_uniapp.png') + ')',backgroundSize: '100% 100%', backgroundRepeat: 'no-repeat'}">
				<!-- #ifdef MP-WEIXIN -->
				<top-tabbar :data="param" titleColor="#fff" class="top-header"/>
				<!-- #endif -->
				<view class="px-[38rpx] pt-[98rpx]">
					<view class="font-bold text-[36rpx] text-[#fff] leading-[42rpx]">领劵中心</view>
					<view class="mt-[10rpx] font-400 text-[24rpx] text-[#fff] leading-[28rpx]">天天来领券，优惠看得见</view>
				</view>
			</view>
			<!-- #endif -->
			<!-- #ifdef H5 -->
			<view class="h-[352rpx]" :style="{ backgroundImage: 'url(' + img('addon/shop/coupon/coupn_h5.png') + ')',backgroundSize: '100%', backgroundRepeat: 'no-repeat'}">
				<view class="px-[38rpx] pt-[98rpx]">
					<view class="font-bold text-[36rpx] text-[#fff] leading-[42rpx]">领劵中心</view>
					<view class="mt-[10rpx] font-400 text-[24rpx] text-[#fff] leading-[28rpx]">天天来领券，优惠看得见</view>
				</view>
			</view>
			<!-- #endif -->
		</view>
		<view class="-mt-[74rpx] bg-[#F6F6F6] rounded-tl-[26rpx] rounded-tr-[26rpx]">
			<mescroll-body ref="mescrollRef"  @init="mescrollInit" :down="{ use: false }" @up="getShopCouponListFn">
				<view class="py-[30rpx] px-[30rpx]">
					<template v-for="(item, index) in list">
						<view v-if="item.btnType === 'collected'"
							class="flex items-center relative w-[100%] rounded-[20rpx] overflow-hidden bg-[#fff] py-[22rpx] background-size"
							:class="{'mt-[20rpx]':index}" :style="{ backgroundImage: 'url(' + img('addon/shop/coupon/coupn_loot.png') + ')'}" @click="toDetail(item.id)" >
							<view class="box-border flex-1 border-0 border-r-[1px] border-[#FFDCDC] border-dashed flex items-center">
								<view class="pl-[40rpx] w-[200rpx] box-border">
									<view class="price-font flex items-baseline text-[var(--primary-color)]">
										<text class="text-[36rpx] mr-[4rpx] leading-[45rpx] text-center font-500">￥</text>
										<text class="text-[54rpx] font-semibold text-left leading-[70rpx] truncate">{{ item.coupon_price }}</text>
									</view>
								</view>
								<view class="flex-1 box-border ml-[10rpx]">
									<view class="text-[30rpx] leading-[35rpx] text-left font-500">
										<text v-if="item.min_condition_money === '0.00'">无门槛</text>
										<text v-else>满{{ item.coupon_min_price }}元可用</text>
									</view>
									<view class="text-[20rpx] leading-[23rpx] mt-[4px] text-left flex items-center">
										<text class="bg-[var(--primary-color)] whitespace-nowrap text-[#fff] text-[20rpx] h-[28rpx] leading-[28rpx] px-[10rpx] rounded-[16rpx] mr-[6rpx] shrink-0">{{ item.type_name }}</text>
										<text class="truncate max-w-[190rpx] leading-[1.3]">{{ item.title }}</text>
									</view>
									<view class="w-[100%] mt-[4px] text-[20rpx] leading-[23rpx]">
										<text v-if="item.valid_type == 1">领取之日起{{ item.length || '' }}天内有效</text>
										<text v-else> 有效期至{{ item.valid_end_time ? item.valid_end_time.slice(0, 10) : '' }}</text>
									</view>
								</view>
							</view>
							<view class="pr-[20rpx] pl-[30rpx]">
								<u-button text="已领完"  :customStyle="{width:'150rpx',height:'60rpx',color:'#fff', fontSize:'24rpx',lineHeight:'60rpx', padding:'0',backgroundColor:'var(--primary-color)', opacity :'0.6',border:'none'}"  shape="circle"  disabled></u-button>
							</view>
							<view class="absolute top-0 right-[190rpx]  h-[10rpx] w-[20rpx] rounded-br-[20rpx] rounded-bl-[20rpx] bg-[#F6F6F6] "></view>
							<view class="absolute bottom-0 right-[190rpx] h-[10rpx] w-[20rpx] rounded-tr-[20rpx] rounded-tl-[20rpx] bg-[#F6F6F6]"></view>
						</view>
						<view v-else class ="flex items-center relative w-[100%] rounded-[20rpx] overflow-hidden bg-[#fff] py-[22rpx] background-size"
							:class="{'mt-[20rpx]':index}" @click="toDetail(item.id)" :style="{ backgroundImage: item.btnType === 'using' ? ('url(' + img('addon/shop/coupon/coupn_bg.png') + ')') : 'none' }">
							<view class="relative box-border flex-1 border-0 border-r-[1px] border-[#FFDCDC] border-dashed flex items-center">
								<view class="pl-[40rpx] w-[200rpx] box-border">
									<view class="price-font flex items-baseline text-[var(--primary-color)]">
										<text class="text-[38rpx] mr-[4rpx] leading-[45rpx] text-center font-500">￥</text>
										<text class="text-[56rpx] font-semibold text-left leading-[70rpx] truncate">{{ item.coupon_price }}</text>
									</view>
								</view>
								<view class="flex-1 box-border ml-[10rpx]">
									<view class="text-[30rpx] leading-[35rpx] text-left font-500">
										<text v-if="item.min_condition_money === '0.00'">无门槛</text>
										<text v-else>满{{ item.coupon_min_price }}元可用</text>
									</view>
									<view class="text-[20rpx] leading-[23rpx] mt-[4px] text-left flex items-center">
										<text class="bg-[var(--primary-color)] whitespace-nowrap text-[#fff] text-[20rpx] h-[28rpx] leading-[28rpx] px-[10rpx] rounded-[16rpx] mr-[6rpx] shrink-0">{{ item.type_name }}</text>
										<text class="truncate max-w-[190rpx] leading-[1.3]">{{ item.title }}</text>
									</view>
									<view class="w-[100%] mt-[4px] text-[20rpx] leading-[23rpx]">
										<text v-if="item.valid_type == 1">领取之日起<text>{{ item.length || '' }}</text>天内有效</text>
										<text v-else> 有效期至<text>{{ item.valid_end_time ? item.valid_end_time.slice(0, 10) : '' }}</text></text>
									</view>
								</view>
							</view>
							<view v-if="item.btnType === 'collecting'" @click.stop="collecting(item.id, index)" class="pr-[20rpx] pl-[30rpx]">
								<u-button text="立即领取" :customStyle="{width:'150rpx',height:'60rpx',color:'#fff', fontSize:'24rpx',lineHeight:'60rpx', padding:'0', backgroundColor:'var(--primary-color)',border:'none'}"  shape="circle"></u-button>
							</view>
							<view v-if="item.btnType === 'using'" @click.stop="toLink(item.id)" class="pr-[20rpx] pl-[30rpx]">
								<u-button text="去使用" :customStyle="{width:'150rpx',height:'60rpx',color:'var(--primary-color)', fontSize:'24rpx',lineHeight:'60rpx', padding:'0',backgroundColor:'transparent',border:'2rpx solid var(--primary-color)'}"  shape="circle" ></u-button>
							</view>

							<view class="absolute top-0 right-[190rpx]  h-[10rpx] w-[20rpx] rounded-br-[20rpx] rounded-bl-[20rpx] bg-[#F6F6F6] "></view>
							<view class="absolute bottom-0 right-[190rpx] h-[10rpx] w-[20rpx] rounded-tr-[20rpx] rounded-tl-[20rpx] bg-[#F6F6F6]"></view>
						</view>
					</template>
					<view  v-if="!list.length && !loading" class="noData bg-[#fff] rounded-[20rpx] flex items-center justify-center">
						<mescroll-empty :option="{tip : '暂无优惠券'}"></mescroll-empty>
					</view>
				</view>
			</mescroll-body>
		</view>
	</view>
</template>

<script setup lang="ts">
import { ref, computed,nextTick, getCurrentInstance } from 'vue'
import { img, redirect } from '@/utils/common'
import { getShopCouponList, getCoupon } from '@/addon/shop/api/coupon'
import MescrollBody from '@/components/mescroll/mescroll-body/mescroll-body.vue'
import MescrollEmpty from '@/components/mescroll/mescroll-empty/mescroll-empty.vue'
import useMescroll from '@/components/mescroll/hooks/useMescroll.js'
import { onPageScroll, onReachBottom } from '@dcloudio/uni-app'
import useMemberStore from '@/stores/member'
import { useLogin } from '@/hooks/useLogin'
import { t } from '@/locale'

const { mescrollInit, downCallback, getMescroll } = useMescroll(onPageScroll, onReachBottom)
// 获取系统状态栏的高度
let menuButtonInfo = {};
// 如果是小程序，获取右上角胶囊的尺寸信息，避免导航栏右侧内容与胶囊重叠(支付宝小程序非本API，尚未兼容)
// #ifdef MP-WEIXIN || MP-BAIDU || MP-TOUTIAO || MP-QQ
menuButtonInfo = uni.getMenuButtonBoundingClientRect();
// #endif
let param = ref({
	title:'优惠券列表',
	topStatusBar: {
		style: 'style-1',
        isTransparent: true,
		bgColor: 'transparent',
        rollBgColor: '#fff',
		textColor: '#fff'
	}
})
const headStyle = computed(() => {
	let style = (Number(menuButtonInfo.height) * 2 + menuButtonInfo.top * 2 +  368) + 'rpx;'
	return style
})

// 头部滚动

// #ifndef  H5
const instance = getCurrentInstance();
let couponHeight = 0
let topHead = 0
nextTick(()=>{
	setTimeout(()=>{
	const query = uni.createSelectorQuery().in(instance);
	query.select('.coupon-header').boundingClientRect(data => {
		couponHeight = data.height;
	}).exec();
	query.select('.top-header').boundingClientRect(data => {
		topHead = data.height;
	}).exec();
}, 300)
})
onPageScroll((e)=>{
	let height = couponHeight - topHead - 37;
	param.value.tabbarBg = 'transparent'
	if(e.scrollTop >= height){
		param.value.tabbarBg = 'var(--primary-color)'
	}
})
// #endif

const list = ref<Array<Object>>([]);
const loading = ref<boolean>(true);
const memberStore = useMemberStore()
const userInfo = computed(() => memberStore.info)

const getShopCouponListFn = (mescroll) => {
	loading.value = true;
	let data: object = {
		page: mescroll.num,
		limit: mescroll.size,
	};

	getShopCouponList(data).then((res) => {
		let newArr = (res.data.data as Array<Object>).map((el: any) => {
			if (el.sum_count != -1 && el.receive_count === el.sum_count) {
				el.btnType = 'collected'//已领完
			}else if (!userInfo.value) {
				el.btnType = 'collecting'//领用
			} else {
				if (el.is_receive && el.limit_count === el.member_receive_count) {
					el.btnType = 'using'//去使用
				} else {
					el.btnType = 'collecting'//领用
				}
			}
			return el
		})
		//设置列表数据
		if (mescroll.num == 1) {
			list.value = []; //如果是第一页需手动制空列表
		}
		list.value = list.value.concat(newArr);
		mescroll.endSuccess(newArr.length);
		loading.value = false;
	}).catch(() => {
		loading.value = false;
		mescroll.endErr(); // 请求失败, 结束加载
	})
}
const collecting = (coupon_id: any, index: number) => {
	if (!userInfo.value) {
		useLogin().setLoginBack({ url: '/addon/shop/pages/coupon/list' })
		return false
	}
	getCoupon({ coupon_id, number: 1,type:'receive'  }).then(res => {
		if(res.code > 0){
			list.value[index].member_receive_count += 1
			list.value[index].receive_count += 1
			if(list.value[index].member_receive_count == list.value[index].limit_count
			|| (list.value[index].sum_count != -1 && list.value[index].receive_count === list.value[index].sum_count)
			){
				list.value[index].btnType = 'using'
			}
		}
		
	})
}
const toDetail = (id: any) => {
	redirect({ url: '/addon/shop/pages/coupon/detail', param: { coupon_id: id } })
}
const toLink = (id: any) => {
	redirect({ url: '/addon/shop/pages/goods/list', param: { coupon_id: id } })
}
</script>

<style lang="scss" scoped>
.background-size{
	background-repeat: no-repeat;
	background-position: right top;
	background-size: 27%;
}
.remove-border {
	 &::after {
		 border: none;
	 }
 }
 .noData{
	height: calc(100vh - 338rpx - constant(safe-area-inset-bottom));
	height: calc(100vh - 338rpx - env(safe-area-inset-bottom));
 }
</style>