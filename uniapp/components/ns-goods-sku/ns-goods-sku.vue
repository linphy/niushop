<template>
	<view class="goods-sku" @touchmove.prevent.stop>
		<uni-popup ref="skuPopup" type="bottom" class="sku-layer" @change="popclose">
			<view class="sku-info" :style="{ height: skuHeight }">
				<view class="header">
					<view class="img-wrap" @click="previewMedia()"><image :src="$util.img(goodsDetail.sku_image, { size: 'mid' })" @error="imageError()" mode="aspectFit" /></view>

					<view class="main">
						<view class="price-wrap">
							<text class="unit price-style small">￥</text>
							<block v-if="goodsDetail.discount_price > 0">
								<block v-if="goodsDetail.member_price">
									<text class="price price-style large" v-if="showPrice(goodsDetail.discount_price) < showPrice(goodsDetail.member_price)">
										{{
											parseFloat(goodsDetail.discount_price)
												.toFixed(2)
												.split('.')[0]
										}}
									</text>
									<text class="price price-style large" v-else>
										{{
											parseFloat(goodsDetail.member_price)
												.toFixed(2)
												.split('.')[0]
										}}
									</text>
									<text class="unit price-style small" v-if="showPrice(goodsDetail.discount_price) < showPrice(goodsDetail.member_price)">
										.{{
											parseFloat(goodsDetail.discount_price)
												.toFixed(2)
												.split('.')[1]
										}}
									</text>
									<text class="unit price-style small" v-else>
										.{{
											parseFloat(goodsDetail.member_price)
												.toFixed(2)
												.split('.')[1]
										}}
									</text>
								</block>
								<block v-else>
									<text class="price price-style large" v-if="showPrice(goodsDetail.discount_price) < showPrice(goodsDetail.price)">
										{{
											parseFloat(goodsDetail.discount_price)
												.toFixed(2)
												.split('.')[0]
										}}
									</text>
									<text class="price price-style large" v-else>
										{{
											parseFloat(goodsDetail.price)
												.toFixed(2)
												.split('.')[0]
										}}
									</text>
									<text class="unit price-style small" v-if="showPrice(goodsDetail.discount_price) < showPrice(goodsDetail.price)">
										.{{
											parseFloat(goodsDetail.discount_price)
												.toFixed(2)
												.split('.')[1]
										}}
									</text>
									<text class="unit price-style small" v-else>
										.{{
											parseFloat(goodsDetail.price)
												.toFixed(2)
												.split('.')[1]
										}}
									</text>
								</block>
							</block>
							<block v-else>
								<text class="price price-style large" v-if="goodsDetail.member_price">
									{{
										parseFloat(goodsDetail.member_price)
											.toFixed(2)
											.split('.')[0]
									}}
								</text>
								<text class="price price-style large" v-else>
									{{
										parseFloat(goodsDetail.price)
											.toFixed(2)
											.split('.')[0]
									}}
								</text>
								<text class="unit price-style small" v-if="goodsDetail.member_price">
									.{{
										parseFloat(goodsDetail.member_price)
											.toFixed(2)
											.split('.')[1]
									}}
								</text>
								<text class="unit price-style small" v-else>
									.{{
										parseFloat(goodsDetail.price)
											.toFixed(2)
											.split('.')[1]
									}}
								</text>
							</block>
						</view>
						<view class="stock">
							<block v-if="goodsDetail.stock_show">库存{{ goodsDetail.stock }}{{ goodsDetail.unit }}</block>
						</view>

						<view class="sku-name font-size-tag" v-if="goodsDetail.sku_spec_format">
							<text class="color-tip">已选规格：</text>
							<text v-for="(item, index) in goodsDetail.sku_spec_format" :key="index" class="spec-value">{{ item.spec_value_name }}</text>
						</view>
					</view>

					<view class="sku-close iconfont icon-close" @click="closeSkuPopup()"></view>
				</view>

				<view class="body-item">
					<scroll-view scroll-y class="wrap">
						<view class="sku-list-wrap" v-for="(item, index) in goodsDetail.goods_spec_format" :key="index">
							<text class="title font-size-base">{{ item.spec_name }}</text>
							<view
								v-for="(item_value, index_value) in item.value"
								:key="index_value"
								:class="{
									selected: item_value['selected'] || skuId == item_value.sku_id,
									disabled: item_value['disabled'] || (!item_value['selected'] && disabled)
								}"
								class="items"
								@click="change(item_value.sku_id, item_value.spec_id)"
							>
								<image v-if="item_value.image" :src="$util.img(item_value.image, { size: 'small' })" @error="valueImageError(index, index_value)" />
								<text>{{ item_value.spec_value_name }}</text>
							</view>
						</view>

						<view class="number-wrap">
							<view class="number-line">
								<text class="title font-size-base">购买数量</text>
								<text class="limit-txt color-base-text" v-if="limitNumber > 0">(每人限购{{ limitNumber }}{{ goodsDetail.unit }})</text>
								<text v-if="maxBuy > 0 && minBuy > 1" class="limit-txt color-base-text">
									({{ minBuy }}{{ goodsDetail.unit }}起售，限购{{ maxBuy }}{{ goodsDetail.unit }})
								</text>
								<text v-else-if="maxBuy > 0" class="limit-txt color-base-text">(限购{{ maxBuy }}{{ goodsDetail.unit }})</text>
								<text v-else-if="minBuy > 1" class="limit-txt color-base-text">({{ minBuy }}{{ goodsDetail.unit }}起售)</text>
								<view class="number">
									<button type="default" class="decrease color-line-border" :class="{ disabled: decreaseDisabled }" @click="changeNum('-')">-</button>
									<input
										type="number"
										class="uni-input color-line-border font-size-goods-tag"
										@blur="blur"
										v-model="number"
										placeholder="0"
										@input="keyInput(false)"
									/>
									<button type="default" class="increase color-line-border" :class="{ disabled: increaseDisabled }" @click="changeNum('+')">+</button>
									<!-- v-if="max_buy == 1" -->
									<!-- <button v-else type="default" class="increase color-line-border" @click="changeNum('+')">+</button> -->
								</view>
							</view>
						</view>
					</scroll-view>
				</view>
				<view class="footer" @click="confirm()">
					<button type="primary" v-if="goodsDetail.stock && goodsDetail.stock != 0 && type == 'join_cart'">加入购物车</button>
					<button type="primary" v-else-if="goodsDetail.stock && goodsDetail.stock != 0 && type == 'buy_now'">立即购买</button>
					<button type="primary" v-else-if="goodsDetail.stock && goodsDetail.stock != 0 && type == 'confirm'">确认</button>
					<template v-else-if="goodsDetail.stock && goodsDetail.stock != 0">
						<template v-if="goodsDetail.buy_num">
							<button type="primary" v-if="goodsDetail.buy_num <= goodsDetail.stock">立即抢购</button>
							<button type="primary" v-else disabled="true">库存不足</button>
						</template>
						<template v-else>
							<button type="primary">立即抢购</button>
						</template>
					</template>
					<button type="primary" v-else disabled="true">库存不足</button>
				</view>
			</view>
		</uni-popup>
		<ns-login ref="login"></ns-login>
	</view>
