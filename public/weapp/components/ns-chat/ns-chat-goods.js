(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-chat/ns-chat-goods"],{"1e9a":function(t,n,o){"use strict";o.r(n);var e=o("a1c8"),s=o("261c");for(var u in s)"default"!==u&&function(t){o.d(n,t,(function(){return s[t]}))}(u);o("4c21");var a,i=o("f0c5"),c=Object(i["a"])(s["default"],e["b"],e["c"],!1,null,null,null,!1,e["a"],a);n["default"]=c.exports},"261c":function(t,n,o){"use strict";o.r(n);var e=o("b6e4"),s=o.n(e);for(var u in e)"default"!==u&&function(t){o.d(n,t,(function(){return e[t]}))}(u);n["default"]=s.a},"4c21":function(t,n,o){"use strict";var e=o("5c4a1"),s=o.n(e);s.a},"5c4a1":function(t,n,o){},a1c8:function(t,n,o){"use strict";var e;o.d(n,"b",(function(){return s})),o.d(n,"c",(function(){return u})),o.d(n,"a",(function(){return e}));var s=function(){var t=this,n=t.$createElement,o=(t._self._c,t.goodsInfo.goods_name?t.$util.img(t.goodsInfo.sku_image):null),e=!t.goodsInfo.goods_name&&t.goodsDetail?t.$util.img(t.goodsDetail.sku_image):null;t.$mp.data=Object.assign({},{$root:{g0:o,g1:e}})},u=[]},b6e4:function(t,n,o){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var e={name:"ns-chat-goods",props:{skuId:{type:[Number,String]},goodsDetail:{type:[Object]}},data:function(){return{goodsInfo:{}}},mounted:function(){this.getGoodsInfo()},methods:{getGoodsInfo:function(){var t=this;this.$api.sendRequest({url:"/api/goodssku/detail",data:{sku_id:this.skuId},success:function(n){n.code>=0&&(t.goodsInfo=n.data.goods_sku_detail)}})},sendMsg:function(){this.$emit("sendMsg","goods")}}};n.default=e}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-chat/ns-chat-goods-create-component',
    {
        'components/ns-chat/ns-chat-goods-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("1e9a"))
        })
    },
    [['components/ns-chat/ns-chat-goods-create-component']]
]);
