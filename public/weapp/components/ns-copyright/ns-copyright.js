(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-copyright/ns-copyright"],{"03e4":function(t,n,o){"use strict";var e=o("cba5"),c=o.n(e);c.a},2411:function(t,n,o){"use strict";o.r(n);var e=o("77b9"),c=o.n(e);for(var r in e)"default"!==r&&function(t){o.d(n,t,(function(){return e[t]}))}(r);n["default"]=c.a},"2b8e":function(t,n,o){"use strict";o.r(n);var e=o("60ba"),c=o("2411");for(var r in c)"default"!==r&&function(t){o.d(n,t,(function(){return c[t]}))}(r);o("03e4");var u,i=o("f0c5"),a=Object(i["a"])(c["default"],e["b"],e["c"],!1,null,null,null,!1,e["a"],u);n["default"]=a.exports},"60ba":function(t,n,o){"use strict";var e;o.d(n,"b",(function(){return c})),o.d(n,"c",(function(){return r})),o.d(n,"a",(function(){return e}));var c=function(){var t=this,n=t.$createElement,o=(t._self._c,t.show&&t.copyright&&t.copyright.logo?t.$util.img(t.copyright.logo):null),e=t.show&&!t.copyright?t.$util.img("public/uniapp/common/logo_copy.png"):null;t.$mp.data=Object.assign({},{$root:{g0:o,g1:e}})},r=[]},"77b9":function(t,n,o){"use strict";(function(t){Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var o={data:function(){return{show:!0}},created:function(){},computed:{copyright:function(){return t.getStorageSync("copyright")}},methods:{link:function(t){t&&this.$util.redirectTo("/pages_tool/webview/webview",{src:encodeURIComponent(t)})},error:function(){this.show=!1}}};n.default=o}).call(this,o("543d")["default"])},cba5:function(t,n,o){}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-copyright/ns-copyright-create-component',
    {
        'components/ns-copyright/ns-copyright-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("2b8e"))
        })
    },
    [['components/ns-copyright/ns-copyright-create-component']]
]);
