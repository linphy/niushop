<template>
    <view :style="warpCss">
        <view :style="maskLayer"></view>
        <view class="diy-notice relative overflow-hidden">
            <view class="flex items-center pl-[28rpx] p-[22rpx]">
                <template v-if="diyComponent.noticeType == 'img'">
                    <template v-if="diyComponent.imgType == 'system'">
                        <image v-if="diyComponent.systemUrl == 'style_1'" :src="img(`static/resource/images/diy/notice/${diyComponent.systemUrl}.png`)" class="h-[40rpx] max-w-[130rpx] mr-[20rpx]" mode="heightFix"/>
                        <image v-else-if="diyComponent.systemUrl == 'style_2'" :src="img(`static/resource/images/diy/notice/${diyComponent.systemUrl}.png`)" class="w-[200rpx] mr-[20rpx] h-[40rpx]" mode="heightFix" />
                    </template>
                    <image v-else-if="diyComponent.imgType == 'diy'"  :src="img(diyComponent.imageUrl || '')" class="h-[50rpx] mr-[20rpx]" mode="heightFix"/>
                </template>
                <view v-if="diyComponent.noticeType == 'text' && diyComponent.noticeTitle" class="max-w-[128rpx] px-[12rpx] text-[26rpx] h-[40rpx] leading-[40rpx] text-[var(--primary-color)] bg-[var(--primary-color-light)] truncate rounded-[8rpx] mr-[20rpx]">{{ diyComponent.noticeTitle }}</view>
                <view class="flex-1 flex items-center">

                    <!-- 横向滚动 -->
                    <view class="horizontal-wrap" v-if="diyComponent.scrollWay == 'horizontal'">
                        <view class="marquee-wrap">
                            <view class="marquee" :style="marqueeStyle">
                                <text v-for="(item, index) in diyComponent.list" :key="index" @click="toRedirect(item)" :style="{ color: diyComponent.textColor, fontSize: diyComponent.fontSize * 2 + 'rpx', fontWeight: diyComponent.fontWeight }">{{ item.text }}</text>
                            </view>
                            <view class="marquee" :style="marqueeAgainStyle">
                                <text v-for="(item, index) in diyComponent.list" :key="index" @click="toRedirect(item)" :style="{ color: diyComponent.textColor, fontSize: diyComponent.fontSize * 2 + 'rpx', fontWeight: diyComponent.fontWeight }">{{ item.text }}</text>
                            </view>
                        </view>
                    </view>

                    <!-- 上下滚动 -->
                    <template v-if="diyComponent.scrollWay == 'upDown'">
                        <swiper :vertical="true" :duration="500" autoplay="true" circular="true" class="flex-1">
                            <swiper-item v-for="(item, index) in diyComponent.list" :key="index" @touchmove.prevent.stop>
                                <text @click="toRedirect(item)" class="beyond-hiding using-hidden" :style="{ color: diyComponent.textColor, fontSize: diyComponent.fontSize * 2 + 'rpx', fontWeight: diyComponent.fontWeight }">
                                    {{ item.text }}
                                </text>
                            </swiper-item>
                        </swiper>
                        <text class="iconfont iconxiangyoujiantou -ml-[8rpx] pl-[30rpx]" :style="{'color': '#999','fontSize': (12 * 2 + 'rpx'), 'fontWeight': diyComponent.fontWeight}"></text>

                    </template>
                </view>

            </view>

            <u-popup :show="noticeShow" @close="noticeShow = false"  mode="center" :round="5" :safeAreaInsetBottom="false">
                <view class="py-[25rpx] text-sm leading-none border-0 border-solid border-b-[2rpx] border-[#eee] flex items-center justify-between">
                    <text class="ml-[30rpx]">公告</text>
                    <text class="mr-[20rpx] iconfont iconguanbi text-[35rpx]" @click="noticeShow = false"></text>
                </view>
                <scroll-view scroll-y="true" class="px-6 py-3 w-[480rpx] h-[500rpx] text-sm">{{ noticeContent }}</scroll-view>
                <button @click="noticeShow = false" class="!mx-[30rpx] !mb-[40rpx] !w-auto !h-[70rpx] text-[24rpx] leading-[70rpx] rounded-full text-white !bg-[#ff4500] !text-[#fff]">我知道了</button>
            </u-popup>

        </view>
    </view>
