var layCascader, goodsCategory = [];
layui.use(['layCascader'], function () {
	layCascader = layui.layCascader;

	$('.goods-category-con-wrap .layui-block').each(function () {
		var category_id = $(this).find('.category_id').val();
		var _this = this;

		fetchCategory({elem: $(this).find('.select-category'), value: category_id ? parseInt(category_id.split(',').splice(-1)) : ''},
			function (value, node) {
				var categoryId = [];
				node.path.forEach(function (item) {
					categoryId.push(item.value)
				})
				$(_this).find('.category_id').val(categoryId.toString())
			}
		)
	})
})

$('body').on('click', '.goods-category-con-wrap .js-add-category', function () {
	if ($('.goods-category-con-wrap .layui-block').length >= 10) {
		layer.msg('最多添加十个分类');
		return;
	}
	var h = `<div class="layui-block">
		<div class="layui-input-inline cate-input-defalut">
			<input type="text" readonly lay-verify="required" autocomplete="off" class="layui-input len-mid select-category" />
			<input type="hidden" class="category_id" />
		</div>
		<a href="javascript:;" class="text-color js-delete-category">删除</a>
	</div>`;
	$('.goods-category-con-wrap').append(h);

	fetchCategory({elem: $('.goods-category-con-wrap .layui-block:last-child').find('.select-category')}, function (value, node) {
		var categoryId = [];
		node.path.forEach(function (item) {
			categoryId.push(item.value)
		})
		$('.goods-category-con-wrap .layui-block:last-child').find('.category_id').val(categoryId.toString());
	})
})

$('body').on('click', '.goods-category-con-wrap .js-delete-category', function () {
	$(this).parents('.layui-block').remove();
})

/**
 * 渲染分类选择
 * @param option
 * @param callback
 */
function fetchCategory(option, callback){
	if (!goodsCategory.length) {
		$.ajax({
			url : ns.url("shop/goodscategory/lists"),
			dataType: 'JSON',
			type: 'POST',
			async: false,
			success: function(res) {
				goodsCategory = res.data;
			}
		})
	}
	var _option = {
		options: goodsCategory,
		props: {
			value: 'category_id',
			label: 'category_name',
			children: 'child_list'
		}
	}
	if (option) Object.assign(_option, option);
	var _cascader = layCascader(_option);
	_cascader.changeEvent(function (value, node) {
		typeof callback == 'function' && callback(value, node)
	});
}

