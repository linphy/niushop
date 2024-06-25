<template>
    <view :style="themeColor()" class="bg-[#f8f8f8] min-h-[100vh] overflow-hidden">
        <block v-if="!loading">
			<view class="mt-[30rpx] mx-[30rpx]">
				<view class="py-[10rpx] px-[20rpx] flex flex-col rounded-[16rpx] bg-white">
					<view class="flex h-[180rpx]" :class="{'mb-[20rpx]': verifyInfo.value.list.length-1 != index}" v-for="(item,index) in verifyInfo.value.list" :key="index">
						<image class="w-[120rpx] h-[120rpx] mt-[30rpx] rounded-[8rpx]" mode="aspectFit" v-if="item.cover" :src="img(item.cover)"></image>
						<image class="w-[120rpx] h-[120rpx] mt-[30rpx] rounded-[8rpx]" mode="aspectFit" v-else :src="img('addon/tourism/tourism/member/hotel.png')"></image>
						<view class="flex flex-col flex-1 ml-[20rpx] mt-36rpx">
							<view class="leading-[39rpx] text-[28rpx] max-w-[432rpx] multi-hidden">{{item.name}}</view>
							<view class="self-end text-[28rpx]">x1</view>
						</view>
					</view>
				</view>
				
				<view class="flex flex-col bg-[#fff]  p-[20rpx] rounded-[16rpx] mt-[20rpx]">
					<view class="text-[28rpx] text-[#333333] font-bold leading-[39rpx] h-[39rpx]">核销信息</view>
					<view class="flex justify-between items-center mt-[30rpx] h-[39rpx]">
						<text class="text-[28rpx] text-[#333]">核销类型</text>
						<view class="text-[28rpx] text-[#333]">{{verifyInfo.type_name}}</view>
					</view>
					<view class="flex justify-between items-center mt-[20rpx] h-[39rpx]">
						<text class="text-[28rpx] text-[#333]">核销状态</text>
						<view class="text-[28rpx] text-[#333]">已核销</view>
					</view>
					<view class="flex justify-between items-center mt-[20rpx] h-[39rpx]">
						<text class="text-[28rpx]">核销时间</text>
						<view class="text-[#333333] text-[28rpx]">{{verifyInfo.create_time}}</view>
					</view>
					<view class="flex justify-between items-center mt-[20rpx] h-[39rpx]">
						<text class="text-[28rpx]">核销人员</text>
						<view class="text-[#333333] text-[28rpx]">{{verifyInfo.member ? verifyInfo.member.nickname : '--'}}</view>
					</view>
					<view class="flex items-center justify-between mt-[20rpx]" v-for="(item,index) in verifyInfo.value.content.fixed">
						<text class="text-[28rpx] text-[#333]">{{item.title}}</text>
						<view class="text-[28rpx] text-[#333]">{{item.value}}</view>
					</view>
				</view>
				
				<view v-for="(item,index) in verifyInfo.value.content.diy" :key="index" class="text-[#838383] bg-white p-[20rpx] rounded-[16rpx] mt-[20rpx]">
					<view class="text-[28rpx] text-[#333333] font-bold leading-[39rpx] h-[39rpx]">{{item.title}}</view>
					<view class="flex items-center justify-between h-[39rpx] mt-[20rpx]" v-for="(subItem,subIndex) in item.list" :key="subIndex" :class="{'mt-30rpx' : subIndex == '0'}">
						<text class="text-[28rpx] text-[#333]">{{subItem.title}}</text>
						<view class="text-[28rpx] text-[#333]">{{subItem.value}}</view>
					</view>
				</view>
			</view>

        </block>
        <u-loading-page :loading="loading" loading-text="" loadingColor="var(--primary-color)" iconSize="35"></u-loading-page>
    </view>
</template>

<script setup lang="ts">
    import { ref } from 'vue';
    import { onLoad,onShow } from '@dcloudio/uni-app'
	import { img,redirect, getToken } from '@/utils/common';
    import { getVerifyDetail } from '@/app/api/verify'
    import { t } from '@/locale'

    const loading = ref(true)
	let code = ref('');
    onLoad((option)=> {
		if (option.code) code.value = option.code;
    })
	
	onShow(() => {
		if(getToken()){
			getVerifyDetailFn();
		}
	})
	
	let verifyInfo = ref({})
	const getVerifyDetailFn = ()=>{
		loading.value = true;
		getVerifyDetail(code.value).then((res:any) =>{
			verifyInfo.value = res.data;
			console.log("verifyInfo.value",verifyInfo.value);
			loading.value = false;
		})
	}
</script>
