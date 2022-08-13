<template>
	<view class="category-page-wrap">
		<view class="search-box" v-if="value.search" @click="$util.redirectTo('/pages_tool/goods/search')">
			<view class="search-content">
				<input
					type="text"
					class="uni-input font-size-tag"
					maxlength="50"
					placeholder="商品搜索"
					confirm-type="search"
					disabled="true"
				/>
				<text class="iconfont iconsousuo1" ></text>
			</view>
		</view>
		
		<view class="content-box" v-if="categoryTree">
			<block v-if="categoryTree.length">
				<scroll-view scroll-y="true" class="tree-wrap">
					<view class="category-item" 
						v-for="(item, index) in categoryTree" :key="index"
						:class="{select: select == index}"
						@click="switchOneCategory(index)"
						>
						<view class="">{{ item.category_name }}</view>
					</view>
				</scroll-view>
				
				<view class="right-flex-wrap">
					<scroll-view scroll-y="true" class="content-wrap" v-if="value.template == 1 || loadType == 'all'"
						ref="contentWrap"
						:scroll-into-view="categoryId"
						:scroll-with-animation="true"
						@scroll="listenScroll"
						@touchstart="touchStart"
						:refresher-enabled="true"
						refresher-default-style="none"
						:refresher-triggered="triggered"
						@refresherrefresh="onRefresh"
						@refresherrestore="onRestore"
						>
						<view class="child-category" v-for="(item, index) in categoryTree" :key="index" :id="'category-' + index">
							<diy-category-item 
								:category="item" :value="value" ref="categoryItem" :index="index" :select="select"
								@tologin="toLogin" @selectsku="selectSku($event, index)" @addCart="addCartPoint" @loadfinish="getHeightArea"
							></diy-category-item>
						</view>
						<view class="end-tips" ref="endTips" :style="{opacity: endTips}">已经到底了~</view>
					</scroll-view>
					
					<view class="content-wrap" v-if="(value.template == 2 || value.template == 3) && loadType == 'part'">
						<view class="child-category-wrap" v-for="(item, index) in categoryTree" :key="index" :id="'category-' + index" :style="{display: select == index ? 'block' : 'none'}">
							<diy-category-item 
								:category="item" :value="value" ref="categoryItem" :index="index" :select="select" :last="index == categoryTree.length - 1 ? true : false"
								@tologin="toLogin" @selectsku="selectSku($event, index)" @addCart="addCartPoint" @switch="switchOneCategory"
							></diy-category-item>
						</view>
					</view>
					
				</view>
			</block>
			<view class="category-empty" v-else>
				<image :src="$util.img('public/uniapp/category/empty.png')" mode="widthFix"></image>
				<view class="tips">暂时没有分类哦！</view>
			</view>
		</view>
		
		<view class="cart-box" v-if="value.template == 2 && value.quickBuy && token && categoryTree && categoryTree.length">
			<view class="left-wrap">
				<view class="cart-icon" ref="cartIcon" :animation="cartAnimation" @click="$util.redirectTo('/pages/goods/cart')">
					<text class="iconfont iconziyuan1"></text>
					<view class="num" v-if="cartNumber">{{ cartNumber < 99 ? cartNumber : '99+'}}</view>
				</view>
				<view class="price">
					<text class="title">总计：</text>
					<text class="unit font-size-tag price-font">￥</text>
					<text class="money font-size-toolbar price-font">{{ cartMoney[0] }}</text>
					<text class="unit font-size-tag price-font">.{{ cartMoney[1] ? cartMoney[1] : '00' }}</text>
				</view>
			</view>
			<view class="right-wrap">
				<button type="primary" class="settlement-btn" @click="settlement">去结算</button>
			</view>
		</view>
		
		<view class="cart-point" :style="{left: item.left +'px', top: item.top+'px'}" :key="index" v-for="(item,index) in carIconList "></view>
		
		<ns-goods-sku-category ref="skuSelect" @addCart="addCartPoint"></ns-goods-sku-category>
	</view>
</template>

