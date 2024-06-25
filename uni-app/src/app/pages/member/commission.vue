<template>
	<view class="bg-[#F6F6F6] min-h-[100vh] w-full" :style="themeColor()" v-if="memberStore.info">
		<view class="fixed w-full z-2  !bg-[#F6F6F6]">
			<view class="pb-[174rpx]" :style="headerStyle">
				<!-- #ifdef MP-WEIXIN -->
				<top-tabbar :data="param"  class="top-header"/>
				<!-- #endif -->
				<!-- <view class="pt-[18rpx]  pb-[20rpx] pl-[30rpx] flex items-center" v-if="info">
					<u-avatar :src="img(info.headimg)" :size="'60rpx'" leftIcon="none"></u-avatar>
					<view class="ml-[12rpx] mr-[46rpx] text-[32rpx] font-bold text-[#333] leading-[38rpx]">{{info.nickname}}</view>
					<view class="member-level pl-[30rpx] pr-[12rpx] py-[2rpx] font-400 text-[24rpx] text-[#fff] leading-[34rpx] relative">
						<text>{{ info.member_level_name }}</text>
						<image class="h-[40rpx] w-[36rpx] absolute top-0 left-[-20rpx] " :src="img('static/resource/images/member/commission/level_icon.png')" mode="heightFix" />
					</view>
				</view> -->
			</view>
			<view class=" mt-[-114rpx] mx-[30rpx]" :style="{ backgroundImage: 'url(' + img('static/resource/images/member/commission/account_bg.png') + ')',backgroundRepeat:'no-repeat',backgroundSize:'100% 100%'}">
				<view class="pt-[40rpx] pb-[20rpx]">
					<view class="flex items-center justify-between px-[30rpx]">
						<view>
							<view class="text-[26rpx] font-500 text-[#fff] leading-[36rpx] mb-[8rpx]">{{t('accountCommission')}}</view>
							<view class="text-[56rpx] font-bold text-[#fff] leading-[68rpx]">{{ memberStore.info ? moneyFormat(memberStore.info.commission) : 0.00 }}</view>
						</view>
						<u-button type="primary" :text="t('transferMoney')" :plain="true" shape="circle"  :customStyle="{backgroundColor: '#fff',color: '#EF000C',width: '150rpx', height:'66rpx', lineHeight:'66rpx', margin:'0rpx',border:'none'}" @click="applyCashOut"></u-button>
					</view>
					<view class="h-[1rpx] bg-[#fff] opacity-30 mt-[80rpx] mb-[20rpx]"></view>
					<view class="flex items-center  px-[30rpx]">
						<view class="flex-1">
							<view class="font-bold text-[#fff] text-[36rpx] leading-[44rpx] mb-[6rpx]">
								{{ moneyFormat(memberStore.info?.commission_get)|| '0.00' }}
							</view>
							<view class="text-[26rpx] text-[#fff] leading-[36rpx]">{{ t('commission') }}</view>
						</view>
						<view class="flex-1">
							<view class="font-bold text-[#fff] text-[36rpx] leading-[44rpx] mb-[6rpx]">
								{{ moneyFormat(memberStore.info?.commission_cash_outing)|| '0.00' }}
							</view>
							<view class="text-[26rpx] text-[#fff] leading-[36rpx]">{{ t('money') }}</view>
						</view>
					</view>
				</view>
			</view>
			<view class="mt-[40rpx] box-border px-[15rpx]">
				<view class="flex whitespace-nowrap">
					<view  class="text-[26rpx] leading-[70rpx] text-[#666] font-400 px-[15rpx]" :class="{ 'class-select': fromType.from_type === item.from_type && fromType.account_data_gt === item.account_data_gt }" @click="fromTypeFn(item,index)" v-for="(item, index) in accountTypeList">{{ item.name }}</view>
				</view>
			</view>
		</view>
		<mescroll-body ref="mescrollRef" @init="mescrollInit" @down="downCallback" @up="geCommissiontListFn" :top="mescrollTop">
            	<view class="px-[30rpx] pt-[20rpx] body-bottom" v-if="list.length">
					<view v-for="(item,index) in list" :key="item.id" class="w-full h-[120rpx] flex justify-between items-center bg-[#fff] box-border p-[20rpx] rounded-[16rpx]" :class="{'mt-[20rpx]':index}">
						<view class="flex items-center">
							<view class="w-[80rpx] h-[80rpx] text-center rounded-[40rpx] text-[40rpx] font-bold leading-[80rpx] text-[#fff]"
							:class="{'bg-[#EF000C]' :item.account_data > 0, 'bg-[#1379FF]':item.account_data <= 0 }">
								{{item.account_data > 0?'收':'提'}}
							</view>
							<view class="flex flex-col ml-[20rpx]">
								<view class="text-[#333] text-[26rpx] leading-[36rpx]">{{item.from_type_name}}</view>
								<view class="text-[#999] text-[24rpx] leading-[34rpx] mt-[4rpx] font-400">{{item.create_time}}</view>
							</view>
						</view>
						<view class="text-[36rpx] leading-[50rpx]" :class="{'text-[#EF000C]' :item.account_data > 0, 'text-[#333]':item.account_data <= 0 }">{{ item.account_data > 0 ? '+' + item.account_data : item.account_data }}</view>
					</view>
				</view>
				<view class="box-border pt-[20rpx] px-[30rpx]  body-bottom" :style="{'height':'calc(100vh - '+mescrollTop +')'}" v-if="!list.length && !loading &&!listLoading">
					<view class="h-full bg-[#fff] rounded-[16rpx] flex items-center justify-center">
						<mescroll-empty></mescroll-empty>
					</view>
				</view>

            </mescroll-body>
			<u-loading-page bg-color="rgb(248,248,248)" :loading="loading" loadingText="" fontSize="16" color="#303133"></u-loading-page>
	</view>
