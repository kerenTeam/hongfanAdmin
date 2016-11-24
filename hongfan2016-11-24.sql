# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Database: HFDatabase
# Generation Time: 2016-11-23 08:54:40 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table hf_banners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_banners`;

CREATE TABLE `hf_banners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `reports_banner` varchar(450) DEFAULT NULL COMMENT '地方报道banner',
  `other_banner` varchar(450) DEFAULT NULL COMMENT '其他banner',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_express
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_express`;

CREATE TABLE `hf_local_express` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '快递上门',
  `x_y` int(11) DEFAULT NULL COMMENT '当前地址',
  `sender_address` varchar(200) DEFAULT NULL COMMENT '发送人',
  `recipient_address` varchar(200) DEFAULT NULL COMMENT '收件人',
  `phone` varchar(21) DEFAULT NULL COMMENT '电话',
  `link_man` varchar(32) DEFAULT NULL COMMENT '联系人',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

  

# Dump of table hf_local_game
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_game`;

CREATE TABLE `hf_local_game` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '游戏娱乐',
  `pic` varchar(350) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_help
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_help`;

CREATE TABLE `hf_local_help` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL COMMENT '提问用户',
  `name` varchar(32) DEFAULT '' COMMENT '名称',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `reply_time` datetime NOT NULL COMMENT '回复时间',
  `xy` varchar(32) DEFAULT '' COMMENT '提问地址',
  `content` text COMMENT '提问内容',
  `replay_content` text COMMENT '回复内容',
  `state` int(2) DEFAULT NULL COMMENT '是否解决',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_hometown_reports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_hometown_reports`;

CREATE TABLE `hf_local_hometown_reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '本地报道',
  `title` varchar(125) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `red_heart` int(11) DEFAULT NULL COMMENT '点赞',
  `pic` varchar(250) DEFAULT NULL COMMENT '图片',
  `content` text,
  `state` int(11) DEFAULT NULL COMMENT '审核',
  `recommend` int(11) DEFAULT NULL COMMENT '推荐',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_hometown_reports_comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_hometown_reports_comment`;

CREATE TABLE `hf_local_hometown_reports_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论 & 回复表',
  `reports_id` int(11) DEFAULT NULL COMMENT '文章ID',
  `userid` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL COMMENT '评论ID',
  `content` text COMMENT '回复内容',
  `create_time` timestamp NULL DEFAULT NULL,
  `red_heart` int(11) DEFAULT NULL COMMENT '点赞',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_house
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_house`;

CREATE TABLE `hf_local_house` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '房产中介',
  `name` varchar(85) DEFAULT NULL COMMENT '房屋名称',
  `quarters` varchar(85) DEFAULT NULL COMMENT '小区名称',
  `area_address` varchar(350) DEFAULT NULL COMMENT '小区地址',
  `avg_price` float DEFAULT NULL COMMENT '平均售价',
  `intermediary_name` varchar(85) DEFAULT NULL COMMENT '中介名称',
  `intermediary_logo` varchar(250) DEFAULT NULL COMMENT '中介logo',
  `phone` varchar(45) DEFAULT NULL COMMENT '联系电话',
  `house_layout` varchar(85) DEFAULT NULL COMMENT '户型',
  `address` varchar(250) DEFAULT NULL COMMENT '地址',
  `house_area` int(11) DEFAULT NULL COMMENT '面积',
  `price` float DEFAULT NULL COMMENT '价格',
  `cerate_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pic` varchar(350) DEFAULT NULL COMMENT '图片',
  `content` text COMMENT '简介',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_market_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_market_data`;

CREATE TABLE `hf_local_market_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '超市比价',
  `market_name` varchar(200) DEFAULT NULL COMMENT '超市名',
  `goods_name` varchar(200) DEFAULT NULL COMMENT '商品名',
  `date_price` int(11) DEFAULT NULL COMMENT '单价',
  `date` varchar(100) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_marriage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_marriage`;

CREATE TABLE `hf_local_marriage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '一见钟情活动表',
  `title` varchar(85) DEFAULT NULL,
  `times` varchar(85) DEFAULT NULL COMMENT '期次',
  `url` varchar(350) DEFAULT NULL COMMENT 'h5地址',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `charge` float DEFAULT NULL COMMENT '收费',
  `persons_limit` int(11) DEFAULT NULL COMMENT '人数限制',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_marriage_join
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_marriage_join`;

