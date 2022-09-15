<template>
	<view class="container" :style="warpCss">
		<!-- 会员信息 -->
		<view class="common-wrap info-wrap" :data-style="value.style">
			<view class="member-info" :style="memberInfostyle">
				<view class="info-wrap" v-if="memberInfo">
					<view class="headimg" @click="getWxAuth">
						<image
							:src="memberInfo.headimg ? $util.img(memberInfo.headimg) : $util.getDefaultImage().head"
							mode="widthFix"
							@error="memberInfo.headimg = $util.getDefaultImage().head"
						></image>
					</view>
					<view class="info">
						<!-- #ifdef MP-WEIXIN -->
						<block v-if="(memberInfo.nickname.indexOf('u_') != -1 && memberInfo.nickname == memberInfo.username) || memberInfo.nickname == memberInfo.mobile">
							<view class="nickname"><text class="name" @click="getWxAuth">点击获取微信头像</text></view>
						</block>
						<view class="nickname" v-else>
							<text class="name">{{ memberInfo.nickname }}</text>
							<text
								class="member-level"
								v-if="value.style == 1 || value.style == 2"
								@click="redirectBeforeAuth(memberInfo.member_level_type ? '/pages_tool/member/card' : '/pages_tool/member/level')"
							>
								<text class="icondiy icon-system-huangguan"></text>
								{{ memberInfo.member_level_name }}
							</text>
						</view>
						<view class="member-level" v-if="value.style == 3">
							<image :src="$util.img('public/uniapp/member/supervip_icon.png')" mode="heightFix" class="level-icon"></image>
							<view class="level-name">{{ memberInfo.member_level_name }}</view>
						</view>
						<!-- #endif -->

						<!-- #ifdef H5 -->
						<block
							v-if="
								$util.isWeiXin() &&
									((memberInfo.nickname.indexOf('u_') != -1 && memberInfo.nickname == memberInfo.username) || memberInfo.nickname == memberInfo.mobile)
							"
						>
							<view class="nickname"><text class="name" @click="getWxAuth">点击获取微信头像</text></view>
						</block>
						<view class="nickname" v-else>
							<text class="name">{{ memberInfo.nickname }}</text>
							<text
								class="member-level"
								v-if="value.style == 1 || value.style == 2"
								@click="redirectBeforeAuth(memberInfo.member_level_type ? '/pages_tool/member/card' : '/pages_tool/member/level')"
							>
								<text class="icondiy icon-system-huangguan"></text>
								{{ memberInfo.member_level_name }}
							</text>
						</view>
						<view class="member-level" v-if="value.style == 3">
							<image :src="$util.img('public/uniapp/member/supervip_icon.png')" mode="heightFix" class="level-icon"></image>
							<view class="level-name">{{ memberInfo.member_level_name }}</view>
						</view>
						<!-- #endif -->
					</view>
					<text class="iconfont icon-qrcode member-code" @click="showMemberQrcode"></text>
					<text class="iconfont icon-shezhi user-info" @click="$util.redirectTo('/pages_tool/member/info')"></text>
				</view>
				<view class="info-wrap" v-else @click="redirect('/pages/member/index')">
					<view class="headimg"><image :src="$util.getDefaultImage().head" mode="widthFix"></image></view>
					<view class="info">
						<view class="nickname"><text class="name">登录/注册</text></view>
						<view class="desc">点击登录 享受更多精彩信息</view>
					</view>
					<text class="iconfont icon-qrcode member-code"></text>
				</view>

				<view
					class="account-info"
					v-show="value.style == 1 || value.style == 3"
					:style="{ 'margin-left': parseInt(value.infoMargin) * 2 + 'rpx', 'margin-right': parseInt(value.infoMargin) * 2 + 'rpx' }"
				>
					<view class="account-item" @click="redirect('/pages_tool/member/balance')">
						<view class="value price-font">{{ memberInfo ? (parseFloat(memberInfo.balance) + parseFloat(memberInfo.balance_money)).toFixed(2) : '--' }}</view>
						<view class="title">余额</view>
					</view>
					<view class="solid"></view>
					<view class="account-item" @click="redirect('/pages_tool/member/point')">
						<view class="value price-font">{{ memberInfo ? parseFloat(memberInfo.point) : '--' }}</view>
						<view class="title">积分</view>
					</view>
					<view class="solid"></view>
					<view class="account-item" @click="redirect('/pages_tool/member/coupon')">
						<view class="value price-font">{{ memberInfo && memberInfo.coupon_num != undefined ? memberInfo.coupon_num : '--' }}</view>
						<view class="title">优惠券</view>
					</view>
				</view>
				<view class="super-member" v-if="superMember" :style="superMemberStyle">
					<block v-if="value.style == 1 || value.style == 2">
						<view class="super-info">
							<text class="icondiy icon-system-huangguan"></text>
							<text>超级会员</text>
						</view>
						<view class="super-text">
							<text class="see" v-if="memberInfo && memberInfo.member_level_type" @click="redirectBeforeAuth('/pages_tool/member/card')">查看特权</text>
							<text class="see" v-else @click="redirectBeforeAuth('/pages_tool/member/card_buy')">会员可享更多权益</text>
							<text class="iconfont icon-right"></text>
						</view>
					</block>
					<block v-if="value.style == 3">
						<view class="super-info">
							<image :src="$util.img('public/uniapp/member/open_member.png')" class="title" mode="heightFix" />
							<view class="desc">开通可享更多权益</view>
						</view>
						<view class="super-text">
							<text class="see" v-if="memberInfo && memberInfo.member_level_type" @click="redirectBeforeAuth('/pages_tool/member/card')">查看特权</text>
							<text class="see" v-else @click="redirectBeforeAuth('/pages_tool/member/card_buy')">立即开通</text>
						</view>
					</block>
				</view>
			</view>
			<view
				class="account-info"
				v-show="value.style == 2"
				:style="{ 'margin-left': parseInt(value.infoMargin) * 2 + 'rpx', 'margin-right': parseInt(value.infoMargin) * 2 + 'rpx' }"
			>
				<view class="account-item" @click="redirect('/pages_tool/member/balance')">
					<view class="value price-font">{{ memberInfo ? (parseFloat(memberInfo.balance) + parseFloat(memberInfo.balance_money)).toFixed(2) : '--' }}</view>
					<view class="title">余额</view>
				</view>
				<view class="solid"></view>
				<view class="account-item" @click="redirect('/pages_tool/member/point')">
					<view class="value price-font">{{ memberInfo ? parseFloat(memberInfo.point) : '--' }}</view>
					<view class="title">积分</view>
				</view>
				<view class="solid"></view>
				<view class="account-item" @click="redirect('/pages_tool/member/coupon')">
					<view class="value price-font">{{ memberInfo && memberInfo.coupon_num != undefined ? memberInfo.coupon_num : '--' }}</view>
					<view class="title">优惠券</view>
				</view>
			</view>
		</view>

		<!-- 会员码 -->
		<uni-popup ref="erWeiPopup" type="center">
			<view class="member-code-popup">
				<view class="popup-top" @click="getMemberQrcode">
					<view class="popup-top-title">
						<view class="iconfont icon-erweima"></view>
						<view class="popup-top-title-txt">会员码</view>
					</view>
					<view class="popup-top-tiao"><image :src="$util.img(memberCode.barcode)" mode=""></image></view>
					<view class="popup-top-erwei"><image :src="$util.img(memberCode.qrcode)" mode=""></image></view>
					<view class="popup-top-shauxin" @click="getMemberQrcode">
						<text>动态码 {{ memberCode.dynamicNumber }}</text>
						<text class="iconfont icon-shuaxin"></text>
					</view>
					<view class="popup-top-text">如遇到扫码失败请将屏幕调至最亮重新扫码</view>
				</view>
				<view class="popup-bottom"><text class="iconfont iconfont-delete icon-close-guanbi" @click="closeMemberQrcode"></text></view>
			</view>
		</uni-popup>
		<ns-login ref="login"></ns-login>
	</view>
