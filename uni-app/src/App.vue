<script setup lang="ts">
    import { onLaunch, onShow, onHide } from '@dcloudio/uni-app'
    import { launchInterceptor } from '@/utils/interceptor'
    import { getToken, isWeixinBrowser } from '@/utils/common'
    import useMemberStore from '@/stores/member'
    import useConfigStore from '@/stores/config'
    import useSystemStore from '@/stores/system'
    import { useLogin } from '@/hooks/useLogin'
    import { useShare } from '@/hooks/useShare'

    onLaunch(async(data) => {

        // 添加初始化拦截器
        launchInterceptor()

        // #ifdef H5
        uni.getSystemInfoSync().platform == 'ios' && (uni.setStorageSync('initUrl', location.href))

        // 传输给后台数据
        window.parent.postMessage(JSON.stringify({
            type: 'appOnLaunch',
            message: '初始化加载完成'
        }), '*');

        // 监听父页面发来的消息
        window.addEventListener('message', event => {
            try {
                let data = {
                    type: ''
                };
                if (typeof event.data == 'string') {
                    data = JSON.parse(event.data)
                } else if (typeof event.data == 'object') {
                    data = event.data
                }
                if (data.type && data.type == 'appOnReady') {
                    window.parent.postMessage(JSON.stringify({
                        type: 'appOnReady',
                        message: '加载完成'
                    }), '*');
                }
            } catch (e) {
                console.log('uni-app App.vue 接受数据错误', e)
            }
        }, false);

        const { wechatInit } = useShare()
        wechatInit()
        // #endif

        const configStore = useConfigStore()
        await configStore.getTabbarConfig()
        await configStore.getLoginConfig()

        useSystemStore().getMapFn()
        useSystemStore().getSiteInfoFn()
		useMemberStore().getMemberLevel()
        try {
            // 隐藏tabbar
            uni.hideTabBar()
        } catch (e) {

        }

        // 判断是否已登录
        if (getToken()) {
            const memberStore = useMemberStore()
            await memberStore.setToken(getToken())

            setTimeout(() => {
                if (!uni.getStorageSync('openid')) {
                    const memberInfo = useMemberStore().info
                    // #ifdef MP-WEIXIN
                    memberInfo && memberInfo.weapp_openid && uni.setStorageSync('openid', memberInfo.weapp_openid)
                    // #endif
                    // #ifdef H5
                    isWeixinBrowser() && memberInfo && memberInfo.wx_openid && uni.setStorageSync('openid', memberInfo.wx_openid)
                    // #endif
                }
            }, 1000)
        }

        if (!getToken()) {
            const login = useLogin()
            // 第三方平台自动登录
            // #ifdef MP
            login.getAuthCode()
            // #endif
            // #ifdef H5
            if (isWeixinBrowser()) {
                data.query.code ? login.authLogin(data.query.code) : login.getAuthCode('snsapi_userinfo')
            }
            // #endif
        }
    })

    onShow(() => {
    })

    onHide(() => {
    })
</script>

<style>
	uni-page-head {
		display: none !important;
	}
</style>