CREATE TABLE `hf_local_marriage_join` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '一见钟情参与表',
  `marriage_id` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_service
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_service`;

CREATE TABLE `hf_local_service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '本地服务  维修、保姆、保洁、开锁',
  `name` varchar(32) DEFAULT NULL COMMENT '名称',
  `type_name` varchar(32) DEFAULT NULL COMMENT '类型',
  `logo` varchar(125) DEFAULT NULL COMMENT 'logo',
  `pic` varchar(450) DEFAULT NULL COMMENT 'pic',
  `content` text COMMENT '简介内容',
  `open_time` varchar(45) DEFAULT NULL COMMENT '营业时间',
  `link_man` varchar(45) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(45) DEFAULT NULL COMMENT '联系电话',
  `price` varchar(45) DEFAULT NULL COMMENT '价格',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `other` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_used_market
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_used_market`;

CREATE TABLE `hf_local_used_market` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '二手市场',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `title` varchar(150) DEFAULT NULL COMMENT '宝贝标题',
  `phone` varchar(150) DEFAULT NULL COMMENT '联系人电话',
  `content` text COMMENT '宝贝简介',
  `tags` varchar(11) DEFAULT NULL COMMENT '标签',
  `price` float DEFAULT NULL COMMENT '价格',
  `address` varchar(45) DEFAULT NULL COMMENT '地址',
  `brand_new` int(2) DEFAULT NULL COMMENT '是否全新 1是。0不是',
  `pic` varchar(500) DEFAULT NULL COMMENT '图片',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `state` int(11) DEFAULT NULL COMMENT '状态',
  `other` text COMMENT '其他',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_used_market_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_used_market_type`;

CREATE TABLE `hf_local_used_market_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(45) DEFAULT NULL COMMENT '分类名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_local_living_payment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_local_living_payment`;

CREATE TABLE `hf_local_living_payment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '生活缴费 json',
  `userid` int(11) DEFAULT NULL,
  `utilities` int(11) DEFAULT NULL COMMENT '水电费',
  `charge_phone` int(11) DEFAULT NULL COMMENT '话费',
  `tickets` int(11) DEFAULT NULL COMMENT '机票火车票',
 `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_shop_coupon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_shop_coupon`;

CREATE TABLE `hf_shop_coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL COMMENT '优惠劵类型主键',
  `store_id` int(11) DEFAULT NULL COMMENT '店铺主键',
  `name` varchar(11) DEFAULT NULL COMMENT '名称',
  `coupon_amount` varchar(32) DEFAULT NULL COMMENT '优惠金额',
  `discount` varchar(32) DEFAULT NULL COMMENT '折扣率',
  `salerule` varchar(32) DEFAULT NULL COMMENT '折扣规则',
  `gift` varchar(150) DEFAULT NULL COMMENT '礼物',
  `buy` varchar(45) DEFAULT '0' COMMENT '不可购买为空',
  `content` text COMMENT '内容',
  `stock` int(11) DEFAULT NULL COMMENT '库存数',
  `receive_limit` varchar(350) DEFAULT NULL COMMENT '领取限制',
  `vaild_date` varchar(350) DEFAULT NULL COMMENT '有效期',
  `verification` varchar(250) DEFAULT NULL COMMENT '核销',
  `state` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `color` varchar(32) DEFAULT NULL,
  `qrcode` varchar(125) DEFAULT NULL,
  `other` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `hf_shop_coupon` WRITE;
/*!40000 ALTER TABLE `hf_shop_coupon` DISABLE KEYS */;

INSERT INTO `hf_shop_coupon` (`id`, `type_id`, `store_id`, `name`, `coupon_amount`, `discount`, `salerule`, `gift`, `buy`, `content`, `stock`, `receive_limit`, `vaild_date`, `verification`, `state`, `create_time`, `color`, `qrcode`, `other`)
VALUES
	(1,1,2,'优惠卷','80',NULL,NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL,NULL),
	(2,2,1,'折扣劵',NULL,'80%',NULL,NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL,NULL),
	(3,3,1,'活动劵',NULL,NULL,'{rule:[200,20]}',NULL,'0',NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL,NULL),
	(4,4,1,'礼品劵',NULL,NULL,NULL,'Amazon 800元','500',NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL,NULL);

