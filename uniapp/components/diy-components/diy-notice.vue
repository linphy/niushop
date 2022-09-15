<template>
	<view class="diy-notice">
		<view :class="['notice', value.contentStyle]" :style="noticeWrapCss">
			<image v-if="value.iconType == 'img'" class="notice-img" :src="$util.img(value.imageUrl)" mode="aspectFit"></image>
			<diy-icon
				v-if="value.iconType == 'icon'"
				:icon="value.icon"
				:value="value.style ? value.style : 'null'"
				:style="{ maxWidth: 30 * 2 + 'rpx', maxHeight: 30 * 2 + 'rpx', width: '100%', height: '100%' }"
			></diy-icon>
			<view class="notice-xian"></view>
			<view class="main-wrap">
				<text v-if="value.contentStyle == 'style-2'" class="iconfont icon-gonggao" :style="{ color: value.textColor }"></text>
				<view class="uni-swiper-msg">
					<!-- 横向滚动：horizontal -->
					<template v-if="value.scrollWay == 'horizontal'">
						<swiper :vertical="false" :duration="0" autoplay="true" circular="true">
							<swiper-item v-for="(item, index) in list" :key="index" @touchmove.stop>
								<text @click="toLink(item)" class="beyond-hiding animate" :style="{ color: value.textColor }">{{ item.title }}</text>
							</swiper-item>
						</swiper>
					</template>

					<!-- 上下滚动：upDown -->
					<template v-if="value.scrollWay == 'upDown'">
						<swiper :vertical="true" :duration="500" autoplay="true" circular="true">
							<swiper-item v-for="(item, index) in list" :key="index">
								<text @click="toLink(item)" class="beyond-hiding" :style="{ color: value.textColor }">{{ item.title }}</text>
							</swiper-item>
						</swiper>
					</template>
				</view>
				<text v-if="value.contentStyle == 'style-2'" class="iconfont icon-right arrows" @click="toLink"></text>
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
	created() {
		// 数据源：公告系统
		if (this.value.sources == 'default') this.getData();
		else this.list = this.value.list;
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
			if (this.value.sources == 'initial') this.$util.redirectTo('/pages_tool/notice/detail', { notice_id: item.id });
			else if (!item) this.$util.redirectTo('/pages_tool/notice/list');
			else this.$util.diyRedirectTo(item.link);
		}
	}
};
</script>

<style lang="scss">
.notice {
	height: 80rpx;
	position: relative;
	display: flex;
	align-items: center;
	overflow: hidden;
	padding: 20rpx;
	font-size: 70rpx;
	box-sizing: border-box;

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
	&.style-2 {
		.main-wrap {
			display: flex;
			align-items: center;
			.uni-swiper-msg {
				width: 400rpx;
				margin: 0 10rpx;
			}
			.arrows {
				color: #999;
				font-size: $font-size-sub;
			}
		}
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
	width: auto;
	overflow: hidden;
	text-overflow: ellipsis;
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
