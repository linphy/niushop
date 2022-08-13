<template>
	<view class="article-wrap" :style="warpCss" v-if="list.length > 0">
		<view :class="['list-wrap', value.style]" :style="warpCss">
			<view :class="['item', value.ornament.type]" v-for="(item, index) in list" :key="index" @click="toDetail(item)" :style="itemCss">
				<image class="cover-img" :src="$util.img(item.cover_img)" mode="widthFix" @error="imgError(index)"></image>
				<view class="info-wrap">
					<text class="title">{{ item.article_title }}</text>
					<text class="abstract">{{ item.article_abstract }}</text>
					<view class="read-wrap">
						<text class="iconfont iconchakan"></text>
						<text>{{ item.read_num }}人</text>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
// 文章
export default {
	name: 'diy-article',
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
		this.getBrandList();
	},
	computed: {
		warpCss() {
			var obj = '';
			obj += 'background-color:' + this.value.componentBgColor + ';';
			if (this.value.componentAngle == 'round') {
				obj += 'border-top-left-radius:' + this.value.topAroundRadius * 2 + 'rpx;';
				obj += 'border-top-right-radius:' + this.value.topAroundRadius * 2 + 'rpx;';
				obj += 'border-bottom-left-radius:' + this.value.bottomAroundRadius * 2 + 'rpx;';
				obj += 'border-bottom-right-radius:' + this.value.bottomAroundRadius * 2 + 'rpx;';
			}
			return obj;
		},
		// 子项样式
		itemCss() {
			var obj = '';
			obj += 'background-color:' + this.value.elementBgColor + ';';
			if (this.value.elementAngle == 'round') {
				obj += 'border-top-left-radius:' + this.value.topElementAroundRadius * 2 + 'rpx;';
				obj += 'border-top-right-radius:' + this.value.topElementAroundRadius * 2 + 'rpx;';
				obj += 'border-bottom-left-radius:' + this.value.bottomElementAroundRadius * 2 + 'rpx;';
				obj += 'border-bottom-right-radius:' + this.value.bottomElementAroundRadius * 2 + 'rpx;';
			}
			if (this.value.ornament.type == 'shadow') {
				obj += 'box-shadow:' + '0 0 10rpx ' + this.value.ornament.color;
			}
			if (this.value.ornament.type == 'stroke') {
				obj += 'border:' + '2rpx solid ' + this.value.ornament.color;
			}
			return obj;
		}
	},
	methods: {
		getBrandList() {
			var data = {
				page: 1,
				page_size: this.value.count
			};
			if (this.value.sources == 'diy') {
				data.page_size = 0;
				data.article_id_arr = this.value.articleIds.toString();
			}

			this.$api.sendRequest({
				url: '/api/article/page',
				data: data,
				success: res => {
					if (res.code == 0 && res.data) {
						let data = res.data;
						this.list = data.list;
					}
				}
			});
		},
		toDetail(item) {
			this.$util.redirectTo('/pages_tool/article/detail', {
				article_id: item.article_id
			});
		},
		imgError(index) {
			if (this.list[index]) this.list[index].cover_img = this.$util.getDefaultImage().goods;
		}
	}
};
</script>

<style lang="scss">
.article-wrap {
	.list-wrap {
		&.style-1 {
			.item {
				display: flex;
				padding: 20rpx 20rpx 0;
				&.shadow {
					padding: 20rpx;
					margin-left: 8rpx;
					margin-right: 8rpx;
					margin-top: 8rpx;
					margin-bottom: 20rpx;
					&:last-child {
						margin-bottom: 0;
					}
				}
				&.stroke {
					padding: 20rpx;
					margin-bottom: 20rpx;
					&:last-child {
						margin-bottom: 0;
					}
				}
				image {
					margin-right: 20rpx;
					width: 240rpx;
					height: 240rpx;
				}
				.info-wrap {
					flex: 1;
					display: flex;
					flex-direction: column;
					justify-content: space-between;
					.title {
						font-weight: bold;
						margin-bottom: 10rpx;
						overflow: hidden;
						text-overflow: ellipsis;
						display: -webkit-box;
						-webkit-line-clamp: 1;
						-webkit-box-orient: vertical;
						font-size: $font-size-tag;
					}
					.abstract {
						overflow: hidden;
						text-overflow: ellipsis;
						display: -webkit-box;
						-webkit-line-clamp: 2;
						-webkit-box-orient: vertical;
						font-size: $font-size-tag;
					}
					.read-wrap {
						display: flex;
						color: #999ca7;
						justify-content: flex-end;
						align-items: center;
						margin-top: 10rpx;
						line-height: 1;
						text {
							font-size: $font-size-tag;
						}
						.iconfont {
							font-size: 36rpx;
							vertical-align: bottom;
							margin-right: 10rpx;
						}
					}
				}
			}
		}
	}
}
</style>
