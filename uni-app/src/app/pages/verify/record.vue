<template>
    <view class="bg-[#f8f8f8] min-h-screen overflow-hidden" :style="themeColor()">
        <mescroll-body ref="mescrollRef" top="30rpx" @init="mescrollInit" @down="downCallback" @up="geVerifyRecordFn">
        	<view class="ml-[30rpx] mr-[30rpx]">
        		<block v-for="(item,index) in list"	:key="item.id">
        			<view class="w-full flex flex-col mb-3 bg-[#fff] px-[20rpx] box-border rounded-[18rpx] " @click="toLink(item)">
        				<view class="flex items-center pb-[30rpx] pt-[20rpx] leading-[1]">
							<view class="nc-iconfont nc-icon-hexiaotaiV6xx pr-[10rpx]"></view>
        					<text class="truncate max-w-[590rpx] text-[#333333] text-[26rpx]">核销码：{{ item.code }}</text>
        				</view>
						<view class="flex  flex-1" v-for="(dataItem,dataIndex) in item.value.list" :key="dataIndex">
							<image class="w-[100rpx] h-[100rpx] rounded-[8rpx]" mode="aspectFit" v-if="dataItem.cover" :src="img(dataItem.cover)"></image>
							<image class="w-[100rpx] h-[100rpx] rounded-[8rpx]" mode="aspectFit" v-else :src="img('addon/tourism/tourism/member/hotel.png')"></image>

							<view class="flex flex-col flex-1 ml-[20rpx] mt-[3rpx]">
								<view class="leading-[1.4] multi-hidden text-28rpx text-[#333]">{{dataItem.name}}</view>
								<view class="self-end text-[28rpx]">x1</view>
							</view>
						</view>
						<view class="flex flex-col bg-[#F6F6F6] p-[20rpx] rounded-[12rpx] mt-[20rpx] mb-[20rpx]">
							<text class="text-[#333333] text-[26rpx] h-[36rpx] leading-[36rpx]">核销时间：{{ item.create_time }}</text>
							<text class="text-[#333333] text-[26rpx] h-[36rpx] mt-[10rpx] truncate leading-[36rpx]">核销员：{{ item.member ? item.member.nickname : '--' }}</text>
						</view>
        			</view>
        		</block>
        	</view>
            <mescroll-empty :option="{'icon': img('static/resource/images/empty.png')}" v-if="!list.length && loading"></mescroll-empty>
        </mescroll-body>
    </view>
</template>

<script setup lang="ts">
    import { ref, reactive, computed } from 'vue'
    import { onLoad } from '@dcloudio/uni-app'
    import MescrollBody from '@/components/mescroll/mescroll-body/mescroll-body.vue'
    import MescrollEmpty from '@/components/mescroll/mescroll-empty/mescroll-empty.vue'
    import useMescroll from '@/components/mescroll/hooks/useMescroll.js'
    import { onPageScroll, onReachBottom } from '@dcloudio/uni-app'
    import { getVerifyRecords } from '@/app/api/verify'
    import { img, redirect } from '@/utils/common'

    let list = ref<Array<Object>>([])
    let loading = ref<boolean>(false)
    const { mescrollInit, downCallback, getMescroll } = useMescroll(onPageScroll, onReachBottom)

    const geVerifyRecordFn = (mescroll) => {
    	loading.value = false;
    	let data : object = {
    		page: mescroll.num,
    		limit: mescroll.size,
    	};

    	getVerifyRecords(data).then((res) => {
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

    const toLink = (data: AnyObject)=> {
        redirect({ url: '/app/pages/verify/detail', param: { code: data.code } })
    }
</script>

<style lang="scss" scoped>
</style>