</template>

<script setup lang="ts">
// 公告组件
import { ref,computed, watch, onMounted, nextTick,getCurrentInstance } from 'vue';
import { img, redirect,diyRedirect,currRoute, getToken } from '@/utils/common';
import useDiyStore from '@/app/stores/diy';
import { useLogin } from '@/hooks/useLogin';

const props = defineProps(['component', 'index', 'pullDownRefreshCount']);
const diyStore = useDiyStore();
const noticeShow = ref(false);
const noticeContent = ref('');

const diyComponent = computed(() => {
    if (diyStore.mode == 'decorate') {
        return diyStore.value[props.index];
    } else {
        return props.component;
    }
})

const warpCss = computed(() => {
    var style = '';
    style += 'position:relative;';
    if(diyComponent.value.componentStartBgColor) {
        if (diyComponent.value.componentStartBgColor && diyComponent.value.componentEndBgColor) style += `background:linear-gradient(${diyComponent.value.componentGradientAngle},${diyComponent.value.componentStartBgColor},${diyComponent.value.componentEndBgColor});`;
        else style += 'background-color:' + diyComponent.value.componentStartBgColor + ';';
    }

    if(diyComponent.value.componentBgUrl) {
        style += `background-image:url('${ img(diyComponent.value.componentBgUrl) }');`;
        style += 'background-size: cover;background-repeat: no-repeat;';
    }

    if (diyComponent.value.topRounded) style += 'border-top-left-radius:' + diyComponent.value.topRounded * 2 + 'rpx;';
    if (diyComponent.value.topRounded) style += 'border-top-right-radius:' + diyComponent.value.topRounded * 2 + 'rpx;';
    if (diyComponent.value.bottomRounded) style += 'border-bottom-left-radius:' + diyComponent.value.bottomRounded * 2 + 'rpx;';
    if (diyComponent.value.bottomRounded) style += 'border-bottom-right-radius:' + diyComponent.value.bottomRounded * 2 + 'rpx;';
    return style;
})

// 背景图加遮罩层
const maskLayer = computed(()=>{
    var style = '';
    if(diyComponent.value.componentBgUrl) {
        style += 'position:absolute;top:0;width:100%;';
        style += `background: rgba(0,0,0,${diyComponent.value.componentBgAlpha / 10});`;
        style += `height:${height.value}px;`;

        if (diyComponent.value.topRounded) style += 'border-top-left-radius:' + diyComponent.value.topRounded * 2 + 'rpx;';
        if (diyComponent.value.topRounded) style += 'border-top-right-radius:' + diyComponent.value.topRounded * 2 + 'rpx;';
        if (diyComponent.value.bottomRounded) style += 'border-bottom-left-radius:' + diyComponent.value.bottomRounded * 2 + 'rpx;';
        if (diyComponent.value.bottomRounded) style += 'border-bottom-right-radius:' + diyComponent.value.bottomRounded * 2 + 'rpx;';
    }

    return style;
});

watch(
    () => props.pullDownRefreshCount,
    (newValue, oldValue) => {
        // 处理下拉刷新业务
    }
)

const marqueeWrapWidth = ref(0); // 容器宽度
const marqueeWidth = ref(0); // 公告内容累加宽度
const marqueeStyle = ref(''); // 横向滚动样式
const marqueeAgainStyle = ref(''); // 横向滚动复制样式
const time = ref(0); // 滚动完成时间
const delayTime = ref(1000); // 动画延迟时间

