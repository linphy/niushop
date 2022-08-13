export default {
	data() {
		return {
			diyinfo: null,
			memberInfo: null,
			memberCode: {
				timer: null,
				barcode: '',
				qrcode: '',
				routerParameter: '',
				dynamicNumber: '',
			},
			orderNum: {
				waitpay: 0,
				waitsend: 0,
				waitconfirm: 0,
				waitrate: 0,
				refunding: 0
			}
		};
	},
	computed: {
		storeToken() {
			return this.$store.state.token;
		},
		memberInfostyle() {
			if (!this.diyinfo) return '';
			let style = {}
			if (this.diyinfo.member_info.background_type == 'system') {
				style.background = `url('` + this.$util.img('public/static/img/diy_view/member_info_bg.png') +
					`') no-repeat bottom / contain, var(--base-color)`;
			} else {
				style.background = `url('` + this.$util.img('public/static/img/diy_view/member_info_bg.png') +
					`') no-repeat bottom / contain, linear-gradient(` + this.diyinfo.member_info.background[0] + `, ` +
					this.diyinfo.member_info.background[1] + ` 0%, ` + this.diyinfo.member_info.background[2] +
					` 100%)`;
			}
			return this.$util.objToStyle(style)
		},
		orderWrapStyle() {
			if (!this.diyinfo) return '';
			return this.$util.objToStyle({
				padding: parseInt(this.diyinfo.order.margin[0]) * 2 + 'rpx ' + parseInt(this.diyinfo.order
					.margin[1]) * 2 + 'rpx ' + parseInt(this.diyinfo.order.margin[2]) * 2 + 'rpx'
			})
		},
		orderStyle() {
			if (!this.diyinfo) return '';
			return this.$util.objToStyle({
				'border-top-left-radius': parseInt(this.diyinfo.order.radius[0]) * 2 + 'rpx',
				'border-top-right-radius': parseInt(this.diyinfo.order.radius[0]) * 2 + 'rpx',
				'border-bottom-left-radius': parseInt(this.diyinfo.order.radius[1]) * 2 + 'rpx',
				'border-bottom-right-radius': parseInt(this.diyinfo.order.radius[1]) * 2 + 'rpx',
			})
		},
		menuStyle() {
			if (!this.diyinfo) return '';
			return this.$util.objToStyle({
				'border-top-left-radius': parseInt(this.diyinfo.menu.radius[0]) * 2 + 'rpx',
				'border-top-right-radius': parseInt(this.diyinfo.menu.radius[0]) * 2 + 'rpx',
				'border-bottom-left-radius': parseInt(this.diyinfo.menu.radius[1]) * 2 + 'rpx',
				'border-bottom-right-radius': parseInt(this.diyinfo.menu.radius[1]) * 2 + 'rpx',
			})
		},
		menuWrapStyle() {
			if (!this.diyinfo) return '';
			return this.$util.objToStyle({
				padding: parseInt(this.diyinfo.menu.margin[0]) * 2 + 'rpx ' + parseInt(this.diyinfo.menu.margin[
					1]) * 2 + 'rpx ' + parseInt(this.diyinfo.menu.margin[2]) * 2 + 'rpx'
			})
		},
		advWrapStyle() {
			if (!this.diyinfo) return '';
			return this.$util.objToStyle({
				padding: parseInt(this.diyinfo.adv.margin[0]) * 2 + 'rpx ' + parseInt(this.diyinfo.adv.margin[
					1]) * 2 + 'rpx ' + parseInt(this.diyinfo.adv.margin[2]) * 2 + 'rpx'
			})
		},
		advStyle() {
			if (!this.diyinfo) return '';
			let wrapHeight = 0,
				imgs = this.$util.deepClone(this.diyinfo.adv.list),
				wrapWidth = uni.getSystemInfoSync().windowWidth - uni.upx2px(parseInt(this.diyinfo.adv.margin[1]) * 4);

			imgs.forEach((item, index) => {
				let ratio = wrapWidth / item.img_width;
				let height = item.img_height * ratio;
				if (wrapHeight == 0 || wrapHeight < height) wrapHeight = height;
			});

			return this.$util.objToStyle({
				'border-top-left-radius': parseInt(this.diyinfo.adv.radius[0]) * 2 + 'rpx',
				'border-top-right-radius': parseInt(this.diyinfo.adv.radius[0]) * 2 + 'rpx',
				'border-bottom-left-radius': parseInt(this.diyinfo.adv.radius[1]) * 2 + 'rpx',
				'border-bottom-right-radius': parseInt(this.diyinfo.adv.radius[1]) * 2 + 'rpx',
				'height': wrapHeight + 'px'
			})
		}
	},
	watch: {
		storeToken: function(nVal, oVal) {
			if (nVal) {
				this.getMemberInfo();
				if (uni.getStorageSync('source_member')) this.$util.onSourceMember(uni.getStorageSync(
					'source_member'));
			}
		}
	},
	async onLoad(data) {
		uni.hideTabBar();
		await this.getDiyInfo();

		if (data.code) {
			this.$api.sendRequest({
				url: '/wechat/api/wechat/authcodetoopenid',
				data: {
					code: data.code
				},
				success: res => {
					if (res.code >= 0) {
						if (res.data.userinfo.nickName) this.modifyNickname(res.data.userinfo.nickName);
						if (res.data.userinfo.avatarUrl) this.modifyHeadimg(res.data.userinfo
						.avatarUrl);
					}
				}
			});
		}
	},
	onShow() {
		if (uni.getStorageSync('token')) this.getMemberInfo();
		else this.initInfo();
	},
	methods: {
		initInfo() {
			this.memberInfo = null;
			this.orderNum = {
				waitpay: 0,
				waitsend: 0,
				waitconfirm: 0,
				waitrate: 0,
				refunding: 0
			}
		},
		async getDiyInfo() {
			let res = await this.$api.sendRequest({
				url: '/api/diyview/memberindex',
				async: false,
				success: res => {}
			});
			if (res.code == 0) {
				this.diyinfo = res.data;
				this.handleIconStyle();
			}
			if (this.$refs.loadingCover) this.$refs.loadingCover.hide();
		},
		handleIconStyle() {
			if (this.diyinfo.order.icon_style == 0) {
				Object.keys(this.diyinfo.order.icon).forEach(key => {
					if (this.diyinfo.member_info.background_type == 'system') {
						this.diyinfo.order.icon[key].style.iconColor = [this.$util.colourBlend(this.themeStyle
							.bg_color, '#ffffff', 0.5), this.themeStyle.bg_color];
					} else {
						this.diyinfo.order.icon[key].style.iconColor = [this.diyinfo.member_info.background[1],
							this.diyinfo.member_info.background[2]
						];
					}
				})
			}
		},
		/**
		 * 跳转
		 * @param {Object} url
		 */
		redirect(url) {
			if (!uni.getStorageSync('token')) {
				this.$refs.login.open(url);
			} else {
				this.$util.redirectTo(url);
			}
		},
		/**
		 * 自定义跳转
		 * @param {Object} data
		 */
		diyRedirect(data) {
			if (data.wap_url && data.wap_url.indexOf('http') == -1 && data.wap_url.indexOf('http') == -1) this.redirect(
				data.wap_url);
			else this.$util.diyRedirectTo(data);
		},
		/**
		 * 查询会员信息
		 */
		getMemberInfo() {
			this.$api.sendRequest({
				url: '/api/member/info',
				data: {},
				success: res => {
					if (res.code == 0) {
						if (!this.memberInfo) this.memberInfo = res.data;
						else Object.assign(this.memberInfo, res.data);
						this.getCouponNum();
						this.getOrderNum();
						this.checkIsVerifier();
						this.checkSignIsStart();
					}
				},
				complete: res => {
					uni.stopPullDownRefresh();
				}
			});
		},
		/**
		 * 查询优惠券数量
		 */
		getCouponNum() {
			this.$api.sendRequest({
				url: '/coupon/api/coupon/num',
				success: res => {
					if (res.code == 0) {
						this.$set(this.memberInfo, 'coupon_num', res.data);
					}
				}
			});
		},
		/**
		 * 显示会员码 
		 */
		showMemberQrcode() {
			if (this.memberCode.timer) clearInterval(this.memberCode.timer);
			this.getMemberQrcode();
			this.memberCode.timer = setInterval(() => {
				this.getMemberQrcode()
			}, 30000)
		},
		/**
		 * 关闭会员码
		 */
		closeMemberQrcode() {
			clearInterval(this.memberCode.timer);
			this.$refs.erWeiPopup.close();
		},
		/**
		 * 获取会员码
		 */
		getMemberQrcode() {
			this.$api.sendRequest({
				url: '/api/member/membereqrcode',
				data: {
					page: ''
				},
				success: res => {
					if (res.code == 0) {
						this.memberCode.barcode = res.bar_code;
						this.memberCode.qrcode = res.data.path;
						this.memberCode.routerParameter = res.data.url;
						this.memberCode.dynamicNumber = res.dynamic_number;
						if (!this.$refs.erWeiPopup.showPopup) this.$refs.erWeiPopup.open()
					}
				}
			});
		},
		/**
		 * 获取订单数量
		 */
		getOrderNum() {
			this.$api.sendRequest({
				url: '/api/order/num',
				data: {
					order_status: 'waitpay,waitsend,waitconfirm,waitrate,refunding'
				},
				success: res => {
					if (res.code == 0) {
						this.orderNum = res.data;
					}
				}
			});
		},
		onPullDownRefresh() {
			if (uni.getStorageSync('token')) this.getMemberInfo();
			else uni.stopPullDownRefresh();
		},
		/**
		 * 检测用户是否是核销员
		 */
		checkIsVerifier() {
			this.$api.sendRequest({
				url: '/api/verify/checkisverifier',
				success: res => {
					if (res.code != 0) this.diyinfo.menu.menus.verifier.isShow = 0;
				}
			});
		},
		/**
		 * 检测签到是否开启
		 */
		checkSignIsStart() {
			if (!this.diyinfo.menu.menus.membersignin) return;

			this.$api.sendRequest({
				url: '/api/membersignin/getSignStatus',
				success: res => {
					if (res.code == 0 && !res.data.is_use) this.diyinfo.menu.menus.membersignin.isShow = 0;
				}
			});
		},
		/**
		 * 获取微信授权
		 */
		getWxAuth(callback) {
			// #ifdef MP-WEIXIN
			wx.getUserProfile({
				desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
				success: (res) => {
					this.modifyNickname(res.userInfo.nickName);
					this.modifyHeadimg(res.userInfo.avatarUrl);
					typeof callback == 'function' && callback()
				}
			})
			// #endif

			// #ifdef H5
			if (this.$util.isWeiXin()) {
				this.$api.sendRequest({
					url: '/wechat/api/wechat/authcode',
					data: {
						scopes: 'snsapi_userinfo',
						redirect_url: this.$config.h5Domain + '/pages/member/index'
					},
					success: res => {
						if (res.code >= 0) {
							location.href = res.data;
						}
					}
				});
			}
			// #endif
		},
		/**
		 * 修改昵称
		 * @param {Object} nickName
		 */
		modifyNickname(nickName) {
			this.$api.sendRequest({
				url: '/api/member/modifynickname',
				data: {
					nickname: nickName
				},
				success: res => {
					if (res.code == 0) this.memberInfo.nickname = nickName;
				}
			});
		},
		/**
		 * 修改头像
		 */
		modifyHeadimg(headimg) {
			this.$api.sendRequest({
				url: '/api/member/modifyheadimg',
				data: {
					headimg: headimg
				},
				success: res => {
					if (res.code == 0) this.memberInfo.headimg = headimg;
				}
			});
		},
		/**
		 * 跳转之前需先进行授权
		 * @param {Object} url
		 */
		redirectBeforeAuth(url) {
			if (!uni.getStorageSync('token')) {
				this.$refs.login.open('/pages/member/index');
				return;
			}

			// #ifdef MP-WEIXIN
			if ((this.memberInfo.nickname.indexOf('u_') != -1 && this.memberInfo.nickname == this.memberInfo
				.username) ||
				(this.memberInfo.nickname == this.memberInfo.mobile)) {
				this.getWxAuth(() => {
					this.$util.redirectTo(url)
				});
			} else {
				this.$util.redirectTo(url)
			}
			// #endif

			// #ifdef H5
			if (this.$util.isWeiXin() && (
					(this.memberInfo.nickname.indexOf('u_') != -1 && this.memberInfo.nickname == this.memberInfo
						.username) ||
					(this.memberInfo.nickname == this.memberInfo.mobile)
				)) {
				this.getWxAuth();
			} else {
				this.$util.redirectTo(url)
			}
			// #endif
		}
	}
};
