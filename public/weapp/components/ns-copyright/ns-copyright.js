(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-copyright/ns-copyright"],{"1dc2":function(t,n,o){"use strict";o.r(n);var i=o("ce7a"),e=o("734d");for(var u in e)"default"!==u&&function(t){o.d(n,t,(function(){return e[t]}))}(u);o("7050");var c,a=o("f0c5"),r=Object(a["a"])(e["default"],i["b"],i["c"],!1,null,null,null,!1,i["a"],c);n["default"]=r.exports},7050:function(t,n,o){"use strict";var i=o("9221"),e=o.n(i);e.a},"734d":function(t,n,o){"use strict";o.r(n);var i=o("f855"),e=o.n(i);for(var u in i)"default"!==u&&function(t){o.d(n,t,(function(){return i[t]}))}(u);n["default"]=e.a},9221:function(t,n,o){},ce7a:function(t,n,o){"use strict";var i;o.d(n,"b",(function(){return e})),o.d(n,"c",(function(){return u})),o.d(n,"a",(function(){return i}));var e=function(){var t=this,n=t.$createElement,o=(t._self._c,t.bottom_info&&t.bottom_info.logo?t.$util.img(t.bottom_info.logo):null),i=t.bottom_info?null:t.$util.img("upload/uniapp/logo_copy.png");t.$mp.data=Object.assign({},{$root:{g0:o,g1:i}})},u=[]},f855:function(t,n,o){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var i={data:function(){return{bottom_info:{}}},created:function(){this.getAdvList()},methods:{getAdvList:function(){var t=this;this.$api.sendRequest({url:"/api/config/copyright",success:function(n){0==n.code&&n.data&&(t.bottom_info=n.data)},fail:function(){}})},link:function(t){t&&this.$util.redirectTo("/otherpages/web/web?src="+t)}}};n.default=i}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-copyright/ns-copyright-create-component',
    {
        'components/ns-copyright/ns-copyright-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("1dc2"))
        })
    },
    [['components/ns-copyright/ns-copyright-create-component']]
]);
