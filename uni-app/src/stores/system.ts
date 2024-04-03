import { defineStore } from 'pinia'
import { getSiteInfo } from '@/app/api/system'
import { redirect } from '@/utils/common'

interface System {
	site : AnyObject | null,
	siteApps: string[],
	siteAddons: string[]
}

const useSystemStore = defineStore('system', {
	state: () : System => {
		return {
			site: null,
			siteApps: [],
			siteAddons: []
		}
	},
	actions: {
		async getSiteInfoFn() {
			await getSiteInfo().then((res: any) => {
				this.site = res.data
				const apps = [], addons = []
				Object.keys(res.data.site_addons).forEach((key:string) => {
					const item = res.data.site_addons[key]
					item.type == 'app' ? apps.push(key) : addons.push(key)
				})
				this.siteApps = apps
				this.siteAddons = addons
			}).catch((err) => {
			})
		}
	}
})

export default useSystemStore
