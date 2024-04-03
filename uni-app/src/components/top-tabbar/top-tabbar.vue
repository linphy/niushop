<template>
	<view>
		<!-- #ifdef MP-WEIXIN -->
		<view class="flex items-center justify-center fixed left-0 right-0 z-10 bg-[#fff]" :style="navbarInnerStyle">
			<text v-if="props.param.isShowArrow" class="iconfont iconjiantou3 absolute" :style="navbarInnerArrowStyle" @click="goback()"></text>
			<text class="truncate" :style="{color:props.param.titleColor}">{{props.title}}</text>
		</view>
		<!-- 解决fixed定位后导航栏塌陷的问题 -->
		<view :style="navbarInnerStyle"></view>
		<!-- #endif -->
	</view>
</template>

<script setup lang="ts">
// 获取系统状态栏的高度
let systemInfo = uni.getSystemInfoSync();
let platform = systemInfo.platform;
let menuButtonInfo = {};
// 如果是小程序，获取右上角胶囊的尺寸信息，避免导航栏右侧内容与胶囊重叠(支付宝小程序非本API，尚未兼容)
// #ifdef MP-WEIXIN || MP-BAIDU || MP-TOUTIAO || MP-QQ
menuButtonInfo = uni.getMenuButtonBoundingClientRect();
// #endif

import { ref, reactive, computed } from 'vue';
import { redirect } from '@/utils/common';
// param是一个对象{arrowLink => 箭头链接，isShowArrow => 箭头是否显示，tabbarBg => 背景颜色}
const props = defineProps({
    title: {
        type: String,
        default: '首页'
    },
    param: {
        type: Object,
        default: {
			arrowLink: '',
			isShowArrow: false,
			arrowColor:'#000',
			titleColor:'#000',
			tabbarBg: '#fff'
		}
    }
})

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
	style += 'background:'+ props.param.tabbarBg +';';
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
	style += "padding-left: 10rpx;" //1、增加点击面积，2、增加间距
	style += "padding-right: 10rpx;" //1、增加点击面积
	style += 'left:calc( 100vw - ' + menuButtonInfo.right + 'px);';
	style += 'font-size: 32rpx;';
	style += 'font-weight: bold;';
	style += 'color:'+ props.param.arrowColor +';';
	if (platform === 'ios') {
		// 苹果(iOS)设备
		style += 'font-weight: 700;';
	} else if (platform === 'android') {
	  // 安卓(Android)设备
	  
	}
	// #endif
	return style;
})

// 返回上一页
const goback=()=> {
	if(!props.param.arrowLink){
		uni.navigateBack({
			delta: 1
		});
	}else{
		redirect({ url: props.param.arrowLink })
	}
}
</script>

<style scoped lang="scss">
</style>