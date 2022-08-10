//最外层组件
var ncComponentHtml = '<div v-show="data.lazyLoadCss && data.lazyLoad" :key="data.id">';
		ncComponentHtml += '<div class="preview-draggable" ' +
			':style="{ ' +
			'backgroundColor : data.pageBgColor, ' +
			'paddingTop : data.margin.top + \'px\', ' +
			'paddingBottom : data.margin.bottom + \'px\', ' +
			'paddingLeft : data.margin.both + \'px\', ' +
			'paddingRight : data.margin.both + \'px\'  }" @click="$parent.changeCurrentIndex(data.index)">'; // 拖拽区域
			ncComponentHtml += '<slot name="preview"></slot>';
			ncComponentHtml += '<i class="del" v-show="data.isDelete !== 1" @click.stop="$parent.delComponent(data.index)" data-disabled="1">x</i>';
		ncComponentHtml += '</div>';
		// ($slots.edit ? '1' : '0')
		ncComponentHtml += '<div class="edit-attribute" :data-have-edit="1" v-show="$parent.currentIndex == data.index">'; //  && $slots.edit
			ncComponentHtml += '<div class="attr-wrap">';
				ncComponentHtml += '<div class="restore-wrap">';

					ncComponentHtml += '<div class="attr-title">';
						ncComponentHtml += '<span class="title">{{data.componentTitle}}</span>';
						ncComponentHtml += '<div class="tab-wrap">';
							ncComponentHtml += '<span class="active bg-color" data-type="content">内容</span>';
							ncComponentHtml += '<span data-type="style">样式</span>';
						ncComponentHtml += '</div>';
					ncComponentHtml += '</div>';

					// 内容
					ncComponentHtml += '<div class="edit-content-wrap">';
						ncComponentHtml += '<slot name="edit-content"></slot>';
					ncComponentHtml += '</div>';

					// 样式
					ncComponentHtml += '<div class="edit-style-wrap">';
						ncComponentHtml += '<slot name="edit-style"></slot>';
						ncComponentHtml += '<common-set v-if="data.ignoreLoad" :ignore="data.ignore"></common-set>';
					ncComponentHtml += '</div>';
				ncComponentHtml += '</div>';

			ncComponentHtml += '</div>';
		ncComponentHtml += '</div>';

		ncComponentHtml += '<div style="display:none;">';
			ncComponentHtml += '<slot name="resource"></slot>';
		ncComponentHtml += '</div>';

	ncComponentHtml += '</div>';

var ncComponent = {
	props: ["data"],
	template: ncComponentHtml,
	created: function () {
		//如果当前添加的组件没有添加过资源
		if (!this.$slots.resource) {
			this.data.lazyLoadCss = true;
			this.data.lazyLoad = true;
		} else {
			//检测是否只添加了JS或者CSS，没有添加默认为true
			var countCss = 0, countJs = 0, outerCountJs = 0;
			for (var i = 0; i < this.$slots.resource.length; i++) {
				if (this.$slots.resource[i].componentOptions) {
					if (this.$slots.resource[i].componentOptions.tag === "css") {
						countCss++;
					} else if (this.$slots.resource[i].componentOptions.tag === "js") {
						countJs++;
						//统计外部JS数量
						if (!$.isEmptyObject(this.$slots.resource[i].componentOptions.propsData)) outerCountJs++;
					}
				}
			}

			if (countCss === 0) this.data.lazyLoadCss = true;
			if (countJs === 0) this.data.lazyLoad = true;

			this.data.outerCountJs = outerCountJs;

		}
	}
};

/**
 * 手机端自定义模板Vue对象
 */
