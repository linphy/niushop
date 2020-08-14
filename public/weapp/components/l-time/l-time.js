(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/l-time/l-time"],{"79c1":function(t,e,n){"use strict";n.r(e);var u=n("d381"),a=n.n(u);for(var i in u)"default"!==i&&function(t){n.d(e,t,(function(){return u[t]}))}(i);e["default"]=a.a},9657:function(t,e,n){"use strict";n.r(e);var u=n("cc72"),a=n("79c1");for(var i in a)"default"!==i&&function(t){n.d(e,t,(function(){return a[t]}))}(i);var r,c=n("f0c5"),o=Object(c["a"])(a["default"],u["b"],u["c"],!1,null,null,null,!1,u["a"],r);e["default"]=o.exports},cc72:function(t,e,n){"use strict";var u,a=function(){var t=this,e=t.$createElement;t._self._c},i=[];n.d(e,"b",(function(){return a})),n.d(e,"c",(function(){return i})),n.d(e,"a",(function(){return u}))},d381:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var u=a(n("6618"));function a(t){return t&&t.__esModule?t:{default:t}}var i={name:"l-time",props:{text:{type:[String,Number,Date],default:""},maxDate:{type:Boolean,default:!1}},data:function(){return{textVal:this.text}},watch:{text:function(){this.textVal=this.text}},computed:{temp:function(){return this.getText()}},methods:{getText:function(){var t=this,e=u.default.getFormatTime(t.textVal,t.maxDate);return e&&(e.endsWith("刚刚")||e.endsWith("分钟前"))&&setTimeout((function(){var e=t.textVal;t.textVal="",t.textVal=e}),6e4),this.textVal?e:""},onClick:function(){this.$emit("on-tap",this.textVal)}}};e.default=i}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/l-time/l-time-create-component',
    {
        'components/l-time/l-time-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("9657"))
        })
    },
    [['components/l-time/l-time-create-component']]
]);
