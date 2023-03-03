<template>
	<view v-if="show">
		<view class="ns-copyright-info">
			<view class="ns-copyright-pic" v-if="copyright.logo" @click="link(copyright.copyright_link)">
				<image :src="$util.img(copyright.logo)" @error="error" mode="widthFix"></image>
			</view>
			<!-- <view class="copyright-desc color-tip" v-if="copyright.company_name" @click="link(copyright.copyright_link)">{{ copyright.company_name }}</view> -->
			<!-- <view class="copyright-desc color-tip" v-else @click="link('http://www.niushop.com')">牛之云科技提供技术支持</view> -->
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			show: true
		};
	},
	created() {},
	computed: {
		copyright() {
			let copyright = uni.getStorageSync('copyright');
			// 判断是否授权
			if (copyright && !copyright.auth) {
				copyright.logo = 'public/uniapp/common/logo_copy.png';
				copyright.copyright_link = 'http://www.niushop.com';
			}
			return copyright;
		}
	},
	methods: {
		link(url) {
			if (url) {
				this.$util.redirectTo('/pages_tool/webview/webview', {
					src: encodeURIComponent(url)
				});
			}
		},
		error() {
			this.show = false;
		}
	}
};
</script>

<style lang="scss">
.ns-copyright-info {
	width: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	margin-top: 40rpx;
	margin-bottom: 40rpx;
}

.ns-copyright-info .ns-copyright-pic image {
	width: 160rpx;
	height: 24rpx;
}

.ns-copyright-info text {
	font-size: $font-size-goods-tag;
	height: 100rpx;
	line-height: 100rpx;
	color: $color-tip !important;
}

.ns-copyright-info .copyright-desc {
	color: lighten($color-tip, 30%);
	font-size: $font-size-goods-tag;
	text-shadow: 0 0 2rpx lighten($color-tip, 40%);
}
</style>
