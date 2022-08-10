(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-chat/ns-chat-receiveGoods"],{"15ec":function(t,o,n){"use strict";var e=n("6e5b"),u=n.n(e);u.a},2504:function(t,o,n){"use strict";Object.defineProperty(o,"__esModule",{value:!0}),o.default=void 0;var e={name:"ns-chat-receiveGoods",props:{skuId:{type:[Number,String]}},data:function(){return{goodsINfo:{}}},mounted:function(){this.getInfo()},methods:{getInfo:function(){var t=this;this.$api.sendRequest({url:"/api/goodssku/detail",data:{sku_id:this.skuId},success:function(o){o.code>=0&&(t.goodsINfo=o.data.goods_sku_detail,t.$emit("upDOM"))}})},go_shop:function(){this.$util.redirectTo("/pages/goods/detail?goods_id="+this.goodsINfo.goods_id)}}};o.default=e},"6e5b":function(t,o,n){},"87d6":function(t,o,n){"use strict";n.r(o);var e=n("cf92"),u=n("f707");for(var s in u)"default"!==s&&function(t){n.d(o,t,(function(){return u[t]}))}(s);n("15ec");var i,a=n("f0c5"),c=Object(a["a"])(u["default"],e["b"],e["c"],!1,null,null,null,!1,e["a"],i);o["default"]=c.exports},cf92:function(t,o,n){"use strict";var e;n.d(o,"b",(function(){return u})),n.d(o,"c",(function(){return s})),n.d(o,"a",(function(){return e}));var u=function(){var t=this,o=t.$createElement,n=(t._self._c,t.$util.img(t.goodsINfo.sku_image));t.$mp.data=Object.assign({},{$root:{g0:n}})},s=[]},f707:function(t,o,n){"use strict";n.r(o);var e=n("2504"),u=n.n(e);for(var s in e)"default"!==s&&function(t){n.d(o,t,(function(){return e[t]}))}(s);o["default"]=u.a}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-chat/ns-chat-receiveGoods-create-component',
    {
        'components/ns-chat/ns-chat-receiveGoods-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("87d6"))
        })
    },
    [['components/ns-chat/ns-chat-receiveGoods-create-component']]
]);
