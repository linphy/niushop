<template>
    <view class="diy-group" id="componentList">
        <view v-for="(component, index) in data.value" :key="component.id" @click="diyStore.changeCurrentIndex(index, component)" :class="getComponentClass(index,component)" :style="component.pageStyle">
            <template v-if="component.componentName == 'GraphicNav'">
                <diy-graphic-nav :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-graphic-nav>
            </template>
            <template v-if="component.componentName == 'HorzBlank'">
                <diy-horz-blank :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-horz-blank>
            </template>
            <template v-if="component.componentName == 'HorzLine'">
                <diy-horz-line :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-horz-line>
            </template>
            <template v-if="component.componentName == 'HotArea'">
                <diy-hot-area :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-hot-area>
            </template>
            <template v-if="component.componentName == 'ImageAds'">
                <diy-image-ads :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-image-ads>
            </template>
            <template v-if="component.componentName == 'MemberInfo'">
                <diy-member-info :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-member-info>
            </template>
            <template v-if="component.componentName == 'Notice'">
                <diy-notice :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-notice>
            </template>
            <template v-if="component.componentName == 'RubikCube'">
                <diy-rubik-cube :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-rubik-cube>
            </template>
            <template v-if="component.componentName == 'Text'">
                <diy-text :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-text>
            </template>
            <template v-if="component.componentName == 'RichText'">
                <diy-rich-text :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"/>
            </template>
            <template v-if="component.componentName == 'ActiveCube'">
                <diy-active-cube :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"/>
            </template>
			<template v-if="component.componentName == 'FloatBtn'">
			    <diy-float-btn :component="component" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"/>
			</template>
            <template v-if="component.componentName == 'CarouselSearch'">
                <diy-carousel-search :component="component" :global="data.global" :index="index" :pullDownRefreshCount="props.pullDownRefreshCount"></diy-carousel-search>
            </template>
        </view>
        <template v-if="diyStore.mode == '' && data.global.bottomTabBarSwitch">
            <view class="pt-[20rpx]"></view>
            <tabbar :addon="tabbarAddonName" />
        </template>
    </view>
</template>
<script lang="ts" setup>
   import useDiyStore from '@/app/stores/diy';
   import { ref, onMounted, nextTick, computed } from 'vue';
   import Sortable from 'sortablejs';
   import { range } from 'lodash-es';
   import useConfigStore from '@/stores/config'
   const props = defineProps(['data','pullDownRefreshCount']);
   const diyStore = useDiyStore();

   const data = computed(() => {
       if (diyStore.mode == 'decorate') {
           return diyStore;
       } else {
           return props.data;
       }
   })

   const tabbarAddonName = computed(() => {
       return useConfigStore().addon;
   })

   const positionFixed = ref(['fixed', 'top_fixed','right_fixed','bottom_fixed','left_fixed'])

   const getComponentClass = (index:any,component:any) => {
       let obj: any = {
           relative: true,
           selected: diyStore.currentIndex == index,
           decorate: diyStore.mode == 'decorate'
       }
       obj['top-fixed-' + diyStore.topFixedStatus] = true;

       if (component.position && positionFixed.value.indexOf(component.position) != -1) {
           //  找出置顶组件，设置禁止拖动
           obj['ignore-draggable-element'] = true;
       } else {
           obj['draggable-element'] = true;
       }
       return obj;
   }

   onMounted(() => {
       // #ifdef H5
       if (diyStore.mode == 'decorate') {
           var el = document.getElementById('componentList');
           const sortable = Sortable.create(el, {
               draggable: '.draggable-element',
               animation: 200,
               // 结束拖拽
               onEnd: event => {
                   let temp = diyStore.value[event.oldIndex!];
                   diyStore.value.splice(event.oldIndex!, 1);
                   diyStore.value.splice(event.newIndex!, 0, temp);

                   nextTick(() => {
                       sortable.sort(
                           range(diyStore.value.length).map(value => {
                               return value.toString();
                           })
                       );

                       diyStore.postMessage(event.newIndex, diyStore.value[event.newIndex]);
                   });
               }
           });
       }
       // #endif
   });
</script>
<style lang="scss" scoped>
   @import './index.scss';
</style>