</template>

<script>
// 自定义会员中心——会员信息
export default {
	name: 'diy-member-info',
	props: {
		value: {
			type: Object
		},
		token: {
			type: String
		}
	},
	data() {
		return {
			memberInfo: null,
			superMember: null,
			memberCode: {
				timer: null,
				barcode: '',
				qrcode: '',
				routerParameter: '',
				dynamicNumber: ''
			}
		};
	},
	created() {
		this.init();
	},
	watch: {
		token(nVal, oVal) {
			this.init();
		}
	},
	computed: {
		memberInfostyle() {
			let style = {};
			if (this.value.style == 3) {
				style.background = `radial-gradient(36% 112% at 16% 6%, rgba(255,97,40,0.12) 0%, rgba(255,97,40,0.12) 0%, rgba(226,239,255,0.1) 100%, rgba(226,239,255,.1) 100%)`;
			} else {
				if (this.value.theme == 'default') {
					style.background = `url('` + this.$util.img('public/static/img/diy_view/member_info_bg.png') + `') no-repeat bottom / contain, var(--base-color)`;
				} else {
					style.background =
						`url('` +
						this.$util.img('public/static/img/diy_view/member_info_bg.png') +
						`') no-repeat bottom / contain, linear-gradient(` +
						this.value.gradientAngle +
						`deg, ` +
						this.value.bgColorStart +
						` 0%, ` +
						this.value.bgColorEnd +
						` 100%)`;
				}
			}
			return this.$util.objToStyle(style);
		},
		superMemberStyle() {
			let style = {
				'margin-left': parseInt(this.value.infoMargin) * 2 + 'rpx ',
				'margin-right': parseInt(this.value.infoMargin) * 2 + 'rpx '
			};
			if (this.value.style == 3) {
				style.background = `#292f45 url(` + this.$util.img('public/uniapp/member/supervip_bg.png') + `) no-repeat bottom / 100% 100%`;
			} else {
				style.background =
					`url('` +
					this.$util.img('public/static/img/diy_view/super_member_bg.png') +
					`') no-repeat bottom / 100% 100%, linear-gradient(107deg, ` +
					this.themeStyle.super_member.super_member_start_bg +
					` 0%, ` +
					this.themeStyle.super_member.super_member_end_bg +
					` 100%)`;
			}
			return this.$util.objToStyle(style);
		},
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
		}
	},
	methods: {
		init() {
			if (uni.getStorageSync('token')) this.getMemberInfo();
			else this.memberInfo = null;
			this.getMemberCardInfo();
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
					}
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
		 * 查询超级会员信息
		 */
		getMemberCardInfo() {
			this.$api.sendRequest({
				url: '/supermember/api/membercard/firstcard',
				success: res => {
					if (res.code == 0 && res.data) {
						this.superMember = res.data;
					}
				}
			});
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
		 * 显示会员码
		 */
		showMemberQrcode() {
			if (this.memberCode.timer) clearInterval(this.memberCode.timer);
			this.getMemberQrcode();
			this.memberCode.timer = setInterval(() => {
				this.getMemberQrcode();
			}, 30000);
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
						if (!this.$refs.erWeiPopup.showPopup) this.$refs.erWeiPopup.open();
					}
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
			if ((this.memberInfo.nickname.indexOf('u_') != -1 && this.memberInfo.nickname == this.memberInfo.username) || this.memberInfo.nickname == this.memberInfo.mobile) {
				this.getWxAuth(() => {
					this.$util.redirectTo(url);
				});
			} else {
				this.$util.redirectTo(url);
			}
			// #endif

			// #ifdef H5
			if (
				this.$util.isWeiXin() &&
				((this.memberInfo.nickname.indexOf('u_') != -1 && this.memberInfo.nickname == this.memberInfo.username) || this.memberInfo.nickname == this.memberInfo.mobile)
			) {
				this.getWxAuth();
			} else {
				this.$util.redirectTo(url);
			}
			// #endif
		},
		/**
		 * 获取微信授权
		 */
		getWxAuth(callback) {
			// #ifdef MP-WEIXIN
			wx.getUserProfile({
				desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
				success: res => {
					this.modifyNickname(res.userInfo.nickName);
					this.modifyHeadimg(res.userInfo.avatarUrl);
					typeof callback == 'function' && callback();
				}
			});
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
		}
	}
};
</script>