// 绑定横向滚动事件
const bindCrossSlipEvent = ()=> {
    if (diyComponent.value.scrollWay == 'horizontal') {
        setTimeout(() => {
            nextTick(() => {
                uni.createSelectorQuery().in(instance).select('.marquee-wrap').boundingClientRect(res => {
                    marqueeWrapWidth.value = res.width;
                    const query = uni.createSelectorQuery().in(instance);
                    query.select('.marquee').boundingClientRect(data => {
                        marqueeWidth.value = data.width + 30; // 30px是间距
                        time.value = Math.ceil(marqueeWidth.value * 10);

                        if (marqueeWrapWidth.value > marqueeWidth.value) {
                            marqueeStyle.value = `animation: none;`;
                            marqueeAgainStyle.value = 'display:none;';
                        } else {
                            marqueeStyle.value = `
                                width: ${marqueeWidth.value}px;
                                animation-duration: ${time.value}ms;
                                animation-delay: ${delayTime.value}ms;`;
                            marqueeAgainStyle.value = `
                                width: ${marqueeWidth.value}px;
                                left: ${marqueeWidth.value}px;
                                animation-duration: ${time.value}ms;
                                animation-delay: ${delayTime.value}ms;`;
                        }
                    }).exec();
                }).exec();
            });
        });
    }
}

onMounted(() => {
    bindCrossSlipEvent();
    refresh();
    // 装修模式下刷新
    if (diyStore.mode == 'decorate') {
        watch(
            () => diyComponent.value,
            (newValue, oldValue) => {
                if (newValue && newValue.componentName == 'Notice') {
                    bindCrossSlipEvent();
                    refresh();
                }
            }
        )
    }
});

const instance = getCurrentInstance();
const height = ref(0)

const refresh = ()=> {
    nextTick(() => {
        const query = uni.createSelectorQuery().in(instance);
        query.select('.diy-notice').boundingClientRect((data: any) => {
            height.value = data.height;
        }).exec();
    })
}

const toRedirect = (data: {}) => {
    if(diyStore.mode == 'decorate') return false;

    if(diyComponent.value.showType == 'popup'){
        noticeShow.value = true;
        noticeContent.value = data.text;
    }else {
        if (data.link.url) {
            if (currRoute() == 'app/pages/member/index' && !getToken()) {
                useLogin().setLoginBack({ url: data.link.url })
                return;
            }
            diyRedirect(data.link);
        }
    }
}
</script>

<style lang="scss" scoped>
    .main-wrap {
        display: inline-block;
        width: calc(100% - 100rpx);
        position: relative;
    }

    swiper {
        height: 50rpx;
    }

    .beyond-hiding {
        display: inline-block;
        width: 100%;
        white-space: nowrap;
		line-height: 50rpx
    }

    .notice-popup {
        padding: 0 30rpx 40rpx;
        background-color: #fff;

        .head-wrap {
            font-size: 32rpx;
            line-height: 100rpx;
            height: 100rpx;
            display: block;
            text-align: center;
            position: relative;
            border-bottom: 2rpx solid #eeeeee;
            margin-bottom: 20rpx;

            .iconfont {
                position: absolute;
                float: right;
                right: 0;
                font-size: 32rpx;
            }
        }

        .content-wrap {
            max-height: 600rpx;
            overflow-y: auto;
        }

        button {
            margin-top: 40rpx;
        }
    }

    .horizontal-wrap {
        height: 30px;
        line-height: 30px;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .marquee-wrap {
        display: inline-block;
        width: 100%;
        height: 100%;
        vertical-align: middle;
        overflow: hidden;
        box-sizing: border-box;
        position: relative;
    }

    .marquee {
        display: flex;
        position: absolute;
        white-space: nowrap;
        animation: marquee 0s 0s linear infinite;

        text {
            margin-left: 40rpx;

            &:first-child {
                margin-left: 0;
            }
        }
    }

    @keyframes marquee {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }
</style>
