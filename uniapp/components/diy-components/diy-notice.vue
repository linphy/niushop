<template>
	<view class="diy-notice">
		<view class="notice notice-1" :style="noticeWrapCss">
			<image v-if="value.iconType == 'img'" class="notice-img" :src="$util.img(value.imageUrl)" mode="heightFix"></image>
			<diy-icon
				v-if="value.iconType == 'icon'"
				:icon="value.icon"
				:value="value.style ? value.style : 'null'"
				:style="{ maxWidth: 30 * 2 + 'rpx', maxHeight: 30 * 2 + 'rpx', width: '100%', height: '100%' }"
			></diy-icon>
			<view class="notice-xian"></view>
			<view class="main-wrap">
				<view class="uni-swiper-msg">
					<swiper vertical="true" autoplay="true" duration="0" circular="true">
						<swiper-item v-for="(item, index) in list" :key="index" @touchmove.stop>
							<text @click="toLink(item)" class="beyond-hiding animate" :style="{ color: value.textColor }">{{ item.title }}</text>
						</swiper-item>
					</swiper>
				</view>
			</view>
		</view>
	</view>
</template>
<script>
// 公告
export default {
	name: 'diy-notice',
	props: {
		value: {
			type: Object
		}
	},
	data() {
		return {
			list: []
		};
	},
	computed: {
		noticeWrapCss: function() {
			var obj = '';
			obj += 'background-color:' + this.value.componentBgColor + ';';
			if (this.value.componentAngle == 'round') {
				obj += 'border-top-left-radius:' + this.value.topAroundRadius * 2 + 'rpx;';
				obj += 'border-top-right-radius:' + this.value.topAroundRadius * 2 + 'rpx;';
				obj += 'border-bottom-left-radius:' + this.value.bottomAroundRadius * 2 + 'rpx;';
				obj += 'border-bottom-right-radius:' + this.value.bottomAroundRadius * 2 + 'rpx;';
			}
			return obj;
		}
	},
	created() {
		// 数据源：公告系统
		if (this.value.sources == 'default') this.getData();
		else this.list = this.value.list;
	},
	methods: {
		getData() {
			var data = {};
			data.id_arr = this.value.noticeIds.toString();
			this.$api.sendRequest({
				url: '/api/notice/lists',
				data: data,
				success: res => {
					if (res.code == 0 && res.data) {
						this.list = res.data;
					}
				}
			});
		},
		toLink(item) {
			if (this.value.sources == 'default') this.$util.redirectTo('/pages_tool/notice/detail', { notice_id: item.id });
			else this.$util.diyRedirectTo(item.link);
		}
	}
};
</script>

<style lang="scss">
.notice-1 {
	height: 80rpx;
	position: relative;
	display: flex;
	align-items: center;
	overflow: hidden;
	padding: 20rpx;
	font-size: 70rpx;

	.notice-img {
		width: 212rpx;
		height: 40rpx;
	}

	.notice-xian {
		width: 1rpx;
		height: 26rpx;
		background-color: #e4e4e4;
		margin: 0 22rpx;
	}
}

.main-wrap {
	display: inline-block;
	width: calc(100% - 115rpx);
	position: relative;
}

swiper {
	height: 50rpx;
}

.beyond-hiding {
	display: inline-block;
	width: 100%;
	white-space: nowrap;
}

.animate {
	padding-left: 40rpx;
	font-size: $font-size-base;
	color: #000;
	display: inline-block;
	white-space: nowrap;
	animation: 5s wordsLoop linear infinite normal;
}

@keyframes wordsLoop {
	0% {
		transform: translateX(400rpx);
		-webkit-transform: translateX(400rpx);
	}

	100% {
		transform: translateX(-100%);
		-webkit-transform: translateX(-100%);
	}
}

@-webkit-keyframes wordsLoop {
	0% {
		transform: translateX(400rpx);
		-webkit-transform: translateX(400rpx);
	}

	100% {
		transform: translateX(-100%);
		-webkit-transform: translateX(-100%);
	}
}
</style>
