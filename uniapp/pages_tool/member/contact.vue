<template>
	<page-meta :page-style="themeColor"></page-meta>
	<view class="contact">
		<ns-contact><button type="primary">联系客服</button></ns-contact>
	</view>
</template>

<script>
export default {
	data() {
		return {
		};
	},
	onLoad(options) {},
	onShow() {},
	methods: {}
};
</script>

<style lang="scss">
.contact {
	position: absolute;
	width: 80%;
	left: 10%;
	top: 50%;
	margin-top: -80rpx;
}
</style>
