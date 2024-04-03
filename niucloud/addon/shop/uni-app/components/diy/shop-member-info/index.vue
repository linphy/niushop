<template>
	<view :style="warpCss">
		<view class="px-[30rpx] pt-[30rpx] pb-[119rpx] box-border">
			<!-- #ifdef MP-WEIXIN -->
			<view :style="navbarInnerStyle" class="flex items-center justify-center fixed left-0 right-0 z-10 top-0"></view>
			<!-- 解决fixed定位后导航栏塌陷的问题 -->
			<view :style="navbarInnerStyle"></view>
			<!-- #endif -->
			<view v-if="info" class="flex items-center">
				<!-- 唤起获取微信 -->
				<u-avatar :src="img(info.headimg)" :size="'100rpx'" leftIcon="none" @click="clickAvatar"></u-avatar>
				<view class="ml-[20rpx] flex-1">
					<view class="text-[#ffffff] flex items-end" :style="{ color : diyComponent.textColor }">
						<view class="text-[32rpx] font-bold leading-[38rpx]">{{ info.nickname }}</view>
						<view class="text-[24rpx] font-400 leading-[28rpx] ml-[10rpx]" v-if="info.mobile">{{info.mobile.replace(info.mobile.substring(3,7), "****")}}</view>
					</view>
					<view class="text-[#ffffff] text-[24rpx] font-400 leading-[28rpx] mt-[6rpx]" :style="{ color : diyComponent.textColor }">UID：{{ info.member_no }}</view>
				</view>
				<view @click="redirect({ url: '/app/pages/setting/index' })">
					<text class="iconfont iconshezhi1 text-[34rpx] ml-[10rpx]" :style="{ color : diyComponent.textColor }"></text>
				</view>
			</view>
			<view v-else class="flex ml-[32rpx] mr-[52rpx]  items-center" @click="toLogin">
				<u-avatar src="" :size="'100rpx'"></u-avatar>
				<view class="ml-[20rpx] flex-1">
					<view class="text-[32rpx] font-bold leading-[38rpx]" :style="{ color : diyComponent.textColor }">
						{{ t('login') }}/{{ t('register') }}
					</view>
				</view>
				<view @click="redirect({ url: '/app/pages/setting/index' })">
					<text class="iconfont iconshezhi1 text-[34rpx] ml-[10rpx]" :style="{ color : diyComponent.textColor }"></text>
				</view>
			</view>

			<view class="flex mt-[30rpx] items-center">
				<view class="text-center w-[33.333%] flex-shrink-0">
					<view class="text-[36rpx] leading-[42rpx] h-[50rpx] font-500">
						<view @click="redirect({ url: info ? '/app/pages/member/balance' : '' })" :style="{ color : diyComponent.textColor }">{{ money }}</view>
					</view>
					<view class="text-[22rpx] leading-[26rpx] h-[31rpx] font-400">
						<view @click="redirect({ url: info ? '/app/pages/member/balance' : '' })" :style="{ color : diyComponent.textColor }">{{ t('balance') }}</view>
					</view>
				</view>
				<view class="text-center w-[33.333%] flex-shrink-0">
					<view class="text-[36rpx] leading-[42rpx] h-[50rpx] font-500">
						<view @click="redirect({ url: info ? '/app/pages/member/point' : '' })" :style="{ color : diyComponent.textColor }">{{ parseInt(info?.point) || 0 }}</view>
					</view>
					<view class="text-[22rpx] leading-[26rpx] h-[31rpx] font-400">
						<view @click="redirect({ url: info ? '/app/pages/member/point' : '' })" :style="{ color : diyComponent.textColor }">{{ t('point') }}</view>
					</view>
				</view>
				<view class="text-center w-[33.333%] flex-shrink-0"  @click="redirect({ url: couponCount ? '/addon/shop/pages/member/my_coupon' : '' })">
					<view class="text-[36rpx] leading-[42rpx] h-[50rpx] font-500">
						<view :style="{ color : diyComponent.textColor }">{{ couponCount }}</view>
					</view>
					<view class="text-[22rpx] leading-[26rpx] h-[31rpx] font-400">
						<view  :style="{ color : diyComponent.textColor }">{{ t('coupon') }}</view>
					</view>
				</view>
			</view>
		</view>
		<view class="w-[690rpx] mx-auto mt-[-91rpx] bg-[#fff] rounded-[16rpx] overflow-hidden">
			<view class="h-[91rpx] flex box-border items-center justify-between px-[30rpx]">
				<view class="text-[32rpx] font-400 text-[#303133]"> {{t('orderCenter')}}</view>
				<view class="flex items-center">
					<view class="text-[26rpx] text-[#666666] font-400 mr-[10rpx]" @click="toShopOrder('')">{{t('orderAll')}}</view>
					<u-icon name="arrow-right" color="#666666" :size="'18rpx'"></u-icon>
				</view>
			</view>
			<view class="flex items-center pt-[14rpx] pb-[30rpx]">
				<view class="flex-1 text-center" @click="toShopOrder('1')">
					<image class="w-[44rpx] h-[44rpx]" :src="img('addon/shop/diy/member/order1.png')"  mode="aspectFill" />
					<view class="text-[24rpx] leading-[28rpx] h-[34rpx] mt-[14rpx] text-[#303133]">{{ t('obligation') }}</view>
				</view>
				<view class="flex-1 text-center" @click="toShopOrder('2')">
					<image class="w-[44rpx] h-[44rpx]" :src="img('addon/shop/diy/member/order2.png')"  mode="aspectFill" />
					<view class="text-[24rpx] leading-[28rpx] h-[34rpx] mt-[14rpx] text-[#303133]">{{ t('toBeShipped') }}</view>
				</view>
				<view class="flex-1 text-center" @click="toShopOrder('3')">
					<image class="w-[44rpx] h-[44rpx]" :src="img('addon/shop/diy/member/order3.png')"  mode="aspectFill" />
					<view class="text-[24rpx] leading-[28rpx] h-[34rpx] mt-[14rpx] text-[#303133]">{{ t('toBeReceived') }}</view>
				</view>
				<view class="flex-1 text-center" @click="toShopOrder('5')">
					<image class="w-[44rpx] h-[44rpx]" :src="img('addon/shop/diy/member/order4.png')"  mode="aspectFill" />
					<view class="text-[24rpx] leading-[28rpx] h-[34rpx] mt-[14rpx] text-[#303133]">{{ t('toBeEvaluated') }}</view>
				</view>
				<view class="flex-1 text-center" @click="redirect({ url : '/addon/shop/pages/refund/list' })">
					<image class="w-[44rpx] h-[44rpx]" :src="img('addon/shop/diy/member/order5.png')"  mode="aspectFill" />
					<view class="text-[24rpx] leading-[28rpx] h-[34rpx] mt-[14rpx] text-[#303133]">{{ t('refund') }}</view>
				</view>
			</view>
		</view>
		<!-- #ifdef MP-WEIXIN -->
		<information-filling ref="infoFill"></information-filling>
		<!-- #endif -->
	</view>
