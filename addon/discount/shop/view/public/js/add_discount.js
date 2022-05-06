var goods_id = [], selectedGoodsId = [], sku_list = [],sku_goods_data = [],form,
	selected_sku_list=[];

layui.use(['form', 'laydate'], function() {
	form = layui.form;
	var laydate = layui.laydate,
	repeat_flag = false, //防重复标识
	currentDate = new Date(),
	minDate = "";
	form.render();

	currentDate.setDate(currentDate.getDate() + 30);

	renderTable(sku_list); // 初始化表格

	laydate.render({
		elem: '#start_time', //指定元素
		type: 'datetime',
		value: new Date(),
		done: function(value) {
			minDate = value;
			reRender();
		}
	});

	//结束时间
	laydate.render({
		elem: '#end_time', //指定元素
		type: 'datetime',
		value: new Date(currentDate)
	});

	/**
	 * 重新渲染结束时间
	 * */
	function reRender() {
		$("#end_time").remove();
		$(".end-time").html('<input type="text" id="end_time" name="end_time" placeholder="请输入结束时间" lay-verify="required|time" class = "layui-input ns-len-mid" autocomplete="off"> ');
		laydate.render({
			elem: '#end_time',
			type: 'datetime',
			min: minDate
		});
	}

	/**
	 * 监听提交
	 */
	form.on('submit(save)', function(data) {

		var goods_data = [];

		for (var i in sku_list){
			var goods = {};
			goods.goods_id = sku_list[i]['goods_id'];

			goods.sku_list = sku_list[i].sku_list;
			
			goods_data.push(goods);
		}

		if(sku_list.length == 0){
			layer.msg('请选择商品', {icon: 5, anim: 6});
			return false;
		}

		console.log("goods_data的数据",goods_data)
		
		data.field.goods_data = goods_data;
		if (repeat_flag) return;
		repeat_flag = true;
		$.ajax({
			url: ns.url("discount://shop/discount/add"),
			data: data.field,
			dataType: 'JSON',
			type: 'POST',
			success: function(res) {
				repeat_flag = false;

				if (res.code == 0) {
					layer.confirm('添加成功', {
						title: '操作提示',
						btn: ['返回列表', '继续添加'],
						closeBtn: 0,
						yes: function() {
							location.href = ns.url("discount://shop/discount/lists")
						},
						btn2: function() {
							location.href = ns.url("discount://shop/discount/add");
						}
					});
				} else {
					layer.msg(res.message);
				}
			}
		});
	});

	/**
	 * 表单验证
	 */
	form.verify({
		time: function(value) {
			var now_time = (new Date()).getTime();
			var start_time = (new Date($("#start_time").val())).getTime();
			var end_time = (new Date(value)).getTime();
			if (now_time > end_time) {
				return '结束时间不能小于当前时间!'
			}
			if (start_time > end_time) {
				return '结束时间不能小于开始时间!';
			}
		},

		discount_price: function(value, item) {
			if (value == "" || value == 0) {
				return;
			}
			if (value < 0) {
				return '折扣金额不能小于0';
			}

		}
	});
});


function delGoods(that,goods_id) {
	
	var goods_ids = [];
	for (let i = 0; i < sku_list.length; i++){
		if (sku_list[i].goods_id == parseInt(goods_id)){
			sku_list.splice(i,1);
		}
	}
	
	for (let i = 0; i < sku_list.length; i++){
		goods_ids.push(sku_list[i].goods_id);
	}
	
	$(that).parents("tr").remove();

	$("#goods_num").html(goods_ids.length)
	selectedGoodsId = goods_ids.toString();

	renderTable(sku_list);
}

