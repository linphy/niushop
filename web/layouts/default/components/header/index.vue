<template>
    <div class="flex h-full min-w-[1200px] bg-[#fff]">
        <div class="flex items-center ml-[20px]">
            <NuxtLink to="/">
                <div class="w-[132px] mr-[10px]"><img src="@/assets/images/index/logo.jpg" /></div>
            </NuxtLink>
            <div class="hidden text-[14px] text-[#A6B0C8] xl:block">|<span class="ml-[10px]">一款快速开发多应用管理系统后台框架</span>
            </div>
        </div>

        <div class="mx-auto flex-shrink">
            <el-menu :default-active="appStore.route" class="h-full" mode="horizontal" :ellipsis="false" :router="true">
                <el-menu-item index="/" route="/app/index">
                    <span class="text-base mx-4">首页</span>
                    <span></span>
                </el-menu-item>
                <el-menu-item index="bbs">
                    <span class="text-base mx-4" @click.stop="openBbs">社区</span>
                    <span></span>
                </el-menu-item>
            </el-menu>
        </div>

        <div class="flex items-center justify-end mr-[20px] ml-auto whitespace-pre-wrap">
            <div v-if="info">
                <NuxtLink to="/app/member/center">
                    <span class="cursor-pointer">{{ info.nickname }}</span>
                </NuxtLink>
                <span class="mx-2">|</span>
                <span class="cursor-pointer" @click="logoutFn">退出</span>
            </div>
            <el-button type="primary" link v-else @click="toLogin">{{ t('login') }} / {{ t('register') }}</el-button>
        </div>
        <LoadingDialog/>
    </div>
</template>

<script lang="ts" setup>
import {  getToken } from '@/utils/common'
import useMemberStore from '@/stores/member'
import useAppStore from '@/stores/app'
import useConfigStore from '@/stores/config'
import LoadingDialog from '@/components/login-dialog/index.vue'

const configStore = useConfigStore()
const memberStore = useMemberStore()
const info = computed(() => memberStore.info)

const toLogin = () => {
    if(!getToken() && !configStore.login.is_username && !configStore.login.is_mobile && !configStore.login.is_bind_mobile){
        ElMessage.error('商家未开启普通账号登录注册')
        return false
    }
    memberStore.logOpen()
}
const logoutFn = () => {
    memberStore.logout()
    navigateTo(`/app/index`)
}

const openBbs = () => {
    window.open('https://www.niushop.com/bbs.html')
}
const appStore = useAppStore()
</script>

<style lang="scss" scoped>
:deep(.el-menu--horizontal) {
    border-bottom: none;
}

.el-menu-item {
    padding-left: 0;
    border: none !important;
    color: #000 !important;

    &.is-active {
        border: none !important;
        color: #000 !important;

        span {
            &:first-of-type {
                position: relative;
                z-index: 1;
            }

            &:last-of-type {
                position: absolute;
                width: 16px;
                height: 16px;
                background-image: linear-gradient(to bottom right, #FFFFFF, var(--el-color-primary));
                border-radius: 100px;
                bottom: 15px;
                right: 27px;
                z-index: 0;
            }
        }
    }

    &:hover {
        background-color: transparent !important;
        color: var(--el-menu-hover-text-color) !important;
    }

    &:focus {
        background-color: transparent !important;
    }
}
</style>
