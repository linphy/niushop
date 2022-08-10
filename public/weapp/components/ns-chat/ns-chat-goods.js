(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-chat/ns-chat-goods"],{3703:function(t,n,o){"use strict";o.r(n);var e=o("6e2e"),s=o("f985");for(var u in s)"default"!==u&&function(t){o.d(n,t,(function(){return s[t]}))}(u);o("8331");var a,i=o("f0c5"),d=Object(i["a"])(s["default"],e["b"],e["c"],!1,null,null,null,!1,e["a"],a);n["default"]=d.exports},"6e2e":function(t,n,o){"use strict";var e;o.d(n,"b",(function(){return s})),o.d(n,"c",(function(){return u})),o.d(n,"a",(function(){return e}));var s=function(){var t=this,n=t.$createElement,o=(t._self._c,t.goodsInfo.goods_name?t.$util.img(t.goodsInfo.sku_image):null),e=!t.goodsInfo.goods_name&&t.goodsDetail?t.$util.img(t.goodsDetail.sku_image):null;t.$mp.data=Object.assign({},{$root:{g0:o,g1:e}})},u=[]},"7e98":function(t,n,o){},8331:function(t,n,o){"use strict";var e=o("7e98"),s=o.n(e);s.a},be00:function(t,n,o){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var e={name:"ns-chat-goods",props:{skuId:{type:[Number,String]},goodsDetail:{type:[Object]}},data:function(){return{goodsInfo:{}}},mounted:function(){this.getGoodsInfo()},methods:{getGoodsInfo:function(){var t=this;this.$api.sendRequest({url:"/api/goodssku/detail",data:{sku_id:this.skuId},success:function(n){n.code>=0&&(t.goodsInfo=n.data.goods_sku_detail)}})},sendMsg:function(){this.$emit("sendMsg","goods")}}};n.default=e},f985:function(t,n,o){"use strict";o.r(n);var e=o("be00"),s=o.n(e);for(var u in e)"default"!==u&&function(t){o.d(n,t,(function(){return e[t]}))}(u);n["default"]=s.a}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-chat/ns-chat-goods-create-component',
    {
        'components/ns-chat/ns-chat-goods-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("3703"))
        })
    },
    [['components/ns-chat/ns-chat-goods-create-component']]
]);