// 表格渲染
function renderTable(sku_list) {
	sku_list.forEach((item,index)=>{
		if(item.sku_list.length > 1){
			let data = [];
			let dataPrice = [];
			data = item.sku_list.map((v,i)=>{
				return Math.floor(v.discount_price);
			})
			dataPrice = item.sku_list.map((v,i)=>{
				return Math.floor(v.price);
			})
			if((Math.min.apply(Math,dataPrice)).toFixed(2).toString() != (Math.max.apply(Math,dataPrice)).toFixed(2).toString()){
				item.ns_price = (Math.min.apply(Math,dataPrice)).toFixed(2).toString() + '~' + (Math.max.apply(Math,dataPrice)).toFixed(2).toString();
			}else{
				item.ns_price = (Math.min.apply(Math,dataPrice)).toFixed(2).toString();
			}
			if(Math.min.apply(Math,data) != Math.max.apply(Math,data)){
				item.discount_judge = true;
				item.discount_price = (Math.min.apply(Math,data)).toFixed(2).toString() + '~' + (Math.max.apply(Math,data)).toFixed(2).toString();
			}else{
				item.discount_judge = false;
				item.discount_price = (Math.min.apply(Math,data)).toFixed(2).toString()
			}
		}else{
			item.sku_list[0].discount_price = Math.floor(item.sku_list[0].discount_price).toFixed(2).toString()
		}
	})
	
	console.log('是否是数据结构问题 - sku_list',sku_list)
	
	//展示已知数据
	table = new Table({
		elem: '#selected_goods_list',
		page: false,
		limit: Number.MAX_VALUE,
		cols: [
			[{
				width: "3%",
				type: 'checkbox',
				unresize: 'false'
			},{
				field: 'sku_name',
				title: '商品名称',
				width: '28%',
				unresize: 'false',
				templet: function(data) {
					var html = '';
					html = "<div class='goods-title'>"
						html += "<div class='goods-img'>"
							html += `<img layer-src src="${data.sku_image ? ns.img(data.sku_image) : ''}" alt="">`
						html += "</div>"
						html += `<div data-goods_id="${data.goods_id}" data-sku_id="${data.sku_id}" title="${data.sku_name}">`
							html += `<p class="ns-multi-line-hiding goods-name" >${data.sku_name}</p>`
							if(data.sku_list.length > 1){
								html += `<p class="ns-multi-line-hiding goods-name" >规格：${data.sku_list.length}个</p>`
							}
						html += "</div>"
					html += "</div>"
					return html;
				}
			}, {
				field: 'price',
				title: '商品价格',
				unresize: 'false',
				align: 'left',
				width: '15%',
				templet: function(data) {
					if(data.sku_list.length > 1){
						return '<p class="ns-line-hiding" title="'+ data.ns_price +'">￥<span>' + data.ns_price +'</span></p>';
					}else{
						return '<p class="ns-line-hiding" title="'+ data.price +'">￥<span>' + data.price +'</span></p>';
					}
				}
			},{
				title: '<span title="折扣价">折扣价<span>',
				unresize: 'false',
				width: '18%',
				templet: function(data){
					if(data.sku_list.length > 1){
						if(data.discount_judge){
							return `<input type="number" autocomplete="off" onclick="discount_price(${data.LAY_TABLE_INDEX})" 
								class="layui-input ns-len-input discount_price" placeholder="${data.discount_price}" readonly lay-verify="discount_price" min="0.00"/>`
						}else{
							return `<input type="number" class="layui-input ns-len-input discount_price" onclick="discount_price(${data.LAY_TABLE_INDEX})"
								value="${data.discount_price}" ${data.sku_id}, this)" lay-verify="discount_price" min="0.00"/>`
						}
					}else{
						return `<input type="number" class="layui-input ns-len-input 
							discount_price" value="${data.sku_list[0].discount_price}" onchange="setGoodsSku('discount_price', ${data.sku_id}, this)" lay-verify="discount_price" min="0.00"/>`
					}
				}
			}, {
				title: '操作',
				align:'right',
				unresize: 'false',
				templet:function(data){
					let html = `<div class="ns-table-btn">
									<a class="layui-btn" onclick="delGoods(this,${data.goods_id})">删除</a>
								</div>`
					return html;
					
				}
			}]
		],
		data: sku_list,
		toolbar: '#toolbarOperation',
	});
	/**
	 * 批量操作
	 */
	table.toolbar(function(obj) {
		
		if (obj.data.length < 1) {
			layer.msg('请选择要操作的数据');
			return;
		}
		switch (obj.event) {
			case "discount-price":
				editInput(0,obj);
				break;
		}
	});
}

