<template>
	<view :style="themeColor()">
		<view
				v-if="Object.keys(detail).length&&!loading"
				class="overflow-hidden min-h-screen bg-style relative"
				:style="{ 'background': 'url(' + img('addon/shop/coupon/coupon_bg.png') + ') no-repeat' }">
			<!-- #ifdef MP -->
			<top-tabbar :data="topTabbarData" title-color="#fff" />
			<!-- #endif -->
			<view class="relative mt-[236rpx] w-[100%] h-[932rpx]" :style="{ 'background': 'url(' + img('addon/shop/coupon/coupon_bg_02.png') + ') center / contain no-repeat' }">
				<view v-if="detail.limit_count"
				      :style="{ 'background': 'url(' + img('addon/shop/coupon/top_tab.png') + ') center / cover no-repeat', 'transform': 'translateX(-50%)'}"
				      class="text-[32rpx] leading-[56rpx] -top-[2rpx] left-[50%] px-[30rpx] box-border justify-center absolute min-w-[196rpx] h-[56rpx] flex items-center text-[#fff]">
					限领{{ detail.limit_count }}张
				</view>
				<view class="text-[120rpx] text-color text-center price-font flex justify-center pt-[140rpx]">
					<text class="leading-[1] max-w-[380rpx] -mt-[32rpx] truncate">{{ detail.coupon_price || 0.00 }}</text>
					<text class="text-[50rpx] ml-[4rpx] mt-[4rpx] text-[#F7D894] bg-[var(--primary-color)] rounded-full w-[70rpx] h-[70rpx] leading-[68rpx]">元</text>
				</view>
				<view class="text-[42rpx] text-[#E22D17] mt-[24rpx] text-center">
					<text v-if="detail.min_condition_money === '0.00'">无门槛</text>
					<text v-else>满{{ detail.coupon_min_price }}元可用</text>
				</view>
				<view class="text-[28rpx] text-[#E22D17] mt-[60rpx] text-center">
					<text v-if="detail.valid_type == 1">领取之日起
						<text>{{ detail.length}}</text>
						天内有效
					</text>
					<text v-else> 有效期至
						<text>{{ detail.valid_end_time ? detail.valid_end_time.slice(0, 10) : '' }}</text>
					</text>
				</view>
				<view class="flex justify-center items-center mt-[24rpx]">
					<text v-if="detail.btnType === 'collected'"
					      class="!leading-[98rpx] text-center text-[#999] text-[50rpx] min-w-[240rpx] h-[100rpx]"
					      :style="{ 'background': 'url(' + img('addon/shop/coupon/coupon_btn_02.png') + ')  center / contain no-repeat' }"
					>已领完
					</text>
					<text v-if="detail.btnType === 'collecting'"
					      class="!leading-[98rpx] text-center text-[#E22D17] text-[50rpx] min-w-[240rpx] h-[100rpx]"
					      :style="{ 'background': 'url(' + img('addon/shop/coupon/coupon_btn.png') + ') center / contain no-repeat' }"
					      @click="collecting(detail.id)">领取
					</text>
					<text v-if="detail.btnType === 'using'"
					      class="!leading-[98rpx] text-center text-[#E22D17] text-[50rpx] min-w-[240rpx] h-[100rpx]"
					      :style="{ 'background': 'url(' + img('addon/shop/coupon/coupon_btn.png') + ') center / contain no-repeat' }"
					      @click="toLink(detail.id)">去使用
					</text>
				</view>
				<view class="w-[230rpx] h-[230rpx] box-border p-[14rpx] bg-[#fff] mx-[auto] mt-[50rpx]">
					<image class="w-[200rpx] h-[200rpx]" :src="codeUrl" mode="aspectFill" />
				</view>
				<view class="text-[28rpx] text-[rgba(255,255,255,0.7)] mt-[30rpx] text-center">注:扫描二维码或点击右上角进行分享</view>
			</view>

		</view>
		<u-loading-page bg-color="rgb(248,248,248)" :loading="loading" loadingText="" fontSize="16" color="#303133"></u-loading-page>
	</view>
</template>
<script lang="ts" setup>
    import { ref, computed } from 'vue'
    import { onLoad } from '@dcloudio/uni-app'
    import { img, redirect, handleOnloadParams } from '@/utils/common'
    import QRCode from "qrcode";
    import { getShopCouponInfo, getCoupon, getShopCouponQrocde } from '@/addon/shop/api/coupon'
    import useMemberStore from '@/stores/member'
    import { useLogin } from '@/hooks/useLogin'

    const loading = ref(false)
    const codeUrl = ref('')
    const detail = ref({})
    const memberStore = useMemberStore()
    const userInfo = computed(() => memberStore.info)

    let topTabbarData = ref({
        title: '优惠券详情',
        topStatusBar: {
            style: 'style-1',
            isTransparent: true,
            bgColor: 'transparent',
            textColor: '#fff'
        }
    })
    onLoad((option) => {

        // #ifdef MP-WEIXIN
        // 处理小程序场景值参数
        option = handleOnloadParams(option);
        // #endif

        if (!option.coupon_id) {
            uni.showToast({ title: '优惠券不存在', icon: 'none' })
            setTimeout(() => {
                redirect({ url: '/addon/shop/pages/index', mode: 'reLaunch' })
            }, 600)
            return false
        } else {
            getShopCouponInfoFn(option.coupon_id)
            getShopCouponQrocdeFn(option.coupon_id)
        }

    })

    const getShopCouponInfoFn = (id: number) => {
        loading.value = true
        getShopCouponInfo(id).then((res: any) => {
            detail.value = res.data
            if (detail.value.sum_count != -1 && detail.value.receive_count === detail.value.sum_count) {
                detail.value.btnType = 'collected'//已领完
            }
            if (!userInfo.value) {
                detail.value.btnType = 'collecting'//领用
            } else {
                if (detail.value.is_receive && detail.value.limit_count === detail.value.member_receive_count) {
                    detail.value.btnType = 'using'//去使用
                } else {
                    detail.value.btnType = 'collecting'//领用
                }
            }
            loading.value = false

        }).catch(() => {
            loading.value = false
            detail.value = {}
            setTimeout(() => {
                redirect({ url: '/addon/shop/pages/index', mode: 'reLaunch' })
            }, 600)
        })
    }

    const getShopCouponQrocdeFn = (id) => {
        // #ifdef H5
        QRCode.toDataURL(window.location.href, { errorCorrectionLevel: 'L', margin: 0, width: 100 }).then(url => {
            codeUrl.value = url
        });
        // #endif

        // #ifdef MP-WEIXIN
        getShopCouponQrocde(id).then((res: any) => {
            if (res.data) {
                codeUrl.value = img(res.data);
            }
        })
        // #endif
    }

    const collecting = (coupon_id: any) => {
        if (!userInfo.value) {
            useLogin().setLoginBack({ url: '/addon/shop/pages/coupon/list' })
            return false
        }
        getCoupon({ coupon_id, number: 1 }).then(res => {
            detail.value.btnType = 'using'
        })
    }
    const toLink = (id: any) => {
        redirect({ url: '/addon/shop/pages/goods/list', param: { coupon_id: id } })
    }
</script>
<style lang="scss" scoped>
	.border-color {
		border-color: var(--primary-color) !important;
	}

	.text-color {
		color: var(--primary-color) !important;
	}

	.bg-color {
		background-color: var(--primary-color) !important;
	}

	.bg-style {
		background-size: cover !important;
	}

	.code {
		box-shadow: 0 0 20px -1px;
	}
</style>