</template>

<script lang="ts" setup>
	import { computed, ref, watch } from 'vue'
	import useMemberStore from '@/stores/member'
	import { useLogin } from '@/hooks/useLogin'
	import { getMyCouponCount } from '@/addon/shop/api/coupon'
	import { img, isWeixinBrowser, redirect, urlDeconstruction, moneyFormat } from '@/utils/common'
	import { t } from '@/locale'
	import { wechatSync } from '@/app/api/system'
	import useDiyStore from '@/app/stores/diy'

	const props = defineProps(['component', 'index', 'pullDownRefreshCount']);

	const diyStore = useDiyStore();

	const diyComponent = computed(() => {
		if (diyStore.mode == 'decorate') {
			return diyStore.value[props.index];
		} else {
			return props.component;
		}
	})
	const warpCss = computed(() => {
		var style = '';
        if(diyComponent.value.componentStartBgColor) {
            if (diyComponent.value.componentStartBgColor && diyComponent.value.componentEndBgColor) style += `background:linear-gradient(${diyComponent.value.componentGradientAngle},${diyComponent.value.componentStartBgColor},${diyComponent.value.componentEndBgColor});`;
            else style += 'background-color:' + diyComponent.value.componentStartBgColor + ';';
        }
		if (diyComponent.value.bgUrl) {
			style += 'background-image:url(' + img(diyComponent.value.bgUrl) + ');';
			style += 'background-size: 100%;';
			style += 'background-repeat: no-repeat;';
		}
		if (diyComponent.value.topRounded) style += 'border-top-left-radius:' + diyComponent.value.topRounded * 2 + 'rpx;';
		if (diyComponent.value.topRounded) style += 'border-top-right-radius:' + diyComponent.value.topRounded * 2 + 'rpx;';
		if (diyComponent.value.bottomRounded) style += 'border-bottom-left-radius:' + diyComponent.value.bottomRounded * 2 + 'rpx;';
		if (diyComponent.value.bottomRounded) style += 'border-bottom-right-radius:' + diyComponent.value.bottomRounded * 2 + 'rpx;';

		return style;
	})

	watch(
		() => props.pullDownRefreshCount,
		(newValue, oldValue) => {
			// 处理下拉刷新业务
		}
	)

	const memberStore = useMemberStore()

	// #ifdef H5
	const { query } = urlDeconstruction(location.href)
	if (query.code && isWeixinBrowser()) {
		wechatSync({ code: query.code }).then(res => {
			memberStore.getMemberInfo()
		})
	}
	// #endif

	const info = computed(() => {
		// 装修模式
		if (diyStore.mode == 'decorate') {
			return {
				headimg: '',
				nickname: '昵称',
				balance: 0,
				point: 0,
				money: 0,
				mobile:'155****0549',
				member_no: 'NIU0000021'
			}
		} else {
			getMyCouponCountFn()
			return memberStore.info;
		}
	})

	const money = computed(() => {
		if (info.value) {
			let m = parseFloat(info.value.balance) + parseFloat(info.value.money)
			return moneyFormat(m.toString());
		} else {
			return 0;
		}
	})

	const toLogin = () => {
		useLogin().setLoginBack({ url: '/app/pages/member/index' })
	}

	const infoFill = ref(false)
	const clickAvatar = () => {
		// #ifdef MP-WEIXIN
		infoFill.value.show = true
		// #endif

		// #ifdef H5
		if (isWeixinBrowser()) {
			useLogin().getAuthCode('snsapi_userinfo')
		} else {
			redirect({ url: '/app/pages/member/personal' })
		}
		// #endif
	}
	const toShopOrder = (status:any)=>{
		redirect({ url: '/addon/shop/pages/order/list',param:{status} })
	}
	const couponCount = ref(0)
	const getMyCouponCountFn= async()=>{
		try {
			const res = await getMyCouponCount({status:1})
			couponCount.value = res.data
		} catch (e){
			couponCount.value = 0
		}
			
	}
	
	
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
	style += 'padding-top:' + (menuButtonInfo.top-15) + 'px;';
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
	console.log("style",style);
	return style;
})
</script>

<style lang="scss" scoped>
</style>