/*!40000 ALTER TABLE `hf_shop_coupon` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_shop_coupon_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_shop_coupon_type`;

CREATE TABLE `hf_shop_coupon_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '优惠卷类型表',
  `name` varchar(45) DEFAULT NULL COMMENT '折扣劵。。。',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `other` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `hf_shop_coupon_type` WRITE;
/*!40000 ALTER TABLE `hf_shop_coupon_type` DISABLE KEYS */;

INSERT INTO `hf_shop_coupon_type` (`id`, `name`, `create_time`, `other`)
VALUES
	(1,'优惠卷','2016-11-23 11:19:58',NULL),
	(2,'折扣劵','2016-11-23 11:19:58',NULL),
	(3,'活动劵','2016-11-23 11:19:58',NULL),
	(4,'礼品劵','2016-11-23 11:19:58',NULL),
	(5,'停车劵','2016-11-23 13:01:33',NULL);

/*!40000 ALTER TABLE `hf_shop_coupon_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_shop_membership_card ⚠️
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_shop_membership_card`;

CREATE TABLE `hf_shop_membership_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `hf_shop_membership_card` WRITE;
/*!40000 ALTER TABLE `hf_shop_membership_card ⚠️` DISABLE KEYS */;

INSERT INTO `hf_shop_membership_card` (`id`, `gid`, `name`)
VALUES
	(1,NULL,NULL);

/*!40000 ALTER TABLE `hf_shop_membership_card ⚠️` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_shop_membership_card_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_shop_membership_card_type`;

CREATE TABLE `hf_shop_membership_card_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `hf_shop_membership_card_type` WRITE;
/*!40000 ALTER TABLE `hf_shop_membership_card_type` DISABLE KEYS */;

INSERT INTO `hf_shop_membership_card_type` (`id`, `name`, `create_time`)
VALUES
	(1,'白银会员','2016-11-23 13:20:53'),
	(2,'黄金会员','2016-11-23 13:21:01'),
	(3,'钻石会员','2016-11-23 13:21:10');

/*!40000 ALTER TABLE `hf_shop_membership_card_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_shop_store
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_shop_store`;

CREATE TABLE `hf_shop_store` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_type` int(11) DEFAULT NULL COMMENT '商户类型 （二级业态主键）',
  `barnd_name` varchar(85) DEFAULT NULL COMMENT '品牌名称',
  `name` varchar(125) DEFAULT NULL COMMENT '商户名称',
  `secondary_name` varchar(255) DEFAULT NULL COMMENT '补充名称',
  `en_name` varchar(255) DEFAULT NULL COMMENT '英文名称',
  `block_name` varchar(255) DEFAULT NULL COMMENT '所在街区',
  `floor_name` varchar(150) DEFAULT NULL COMMENT '所在楼层',
  `door_no` varchar(125) DEFAULT NULL COMMENT '店铺编号',
  `commercial_type_name` varchar(255) DEFAULT NULL COMMENT '商家二级业态',
  `subcommercial_type_name` varchar(255) DEFAULT NULL COMMENT '商家三级业态',
  `dych_commercial_type_name` varchar(255) DEFAULT NULL COMMENT '商家独有二级业态',
  `dych_subcommercial_type_name` varchar(255) DEFAULT NULL COMMENT '商家独有三级业态',
  `pct` varchar(125) DEFAULT NULL COMMENT '客单元 （元／人）',
  `business_hours` varchar(85) DEFAULT NULL COMMENT '营业时间',
  `phone` varchar(25) DEFAULT NULL COMMENT '联系电话',
  `description` text COMMENT '简介',
  `sina_weibo` varchar(85) DEFAULT NULL COMMENT '新浪微博',
  `tc_weibo` varchar(85) DEFAULT NULL COMMENT '腾讯微博',
  `wechat` varchar(85) DEFAULT NULL COMMENT '微信号',
  `web_site` varchar(125) DEFAULT NULL COMMENT '网址',
  `shop_code` varchar(85) DEFAULT NULL COMMENT '商家自定义编号',
  `area` varchar(50) DEFAULT NULL COMMENT '面积',
  `tags` varchar(350) DEFAULT NULL COMMENT '标签',
  `logo` varchar(250) DEFAULT NULL COMMENT 'Logo',
  `pic` varchar(450) DEFAULT NULL COMMENT '商家照片',
  `qr_code` varchar(250) DEFAULT NULL COMMENT '商家二维码',
  `op_status` enum('营业中','暂停营业','装修中','即将开业') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_shop_store_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_shop_store_type`;

CREATE TABLE `hf_shop_store_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '二级业态',
  `gid` int(11) DEFAULT NULL,
  `type_name` varchar(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `hf_shop_store_type` WRITE;
/*!40000 ALTER TABLE `hf_shop_store_type` DISABLE KEYS */;

