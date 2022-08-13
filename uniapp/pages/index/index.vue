<template>
	<page-meta :page-style="themeColor"></page-meta>
	<view :style="{ backgroundColor: bgColor, backgroundImage: bgImg, minHeight: 'calc(100vh - 55px)' }" class="page_img">
		<!-- #ifndef H5 -->
		<view class="page-header"><ns-navbar :background="bgNav" :title-color="textNavColor" :globalS="diyData.global"></ns-navbar></view>
		<!-- #endif -->

		<diy-index-page ref="indexPage" :value="topIndexValue" :scrollHeight="scrollHeight" :scrollTopHeight="scrollTopHeight" :bgUrl="bgUrl" v-if="topIndexValue">
			<diy-group ref="diyGroup" :diyData="diyData" v-if="diyData.value" :height="scrollTopHeight"></diy-group>
			<view class="padding-bottom"><ns-copy-right></ns-copy-right></view>
		</diy-index-page>

		<scroll-view v-else scroll-y="true" show-scrollbar="false" :style="{ height: 'calc(100vh - headerHeight - 55px)' }">
			<view class="bg-index" :style="backgroundUrl">
				<diy-group ref="diyGroup" :diyData="diyData" v-if="diyData.value"></diy-group>
				<view class="padding-bottom"><ns-copy-right></ns-copy-right></view>
			</view>
		</scroll-view>

		<template v-if="diyData.global && diyData.global.popWindow && diyData.global.popWindow.count != -1 && diyData.global.popWindow.imageUrl">
			<view @touchmove.prevent.stop>
				<uni-popup ref="uniPopupWindow" type="center" class="wap-floating" :maskClick="false">
					<view class="image-wrap">
						<image
							:src="$util.img(diyData.global.popWindow.imageUrl)"
							:style="popWindowStyle"
							@click="$util.diyRedirectTo(diyData.global.popWindow.link)"
							mode="aspectFit"
						></image>
					</view>
					<text class="iconfont iconroundclose" @click="closePopupWindow"></text>
				</uni-popup>
			</view>
		</template>

		<!-- 底部tabBar -->
		<view class="page-bottom" v-if="openBottomNav"><diy-bottom-nav type="shop" @callback="callback"></diy-bottom-nav></view>

		<!-- 自定义页面跳转返回 -->
		<text class="diy-pages-return" v-if="diyPageReturn.length > 1" @click="diyPageFn">返回</text>

		<!-- 收藏 -->
		<uni-popup ref="collectPopupWindow" type="top" class="wap-floating wap-floating-collect">
			<view v-if="showTip" class="collectPopupWindow" :style="{ marginTop: (collectTop + statusBarHeight) * 2 + 'rpx' }">
				<image :src="$util.img('public/uniapp/index/collect2.png')" mode="aspectFit"></image>
				<text @click="closeCollectPopupWindow">我知道了</text>
			</view>
		</uni-popup>

		<loading-cover ref="loadingCover"></loading-cover>
	</view>
</template>

<script>
import uniPopup from '@/components/uni-popup/uni-popup.vue';
import nsNavbar from '@/components/ns-navbar/ns-navbar.vue';
import nsCopyRight from '@/components/ns-copyright/ns-copyright.vue';
import indexJs from './public/js/index.js';

export default {
	components: {
		uniPopup,
		nsNavbar,
		nsCopyRight
	},
	mixins: [indexJs]
};
</script>

<style lang="scss">
@import './public/css/index.scss';
</style>

<style scoped>
.wap-floating >>> .uni-popup__wrapper.uni-custom .uni-popup__wrapper-box {
	background: none !important;
}
/deep/ .placeholder {
	height: 0;
}
/deep/::-webkit-scrollbar {
	width: 0;
	height: 0;
	background-color: transparent;
	display: none;
}
</style>