</template>

<script>
import uniPopup from '@/components/uni-popup/uni-popup-sku.vue';
// 商品SKU
export default {
	name: 'ns-goods-sku',
	components: {
		uniPopup
	},
	props: {
		goodsId: {
			type: [Number, String],
			default: 0
		},
		goodsDetail: {
			type: Object,
			default: null
		},
		disabled: {
			type: Boolean,
			default: false
		},
		pointLimit: {
			type: [Number, String]
		},
		maxBuy: {
			type: Number,
			default: 0
		},
		minBuy: {
			type: Number,
			default: 0
		}
	},
	data() {
		return {
			isIphoneX: false,
			systemInfo: {}, //系统信息
			number: 1,
			btnSwitch: false, //提交按钮防止重复提交
			type: '', //join_cart：加入购物车，buy_now：立即购买
			callback: null, //回调
			skuId: 0,
			limitNumber: 0, // 限购
			minNumber: 0,
			//是否开启预览，0：不开启，1：开启
			preview: 0,
			cartNumber: 0, // 购物车中商品存在的数量
			goodsSkuDetail: {},
			goodsSkuInfo: null, //所有的商品规格信息
			isLoad: false // 是否首次加载
		};
	},
	created() {
		this.isIphoneX = this.$util.uniappIsIPhoneX();
		this.systemInfo = uni.getSystemInfoSync();
		this.isLoad = true;
		if (this.goodsId && this.goodsDetail.goods_spec_format) {
			this.skuId = this.goodsDetail.sku_id;
			this.getAllGoodsSkuInfo();
		}
	},
	watch: {
		pointLimit(newNum, oldNum) {
			this.limitNumber = Number(newNum);
		},
		goodsDetail: {
			handler(newData, oldData) {
				this.skuId = newData.sku_id;
			},
			deep: true // 深度监听父组件传过来对象变化
		},
		minBuy(newData, oldData) {
			if (this.minBuy > 1) {
				this.number = Number(this.minBuy);
			}
		}
	},
	computed: {
		decreaseDisabled: function() {
			let min = this.minBuy > 0 ? this.minBuy : 1;
			return this.number <= min;
		},
		increaseDisabled: function() {
			let max = this.maxBuy > 0 && this.maxBuy < this.goodsDetail.stock ? this.maxBuy : this.goodsDetail.stock;
			return this.number >= max;
		},
		skuHeight() {
			let height = 48;
			if (this.goodsDetail) {
				if (this.goodsDetail.goods_spec_format && this.goodsDetail.goods_spec_format.length) {
					height = 51 + this.goodsDetail.goods_spec_format.length * 9.5;
				}
			}
			height += 'vh';
			return height;
		}
	},
	methods: {
		//【普通商品】获取所有规格信息
		getAllGoodsSkuInfo(callback) {
			this.$api.sendRequest({
				url: '/api/goodssku/goodsSku',
				data: {
					goods_id: this.goodsId
				},
				success: res => {
					if (res.code >= 0) {
						let data = res.data,
							obj = {};

						res.data.forEach((item, index) => {
							item = this.handleData(item);

							// 限时折扣
							if (item.promotion_type == 1) {
								item.discountTimeMachine = this.$util.countDown(item.end_time - res.timestamp);
							}

							if (item.promotion_type == 1 && item.discountTimeMachine) {
								if (item.member_price > 0 && Number(item.member_price) <= Number(item.discount_price)) {
									item.show_price = item.member_price;
								} else {
									item.show_price = item.discount_price;
								}
							} else if (item.member_price > 0) {
								item.show_price = item.member_price;
							} else {
								item.show_price = item.price;
							}

							obj['sku_' + item.sku_id] = item;
						});
						if (this.skuId == 0) this.skuId = res.data[0].sku_id;
						this.goodsSkuInfo = obj;
						this.isLoad = false;
						if (callback) callback();
					} else {
						this.$util.redirectTo('/pages/index/index');
					}
				}
			});
		},
		handleData(item) {
			if (item.sku_images) item.sku_images = item.sku_images.split(',');
			else item.sku_images = [];

			// 多规格时合并主图
			if (item.goods_spec_format && item.goods_image) {
				item.goods_image = item.goods_image.split(',');
				item.sku_images = item.goods_image.concat(item.sku_images);
			}

			// 当前商品SKU规格
			if (item.sku_spec_format) item.sku_spec_format = JSON.parse(item.sku_spec_format);

			// 商品SKU格式
			if (item.goods_spec_format) item.goods_spec_format = JSON.parse(item.goods_spec_format);

			return item;
		},
		show(type, callback, data) {
			this.callback = callback;

			// 排除购物车切换规格
			if (this.type != 'confirm') {
				this.$refs.skuPopup.open();
			}
			this.type = type;
			this.skuId = this.goodsDetail.sku_id;
			this.preview = this.goodsDetail.preview || 0;
			if (this.type == 'confirm') {
				if (this.isLoad) return;

				// 购物车切换规格
				this.goodsId = data.goods_id;
				this.skuId = data.sku_id;
				this.getAllGoodsSkuInfo(() => {
					this.$refs.skuPopup.open();
				});
			}
			if (this.type == 'join_cart') this.getCartData();
			this.$forceUpdate();
		},
		hide() {
			this.$emit('hideSkuPop');
			this.$refs.skuPopup.close();
		},
		popclose() {
			if (this.$refs.skuPopup.showPopup) {
				this.$emit('hideSkuPop');
			}
		},
		//查看规格图片
		previewMedia() {
			var paths = [];
			paths.push(
				this.$util.img(this.goodsDetail.sku_image, {
					size: 'big'
				})
			);
			uni.previewImage({
				current: 1,
				urls: paths
			});
		},
		change(skuId, spec_id) {
			if (this.goodsSkuInfo == null) return;
			if (this.disabled) return;
			this.btnSwitch = false;

			this.skuId = skuId;

			// 清空选择
			for (var i = 0; i < this.goodsDetail.goods_spec_format.length; i++) {
				var sku = this.goodsDetail.goods_spec_format[i];
				for (var j = 0; j < sku.value.length; j++) {
					// 排除当前点击的规格值
					if (spec_id == this.goodsDetail.goods_spec_format[i].value[j].spec_id) {
						this.goodsDetail.goods_spec_format[i].value[j].selected = false;
					}
				}
			}

			this.goodsSkuDetail = this.goodsSkuInfo['sku_' + this.skuId];
			this.$emit('refresh', this.goodsSkuDetail);
			this.$emit('getSkuId', this.skuId);
			this.keyInput(true);
		},
		showPrice(price) {
			return parseFloat(price);
		},
		changeNum(tag) {
			if (this.goodsDetail.stock == 0) return;
			var min = 1;
			var stock = this.goodsDetail.stock;

			if (this.maxBuy == 1) {
				stock = 1;
			}

			if (this.goodsDetail.is_limit == 1 && this.maxBuy > 0 && this.maxBuy < stock) stock = this.maxBuy;

			if (this.goodsDetail.is_limit == 1 && this.goodsDetail.limit_type == 2 && this.maxBuy > 0 && this.goodsDetail.purchased_num > 0) {
				let maxBuy = this.maxBuy - this.goodsDetail.purchased_num;
				stock = maxBuy < this.goodsDetail.stock ? maxBuy : this.goodsDetail.stock;
			}

			if (this.minBuy > 1) {
				min = this.minBuy;
			}

			if (tag == '+') {
				// 加
				if (this.number < stock) {
					this.number++;
				} else {
					if (this.number >= this.goodsDetail.stock) {
						this.$util.showToast({
							title: '库存不足'
						});
						return;
					}

					if (this.goodsDetail.is_limit == 1 && this.maxBuy > 0) {
						if (this.goodsDetail.limit_type == 1) {
							this.$util.showToast({
								title: '该商品每次最多购买' + this.maxBuy + this.goodsDetail.unit
							});
							return;
						}

						if (this.goodsDetail.limit_type == 2) {
							let message = '该商品每人限购' + this.maxBuy + this.goodsDetail.unit;
							message += this.goodsDetail.purchased_num > 0 ? '，您已购买了' + this.goodsDetail.purchased_num + this.goodsDetail.unit : '';
							this.$util.showToast({
								title: message
							});
							return;
						}
					}

					if (this.type == 'seckill' && this.goodsDetail.seckill_id && this.goodsDetail.num > 0) {
						this.$util.showToast({
							title: '该商品每人限购' + this.goodsDetail.num + this.goodsDetail.unit
						});
						return;
					}

					if (this.type == 'presale' && this.goodsDetail.presale_id && this.goodsDetail.presale_num > 0) {
						this.$util.showToast({
							title: '该商品每人限购' + this.goodsDetail.presale_num + this.goodsDetail.unit
						});
						return;
					}
				}
			} else if (tag == '-') {
				// 减
				if (this.number > min) {
					this.number -= 1;
				} else {
					if (this.minBuy > 1) {
						this.$util.showToast({
							title: '该商品' + this.minBuy + this.goodsDetail.unit + '起售'
						});
					}
					return;
				}
			}
			if (this.number > this.limitNumber && this.limitNumber) {
				this.number = this.limitNumber;
			}
		},
		blur() {
			if (!this.number) {
				this.number = 0;
			}
			if (this.number > this.limitNumber && this.limitNumber) {
				this.number = this.limitNumber;
			}
			if (this.number < this.minNumber && this.minNumber) {
				this.number = this.minNumber;
			}

			if (this.goodsDetail.is_limit == 1 && this.maxBuy > 0 && this.number > this.maxBuy) {
				this.number = this.maxBuy;
			}

			if (this.goodsDetail.is_limit == 1 && this.maxBuy > 0 && this.goodsDetail.purchased_num > 0) {
				let maxBuy = this.maxBuy - this.goodsDetail.purchased_num;
				if (this.number > maxBuy) this.number = maxBuy;
			}
			if (this.number < this.minBuy && this.minBuy > 0) {
				this.number = this.minBuy;
			}

			if (this.number <= 0) {
				this.number = 1;
			}
		},
		//输入数量
		keyInput(flag, callback) {
			setTimeout(() => {
				var stock = this.goodsDetail.stock;

				// 库存为0
				if (this.goodsDetail.stock == 0) {
					this.number = 0;
					return;
				}

				// 防止空
				if (flag && this.number.length == 0) this.number = 1;

				// 防止输入0和负数、非法输入
				if (flag && (this.number <= 0 || isNaN(this.number))) this.number = 1;

				if (this.number > stock) {
					this.number = stock;
				}
				// 商品起售数
				if (this.minBuy > 1 && this.number < this.minBuy) {
					this.number = this.minBuy;
				}

				if (flag) this.number = parseInt(this.number);
				if (callback) callback();
			}, 0);
		},

		//提交
		confirm() {
			// 删除待付款物流方式缓存
			uni.removeStorageSync('delivery');
			if (this.preview) {
				this.$util.showToast({
					title: '预览商品无法购买'
				});
				return;
			}

			if (!uni.getStorageSync('token')) {
				this.$refs.login.open();
				return;
			}

			//纠正数量
			this.keyInput(true, () => {
				if (this.goodsDetail.stock == 0) {
					this.$util.showToast({
						title: '商品已售罄'
					});
					return;
				}

				if (this.number.length == 0 || this.number <= 0) {
					this.$util.showToast({
						title: '购买数量不能小于等于0'
					});
					return;
				}

				if (this.goodsDetail.buy_num > this.goodsDetail.stock) {
					this.$util.showToast({
						title: '库存小于最低购买数量'
					});
					return;
				}

				if (this.number > this.goodsDetail.stock) {
					this.$util.showToast({
						title: '库存不足'
					});
					return;
				}

				if (this.goodsDetail.is_limit == 1 && this.goodsDetail.limit_type == 1 && this.maxBuy > 0 && this.number > this.maxBuy) {
					this.$util.showToast({
						title: '该商品每次最多购买' + this.maxBuy + this.goodsDetail.unit
					});
					return;
				}

				if (this.goodsDetail.is_limit == 1 && this.goodsDetail.limit_type == 2 && this.maxBuy > 0 && this.number + this.goodsDetail.purchased_num > this.maxBuy) {
					let message = '该商品每人限购' + this.maxBuy + this.goodsDetail.unit;
					message += this.goodsDetail.purchased_num > 0 ? '，您已购买了' + this.goodsDetail.purchased_num + this.goodsDetail.unit : '';
					this.$util.showToast({
						title: message
					});
					return;
				}

				if (this.type == 'join_cart' && this.goodsDetail.is_limit == 1 && this.maxBuy > 0 && this.cartNumber + this.number > this.maxBuy) {
					this.$util.showToast({
						title: '该商品每人限购' + this.maxBuy + this.goodsDetail.unit
					});
					return;
				}

				if (this.btnSwitch) return;
				this.btnSwitch = true;

				if (this.type == 'join_cart') {
					this.$api.sendRequest({
						url: '/api/cart/add',
						data: {
							sku_id: this.skuId,
							num: this.number
						},
						success: res => {
							var data = res.data;
							if (data > 0) {
								this.$util.showToast({
									title: '加入购物车成功'
								});
								this.cartNumber += this.number;
								if (this.callback) this.callback();
							}
							this.$refs.skuPopup.close();
							this.btnSwitch = false;
						},
						fail: res => {
							this.$refs.skuPopup.close();
							this.btnSwitch = false;
						}
					});
				} else if (this.type == 'buy_now') {
					var data = {
						sku_id: this.skuId,
						num: this.number
					};

					uni.setStorage({
						key: 'orderCreateData',
						data: data,
						success: () => {
							this.$util.redirectTo('/pages/order/payment');
							this.btnSwitch = false;
						}
					});
				} else if (this.type == 'confirm') {
					this.btnSwitch = false;
					this.$refs.skuPopup.close();
					if (this.callback) this.callback(this.skuId, this.number);
				}
			});
		},
		closeSkuPopup() {
			this.$emit('hideSkuPop');
			this.$refs.skuPopup.close();
		},
		imageError() {
			this.goodsDetail.sku_image = this.$util.getDefaultImage().goods;
			this.$forceUpdate();
		},
		valueImageError(index, index_value) {
			this.goodsDetail.goods_spec_format[index].value[index_value].image = this.$util.getDefaultImage().goods;
			this.$forceUpdate();
		},
		// 获取购物车数据
		getCartData() {
			this.$api.sendRequest({
				url: '/api/cart/goodsnum',
				data: {
					goods_id: this.goodsDetail.goods_id
				},
				success: res => {
					if (res.code >= 0) {
						this.cartNumber = res.data;
					}
				}
			});
		}
	}
};
</script>
<style lang="scss">
.sku-layer .sku-info {
	max-height: 75vh;
	height: 45vh;
	position: relative;
	z-index: 999;
}

