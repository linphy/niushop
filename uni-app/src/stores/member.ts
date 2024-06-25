import { defineStore } from 'pinia'
import { setToken, removeToken, redirect } from '@/utils/common'
import { getMemberInfo,getMemberLevel } from '@/app/api/member'
import { logout } from '@/app/api/auth'

interface Member {
    token : string | null
    info : AnyObject | null
    levelList : Array<any> | null
}

const useMemberStore = defineStore('member', {
    state: () : Member => {
        return {
            token: uni.getStorageSync(import.meta.env.VITE_REQUEST_STORAGE_TOKEN_KEY),
            info: null,
			levelList:null
        }
    },
    actions: {
        async setToken(token : string) {
            this.token = token
            setToken(token)
            await this.getMemberInfo()
        },
        async getMemberInfo() {
            if (!this.token) return
            await getMemberInfo().then((res: any) => {
                this.info = res.data
                uni.setStorageSync('wap_member_info',this.info)
                uni.setStorageSync('wap_member_id',res.data.member_id)
            }).catch(async () => {
                await this.logout()
            })
        },
        async logout(isRedirect : boolean = false) {
            if (!this.token) return
            this.token = ''
            this.info = null
            uni.setStorageSync('autoLoginLock', true)
            await logout().then(() => {
                removeToken()
                uni.removeStorageSync('wap_member_info');
                isRedirect && redirect({ url: '/app/pages/index/index', mode: 'switchTab' })
            }).catch(() => {
                removeToken()
                uni.removeStorageSync('wap_member_info');
                isRedirect && redirect({ url: '/app/pages/index/index', mode: 'switchTab' })
            })
        },
		getMemberLevel(){
			getMemberLevel().then((res:any)=>{
				this.levelList = res.data
			})
		}
    }
})

export default useMemberStore
