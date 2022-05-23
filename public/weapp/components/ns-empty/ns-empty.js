(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-empty/ns-empty"],{"22bb":function(t,e,n){"use strict";n.r(e);var u=n("5111"),r=n.n(u);for(var i in u)"default"!==i&&function(t){n.d(e,t,(function(){return u[t]}))}(i);e["default"]=r.a},5111:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var u={data:function(){return{}},props:{text:{type:String,default:"暂无相关数据"},isIndex:{type:Boolean,default:!0},emptyBtn:{type:Object,default:function(){return{text:"去逛逛"}}},fixed:{type:Boolean,default:!0}},methods:{goIndex:function(){this.emptyBtn.url?this.$util.redirectTo(this.emptyBtn.url,{},"redirectTo"):this.$util.redirectTo("/pages/index/index/index",{},"redirectTo")},re:function(t){this.text=t}}};e.default=u},"8e4d":function(t,e,n){},"90af":function(t,e,n){"use strict";n.r(e);var u=n("b5e8"),r=n("22bb");for(var i in r)"default"!==i&&function(t){n.d(e,t,(function(){return r[t]}))}(i);n("cb5f");var o,a=n("f0c5"),c=Object(a["a"])(r["default"],u["b"],u["c"],!1,null,null,null,!1,u["a"],o);e["default"]=c.exports},b5e8:function(t,e,n){"use strict";var u;n.d(e,"b",(function(){return r})),n.d(e,"c",(function(){return i})),n.d(e,"a",(function(){return u}));var r=function(){var t=this,e=t.$createElement,n=(t._self._c,t.$util.img("upload/uniapp/common-empty.png"));t.$mp.data=Object.assign({},{$root:{g0:n}})},i=[]},cb5f:function(t,e,n){"use strict";var u=n("8e4d"),r=n.n(u);r.a}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-empty/ns-empty-create-component',
    {
        'components/ns-empty/ns-empty-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("90af"))
        })
    },
    [['components/ns-empty/ns-empty-create-component']]
]);
