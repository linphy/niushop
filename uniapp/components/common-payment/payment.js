export default {
	data() {
		return {
			outTradeNo: '',
			isIphoneX: false,
			orderCreateData: {
				is_balance: 0,
				is_point: 1,
				is_invoice: 0, // 是否需要发票 0 无发票  1 有发票
				invoice_type: 1, // 发票类型  1 纸质 2 电子
				invoice_title_type: 1, // 抬头类型  1 个人 2 企业
				is_tax_invoice: 0, // 是否需要增值税专用发票  0 不需要 1 需要
				coupon: {
					coupon_id: 0
				}
			},
			paymentData: null,
			calculateData: null,
			tempData: null,
			storeId: 0,
			deliveryTime: '', // 提货时间
			memberAddress: null, // 会员收货地址
			localMemberAddress: null, // 会员本地配送收货地址
			isRepeat: false,
			promotionInfo: null,
			transactionAgreement: {} // 购买须知
		}
	},
	inject: ['promotion'],
	created(){
		this.isIphoneX = this.$util.uniappIsIPhoneX()
		if (uni.getStorageSync('token')) {
			Object.assign(this.orderCreateData, uni.getStorageSync(this.createDataKey))
			if (this.location) {
				this.orderCreateData.latitude = this.location.latitude;
				this.orderCreateData.longitude = this.location.longitude;
			}
			this.payment();
		} else {
			setTimeout(() => {
				this.$refs.loadingCover.hide();
				this.$refs.login.open(this.$util.getCurrentRoute().path)
			})
		}
		this.getTransactionAgreement();
	},
	computed: {
		storeToken() {
			return this.$store.state.token;
		},
		goodsData(){
			if (this.paymentData) {
				this.paymentData.shop_goods_list.goods_list.forEach(item => {
					if (item.sku_spec_format) item.sku_spec_format = JSON.parse(item.sku_spec_format); 
				})
				return this.paymentData.shop_goods_list;
			}
		},
		calculateGoodsData(){
			if (this.calculateData) return this.calculateData.shop_goods_list;
		},
		// 余额可抵扣金额
		balanceDeduct() {
			if (this.calculateData) {
				if (this.calculateData.member_account.balance_total <= parseFloat(this.calculateData.order_money).toFixed(2)) {
					return parseFloat(this.calculateData.member_account.balance_total).toFixed(2);
				} else {
					return parseFloat(this.calculateData.order_money).toFixed(2);
				}
			}
		},
		// 门店列表
		storeList(){
			let storeList = null;
			if (this.goodsData && this.goodsData.express_type) {
				this.goodsData.express_type.forEach((item) => {
					if (item.name == 'store') {
						storeList = item.store_list;
						storeList = storeList.reduce((res, item) => {
						    return {...res, [item.store_id]: item}
						}, {})
					}
				})
			}
			return storeList;
		},
		// 门店信息
		storeInfo: {
			get(){
				if (this.storeList && this.orderCreateData.delivery && this.orderCreateData.delivery.delivery_type == 'store' && this.storeId) {
					return this.storeList[ this.orderCreateData.delivery.store_id ];
				}
			},
			set(value){
				this.storeList[ this.orderCreateData.delivery.store_id ].store_image = value;
			}
		},
		// 会员卡购买周期
		cardChargeType(){
			if (this.paymentData.recommend_member_card) {
				let charge_rule_arr = [];
				let charge_rule = this.paymentData.recommend_member_card.charge_rule;
				Object.keys(charge_rule).forEach((key, index)=>{
					switch (key) {
						case 'week':
							charge_rule_arr.push({'key': key, 'value': charge_rule[key], 'title' : '周卡', unit: '周'});
						break;
						case 'month':
							charge_rule_arr.push({'key': key, 'value': charge_rule[key], 'title' : '月卡', unit: '月'});
						break;
						case 'quarter':
							charge_rule_arr.push({'key': key, 'value': charge_rule[key], 'title' : '季卡', unit: '季'});
						break;
						case 'year':
							charge_rule_arr.push({'key': key, 'value': charge_rule[key], 'title' : '年卡', unit: '年'});
						break;
					}
				})
				return charge_rule_arr;
			}
		},
		// 定位信息
		location(){
			return this.$store.state.location;
		}
	},
	watch: {
		storeToken: function(nVal, oVal) {
			this.payment();
		},
		deliveryTime: function(nVal){
			if (!nVal) this.$refs.timePopup.refresh();
		},
		location: function(nVal){
			if (nVal) {
				this.orderCreateData.latitude = nVal.latitude;
				this.orderCreateData.longitude = nVal.longitude;
				this.payment();
			}
		}
	},
	methods: {
		/**
		 * 父级页面onShow调用
		 */
		pageShow(){
			if (uni.getStorageSync('addressBack') ) {
				uni.removeStorageSync('addressBack');
				this.payment();
			}
		},
		/**
		 * 获取订单结算数据
		 */
		payment(){
			this.$api.sendRequest({
				url: this.api.payment,
				data: this.orderCreateData,
				success: res => {
					if (res.code == 0 && res.data) {
						let data = res.data;
							
						// #ifdef MP-WEIXIN
						var scene = uni.getStorageSync('is_test') ? 1175 : wx.getLaunchOptionsSync().scene;
						if([1175, 1176, 1177, 1191, 1195].indexOf(scene) != -1 && data.shop_goods_list.express_type){
							data.shop_goods_list.express_type = data.shop_goods_list.express_type.filter(item => item.name == 'express' );
						}
						// #endif
						
						// 配送方式
						if (data.shop_goods_list.express_type && data.shop_goods_list.express_type.length) {
							let deliveryStorage = uni.getStorageSync('delivery');
							if (deliveryStorage) {
								data.shop_goods_list.express_type.forEach(item => {
									if (item.name == deliveryStorage.delivery_type) {
										this.orderCreateData.delivery = deliveryStorage;
										this.storeId = deliveryStorage.store_id ?? 0;
										if (deliveryStorage.delivery_type == 'store') {
											this.orderCreateData.member_address = {mobile: data.member_account.mobile ?? '' }
											if (!this.location) this.$util.getLocation();
										}
									}
								})
							} 
							if (!this.orderCreateData.delivery) {
								this.selectDeliveryType(data.shop_goods_list.express_type[0], false);
							}
							
							if(uni.getStorageSync('deliveryTime') && uni.getStorageSync('deliveryTime')['delivery_type'] && uni.getStorageSync('deliveryTime')['delivery_type'] == this.orderCreateData.delivery.delivery_type){
								this.deliveryTime = uni.getStorageSync('deliveryTime')['deliveryTime'];
								this.orderCreateData.buyer_ask_delivery_time = uni.getStorageSync('deliveryTime')['buyer_ask_delivery_time'];
							}
						}
						
						// 优惠券
						if (data.shop_goods_list.coupon_list && data.shop_goods_list.coupon_list[0]) 
							this.orderCreateData.coupon = {coupon_id: data.shop_goods_list.coupon_list[0].coupon_id };
						// 地址、手机号
						if (data.is_virtual) {
							this.orderCreateData.member_address = {mobile: data.member_account.mobile ?? '' }
						}
						
						// 该方法在父级组件中
						this.promotionInfo = this.promotion(data);
						
						this.paymentData = data;
						this.calculate();
					}
				}
			})
		},
		/**
		 * 订单创建
		 */
		calculate(){
			this.$forceUpdate();
			this.$api.sendRequest({
				url: this.api.calculate,
				data: this.handleCreateData(),
				success: res => {
					if (this.$refs.loadingCover && this.$refs.loadingCover.isShow) this.$refs.loadingCover.hide();
					if (res.code == 0 && res.data) {
						this.calculateData = res.data;
						if (res.data.delivery) {
							if (res.data.delivery.delivery_type == 'express') this.memberAddress = res.data.member_address;
							if (res.data.delivery.delivery_type == 'local') this.localMemberAddress = res.data.member_address;
						}
						this.resetDeliveryTime();
						this.$forceUpdate();
					} else {
						this.$util.showToast({
							title: res.message
						});
					}
				}
			})
		},
		/**
		 * 订单创建
		 */
		create(){
			if (!this.verify() || this.isRepeat) return;
			this.isRepeat = true;
			
			uni.showLoading({title: ''})
			this.$api.sendRequest({
				url: this.api.create,
				data: this.handleCreateData(),
				success: res => {
					uni.hideLoading();
					if (res.code == 0) {
						this.outTradeNo = res.data;
						uni.removeStorageSync('deliveryTime');
						if (this.calculateData.pay_money == 0) {
							// #ifdef MP-WEIXIN
							if (this.paymentData.is_virtual || this.orderCreateData.delivery.delivery_type == 'store') {
								this.$util.subscribeMessage('ORDER_VERIFY_OUT_TIME,VERIFY_CODE_EXPIRE,VERIFY');
							}
							// #endif
							this.$util.redirectTo('/pages_tool/pay/result', {
								code: res.data
							}, 'redirectTo');
						} else {
							this.openChoosePayment();
						}
					} else {
						this.$util.showToast({ title: res.message });
						this.isRepeat = false;
					}
					// 更新购物车数量
					this.$store.dispatch('getCartNumber');
				}
			})
		},
		/**
		 * 处理订单计算、创建传参
		 */
		handleCreateData(){
			let data = this.$util.deepClone(this.orderCreateData);
			if (this.paymentData && this.paymentData.system_form && this.$refs.form) data.form_data = { form_id: this.paymentData.system_form.id, form_data: this.$util.deepClone(this.$refs.form.formData) };
			Object.keys(data).forEach((key) => {
				let item = data[key];
				if (typeof item == 'object') data[key] = JSON.stringify(item);
			})
			if (data.member_address && this.orderCreateData.delivery && this.orderCreateData.delivery.delivery_type != 'store' ) delete data.member_address;
			return data;
		},
		/**
		 * 打开支付弹窗
		 */
		openChoosePayment(){
			uni.setStorageSync('paySource', '');
			// #ifdef MP-WEIXIN
			if (this.paymentData.is_virtual) {
				this.$util.subscribeMessage('ORDER_URGE_PAYMENT,ORDER_PAY');
			} else {
				switch(this.orderCreateData.delivery.delivery_type){
					case 'express'://物流配送
						this.$util.subscribeMessage('ORDER_URGE_PAYMENT,ORDER_PAY,ORDER_DELIVERY');
						break;
					case 'store'://门店自提
						this.$util.subscribeMessage('ORDER_URGE_PAYMENT,ORDER_PAY');
						break;
					case 'local'://同城配送
						this.$util.subscribeMessage('ORDER_URGE_PAYMENT,ORDER_PAY,ORDER_DELIVERY');
						break;
				}
			}
			// #endif
			this.$refs.choosePaymentPopup.getPayInfo(this.outTradeNo);
		},
		verify(){
			if (this.paymentData.is_virtual == 1) {
				if (!this.orderCreateData.member_address.mobile.length) {
					this.$util.showToast({
						title: '请输入您的手机号码'
					});
					return false;
				}
				var reg = /^[1](([3][0-9])|([4][5-9])|([5][0-3,5-9])|([6][5,6])|([7][0-8])|([8][0-9])|([9][1,8,9]))[0-9]{8}$/;
				if (!reg.test(this.orderCreateData.member_address.mobile)) {
					this.$util.showToast({
						title: '请输入正确的手机号码'
					});
					return false;
				}
			} else  {
				if (!this.orderCreateData.delivery) {
					this.$util.showToast({ title: '商家未设置配送方式' });
					return false;
				}
				if (
					(this.orderCreateData.delivery.delivery_type == 'express' && !this.memberAddress) ||
					(this.orderCreateData.delivery.delivery_type == 'local' && !this.localMemberAddress)
				) {
					this.$util.showToast({ title: '请先选择您的收货地址' });
					return false;
				}
			
				if (this.orderCreateData.delivery.delivery_type == 'store') {
					if (!this.orderCreateData.delivery.store_id) {
						this.$util.showToast({
							title: '没有可提货的门店,请选择其他配送方式'
						});
						return false;
					}
					if (!this.orderCreateData.member_address.mobile) {
						this.$util.showToast({
							title: '请输入预留手机'
						});
						return false;
					}
					var reg = /^[1](([3][0-9])|([4][5-9])|([5][0-3,5-9])|([6][5,6])|([7][0-8])|([8][0-9])|([9][1,8,9]))[0-9]{8}$/;
					if (!reg.test(this.orderCreateData.member_address.mobile)) {
						this.$util.showToast({
							title: '请输入正确的手机号'
						});
						return false;
					}
					if (!this.deliveryTime) {
						this.$util.showToast({
							title: '请选择提货时间'
						});
						return false;
					}
				}
			
				if (this.orderCreateData.delivery.delivery_type == 'local') {
					if (!this.deliveryTime) {
						this.$util.showToast({
							title: '请选择送达时间'
						});
						return false;
					}
				}
			}
			
			if (this.paymentData.system_form) {
				let formVerify = this.$refs.form.verify();
				if (!formVerify) return false;
			}
			return true;
		},
		/**
		 * 选择收货地址
		 */
		selectAddress() {
			var params = {
				back: this.$util.getCurrentRoute().path,
				local: 0,
				type: 1
			}
			// 外卖配送需要定位地址
			if (this.orderCreateData.delivery.delivery_type == 'local') {
				params.local = 1;
				params.type = 2;
			}
			this.$util.redirectTo('/pages_tool/member/address', params);
		},
		/**
		 * 选择配送方式
		 * @param {Object} data
		 */
		selectDeliveryType(data){
			
			if (this.orderCreateData.delivery && this.orderCreateData.delivery.delivery_type == data.name) return;
			
			let delivery = {
				delivery_type: data.name,
				delivery_type_name: data.title
			}
			// 如果是门店配送
			if (data.name == 'store') {
				let currStore = uni.getStorageSync('store');
				if (currStore) {
					if (this.storeList && this.storeList[currStore.store_id]) {
						delivery.store_id = currStore.store_id;
					} else {
						delivery.store_id = data.store_list[0].store_id;
					}
				} else if(data.store_list[0]) {
					delivery.store_id = data.store_list[0].store_id;
				}
				this.storeId = delivery.store_id;
				if (!this.orderCreateData.member_address) this.orderCreateData.member_address = {mobile: this.paymentData && this.paymentData.member_account.mobile ? this.paymentData.member_account.mobile : '' }
			} 
			this.$set(this.orderCreateData, 'delivery', delivery);
			this.orderCreateData.buyer_ask_delivery_time = '';
			this.deliveryTime = '';
			uni.removeStorageSync('deliveryTime');
			uni.setStorageSync('delivery', delivery);
			
			// 配送方式不为门店配送时
			if (this.orderCreateData.delivery.delivery_type == 'store' && !this.location) this.$util.getLocation();
			this.calculate();
		},
		/**
		 * 图片错误
		 * @param {Object} index
		 */
		imageError(index){
			this.paymentData.shop_goods_list.goods_list[index].sku_image = this.$util.getDefaultImage().goods;
			this.$forceUpdate();
		},
		/**
		 * 选择门店
		 * @param {Object} data
		 */
		selectPickupPoint(data) {
			if (data.store_id != this.storeId) {
				this.storeId = data.store_id;
				this.orderCreateData.delivery.store_id = data.store_id;
				this.calculate();				
				
			}
			this.$refs.deliveryPopup.close();
		},
		/**
		 * 重置提货时间
		 */
		resetDeliveryTime(){
			if(!this.orderCreateData.delivery || this.orderCreateData.delivery.delivery_type != 'store') return;
			if(this.calculateData.shop_goods_list.delivery_store_info && this.orderCreateData.buyer_ask_delivery_time){
				let delivery_store_info = JSON.parse(this.calculateData.shop_goods_list.delivery_store_info)
				let data = {
					time_type:this.$util.deepClone(delivery_store_info).time_type,
					end_time:this.$util.deepClone(delivery_store_info).end_time,
					start_time:this.$util.deepClone(delivery_store_info).start_time,
					time_week:this.$util.deepClone(delivery_store_info).time_week,
				};
				var delivery_time = this.$util.timeTurnTimeStamp(this.orderCreateData.buyer_ask_delivery_time);
				var date = new Date();
				date.setTime(delivery_time * 1000);
				var week = date.getDay();
				
				if(data.time_type && this.$util.inArray(week.toString(), data.time_week) == -1){
					this.orderCreateData.buyer_ask_delivery_time = '';
					this.deliveryTime = '';
					uni.removeStorageSync('deliveryTime');
				}
				
				var dayTime = Number(date.getHours()) * 3600 + Number(date.getMinutes()) * 60 + date.getSeconds()
				if(dayTime > data.end_time || dayTime < data.start_time){
					this.orderCreateData.buyer_ask_delivery_time = '';
					this.deliveryTime = '';
					uni.removeStorageSync('deliveryTime');
				}
			}else{
				this.orderCreateData.buyer_ask_delivery_time = '';
				this.deliveryTime = '';
				uni.removeStorageSync('deliveryTime');
			}
			
		},
		/**
		 * 门店
		 */
		storetime(type = ''){
			if(this.calculateData.shop_goods_list.delivery_store_info){
				let delivery_store_info = JSON.parse(this.calculateData.shop_goods_list.delivery_store_info)
				let data = {
					time_type:this.$util.deepClone(delivery_store_info).time_type,
					end_time:this.$util.deepClone(delivery_store_info).end_time,
					start_time:this.$util.deepClone(delivery_store_info).start_time,
					time_week:this.$util.deepClone(delivery_store_info).time_week,
				};
				let obj = {
					delivery:this.orderCreateData.delivery,
					dataTime:data
				} 
				this.$refs.timePopup.open(obj,type);
				this.$forceUpdate();
			}
		},
		/**
		 * 选择自提时间
		 * @param {Object} data
		 */
		selectPickupTime(data){
			this.deliveryTime = data.data.month + '('+ data.data.time +')';
			
			let nowDate = new Date();
			let Year =  nowDate.getFullYear();
			let timeData = data.data.month.split('月');
			let month = timeData[0];
			let date = timeData[1].split('日')[0]
			this.orderCreateData.buyer_ask_delivery_time = Year + '-' + month + '-' + date + ' ' + data.data.time + ':00'
			
			//将时间缓存，避免切换地址时重置
			uni.setStorageSync('deliveryTime',{
				'deliveryTime' : this.deliveryTime,
				'buyer_ask_delivery_time' : this.orderCreateData.buyer_ask_delivery_time,
				'delivery_type' : this.orderCreateData.delivery.delivery_type
			});
			
		},
		storeImgError(){
			this.storeInfo.store_image = this.$util.getDefaultImage().store;
		},
		openPopup(ref) {
			this.tempData = this.$util.deepClone(this.orderCreateData);
			this.$refs[ref].open();
		},
		closePopup(ref) {
			this.orderCreateData = this.$util.deepClone(this.tempData);
			this.$refs[ref].close();
			this.tempData = null;
		},
		/**
		 * 切换发票开关
		 */
		changeIsInvoice() {
			if (this.orderCreateData.is_invoice == 0) {
				this.orderCreateData.is_invoice = 1;
			} else {
				this.orderCreateData.is_invoice = 0;
			}
		},
		/**
		 * 切换发票类型
		 * @param {Object} invoice_type
		 */
		changeInvoiceType(invoice_type) {
			this.orderCreateData.invoice_type = invoice_type;
		},
		/**
		 * 切换发票个人还是企业
		 * @param {Object} invoice_title_type
		 */
		changeInvoiceTitleType(invoice_title_type) {
			this.orderCreateData.invoice_title_type = invoice_title_type;
		},
		/**
		 * 切换增值税专用发票开关
		 */
		changeIsTaxInvoice() {
			if (this.orderCreateData.is_tax_invoice == 0) this.orderCreateData.is_tax_invoice = 1;
			else this.orderCreateData.is_tax_invoice = 0;
			this.$forceUpdate();
		},
		/**
		 * 选择发票内容
		 * @param {Object} invoice_content
		 */
		changeInvoiceContent(invoice_content) {
			this.orderCreateData.invoice_content = invoice_content;
			this.$forceUpdate();
		},
		/**
		 * 验证发票内容
		 */
		invoiceVerify() {
			if (!this.orderCreateData.invoice_title) {
				this.$util.showToast({
					title: '请填写发票抬头'
				});
				return false;
			}
			if (!this.orderCreateData.taxpayer_number && this.orderCreateData.invoice_title_type == 2) {
				this.$util.showToast({
					title: '请填写纳税人识别号'
				});
				return false;
			}
			if (this.orderCreateData.invoice_type == 1 && !this.orderCreateData.invoice_full_address && this.orderPaymentData.is_virtual ==1) {
				this.$util.showToast({
					title: '请填写发票邮寄地址'
				});
				return false;
			}
			if (this.orderCreateData.invoice_type == 2 && !this.orderCreateData.invoice_email) {
				this.$util.showToast({
					title: '请填写邮箱'
				});
				return false;
			}
			if (this.orderCreateData.invoice_type == 2) {
				var reg = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
				if (!reg.test(this.orderCreateData.invoice_email)) {
					this.$util.showToast({
						title: '请填写正确的邮箱'
					});
					return false;
				}
			}
			if (!this.orderCreateData.invoice_content) {
				this.$util.showToast({
					title: '请选择发票内容'
				});
				return false;
			}
			return true;
		},
		/**
		 * 保存发票设置
		 */
		saveInvoice(){
			if (this.orderCreateData.is_invoice == 1 && !this.invoiceVerify()) return;
			this.calculate();
			this.$refs.invoicePopup.close();
		},
		/**
		 * 保存留言
		 */
		saveBuyerMessage(){
			this.calculate();
			this.$refs.buyerMessagePopup.close();
		},
		/**
		 * 选择会员卡
		 */
		selectMemberCard() {
			this.orderCreateData.is_open_card = this.orderCreateData.is_open_card ? 0 : 1;
			if (!this.orderCreateData.member_card_unit) this.orderCreateData.member_card_unit = this.cardChargeType[0].key;
			this.calculate();
		},
		/**
		 * 选择会员卡充值类型
		 * @param {Object} key
		 */
		selectMembercardUnit(key){
			this.orderCreateData.member_card_unit = key;
			this.calculate();
		},
		/**
		 * 使用积分抵扣
		 */
		usePoint() {
			this.orderCreateData.is_point = this.orderCreateData.is_point ? 0 : 1;
			this.calculate();
		},
		/**
		 * 支付弹窗关闭
		 */
		payClose(){
			this.$util.redirectTo('/pages/order/detail', {order_id: this.$refs.choosePaymentPopup.payInfo.order_id}, 'redirectTo');
		},
		/**
		 * 选择优惠券
		 * @param {Object} data
		 */
		selectCoupon(data){
			if (this.orderCreateData.coupon.coupon_id == data.coupon_id) this.orderCreateData.coupon = {coupon_id: 0};
			else this.orderCreateData.coupon = {coupon_id: data.coupon_id};
		},
		/**
		 * 使用优惠券
		 */
		useCpopon(){
			this.$refs.couponPopup.close();
			this.calculate();
		},
		/**
		 * 同城配送送达时间
		 */
		localtime(type = ''){
			let data = {
				time_type:this.$util.deepClone(this.goodsData.local_config.info).time_type,
				end_time:this.$util.deepClone(this.goodsData.local_config.info).end_time,
				start_time:this.$util.deepClone(this.goodsData.local_config.info).start_time,
				time_week:this.$util.deepClone(this.goodsData.local_config.info).time_week,
			};
			let obj = {
				delivery:this.orderCreateData.delivery,
				dataTime:data
			}
			this.$refs.timePopup.open(obj,type);
		},
		/**
		 * 剩余起送价
		 */
		surplusStartMoney(){
			let money = 0;
			if (this.calculateData && this.calculateData.delivery && this.calculateData.delivery.delivery_type == 'local') {
				let startDeliveryMoney = this.goodsData.local_config.info.start_money ?? 0;
				money = parseFloat(startDeliveryMoney) - parseFloat(this.calculateData.goods_money);
				money = money < 0 ? 0 : money;
			}
			return money;
		},
		/**
		 * 交易协议
		 */
		getTransactionAgreement(){
			this.$api.sendRequest({
				url: '/api/order/transactionagreement',
				success: res => {
					if (res.data) this.transactionAgreement = res.data;
				}
			})
		}
	},
	filters: {
		// 金额格式化输出
		moneyFormat(money) {
			return parseFloat(money).toFixed(2);
		}
	}
}