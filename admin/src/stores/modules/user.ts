import { defineStore } from 'pinia'
import { getToken, setToken, removeToken, getAppType } from '@/utils/common'
import { login, getAuthMenus } from '@/app/api/auth'
import storage from '@/utils/storage'
import router from '@/router'
import { getApply } from '@/app/api/apply'
import { formatRouters, findFirstValidRoute } from '@/router/routers'

interface User {
    token: string,
    userInfo: object,
    routers: any[],
    addonIndexRoute: Record<string, symbol>,
    rules: any[]
}

const useUserStore = defineStore('user', {
    state: (): User => {
        return {
            token: getToken() || '',
            userInfo: storage.get('userinfo') || {},
            routers: [],
            addonIndexRoute: {},
            rules: []
        }
    },
    actions: {
        login(form: object) {
            return new Promise((resolve, reject) => {
                login(form)
                    .then((res) => {
                        this.token = res.data.token
                        this.userInfo = res.data.userinfo
                        setToken(res.data.token)
                        storage.set({ key: 'userinfo', data: res.data.userinfo })
                        storage.set({ key: 'comparisonTokenStorage', data: res.data.token })
                        resolve(res)
                    })
                    .catch((error) => {
                        reject(error)
                    })
            })
        },
        clearRouters() {
            this.routers = []
        },
        logout() {
            this.token = ''
            this.userInfo = {}
            removeToken()
            storage.remove(['userinfo'])
            this.routers = []
            router.push('/login')
        },
        getAuthMenus() {
            return new Promise((resolve, reject) => {
                getAuthMenus()
                    .then((res) => {
                        this.routers = formatRouters(res.data)
                        // 获取插件的首个菜单
                        this.routers.forEach((item, index) => {
                            if (item.meta.app !== '') {
                                if (item.children && item.children.length) {
                                    this.addonIndexRoute[item.meta.addon] = findFirstValidRoute(item.children)
                                } else {
                                    this.addonIndexRoute[item.meta.addon] = item.name
                                }
                            }
                        })
                        resolve(res)
                    })
                    .catch((error) => {
                        reject(error)
                    })
            })
        }
    }
})

export default useUserStore
