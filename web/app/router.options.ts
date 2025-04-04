import type { RouterConfig } from '@nuxt/schema'
import routes from '@/app/pages/routes'

const addonRoutes = import.meta.globEager('@/addon/**/pages/routes.ts')

for (const key in addonRoutes) {
    const addon = key.split('/')[2]
    // 先加载插件路由后加载app路由
    routes.unshift(...addonRoutes[key].default.map((item) => {
        item.meta = item.meta ? Object.assign(item.meta, { addon }) : { addon }
        return item
    }))
}

// https://router.vuejs.org/api/interfaces/routeroptions.html
export default <RouterConfig>{
    routes: (_routes) => routes,
    strict: false
}
