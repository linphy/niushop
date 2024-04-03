<template>
	<view :style="warpCss">
		<view :class="['float-btn flex flex-col z-1000 items-center px-[24rpx] fixed', diyComponent.bottomPosition, diyStore.mode == 'decorate' ? 'float-btn-border' : '']" :style="floatBtnWrapCss">
			<view v-for="(item,index) in diyComponent.list" :key="index" @click="toRedirect(item.link)" :class="{'flex items-center justify-center' : true, 'mb-[20rpx]': diyComponent.list.length != index+1 }" :style="floatBtnItemCss">
				<image v-if="item && item.imageUrl" :style="floatBtnItemCss" :src="img(item.imageUrl)" mode="aspectFit"></image>
				<image v-else :src="img('static/resource/images/diy/figure.png')" mode="aspectFit" :style="floatBtnItemCss"/>
			</view>
		</view>
	</view>
</template>

<script setup lang="ts">
	// 浮动按钮组件
	import { computed, watch } from 'vue';
	import useDiyStore from '@/app/stores/diy';
	import { img,redirect,diyRedirect, currRoute, getToken } from '@/utils/common';
    import { useLogin } from '@/hooks/useLogin';

	const props = defineProps(['component', 'index', 'pullDownRefreshCount']);

	const diyStore = useDiyStore();

	const diyComponent = computed(() => {
		if (diyStore.mode == 'decorate') {
			return diyStore.value[props.index];
		} else {
			return props.component;
		}
	})

	const warpCss = computed(() => {
		var style = '';
        if(diyComponent.value.componentStartBgColor) {
            if (diyComponent.value.componentStartBgColor && diyComponent.value.componentEndBgColor) style += `background:linear-gradient(${diyComponent.value.componentGradientAngle},${diyComponent.value.componentStartBgColor},${diyComponent.value.componentEndBgColor});`;
            else style += 'background-color:' + diyComponent.value.componentStartBgColor + ';';
        }
		if (diyComponent.value.topRounded) style += 'border-top-left-radius:' + diyComponent.value.topRounded * 2 + 'rpx;';
		if (diyComponent.value.topRounded) style += 'border-top-right-radius:' + diyComponent.value.topRounded * 2 + 'rpx;';
		if (diyComponent.value.bottomRounded) style += 'border-bottom-left-radius:' + diyComponent.value.bottomRounded * 2 + 'rpx;';
		if (diyComponent.value.bottomRounded) style += 'border-bottom-right-radius:' + diyComponent.value.bottomRounded * 2 + 'rpx;';
		return style;
	})

	const floatBtnItemCss = computed(() => {
		var style = '';
		style += 'width:' + diyComponent.value.imageSize * 2 + 'rpx;';
		style += 'height:' + diyComponent.value.imageSize * 2 + 'rpx;';
		style += 'border-radius:' + diyComponent.value.aroundRadius * 2 + 'rpx;';
		return style;
	})

	const floatBtnWrapCss = computed(() => {
		let style = '';
		if(diyComponent.value.offset){
			if(diyComponent.value.bottomPosition == 'lowerRight' || diyComponent.value.bottomPosition == 'lowerLeft'){
				style += 'padding-bottom:'+ diyComponent.value.offset * 2 + 'rpx;';
			}else if(diyComponent.value.bottomPosition == 'upperRight' || diyComponent.value.bottomPosition == 'upperLeft'){
				style += 'padding-top:'+ diyComponent.value.offset * 2 + 'rpx;';
			}
		}
		return style;
	})

	watch(
		() => props.pullDownRefreshCount,
		(newValue, oldValue) => {
			// 处理下拉刷新业务
		}
	)

    const toRedirect = (data: {}) => {
        if (Object.keys(data).length) {
            if (!data.url) return;
            if (currRoute() == 'app/pages/member/index' && !getToken()) {
                useLogin().setLoginBack({ url: data.url })
                return;
            }
            diyRedirect(data);
        } else {
            redirect(data)
        }
    }
</script>

<style lang="scss" scoped>
	.float-btn{
		&.decorate-position.upperRight,&.decorate-position.lowerRight {
			align-items: flex-end;
		}
		&.decorate-position.upperLeft,&.decorate-position.lowerLeft {
			align-items: baseline;
		}
		&.upperLeft {
			top: 100rpx;
			left: 30rpx;
		}

		&.upperRight {
			top: 100rpx;
			right: 30rpx;
		}

		&.lowerLeft {
			bottom: 160rpx;
			left: 30rpx;
			padding-bottom: constant(safe-area-inset-bottom);
			/*兼容 IOS<11.2*/
			padding-bottom: env(safe-area-inset-bottom);
			/*兼容 IOS>11.2*/
		}

		&.lowerRight {
			bottom: 160rpx;
			right: 30rpx;
			padding-bottom: constant(safe-area-inset-bottom);
			/*兼容 IOS<11.2*/
			padding-bottom: env(safe-area-inset-bottom);
			/*兼容 IOS>11.2*/
		}
	}
	.z-1000{
		z-index: 1000;
	}
	.float-btn-border{
		border: 4rpx dashed var(--primary-color);
	}
</style>