INSERT INTO `hf_shop_store_type` (`id`, `gid`, `type_name`, `create_time`)
VALUES
	(1,1,'百货','2016-11-23 12:47:27'),
	(2,1,'OUTLETS','2016-11-23 12:47:40'),
	(3,2,'超市','2016-11-23 12:47:57'),
	(4,2,'便利店','2016-11-23 12:48:09'),
	(6,2,'食品店','2016-11-23 12:48:13'),
	(7,2,'烟酒茶','2016-11-23 12:48:21'),
	(8,2,'零食','2016-11-23 12:48:31'),
	(9,3,'药品/保健品','2016-11-23 12:49:58'),
	(10,3,'化妆品/个人护理','2016-11-23 12:50:06'),
	(11,4,'服装','2016-11-23 12:50:18'),
	(12,4,'运动户外','2016-11-23 12:50:27'),
	(13,4,'内衣','2016-11-23 12:50:36'),
	(14,4,'配饰单品','2016-11-23 12:50:48'),
	(15,5,'鞋包','2016-11-23 12:50:57'),
	(16,6,'图书/音像制品','2016-11-23 12:51:15'),
	(17,6,'家电','2016-11-23 12:51:32'),
	(18,6,'电子数码/音响','2016-11-23 12:51:32');

/*!40000 ALTER TABLE `hf_shop_store_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_shop_store_type_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_shop_store_type_group`;

CREATE TABLE `hf_shop_store_type_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '一级业态',
  `name` varchar(55) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `hf_shop_store_type_group` WRITE;
/*!40000 ALTER TABLE `hf_shop_store_type_group` DISABLE KEYS */;

INSERT INTO `hf_shop_store_type_group` (`id`, `name`, `create_time`)
VALUES
	(1,'百货','2016-11-23 12:45:57'),
	(2,'超市_便利店','2016-11-23 12:46:04'),
	(3,'药品_护理_保健','2016-11-23 12:46:10'),
	(4,'服装','2016-11-23 12:46:16'),
	(5,'鞋包','2016-11-23 12:46:23'),
	(6,'数码音像','2016-11-23 12:46:31'),
	(7,'家居生活','2016-11-23 12:46:40'),
	(8,'饰品','2016-11-23 12:46:46'),
	(9,'餐饮','2016-11-23 12:46:53'),
	(10,'休闲娱乐','2016-11-23 12:47:00'),
	(11,'儿童','2016-11-23 12:47:07'),
	(12,'配套服务','2016-11-23 12:47:13');

/*!40000 ALTER TABLE `hf_shop_store_type_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_system
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_system`;

CREATE TABLE `hf_system` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '系统json',
  `system_name` varchar(85) DEFAULT NULL,
  `wechatPay` varchar(220) DEFAULT NULL,
  `aliPay` varchar(200) DEFAULT NULL,
  `sinaWeibo` varchar(200) DEFAULT NULL,
  `tcWeibo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_user_address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_user_address`;

CREATE TABLE `hf_user_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户地址表',
  `userid` int(11) DEFAULT NULL COMMENT '用户主键id',
  `phone` varchar(32) DEFAULT '' COMMENT '收货电话',
  `person` varchar(32) DEFAULT NULL COMMENT '收货人',
  `province` varchar(50) DEFAULT NULL COMMENT '省份',
  `city` varchar(50) DEFAULT NULL COMMENT '城市',
  `area` varchar(50) DEFAULT NULL COMMENT '区县',
  `address` varchar(150) DEFAULT NULL COMMENT '详细地址',
  `x_y` varchar(32) DEFAULT NULL COMMENT '经纬度',
  `state` int(11) DEFAULT NULL COMMENT '状态 0 & 1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_user_coupon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_user_coupon`;

CREATE TABLE `hf_user_coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户优惠劵表',
  `userid` int(11) DEFAULT NULL COMMENT '用户主键',
  `coupon_id` int(11) DEFAULT NULL COMMENT '优惠劵主键',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `hf_user_coupon` WRITE;
/*!40000 ALTER TABLE `hf_user_coupon` DISABLE KEYS */;

