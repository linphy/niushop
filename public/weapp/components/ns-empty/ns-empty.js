(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/ns-empty/ns-empty"],{"04f3":function(t,e,n){"use strict";var u=n("8842"),r=n.n(u);r.a},"0c1b":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var u={data:function(){return{}},props:{text:{type:String,default:"暂无相关数据"},isIndex:{type:Boolean,default:!0},emptyBtn:{type:Object,default:function(){return{text:"去逛逛"}}},fixed:{type:Boolean,default:!0}},methods:{goIndex:function(){this.emptyBtn.url?this.$util.redirectTo(this.emptyBtn.url,{},"redirectTo"):this.$util.redirectTo("/pages/index/index",{},"redirectTo")},re:function(t){this.text=t}}};e.default=u},"22e7":function(t,e,n){"use strict";n.r(e);var u=n("0c1b"),r=n.n(u);for(var i in u)"default"!==i&&function(t){n.d(e,t,(function(){return u[t]}))}(i);e["default"]=r.a},"2c4c":function(t,e,n){"use strict";n.r(e);var u=n("977e"),r=n("22e7");for(var i in r)"default"!==i&&function(t){n.d(e,t,(function(){return r[t]}))}(i);n("04f3");var o,c=n("f0c5"),a=Object(c["a"])(r["default"],u["b"],u["c"],!1,null,null,null,!1,u["a"],o);e["default"]=a.exports},8842:function(t,e,n){},"977e":function(t,e,n){"use strict";var u;n.d(e,"b",(function(){return r})),n.d(e,"c",(function(){return i})),n.d(e,"a",(function(){return u}));var r=function(){var t=this,e=t.$createElement,n=(t._self._c,t.$util.img("public/uniapp/common/common-empty.png"));t.$mp.data=Object.assign({},{$root:{g0:n}})},i=[]}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/ns-empty/ns-empty-create-component',
    {
        'components/ns-empty/ns-empty-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("2c4c"))
        })
    },
    [['components/ns-empty/ns-empty-create-component']]
]);
