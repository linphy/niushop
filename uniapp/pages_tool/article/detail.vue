<template>
	<page-meta :page-style="themeColor"></page-meta>
	<view class="page">
		<view class="help-title">{{ detail.article_title }}</view>
		<view class="help-content"><rich-text :nodes="content"></rich-text></view>
		<view class="help-meta">
			<text class="help-time">发表时间: {{ $util.timeStampTurnTime(detail.create_time) }}</text>
		</view>
		<loading-cover ref="loadingCover"></loading-cover>
	</view>
</template>

<script>
import htmlParser from '@/common/js/html-parser';
export default {
	data() {
		return {
			articleId: 0,
			detail: {},
			content: ''
		};
	},
	onLoad(options) {
		this.articleId = options.article_id || 0;
		if (this.articleId == 0) {
			this.$util.redirectTo('/pages_tool/help/list', {}, 'redirectTo');
			return;
		}
		this.getData();
	},
	onShow() {},
	methods: {
		getData() {
			this.$api.sendRequest({
				url: '/api/article/info',
				data: {
					article_id: this.articleId
				},
				success: res => {
					if (res.code == 0 && res.data) {
						this.detail = res.data;
						this.$langConfig.title(this.detail.article_title);
						this.content = htmlParser(this.detail.article_content);
					} else {
						this.$util.showToast({
							title: res.message
						});
						setTimeout(() => {
							this.$util.redirectTo('/pages_tool/article/list', {}, 'redirectTo');
						}, 2000);
					}
					if (this.$refs.loadingCover) this.$refs.loadingCover.hide();
				},
				fail: res => {
					if (this.$refs.loadingCover) this.$refs.loadingCover.hide();
				}
			});
		}
	},
	onShareAppMessage(res) {
		var title = this.detail.article_title;
		var path = '/pages_tool/article/detail?article_id=' + this.articleId;
		return {
			title: title,
			path: path,
			success: res => {},
			fail: res => {}
		};
	}
};
</script>

<style lang="scss">
.page {
	width: 100%;
	height: 100%;
	padding: 30rpx;
	box-sizing: border-box;
	background: #ffffff;
}

.help-title {
	font-size: $font-size-toolbar;
	text-align: center;
}

.help-content {
	margin-top: $margin-updown;
	word-break: break-all;
}

.help-meta {
	text-align: right;
	margin-top: $margin-updown;
	color: $color-tip;

	.help-time {
		font-size: $font-size-tag;
	}
}
</style>
