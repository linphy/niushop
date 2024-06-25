<template>
    <view :style="themeColor()" class="bg-[#f8f8f8] min-h-[100vh] overflow-hidden">
        <block v-if="!loading && verifyInfo && verifyInfo.value">
			<view class="w-full bg-[#fff] flex justify-center">
				<view class="text-[var(--primary-color)] absolute top-[30rpx] right-[30rpx] flex" @click="redirect({url:'/app/pages/verify/record'})">
					<image class="w-[24rpx] h-[28rpx]" :src="img('static/resource/images/verify/history.png')"/>
					<text class="text-[26rpx] leading-[30.47rpx] ml-[10rpx] h-[36rpx] leading-[36rpx]">核销记录</text>
				</view>
				<view class="flex pt-[126rpx] pb-[30rpx] items-center">
					<view class="flex justify-center items-center flex-col pr-[30rpx]">
						<image class="w-[100rpx] h-[100rpx]" :src="img('static/resource/images/verify/yanzhenghexiaoma.png')"/>
						<view class="text-[26rpx] mt-[12rpx] h-[36rpx] leading-[36rpx]">验证核销码</view>
					</view>
					<image class="w-[74rpx] h-[12rpx] mb-[50rpx]" :src="img('static/resource/images/verify/youjiantou.png')"/>
					<view class="flex justify-center items-center flex-col pl-[30rpx]">
						<image class="w-[100rpx] h-[100rpx]" :src="img('static/resource/images/verify/hexiao.png')"/>
						<view class="text-[26rpx] mt-[12rpx] h-[36rpx] leading-[36rpx]">确定核销</view>
					</view>
				</view>
			</view>
			<view class="bg-[#fff] rounded-[16rpx] mt-[20rpx] mx-[30rpx] h-[200rpx]">
				<view class="flex" v-for="(item,index) in verifyInfo.value.list" :key="index">
						<image class="w-[150rpx] h-[150rpx] ml-[20rpx] mt-[30rpx] rounded-[8rpx]" mode="aspectFit" v-if="item.cover" :src="img(item.cover)"></image>
						<image class="w-[150rpx] h-[150rpx] ml-[20rpx] mt-[30rpx] rounded-[8rpx]" mode="aspectFit" v-else :src="img('addon/tourism/tourism/member/hotel.png')"></image>
					<view class="flex flex-col flex-1 ml-[10rpx]">
						<view class="mt-[33rpx] ml-[20rpx] max-w-[432rpx] multi-hidden">{{item.name}}</view>
					</view>
				</view>
			</view>
			
			<view class="bg-[#fff] rounded-[16rpx] mx-[30rpx] mt-[20rpx]">
				<view class="pt-[20rpx] pl-[20rpx] text-[28rpx] font-bold h-[39rpx] leading-[39rpx]">核销信息</view>
				<view class="text-[28rpx] pb-[20rpx]">
					<view class="flex pt-[30rpx] items-center justify-between px-[20rpx]">
						<text class="text-[28rpx] text-[#333333] h-[39rpx] leading-[39rpx]">核销类型</text>
						<view class="text-[28rpx] text-[#333333] h-[39rpx] leading-[39rpx]">{{verifyInfo.type_name}}</view>
					</view>
					<view class="flex pt-[30rpx] items-center justify-between px-[20rpx]" v-for="(item,index) in verifyInfo.value.content.fixed">
						<text class="text-[28rpx] text-[#333333] h-[39rpx] leading-[39rpx]">{{item.title}}</text>
						<view class="text-[28rpx] text-[#333333] h-[39rpx] leading-[39rpx]">{{item.value}}</view>
					</view>
				</view>
			</view>
			
			<view v-for="(item,index) in verifyInfo.value.content.diy" :key="index" class="bg-[#fff] rounded-[16rpx] mx-[30rpx] mt-[20rpx]">
				<view class="pt-[20rpx] pl-[20rpx] text-[28rpx] font-bold h-[39rpx] leading-[39rpx]">{{item.title}}</view>
				<view class="text-[28rpx] pb-[20rpx]">
					<view class="flex pt-[30rpx] items-center justify-between px-[20rpx]" v-for="(subItem,subIndex) in item.list" :key="subIndex">
						<text class="text-[28rpx] text-[#333333] h-[39rpx] leading-[39rpx]">{{subItem.title}}</text>
						<div v-if="subIndex === 0" class="flex items-center">
						    <text class="text-[28rpx] text-[#333333] h-[39rpx] leading-[39rpx] mr-[10rpx]">{{ subItem.value }}</text>
							<view class="w-[1rpx] h-[20rpx] bg-[#999999] mr-[10rpx]"></view>
						    <view class="text-[#EF900A]" @click="copy(subItem.value)">复制</view>
						</div>
						<div v-else>
							<text class="text-[28rpx] text-[#333333] h-[39rpx] leading-[39rpx]">{{ subItem.value }}</text>
						</div>
					</view>
				</view>
			</view>
			
			<text class=" min-w-[630rpx] fixed bottom-[60rpx] confirmBtn text-[#fff] flex items-center justify-center !text-[32rpx] rounded-[50rpx] h-[88rpx] ml-[60rpx] mr-[60rpx]" @click="verifyFn">确定</text>
        </block>
        <u-loading-page :loading="loading" loading-text="" loadingColor="var(--primary-color)" iconSize="35"></u-loading-page>
    </view>
</template>

<script setup lang="ts">
    import { ref } from 'vue';
    import { onLoad ,onShow} from '@dcloudio/uni-app'
	import { img,redirect, isWeixinBrowser, getToken } from '@/utils/common';
    import { getVerifierInfo, getCheckVerifier, verify } from '@/app/api/verify'
	import { copy } from '@/utils/common';
    import { t } from '@/locale'

    const loading = ref(true)
    const verifyDetail = ref<AnyObject | null>(null)
	let code = ref('');
    onLoad((option)=> {
		if (option.code) code.value = option.code;
		// 小程序扫码进入
		if (option.scene) {
			let sceneParams = decodeURIComponent(option.scene);
			sceneParams = sceneParams.split('&');
			if (sceneParams.length) {
				sceneParams.forEach(item => {
					if (item.indexOf('code') != -1) code.value = item.split('-')[1];
				});
			}
		}
    })
	
	onShow(() => {
		if(getToken()){
			checkIsVerifier();
			getVerifierInfoFn();
		}
	})
	
	// 检测是否是核销员
	const checkIsVerifier = () => {
		getCheckVerifier().then((res:any) =>{
			if(!res.data){
				uni.showToast({
					title: '非核销员无此权限',
					icon: 'none'
				});
				setTimeout(() => {
					uni.navigateBack();
				}, 1000);
			}else{
				loading.value = false;
			}
		})
	}
	
	let verifyInfo = ref({})
	const getVerifierInfoFn = ()=>{
		loading.value = true;
		getVerifierInfo(code.value).then((res:any) =>{
			verifyInfo.value = res.data;
			loading.value = false;
		})
	}
	let isLoading = false;
	const verifyFn = ()=>{
		if(isLoading) return false;
		isLoading = true;
		
		verify(code.value).then((res:any) =>{
			isLoading = false;
			setTimeout(() => {
				redirect({ url: '/app/pages/verify/index', param: {}, mode: 'redirectTo' })
			}, 1000);
		}).catch(() => {
            isLoading = false;
        })
	}
</script>

<style lang="scss" scoped>
	.confirmBtn{
		background: linear-gradient( 94deg, #FB7939 0%, #FE120E 99%), #EF000C;
	}
</style>