var vue = new Vue({
	el: "#diyView",
	data: {
		//当前编辑的组件位置
		currentIndex: -99,
		changeIndex: -1,
		isAdd: false,
		globalLazyLoad: false,

		//全局属性
		global: {
			title: "页面" + $('#name').val().replace('DIY_VIEW_RANDOM_', ''),
			pageBgColor: "#ffffff", // 页面背景颜色
			topNavColor: "#ffffff",
			topNavBg: false,
			textNavColor: "#333333",
			topNavImg: "",
			moreLink: {
				name: ""
			},
			//是否显示底部导航标识
			openBottomNav: true,
			navStyle: 1,
			textImgPosLink: 'center',
			mpCollect: false,
			// 弹框形式，不弹出 -1，首次弹出 1，每次弹出 0
			popWindow: {
				imageUrl: "",
				count: -1,
				show: 0,
				link: {
					name: ""
				},
				imgWidth: '',
				imgHeight: ''
			},
			bgUrl: "",

			// 公共模板属性，所有组件都继承，不需要重复定义，组件内部根据业务自行调用
			template: {
				pageBgColor: '', // 底部背景颜色
				textColor: "#303133", // 文字颜色

				componentBgColor: '', // 组件背景颜色
				componentAngle: 'round', // 组件角标（round：圆角，right：直角）
				topAroundRadius: 0, // 组件上圆角，命名缩减
				bottomAroundRadius: 0, // 组件下圆角，命名缩减

				elementBgColor: '', // 元素背景颜色
				elementAngle: 'round', // 元素角标（round：圆角，right：直角）
				topElementAroundRadius: 0, // 元素上圆角，命名缩减
				bottomElementAroundRadius: 0, // 元素下圆角，命名缩减

				margin: {
					top: 0, // 上边距
					bottom: 0, // 下边距
					both: 0, // 左右边距
				}
			}
		},
		//自定义组件集合
		data: [],
	},
	components: {
		'nc-component': ncComponent,//最外层组件
	},
	created: function () {
		if ($("#info").length) {
			setTimeout(function () {
				$('#diyView').css('visibility', 'visible');
			}, 50);
		} else {
			$('#diyView').css('visibility', 'visible');
			$('.loading-layer').hide();
			$('.preview-wrap .preview-restore-wrap').css('visibility', 'visible');
		}
	},
	mounted: function () {
		this.refresh();
	},
	methods: {
		addComponent: function (obj, other) {
			//附加公共字段
			obj.index = 0;
			obj.sort = 0;
			obj.lazyLoadCss = false; // 资源懒加载，防止看到界面缓慢加载
			obj.lazyLoad = false; // 资源懒加载，防止看到界面缓慢加载
			obj.outerCountJs = 0;
			obj.ignore = []; // 忽略模板属性
			// obj.hidden = []; // 隐藏公共属性
			obj.tempData = {}; // 临时数据
			obj.id = ns.gen_non_duplicate(5);

			//第一次添加组件时，添加以下字段
			if (other) {
				obj.componentName = other.name;
				obj.componentTitle = other.title;
				obj.isDelete = parseInt(other.is_delete);

				for (var key in this.global.template) {
					obj[key] = typeof this.global.template[key] == 'object' ? JSON.parse(JSON.stringify(this.global.template[key])) : this.global.template[key];
				}
				if (!this.checkComponentIsAdd(obj.componentName)) {
					this.autoSelected(obj.componentName);
					return;
				}
			}

			this.data.push(obj);

			// 添加组件后（不是编辑调用的），选择最后一个
			if (other) this.currentIndex = this.data.length - 1;
			this.isAdd = true;

			this.refresh();

			$(".edit-attribute-placeholder").show();

			var self = this;

			setTimeout(function () {
				if (obj.componentName !== "FloatBtn" && (self.changeIndex === -1 || (self.changeIndex !== self.currentIndex))) {
					$(".preview-wrap .preview-restore-wrap .div-wrap").scrollTop($(".diy-view-wrap").height());
				}
				var div = $(".draggable-element[data-index=" + self.currentIndex + "] .edit-attribute .attr-wrap");
				if (div.find('.edit-content-wrap').children().length === 0 || div.find('.edit-style-wrap').children().length === 0) {
					div.find('.tab-wrap').css('display', 'none');
				} else {
					div.find('.tab-wrap').css('display', 'flex');
				}
				$(".edit-attribute-placeholder").hide();
				// console.log('div',div,div.find('.edit-content-wrap').children(),div.find('.edit-content-wrap').children().length ,div.find('.edit-style-wrap').children().length)
				if (div.find('.edit-content-wrap').children().length !== 0 || div.find('.edit-style-wrap').children().length !== 0) {

					// 默认选中内容
					$(".draggable-element[data-index='" + self.currentIndex + "'] .edit-attribute .attr-wrap .restore-wrap .attr-title .tab-wrap span:eq(0)").click();
				}
			}, 160);
		},

		//检测组件是否允许添加，true：允许 false：不允许
		checkComponentIsAdd: function (componentName) {

			var component = $('.component-list ul li[data-name="' + componentName + '"]');
			var maxCount = parseInt(component.attr('data-max-count'));

			//maxCount为0时不处理
			if (maxCount === 0) return true;

			var count = 0;

			//遍历已添加的自定义组件，检测是否超出数量
			for (var i in this.data) if (this.data[i].componentName === componentName) count++;

			if (count >= maxCount) return false;
			else return true;
		},

		// 获取组件添加数量
		getComponentAddCount: function (componentName) {
			var count = 0;
			//遍历已添加的自定义组件，检测是否超出数量
			for (var i in this.data) if (this.data[i].componentName === componentName) count++;
			return count;
		},

		//改变当前编辑的组件选中
		changeCurrentIndex: function (sort) {
			this.currentIndex = parseInt(sort);
			this.changeIndex = this.currentIndex;
			this.isAdd = false;
			// 默认选中内容
			var self = this;
			setTimeout(function () {
				$(".draggable-element[data-index='" + self.currentIndex + "'] .edit-attribute .attr-wrap .restore-wrap .attr-title .tab-wrap span:eq(0)").click();
			}, 50);
			this.refresh();
		},

		//改变当前的删除弹出框的显示状态
		delComponent: function (i) {
			if (i < -1) return; // 从0开始
			var self = this;

			layer.confirm('确定要删除吗?', {title: '操作提示'}, function (index) {

				self.data.splice(i, 1);
				//删除当前组件后，选中最后一个组件进行编辑
				if (self.data[self.data.length - 1]) {
					self.currentIndex = $(".draggable-element:last").attr("data-index");
					//删除组件后，进行重新排序
					self.refresh();
				} else {
					self.currentIndex = -99;
				}
				layer.close(index);

			});
		},

		// 重置当前组件数据
		resetComponent: function () {
			var self = this;
			if (this.currentIndex < 0) return; // 从0开始
			// if (self.data.length < 1) return; // 重置全部用

			layer.confirm('确认要重置组件默认数据吗?', {title: '操作提示'}, function (index) {

				// 重置当前选中的组件数据
				var current = $(".draggable-element[data-index=" + self.currentIndex + "]");
				var id = current.attr('data-id');
				var info = JSON.parse($("#info").val().toString());
				if (Object.keys(info).length) {
					var temp = {};
					for (var i = 0; i < info.value.length; i++) {
						if (info.value[i].id === id) {
							info.value[i].index = self.currentIndex;
							info.value[i].sort = 0;
							info.value[i].lazyLoadCss = false; // 资源懒加载，防止看到界面缓慢加载
							info.value[i].lazyLoad = false; // 资源懒加载，防止看到界面缓慢加载
							info.value[i].outerCountJs = 0;
							info.value[i].ignore = []; // 忽略模板属性
							info.value[i].tempData = {}; // 临时数据
							info.value[i].id = ns.gen_non_duplicate(5);
							temp = info.value[i];
							break;
						}
					}

					// 如果是新添加的组件，要重置数据
					if (Object.keys(temp).length === 0) {
						var component = $('.component-list ul li[data-name="' + self.data[self.currentIndex].componentName + '"]');
						var value = JSON.parse(component.attr('data-value'));
						let index = self.currentIndex;
						self.data.splice(index, 1);
						self.addComponent(value, {
							name: component.attr('data-name'),
							title: component.attr('title'),
							max_count: component.attr('data-max-count'),
							is_delete: component.attr('data-is-delete')
						});

					} else {
						self.data.splice(self.currentIndex, 1, temp);
					}

					// console.log('self.currentIndex', self.currentIndex, temp)

					setTimeout(function () {
						fullScreenSize();
						self.refreshQuick(true);
					}, 10)
				}

				// 以下是重置全部数据，需要时放开，勿删！
				// self.data = [];
				// self.currentIndex = -99;
				// setTimeout(function () {
				// 	self.refreshComponent();
				// }, 10 * 2);

				layer.close(index);
			});
		},

		// 上移组件
		moveUpComponent: function () {
			if ((this.currentIndex - 1) < 0) return; // 从0开始

			var element = $(".draggable-element[data-index=" + this.currentIndex + "]");
			var prev = element.prev('.draggable-element'); // 上一个组件

			if(prev.length === 0) return;

			var prevIndex = parseInt(prev.attr('data-index'));

			var temp = this.deepClone(this.data[this.currentIndex]); // 当前选中组件
			var temp2 = this.deepClone(this.data[prevIndex]); // 上个组件

			this.data[this.currentIndex] = temp2;
			this.data[prevIndex] = temp;

			this.changeCurrentIndex(prevIndex);

			this.refreshQuick();
		},

		// 下移组件
		moveDownComponent: function () {
			// if (this.data.length === 0 || (this.currentIndex + 1) === this.data.length) return; // 最后一个不能下移

			var element = $(".draggable-element[data-index=" + this.currentIndex + "]");
			var next = element.next('.draggable-element'); // 上一个组件

			if(next.length === 0) return;

			var nextIndex = parseInt(next.attr('data-index'));

			var temp = this.deepClone(this.data[this.currentIndex]); // 当前选中组件
			var temp2 = this.deepClone(this.data[nextIndex]); // 下个组件

			this.data[this.currentIndex] = temp2;
			this.data[nextIndex] = temp;

			this.changeCurrentIndex(nextIndex);

			this.refreshQuick();
		},

		// 复制组件
		copyComponent: function () {
			if (this.currentIndex < 0) return; // 从0开始

			var temp = this.deepClone(this.data[this.currentIndex]); // 当前选中组件
			temp.index++;
			temp.id = ns.gen_non_duplicate(5);
			var component = $('.component-list ul li[data-name="' + temp.componentName + '"]');
			var maxCount = parseInt(component.attr('data-max-count'));

			if (!this.checkComponentIsAdd(temp.componentName)) {
				layer.msg(`无法复制，${temp.componentTitle}组件只能添加${maxCount}个`);
				return;
			}

			var index = this.currentIndex;
			this.data.splice(index, 0, temp);

			this.changeCurrentIndex(index + 1);

			this.refreshQuick(true);

			var self = this;

			setTimeout(function () {
				var curr = $(".draggable-element[data-index=" + index + "]");
				var last = $(".draggable-element[data-index=" + (self.data.length - 1) + "]");
				// 调试代码，勿删
				// window.curr = curr;
				// window.last = last;
				// console.log("curr",curr);
				// console.log("last",last);
				curr.after(last);
			}, 10);

		},

		// 深度拷贝对象
		deepClone(source) {
			if (typeof source !== 'object' || source == null) {
				return source;
			}
			const target = Array.isArray(source) ? [] : {};
			for (const key in source) {
				if (Object.prototype.hasOwnProperty.call(source, key)) {
					if (typeof source[key] === 'object' && source[key] !== null) {
						target[key] = this.deepClone(source[key]);
					} else {
						target[key] = source[key];
					}
				}
			}
			return target;
		},

		//刷新数据排序
		refresh: function () {
			var self = this;
			//vue框架执行，异步操作组件列表的排序
			setTimeout(function () {

				$(".draggable-element").each(function (i) {
					$(this).attr("data-sort", i);
				});

				for (var i = 0; i < self.data.length; i++) {
					self.data[i].index = $(".draggable-element[data-index=" + i + "]").attr("data-index");
					self.data[i].sort = $(".draggable-element[data-index=" + i + "]").attr("data-sort");
				}

				// 触发变异方法，进行视图更新。不能用sort()方法，会改变组件的顺序，导致显示的顺序错乱
				// self.data.push({});
				// self.data.pop();
				// console.log(self.currentIndex);

				// 如果当前编辑的组件不存在了，则选中最后一个
				if (parseInt(self.currentIndex) >= self.data.length) self.currentIndex--;

				$(".draggable-element[data-index=" + self.currentIndex + "] .edit-attribute .attr-wrap").css("height", ($(window).height() - 163) + "px");

				if (self.isAdd && self.changeIndex > -1 && (self.changeIndex !== self.currentIndex) && self.changeIndex < (self.data.length - 1)) {
					var curr = $(".draggable-element[data-index=" + self.changeIndex + "]");
					var last = $(".draggable-element[data-index=" + (self.data.length - 1) + "]");
					// 调试代码，勿删
					// window.curr = curr;
					// window.last = last;
					// console.log("curr",curr);
					// console.log("last",last);
					curr.after(last);
					// console.log('self.currentIndex',self.currentIndex)
					self.changeIndex = self.currentIndex;

					// 定位到当前位置
					// setTimeout(function () {
					// console.log("定位到当前位置",parseFloat((curr.position().top + last.outerHeight())));
					// $(".preview-wrap .preview-restore-wrap .div-wrap").scrollTop(curr.position().top + last.outerHeight());
					// $(".preview-wrap .preview-restore-wrap .div-wrap").scrollTop($(".diy-view-wrap").height());
					// },1600);
					// console.log("self.changeIndex",self.changeIndex);
					// console.log("self.currentIndex",self.currentIndex);
				}

				// 显示插件添加的数量，防止一进入看到代码
				// $(".js-component-add-count").show();

			}, 50);

		},

		//转换图片路径
		changeImgUrl: function (url) {
			if (url == null || url === "") return '';
			if (url.indexOf("static/img/") > -1) return ns.img(ns_url.staticImg + "/" + url.replace("public/static/img/", ""));
			else return ns.img(url);
		},

		//设置全局对象属性
		setGlobal: function (obj) {
			for (var k in obj) {
				if (k) this.$set(this.global, k, obj[k]);
			}
			this.globalLazyLoad = true;
		},

		verify: function () {

			if (this.global.title === "") {
				layer.msg('请输入页面名称');
				this.currentIndex = -99;
				this.refresh();
				return false;
			} else if (this.global.title.length > 50) {
				layer.msg('页面名称最多50个字符');
				this.currentIndex = -99;
				this.refresh();
				return false;
			}

			if (this.global.popWindow.count !== -1 && this.global.popWindow.imageUrl === '') {
				layer.msg('请上传弹框广告');
				this.currentIndex = -99;
				this.refresh();
				return false;
			}

			for (var i = 0; i < this.data.length; i++) {

				try {
					if (this.data[i].verify) {
						for (var j = 0; j < this.data[i].verify.length; j++) {
							var res = this.data[i].verify[j](i);
							if (!res.code) {
								this.currentIndex = i;
								this.refresh();
								layer.msg(res.message);
								return false;
							}
						}
					}
				} catch (e) {
					console.log("verify Error:", e, i, this.data[i]);
				}
			}
			return true;
		},

		// 定位组件位置
		autoSelected(componentName) {
			for (var i in this.data) {
				if (this.data[i].componentName === componentName) {
					this.changeCurrentIndex(this.data[i].index);
					var element = $('.preview-wrap .preview-restore-wrap [data-index="' + this.data[i].index + '"]'),
						warp = $(".preview-wrap .preview-restore-wrap .div-wrap"),
						warpTop = warp.offset().top,
						warpBottom = warpTop + warp.height(),
						elementTop = element.offset().top,
						elementBottom = elementTop + element.height(),
						scrollTop = warp.scrollTop();

					if (elementBottom > warpBottom) {
						scrollTop += (elementBottom - warpBottom) + 2;
					} else if (warpTop > elementTop) {
						scrollTop -= (warpTop - elementTop);
					}
					warp.animate({scrollTop: scrollTop}, 300);
					return;
				}
			}
		},

		// 刷新组件数据
		refreshComponent: function () {
			if ($("#info").length === 0) return;

			var info = JSON.parse($("#info").val().toString());// .replace(/\@/g, "'"));
			if (Object.keys(info).length) {
				for (var i = 0; i < info.value.length; i++) {
					info.value[i].index = 0;
					info.value[i].sort = 0;
					info.value[i].lazyLoadCss = false; // 资源懒加载，防止看到界面缓慢加载
					info.value[i].lazyLoad = false; // 资源懒加载，防止看到界面缓慢加载
					info.value[i].outerCountJs = 0;
					info.value[i].ignore = []; // 忽略模板属性
					info.value[i].tempData = {}; // 临时数据
					// info.value[i].id = ns.gen_non_duplicate(5);
				}
			}

			this.setGlobal(info.global);

			this.data = info.value;
			this.isAdd = true;

			this.refresh();

			$(".edit-attribute-placeholder").show();

			var self = this;

			setTimeout(function () {
				var div = $(".draggable-element .edit-attribute .attr-wrap");
				div.each(function () {
					if ($(this).find('.edit-content-wrap').children().length === 0 || $(this).find('.edit-style-wrap').children().length === 0) {
						$(this).find('.tab-wrap').css('display', 'none');
					} else {
						$(this).find('.tab-wrap').css('display', 'flex');
					}
				});

				$('.loading-layer').hide();
				$(".edit-attribute-placeholder").hide();
				$('.preview-wrap .preview-restore-wrap').css('visibility', 'visible');

				self.changeCurrentIndex(0); // 选择第一个

				fullScreenSize();
			}, 10 * 5 * self.data.length);
		},

		/**
		 * 刷新快捷操作后的展示
		 * @param isScroll false：滚动，true：不滚动
		 */
		refreshQuick: function (isScroll) {
			var self = this;
			$(".edit-attribute-placeholder").show();
			vue.$nextTick(function () {
				self.data.push({});
				self.data.pop();
				setTimeout(function () {
					var div = $(".draggable-element[data-index=" + self.currentIndex + "] .edit-attribute .attr-wrap");
					if (div.find('.edit-content-wrap').children().length === 0 || div.find('.edit-style-wrap').children().length === 0) {
						div.find('.tab-wrap').css('display', 'none');
					} else {
						div.find('.tab-wrap').css('display', 'flex');
					}
					if (!isScroll) {
						var element = $(".draggable-element[data-index=" + self.currentIndex + "]");
						var warp = $(".preview-wrap .preview-restore-wrap .div-wrap");
						var height = 0;
						$(".draggable-element:lt(" + (element.index() + 1) + ")").each(function (i) {
							height += $(this).outerHeight();
						});
						height -= element.outerHeight() + 30;
						warp.animate({scrollTop: height}, 300);
					}
					$(".edit-attribute-placeholder").hide();

				}, 50);
			});
		}

	}
});

