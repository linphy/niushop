(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-empty/ns-empty"],{"0640":function(t,e,n){},"0e06":function(t,e,n){"use strict";n.r(e);var u=n("8c2c"),r=n.n(u);for(var i in u)"default"!==i&&function(t){n.d(e,t,(function(){return u[t]}))}(i);e["default"]=r.a},1928:function(t,e,n){"use strict";n.r(e);var u=n("d2fd"),r=n("0e06");for(var i in r)"default"!==i&&function(t){n.d(e,t,(function(){return r[t]}))}(i);n("ba16");var o,a=n("f0c5"),c=Object(a["a"])(r["default"],u["b"],u["c"],!1,null,null,null,!1,u["a"],o);e["default"]=c.exports},"8c2c":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var u={data:function(){return{}},props:{text:{type:String,default:"暂无相关数据"},isIndex:{type:Boolean,default:!0},emptyBtn:{type:Object,default:function(){return{text:"去逛逛"}}},fixed:{type:Boolean,default:!0}},methods:{goIndex:function(){this.emptyBtn.url?this.$util.redirectTo(this.emptyBtn.url,{},"redirectTo"):this.$util.redirectTo("/pages/index/index/index",{},"redirectTo")}}};e.default=u},ba16:function(t,e,n){"use strict";var u=n("0640"),r=n.n(u);r.a},d2fd:function(t,e,n){"use strict";var u;n.d(e,"b",(function(){return r})),n.d(e,"c",(function(){return i})),n.d(e,"a",(function(){return u}));var r=function(){var t=this,e=t.$createElement,n=(t._self._c,t.$util.img("upload/uniapp/common-empty.png"));t.$mp.data=Object.assign({},{$root:{g0:n}})},i=[]}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-empty/ns-empty-create-component',
    {
        'components/ns-empty/ns-empty-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("1928"))
        })
    },
    [['components/ns-empty/ns-empty-create-component']]
]);
