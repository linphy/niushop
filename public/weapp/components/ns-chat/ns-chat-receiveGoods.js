(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-chat/ns-chat-receiveGoods"],{"3b49":function(t,n,e){"use strict";var o=e("613a"),s=e.n(o);s.a},"54a2":function(t,n,e){"use strict";e.r(n);var o=e("99bc"),s=e.n(o);for(var u in o)"default"!==u&&function(t){e.d(n,t,(function(){return o[t]}))}(u);n["default"]=s.a},"613a":function(t,n,e){},"99bc":function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var o={name:"ns-chat-receiveGoods",props:{skuId:{type:[Number,String]}},data:function(){return{goodsINfo:{}}},mounted:function(){this.getInfo()},methods:{getInfo:function(){var t=this;console.log(this.skuId,"this.orderId"),this.$api.sendRequest({url:"/api/goodssku/detail",data:{sku_id:this.skuId},success:function(n){console.log(n,"res"),n.code>=0&&(t.goodsINfo=n.data.goods_sku_detail,t.$emit("upDOM"))}})},go_shop:function(){this.$util.redirectTo("/pages/goods/detail/detail?sku_id="+this.skuId)}}};n.default=o},ec08:function(t,n,e){"use strict";e.r(n);var o=e("f19f"),s=e("54a2");for(var u in s)"default"!==u&&function(t){e.d(n,t,(function(){return s[t]}))}(u);e("3b49");var i,a=e("f0c5"),c=Object(a["a"])(s["default"],o["b"],o["c"],!1,null,null,null,!1,o["a"],i);n["default"]=c.exports},f19f:function(t,n,e){"use strict";var o;e.d(n,"b",(function(){return s})),e.d(n,"c",(function(){return u})),e.d(n,"a",(function(){return o}));var s=function(){var t=this,n=t.$createElement,e=(t._self._c,t.$util.img(t.goodsINfo.sku_image));t.$mp.data=Object.assign({},{$root:{g0:e}})},u=[]}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-chat/ns-chat-receiveGoods-create-component',
    {
        'components/ns-chat/ns-chat-receiveGoods-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("ec08"))
        })
    },
    [['components/ns-chat/ns-chat-receiveGoods-create-component']]
]);