// 自适应全屏宽高
function fullScreenSize(isFull) {
	var size = 0;
	if (baseStyle === 'app/shop/view/base/style1.html') size = 215; // 公式：头部layui-header（61px）+ 面包屑crumbs（44px） + 自定义模板区域上内边距diyview（20px） + 底部保存按钮（90px）
	else size = 165; // 公式：二级面包屑layui-header-crumbs-second （55px）+ 自定义模板区域上内边距diyview（20px） + 底部保存按钮（90px）

	if (isFull) size = 75; // 顶部面包屑（55px） + 自定义模板区域上内边距diyview（20px）
	var commonHeight = $(window).height() - size;
	['.preview-wrap .preview-restore-wrap .div-wrap', '.edit-attribute-placeholder'].forEach(function (obj) {
		$(obj).css("height", (commonHeight) + "px");
	});
	$('.loading-layer').css('height', (commonHeight - 70) + "px"); // 70px是头部高度
	$(".component-list nav").css("height", (commonHeight + 20) + "px");// 20px是自定义模板区域上内边距
	$(".edit-attribute .attr-wrap").css("height", (commonHeight - 1) + "px");// 1px是上边框
	$(".preview-block").css("min-height", (commonHeight - 104) + "px"); // 公式：高度 - 自定义模板区域上内边距（20px） - 自定义模板区域下外编辑（20px）- 自定义模板头部（64px）
}

