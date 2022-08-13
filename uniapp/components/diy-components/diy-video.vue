<template>
	<video :src="$util.img(value.videoUrl)" :poster="$util.img(value.imageUrl)" :style="videoWarpCss"></video>
</template>

<script>
// 视频
export default {
	name: 'diy-video',
	props: {
		value: {
			type: Object
		}
	},
	data() {
		return {};
	},
	created() {},
	computed: {
		videoWarpCss: function() {
			var obj = '';
			if (this.value.componentAngle == 'round') {
				obj += 'border-top-left-radius:' + this.value.topAroundRadius * 2 + 'rpx;';
				obj += 'border-top-right-radius:' + this.value.topAroundRadius * 2 + 'rpx;';
				obj += 'border-bottom-left-radius:' + this.value.bottomAroundRadius * 2 + 'rpx;';
				obj += 'border-bottom-right-radius:' + this.value.bottomAroundRadius * 2 + 'rpx;';
			}
			return obj;
		}
	},
	methods: {}
};
</script>

<style scoped>
video {
	width: 100%;
}
</style>