</template>

<script setup lang="ts">
	import { computed, ref } from 'vue'
	import { t } from '@/locale'
	import { moneyFormat, redirect, img } from '@/utils/common';
	import useMemberStore from '@/stores/member'
	import { getMemberCommission } from '@/app/api/member';
	import MescrollBody from '@/components/mescroll/mescroll-body/mescroll-body.vue';
	import MescrollEmpty from '@/components/mescroll/mescroll-empty/mescroll-empty.vue';
	import useMescroll from '@/components/mescroll/hooks/useMescroll.js';
	import { onLoad, onPageScroll, onReachBottom } from '@dcloudio/uni-app';

	const { downCallback,mescrollInit, getMescroll } = useMescroll(onPageScroll, onReachBottom);
	const memberStore = useMemberStore();
	const info = computed(() => memberStore.info)
	// 提现
	const applyCashOut = ()=> {
	    uni.setStorageSync('cashOutAccountType', 'commission')
	    redirect({ url: '/app/pages/member/apply_cash_out' })
	}

	let param = ref({
		title:'我的佣金',
		topStatusBar: {
            isTransparent: true,
			style: 'style-1',
			bgColor: 'transparent',
			textColor: '#333'
		}
	})
	// 获取系统状态栏的高度
	let menuButtonInfo:any = {};
	// 如果是小程序，获取右上角胶囊的尺寸信息，避免导航栏右侧内容与胶囊重叠(支付宝小程序非本API，尚未兼容)
	// #ifdef MP-WEIXIN || MP-BAIDU || MP-TOUTIAO || MP-QQ
	menuButtonInfo = uni.getMenuButtonBoundingClientRect();
	// #endif
	const headerStyle = computed(()=>{
		return {
			backgroundImage: 'url(' + img('static/resource/images/member/commission/commission_bg.png') + ') ',
			backgroundSize: 'cover',
			backgroundRepeat: 'no-repeat',
			backgroundPosition: 'center',
		}
	})
	//  16为自定头部的padding-bottom
	const mescrollTop = computed(()=>{
		return Object.keys(menuButtonInfo).length?(Number(menuButtonInfo.height) * 2 + menuButtonInfo.top * 2  + 530 + 16)+'rpx':'530rpx'
	})

	//来源类型
	const fromType = ref({
		from_type:'',
		account_data_gt:''
	})
	const accountTypeList = ref([
		{name:'全部',from_type:'',account_data_gt: ''},
		{name:'佣金',from_type:'',account_data_gt: 0},
		{name:'提现',from_type:'cash_out',account_data_gt: ''},
	])
	const list = ref<Array<any>>([])
	const loading = ref<boolean>(true)
	const listLoading = ref<boolean>(true)
	const mescrollRef = ref(null);

	const fromTypeFn = (data : any ,index : number)=>{
		fromType.value.from_type = data.from_type
		fromType.value.account_data_gt = data.account_data_gt
		getMescroll().resetUpScroll();
	}
	const geCommissiontListFn = (mescroll) => {
		listLoading.value = true;
		let data : Object = {
			page: mescroll.num,
			limit: mescroll.size,
			from_type:fromType.value.from_type,
			account_data_gt: fromType.value.account_data_gt
		}
		getMemberCommission(data).then((res:any) => {
			let newArr = res.data.data;-
			mescroll.endSuccess(newArr.length);
			//设置列表数据
			if (mescroll.num == 1) {
				list.value = []; //如果是第一页需手动制空列表
			}
			list.value = list.value.concat(newArr);
			listLoading.value = false;
			loading.value = false;
		}).catch(() => {
			listLoading.value = false;
			loading.value = false;
			mescroll.endErr(); // 请求失败, 结束加载
		})
	}
</script>

<style lang="scss">
	.member-level{
		background: linear-gradient( 360deg, #F23621 11%, #FF7F71 100%), #D9D9D9;
		border-radius: 0rpx 20rpx 20rpx 0rpx;
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
	:deep(.uni-scroll-view){
		overflow: auto hidden !important;
	}
	.body-bottom{
		padding-bottom:  calc(20rpx + constant(safe-area-inset-bottom));
		padding-bottom:  calc(20rpx + env(safe-area-inset-bottom));
	}
</style>
