
ALTER TABLE `shop_order_refund` CHANGE COLUMN `delivery` `delivery` VARCHAR(3000) NOT NULL DEFAULT '' COMMENT '退货配送信息';