<script>
	import nsGoodsSkuCategory from '@/components/ns-goods-sku/ns-goods-sku-category.vue'
	
	var contentWrapHeight, query, cartPosition;
	
	export default {
		components: { nsGoodsSkuCategory },
		name: 'diy-category',
		props: {
			value: {
				type: Object,
				default: () => {
					return {};
				}
			}
		},
		data() {
			return {
				select: 0,
				categoryId: 'category-0',
				categoryTree: null,
				scrollLock: false,
				triggered: true,
				heightArea: [],
				isSub: false,
				token: null,
				carIconList: {},
				endTips: 0,
				cartAnimation: {},
				loadType: ''
			};
		},
		created() {
			this.getCategoryTree();
			this.$store.dispatch('getCartNumber'); 
			this.token = uni.getStorageSync('token');
			this.loadType = this.value.goodsLevel == 1 && this.value.loadType == 'all' ? 'all' : 'part';
		},
		mounted() {
			query = uni.createSelectorQuery().in(this);
			query.select('.content-wrap').boundingClientRect(data => {
				if (data) contentWrapHeight = data.height;
			}).exec();
			setTimeout(() => {
				query.select('.end-tips').boundingClientRect(data => {
					if (data && data.top > contentWrapHeight ) this.endTips = 1;
				}).exec();
				query.select('.cart-icon').boundingClientRect(data => {
					if (data) cartPosition = data;
				}).exec();
				if (this.value.template == 1) this.getHeightArea(-1);
			}, 500)
		},
		computed: {
			cartMoney(){
				let cartMoney = parseFloat(this.$store.state.cartMoney).toFixed(2);
				return cartMoney.split('.');
			},
			cartNumber(){
				return this.$store.state.cartNumber;
			}
		},
		methods:{
			/**
			 * 页面显示
			 */
			pageShow(){
				this.$store.dispatch('getCartNumber');
				this.token = uni.getStorageSync('token');
				if (!this.heightArea.length) this.getHeightArea(-1);
			},
			/**
			 * 获取高度区间 
			 */
			getHeightArea(index){
				let heightArea = [];
				query.selectAll('.content-wrap .child-category').boundingClientRect(data => {
					if (data && data.length) {
						data.forEach((item, index) => {
							if (index == 0) heightArea.push([0, item.height]);
							else heightArea.push([ heightArea[index - 1][1], heightArea[index - 1][1] + item.height]);
						})
					}
				}).exec();
				this.heightArea = heightArea;
				if (index != -1 && index < this.categoryTree.length - 1) this.$refs.categoryItem[index + 1].getGoodsList();
			},
			/**
			 * 获取全部分类
			 */
			getCategoryTree(){
				this.$api.sendRequest({
					url: '/api/goodscategory/tree',
					data: {
						level: 3,
					},
					success: res => {
						if (res.code == 0) this.categoryTree = res.data;
					}
				})
			},
			/**
			 * 切换一级分类
			 * @param {Object} index
			 */
			switchOneCategory(index){
				if (index >= this.categoryTree.length) return;
				this.select = index;
				this.categoryId = 'category-' + index;
				// 阻止切换分类之后滚动事件也立即执行
				this.scrollLock = true;
			},
			touchStart(){
				this.scrollLock = false;
			},
			/**
			 * 监听滚动
			 * @param {Object} event
			 */
			listenScroll(event){
				if (this.scrollLock) return;
				let scrollTop = event.detail.scrollTop;
				if (this.heightArea.length) {
					for(let i = 0; i < this.heightArea.length; i++) {
						if (scrollTop >= this.heightArea[i][0] && scrollTop <= this.heightArea[i][1]) {
							this.select = i;
							break;
						}
					}
					if (this.value.template != 1 && this.value.loadType == 'all' && this.heightArea[this.select][1] - scrollTop - contentWrapHeight < 300) {
						this.$refs.categoryItem[this.select].getGoodsList();
					}
				}
			},
			onRefresh(){
				this.triggered = false;
			},
			onRestore() {
				this.triggered = 'restore'; // 需要重置
			},
			toLogin(){
				this.$emit('tologin');
			},
			/**
			 * sku选择
			 * @param {Object} data
			 * @param {Object} index
			 */
			selectSku(data, index){
				this.$api.sendRequest({
					url: '/api/goodssku/getinfoforcategory',
					data: {
						sku_id: data.sku_id,
					},
					success: res => {
						let goodsSkuDetail = res.data;
						
						goodsSkuDetail.unit = goodsSkuDetail.unit || "件";
						goodsSkuDetail.show_price = goodsSkuDetail.discount_price;
						if (goodsSkuDetail.sku_spec_format) goodsSkuDetail.sku_spec_format = JSON.parse(goodsSkuDetail.sku_spec_format);
						if (goodsSkuDetail.goods_spec_format) goodsSkuDetail.goods_spec_format = JSON.parse(goodsSkuDetail.goods_spec_format);
						
						this.$refs.skuSelect.show("join_cart", goodsSkuDetail, () => {
						});
					}
				});
			},
			settlement(){
				let cartList = Object.keys(this.$store.state.cartList), cartIds = [];
				if (!cartList.length || this.isSub) return;
				this.isSub = true;
				
				cartList.forEach(key => {
					cartIds.push(this.$store.state.cartList[key].cart_id);
				})
				
				uni.removeStorageSync('delivery');
				uni.setStorage({
					key: 'orderCreateData',
					data: {
						cart_ids: cartIds.toString()
					},
					success: () => {
						this.$util.redirectTo('/pages/order/payment');
						this.isSub = false;
					}
				});
			},
			/**
			 * 添加点
			 * @param {Object} left
			 * @param {Object} top
			 */
			addCartPoint(left, top){
				if (this.value.template != 2 && !value.quickBuy) return;
				
				let key = (new Date()).getTime();
				this.$set(this.carIconList, key, {
					left: left,
					top: top,
					index: 0,
					bezierPos: this.$util.bezier([
						{x: left, y: top},
						{x: left - 200, y: left - 120},
						{x: cartPosition.left + 10, y: cartPosition.top}
					], 6).bezier_points,
					timer: null
				})
				this.startAnimation(key);
			},
			/**
			 * 执行动画
			 * @param {Object} key
			 */
			startAnimation(key){
				let bezierPos = this.carIconList[ key ].bezierPos,
					index = this.carIconList[ key ].index;
					
				this.carIconList[ key ].timer = setInterval(() => {
					if (index < 6) {
						this.carIconList[ key ].left = bezierPos[index].x;
						this.carIconList[ key ].top = bezierPos[index].y;
						index++;
					} else {
						clearInterval(this.carIconList[ key ].timer);
						delete this.carIconList[ key ];
						this.$forceUpdate()
						
						// 购物车图标
						setTimeout(() => {
							this.$store.commit('setCartChange');
						}, 100)
						let animation = uni.createAnimation({
							duration: 200,
							timingFunction: 'ease',
						})
						animation.scale(1.2).step();
						this.cartAnimation = animation.export()
						setTimeout(() => {
							animation.scale(1).step();
							this.cartAnimation = animation.export()
						}, 300)
					}
				}, 50)
			}
		}
	}
