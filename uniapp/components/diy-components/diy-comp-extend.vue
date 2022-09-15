<template>
	<view>
		<!-- 扩展组件 -->

		<!-- 扩展标题 -->
		<template v-if="value.componentName == 'TextExtend'">
			<diy-text-extend :value="value"></diy-text-extend>
		</template>
	</view>
</template>

<script>
// 自定义扩展组件
export default {
	name: 'diy-comp-extend',
	props: {
		value: {
			type: Object
		}
	},
	data() {
		return {};
	},
	computed: {},
	created() {},
	methods: {}
};
</script>

<style></style>
