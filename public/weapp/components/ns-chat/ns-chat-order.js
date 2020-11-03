(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-chat/ns-chat-order"],{"2b1f":function(n,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var o={name:"ns-chat-goods",props:{orderId:{type:[Number,String]},isCanSend:Boolean},data:function(){return{orderInfo:{}}},mounted:function(){this.getGoodsInfo()},methods:{getGoodsInfo:function(){var n=this;this.$api.sendRequest({url:"/api/order/detail",data:{order_id:this.orderId},success:function(t){t.code>=0&&(n.orderInfo=t.data)}})},sendMsg:function(){this.$emit("sendMsg","order")}}};t.default=o},"7ab9":function(n,t,e){},"8c90":function(n,t,e){"use strict";var o;e.d(t,"b",(function(){return r})),e.d(t,"c",(function(){return a})),e.d(t,"a",(function(){return o}));var r=function(){var n=this,t=n.$createElement,e=(n._self._c,n.$util.img(n.orderInfo.order_goods?n.orderInfo.order_goods[0].sku_image:""));n.$mp.data=Object.assign({},{$root:{g0:e}})},a=[]},"93fa":function(n,t,e){"use strict";e.r(t);var o=e("8c90"),r=e("c5e3");for(var a in r)"default"!==a&&function(n){e.d(t,n,(function(){return r[n]}))}(a);e("a5ba");var u,d=e("f0c5"),s=Object(d["a"])(r["default"],o["b"],o["c"],!1,null,null,null,!1,o["a"],u);t["default"]=s.exports},a5ba:function(n,t,e){"use strict";var o=e("7ab9"),r=e.n(o);r.a},c5e3:function(n,t,e){"use strict";e.r(t);var o=e("2b1f"),r=e.n(o);for(var a in o)"default"!==a&&function(n){e.d(t,n,(function(){return o[n]}))}(a);t["default"]=r.a}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-chat/ns-chat-order-create-component',
    {
        'components/ns-chat/ns-chat-order-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("93fa"))
        })
    },
    [['components/ns-chat/ns-chat-order-create-component']]
]);