</script>

<style lang="scss">
	.category-page-wrap {
		width: 100vw;
		height: calc(100vh - var(--tab-bar-height, 0)); 
		display: flex;
		flex-direction: column;
	}
	
	.content-box {
		flex: 1;
		height: 0;
		display: flex;
		
		.tree-wrap {
			width: 170rpx;
			height: 100%;
			background-color: #F5F5F5;
		}
		
		.right-flex-wrap {
			flex: 1;
			width: 0;
			height: 100%;
			background: #fff;
			display: flex;
			flex-direction: column;
			transform: translateX(0px);
			
			.content-wrap {
				display: flex;
				flex: 1;
				height: 0;
				width: 100%;
			}
			
			.child-category-wrap {
				width: 100%;
				height: 100%;
			}
		}
	}
	
	.tree-wrap .category-item {
		line-height: 1.5;
		padding: 26rpx 28rpx;
		box-sizing: border-box;
		position: relative;
		
		view {
			color: #222222;
			width: 100%;
			white-space: nowrap;
			text-overflow: ellipsis;
			overflow: hidden;
			text-align: center;
		}
		
		&.select {
			background: #fff;
			view {
				color: #333;
				font-weight: bold;
			}
			&::before {
				content: ' ';
				width: 8rpx;
				height: 34rpx;
				background: var(--base-color);
				display: block;
				position: absolute;
				left: 0;
				top: 50%;
				transform: translateY(-50%);
			}
		}
	}
	
	.search-box {
		position: relative;
		padding: 20rpx 30rpx;
		display: flex;
		align-items: center;
		background: #fff;
		
		.search-content {
			position: relative;
			height: 70rpx;
			border-radius: 40rpx;
			flex: 1;
			background-color: #F5F5F5;
			
			input {
				box-sizing: border-box;
				display: block;
				height: 70rpx;
				width: 100%;
				padding: 0 20rpx 0 40rpx;
				background: #F5F5F5;
				color: #333;
				border-radius: 40rpx;
			}
			
			.iconfont {
				position: absolute;
				top: 50%;
				right: 10rpx;
				transform: translateY(-50%);
				font-size: $font-size-toolbar;
				z-index: 10;
				color: #89899a;
				width: 80rpx;
				text-align: center;
			}
		}
	}
	
	.cart-box {
		height: 100rpx;
		width: 100%;
		background: #fff;
		border-top: 1px solid #f5f5f5;
		box-sizing: border-box;
		padding: 0 30rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		
		.left-wrap {
			display: flex;
			align-items: center;
		}
		
		.cart-icon {
			width: 70rpx;
			height: 70rpx;
			position: relative;
			
			.iconfont {
				color: var(--btn-text-color);
				width: inherit;
				height: inherit;
				background-color: $base-color;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
			}
			
			.num {
				position: absolute;
				top: 0;
				right: 0;
				transform: translate(60%, 0);
				display: inline-block;
				box-sizing: border-box;
				color: #fff;
				line-height: 1.2;
				text-align: center;
				font-size: 24rpx;
				padding: 0 6rpx;
				min-width: 30rpx;
				border-radius: 16rpx;
				background-color: var(--price-color);
				border: 2rpx solid #fff;
			}
		}
		
		.price {
			margin-left: 30rpx;
			
			.title {
				color: #333;
			}
			
			.money,.unit {
				font-weight: bold;
				color: var(--price-color);
			}
		}
		
		.settlement-btn {
			margin: 0 0 0 20rpx;
			width: 200rpx;
			font-weight: bold;
		}
	}
	
	.cart-point {
		width: 26rpx;
		height: 26rpx;
		position: fixed;
		z-index: 1000;
		background: #f00;
		border-radius: 50%;
		transition: all .05s;
	}
	
	.category-empty {
		flex: 1;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		
		image {
			width: 380rpx;
		}
		
		.tips {
			font-size: 26rpx;
			font-weight: 500;
			color: #999;
			margin-top: 50rpx;
		}
	}
	
	.end-tips {
		text-align: center;
		color: #999;
		font-size: 24rpx;
		padding: 20rpx 0;
		opacity: 0;
	}
</style>
