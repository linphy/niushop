<template>
	<page-meta :page-style="themeColor"></page-meta>
	<view>
		<mescroll-uni @getData="getData" ref="mescroll">
			<block slot="list">
				<view class="article-wrap" v-if="list.length">
					<view class="item" v-for="(item, index) in list" :key="index" @click="toDetail(item)">
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
				<view v-else class="empty-wrap"><ns-empty text="暂无文章" :isIndex="false"></ns-empty></view>
				<loading-cover ref="loadingCover"></loading-cover>
			</block>
		</mescroll-uni>
	</view>
</template>

<script>
export default {
	data() {
		return {
			list: []
		};
	},
	onShow() {},
	methods: {
		getData(mescroll) {
			this.$api.sendRequest({
				url: '/api/article/page',
				data: {
					page_size: mescroll.size,
					page: mescroll.num
				},
				success: res => {
					let newArr = [];
					let msg = res.message;
					if (res.code == 0 && res.data) {
						newArr = res.data.list;
					} else {
						this.$util.showToast({
							title: msg
						});
					}
					mescroll.endSuccess(newArr.length);
					//设置列表数据
					if (mescroll.num == 1) this.list = []; //如果是第一页需手动制空列表
					this.list = this.list.concat(newArr); //追加新数据
					if (this.$refs.loadingCover) this.$refs.loadingCover.hide();
				},
				fail: res => {
					mescroll.endErr();
					if (this.$refs.loadingCover) this.$refs.loadingCover.hide();
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
	},
	onShareAppMessage(res) {
		var title = '文章列表';
		var path = '/pages_tool/article/list';
		return {
			title: title,
			path: path,
			success: res => {},
			fail: res => {}
		};
	}
};
</script>

<style lang="scss" scoped>
/deep/ .fixed {
	position: relative;
	top: 0;
}

.empty-wrap {
	padding-top: 200rpx;
}

.article-wrap {
	background: #f8f8f8;
	.item {
		display: flex;
		padding: 20rpx;
		background-color: #fff;
		margin-bottom: 20rpx;
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
</style>
