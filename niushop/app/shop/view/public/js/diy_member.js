var form,slider,carousel;

layui.use(['form', 'slider', 'carousel'], function() {
    form = layui.form;
    slider = layui.slider;
    carousel = layui.carousel;
})

Vue.prototype.ns = ns;

var vue = new Vue({
    el: "#diyView",
    data: {
        currComponent: 'diy-member-info',
        value: null,
        isRepeat: false
    },
    methods: {
        save(){
            if (this.isRepeat || !this.verify()) return;
            this.isRepeat = true;

            var self = this;

            $.ajax({
                type: 'POST',
                url: ns.url("shop/diy/memberindex"),
                data: {value: JSON.stringify(ns.deepclone(this.value))},
                dataType: 'JSON',
                success: function (res) {
                    layer.msg(res.message);
                    self.isRepeat = false;
                    if (res.code == 0) {
                        // location.reload();
                    }
                }
            });
        },
        selectComponent(name){
            this.currComponent = name;
        },
        /**
         * 验证数据
         * @returns {boolean}
         */
        verify(){
            var verify = true,
                refs = Object.keys(this.$refs);

            for (var i = 0; i < refs.length; i++) {
                var ref = refs[i];
                if (this.$refs[ ref ] && typeof this.$refs[ ref ].verify == 'function') {
                    verify = this.$refs[ ref ].verify();
                    if (!verify) {
                        this.$refs[ ref ].selectComponent();
                        break;
                    }
                }
            }
            return verify;
        }
    },
    computed: {

    }
})
