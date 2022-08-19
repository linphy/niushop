<template>
	<page-meta :page-style="themeColor"></page-meta>
	<view>
		<scroll-view scroll-y="true" class="container">
			<block v-if="diyinfo">
				<!-- 会员信息 -->
				<view class="common-wrap info-wrap" :data-style="diyinfo.member_info.style">
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
									<view class="nickname">
										<text class="name" @click="getWxAuth">点击获取微信头像</text>
									</view>
								</block>
								<view class="nickname" v-else>
									<text class="name">{{ memberInfo.nickname }}</text>
									<text class="member-level" @click="redirectBeforeAuth('/pages_tool/member/level')">
										<text class="icondiy icon-system-huangguan"></text>{{ memberInfo.member_level_name }}
									</text>
								</view>
								<view class="mobile" v-if="memberInfo.mobile">{{ memberInfo.mobile }}</view>
								<!-- #endif -->
								
								<!-- #ifdef H5 -->
								<block v-if="$util.isWeiXin() && (( memberInfo.nickname.indexOf('u_') != -1 && memberInfo.nickname == memberInfo.username) || memberInfo.nickname == memberInfo.mobile)">
									<view class="nickname">
										<text class="name" @click="getWxAuth">点击获取微信头像</text>
									</view>
								</block>
								<view class="nickname" v-else>
									<text class="name">{{ memberInfo.nickname }}</text>
									<text class="member-level" @click="redirectBeforeAuth('/pages_tool/member/level')">
										<text class="icondiy icon-system-huangguan"></text>{{ memberInfo.member_level_name }}
									</text>
								</view>
								<view class="mobile" v-if="memberInfo.mobile">{{ memberInfo.mobile }}</view>
								<!-- #endif -->
				            </view>
				            <text class="iconfont iconico member-code" @click="showMemberQrcode"></text>
							<text class="iconfont iconshezhi user-info"  @click="$util.redirectTo('/pages_tool/member/info')"></text>
				        </view>
						<view class="info-wrap" v-else @click="redirect('/pages/member/index')">
						    <view class="headimg">
								<image :src="$util.getDefaultImage().head" mode="widthFix"></image>
						    </view>
						    <view class="info">
						        <view class="nickname">
						            <text class="name">登录/注册</text>
						        </view>
						        <view class="desc">点击登录 享受更多精彩信息</view>
						    </view>
						    <text class="iconfont iconico member-code"></text>
						</view>
						
				        <view class="account-info" v-show="diyinfo.member_info.style == 1" :style="{'margin-left': parseInt(diyinfo.member_info.margin) * 2 + 'rpx', 'margin-right': parseInt(diyinfo.member_info.margin) * 2 + 'rpx' }">
				            <view class="account-item" @click="redirect('/pages_tool/member/balance')">
				                <view class="value">{{ memberInfo ? (parseFloat(memberInfo.balance) + parseFloat(memberInfo.balance_money)).toFixed(2) : '--' }}</view>
				                <view class="title">余额</view>
				            </view>
				            <view class="solid"></view>
				            <view class="account-item" @click="redirect('/pages_tool/member/point')">
				                <view class="value">{{ memberInfo ? parseFloat(memberInfo.point) : '--' }}</view>
				                <view class="title">积分</view>
				            </view>
							<view class="solid"></view>
				            <view class="account-item" @click="redirect('/pages_tool/member/coupon')">
				                <view class="value">{{ memberInfo && memberInfo.coupon_num != undefined ? memberInfo.coupon_num  : '--' }}</view>
				                <view class="title">优惠券</view>
				            </view>
				           
				        </view>
				    </view>
				    <view class="account-info"
				         v-show="diyinfo.member_info.style == 2"
				         :style="{'margin-left': parseInt(diyinfo.member_info.margin) * 2 + 'rpx', 'margin-right': parseInt(diyinfo.member_info.margin) * 2 + 'rpx' }"
				    >
				        <view class="account-item" @click="redirect('/pages_tool/member/balance')">
				            <view class="value">{{ memberInfo ? (parseFloat(memberInfo.balance) + parseFloat(memberInfo.balance_money)).toFixed(2) : '--' }}</view>
				            <view class="title">余额</view>
				        </view>
				       
				        <view class="solid"></view>
				        <view class="account-item" @click="redirect('/pages_tool/member/point')">
				            <view class="value">{{ memberInfo ? parseFloat(memberInfo.point) : '--' }}</view>
				            <view class="title">积分</view>
				        </view>
						<view class="solid"></view>
						<view class="account-item" @click="redirect('/pages_tool/member/coupon')">
						    <view class="value">{{ memberInfo && memberInfo.coupon_num != undefined ? memberInfo.coupon_num  : '--' }}</view>
						    <view class="title">优惠券</view>
						</view>
				    </view>
				</view>
				
				<view class="common-wrap" :style="orderWrapStyle">
					<view class="order-wrap" :style="orderStyle">
						<view class="head-wrap" @click="redirect('/pages/order/list')">
							<view class="title">我的订单</view>
							<text class="see">全部订单</text>
							<text class="iconfont iconright"></text>
						</view>
						<view class="status-wrap">
							<view class="item-wrap" @click="redirect('/pages/order/list?status=waitpay')">
								<view class="icon-block">
									<diy-icon :icon="diyinfo.order.icon.waitPay.icon" v-if="diyinfo.order.icon.waitPay" :value="diyinfo.order.icon.waitPay.style ? diyinfo.order.icon.waitPay.style : null"></diy-icon>
									<text v-if="orderNum.waitpay > 0" class="order-num color-base-bg">{{ orderNum.waitpay > 99 ? '99+' : orderNum.waitpay }}</text>
								</view>
								<view class="title">待付款</view>
							</view>
							<view class="item-wrap" @click="redirect('/pages/order/list?status=waitsend')">
								<view class="icon-block">
									<diy-icon :icon="diyinfo.order.icon.waitSend.icon" v-if="diyinfo.order.icon.waitSend" :value="diyinfo.order.icon.waitSend.style ? diyinfo.order.icon.waitSend.style : null"></diy-icon>
									<text v-if="orderNum.waitsend > 0" class="order-num color-base-bg">{{ orderNum.waitsend > 99 ? '99+' : orderNum.waitsend }}</text>
								</view>
								<view class="title">待发货</view>
							</view>
							<view class="item-wrap" @click="redirect('/pages/order/list?status=waitconfirm')">
								<view class="icon-block">
									<diy-icon :icon="diyinfo.order.icon.waitConfirm.icon" v-if="diyinfo.order.icon.waitConfirm" :value="diyinfo.order.icon.waitConfirm.style ? diyinfo.order.icon.waitConfirm.style : null"></diy-icon>
									<text v-if="orderNum.waitconfirm > 0" class="order-num color-base-bg">{{ orderNum.waitconfirm > 99 ? '99+' : orderNum.waitconfirm }}</text>
								</view>
								<view class="title">待收货</view>
							</view>
							<view class="item-wrap" @click="redirect('/pages/order/list?status=waitrate')">
								<view class="icon-block">
									<diy-icon :icon="diyinfo.order.icon.waitRate.icon" v-if="diyinfo.order.icon.waitRate" :value="diyinfo.order.icon.waitRate.style ? diyinfo.order.icon.waitRate.style : null"></diy-icon>
									<text v-if="orderNum.waitrate > 0" class="order-num color-base-bg">{{ orderNum.waitrate > 99 ? '99+' : orderNum.waitrate }}</text>
								</view>
								<view class="title">待评价</view>
							</view>
							<view class="item-wrap" @click="redirect('/pages_tool/order/activist')">
								<view class="icon-block">
									<diy-icon :icon="diyinfo.order.icon.refunding.icon" v-if="diyinfo.order.icon.refunding" :value="diyinfo.order.icon.refunding.style ? diyinfo.order.icon.refunding.style : null"></diy-icon>
									<text v-if="orderNum.refunding > 0" class="order-num color-base-bg">{{ orderNum.refunding > 99 ? '99+' : orderNum.refunding }}</text>
								</view>
								<view class="title">售后</view>
							</view>
						</view>
					</view>
				</view>
				
				<view class="common-wrap" v-if="diyinfo.adv.list.length" :style="advWrapStyle">
					<view class="adv-wrap" :style="advStyle" ref="adv">
						<swiper :indicator-dots="diyinfo.adv.list.length > 1" :autoplay="true" :interval="3000" :duration="1000" class="swiper-wrap">
							<swiper-item v-for="(item, index) in diyinfo.adv.list" :key="index">
								<view class="swiper-item" @click="diyRedirect(item.link)">
									<image :src="$util.img(item.img)" mode="widthFix"></image>
								</view>
							</swiper-item>
						</swiper>
					</view>
				</view>
				
				<view class="common-wrap" :style="menuWrapStyle">
					<view class="menu-wrap" :style="menuStyle" :menu-type="diyinfo.menu.style">
						<view class="head-wrap">
							<view class="title">常用功能</view>
						</view>
						<view class="menu-list">
							<block v-for="(item, index) in diyinfo.menu.menus" :key="index">
								<view class="item-wrap" v-if="item.isShow" @click="diyRedirect(item.link)">
									<view class="icon">
										<image :src="$util.img(item.img)" mode="widthFix" v-if="item.icon_type == 'img'">
										<view class="icon-block" v-else>
											<diy-icon :icon="item.icon" v-if="item.icon" :value="item.style ? item.style : null"></diy-icon>
										</view>
									</view>
									<view class="title">{{ item.text }}</view>
									<text class="iconfont iconyoujiantou" v-if="diyinfo.menu.style == 'list'"></text>
								</view>
							</block>
						</view>
					</view>
				</view>
			</block>
			
			<ns-copyright></ns-copyright>
			
			<!-- 会员码 -->
			<uni-popup ref="erWeiPopup" type="center">
				<view class="member-code-popup">
					<view class="popup-top" @click="getMemberQrcode">
						<view class="popup-top-title">
							<view class="iconfont iconerweima"></view>
							<view class="popup-top-title-txt">会员码</view>
						</view>
						<view class="popup-top-tiao">
							<image :src="$util.img(memberCode.barcode)" mode=""></image>
						</view>  
						<view class="popup-top-erwei">
							<image :src="$util.img(memberCode.qrcode)" mode=""></image>
						</view>
						<view class="popup-top-shauxin" @click="getMemberQrcode">
							<text>动态码  {{ memberCode.dynamicNumber }}</text>
							<text class="iconfont iconshuaxin"></text>
						</view>
						<view class="popup-top-text">如遇到扫码失败请将屏幕调至最亮重新扫码</view>
					</view>
					<view class="popup-bottom">
						<text class="iconfont iconfont-delect icon2guanbi" @click="closeMemberQrcode"></text>
					</view>
				</view>
			</uni-popup>
			
			<ns-login ref="login"></ns-login>
			<loading-cover ref="loadingCover"></loading-cover>
		</scroll-view>
		
		<view id="tab-bar">
			<diy-bottom-nav></diy-bottom-nav>
		</view>
	</view>
</template>

<script>
import index from './public/js/index.js'
export default {
	mixins: [index]
};
</script>

<style lang="scss">
@import './public/css/index.scss';
</style>