INSERT INTO `hf_user_coupon` (`id`, `userid`, `coupon_id`)
VALUES
	(1,1,2);

/*!40000 ALTER TABLE `hf_user_coupon` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_user_intergral ⚠️
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_user_intergral ⚠️`;

CREATE TABLE `hf_user_intergral ⚠️` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户积分纪录表',
  `userid` int(11) DEFAULT NULL,
  `intergral` int(11) DEFAULT NULL COMMENT '积分浮动值',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '产生时间',
  `notice` varchar(350) DEFAULT NULL COMMENT '说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `hf_user_intergral ⚠️` WRITE;
/*!40000 ALTER TABLE `hf_user_intergral ⚠️` DISABLE KEYS */;

INSERT INTO `hf_user_intergral ⚠️` (`id`, `userid`, `intergral`, `create_time`, `notice`)
VALUES
	(1,2,30,'2016-11-23 11:28:17','签到送30积分');

/*!40000 ALTER TABLE `hf_user_intergral ⚠️` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_user_member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_user_member`;

CREATE TABLE `hf_user_member` (
  `userid` bigint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户表',
  `gid` int(11) DEFAULT NULL COMMENT '用户分类主键',
  `username` varchar(82) DEFAULT NULL COMMENT '用户名',
  `nickname` varchar(82) DEFAULT NULL COMMENT '昵称',
  `password` varchar(350) DEFAULT NULL COMMENT '密码',
  `passport` varchar(30) DEFAULT NULL COMMENT '通信口令',
  `phone` varchar(11) DEFAULT NULL,
  `qq` varchar(45) DEFAULT NULL,
  `email` varchar(320) DEFAULT NULL,
  `wechat` varchar(320) DEFAULT NULL,
  `wechatpay` varchar(50) DEFAULT NULL COMMENT '微信支付',
  `alipay` varchar(50) DEFAULT NULL COMMENT '阿里支付',
  `bank` varchar(50) DEFAULT NULL COMMENT '银联',
  `gender` varchar(20) DEFAULT '' COMMENT '性别',
  `avatar` varchar(350) DEFAULT NULL COMMENT '头像',
  `message` smallint(11) DEFAULT NULL COMMENT '消息',
  `coupon` int(11) DEFAULT NULL COMMENT '优惠卷',
  `level` int(11) DEFAULT NULL COMMENT '等级',
  `address` int(32) DEFAULT NULL COMMENT '用户默认地址id',
  `map` varchar(32) DEFAULT NULL COMMENT '用户当前位置',
  `intergral` int(20) DEFAULT NULL COMMENT '积分',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table hf_user_member_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_user_member_group`;

CREATE TABLE `hf_user_member_group` (
  `gid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户分类表',
  `group_name` varchar(45) DEFAULT NULL COMMENT '用户分类名',
  `group_permission` varchar(350) DEFAULT NULL COMMENT '默认权限',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `other` text COMMENT '其他',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hf_user_member_group` WRITE;
/*!40000 ALTER TABLE `hf_user_member_group` DISABLE KEYS */;

INSERT INTO `hf_user_member_group` (`gid`, `group_name`, `group_permission`, `create_time`, `other`)
VALUES
	(1,'超级管理员','[1,2,3,4,5,6,7,8,9]','2016-11-23 09:56:19',NULL),
	(2,'系统管理员','[4,5,6,7,8,9]','2016-11-23 09:56:55',NULL);

/*!40000 ALTER TABLE `hf_user_member_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_user_message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_user_message`;

CREATE TABLE `hf_user_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户消息表',
  `userid` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `conent` varchar(450) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `hf_user_message` WRITE;
/*!40000 ALTER TABLE `hf_user_message` DISABLE KEYS */;

INSERT INTO `hf_user_message` (`id`, `userid`, `title`, `conent`, `create_time`)
VALUES
	(1,NULL,NULL,NULL,'2016-11-23 11:30:20');

/*!40000 ALTER TABLE `hf_user_message` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hf_user_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hf_user_order`;

CREATE TABLE `hf_user_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户订单表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
