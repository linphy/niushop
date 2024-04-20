<template>
	<template v-if="tabbar && Object.keys(tabbar).length">
		<u-tabbar :value="value" @change="tabbarChange" zIndex="9999" :fixed="true" :placeholder="true" :safeAreaInsetBottom="true"
			:inactive-color="tabbar.value.textColor" :active-color="tabbar.value.textHoverColor" v-if="tabbar">
			<block v-for="item in tabbar.value.list">
				<u-tabbar-item class="py-[5rpx]" :style="{'background-color': tabbar.value.backgroundColor}" :text="item.text"
					:icon="img(value == item.link.url ? item.iconSelectPath : item.iconPath)" :name="item.link.url"
					v-if="tabbar.value.type == 1"></u-tabbar-item>
				<u-tabbar-item class="py-[5rpx]" :style="{'background-color': tabbar.value.backgroundColor}"
					:icon="img(value == item.link.url ? item.iconSelectPath : item.iconPath)" :name="item.link.url"
					v-if="tabbar.value.type == 2"></u-tabbar-item>
				<u-tabbar-item class="py-[5rpx]" :style="{'background-color': tabbar.value.backgroundColor}" :text="item.text" :name="item.link.url"
					v-if="tabbar.value.type == 3"></u-tabbar-item>
			</block>
		</u-tabbar>
		<view class="tab-bar-placeholder"></view>
	</template>
</template>

<script setup lang="ts">
	import { computed } from 'vue'
	import { redirect, currRoute, img } from '@/utils/common'
	import useConfigStore from '@/stores/config'

    const props = defineProps({
        addon: {
            type: String,
            default: ''
        }
    })

	if(props.addon){
        const configStore = useConfigStore()
        configStore.getTabbarConfig(props.addon)
	}

	const tabbar = computed(() => {
        return useConfigStore().tabbar
	})

	const value = computed(() => {
		return '/' + currRoute()
	})

	const tabbarChange = (url : string) => {
        // 外部链接
        if (url.indexOf('http') != -1 || url.indexOf('http') != -1) {

            // #ifdef H5
            window.location.href = url;
            // #endif

            // #ifdef MP
            redirect({
                url: '/app/pages/webview/index',
                param: { src: encodeURIComponent(url) }
            });
            // #endif
        } else {
            redirect({ url,mode: 'reLaunch' })
        }
	}

	const setAddon = (addon:any)=> {
        const configStore = useConfigStore()
        configStore.getTabbarConfig(addon)
    }

    defineExpose({
        setAddon
    })
</script>

<style lang="scss" scoped>
	.tab-bar-placeholder {
		padding-bottom: calc(constant(safe-area-inset-bottom) + 112rpx);
		padding-bottom: calc(env(safe-area-inset-bottom) + 112rpx);
	}
</style>