.sku-layer .sku-info .header {
	padding: 30rpx 30rpx 20rpx 210rpx;
	position: relative;
	border-bottom: 2rpx solid $color-line;
	min-height: 170rpx;
}

.sku-layer .sku-info .header .img-wrap {
	width: 160rpx;
	height: 160rpx;
	position: absolute;
	left: 20rpx;
	border-radius: $border-radius;
	overflow: hidden;
	padding: 2rpx;
	background-color: #fff;
	line-height: 208rpx;
}

.sku-layer .sku-info .header .img-wrap image {
	width: 100%;
	height: 100%;
}

.sku-layer .sku-info .main {
	font-size: 24rpx;
	line-height: 40rpx;
	padding-right: 40rpx;

	.price-wrap {
		font-weight: bold;

		.unit {
			margin-right: 4rpx;
		}
	}

	.stock {
		font-size: $font-size-tag;
		color: $color-tip;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		height: 70rpx;
		overflow: hidden;
	}
}

.sku-layer .sku-info .main .price {
	word-wrap: break-word;
}

.sku-layer .sku-info .main .sku-name {
	display: -webkit-box;
	-webkit-line-clamp: 1;
	-webkit-box-orient: vertical;
	overflow: hidden;
	height: 42rpx;

	.spec-value {
		&::after {
			content: '/';
		}

		&:last-child {
			&::after {
				content: '';
			}
		}
	}
}

