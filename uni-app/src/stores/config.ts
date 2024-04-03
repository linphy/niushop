import { defineStore } from 'pinia'
import { getConfig } from '@/app/api/auth'
import { getTabbarInfo } from '@/app/api/diy'

interface loginConfig {
    is_username: number | boolean,
    is_mobile: number | boolean,
    is_auth_register: number | boolean,
    is_bind_mobile: number | boolean,
    agreement_show: number | boolean
}

interface tabbarConfig {
    backgroundColor: string,
    textColor: string,
    textHoverColor: string,
    list: AnyObject[]
}

interface Config {
    login: loginConfig,
    tabbar: tabbarConfig | null,
    addon: String,
    themeColor:String
}

const useConfigStore = defineStore('config', {
    state: (): Config => {
        return {
            login: {
                is_username: 0,
                is_mobile: 0,
                is_auth_register: 0,
                is_bind_mobile: 0,
                agreement_show: 0
            },
            tabbar: null,
            addon: '',
            themeColor:''
        }
    },
    actions: {
        async getLoginConfig() {
            await getConfig().then((res: responseResult) => {
                this.login.is_username = parseInt(res.data.is_username)
                this.login.is_mobile = parseInt(res.data.is_mobile)
                this.login.is_auth_register = parseInt(res.data.is_auth_register)
                this.login.is_bind_mobile = parseInt(res.data.is_bind_mobile)
                this.login.agreement_show = parseInt(res.data.agreement_show)
            }).catch(() => {
            })
        },
        async getTabbarConfig(key: any = '') {
            if(key == this.addon) return; // 防重复请求
            if (!key) key = this.addon;

            await getTabbarInfo({key}).then((res: responseResult) => {
                this.tabbar = res.data
            }).catch(() => {
            })
        },
        // 获取主色调
        getThemeColor() {
            let themeColorStorage = uni.getStorageSync('current_theme_color');
            if (!this.themeColor && themeColorStorage) {
                this.themeColor = JSON.parse(themeColorStorage);
            }
            if (this.themeColor) {
                let style = '';
                for (let k in this.themeColor) {
                    style += `${k}:${this.themeColor[k]};`;
                }
                return style;
            }
            return '';
        }
    }
})

export default useConfigStore
