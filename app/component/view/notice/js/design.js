/**
 * 公告·组件
 */
var noticeConHtml = '<div style="display:none;"></div>';

Vue.component("notice-sources", {
	template: noticeConHtml,
	data: function () {
		return {
			data: this.$parent.data,
			noticeSources: {
				initial: {
					text: "默认",
					icon: "iconmofang"
				},
				diy: {
					text: "手动选择",
					icon: "iconshoudongxuanze"
				},
			},
			iconList: {
				initial: {
					text: "系统图标",
					type: 'img',
					src: "iconshangpinfenlei",
					icon: [(noticeResourcePath + "/notice/img/notice_01.png"), (noticeResourcePath + "/notice/img/notice_02.png")]
				},
				diy: {
					type: 'icon',
					text: "自定义",
					src: "iconshoudongxuanze",
				}
			},
		}
	},
	created: function () {
		if (!this.$parent.data.verify) this.$parent.data.verify = [];
		this.$parent.data.verify.push(this.verify);//加载验证方法

		// 赋值初始化图片
		if (!this.data.imageUrl) this.data.imageUrl = this.iconList.initial.icon[0];

		this.$parent.data.ignore = ['elementBgColor', 'elementAngle'];//加载忽略内容 -- 其他设置中的属性设置
		this.$parent.data.ignoreLoad = true; // 等待忽略数组赋值后加载

		// 组件所需的临时数据
		this.$parent.data.tempData = {
			noticeSources: this.noticeSources,
			iconList: this.iconList,
			methods: {
				addNotice: this.addNotice,
				iconStyle: this.iconStyle
			}
		};

	},
	mounted() {
		this.fetchIconColor();
	},
	methods: {
		verify: function (index) {
			var res = {code: true, message: ""};
			if (vue.data[index].list.length > 0) {
				for (var i = 0; i < vue.data[index].list.length; i++) {
					if (vue.data[index].list[i].title === "") {
						res.code = false;
						res.message = "公告内容不能为空";
						break;
					}
				}
			} else {
				res.code = false;
				res.message = "请添加一条公告";
			}
			return res;
		},
		addNotice: function () {
			var self = this;
			self.noticeSelect(function (res) {
				self.$parent.data.noticeIds = [];
				self.$parent.data.list = [];

				for (var i = 0; i < res.length; i++) {
					self.$parent.data.noticeIds.push(res[i].id);
					self.$parent.data.list[i] = {
						title: res[i].title,
						link: {}
					};
				}
			}, self.$parent.data.noticeIds);
		},
		/**
		 * 选择图标风格
		 * @param event
		 */
		iconStyle(event) {
			var self = this;
			selectIconStyle({
				elem: event.currentTarget,
				icon: self.data.icon,
				callback: function (data) {
					if (data) {
						self.data.style = data;
					} else {
						iconStyleSet({
							style: JSON.stringify(self.data.style),
							query: {
								icon: self.data.icon
							}
						}, function (style) {
							self.data.style = style;
						})
					}
				}
			})
		},
		/**
		 * 渲染颜色组件
		 * @param id
		 * @param color
		 * @param callback
		 */
		colorRender(id, color, callback) {
			setTimeout(function () {
				Colorpicker.create({
					el: id,
					color: color,
					change: function (elem, hex) {
						callback(elem, hex)
					}
				});
			})
		},
		/**
		 * 渲染图标颜色选择器
		 */
		fetchIconColor() {
			var self = this;
			self.colorRender('notice-color-' + self.data.index, '', function (elem, color) {
				if (self.data.style.iconBgColor.length || self.data.style.iconBgImg) {
					self.data.style.iconBgColor = [color];
				} else {
					self.data.style.iconColor = [color];
				}
				self.$forceUpdate();
			});
		},
		noticeSelect: function (callback, selectId) {
			var self = this;
			layui.use(['layer'], function () {
				var url = ns.url("shop/notice/noticeselect", {select_id: selectId.toString()});
				//iframe层-父子操作
				layer.open({
					title: "公告选择",
					type: 2,
					area: ['1000px', '600px'],
					fixed: false, //不固定
					btn: ['保存', '返回'],
					content: url,
					yes: function (index, layero) {
						var iframeWin = window[layero.find('iframe')[0]['name']];//得到iframe页的窗口对象，执行iframe页的方法：
						iframeWin.selectNotice(function (obj) {
							if (typeof callback == "string") {
								try {
									eval(callback + '(obj)');
									layer.close(index);
								} catch (e) {
									console.error('回调函数' + callback + '未定义');
								}
							} else if (typeof callback == "function") {
								callback(obj);
								layer.close(index);
							}
						});
					}
				});
			});
		},
	}
});