.sku-layer .sku-info .sku-close {
	position: absolute;
	top: 20rpx;
	right: 40rpx;
	width: 40rpx;
	height: 80rpx;
	font-size: 40rpx;
}

.sku-layer .body-item {
	padding: 0 30rpx;
	height: calc(100% - 360rpx);
	box-sizing: border-box;
	overflow: scroll;
}

.sku-layer .body-item .wrap {
	height: calc(100% - 60rpx);
}

.sku-layer .body-item .sku-list-wrap {
	padding-bottom: 0rpx;
}

.sku-layer .body-item .sku-list-wrap .title {
	padding: 20rpx 0;
	display: block;
}

.sku-layer .body-item .sku-list-wrap .items {
	position: relative;
	display: inline-block;
	border: 2rpx solid $color-line;
	padding: 4rpx 30rpx;
	border-radius: 8rpx;
	margin: 0 20rpx 20rpx 0;
	background-color: #fff;
	font-size: $font-size-tag;
}

.sku-layer .body-item .sku-list-wrap .items.disabled {
	border: 2rpx dashed;
}

.sku-layer .body-item .sku-list-wrap .items image {
	height: 44rpx;
	width: 44rpx;
	border-radius: $border-radius;
	margin-right: 10rpx;
	display: inline-block;
	vertical-align: middle;
}