function editInput(textIndex=0,data) {
	var text = [{
		name: '折扣价',
		value: 'discount_price'
	}];

	layer.open({
		type: 1,
		title:"修改"+text[textIndex].name,
		area: ['321px', '180px'],
		btn:["保存","返回"],
		content: `
		<div class="layui-form-item">
			<div class="">
				<input type="text" name="bargain_edit_input" lay-verify="required" autocomplete="off" class="layui-input"  placeholder="请输入${text[textIndex].name}">
			</div>
		</div>`,
		yes: function(index, layero){
			var val = $("input[name='bargain_edit_input']").val();
			if (!val){
				layer.msg("请输入" + text[textIndex].name);
				return false;
			}

			data.data.forEach(function (item,index) {
				
				sku_list.forEach(function (skuItem,skuIndex) {
					
					if (item.goods_id == skuItem.goods_id){
						
						skuItem.sku_list.forEach((v,i)=>{
							if(Math.floor(v.price) > Math.floor(val)){
								skuItem.sku_list[i].discount_price = val;
							}else{
								skuItem.sku_list[i].discount_price = v.price;
							}

						})
						
					}
					
				})
			});
			
			renderTable(sku_list);
			layer.closeAll();
		}
	});
}

/**
 * 折扣价格多规格弹窗打开
 */
function discount_price(index){
	selected_sku_list = JSON.parse(JSON.stringify(sku_list[index].sku_list));
	
	let is_reload = false;
	let sku_ids = []; 
	let checkbox = false;
	let oneOpen = layer.open({
		type:1,
		title:'修改折扣价',
		area: ['1000px', '720px'],
		btn:['保存','返回'],
		content:$('#discountPrice').html(),
		success:function(res){
			let discountTable = new Table({
				elem: '#selected_skuGoods_list',
				cols: [
					[{
						width: "3%",
						type: 'checkbox',
						unresize: 'false'
					},{
						field: 'sku_name',
						title: '商品名称',
						width: '50%',
						unresize: 'false',
						templet: function(data) {
							var html = '';
							
							html += `
								<div class="goods-title">
									<div class="goods-img">
										<img layer-src src="${data.sku_image ? ns.img(data.sku_image) : ''}" alt="">
									</div>
									<div class="ns-multi-line-hiding goods-name" data-goods_id="${data.goods_id}" data-sku_id="${data.sku_id}" title="${data.sku_name}${data.sku_name}">
										<p>${data.sku_name.split(' ')[0]}</p>
										<p>${data.sku_name.split(' ').splice(1,data.sku_name.split(' ').length).join()}</p>
									</div>
								</div>
							`;
							return html;
						}
					},{
						field: 'price',
						title: '原价',
						width: "27%",
						unresize: 'false'
					},{
						title: '<span title="折扣价">折扣价<span>',
						unresize: 'false',
						width: '20%',
						templet: function(data){
							return `<input type="number" name="discount_price" class="layui-input ns-len-input discount_price" value="${data.discount_price}" 
									onchange="setSkusGoods(${data.sku_id}, this)" lay-verify="discount_price" min="0.00"/>`
						}
					}]
				],
				page: false,
				data: selected_sku_list,
				toolbar: '#toolbardiscount',
				callback: function(res, curr, count){
					//分页不需要显示
					$("#selected_skuGoods_list").parent().find('.layui-table-page').hide();
					//商品内容单元格宽度有问题，重新渲染一下就好了
					if(is_reload === false){
						setTimeout(function(){
							discountTable.reload();
							is_reload = true;
						}, 300);
					}
				}
			});
			
			discountTable.toolbar(function(obj) {
				if(obj.data.length == 0){
					layer.msg('请选择需要操作的数据')
					return false;
				}else{
					let openIndex = layer.open({
						type:1,
						title:'修改折扣价',
						area: ['321px', '180px'],
						btn:['保存','返回'],
						content:'<input name="editDiscount" placeholder="请输入折扣价" class="layui-input ns-len-input"/>',
						success:function(res){},
						yes:function(res){
							setSkusGoods(sku_ids,'all')
							layer.close(openIndex)
						}
					})
				}
			});
			
			discountTable.on('checkbox', function(obj){
				switch(obj.type){
					case 'all':
						if(obj.checked){
							sku_ids = selected_sku_list.map((item,index)=>{
								return item.sku_id;
							})
						}else{
							sku_ids = [];
						}
						break;
					case 'one':
						if(obj.checked){
							sku_ids.push(obj.data.sku_id);
						}else{
							let index = sku_ids.indexOf(obj.data.sku_id);
							sku_ids.splice(index,1);
						}
						break;
				}
			});
		},
		yes:function(res){
			sku_list[index].sku_list = selected_sku_list;
			renderTable(sku_list);
			$('.layui-form-checked').removeClass('layui-form-checked')
			layer.close(oneOpen)
		},
	})
}

