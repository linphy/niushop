(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-copyright/ns-copyright"],{"36db":function(t,n,o){"use strict";o.r(n);var e=o("392d"),i=o("f5bd");for(var c in i)"default"!==c&&function(t){o.d(n,t,(function(){return i[t]}))}(c);o("64b1");var u,r=o("f0c5"),a=Object(r["a"])(i["default"],e["b"],e["c"],!1,null,null,null,!1,e["a"],u);n["default"]=a.exports},"392d":function(t,n,o){"use strict";var e;o.d(n,"b",(function(){return i})),o.d(n,"c",(function(){return c})),o.d(n,"a",(function(){return e}));var i=function(){var t=this,n=t.$createElement,o=(t._self._c,t.bottom_info&&t.bottom_info.logo?t.$util.img(t.bottom_info.logo):null),e=t.bottom_info?null:t.$util.img("upload/uniapp/logo_copy.png");t.$mp.data=Object.assign({},{$root:{g0:o,g1:e}})},c=[]},"64b1":function(t,n,o){"use strict";var e=o("c5c5"),i=o.n(e);i.a},bb7c:function(t,n,o){"use strict";(function(t){Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var o={data:function(){return{bottom_info:{}}},created:function(){this.getAdvList()},methods:{getAdvList:function(){this.bottom_info=t.getStorageSync("copyright")?JSON.parse(t.getStorageSync("copyright")):{}},link:function(t){t&&this.$util.redirectTo("/otherpages/webview/webview",{link:encodeURIComponent(t)})}}};n.default=o}).call(this,o("543d")["default"])},c5c5:function(t,n,o){},f5bd:function(t,n,o){"use strict";o.r(n);var e=o("bb7c"),i=o.n(e);for(var c in e)"default"!==c&&function(t){o.d(n,t,(function(){return e[t]}))}(c);n["default"]=i.a}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-copyright/ns-copyright-create-component',
    {
        'components/ns-copyright/ns-copyright-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("36db"))
        })
    },
    [['components/ns-copyright/ns-copyright-create-component']]
]);
