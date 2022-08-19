<template>
	<view class="diy-group">
		<view v-for="(item, index) in diyGlobalData.value" :key="index" :style="item.pageStyle">
			<template v-if="item.componentName == 'Text'">
				<!-- 文本 -->
				<diy-text :value="item"></diy-text>
			</template>

			<template v-if="item.componentName == 'TextNav'">
				<!-- 文本导航 -->
				<diy-text-nav :value="item"></diy-text-nav>
			</template>

			<template v-if="item.componentName == 'Notice'">
				<!-- 公告 -->
				<diy-notice :value="item"></diy-notice>
			</template>

			<template v-if="item.componentName == 'GraphicNav'">
				<!-- 图文导航 -->
				<diy-graphic-nav :value="item"></diy-graphic-nav>
			</template>

			<template v-if="item.componentName == 'ImageAds'">
				<!-- 图片广告 -->
				<view :class="!showStore || !addonIsExist.store ? 'noStore-bg' : ''"><diy-img-ads :value="item"></diy-img-ads></view>
			</template>

			<template v-if="item.componentName == 'Search'">
				<!-- 搜索 -->
				<view :class="!showStore || !addonIsExist.store ? 'noStore-bg' : ''"><diy-search :value="item"></diy-search></view>
				<!-- <view :class="!showStore || !addonIsExist.store ? 'noStore-bg' : 'isStore-top'">
					<diy-search :value="item"></diy-search>
				</view> -->
			</template>

			<template v-if="item.componentName == 'RichText'">
				<!-- 富文本 -->
				<diy-rich-text :value="item"></diy-rich-text>
			</template>

			<template v-if="item.componentName == 'HorzLine'">
				<!-- 辅助线 -->
				<diy-horz-line :value="item"></diy-horz-line>
			</template>

			<template v-if="item.componentName == 'HorzBlank'">
				<!-- 辅助空白 -->
				<diy-horz-blank :value="item"></diy-horz-blank>
			</template>

			<template v-if="item.componentName == 'Coupon' && addonIsExist.coupon">
				<!-- 优惠券 -->
				<diy-coupon :value="item"></diy-coupon>
			</template>

			<template v-if="item.componentName == 'GoodsList'">
				<!-- 商品列表 -->
				<diy-goods-list :value="item"></diy-goods-list>
			</template>

			<template v-if="item.componentName == 'ManyGoodsList'">
				<!-- 多商品组 -->
				<diy-many-goods-list :value="item"></diy-many-goods-list>
			</template>

			<template v-if="item.componentName == 'RubikCube'">
				<!-- 魔方、橱窗 -->
				<diy-rubik-cube :value="item"></diy-rubik-cube>
			</template>

			<template v-if="item.componentName == 'Video'">
				<!-- 视频 -->
				<diy-video :value="item"></diy-video>
			</template>

			<view class="diy-goods-level-wrap" v-if="item.componentName == 'GoodsCategory'">
				<!-- 商品分类 使用view替代template目的是限制商品分类在自定义首页的高度-->
				<diy-category :value="item"></diy-category>
			</view>

			<template v-if="item.componentName == 'FloatBtn'">
				<!-- 浮动按钮 -->
				<diy-float-btn :value="item"></diy-float-btn>
			</template>

			<template v-if="item.componentName == 'GoodsRecommend'">
				<!-- 商品推荐 -->
				<diy-goods-recommend :value="item"></diy-goods-recommend>
			</template>

			<template v-if="item.componentName == 'GoodsBrand'">
				<!-- 商品品牌 -->
				<diy-goods-brand :value="item"></diy-goods-brand>
			</template>

			<template v-if="item.componentName == 'Article'">
				<!-- 文章 -->
				<diy-article :value="item"></diy-article>
			</template>
		</view>
	</view>
</template>

<script>
export default {
	components: {},
	props: {
		diyData: {
			type: Object
		},
		storeId: {
			type: [String, Number]
		},
		height: {
			type: String,
			default() {
				return '100vh';
			}
		}
	},
	data() {
		return {
			showStore: false,
			diyGlobalData: null
		};
	},
	created() {
		this.diyGlobalData = JSON.parse(JSON.stringify(this.diyData));
		this.setPagestyle();
	},
	computed: {
		bgColor() {
			let str = '';
			if (this.diyData && this.diyData.global) {
				str = this.diyData.global.bgColor;
			}
			return str;
		},
		bgUrl() {
			let str = '';
			if (this.diyData && this.diyData.global) {
				str = this.diyData.global.bgUrl;
			}
			return str;
		}
	},
	mounted() {
		if (this.diyData != undefined) {
			this.dealData();
		}
	},
	methods: {
		setPagestyle() {
			this.diyGlobalData.value.forEach((item, index) => {
				item.pageStyle = '';
				item.pageStyle += 'background-color:' + item.pageBgColor + ';';
				if (item.margin) {
					item.pageStyle += 'padding-top:' + item.margin.top * 2 + 'rpx' + ';';
					item.pageStyle += 'padding-bottom:' + item.margin.bottom * 2 + 'rpx' + ';';
					item.pageStyle += 'padding-right:' + item.margin.both * 2 + 'rpx' + ';';
					item.pageStyle += 'padding-left:' + item.margin.both * 2 + 'rpx' + ';';
				}
			});
		},
		// 刷新数据
		refresh(data) {
			this.diyGlobalData = {}; // 必须先清空自定义组件集合，然后异步刷新
			setTimeout(() => {
				this.diyGlobalData = data;
				this.setPagestyle();
			}, 1);
		},
		dealData() {
			if (Array.isArray(this.diyData.value)) {
				for (var i = 0; i < this.diyData.value.length; i++) {
					if (this.diyData.value[i].componentName == 'StoreShow') {
						this.showStore = true;
					}
				}
			}
		}
	}
};
</script>

<style lang="scss">
.diy-group {
	width: 100%;
}
// .diy-goods-level-wrap {
// 	position: relative;
// 	height: 60vh;
// }
</style>