<style lang="scss">
.common-wrap {
	width: 100%;
	box-sizing: border-box;
}
// 会员信息
.member-info {
	// #ifdef MP
	padding-top: 108rpx;
	// #endif

	.info-wrap {
		padding: 44rpx 30rpx;
		display: flex;
		align-items: center;
		view {
			color: var(--btn-text-color);
		}
		.info {
			flex: 1;
			width: 0;
			padding-right: 20rpx;
			overflow: hidden;
		}
	}
	.headimg {
		width: 120rpx;
		height: 120rpx;
		overflow: hidden;
		border-radius: 50%;
		margin-right: 20rpx;
		image {
			width: 100%;
		}
	}
	.nickname {
		font-weight: bold;
		white-space: nowrap;
		margin-bottom: 0;
		display: flex;
		align-items: center;
	}
	.name {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		font-size: 38rpx;
		font-weight: 600;
	}
	.mobile {
		font-size: 26rpx;
		line-height: 1.5;
	}
	.desc {
		font-size: 24rpx;
	}
	.member-code,
	.user-info {
		font-size: 40rpx;
		color: #fff;
		margin-left: 20rpx;
		line-height: 1;
		color: var(--btn-text-color);
	}
	.member-level {
		font-size: 24rpx;
		background: linear-gradient(107deg, #7c7878 0%, #201a18 100%);
		color: #f7c774;
		line-height: 40rpx;
		height: 40rpx;
		border-radius: 4rpx;
		padding: 0 16rpx;
		display: inline-block;
		margin-left: 20rpx;
		.icondiy {
			line-height: 1;
			font-size: 24rpx;
			margin-right: 10rpx;
		}
		&.auth {
			margin-left: 0;
		}
	}
	.super-member {
		display: flex;
		align-items: center;
		justify-content: space-between;
		height: 120rpx;
		border-top-left-radius: 10rpx;
		border-top-right-radius: 10rpx;
		background: linear-gradient(107deg, #7c7878 0%, #201a18 100%);
		padding: 30rpx 40rpx;
		box-sizing: border-box;

		text {
			// color: #fff;
		}
		.icon-huangguan {
			margin-right: 10rpx;
			font-size: 40rpx;
		}
		.super-info {
			flex: 1;
			width: 0;
			font-size: 36rpx;
			color: var(--super-member-start-text-color);
			// background-image: linear-gradient(90deg, var(--super-member-start-text-color) 0%, var(--super-member-end-text-color) 100%);
			// -webkit-background-clip: text;
			// -webkit-text-fill-color: transparent;
			display: flex;
			align-items: center;
			.icondiy {
				margin-right: 10rpx;
			}
		}

		.see {
			line-height: 1;
			font-size: 30rpx;
		}
		.icon-right {
			font-size: 28rpx;
			margin-left: 10rpx;
		}
	}
}
.account-info {
	display: flex;
	padding: 40rpx 0;
	align-items: center;
	justify-content: center;
	view {
		color: #fff;
	}
	.solid {
		height: 70rpx;
		width: 2rpx;
		background: #fff;
		border-radius: 2rpx;
	}

	.account-item {
		flex: 1;
		text-align: center;
		.value {
			font-size: 34rpx;
			font-weight: bold !important;
			margin-bottom: 4rpx;
			line-height: 1.3;
		}
		.title {
			font-size: 26rpx;
		}
	}
}
[data-style='1'] {
	.super-text {
		background-image: linear-gradient(90deg, #ffdba6 0%, #ffebca 49%, #f7c774 100%);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		display: flex;
		align-items: center;
	}
}

[data-style='2'] {
	.member-info {
		border-radius: 0 0 100% 100%/0 0 70rpx 70rpx;
		overflow: hidden;

		.member-level {
			background: linear-gradient(107deg, #fadcb5 0%, #f6bd74 100%);
			color: #8d4b16;
		}
	}
	.account-info {
		background: #fff;
		margin: 20rpx 0 0 0;
		color: #333;
		border-radius: 18rpx;
		.solid {
			background: #f2f2f2;
		}
		.account-item {
			.value {
				color: #000000;
			}
			.title {
				color: #666666;
			}
		}
	}
	.super-member {
		color: #8d4b16;
		background: linear-gradient(107deg, #fadcb5 0%, #f6bd74 100%);
		border-top-left-radius: 18rpx;
		border-top-right-radius: 18rpx;
		.super-info {
			color: var(--super-member-start-text-color);
			// background-image: linear-gradient(90deg, var(--super-member-start-text-color) 0%, var(--super-member-end-text-color) 100%);
		}
		.see {
			color: var(--super-member-start-text-color);
		}
		.icon-right {
			color: var(--super-member-start-text-color);
		}
	}
}

[data-style='3'] {
	.info-wrap view {
		color: #282c38;
	}
	.member-code,
	.user-info {
		color: #282c38;
		font-weight: bold;
	}
	.member-code {
		font-size: 36rpx;
	}
	.super-member {
		border-radius: 22rpx;

		.super-text {
			.see {
				width: 160rpx;
				height: 56rpx;
				line-height: 56rpx;
				background: #e3c377;
				border-radius: 56rpx;
				color: #77413e;
				text-align: center;
				font-weight: bold;
				font-size: 24rpx;
				display: block;
			}
		}
		.super-info {
			flex-direction: column;
			align-items: normal;

			.title {
				height: 36rpx;
				width: auto;
				margin-bottom: 14rpx;
			}
			.desc {
				color: #e3c377;
				line-height: 1;
			}
		}
	}
	.account-info {
		.solid {
			background: none;
		}
	}
	.account-item {
		.value {
			color: #282c38;
			font-size: 44rpx;
		}
		.title {
			color: #aab0ba;
		}
	}
	.member-level {
		background: none;
		padding: 0;
		margin: 0;
		height: auto;
		display: flex;
		align-items: center;
		.level-icon {
			height: 36rpx;
		}
		.level-name {
			height: 36rpx;
			line-height: 36rpx;
			padding: 0 20rpx;
			color: #8d4b16;
			background: #f8cf9a;
			font-size: 24rpx;
			display: inline-block;
			margin-left: 10rpx;
			border-radius: 36rpx;
			border-bottom-left-radius: 0;
			border-top-left-radius: 40rpx;
			font-weight: bold;
		}
	}
}

.member-code-popup {
	width: 100%;
	min-height: 900rpx;
	background: none;
	.popup-top {
		padding: 40rpx;
		box-sizing: border-box;
		width: 100%;
		height: 800rpx;
		background: #ffffff;
		border-radius: 12rpx;
		.popup-top-title {
			display: flex;
			align-items: center;
			margin-bottom: 60rpx;
			.popup-top-title-txt {
				font-size: 30rpx;
				margin-left: 16rpx;
			}
		}
		.popup-top-tiao {
			width: 480rpx;
			height: 160rpx;
			margin: 0 auto 46rpx;
			image {
				width: 100%;
				height: 100%;
			}
		}
		.popup-top-tiaoJie {
			text-align: center;
			font-size: 28rpx;
			color: rgb(153, 153, 153);
			margin-bottom: 40rpx;
		}
		.popup-top-erwei {
			width: 254rpx;
			height: 254rpx;
			margin: 0 auto 20rpx;
			image {
				width: 100%;
				height: 100%;
			}
		}
		.popup-top-shauxin {
			width: 350rpx;
			height: 80rpx;
			border-radius: $border-radius;
			background: rgb(245, 249, 247);
			margin: 0 auto;
			font-size: 30rpx;
			text-align: center;
			display: flex;
			align-items: center;
			justify-content: center;
			.iconfont {
				margin-left: 20rpx;
			}
		}
		.popup-top-text {
			text-align: center;
			font-size: 18rpx;
			color: rgb(153, 153, 153);
			margin-top: 30rpx;
		}
	}
	.popup-bottom {
		display: flex;
		align-items: center;
		justify-content: center;
		background: none !important;
		.iconfont-delete {
			font-size: 60rpx;
			margin-top: 20rpx;
			color: white;
		}
	}
}

/deep/ .uni-popup__wrapper.uni-custom .uni-popup__wrapper-box {
	background: none !important;
}

.member-code-popup .popup-top {
	height: auto;
}
</style>
