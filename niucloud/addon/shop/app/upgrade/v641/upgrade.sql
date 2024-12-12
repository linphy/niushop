
DROP TABLE IF EXISTS `shop_manjian_record`;

ALTER TABLE `shop_order_goods` ADD COLUMN `is_gift` TINYINT(4) NOT NULL DEFAULT 0 COMMENT '是否是赠品（0否  1是）';


DROP TABLE IF EXISTS `shop_manjian_give_records`;
CREATE TABLE `shop_manjian_give_records` (
  `record_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '赠送记录id',
  `manjian_id` INT(11) NOT NULL DEFAULT 0 COMMENT '满减送活动id',
  `order_id` INT(11) NOT NULL DEFAULT 0 COMMENT '订单id',
  `member_id` INT(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `level` INT(11) NOT NULL DEFAULT 0 COMMENT '优惠层级',
  `point` INT(11) NOT NULL DEFAULT 0 COMMENT '赠送积分数量',
  `balance` DECIMAL(10, 2) NOT NULL DEFAULT 0.00 COMMENT '赠送余额',
  `coupon_json` TEXT DEFAULT NULL COMMENT '赠送优惠券',
  `goods_json` TEXT DEFAULT NULL COMMENT '赠送商品',
  `sku_ids` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '满足条件的商品规格id',
  `create_time` int NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci COMMENT='满减送记录表';


ALTER TABLE `shop_goods` CHANGE COLUMN `is_gift` `is_gift` TINYINT NOT NULL DEFAULT 0 COMMENT '商品是否赠品(0:否 1:是)';


DROP TABLE IF EXISTS `shop_manjian_goods`;
CREATE TABLE `shop_manjian_goods` (
  `manjian_goods_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '满减商品活动id',
  `manjian_id` INT(11) NOT NULL DEFAULT 0 COMMENT '满减活动id',
  `goods_id` INT(11) NOT NULL DEFAULT 0 COMMENT '商品id',
  `sku_id` INT(11) NOT NULL DEFAULT 0 COMMENT '规格id',
  `goods_type` VARCHAR(255) NOT NULL DEFAULT 'all_goods' COMMENT '参与商品 all_goods:全部商品参与  selected_goods:指定商品 selected_goods_not:指定商品不参与 ',
  `status` TINYINT(4) NOT NULL DEFAULT 0 COMMENT '状态（0未开始1进行中2已结束-1已关闭）',
  PRIMARY KEY (`manjian_goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci COMMENT='满减商品表';


DROP TABLE IF EXISTS `shop_manjian`;
CREATE TABLE `shop_manjian` (
  `manjian_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '满减活动id',
  `manjian_name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '名称',
  `condition_type` VARCHAR(255) NOT NULL DEFAULT 'over_n_yuan' COMMENT '条件类型 over_n_yuan:满N元  over_n_piece:满N件',
  `goods_type` VARCHAR(255) NOT NULL DEFAULT 'all_goods' COMMENT '参与商品 all_goods:全部商品参与  selected_goods:指定商品 selected_goods_not:指定商品不参与 ',
  `join_member_type` VARCHAR(255) NOT NULL DEFAULT 'all_member' COMMENT '参与会员 all_member:所有会员参与  selected_member_level:指定会员等级  selected_member_label:指定会员标签 ',
  `rule_type` VARCHAR(255) NOT NULL DEFAULT 'ladder' COMMENT '优惠规格 ladder:阶梯优惠  cycle:循环优惠',
  `rule_json` TEXT DEFAULT NULL COMMENT '优惠规则json',
  `goods_ids` TEXT DEFAULT NULL COMMENT '商品id集',
  `level_ids` TEXT DEFAULT NULL COMMENT '会员等级id集',
  `label_ids` TEXT DEFAULT NULL COMMENT '会员标签id集',
  `status` INT(11) NOT NULL DEFAULT 0 COMMENT '状态（0未开始1进行中2已结束-1已关闭）',
  `start_time` INT(11) NOT NULL DEFAULT 0 COMMENT '开始时间',
  `end_time` INT(11) NOT NULL DEFAULT 0 COMMENT '结束时间',
  `create_time` INT(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` INT(11) NOT NULL DEFAULT 0 COMMENT '修改时间',
  `remark` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '备注',
  `total_order_money` DECIMAL(10, 2) NOT NULL DEFAULT 0.00 COMMENT '活动累计金额',
  `total_order_num` INT(11) NOT NULL DEFAULT 0 COMMENT '活动累计订单数',
  `total_member_num` INT(11) NOT NULL DEFAULT 0 COMMENT '活动参与会员数',
  `total_point` INT(11) NOT NULL DEFAULT 0 COMMENT '活动累计赠送积分',
  `total_balance` DECIMAL(10, 2) NOT NULL DEFAULT 0.00 COMMENT '活动累计赠送余额',
  `total_coupon_num` INT(11) NOT NULL DEFAULT 0 COMMENT '活动累计赠送优惠券数',
  `total_goods_num` INT(11) NOT NULL DEFAULT 0 COMMENT '活动累计赠送商品数',
  PRIMARY KEY (`manjian_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci COMMENT='满减活动表';


DROP TABLE IF EXISTS `shop_goods_rank`;
CREATE TABLE `shop_goods_rank` (
  `rank_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '榜单名称',
  `rank_type` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '排行周期 day=天，week=周，month=月, quarter=季度',
  `goods_source` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '来源类型 goods=指定商品，category=指定分类，brand=指定品牌, label=指定标签',
  `rule_type` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '排序规则 sale=按照销量，collect=按收藏数，evaluate=按评价数, access=按照浏览量',
  `goods_json` TEXT DEFAULT NULL COMMENT '商品信息',
  `category_ids` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '商品分类id',
  `brand_ids` VARCHAR(255) NOT NULL DEFAULT '0' COMMENT '商品品牌id',
  `label_ids` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '商品标签id，多个逗号隔开',
  `sort` INT(11) NOT NULL DEFAULT 0 COMMENT '排序号',
  `status` INT(11) NOT NULL DEFAULT 1 COMMENT '显示状态（0不显示 1显示）',
  `create_time` INT(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` INT(11) NOT NULL DEFAULT 0 COMMENT '修改时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci COMMENT='商品排行榜';
