var diyMemberInfoHtml = '<div></div>';

Vue.component("diy-member-info-sources", {
    template: diyMemberInfoHtml,
    data: function () {
        return {
            data: this.$parent.data,
            styleList: [
                {text: '样式一', value: 1},
                {text: '样式二', value: 2},
                {text: '样式三', value: 3}
            ]
        };
    },
    created: function () {
        this.$parent.data.ignore = [];//加载忽略内容 -- 其他设置中的属性设置
        this.$parent.data.ignoreLoad = true; // 等待忽略数组赋值后加载

        // 组件所需的临时数据
        this.$parent.data.tempData = {
            styleList: this.styleList,
            methods: {
                getBgStyle: this.getBgStyle
            },
        };
    },
    methods: {
        verify: function (index) {
            var res = {code: true, message: ""};
            return res;
        },
        getBgStyle() {
            let style = {};
            if (this.data.style == 3) {
                style.background = `radial-gradient(36% 112% at 16% 6%, rgba(255,97,40,0.12) 0%, rgba(255,97,40,0.12) 0%, rgba(226,239,255,0.1) 100%, rgba(226,239,255,.1) 100%)`;
            } else {
                if (this.data.theme == 'default') {
                    style.background = `url('` + ns.img('public/static/img/diy_view/member_info_bg.png') + `') no-repeat bottom / contain, linear-gradient(` + this.data.gradientAngle + `deg, ` + diyMemberInfoSystemColor.main_color + ` 0%, ` + diyMemberInfoSystemColor.main_color + ` 100%)`;
                } else {
                    style.background = `url('` + ns.img('public/static/img/diy_view/member_info_bg.png') + `') no-repeat bottom / contain,linear-gradient(` + this.data.gradientAngle + `deg, ` + this.data.bgColorStart + ` 0%, ` + this.data.bgColorEnd + ` 100%)`;
                }
            }
            return style;
        }
    }
});