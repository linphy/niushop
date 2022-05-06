var floatBtnListHtml = '<div class="float-btn-list">';
floatBtnListHtml += '<ul>';
floatBtnListHtml += '<li v-for="(item,index) in list" v-bind:key="index">';
floatBtnListHtml += '<div class="video-in-box">';
	floatBtnListHtml += '<span class="video-title">视频上传</span>';
	floatBtnListHtml += '<video-upload v-bind:data="{data : item}" :currIndex = "index"></video-upload>';
floatBtnListHtml += '</div>';
floatBtnListHtml += '<div class="video-in-box">';
	floatBtnListHtml += '<span class="video-title">视频封面</span>';
	floatBtnListHtml += '<img-upload v-bind:data="{data : item}" :currIndex = "index"></img-upload>';
floatBtnListHtml += '</div>';
// floatBtnListHtml += '<div class="layui-form-item goods-show-box ns-checkbox-wrap">';
// floatBtnListHtml +=		'<div class="layui-input-block">';
// 	floatBtnListHtml +=		'<div class="layui-input-inline-checkbox">';
// 	floatBtnListHtml +=			'<span>自动播放</span>';
// 	floatBtnListHtml +=			'<div v-on:click="changeStatus(\'is_play\')" class="layui-unselect layui-form-checkbox"  v-bind:class="{\'layui-form-checked\': (item.is_play == 1)}" lay-skin="primary"><i class="layui-icon layui-icon-ok"></i></div>';
// 	floatBtnListHtml +=		'</div>';
// 	floatBtnListHtml +=		'<div class="layui-input-inline-checkbox">';
// 	floatBtnListHtml +=			'<span>静音播放</span>';
// 	floatBtnListHtml +=			'<div v-on:click="changeStatus(\'is_mute\')" class="layui-unselect layui-form-checkbox" v-bind:class="{\'layui-form-checked\': (item.is_mute == 1)}" lay-skin="primary"><i class="layui-icon layui-icon-ok"></i></div>';
// 	floatBtnListHtml +=		'</div>';
// floatBtnListHtml +=		'</div>';
// floatBtnListHtml +=	'</div>';
floatBtnListHtml += '<div class="error-msg"></div>';
floatBtnListHtml += '</li>';
floatBtnListHtml += '</ul>';
floatBtnListHtml += '</div>';

Vue.component("video-moba",{
	data: function () {
		return {
			list: this.$parent.data.list,
			maxTip : 3,//最大上传数量提示
			showAddItem : true,
			systemInfo:{
				top:0,
				left:0,
				right:0,
				bottom:0,
				width:0
			},
			screenWidth:0
		};
	},
	created : function(){
		if(!this.$parent.data.verify) this.$parent.data.verify = [];
		//this.$parent.data.verify.push(this.verify);//加载验证方法
	},
	methods: {
		verify :function () {
		},
        changeStatus: function(field) {
			if(this.$parent.data.list[0][field] == 0){
                this.$parent.data.list[0][field] = 1;
			}else{
                this.$parent.data.list[0][field] = 0;
			}
        }
	},
	template: floatBtnListHtml
});
