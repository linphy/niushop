(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-copyright/ns-copyright"],{5462:function(t,n,o){"use strict";var i,c=function(){var t=this,n=t.$createElement,o=(t._self._c,t.$util.img(t.bottom_info.logo)),i=t.$util.img("upload/uniapp/logo_copy.png");t.$mp.data=Object.assign({},{$root:{g0:o,g1:i}})},e=[];o.d(n,"b",(function(){return c})),o.d(n,"c",(function(){return e})),o.d(n,"a",(function(){return i}))},"6d1d":function(t,n,o){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var i={data:function(){return{bottom_info:{}}},created:function(){this.getAdvList()},methods:{getAdvList:function(){var t=this;this.$api.sendRequest({url:"/api/config/copyright",success:function(n){0==n.code&&n.data&&(t.bottom_info=n.data)},fail:function(){}})},link:function(t){t&&this.$util.redirectTo("/otherpages/web/web?src="+t)}}};n.default=i},b1c7:function(t,n,o){"use strict";o.r(n);var i=o("5462"),c=o("b2cc");for(var e in c)"default"!==e&&function(t){o.d(n,t,(function(){return c[t]}))}(e);o("d653");var u,a=o("f0c5"),r=Object(a["a"])(c["default"],i["b"],i["c"],!1,null,null,null,!1,i["a"],u);n["default"]=r.exports},b2cc:function(t,n,o){"use strict";o.r(n);var i=o("6d1d"),c=o.n(i);for(var e in i)"default"!==e&&function(t){o.d(n,t,(function(){return i[t]}))}(e);n["default"]=c.a},d653:function(t,n,o){"use strict";var i=o("fa53"),c=o.n(i);c.a},fa53:function(t,n,o){}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-copyright/ns-copyright-create-component',
    {
        'components/ns-copyright/ns-copyright-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("b1c7"))
        })
    },
    [['components/ns-copyright/ns-copyright-create-component']]
]);