// $(function () {
// 	getGoodsCategoryTree(1, 0);
// 	var _index = '';
// });
//
// // 添加商品分类
// function addGoodsCate() {
// 	if ($(".goods-category-con-wrap .layui-block").length < 10) {
// 		var html = `
// 			<div class="layui-block">
// 				<div class="layui-input-inline cate-input-defalut">
// 					<input type="text" readonly lay-verify="required" autocomplete="off" class="layui-input len-mid select-category" />
// 					<input type="hidden" class="category_id" />
// 					<input type="hidden" class="category_id_1" />
// 					<input type="hidden" class="category_id_2" />
// 					<input type="hidden" class="category_id_3" />
// 					<input type="hidden"  id="select_category_id">
// 					<input type="hidden"  name="category_id">
// 				</div>
// 				<a href="#" class="default text-color input-text" onclick="delGoodsCate(this)">删除</a>
// 			</div>
// 		`;
//
// 		$(".goods-category-con-wrap").append(html);
// 	}
// 	refreshAddCategory();
// }
//
// // 删除商品分类
// function delGoodsCate(obj) {
// 	$(obj).parents(".layui-block").remove();
// 	refreshAddCategory();
// }
//
// // 刷新添加商品分类按钮是否显示
// function refreshAddCategory() {
// 	if ($(".goods-category-con-wrap .layui-block").length < 10) {
// 		$(".js-add-category").css('visibility', '');
// 	} else {
// 		$(".js-add-category").css('visibility', 'hidden');
// 	}
// }
//
// //初始化分类
// function getGoodsCategoryTree(level, pid) {
// 	$.ajax({
// 		url: ns.url("shop/goodscategory/getCategoryByParent"),
// 		dataType: 'JSON',
// 		type: 'POST',
// 		data: {
// 			'level': level,
// 			'pid': pid
// 		},
// 		async: false,
// 		success: function(data) {
// 			var category_html = '';
// 			if (data['data']) {
// 				$.each(data.data, function(category_key, category_val) {
// 					//一级分类
// 					category_html += '<li data-value="' + category_val.category_id + '" data-level="' + level + '" pid="' + pid +
// 						'" child="' + (category_val.child_count > 0) + '">';
// 					category_html += '<span>' + category_val.category_name + '</span>';
// 					if (category_val.child_count > 0) {
// 						category_html += '<i class="layui-icon-right layui-icon"></i>';
// 					}
// 					category_html += '</li>';
// 				})
// 			}
// 			$('.goodsCategory_' + level + ' ul').html(category_html);
// 		}
// 	})
// }
//
// $("body").on('click', '.goods-category-wrap-box .goodsCategory ul li', function() {
// 	var level = $(this).attr('data-level');
// 	var value = $(this).attr('data-value');
// 	var isVal = 0;
//
// 	$('.goods-category-wrap-box .goodsCategory_2, .goods-category-wrap-box .goodsCategory_3').addClass('hide');
//
// 	if ($(this).attr('child') == 'true') {
// 		getGoodsCategoryTree(parseInt(level) + 1, value);
// 		$('.goods-category-wrap-box .goodsCategory_' + (parseInt(level) + 1) + ' ul li').addClass('hide');
// 		$('.goods-category-wrap-box .goodsCategory_' + (parseInt(level) + 1) + ' ul li[pid="' + value + '"]').removeClass('hide');
// 		$('.goods-category-wrap-box .goodsCategory_' + level).removeClass('hide');
// 		$('.goods-category-wrap-box .goodsCategory_' + (parseInt(level) + 1)).removeClass('hide');
// 		isVal = 1;
// 	} else {
// 		$('.goods-category-wrap-box .category-wrap, .goods-category-wrap-box .goodsCategory, .goods-category-wrap-box .goods-category-mask').addClass('hide');
// 	}
//
// 	$('.goods-category-wrap-box .goodsCategory_' + level + ' ul li').removeClass('selected');
// 	$('.goods-category-wrap-box .goodsCategory_' + (parseInt(level) + 1) + ' ul li').removeClass('selected');
// 	$('.goods-category-wrap-box .goodsCategory_' + (parseInt(level) + 2) + ' ul li').removeClass('selected');
// 	$(this).addClass('selected');
// 	// categoryBottom();
// 	setSelectGoodsCaregory(isVal);
//
// });
//
//
// //设置选中分类
// function setSelectGoodsCaregory(isVal) {
// 	var level_text_1 = '';
// 	var level_text_2 = '';
// 	var level_text_3 = '';
// 	var select_id = '';
// 	$('.goods-category-wrap-box .goodsCategory ul li.selected').each(function(i, e) {
// 		var level = $(e).attr('data-level');
// 		if (level == 1) {
// 			level_text_1 = $(e).find('span').text();
// 			select_id += $(e).attr('data-value') + ',';
// 		}
// 		if (level == 2) {
// 			level_text_2 = '/' + $(e).find('span').text();
// 			select_id += $(e).attr('data-value') + ',';
// 		}
// 		if (level == 3) {
// 			level_text_3 = '/' + $(e).find('span').text();
// 			select_id += $(e).attr('data-value') + ',';
// 		}
// 	});
//
// 	select_id = select_id.substring(0, select_id.length - 1);
// 	var bool = false;
// 	if ($(".goods-category-wrap-box .layui-block").length > 1) {
// 		$(".goods-category-wrap-box .layui-block").each(function() {
// 			var selectId = $(this).find(".category_id").val();
// 			if (select_id == selectId) {
// 				bool = true;
// 			}
// 		})
// 	}
//
// 	if (bool) {
// 		layer.msg("该分类已被选中");
// 		getGoodsCategoryTree(1, 0);
// 		return;
// 	} else {
// 		if (!isVal) {
// 			$(".goods-category-wrap-box .layui-block").eq(_index).find(".select-category").val(level_text_1 + level_text_2 + level_text_3);
// 			$(".goods-category-wrap-box .layui-block").eq(_index).find('#select_category_id').val(select_id);
// 			var category_arr = select_id.split(',');
// 			$(".goods-category-wrap-box .layui-block").eq(_index).find('.category_id').val(category_arr);
// 			$(".goods-category-wrap-box .layui-block").eq(_index).find('input[name="category_id"]').val(category_arr.pop());
// 		}
// 	}
// }
//
// $("body").on('focus', '.goods-category-wrap-box .select-category', function() {
// 	getGoodsCategoryTree(1, 0);
//
// 	$(".goods-category-wrap-box .category-wrap").css('display', 'flex');
// 	_index = $(this).parents(".layui-block").index();
// 	var _top = $(this).parents(".layui-block").position().top;
// 	var _left = $(this).parents(".layui-block").position().left;
//
// 	$(".goods-category-wrap-box .category-wrap").css({
// 		'top': _top + 44 + 'px'
// 	})
//
// 	var select_id = $(this).parents(".layui-block").find('.category_id').val();
// 	var category_arr = [];
// 	if (select_id) {
// 		category_arr = select_id.split(',');
//
// 		$.each(category_arr, function(i, e) {
// 			var level = parseInt(i) + 1;
// 			$('.goods-category-wrap-box .goodsCategory_' + level).removeClass('hide');
// 			$('.goods-category-wrap-box .goodsCategory_' + level + ' ul li[data-value="' + e + '"]').addClass('selected');
//
// 			if (level < category_arr.length) {
// 				getGoodsCategoryTree(parseInt(level) + 1, e);
// 			}
// 		});
// 	} else {
// 		$('.goods-category-wrap-box .goodsCategory_1').removeClass('hide');
// 		$('.goods-category-wrap-box .goodsCategory_2').addClass('hide');
// 		$('.goods-category-wrap-box .goodsCategory_3').addClass('hide');
// 	}
// });
//
// $("body").on('keyup', '.select-category', function() {
// 	if ($(this).val().length == 0) {
// 		$(this).siblings('#select_category_id').val("");
// 		$(this).siblings('input[name="category_id"]').val("");
// 		$(this).siblings('.category_id').val("");
// 		$(this).siblings('.category_id_1').val("");
// 		$(this).siblings('.category_id_2').val("");
// 		$(this).siblings('.category_id_3').val("");
// 	}
// });
//
// $('body').on('click', function(e){
// 	var flag = true;
// 	$(".goods-category-con-wrap .layui-block").each(function () {
// 		var con = $(this).find(".select-category");
// 		if (con.is(e.target) || con.has(e.target).length != 0 || $(".goods-category-wrap-box .category-wrap").has(e.target).length != 0) {
// 			flag = false;
// 			return;
// 		}
// 	});
//
// 	if (flag) {
// 		if($(".goods-category-wrap-box .category-wrap").is(":visible")){
// 			$(".goods-category-wrap-box .category-wrap").hide();
// 		}
// 	}
//
// });