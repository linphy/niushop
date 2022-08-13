<template>
	<view :style="{ borderTop: '2rpx ' + value.borderStyle + ' ' + value.color }"></view>
</template>

<script>
// 辅助线
export default {
	name: 'diy-horz-line',
	props: {
		value: {
			type: Object
		}
	},
	data() {
		return {};
	},
	methods: {}
};
</script>

<style></style>
