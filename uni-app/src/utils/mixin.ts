import { currRoute } from './common'
import { redirectInterceptor } from './interceptor'
import useConfigStore from "@/stores/config";
import useSystemStore from '@/stores/system'

export default {
    install(vue) {
        vue.mixin({
            data() {
                return {
                    query: {}
                }
            },
            onLoad: (data: object) => {
                const route = currRoute() ?? ''

                this.query = data

                useSystemStore().$patch((state) => {
                    state.currRoute = route
                })
            },
            onShow: () => {
                const route = currRoute() ?? ''

                useSystemStore().$patch((state) => {
                    state.currRoute = route
                })

                redirectInterceptor({
                    path: route,
                    query: this.query
                })
            },
            methods:{
                themeColor(){
                    const configStore = useConfigStore()
                    return configStore.getThemeColor();
                }
            }
        });
    },
};