var form, repeat_flag = false;//防重复标识
layui.use(['form'], function () {
	form = layui.form;
	form.render();

	fullScreenSize();

	if ($("#info").val()) {
		vue.refreshComponent();
	} else {
		vue.globalLazyLoad = true;
	}

	// 组件列表
	$("body").on("click", ".component-list h3", function () {
		var index = $(this).attr("data-index");
		var ul = $(".component-list ul[data-index='" + index + "']");
		if (ul.height()) {
			$(this).find("img").attr("src", ns_url.staticExt + "/diyview/img/component_right.png");
			if (!ul.attr("data-height")) ul.attr("data-height", ul.height());
			ul.animate({opacity: 0, height: 0}, 100);
		} else {
			$(this).find("img").attr("src", ns_url.staticExt + "/diyview/img/component_down.png");
			ul.animate({opacity: 1, height: ul.attr("data-height") + "px"}, 100);
		}
	});

	$("body").on("click", ".edit-attribute .attr-wrap .restore-wrap .attr-title .tab-wrap span", function () {
		$(this).addClass('active bg-color').siblings().removeClass('active bg-color');
		var type = $(this).attr('data-type');
		$(this).parent().parent().parent().find('.edit-content-wrap').hide();
		$(this).parent().parent().parent().find('.edit-style-wrap').hide();
		$(this).parent().parent().parent().find(`.edit-${type}-wrap`).show();
	});

	// 处理全屏切换事件
	// 事件开始，通过添加顶级样式控制按钮相关展示

	// 底部全屏按钮，隐藏菜单，添加顶级样式，top-full-screen
	$('body').on('click', '.full-screen-btn', function () {
		$('body').find('.layui-header').hide(); //顶部菜单
		$('body').find('.layui-side').hide(); //侧边菜单
		$('body').find('.layui-layout-admin .crumbs').hide(); //面包屑

		$('body').addClass('top-full-screen'); //添加顶级样式，处理大板块结构

		// 隐藏底部按钮，放开头部按钮
		$('body').find('.js-bottom-custom-save').hide(); //底部按钮隐藏
		$('body').find('.js-top-custom-save').removeClass('layui-hide'); //顶部按钮放开

		$('body').find('.main-contact').hide(); //全屏右侧帮助不展示

		// 全屏需处理适应大小
		fullScreenSize(true);
	});

	// 顶部恢复按钮，与底部按钮完全相反
	$('body').on('click', '.cancel-btn', function () {
		$('body').find('.layui-header').show(); //顶部菜单
		$('body').find('.layui-side').show(); //侧边菜单
		$('body').find('.layui-layout-admin .crumbs').show(); //面包屑

		$('body').removeClass('top-full-screen'); //添加顶级样式，处理大板块结构

		// 隐藏底部按钮，放开头部按钮
		$('body').find('.js-bottom-custom-save').show(); //底部按钮隐藏
		$('body').find('.js-top-custom-save').addClass('layui-hide'); //顶部按钮放开

		// 全屏需处理适应大小
		fullScreenSize();
	});

	/**
	 * 绑定拖拽事件
	 */
	$('.preview-block').DDSort({

		//拖拽数据源
		target: '.draggable-element',

		//拖拽时显示的样式
		floatStyle: {
			'border': '1px solid',
			'background-color': '#ffffff'
		},

		//设置可拖拽区域
		draggableArea: "preview-draggable",

		//拖拽中，隐藏右侧编辑属性栏
		move: function (index) {
			if ($(".draggable-element[data-index='" + index + "'] .edit-attribute").attr("data-have-edit") == 1) $(".draggable-element[data-index='" + index + "'] .edit-attribute").hide();
		},

		//拖拽结束后，选择当前拖拽，并且显示右侧编辑属性栏，刷新数据
		up: function (index) {
			if ($(".draggable-element[data-index='" + index + "'] .edit-attribute").attr("data-have-edit") == 1) {
				vue.currentIndex = index;
				$(".draggable-element[data-index='" + index + "'] .edit-attribute").show();
			}
		}
	});

	// 保存
	$("button.save").click(function () {

		// 刷新排序
		vue.refresh();
		setTimeout(function () {

			if (vue.verify()) {

				//全局属性
				var global = JSON.stringify(vue.global);

				global = eval("(" + global + ")");

				//组件属性
				var value = JSON.stringify(vue.data); // .replace(/\@/g, "");

				value = JSON.parse(value);

				//重新排序
				value.sort(function (a, b) {
					return a.sort - b.sort;
				});

				for (var k in value) {
					value[k].ignore.forEach((item, index) => {
						if (item.indexOf('margin') !== -1) delete value[k].margin[item.split('margin')[1].toLowerCase()];
						else delete value[k][item];
					});
					delete value[k].ignore;
					// delete value[k].hidden;
					delete value[k].ignoreLoad;
					delete value[k].verify;
					delete value[k].lazyLoad;
					delete value[k].lazyLoadCss;
					delete value[k].index;
					delete value[k].sort;
					delete value[k].outerCountJs;
					delete value[k].tempData; // 临时数据
				}

				var v = {
					global: global,
					value: value
				};

				// console.log(v);
				// console.log(JSON.stringify(v));
				// return false;

				if (repeat_flag) return;
				repeat_flag = true;

				$.ajax({
					type: "post",
					url: ns.url(requestUrl),
					data: {
						id: $("#id").val(),
						name: $("#name").val(),
						title: vue.global.title,
						value: JSON.stringify(v), // .replace(/\'/g, "@")
						site_id: ns_url.siteId,
						app_module: ns_url.appModule,
						template_key: $("#template_key").val() // 来源：模板标识
					},
					dataType: "JSON",
					success: function (res) {
						layer.msg(res.message);
						if (res.code == 0) {

							if ($("#template_key").val()) {
								location.href = ns.url("shop/diy/index");
							} else if ($("#id").val() || $("#name").val().indexOf('DIY_VIEW_RANDOM_') == -1) {
								// location.reload(); // 不刷新
								repeat_flag = false;
							} else {
								location.href = ns.url("shop/diy/lists");
								// location.href = ns.url(returnList);
							}
						} else {
							repeat_flag = false;
						}
					}
				});
			}
		}, 100);
	});

});

// 预览
function preview() {
	let url = $('input[name="preview_url"]').val();
	if (url.indexOf('?') != -1) url += '&preview=1&time=' + parseInt((new Date().getTime()/1000).toString());
	else url += '?preview=1&time=' + parseInt((new Date().getTime()/1000).toString());
	var layerIndex = layer.open({
		title: '访问页面',
		skin: 'layer-tips-class',
		type: 1,
		area: ['600px', '700px'],
		content: $("#diy_h5_preview").html(),
		success: function () {
			$("#iframe").attr('src', url).show();
			$(".goods-preview .phone-wrap .iframe-wrap .empty").hide();
		}
	});
}