/* 商品 */

function addGoods(){
	goodsSelect(function (res) {
		sku_list.splice(0,sku_list.length);
		if (!res.length) return false;
		goods_id = [];
		sku_list = [];
		for(var i=0;i<res.length;i++) {
			for (var k = 0; k < res[i].sku_list.length; k++) {
				var items = res[i].sku_list[k];
				items.discount_price = items.price;
			}
			var item = res[i];
			item.discount_price = item.price;
			item.sku_name = item.goods_name;
			item.sku_image = item.goods_image;
			goods_id.push(item.goods_id);
			sku_list.push(item);
		}
		
		renderTable(sku_list);
		selectedGoodsId = goods_id;

		$("#goods_num").html(selectedGoodsId.length)
	}, selectedGoodsId);
	
	

}

function setGoodsSku(type, sku_id, obj){
	$.each(sku_list, function (i, e) {
		if(sku_id == e.sku_id){
			if(parseFloat(sku_list[i]['price']) < parseFloat($(obj).val())){
				$(obj).val(sku_list[i]['price'])
				return layer.msg('折扣价格不能大于商品价格');
			} else if($(obj).val()<0){
				$(obj).val(sku_list[i]['price'])
				return layer.msg('折扣价格不能小于0');
			}else{
				sku_list[i][type] = $(obj).val();
			}
		}
	})
}

function back() {
	location.href = ns.url("discount://shop/discount/lists");
}

/**
 * sku弹窗打开数据修改
 */
function setSkusGoods(id,that){
	selected_sku_list.forEach((item,index)=>{
		if(that == 'all'){
			console.log(id,that)
			let disconunt_money = Math.floor($("input[name='editDiscount']").val()).toFixed(2)
			if(id.indexOf(item.sku_id) != -1){
				if(item.price >= Math.floor(disconunt_money).toFixed(2)){
					item.discount_price = disconunt_money;
				}else{
					item.discount_price = item.price;
				}
				console.log('item.discount_price',item.discount_price)
				$("input[name='discount_price']").eq(index).val(item.discount_price)
			}
		}else{
			if(item.sku_id == id){
				if(item.price >= Math.floor($(that).val()).toFixed(2)){
					item.discount_price = $(that).val();
				}else{
					layer.msg('折扣价格不能大于商品原价');
					$(that).val(item.price)
					item.discount_price = $(that).val();
				}
			}
		}
	})
}