.sku-layer .body-item .number-wrap .number-line {
	padding: 20rpx 0;
	line-height: 72rpx;
}

.sku-layer .body-item .number-wrap .title {
	font-weight: 400;
}

.sku-layer .body-item .number-wrap .limit-txt {
}

.sku-layer .body-item .number-wrap .number {
	display: flex;
	height: 72rpx;
	border-radius: 6rpx;
	float: right;
}

.sku-layer .body-item .number-wrap .number button {
	display: inline-block;
	line-height: 64rpx;
	height: 68rpx;
	width: 60rpx;
	font-size: 48rpx;
	box-sizing: content-box;
	border: 2rpx solid $color-line;
	padding: 0;
	margin: 0;
	border-radius: 0;
	background-color: #fff !important;

	&.disabled {
		background: #f7f7f7 !important;
	}
}

.sku-layer .body-item .number-wrap .number button.decrease {
	border-right-width: 0 !important;
}

.sku-layer .body-item .number-wrap .number button.increase {
	border-left: 0 !important;
}

.sku-layer .body-item .number-wrap .number button:after {
	border-radius: 0;
	border: none;
}

.sku-layer .body-item .number-wrap .number input {
	display: inline-block;
	line-height: 64rpx;
	height: 68rpx;
	width: 72rpx;
	text-align: center;
	font-weight: 700;
	border: 2rpx solid;
	margin: 0;
	padding: 0;
	vertical-align: top;
	background-color: $color-bg !important;
}

.sku-layer .footer {
	height: 100rpx;
	width: 100%;
	position: absolute;
	bottom: 30rpx;
	bottom: calc(30rpx + constant(safe-area-inset-bottom));
	bottom: calc(30rpx + env(safe-area-inset-bottom));
	color: #fff;
	z-index: 1;
	display: flex;
	justify-content: center;
	align-items: flex-start;

	button {
		width: 100%;
		height: 80rpx;
		background-color: var(--goods-btn-color);
		font-weight: bold;
	}
}
</style>
