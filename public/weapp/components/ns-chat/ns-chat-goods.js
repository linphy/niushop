(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-chat/ns-chat-goods"],{"076d":function(n,t,o){},"0ad0":function(n,t,o){"use strict";var e;o.d(t,"b",(function(){return s})),o.d(t,"c",(function(){return u})),o.d(t,"a",(function(){return e}));var s=function(){var n=this,t=n.$createElement,o=(n._self._c,n.$util.img(n.goodsInfo.sku_image));n.$mp.data=Object.assign({},{$root:{g0:o}})},u=[]},1065:function(n,t,o){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var e={name:"ns-chat-goods",props:{skuId:{type:[Number,String]},isCanSend:Boolean},data:function(){return{goodsInfo:{},send:!1}},mounted:function(){this.getGoodsInfo()},methods:{getGoodsInfo:function(){var n=this;this.$api.sendRequest({url:"/api/goodssku/detail",data:{sku_id:this.skuId},success:function(t){t.code>=0&&(n.goodsInfo=t.data.goods_sku_detail)}})},sendMsg:function(){this.$emit("sendMsg","goods")}}};t.default=e},"696d":function(n,t,o){"use strict";o.r(t);var e=o("0ad0"),s=o("c5ef");for(var u in s)"default"!==u&&function(n){o.d(t,n,(function(){return s[n]}))}(u);o("8c8c");var a,c=o("f0c5"),d=Object(c["a"])(s["default"],e["b"],e["c"],!1,null,null,null,!1,e["a"],a);t["default"]=d.exports},"8c8c":function(n,t,o){"use strict";var e=o("076d"),s=o.n(e);s.a},c5ef:function(n,t,o){"use strict";o.r(t);var e=o("1065"),s=o.n(e);for(var u in e)"default"!==u&&function(n){o.d(t,n,(function(){return e[n]}))}(u);t["default"]=s.a}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-chat/ns-chat-goods-create-component',
    {
        'components/ns-chat/ns-chat-goods-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("696d"))
        })
    },
    [['components/ns-chat/ns-chat-goods-create-component']]
]);
