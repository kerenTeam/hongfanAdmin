/*
Navicat MySQL Data Transfer

Source Server         : hongfan
Source Server Version : 50165
Source Host           : 211.149.195.183:3306
Source Database       : hongfan

Target Server Type    : MYSQL
Target Server Version : 50165
File Encoding         : 65001

Date: 2016-12-06 15:34:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for hf_ads
-- ----------------------------
DROP TABLE IF EXISTS `hf_ads`;
CREATE TABLE `hf_ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告表',
  `storeid` int(11) DEFAULT NULL COMMENT '店铺ID',
  `goodsid` int(11) DEFAULT NULL COMMENT '商品ID',
  `other_id` int(11) DEFAULT NULL COMMENT 'other_ID',
  `ad_type` varchar(85) DEFAULT NULL COMMENT '广告类型',
  `pic` varchar(350) DEFAULT NULL COMMENT '图片',
  `titlt` varchar(350) DEFAULT NULL COMMENT '标题',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_ads
-- ----------------------------
INSERT INTO `hf_ads` VALUES ('1', '1', '1', '1', 'local_service', 'http://img.hb.aicdn.com/4f590593084d044882d56144c1f8067fbacadabd11448-VPsCWF_sq320', '［平面］海报 / 版式', '2016-12-01 20:18:49');
INSERT INTO `hf_ads` VALUES ('2', '2', null, null, 'local_service', 'http://img.hb.aicdn.com/d22adeec33349027d332f5fe4de3fd57e2251d7eaf1c-vbRiST_sq320', '愿我的世界总是你的二分之一', '2016-12-01 20:19:02');

-- ----------------------------
-- Table structure for hf_banners
-- ----------------------------
DROP TABLE IF EXISTS `hf_banners`;
CREATE TABLE `hf_banners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(35) DEFAULT NULL,
  `banner` varchar(450) DEFAULT NULL COMMENT '地方报道banner',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_banners
-- ----------------------------
INSERT INTO `hf_banners` VALUES ('1', 'Index', '[{\"bannerPic\":\"upload/banner/1.png\",\"url\":\"http://www.baidu.com\"},{\"bannerPic\":\"upload/banner/2.png\",\"url\":\"http://www.baidu.com\"},{\"bannerPic\":\"upload/banner/3.png\",\"url\":\"http://www.baidu.com\"}]', '2016-11-27 16:24:24');
INSERT INTO `hf_banners` VALUES ('2', 'Localreport', '[{\"bannerPic\":\"upload/banner/1.png\",\"url\":\"http://www.baidu.com\"},{\"bannerPic\":\"upload/banner/2.png\",\"url\":\"http://www.baidu.com\"},{\"bannerPic\":\"upload/banner/3.png\",\"url\":\"http://www.baidu.com\"}]', '2016-11-27 16:24:24');
INSERT INTO `hf_banners` VALUES ('3', 'mall', '[{\"bannerPic\":\"upload/banner/1.png\",\"url\":\"http://www.baidu.com\"},{\"bannerPic\":\"upload/banner/2.png\",\"url\":\"http://www.baidu.com\"},{\"bannerPic\":\"upload/banner/3.png\",\"url\":\"http://www.baidu.com\"}]', '2016-12-01 16:05:15');

-- ----------------------------
-- Table structure for hf_local_express
-- ----------------------------
DROP TABLE IF EXISTS `hf_local_express`;
CREATE TABLE `hf_local_express` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '快递上门',
  `userid` int(10) DEFAULT NULL COMMENT '发布用户',
  `sender_address` varchar(200) DEFAULT NULL COMMENT '寄件人地址',
  `phone` varchar(21) DEFAULT NULL COMMENT '联系电话',
  `link_man` varchar(32) DEFAULT NULL COMMENT '联系人',
  `type` varchar(50) DEFAULT NULL,
  `other` varchar(100) DEFAULT NULL COMMENT '备注',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_express
-- ----------------------------
INSERT INTO `hf_local_express` VALUES ('1', '1', '成都市高新区天府三街', '15828277232', '陈', '电器', '东西有点大，请带一哥大点的包装袋之类的', '2016-12-05 16:28:43');
INSERT INTO `hf_local_express` VALUES ('2', '1', 'sdfsdfsdfs', 'sfsfsf', 'fdsfsdfs', 'fsfsf', 'sdfsf', '2016-12-06 11:59:11');
INSERT INTO `hf_local_express` VALUES ('3', '1', 'dfdfsgsfsdf', 'dsfsdfsd', 'fsdfsdfsfdfsdfsf', 'sf', 'sdfsfsfs', '2016-12-06 11:59:21');
INSERT INTO `hf_local_express` VALUES ('4', '1', 'sdfsdfsdfs', 'fsfsfsf', 'sfsfsdf', 'sdfsfsf', 'sfsfsf', '2016-12-06 11:59:29');
INSERT INTO `hf_local_express` VALUES ('5', '1', 'dfsdfsgdgff', 'sdfsdfsdf', 'sdfsfdsdf', 'sdfsdfsdf', 'sdfsdfd', '2016-12-06 11:59:38');
INSERT INTO `hf_local_express` VALUES ('6', '6', 'sfsfsfsfs', 'dfsdfsdf', 'sfsdfsdfs', 'dfsdfsdf', 'sdfsdfsfs', '2016-12-06 11:59:49');

-- ----------------------------
-- Table structure for hf_local_game
-- ----------------------------
DROP TABLE IF EXISTS `hf_local_game`;
CREATE TABLE `hf_local_game` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '游戏娱乐',
  `pic` varchar(350) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_game
-- ----------------------------

-- ----------------------------
-- Table structure for hf_local_help
-- ----------------------------
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

-- ----------------------------
-- Records of hf_local_help
-- ----------------------------

-- ----------------------------
-- Table structure for hf_local_hometown_reports
-- ----------------------------
DROP TABLE IF EXISTS `hf_local_hometown_reports`;
CREATE TABLE `hf_local_hometown_reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '本地报道',
  `title` varchar(125) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `red_heart` int(11) DEFAULT NULL COMMENT '点赞',
  `pic` varchar(250) DEFAULT NULL COMMENT '图片',
  `content` text,
  `state` int(11) DEFAULT NULL COMMENT '审核',
  `recommend` int(11) DEFAULT NULL COMMENT '推荐',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_hometown_reports
-- ----------------------------
INSERT INTO `hf_local_hometown_reports` VALUES ('1', '成都城管收缴共享单车又退还 执法乌龙折射治理困境', '12', '2016-11-27 15:30:57', '20', 'http://img.hb.aicdn.com/d0e238434e0bbc118c35bac2fb62e44b2370fd2e7ab6-t8CHpL_fw658', '央广网成都11月27日消息（记者韩民权） 据中国之声《新闻纵横》报道，最近，各个品牌的共享单车成了街头巷尾独特的风景。在资本的助推下，各家厂商也迅速在全国扩张布局。这个月，已经走遍的北上广深的共享单车开始向成都进军，不过，刚一进入就遭遇到水土不服。24号，成都市华阳街道的城管以非法占道经营为由扣押了辖区内百余辆违规停放的共享单车。\r\n\r\n　　消息爆出不久，成都市城管委员会却否定了华阳街道城管的执法行为，认为对于共享单车按照《非机动车管理条例》进行管理。具体情况如何，为什么城管执法会有如此的“乌龙”，城市里的共享单车到底是缓堵还是添乱？各方又该如何实现共赢呢？\r\n\r\n　　就在一周前，多款色彩绚丽的共享单车一夜间出现在成都的大街小巷。用户通过下载手机软件，支付几十到几百元不等的押金，便可轻易租到一辆自行车，随时取用、随时停放，每半小时内收费只需要1块钱。不少用户纷纷表示，共享单车使用起来既方便快捷，又节能环保，“我用了有一段时间了，我觉得还是比较方便的，因为我从地铁站到公司可能有1公里的样子，所以骑这个车很环保，不用堵车，也很方便。”\r\n\r\n　　如此实惠的代步工具的确赢得了不少市民的青睐。不过，就在共享单车登陆成都一周以来，负面的声音也随之出现，有市民就反映，一些单车随处停放，连人行道、盲道都在占用，一方面影响其他人的出行，一方面也不利于市容市貌。针对这个问题，11月24号，成都市天府新区华阳街道城管开展集中整治行动，扣留了近200辆“共享单车”。华阳城管负责人表示，在华阳，非机动车划有专门的停放区域，被清查回来的这批共享单车是因为违反了《成都市市容和环境卫生管理条例》中“禁止占用城市道路开展经营活动”的条款，“这个自行车我们目前为止没有收到任何单位的批复，或者是任何单位到我们城管部门来进行备案，但它们应该到城市管理部门和交警部门进行对接，包括进行备案。”\r\n\r\n　　然而，对于华阳城管收缴共享单车的行为，相关单车公司并不认同，认为自己并非非法占道经营，而是单车用户没有按照规定停车。对此，北京大成律师事务所律师向东表示，非法占道经营肯定是主观故意行为。现在造成情况的发生，是因为他自己没有按照合同的约定，把车辆停在指定的范围的之内或地点，就是这个行为，是不是运营公司的行为呢？不是的，既然不是他的行为，那你凭什么说是占道经营呢？', '1', '1');
INSERT INTO `hf_local_hometown_reports` VALUES ('2', '世界首条新能源空铁实验线在成都成功运行(图)', '1', '2016-11-27 15:33:10', '30', 'http://china.zjol.com.cn/gnxw/201611/W020161122370848408202.jpg', '<div class=\"contTxt\">\r\n\r\n<p style=\"text-align:center\"><img src=\"./W020161122370848408202.jpg\" oldsrc=\"W020161122370848408202.jpg\"></p><p style=\"text-align: center;\">　　这条新能源空铁试验线，为架设于5米之上空中的白色轨道，呈U字形，全长1.4公里</p><p style=\"text-align:center\"><img src=\"./W020161122370848481916.jpg\" oldsrc=\"W020161122370848481916.jpg\"></p><p style=\"text-align: center;\">　　驾驶舱</p><p style=\"text-align:center\"><img src=\"./W020161122370848551323.jpg\" oldsrc=\"W020161122370848551323.jpg\"></p><p style=\"text-align: center;\">　　站台</p><p style=\"text-align:center\"><img src=\"./W020161122370848632449.jpg\" oldsrc=\"W020161122370848632449.jpg\"></p><p style=\"text-align: center;\">　　车厢内部</p><p style=\"text-align: left;\">　　世界首条新能源空铁来了!11月21日下午，在成都双流空港经济技术开发区的中唐空铁产业基地，新能源空铁总设计师、中科院院士翟婉明宣布:世界首条新能源空中铁路(简称空铁)试验线成功投入运行。它把铁轨架在空中，把车厢悬挂在空中，不与人争路，不与车争路，不与植物争生存空间……当日，包括华西都市报记者在内，数百人先后登上了这辆“熊猫号”空铁，抢鲜试乘。戴上大红花，车头车身尽以熊猫元素装扮的空铁，以60公里的时速一路“飞行”……由此打开了改善城市拥堵的想象空间。<br></p><p style=\"text-align: left;\">　<strong>　空铁初体验</strong></p><p style=\"text-align: left;\"><strong>　　首秀“紧张”，它有点发抖</strong></p><p style=\"text-align: left;\">　　11月21日下午，以熊猫为装饰元素的空铁上路了，华西都市报记者也由此体验了一把“小飞侠”的感觉。这条新能源空铁试验线，为架设于5米之上空中的白色轨道，呈U字形，全长1.4公里。整条试验线由乘客车站、一条正线轨道、一条副线及列车、静调库等相关配套设备构成。可以完全真实地模拟新能源空铁在实际运行中的直线、弯道、爬坡等性能。空铁的前后首座，皆有司机为大家开路。如地铁一般，驾驶舱门与乘客车厢被一道门隔离。车厢内白底，嵌以蓝色座椅和扶手的柱子，看上去有些清爽，左右两侧分列座椅，或因试乘者众，整体感觉有些打挤。据称，一列空铁最高承运量为230人次。站在车厢内，透过玻璃车窗，视线极为开阔，犹如站在二楼眺望远方。该条试验线轨道模拟了城市不同的路况，有弯道，有上坡，线路最大坡度千分之六，最小转弯半径30米。“请大家注意体验，现在进行弯道阶段。”空铁上的“导航员”王凯介绍，这些指标的设定是按照城市路况最复杂的情况下设计的，换句话说，只要这种状况下能取得模拟成功，那么城市其他路况就都能适应。不过，记者感受到在车厢内颠簸还是比较明显。有乘客在车厢内摆放了一瓶矿泉水以测试其平稳性，见水在瓶中不停地跃动着，有乘客打趣道:“这运动的车厢就像给人做按摩一样。”对于车内颠簸的反馈，翟婉明坦率地讲，这可能与焊缝有关，下一步，他们将进一步收集试验参数，改进和优化方案。</p><p style=\"text-align: left;\"><strong>　　空铁全解密</strong></p><p style=\"text-align: left;\"><strong>　　速度/它以60公里时速“飞行”</strong></p><p style=\"text-align: left;\">　　翟婉明说，汽车成为大多数城市居民的日常交通工具，这使得城市地面交通变得不堪重负，也成为了环境污染的一个重要因素。他认为，悬挂于空中的铁路(简称空铁)是现代城市立体化交通发展的必然选择。空铁的速度如何?这是公众关注的一个问题。翟婉明介绍，新能源空铁试验线试运行期间，其时速比照日本和德国的时速，设定为近60公里。他认为，60公里每小时的速度对于城市交通来说足够。因为城市交通隔不了多远就有一个站点，维持交通工具长时间的高速不太现实。如果空铁适用于郊外或者景区，则具备提速的空间。未来，空铁的时速提至70公里或者80公里都是有可能的。</p><p style=\"text-align: left;\">　<strong>　安全/高安全性，它永不脱轨</strong></p><p style=\"text-align: left;\">　　架在空中的轨道，是否会面临脱轨的风险?如何保证其安全性?在发言中，翟婉明特别强调空铁运营的高安全性。他进一步解释，车辆走行机构始终封闭于箱形轨道梁内部，永远不会发生脱轨事件。列车在空中专线上也不会与其他物体碰撞，充分保障了系统的运营安全。话说空铁如此安全，它可能面临哪些运营方面的风险?翟婉明分析最大的风险是电池用尽了，空铁在空中停摆。如果空铁停在空中，乘客如何逃生或者疏散?翟婉明说，团队设计了疏散乘客的方案，比如车厢前后可以开窗，放置5米高的滑梯，乘客可以坐滑梯离开。也可以用简易梯疏散乘客，还可以开另外一辆空铁过来接走被困的乘客。</p><p style=\"text-align: left;\"><strong>　　低廉/每公里建设成本不足亿元</strong></p><p style=\"text-align: left;\">　　据翟婉明介绍，新能源空铁具有投资少和工期短的优势。他透露，与修建地铁动辄大投入相比，新能源空铁的轨道与梁柱采用工厂预制，现场组装，施工简便，对周围影响小，建设周期更短。经过测算，修建每公里空铁的成本不足1亿元，每公里建设成本仅为地铁的五分之一至八分之一，跨坐式的单轨交通的二分之一至三分之一。由于空铁使用的动力是锂电池，因此，运营方可以在用电峰谷充电，比如在深夜充电。一方面对平衡用电做出贡献，另一方面也可以得到最低廉的动力成本。翟婉明介绍，与日本和德国的悬挂铁路相比，他设计的空铁采用了新能源锂电池动力包作为动力源。根据载客人数所需要的动力情况不同，新能源空铁的锂电池运营时间最长可达到4小时。</p><p style=\"text-align: left;\"><strong>　　用途/更适用于二三线城市或景区</strong></p><p style=\"text-align: left;\">　　空铁的出现能否改变城市拥堵的难题?是否会成为未来主流的出行交通工具?对此，翟婉明显得非常理性:空铁并不是一个主流的交通方式，而是诸多的交通方式中的一种，是城市轨道交通的重要补充。“地下有地铁，地上有轻轨，路面变得越来越拥挤，我们架设空中铁路，在整个地面和地下的交通方式中再增加一条。”他说，通过形成城市立体交通，以解决繁忙交通的问题。他认为，空铁的建设成本低、建设工期短的特点，让它更加适合在二三线城市发展，在这类城市，空铁完全可能成为老百姓出行的主流交通工具。去上海，坐磁悬浮列车已成为很多人游上海的标配。备受瞩目的空铁是否也将在旅游业中大展拳脚?对此，翟婉明认为，在旅游业，只要景区有意打造，这将是一个不错的发展方向。</p><p style=\"text-align: left;\"><strong>　　收费/作为城市交通，价格或同地铁</strong></p><p style=\"text-align: left;\">　　如果有一天，空铁走出试验室，来到寻常百姓生活中，乘坐洋气的空铁，收费是否会像上海磁悬浮列车那般贵?是否有如地铁价格那般亲民?对此，翟婉明认为，如果它的功能是城市主要交通出行的工具，它的价格或许会像公交和地铁那样，有来自政府的补贴，价格会很亲民。如果它主要应用于景区，那么，它的价格就可能如观光车、缆车、索道一般，价格会高于日常交通费。</p><p style=\"text-align: left;\">　<strong>　我们何时坐上空铁?</strong></p><p style=\"text-align: left;\"><strong>　　翟婉明院士:</strong></p><p style=\"text-align: left;\"><strong>　　最快在明年最好在四川</strong></p><p style=\"text-align: left;\">　　翟婉明介绍，接下来，这条试验线将模拟正常载客运行状态，进行总里程为1万公里的运行测试，以测试在“反复跑”的情况下系统的稳定性，并根据实际情况，优化提升相关参数以提升相应功能，为新能源空铁商业化，进入大众日常生活，改善中国城市交通拥堵打下坚实基础，“也为接下来确定新能源空铁技术执行标准奠定基础。”既然空铁有那么多优点，这个创新产品是否会赢得市场的青睐?据中唐空铁集团有限公司董事局主席唐通介绍，目前，已经有省内外的一些城市向其抛出了橄榄枝，有些城市明确表示了想用空铁开辟空中旅游线路。翟婉明则表示，他希望第一条应用于市场的空铁诞生在孕育和生长出空铁的四川。他认为，如果做得快的话，明年就可以运用在商业线上。不过，这需要和地方政府的规划结合起来。</p><p style=\"text-align: left;\">　　<strong>知道一下</strong></p><p style=\"text-align: left;\"><strong>　　新能源 空铁</strong></p><p style=\"text-align: left;\">　　●早在1898年，德国人伍珀塔尔在乌帕河上架设建造了全球第一条单轨悬挂铁路系统，1903年全线通车，线路长13.3公里，迄今这条世界上首条单轨悬挂铁路系统已运行了113年。</p><p style=\"text-align: left;\">　　●新能源空铁是指以锂电池动力包为牵引动力的空中悬挂式轨道列车。中科院院士翟婉明介绍，接下来，这条试验线将模拟正常载客运行状态，进行总里程为1万公里的运行测试。</p>\r\n<div class=\"news_more_page\" style=\"text-align: center;\"></div>	\r\n</div>', '1', '0');
INSERT INTO `hf_local_hometown_reports` VALUES ('3', '成都东华门遗址补充发掘 文物体现蜀王府奢华(图)', '2', '2016-11-27 15:34:58', '50', 'http://img.cyol.com/img/life/attachement/jpg/site2/2016-11-25/862507297216795348714738882.jpg', ' 在水道之间，有一排密集分布的木桩，和当时水面的亭台有关，是支撑水面建筑的基柱。可以想象，当年王府贵族通过步道来到水榭歌台游赏园林的场景\r\n\r\n淤泥中有一块只剩碗底的青花瓷，印有莲花和荷叶，是景德镇出品的瓷器。王府中不少琉璃瓦当上刻着龙纹，这些建筑材料是王府区别于一般豪宅的特征\r\n\r\n今年10月，成都市文物考古工作队对市体育中心东华门遗址展开补充发掘，清理出了一条明代修筑的南北向大道，宽10米，足够两车并排跑，可见蜀王府的奢华气派。埋藏在泥土中的雕花石柱、琉璃瓦当、碗盘杯盏，透露出王府昔日的辉煌。\r\n\r\n蜀王府后花园 步道宽达10米\r\n\r\n从2013年开始，东华门遗址的考古发掘就不断带来惊喜，摩诃池、明蜀王府宫墙基槽等文化遗存重见天日。考古专家一致认定，这里就是古代成都的城市中心，从汉代到明清，王朝兴废、城市演变都在遗址一带交替进行。今年，成都市文物考古工作队将在该区域明代水渠遗址往西继续发掘2000平方米，寻找明代河道的走向，解析明代蜀王府的建筑方式。\r\n\r\n“从功能分区上来看，这里还只是蜀王府的一个后花园。”考古队的易立介绍，修建蜀王府时，工匠对摩诃池进行了大面积回填，因此在考古现场出现的生活堆积主要属于明代。考古队员沿着之前发掘的河道继续掘进20多米，河道在一条步道前止步。\r\n\r\n宽约10米，纵贯南北的砖铺道路，位于中轴线偏东位置，修建年代与明代水渠相同。按照成都市博物馆内蜀王府的复原模型，该区域位于后寝及其他宫殿附近。', '1', '0');
INSERT INTO `hf_local_hometown_reports` VALUES ('4', 'How do you prove that the function  f(x)=ex2f(x)=ex2 has no primitive?', '4', '2016-11-27 17:14:45', '21', 'https://qph.ec.quoracdn.net/main-thumb-11487-50-vcrpsihcpcxpjghubcgexcruxkfexoqy.jpeg', 'The function ex2ex2 certainly has a primitive, namely a function FF such that F′=ex2F′=ex2. What you mean to ask is why it has no elementary primitive, meaning that FF cannot be written using exponents, logs, trigonometric functions, roots, and basic arithmetic operations.\n\nIn school we learn to calculate the derivative of any explicitly-written function, such as sin(x√)sin⁡(x) or log(x3+ex)log⁡(x3+ex). We also learn to calculate various integrals (or “antiderivatives” or “primitive functions” or “indefinite integrals”), such as\n\n∫x21+x2dx=x−tan−1(x)+C∫x21+x2dx=x−tan−1⁡(x)+C\n\n∫xex2dx=12ex2+C∫xex2dx=12ex2+C\n\nThis last example makes it natural to wonder about\n\n∫ex2dx=?∫ex2dx=?\n\nbut this turns out not to have any nice closed expression using familiar functions. Teachers often say that it’s “unsolvable” or that it “doesn’t exist” or something along those lines. This isn’t accurate.\n\nIn fact, every continuous function – as well as many functions which are not at all continuous – possesses an antiderivative. However, many elementary functions have an antiderivative which is itself not elementary. This is in stark contrast to the situation with derivatives: if a function is elementary, so is its derivative.\n\nThe function f(x)=ex2f(x)=ex2 can be written as a power series, like this:\n\nf(x)=1+x2+x42+x66+x824+…+x2nn!+…f(x)=1+x2+x42+x66+x824+…+x2nn!+…\n\nThis series converges absolutely for any real (or complex) value of xx, and pretty much anything you’d want to do with ex2ex2 can be done with this power series representation.\n\nThis power series can be integrated term by term to yield\n\nF(x)=x+x33+x510+x742+…+x2n+1n!(2n+1)+…F(x)=x+x33+x510+x742+…+x2n+1n!(2n+1)+…\n\nThis series also converges absolutely everywhere, and it’s a perfectly fine function which satisfies F′(x)=ex2F′(x)=ex2. (As usual, the function F(x)+CF(x)+C would work just as well for any constant CC, and that’s all the freedom you have in determining the antiderivative of ex2ex2).\n\nOf course, if F(x)F(x) doesn’t have a “standard” name, nothing prevents us from giving it one, just like we picked names for loglog and sinsin and so on. Indeed, there’s a standard name for it, namely the “imaginary error function” (a pretty horrible name for a real-valued function of a real variable).\n\nF(x)=∫ex2dx=π‾‾√2erfi(x)F(x)=∫ex2dx=π2erfi(x).', '1', null);
INSERT INTO `hf_local_hometown_reports` VALUES ('5', 'What is the best way to simplify (x - 1/x) / (1 + 1/x) where defined?', '4', '2016-11-27 19:31:16', '6', 'https://qph.ec.quoracdn.net/main-thumb-11487-50-vcrpsihcpcxpjghubcgexcruxkfexoqy.jpeg', 'x−1x1+1xx−1x1+1x\n\n=(xx)x−1x1+1x=(xx)x−1x1+1x\n\n=x2−1x+1=x2−1x+1\n\n=(x+1)(x−1)x+1=(x+1)(x−1)x+1\n\n=x−1=x−1 where x≠0x≠0 and x≠−1', '1', null);
INSERT INTO `hf_local_hometown_reports` VALUES ('6', null, '4', '2016-11-28 15:55:41', null, null, '去年，好莱坞十部大片在中国上演，引起了一场不大不小的轰动。这类片子我在美国时看了不少，但我远不是个电影迷。初到美国时英文不好，看电影来学习英文——除了在电影院着，还租带子，在有线电视上看，前后看了大约也有上千部。片子看多了，就能分出好坏来；但我是个中国的知识分子，既不买好莱坞电影俗套的帐，也不吃美国文化那一套，评判电影另有一套标准。实际上，世界上所有的文化人评判美国电影、标准都和我差不多。用这个标准来看这十部大片，就是一些不错的商业片，谈不上好。美国电影里有一些真好的艺术片，可不是这个样了。  作为一个文化人，我认为好莱坞商业片最让人倒胃之处是落俗套。五六十年代的电影来不来的张嘴就唱，抬腿就跳，唱的是没调的歌，跳的是狗撒尿式的踢蹋舞。我在好莱坞电影里看到男女主人公一张嘴或一抬腿，马上浑身起鸡皮疙瘩，抖作一团；你可能没有同样的反应，那是因为没有我看得多。到了七十年代，西部片大行其道，无非是一个牛仔拔枪就打，全部情节就如我一位美国同学概括的：“Kill everybody”——把所有的人都杀了。等到观众看到牛仔、左轮手枪就讨厌，才换上现在最大的俗套，也就是我们正在看的：炸房子，摔汽车；一直要演到你一看到爆炸就起鸡皮疙瘩，才会换点别的。除了爆炸，还有很多别的俗套。说实在的，我真有点佩服美国片商炮制俗套时那种恬不知耻的劲头。举个例子，有部美国片子《洛基》，起初是部艺术片，讲一个穷移民，生活就如一潭死水——那叙事的风格就像怪腔怪调的布鲁斯，非常的地道。有个拳王挑对手，一下挑到他头上，这是因为他的名字叫“洛基”、在英文的意思里是“经揍”……这电影可能你已经看过了，怪七怪八的，很有点意思。我对它评价不低。假如只拍一集，它会给人留下很好的印象，别人也爱看。无奈有些傻瓜喜欢看电影里揍人的镜头，就有混帐片商把它一集集地拍了下去，除了揍人和挨揍，　—点别的都没了。我离开美国时好像已经拍到了《洛基七》或者《洛基八》，弄到了这个地步，就不是电影，根本就是大粪。', null, null);
INSERT INTO `hf_local_hometown_reports` VALUES ('7', null, '4', '2016-11-28 15:57:22', null, null, '去年，好莱坞十部大片在中国上演，引起了一场不大不小的轰动。这类片子我在美国时看了不少，但我远不是个电影迷。初到美国时英文不好，看电影来学习英文——除了在电影院着，还租带子，在有线电视上看，前后看了大约也有上千部。片子看多了，就能分出好坏来；但我是个中国的知识分子，既不买好莱坞电影俗套的帐，也不吃美国文化那一套，评判电影另有一套标准。实际上，世界上所有的文化人评判美国电影、标准都和我差不多。用这个标准来看这十部大片，就是一些不错的商业片，谈不上好。美国电影里有一些真好的艺术片，可不是这个样了。  作为一个文化人，我认为好莱坞商业片最让人倒胃之处是落俗套。五六十年代的电影来不来的张嘴就唱，抬腿就跳，唱的是没调的歌，跳的是狗撒尿式的踢蹋舞。我在好莱坞电影里看到男女主人公一张嘴或一抬腿，马上浑身起鸡皮疙瘩，抖作一团；你可能没有同样的反应，那是因为没有我看得多。到了七十年代，西部片大行其道，无非是一个牛仔拔枪就打，全部情节就如我一位美国同学概括的：“Kill everybody”——把所有的人都杀了。等到观众看到牛仔、左轮手枪就讨厌，才换上现在最大的俗套，也就是我们正在看的：炸房子，摔汽车；一直要演到你一看到爆炸就起鸡皮疙瘩，才会换点别的。除了爆炸，还有很多别的俗套。说实在的，我真有点佩服美国片商炮制俗套时那种恬不知耻的劲头。举个例子，有部美国片子《洛基》，起初是部艺术片，讲一个穷移民，生活就如一潭死水——那叙事的风格就像怪腔怪调的布鲁斯，非常的地道。有个拳王挑对手，一下挑到他头上，这是因为他的名字叫“洛基”、在英文的意思里是“经揍”……这电影可能你已经看过了，怪七怪八的，很有点意思。我对它评价不低。假如只拍一集，它会给人留下很好的印象，别人也爱看。无奈有些傻瓜喜欢看电影里揍人的镜头，就有混帐片商把它一集集地拍了下去，除了揍人和挨揍，　—点别的都没了。我离开美国时好像已经拍到了《洛基七》或者《洛基八》，弄到了这个地步，就不是电影，根本就是大粪。', null, null);
INSERT INTO `hf_local_hometown_reports` VALUES ('8', null, '4', '2016-11-28 16:00:18', null, null, '去年，好莱坞十部大片在中国上演，引起了一场不大不小的轰动。这类片子我在美国时看了不少，但我远不是个电影迷。初到美国时英文不好，看电影来学习英文——除了在电影院着，还租带子，在有线电视上看，前后看了大约也有上千部。片子看多了，就能分出好坏来；但我是个中国的知识分子，既不买好莱坞电影俗套的帐，也不吃美国文化那一套，评判电影另有一套标准。实际上，世界上所有的文化人评判美国电影、标准都和我差不多。用这个标准来看这十部大片，就是一些不错的商业片，谈不上好。美国电影里有一些真好的艺术片，可不是这个样了。  作为一个文化人，我认为好莱坞商业片最让人倒胃之处是落俗套。五六十年代的电影来不来的张嘴就唱，抬腿就跳，唱的是没调的歌，跳的是狗撒尿式的踢蹋舞。我在好莱坞电影里看到男女主人公一张嘴或一抬腿，马上浑身起鸡皮疙瘩，抖作一团；你可能没有同样的反应，那是因为没有我看得多。到了七十年代，西部片大行其道，无非是一个牛仔拔枪就打，全部情节就如我一位美国同学概括的：“Kill everybody”——把所有的人都杀了。等到观众看到牛仔、左轮手枪就讨厌，才换上现在最大的俗套，也就是我们正在看的：炸房子，摔汽车；一直要演到你一看到爆炸就起鸡皮疙瘩，才会换点别的。除了爆炸，还有很多别的俗套。说实在的，我真有点佩服美国片商炮制俗套时那种恬不知耻的劲头。举个例子，有部美国片子《洛基》，起初是部艺术片，讲一个穷移民，生活就如一潭死水——那叙事的风格就像怪腔怪调的布鲁斯，非常的地道。有个拳王挑对手，一下挑到他头上，这是因为他的名字叫“洛基”、在英文的意思里是“经揍”……这电影可能你已经看过了，怪七怪八的，很有点意思。我对它评价不低。假如只拍一集，它会给人留下很好的印象，别人也爱看。无奈有些傻瓜喜欢看电影里揍人的镜头，就有混帐片商把它一集集地拍了下去，除了揍人和挨揍，　—点别的都没了。我离开美国时好像已经拍到了《洛基七》或者《洛基八》，弄到了这个地步，就不是电影，根本就是大粪。', null, null);
INSERT INTO `hf_local_hometown_reports` VALUES ('9', null, '4', '2016-11-28 16:00:52', null, null, '去年，好莱坞十部大片在中国上演，引起了一场不大不小的轰动。这类片子我在美国时看了不少，但我远不是个电影迷。初到美国时英文不好，看电影来学习英文——除了在电影院着，还租带子，在有线电视上看，前后看了大约也有上千部。片子看多了，就能分出好坏来；但我是个中国的知识分子，既不买好莱坞电影俗套的帐，也不吃美国文化那一套，评判电影另有一套标准。实际上，世界上所有的文化人评判美国电影、标准都和我差不多。用这个标准来看这十部大片，就是一些不错的商业片，谈不上好。美国电影里有一些真好的艺术片，可不是这个样了。  作为一个文化人，我认为好莱坞商业片最让人倒胃之处是落俗套。五六十年代的电影来不来的张嘴就唱，抬腿就跳，唱的是没调的歌，跳的是狗撒尿式的踢蹋舞。我在好莱坞电影里看到男女主人公一张嘴或一抬腿，马上浑身起鸡皮疙瘩，抖作一团；你可能没有同样的反应，那是因为没有我看得多。到了七十年代，西部片大行其道，无非是一个牛仔拔枪就打，全部情节就如我一位美国同学概括的：“Kill everybody”——把所有的人都杀了。等到观众看到牛仔、左轮手枪就讨厌，才换上现在最大的俗套，也就是我们正在看的：炸房子，摔汽车；一直要演到你一看到爆炸就起鸡皮疙瘩，才会换点别的。除了爆炸，还有很多别的俗套。说实在的，我真有点佩服美国片商炮制俗套时那种恬不知耻的劲头。举个例子，有部美国片子《洛基》，起初是部艺术片，讲一个穷移民，生活就如一潭死水——那叙事的风格就像怪腔怪调的布鲁斯，非常的地道。有个拳王挑对手，一下挑到他头上，这是因为他的名字叫“洛基”、在英文的意思里是“经揍”……这电影可能你已经看过了，怪七怪八的，很有点意思。我对它评价不低。假如只拍一集，它会给人留下很好的印象，别人也爱看。无奈有些傻瓜喜欢看电影里揍人的镜头，就有混帐片商把它一集集地拍了下去，除了揍人和挨揍，　—点别的都没了。我离开美国时好像已经拍到了《洛基七》或者《洛基八》，弄到了这个地步，就不是电影，根本就是大粪。', null, null);

-- ----------------------------
-- Table structure for hf_local_hometown_reports_comment
-- ----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_hometown_reports_comment
-- ----------------------------
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('1', '5', '12', '123', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('2', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('3', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('4', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('5', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('6', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('7', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('8', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('9', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('10', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('11', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('12', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('13', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('14', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('15', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('16', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('17', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('18', '1', '0', '0', null, null, null);
INSERT INTO `hf_local_hometown_reports_comment` VALUES ('19', '1', '0', '0', null, null, null);

-- ----------------------------
-- Table structure for hf_local_house
-- ----------------------------
DROP TABLE IF EXISTS `hf_local_house`;
CREATE TABLE `hf_local_house` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '房产中介',
  `userid` int(10) DEFAULT NULL COMMENT '中介id',
  `name` varchar(85) DEFAULT NULL COMMENT '房屋名称',
  `quarters` varchar(85) DEFAULT NULL COMMENT '小区名称',
  `area_address` varchar(350) DEFAULT NULL COMMENT '小区地址',
  `avg_price` float DEFAULT NULL COMMENT '平均售价',
  `intermediary_name` varchar(85) DEFAULT NULL COMMENT '中介名称',
  `list_pic` varchar(250) DEFAULT NULL COMMENT '中介logo',
  `phone` varchar(45) DEFAULT NULL COMMENT '联系电话',
  `house_layout` varchar(85) DEFAULT NULL COMMENT '户型',
  `address` varchar(250) DEFAULT NULL COMMENT '地址',
  `house_area` int(11) DEFAULT NULL COMMENT '面积',
  `price` float DEFAULT NULL COMMENT '价格',
  `type` varchar(255) DEFAULT NULL COMMENT '房屋类型',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pic` varchar(350) DEFAULT NULL COMMENT '图片',
  `content` text COMMENT '简介',
  `state` int(2) DEFAULT '0' COMMENT '房屋状态  1已售 0待售',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_house
-- ----------------------------
INSERT INTO `hf_local_house` VALUES ('1', '1', '颐和家园 套二 有装修', '颐和家园', '成都市中和镇新下街666号', '12146', '链家房产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室2厅', '中和镇新下街60号', '88', '1.08e+006', null, '2016-12-02 11:21:51', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('2', '1', '颐和家园 套二 有装修', '颐和家园', '成都市中和镇新下街666号', '12146', '链家房产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室2厅', '中和镇新下街60号', '88', '1.8e+006', null, '2016-12-02 11:21:52', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('3', '1', '美庭 套三 有装修', '美庭', '成都市中和镇新下街169号', '12146', '链家房产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室1厅', '中和镇新下街60号', '60', '1.8e+006', null, '2016-12-02 11:21:53', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('4', '1', '怡和嘉园 套二 有装修', '怡和嘉园', '成都市中和镇中和大道3段66-5号', '11546', '链家房产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '1室2厅', '中和镇新下街60号', '105', '600000', null, '2016-12-02 11:21:54', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('5', '1', '三利宅院 套二 有装修', '三利宅院', '成都市中和镇中和大道1段666号', '12000', '链家房产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室2厅', '中和镇新下街60号', '20', '1.05414e+006', null, '2016-12-02 11:21:54', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('6', '1', '红树湾 套二 有装修', '红树湾', '成都市中和镇中和大道2段666号', '9000', '链家房产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室2厅', '中和镇新下街60号', '300', '244000', null, '2016-12-02 11:21:55', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('7', '1', '颐和家园 套三 有装修', '颐和家园', '成都市中和镇新下街666号', '12146', '链家房产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室2厅', '中和镇新下街60号', '115', '1.20743e+006', null, '2016-12-02 11:21:55', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('8', '1', '颐和家园 套二 有装修', '颐和家园', '成都市中和镇新下街666号', '12146', '新城地产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室2厅', '中和镇新下街60号', '88', '1.8e+006', null, '2016-12-02 11:21:56', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('9', '1', '美庭 套三 有装修', '美庭', '成都市中和镇新下街169号', '12146', '新城地产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室1厅', '中和镇新下街60号', '60', '1.8e+006', null, '2016-12-02 11:21:56', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('10', '1', '怡和嘉园 套二 有装修', '怡和嘉园', '成都市中和镇中和大道3段66-5号', '11546', '新城地产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '1室2厅', '中和镇新下街60号', '105', '600000', null, '2016-12-02 11:21:56', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('11', '1', '三利宅院 套二 有装修', '三利宅院', '成都市中和镇中和大道1段666号', '12000', '新城地产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室2厅', '中和镇新下街60号', '20', '1.05414e+006', null, '2016-12-02 11:21:58', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('12', '1', '红树湾 套二 有装修', '红树湾', '成都市中和镇中和大道2段666号', '9000', '新城地产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室2厅', '中和镇新下街60号', '300', '244000', null, '2016-12-02 11:21:59', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');
INSERT INTO `hf_local_house` VALUES ('13', '1', '颐和家园 套三 有装修', '颐和家园', '成都市中和镇新下街666号', '12146', '新城地产', 'http://image1.ljcdn.com/usercenter/images/uc_ehr_avatar/63f4f8ba-44bd-479d-9764-723860bf3501.jpg.120x160.jpg', '4008939259', '2室2厅', '中和镇新下街60号', '115', '1.20743e+006', null, '2016-12-02 11:22:03', '[{\"picImg\":\"http://image1.ljcdn.com/appro/group2/M00/34/04/rBAF7Fgu6XKARHweAASHAod1J3U317.jpg.600x450.jpg\"},{\"picimg\":\"http://image1.ljcdn.com/appro/group2/M00/33/71/rBAF6lgu6XuAUxQjAAR-aUr2hyI647.jpg.600x450.jpg\"}]\r\n', '1、户型介绍：此房面积88.92平米，2室2厅1卫，客厅朝南有飘窗：主卧朝南有阳台，次卧朝南带飘窗。\r\n2、装修等介绍：有装修，是房东自住房，带家具家电诚心出售。\r\n3、小区介绍：此房是2008年修建的，2梯3户，地上车位/地下车位，有安保24小时值班，必须刷卡进入。看房提前预约。', '0');

-- ----------------------------
-- Table structure for hf_local_living_payment
-- ----------------------------
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

-- ----------------------------
-- Records of hf_local_living_payment
-- ----------------------------

-- ----------------------------
-- Table structure for hf_local_market_data
-- ----------------------------
DROP TABLE IF EXISTS `hf_local_market_data`;
CREATE TABLE `hf_local_market_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '超市比价',
  `market_name` varchar(200) DEFAULT NULL COMMENT '超市名',
  `goods_name` varchar(200) DEFAULT NULL COMMENT '商品名',
  `unit` varchar(10) DEFAULT NULL COMMENT '单位',
  `date_price` float DEFAULT NULL COMMENT '单价',
  `import_user` int(10) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_market_data
-- ----------------------------
INSERT INTO `hf_local_market_data` VALUES ('2', '永辉超市', '五花肉', '斤', '20', null, '2016-12-06 10:57:35');
INSERT INTO `hf_local_market_data` VALUES ('3', '家乐福1', '白菜', '斤', '1.8', null, '2016-12-05 17:04:36');
INSERT INTO `hf_local_market_data` VALUES ('5', '345678', '热推', '水电费水电费', '34567', null, '2016-12-05 17:04:36');
INSERT INTO `hf_local_market_data` VALUES ('6', '2345678', '3456789', '服务二', '34234', null, '2016-12-05 17:05:03');
INSERT INTO `hf_local_market_data` VALUES ('7', '红旗超市', '芽菜', '斤', '2.5', null, '2016-12-06 10:57:35');
INSERT INTO `hf_local_market_data` VALUES ('8', '永辉超市', '青菜', '斤', '1.2', null, '2016-12-06 10:57:35');
INSERT INTO `hf_local_market_data` VALUES ('9', '红旗超市', '芽菜', '斤', '2.5', null, '2016-12-06 11:04:42');
INSERT INTO `hf_local_market_data` VALUES ('10', '永辉超市', '青菜', '斤', '1.2', null, '2016-12-06 11:04:42');
INSERT INTO `hf_local_market_data` VALUES ('11', 'sd ', 'asdas', 'as', '213', null, '2016-12-06 11:04:42');
INSERT INTO `hf_local_market_data` VALUES ('12', 'dsf', 'asdada', 'dad', '234', null, '2016-12-06 11:20:42');
INSERT INTO `hf_local_market_data` VALUES ('13', 'qweqwe', 'qweqwe', 'eqweqw', '2345', null, '2016-12-06 11:20:42');
INSERT INTO `hf_local_market_data` VALUES ('14', '5rty', 'rtyrty', 'gfh', '6546', null, '2016-12-06 14:42:19');
INSERT INTO `hf_local_market_data` VALUES ('15', '红旗超市', '芽菜', '斤', '2.5', '1', '2016-12-06');
INSERT INTO `hf_local_market_data` VALUES ('16', '永辉超市', '青菜', '斤', '1.2', '1', '2016-12-06');

-- ----------------------------
-- Table structure for hf_local_marriage
-- ----------------------------
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

-- ----------------------------
-- Records of hf_local_marriage
-- ----------------------------

-- ----------------------------
-- Table structure for hf_local_marriage_join
-- ----------------------------
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

-- ----------------------------
-- Records of hf_local_marriage_join
-- ----------------------------

-- ----------------------------
-- Table structure for hf_local_service
-- ----------------------------
DROP TABLE IF EXISTS `hf_local_service`;
CREATE TABLE `hf_local_service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '本地服务  维修、保姆、保洁、开锁',
  `name` varchar(32) DEFAULT NULL COMMENT '名称',
  `type_name` varchar(32) DEFAULT NULL COMMENT '类型',
  `star` float(255,0) DEFAULT NULL COMMENT '星级',
  `logo` varchar(125) DEFAULT NULL COMMENT 'logo',
  `pic` text COMMENT 'pic',
  `content` text COMMENT '简介内容',
  `open_time` varchar(45) DEFAULT NULL COMMENT '营业时间',
  `address` varchar(250) DEFAULT NULL COMMENT '地址',
  `service_cope` varchar(250) DEFAULT NULL COMMENT '服务范围',
  `link_man` varchar(45) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(45) DEFAULT NULL COMMENT '联系电话',
  `price` varchar(45) DEFAULT NULL COMMENT '价格',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `other` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_service
-- ----------------------------
INSERT INTO `hf_local_service` VALUES ('1', '重庆百家家电维修服务有限公司', '1', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:21:42', null);
INSERT INTO `hf_local_service` VALUES ('6', '重庆百家家电维修服务有限公司', '1', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:21:46', null);
INSERT INTO `hf_local_service` VALUES ('3', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:21:49', null);
INSERT INTO `hf_local_service` VALUES ('4', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:21:53', null);
INSERT INTO `hf_local_service` VALUES ('5', '重庆百家家电维修服务有限公司', '1', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:21:56', null);
INSERT INTO `hf_local_service` VALUES ('7', '重庆百家家电维修服务有限公司', '1', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:21:59', null);
INSERT INTO `hf_local_service` VALUES ('8', '重庆百家家电维修服务有限公司', '1', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:02', null);
INSERT INTO `hf_local_service` VALUES ('9', '重庆百家家电维修服务有限公司545', '1', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-06 14:30:08', null);
INSERT INTO `hf_local_service` VALUES ('10', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:09', null);
INSERT INTO `hf_local_service` VALUES ('11', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:12', null);
INSERT INTO `hf_local_service` VALUES ('12', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:16', null);
INSERT INTO `hf_local_service` VALUES ('13', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:19', null);
INSERT INTO `hf_local_service` VALUES ('14', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:22', null);
INSERT INTO `hf_local_service` VALUES ('15', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:25', null);
INSERT INTO `hf_local_service` VALUES ('16', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:29', null);
INSERT INTO `hf_local_service` VALUES ('17', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:32', null);
INSERT INTO `hf_local_service` VALUES ('18', '重庆月嫂服务有限公司', '3', null, 'http://img.hb.aicdn.com/780b8a03a5fe879bc764a6068313f8588a49e45aa076-urSz83_sq320', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '成都家电售后维修服务中心隶属于成都鑫恒泰电器设备有限公司，是成都较大的家电维修网络门户，本中心专业提供成都家电维修，成都空调维修，成都冰箱维修，成都洗衣机维修，成都热水器维修，成都微波炉维修，成都电视维修服务等，成都市区及郊县皆有我们的维修网点，您只需拨通我们的24小时热线电话400-993-9993，我们将为您尽快上门服务！\n      成都家电售后维修服务中心技术实力雄厚，服务专业。现代化管理，拥有专业的团队。服务品牌化的战略调整，力求打造家电维修服务的知名品牌。\n      我们自成立以来，不断吸收现代企业的管理先进经验，对应各类家用电器和空调维修的每个分类具有高等技术人才，有着相当准确快捷的维修、抢修能力，为顾客缩短维修占用时间，深受广大新老客户的一致好评。维修人员定期参加各品牌厂家的技能培训，使技术力量更加雄厚，我们始终本着“客户是我们的衣食父母”。\n      在如此激烈的市场竞争中，我们深知：只有真正的技术与良好的服务相结合才能被广大的用户所接受才能创造出光辉的企业形象。 同时，我中心建立了强大的技术问题解决处理管理系统．公司注重服务管理的信息化，建立有客户详细的维修记录管理档案，只要您能提供曾经维修的部分真实信息，我们都能在管理档案查到您的详细资料并提供维保。作为与客户互动沟通的桥梁，致力于客户咨询、报修、受理客户投诉和服务监督。我们将以“真诚服务，贴心到家”为服务口号，用心、用真情为您提供优质的服务。\n      维修主营项目：电视维修、 空调维修、 冰箱维修、、洗衣机维修、 微波炉维修、热水器维修等。\n      郑重承诺：明码标价，合理收费，所有维修产品收费和保修按国家规定的标准执行。\n\n专业维修各种型号微波炉,维修快速彻底，本部制定了的故障基本如下:\n\n机械旋纽式的维修,定时器故障（定时器不能复位，不能定时）\n\n门开关故障（不能开机，等不亮等）,\n\n磁控管故障（不能加热，开机炉内打火）\n\n,变压器故障（不能加热，开机短路跳闸）\n\n,电源故障（开机灯不亮，转盘不转，不能加热，整机不工作）\n\n,高压产生电路（灯亮，转盘转但不能加热）,灯不亮（灯泡或门开关损坏）\n1.服务承诺：我们的低价收费将使你满意；\n2.我们随时提供服务使你们省心；\n3.我们的技术让你们放心；\n4.我们微笑的服务态度使你们安心；\n5.你们的满意是我们的宗旨；\n6.在成都，我们东南西北都有维修网点', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:35', null);
INSERT INTO `hf_local_service` VALUES ('19', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:38', null);
INSERT INTO `hf_local_service` VALUES ('20', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:41', null);
INSERT INTO `hf_local_service` VALUES ('21', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:44', null);
INSERT INTO `hf_local_service` VALUES ('22', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:47', null);
INSERT INTO `hf_local_service` VALUES ('23', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:50', null);
INSERT INTO `hf_local_service` VALUES ('24', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:53', null);
INSERT INTO `hf_local_service` VALUES ('25', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:22:56', null);
INSERT INTO `hf_local_service` VALUES ('26', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:23:00', null);
INSERT INTO `hf_local_service` VALUES ('27', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:23:03', null);
INSERT INTO `hf_local_service` VALUES ('28', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '李小姐', '199999999', '180', '2016-12-02 15:23:06', null);
INSERT INTO `hf_local_service` VALUES ('29', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '好先生', '199999999', '200', '2016-12-02 15:23:09', null);
INSERT INTO `hf_local_service` VALUES ('30', '重庆保洁服务有限公司1', '2', '23456', 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[]', '我们的服务\r\n清洁专家严格培训提升客户服务意识\r\nSOP专业化操作流程保证服务质量\r\n信息化智能设备提升服务监管效率\r\n云端清洁团队及时响应客户特殊需求\r\n完善售后体系保障客户和劳动者权益\r\n\r\n传统线下服务\r\n服务人员缺乏客户服务意识\r\n磨洋工打扫不及时情况普遍\r\n需要客户亲自监督浪费时间\r\n特殊大型项目人员供给不足\r\n作坊式管理财务安全无保障\r\n\r\n王牌清洁培训流程\r\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\r\n\r\n10项选拔指标\r\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\r\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\r\n人员才能入围\r\n80课时，9门课程，菲律宾老师专业培训\r\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\r\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\r\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\r\n专业进口物料设备\r\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\r\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\r\n\r\n客户经理获取客户需求，定制详细服务方案\r\n\r\n项目经理跟踪服务进程，实时反馈客户需求\r\n\r\n产品团队持续精进服务产品，提升客户体验\r\n专业高效的清洁服务标准\r\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\r\n每一个角落都有我们的细致服务\r\n\r\n办公区域 ：一天2次整体清洁多遍\r\n擦拭，9块毛巾分区打扫\r\n\r\n卫生间清洁 ：40个清洁步骤，重点区域\r\n消毒，无尘无水，干净卫生\r\n\r\n休息区清洁 ：餐桌无油无灰，环境清洁有\r\n序，垃圾及时处理\r\n专业进口物料设备\r\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\r\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\r\n\r\n清洁剂无毒无害，清洁设备原装进口\r\n\r\n超细纤维毛巾，每日消毒定期更换\r\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '唐小姐', '199999999', '320', '2016-12-05 11:54:40', null);
INSERT INTO `hf_local_service` VALUES ('39', '5467892435678', '1', '65856856', 'upload/service/2016-12-06_1450271.png', '[{\"banner1\":\"upload\\/service\\/2016-12-06_145027.png\"}]', '8568568', '5685685', '858568568', '568568568', '8568568', '56856856', null, '2016-12-06 14:51:07', null);
INSERT INTO `hf_local_service` VALUES ('31', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '上官小姐', '199999999', '152', '2016-12-02 15:23:15', null);
INSERT INTO `hf_local_service` VALUES ('32', '重庆保洁服务有限公司', '2', null, 'http://static.daojia.com/changsha/pc/58qifu/1.0.0/images/logo.png?v=201611281414', '[{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"},{\"banner\":\"http://img.hb.aicdn.com/9d77dffbe1590153808304498ba7ada25f9ad42cf6e9-IWi4ZB_fw658\"}]', '我们的服务\n清洁专家严格培训提升客户服务意识\nSOP专业化操作流程保证服务质量\n信息化智能设备提升服务监管效率\n云端清洁团队及时响应客户特殊需求\n完善售后体系保障客户和劳动者权益\n\n传统线下服务\n服务人员缺乏客户服务意识\n磨洋工打扫不及时情况普遍\n需要客户亲自监督浪费时间\n特殊大型项目人员供给不足\n作坊式管理财务安全无保障\n\n王牌清洁培训流程\n我们的保洁人员不仅精于清洁之道，更能融入到客户的企业文化中\n\n10项选拔指标\n筛选保洁师的条件有：个人经历、背景、年龄、仪表、性格、\n技能、潜力、匹配度、客户接受度、个人稳定性，只有达标\n人员才能入围\n80课时，9门课程，菲律宾老师专业培训\n每个保洁师在上岗前均需通过80课时严格培训，内容涵盖保洁\n基本技能、保洁高级技能、工具使用知识、清洁剂知识、环境保护、\n客户服务、企业文化、传统礼仪、个人仪表等9大课程\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n客户经理获取客户需求，定制详细服务方案\n\n项目经理跟踪服务进程，实时反馈客户需求\n\n产品团队持续精进服务产品，提升客户体验\n专业高效的清洁服务标准\n从办公区到茶水间、从会议室到洗手间、从前台大厅到休息区\n每一个角落都有我们的细致服务\n\n办公区域 ：一天2次整体清洁多遍\n擦拭，9块毛巾分区打扫\n\n卫生间清洁 ：40个清洁步骤，重点区域\n消毒，无尘无水，干净卫生\n\n休息区清洁 ：餐桌无油无灰，环境清洁有\n序，垃圾及时处理\n专业进口物料设备\n从清洁毛巾到清洁剂、从清洁设备到专业保洁间\n从服务人员装备到考勤管理设备、每一样物料都由我们为您精挑细选。\n\n清洁剂无毒无害，清洁设备原装进口\n\n超细纤维毛巾，每日消毒定期更换\n', '09:00 ～ 22:00', '江北区黄山路1912街1号楼', '江北区 沙坪坝 九龙坡', '何先生', '199999999', '160', '2016-12-02 15:23:18', null);
INSERT INTO `hf_local_service` VALUES ('36', '2345678345678', '1', '3457890', 'upload/service/2016-12-01_155156.png', '[{\"banner\":\"upload\\/service\\/2016-12-01_155156.jpg\"},{\"banner\":\"upload\\/service\\/2016-12-01_1551561.jpg\"},{\"banner\":\"upload\\/service\\/2016-12-01_1551562.jpg\"}]', '45890-', '234567890', '34567890', '34567890-2345678', '234567890', '5457890', null, '2016-12-02 15:23:27', null);

-- ----------------------------
-- Table structure for hf_local_service_cates
-- ----------------------------
DROP TABLE IF EXISTS `hf_local_service_cates`;
CREATE TABLE `hf_local_service_cates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类管理表',
  `c_id` varchar(20) DEFAULT NULL COMMENT '所属分类id',
  `name` varchar(50) DEFAULT NULL COMMENT '分类名',
  `sort` int(5) DEFAULT '10' COMMENT '排序',
  `typeid` int(5) DEFAULT NULL COMMENT '类别  1普通信息类  2房产信息类  3法律咨询类  4闲置商品类',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `icon_color` varchar(255) DEFAULT NULL COMMENT 'icon 背景色',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_service_cates
-- ----------------------------
INSERT INTO `hf_local_service_cates` VALUES ('1', '本地生活', '维修服务', '1', '1', 'upload/icon/2016-11-28_024547.png', '#80ff00', '2016-11-28 17:45:46');
INSERT INTO `hf_local_service_cates` VALUES ('2', '本地生活', '保洁', '2', '1', 'upload/icon/2016-11-28_024654.png', '#5b5fa4', '2016-11-28 09:54:34');
INSERT INTO `hf_local_service_cates` VALUES ('3', '本地生活', '保姆月嫂', '3', '1', 'upload/icon/2016-11-28_024807.png', '#59cae1', '2016-11-28 09:54:36');
INSERT INTO `hf_local_service_cates` VALUES ('4', '本地生活', '房产咨询', '4', '2', 'upload/icon/2016-11-28_024842.png', '#ff4242', '2016-11-28 09:54:38');
INSERT INTO `hf_local_service_cates` VALUES ('5', '本地生活', '跳蚤市场', '5', '3', 'upload/icon/2016-11-28_024942.png', '#35bf8b', '2016-11-29 15:49:54');
INSERT INTO `hf_local_service_cates` VALUES ('6', '本地生活', '开锁', '6', '1', 'upload/icon/2016-11-28_025057.png', '#9cd6b6', '2016-11-28 09:55:07');
INSERT INTO `hf_local_service_cates` VALUES ('7', '本地生活', '快递上门', '7', '4', 'upload/icon/2016-11-28_025151.png', '#75ad72', '2016-11-29 15:49:50');
INSERT INTO `hf_local_service_cates` VALUES ('8', '本地生活', '超市比价', '8', '5', 'upload/icon/2016-11-28_025339.png', '#8f8dde', '2016-11-29 15:50:01');

-- ----------------------------
-- Table structure for hf_local_used_market
-- ----------------------------
DROP TABLE IF EXISTS `hf_local_used_market`;
CREATE TABLE `hf_local_used_market` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '二手市场',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `title` varchar(150) DEFAULT NULL COMMENT '宝贝标题',
  `phone` varchar(150) DEFAULT NULL COMMENT '联系人电话',
  `content` text COMMENT '宝贝简介',
  `type` int(10) DEFAULT NULL COMMENT '标签',
  `price` float DEFAULT NULL COMMENT '价格',
  `address` varchar(45) DEFAULT NULL COMMENT '地址',
  `brand_new` varchar(50) DEFAULT NULL COMMENT '是否全新',
  `list_pic` varchar(255) DEFAULT NULL COMMENT '列表缩略图',
  `pic` varchar(500) DEFAULT NULL COMMENT '图片',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `state` int(11) DEFAULT NULL COMMENT '状态',
  `other` text COMMENT '其他',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_used_market
-- ----------------------------
INSERT INTO `hf_local_used_market` VALUES ('1', '1', '笔记本电脑', '15828277232', '笔记本电脑', '1', '2500', '成都市双流区中和镇', '1', null, null, '2016-12-04 16:30:07', '0', null);
INSERT INTO `hf_local_used_market` VALUES ('5', '1', '豆腐干第三方', '23456', '赏不当功大师傅士大夫', '1', '3546', '2345', '丹甫df ', 'upload/service/mark/2016-12-04_1710341.png', '[{\"picImg\":\"upload\\/service\\/mark\\/2016-12-04_171034.png\"}]', '2016-12-05 11:41:56', null, null);

-- ----------------------------
-- Table structure for hf_local_used_market_type
-- ----------------------------
DROP TABLE IF EXISTS `hf_local_used_market_type`;
CREATE TABLE `hf_local_used_market_type` (
  `tagid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(45) DEFAULT NULL COMMENT '分类名',
  PRIMARY KEY (`tagid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_local_used_market_type
-- ----------------------------
INSERT INTO `hf_local_used_market_type` VALUES ('1', '电脑');
INSERT INTO `hf_local_used_market_type` VALUES ('2', '手机');

-- ----------------------------
-- Table structure for hf_mall_category
-- ----------------------------
DROP TABLE IF EXISTS `hf_mall_category`;
CREATE TABLE `hf_mall_category` (
  `catid` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类栏目',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '模块ID',
  `catname` varchar(50) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `letter` varchar(200) NOT NULL DEFAULT '' COMMENT '字母索引',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `icon` varchar(350) DEFAULT NULL COMMENT 'icon',
  `icon_color` varchar(50) DEFAULT NULL COMMENT '背景色',
  `sort` int(10) DEFAULT '10' COMMENT '排序',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='栏目分类';

-- ----------------------------
-- Records of hf_mall_category
-- ----------------------------
INSERT INTO `hf_mall_category` VALUES ('1', '1', '数码', 'shuma', '0', 'upload/icon/shuma.png', '#85b0dd', '1', '2016-11-29 18:21:00');
INSERT INTO `hf_mall_category` VALUES ('2', '1', '床上用品', 'csyp', '0', 'upload/icon/csyp.png', '#fb718a', '2', '2016-11-29 18:21:45');
INSERT INTO `hf_mall_category` VALUES ('3', '1', '美妆', 'mz', '0', 'upload/icon/mz.png', '#ff88b8', '3', '2016-11-29 18:22:08');
INSERT INTO `hf_mall_category` VALUES ('4', '1', '女装', 'nvzhuang', '0', 'upload/icon/women.png', '#fb718a', '4', '2016-11-29 18:23:10');
INSERT INTO `hf_mall_category` VALUES ('5', '1', '男装', 'nanzhuang', '0', 'upload/icon/men.png', '#71caeb', '5', '2016-11-29 18:23:42');
INSERT INTO `hf_mall_category` VALUES ('6', '1', '生鲜', 'sx', '0', 'upload/icon/shengxian.png', '#85b0dd', '6', '2016-11-29 18:24:33');
INSERT INTO `hf_mall_category` VALUES ('7', '1', '母婴', 'muying', '0', 'upload/icon/muying.png', '#f98646', '7', '2016-11-29 18:25:44');
INSERT INTO `hf_mall_category` VALUES ('8', '1', '电器', '电器', '0', 'upload/icon/dianqi.png', '#fb9d52', '8', '2016-11-29 18:26:28');

-- ----------------------------
-- Table structure for hf_mall_comment
-- ----------------------------
DROP TABLE IF EXISTS `hf_mall_comment`;
CREATE TABLE `hf_mall_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `goodsid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `buyerid` varchar(30) NOT NULL DEFAULT '' COMMENT '买家id',
  `sellerid` varchar(30) NOT NULL DEFAULT '' COMMENT '卖家ID',
  `seller_star` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '买家对卖家的评分',
  `seller_comment` text NOT NULL COMMENT '买家对卖家的评论',
  `comment_pic` text NOT NULL,
  `seller_ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '买家对卖家的评论时间',
  `seller_reply` text NOT NULL COMMENT '买家对卖家评论的解释',
  `seller_rtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '买家对卖家评论的解释时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='订单评论';

-- ----------------------------
-- Records of hf_mall_comment
-- ----------------------------
INSERT INTO `hf_mall_comment` VALUES ('1', '1', '1', '4', '1', '0', '产品很不错！', '[{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"},{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"},{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"}]', '2016-12-01 10:21:23', '', '0');
INSERT INTO `hf_mall_comment` VALUES ('2', '1', '1', '4', '1', '0', '谢谢评价！', '[{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"},{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"},{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"}]', '2016-12-01 10:23:56', '', '0');
INSERT INTO `hf_mall_comment` VALUES ('3', '1', '1', '4', '1', '0', '第二次购买', '[{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"},{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"},{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"}]', '2016-12-01 10:23:58', '', '0');
INSERT INTO `hf_mall_comment` VALUES ('4', '1', '1', '4', '1', '0', '很好', '[{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"},{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"},{\"comment_pic\":\"http://pic.qianmi.com/qmopen/image/open-doc-join-register.png\"}]', '2016-12-01 10:26:18', '', '0');

-- ----------------------------
-- Table structure for hf_mall_goods
-- ----------------------------
DROP TABLE IF EXISTS `hf_mall_goods`;
CREATE TABLE `hf_mall_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商城产品',
  `categoryid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属商家',
  `recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐 1是 0否',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `style` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `introduce` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `brand` varchar(100) NOT NULL DEFAULT '' COMMENT '品牌',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `originalprice` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `parameter` mediumtext COMMENT '获取参数',
  `amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '供货总量',
  `group_purchase_amount` int(11) NOT NULL DEFAULT '0' COMMENT '团购供货量',
  `unit` varchar(20) NOT NULL COMMENT '记录单位',
  `tag` mediumtext NOT NULL COMMENT '标签',
  `keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `pptword` varchar(255) NOT NULL DEFAULT '' COMMENT '属性关键词',
  `hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `orders` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单数量',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售数量',
  `good_pic` text NOT NULL COMMENT '商品图片',
  `comments` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '标题图1',
  `n1` varchar(100) NOT NULL COMMENT '购买属性名1',
  `n2` varchar(100) NOT NULL COMMENT '购买属性名2',
  `n3` varchar(100) NOT NULL COMMENT '购买属性名3',
  `v1` varchar(255) NOT NULL COMMENT '购买属性值1',
  `v2` varchar(255) NOT NULL COMMENT '购买属性值2',
  `v3` varchar(255) NOT NULL COMMENT '购买属性值3',
  `express_1` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递ID1',
  `express_name_1` varchar(100) NOT NULL COMMENT '快递名称1',
  `fee_start_1` decimal(10,2) unsigned NOT NULL COMMENT '快递起价1',
  `fee_step_1` decimal(10,2) unsigned NOT NULL COMMENT '快递价格递增1',
  `cod` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '货到付款',
  `content` text NOT NULL COMMENT '图文详情',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_mall_goods
-- ----------------------------
INSERT INTO `hf_mall_goods` VALUES ('1', '1', '2', '1', '华为 HUAWEI nova 4GB+64GB版 香槟金（白）移动联通电信4G手机 双卡双待华为 HUAWEI nova 4GB+64GB版 香槟金（白）移动联通电信4G手机 双卡双待', '', '\r\n4K高清视频拍摄！美颜自拍！DTS音效！张艺兴，关晓彤的选择！更多优惠请见！\r\n选择下方购买方式的【移动】【电信】【联通】优惠购，套餐有优惠，还有话费返还！\r\n\r\n4K高清视频拍摄！美颜自拍！DTS音效！张艺兴，关晓彤的选择！更多优惠请见！\r\n选择下方购买方式的【移动】【电信】【联通】优惠购，套餐有优惠，还有话费返还！\r\n', '华为', '2299.00', '0.00', '[\n    {parameter_name:\'颜色\',child_value:\n        [\n        {child_parameter_name:\'红色\',equivalence:200,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'白色\',equivalence:800,Inventory:20,other:\"ABCD\"},\n        {child_parameter_name:\'黑色\',equivalence:0,Inventory:100,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'内存\',child_value:\n        [\n        {child_parameter_name:\'32G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'64G\',equivalence:100,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'128G\',equivalence:300,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'运存\',child_value:\n        [\n        {child_parameter_name:\'3G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'4G\',equivalence:300,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'6G\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'版本\',child_value:\n        [\n        {child_parameter_name:\'亚太版\',equivalence:300,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'美版\',equivalence:-200,Inventory:300,other:\"ABCD\"},\n        {child_parameter_name:\'日版\',equivalence:-800,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'港版\',equivalence:-1200,Inventory:600,other:\"ABCD\"},\n        {child_parameter_name:\'国际版\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    }\n]', '2000', '0', '件', '[{tag_name:\'限时抢购\'},{tag_name:\'中秋节新品\'}]', '华为', '华为', '25', '15', '1', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img13.360buyimg.com/n1/s450x450_jfs/t3259/201/4085616080/243767/3160656a/57fe0be8N942e3b6c.jpg', '颜色', '版本', '套装', '香槟金(白)|香槟金(黑)|玫瑰金', '64G|32G', '光放标配|移动优惠购', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-06 12:30:53');
INSERT INTO `hf_mall_goods` VALUES ('2', '6', '2', '1', '七匹狼男装羽绒服男 2016新款轻薄外套 商务休闲短款修身男士羽绒服 1710 001色黑 175/92A(XL)', '', '', '七匹狼', '419.00', '0.00', '[\n    {parameter_name:\'颜色\',child_value:\n        [\n        {child_parameter_name:\'红色\',equivalence:200,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'白色\',equivalence:800,Inventory:20,other:\"ABCD\"},\n        {child_parameter_name:\'黑色\',equivalence:0,Inventory:100,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'内存\',child_value:\n        [\n        {child_parameter_name:\'32G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'64G\',equivalence:100,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'128G\',equivalence:300,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'运存\',child_value:\n        [\n        {child_parameter_name:\'3G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'4G\',equivalence:300,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'6G\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'版本\',child_value:\n        [\n        {child_parameter_name:\'亚太版\',equivalence:300,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'美版\',equivalence:-200,Inventory:300,other:\"ABCD\"},\n        {child_parameter_name:\'日版\',equivalence:-800,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'港版\',equivalence:-1200,Inventory:600,other:\"ABCD\"},\n        {child_parameter_name:\'国际版\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    }\n]', '2000', '0', '件', '[{tag_name:\'20HZ\'},{tag_name:\'20HZ\'},{tag_name:\'20HZ\'},{tag_name:\'20HZ\'}]', '七匹狼', '七匹狼', '25', '15', '2', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img11.360buyimg.com/n1/s350x449_jfs/t3376/94/994715136/360412/640be6d8/5819f6d1N93b2ee4a.jpg', '颜色', '尺码', '', '白|黑|红', 'XXL(176)|XL(170)|X(165)|S', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-06 12:29:07');
INSERT INTO `hf_mall_goods` VALUES ('3', '3', '1', '1', 'SUPOR/苏泊尔 CFXB40FC835-75电饭煲4L智能电饭锅家用正品3-5-6人', '', '', 'SUPOR/苏泊尔', '419.00', '0.00', '[\n    {parameter_name:\'颜色\',child_value:\n        [\n        {child_parameter_name:\'红色\',equivalence:200,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'白色\',equivalence:800,Inventory:20,other:\"ABCD\"},\n        {child_parameter_name:\'黑色\',equivalence:0,Inventory:100,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'内存\',child_value:\n        [\n        {child_parameter_name:\'32G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'64G\',equivalence:100,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'128G\',equivalence:300,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'运存\',child_value:\n        [\n        {child_parameter_name:\'3G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'4G\',equivalence:300,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'6G\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'版本\',child_value:\n        [\n        {child_parameter_name:\'亚太版\',equivalence:300,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'美版\',equivalence:-200,Inventory:300,other:\"ABCD\"},\n        {child_parameter_name:\'日版\',equivalence:-800,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'港版\',equivalence:-1200,Inventory:600,other:\"ABCD\"},\n        {child_parameter_name:\'国际版\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    }\n]', '2000', '0', '件', '[{tag_name:\'20HZ\'},{tag_name:\'20HZ\'},{tag_name:\'20HZ\'},{tag_name:\'20HZ\'}]', 'SUPOR/苏泊尔', 'SUPOR/苏泊尔', '25', '15', '3', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img.alicdn.com/bao/uploaded/i1/TB1ZVNqOpXXXXaUXXXXXXXXXXXX_!!0-item_pic.jpg_430x430q90.jpg', '颜色', '', '', '白', '', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-06 12:29:30');
INSERT INTO `hf_mall_goods` VALUES ('4', '6', '1', '1', 'Joyoung/九阳 JYF-40FS62智能电饭煲4L电饭锅家用3-4-5-6人正品', '', '', 'Joyoung/九阳', '419.00', '0.00', '[\n    {parameter_name:\'颜色\',child_value:\n        [\n        {child_parameter_name:\'红色\',equivalence:200,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'白色\',equivalence:800,Inventory:20,other:\"ABCD\"},\n        {child_parameter_name:\'黑色\',equivalence:0,Inventory:100,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'内存\',child_value:\n        [\n        {child_parameter_name:\'32G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'64G\',equivalence:100,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'128G\',equivalence:300,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'运存\',child_value:\n        [\n        {child_parameter_name:\'3G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'4G\',equivalence:300,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'6G\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'版本\',child_value:\n        [\n        {child_parameter_name:\'亚太版\',equivalence:300,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'美版\',equivalence:-200,Inventory:300,other:\"ABCD\"},\n        {child_parameter_name:\'日版\',equivalence:-800,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'港版\',equivalence:-1200,Inventory:600,other:\"ABCD\"},\n        {child_parameter_name:\'国际版\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    }\n]', '2000', '0', '件', '[{tag_name:\'20HZ\'},{tag_name:\'400ZHz\'},{tag_name:\'800T运存\'}]', 'Joyoung/九阳', 'Joyoung/九阳', '25', '15', '9', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img.alicdn.com/imgextra/i4/2411055336/TB2cEIoeSiK.eBjSZFyXXaS4pXa_!!2411055336.jpg', '颜色', '', '', '白', '', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-06 12:30:16');
INSERT INTO `hf_mall_goods` VALUES ('5', '6', '1', '1', 'OLAYKS CFXB20-400A 智能预约迷你电饭煲1-2-3-4人多功能小电饭锅', '', '', 'OLAYKS', '419.00', '0.00', '[\n    {parameter_name:\'颜色\',child_value:\n        [\n        {child_parameter_name:\'红色\',equivalence:200,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'白色\',equivalence:800,Inventory:20,other:\"ABCD\"},\n        {child_parameter_name:\'黑色\',equivalence:0,Inventory:100,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'内存\',child_value:\n        [\n        {child_parameter_name:\'32G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'64G\',equivalence:100,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'128G\',equivalence:300,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'运存\',child_value:\n        [\n        {child_parameter_name:\'3G\',equivalence:0,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'4G\',equivalence:300,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'6G\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    },\n    {parameter_name:\'版本\',child_value:\n        [\n        {child_parameter_name:\'亚太版\',equivalence:300,Inventory:800,other:\"ABCD\"},\n        {child_parameter_name:\'美版\',equivalence:-200,Inventory:300,other:\"ABCD\"},\n        {child_parameter_name:\'日版\',equivalence:-800,Inventory:400,other:\"ABCD\"},\n        {child_parameter_name:\'港版\',equivalence:-1200,Inventory:600,other:\"ABCD\"},\n        {child_parameter_name:\'国际版\',equivalence:600,Inventory:400,other:\"ABCD\"}\n        ]\n    }\n]', '2000', '0', '件', '[{tag_name:\'限时抢购\'},{tag_name:\'中秋节新品\'}]', 'OLAYKS', 'OLAYKS', '25', '15', '8', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img.alicdn.com/imgextra/i1/2120270425/TB2jXc_c7WM.eBjSZFhXXbdWpXa_!!2120270425.jpg_430x430q90.jpg', '颜色', '', '', '白', '', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-06 12:30:59');
INSERT INTO `hf_mall_goods` VALUES ('6', '3', '1', '1', '婴儿衣服纯棉新生儿礼盒套装秋冬婴儿用品刚出生宝宝满月母婴用品 ', '', '精梳纯棉 大气礼盒 精美贺卡 送礼品袋 送运费险 ', '', '419.00', '0.00', null, '2000', '0', '件', '[{tag_name:\'限时抢购\'},{tag_name:\'中秋节新品\'}]', '', '', '25', '15', '7', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img.alicdn.com/imgextra/i4/1661973271/TB2hfRDbVXXXXbbXXXXXXXXXXXX_!!1661973271.jpg_430x430q90.jpg', '颜色', '', '', '白', '', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-06 12:31:02');
INSERT INTO `hf_mall_goods` VALUES ('7', '4', '1', '1', '纯棉婴儿衣服套装新生儿礼盒秋冬母婴用品刚出生初生满月宝宝礼物', '', '秋冬上新 特价500件 包装精美 精梳纯棉 ', '', '419.00', '0.00', null, '2000', '0', '件', '[{tag_name:\'限时抢购\'},{tag_name:\'中秋节新品\'}]', '', '', '25', '15', '6', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img.alicdn.com/imgextra/i2/2880074794/TB2fgjwXDgX61BjSspmXXaFcFXa_!!2880074794.jpg_430x430q90.jpg', '颜色', '', '', '白', '', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-06 12:31:05');
INSERT INTO `hf_mall_goods` VALUES ('8', '3', '1', '1', '惟爱贝妈咪包双肩多功能大容量母婴包妈妈背包时尚儿童背带待产包 ', '', '一款两用 妈咪包使用 背带使用 更贴心设计 ', '', '419.00', '0.00', null, '2000', '0', '件', '', '', '', '25', '15', '5', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img.alicdn.com/imgextra/i1/2088044276/TB2t1kkmXXXXXXhXXXXXXXXXXXX_!!2088044276.jpg_430x430q90.jpg', '颜色', '', '', '白', '', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-02 10:33:47');
INSERT INTO `hf_mall_goods` VALUES ('9', '5', '1', '1', '床上四件套纯棉1.8m床秋冬简约被单全棉被套床单被罩1.5m床上用品 ', '', '㊣ 100%棉 假一罚十 不起球  ', '', '419.00', '0.00', null, '2000', '0', '件', '', '', '', '25', '15', '10', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img.alicdn.com/bao/uploaded/i4/TB11x2QMVXXXXc_XXXXXXXXXXXX_!!0-item_pic.jpg_430x430q90.jpg', '颜色', '', '', '白', '', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-01 21:03:10');
INSERT INTO `hf_mall_goods` VALUES ('10', '6', '1', '1', '简约纯色1.8床上用品四件套4被套1.5m学生宿舍寝室单人床单三件套', '', '秋冬上新 特价500件 包装精美 精梳纯棉 ', '', '419.00', '0.00', null, '2000', '0', '件', '', '', '', '25', '15', '4', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://gd4.alicdn.com/imgextra/i4/2100047651/TB2uZx4aQ5M.eBjSZFrXXXPgVXa_!!2100047651.jpg_400x400.jpg', '颜色', '', '', '白', '', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-02 10:33:52');
INSERT INTO `hf_mall_goods` VALUES ('11', '3', '1', '1', '珊瑚绒四件套加厚纯色法兰绒1.8m床单被套法莱绒冬季保暖床上用品 ', '', '加厚保暖 平方240g 一触即暖 1秒即热 ', '', '419.00', '0.00', null, '2000', '0', '件', '', '', '', '25', '15', '12', '[{\"bannerPic\":\"upload/banner/1.png\"},{\"bannerPic\":\"upload/banner/2.png\"},{\"bannerPic\":\"upload/banner/3.png\"}]', '0', 'https://img.alicdn.com/bao/uploaded/i1/TB1FOwbNVXXXXaaaXXXXXXXXXXX_!!0-item_pic.jpg_430x430q90.jpg', '颜色', '', '', '白', '', '', '1', '圆通', '12.00', '0.00', '0', '<img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3295/181/4281009689/112975/2474f43d/583bec0fNe0fb0f95.jpg\"></a><br></div><div align=\"center\"><a href=\"//sale.jd.com/act/2FbAT7wrVOY68pKv.html\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3172/77/987571873/68507/92b718ac/57c3f107N66df2708.jpg\"></a><br></div></div>\r\n                                                                                                            <div id=\"J-detail-content\">	<div style=\"text-align: center;\"><br></div><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><a href=\"//group.jd.com/thread/20000151/21044742.htm?circleId=20001111&amp;random=280\" target=\"_blank\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3748/316/587119788/46142/985cfe18/580dd7f6N17ea478e.png\"></a></div><div class=\"formwork_img\"><br><div class=\"content_tpl\"><div class=\"formwork\"><div class=\"formwork_img\"><img alt=\"\" class=\"\" src=\"//img30.360buyimg.com/jgsq-productsoa/jfs/t3571/264/1569822558/2788249/de792b9e/582add4dN331abe4c.jpg\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2016-12-02 10:33:53');

-- ----------------------------
-- Table structure for hf_mall_order
-- ----------------------------
DROP TABLE IF EXISTS `hf_mall_order`;
CREATE TABLE `hf_mall_order` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(6) unsigned NOT NULL DEFAULT '16' COMMENT '模块ID',
  `mallid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `buyer` varchar(30) NOT NULL DEFAULT '' COMMENT '买家',
  `seller` varchar(30) NOT NULL DEFAULT '' COMMENT '卖家',
  `number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单总额',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '附加费用',
  `fee_name` varchar(30) NOT NULL DEFAULT '' COMMENT '费用名称',
  `send_type` varchar(50) NOT NULL DEFAULT '' COMMENT '发货方式',
  `send_no` varchar(50) NOT NULL DEFAULT '' COMMENT '物流单号',
  `send_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '物流状态',
  `send_time` varchar(20) NOT NULL DEFAULT '' COMMENT '发货时间',
  `send_days` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货天数限制',
  `cod` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '活动付款',
  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '支付宝交易编号',
  `add_time` smallint(6) NOT NULL DEFAULT '0' COMMENT '延长收货时间(小时)',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `buyer_reason` mediumtext NOT NULL COMMENT '买家退款理由',
  `refund_reason` mediumtext NOT NULL COMMENT '处理依据',
  `note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`itemid`),
  KEY `buyer` (`buyer`),
  KEY `seller` (`seller`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商城订单';

-- ----------------------------
-- Records of hf_mall_order
-- ----------------------------
INSERT INTO `hf_mall_order` VALUES ('1', '1', '1', '148', '1', '1', '2299.00', '0.00', '', '', '', '0', '', '0', '0', '23456787453423', '0', '0', '0', '', '', '', '0');
INSERT INTO `hf_mall_order` VALUES ('2', '1', '1', '148', '1', '1', '2299.00', '0.00', '', '圆通快递', '345675345765334', '1', '2016-12-1 12:00', '0', '0', '1354687865444', '0', '0', '0', '', '', '', '0');

-- ----------------------------
-- Table structure for hf_market_floor
-- ----------------------------
DROP TABLE IF EXISTS `hf_market_floor`;
CREATE TABLE `hf_market_floor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '楼层信息表',
  `floor_id` int(10) DEFAULT NULL,
  `floor_name` varchar(255) DEFAULT NULL COMMENT '楼层名称',
  `floor_theme` varchar(255) DEFAULT NULL COMMENT '楼层主题',
  `park` int(1) DEFAULT '0' COMMENT '是否有停车场 0否 1有',
  `merchant` int(1) DEFAULT '1' COMMENT '是否有商户  1是 0否',
  `entrance` int(1) DEFAULT '0' COMMENT '是否入口楼层  0否  1是',
  `plan` int(1) DEFAULT '0' COMMENT '是否上传平面图  0否  1是',
  `plan_pic` varchar(255) DEFAULT NULL COMMENT '平面图地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_market_floor
-- ----------------------------

-- ----------------------------
-- Table structure for hf_market_info
-- ----------------------------
DROP TABLE IF EXISTS `hf_market_info`;
CREATE TABLE `hf_market_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商场简介',
  `market_name` varchar(120) DEFAULT NULL COMMENT '商场名',
  `sulg_name` varchar(255) DEFAULT NULL COMMENT '英文名称',
  `city` varchar(100) DEFAULT NULL COMMENT '城市',
  `area` varchar(100) DEFAULT NULL COMMENT '区县',
  `trading` varchar(255) DEFAULT NULL COMMENT '所在商圈',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `logo` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL COMMENT '商场图片',
  `hours_time` varchar(50) DEFAULT NULL COMMENT '营业时间',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `sina` varchar(50) DEFAULT NULL COMMENT '新浪微博',
  `tencent` varchar(255) DEFAULT NULL COMMENT '腾讯微博',
  `cardinfo` text COMMENT '商场会员卡简介',
  `open_cared_info` text COMMENT '开通绑定商场会员卡提示',
  `market_info` text COMMENT '文字简介*：',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_market_info
-- ----------------------------
INSERT INTO `hf_market_info` VALUES ('1', '宏帆广场', 'Grand sail square', '广安', '邻水', null, '啊实打实的', null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for hf_recommend
-- ----------------------------
DROP TABLE IF EXISTS `hf_recommend`;
CREATE TABLE `hf_recommend` (
  `recommend_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(85) DEFAULT NULL,
  `content` text,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recommend_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_recommend
-- ----------------------------
INSERT INTO `hf_recommend` VALUES ('1', 'Index', '[{\n    pic: \"http://img4q.duitang.com/uploads/people/201611/29/20161129153957_W4PKZ.thumb.224_224_c.jpeg\",\n    title: \"穿对了学院风，不青春都难\",\n    subtitle: \"李大象在哪里\"\n}, {\n    pic: \"http://img4q.duitang.com/uploads/people/201611/29/20161129204341_kiQHV.thumb.710_443_c.jpeg\",\n    title: \"视频 | 脆皮炸弹，它比纯粹的烤肉更好吃\",\n    subtitle: \"李大象在哪里\"\n}, {\n    pic: \"http://img4q.duitang.com/uploads/item/201611/30/20161130175033_N4vYi.thumb.710_443_c.jpeg\",\n    title: \"在寒冷的冬天，让我们和石原妹子一起温暖如春吧\",\n    subtitle: \"李大象在哪里\"\n}]', '2016-12-02 16:17:27');

-- ----------------------------
-- Table structure for hf_session
-- ----------------------------
DROP TABLE IF EXISTS `hf_session`;
CREATE TABLE `hf_session` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cookie` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expire` bigint(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cookie` (`cookie`),
  KEY `expire` (`expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_session
-- ----------------------------

-- ----------------------------
-- Table structure for hf_shop_coupon
-- ----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_shop_coupon
-- ----------------------------
INSERT INTO `hf_shop_coupon` VALUES ('1', '1', '2', '优惠卷', '80', null, null, null, '0', null, null, null, null, null, null, '0000-00-00 00:00:00', null, null, null);
INSERT INTO `hf_shop_coupon` VALUES ('2', '2', '1', '折扣劵', null, '80%', null, null, '0', null, null, null, null, null, null, '0000-00-00 00:00:00', null, null, null);
INSERT INTO `hf_shop_coupon` VALUES ('3', '3', '1', '活动劵', null, null, '{rule:[200,20]}', null, '0', null, null, null, null, null, null, '0000-00-00 00:00:00', null, null, null);
INSERT INTO `hf_shop_coupon` VALUES ('4', '4', '1', '礼品劵', null, null, null, 'Amazon 800元', '500', null, null, null, null, null, null, '0000-00-00 00:00:00', null, null, null);

-- ----------------------------
-- Table structure for hf_shop_coupon_type
-- ----------------------------
DROP TABLE IF EXISTS `hf_shop_coupon_type`;
CREATE TABLE `hf_shop_coupon_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '优惠卷类型表',
  `name` varchar(45) DEFAULT NULL COMMENT '折扣劵。。。',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `other` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_shop_coupon_type
-- ----------------------------
INSERT INTO `hf_shop_coupon_type` VALUES ('1', '优惠卷', '2016-11-23 11:19:58', null);
INSERT INTO `hf_shop_coupon_type` VALUES ('2', '折扣劵', '2016-11-23 11:19:58', null);
INSERT INTO `hf_shop_coupon_type` VALUES ('3', '活动劵', '2016-11-23 11:19:58', null);
INSERT INTO `hf_shop_coupon_type` VALUES ('4', '礼品劵', '2016-11-23 11:19:58', null);
INSERT INTO `hf_shop_coupon_type` VALUES ('5', '停车劵', '2016-11-23 13:01:33', null);

-- ----------------------------
-- Table structure for hf_shop_membership_card
-- ----------------------------
DROP TABLE IF EXISTS `hf_shop_membership_card`;
CREATE TABLE `hf_shop_membership_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_shop_membership_card
-- ----------------------------

-- ----------------------------
-- Table structure for hf_shop_membership_card_type
-- ----------------------------
DROP TABLE IF EXISTS `hf_shop_membership_card_type`;
CREATE TABLE `hf_shop_membership_card_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `bg_color` varchar(20) DEFAULT NULL COMMENT '背景色',
  `font_color` varchar(20) DEFAULT NULL COMMENT '字体颜色',
  `level` varchar(20) DEFAULT NULL COMMENT '会员卡等级',
  `card_type` varchar(255) DEFAULT NULL COMMENT '会员卡类型',
  `pic` varchar(255) DEFAULT NULL COMMENT '会员卡卡样',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_shop_membership_card_type
-- ----------------------------
INSERT INTO `hf_shop_membership_card_type` VALUES ('1', '白银会员12', '#ff8000', '#00ff40', '1', null, 'upload/cards/2016-11-28_041513.jpg', '2016-11-28 14:31:17');
INSERT INTO `hf_shop_membership_card_type` VALUES ('2', '黄金会员', '#000000', '#000000', '2', null, 'upload/cards/2016-11-28_041513.jpg', '2016-11-28 11:21:57');
INSERT INTO `hf_shop_membership_card_type` VALUES ('3', '钻石会员', '#000000', '#000000', '3', null, 'upload/cards/2016-11-28_041513.jpg', '2016-11-28 11:22:02');
INSERT INTO `hf_shop_membership_card_type` VALUES ('5', '34567', '#000000', '#000000', '567', null, 'upload/cards/2016-12-01_075956.jpg', '2016-12-01 15:00:02');

-- ----------------------------
-- Table structure for hf_shop_store
-- ----------------------------
DROP TABLE IF EXISTS `hf_shop_store`;
CREATE TABLE `hf_shop_store` (
  `store_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `barnd_name` varchar(85) DEFAULT NULL COMMENT '品牌名称',
  `store_name` varchar(125) DEFAULT NULL COMMENT '商户名称',
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
  `op_status` enum('营业中','停止营业','装修中','即将开业') NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_shop_store
-- ----------------------------
INSERT INTO `hf_shop_store` VALUES ('1', '华为', '华为手机', '华为手机旗舰店', 'huawei', '天富三街', '1楼', '1003', null, null, null, null, null, '早上9:00 - 晚上22：00', '13245875121', '华为手机简介', null, null, null, null, null, null, null, 'https://g-search1.alicdn.com/img/bao/uploaded/i4//5a/f4/TB1DqPwMXXXXXbkXVXXSutbFXXX.jpg_70x70.jpg', '[{\"picImg\":\"https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=34949323,3316289746&fm=116&gp=0.jpg\"}]', null, '营业中');

-- ----------------------------
-- Table structure for hf_shop_store_type
-- ----------------------------
DROP TABLE IF EXISTS `hf_shop_store_type`;
CREATE TABLE `hf_shop_store_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '二级业态',
  `gid` int(11) DEFAULT NULL,
  `type_name` varchar(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_shop_store_type
-- ----------------------------
INSERT INTO `hf_shop_store_type` VALUES ('1', '1', '百货', '2016-11-23 12:47:27');
INSERT INTO `hf_shop_store_type` VALUES ('2', '1', 'OUTLETS', '2016-11-23 12:47:40');
INSERT INTO `hf_shop_store_type` VALUES ('3', '2', '超市', '2016-11-23 12:47:57');
INSERT INTO `hf_shop_store_type` VALUES ('4', '2', '便利店', '2016-11-23 12:48:09');
INSERT INTO `hf_shop_store_type` VALUES ('6', '2', '食品店', '2016-11-23 12:48:13');
INSERT INTO `hf_shop_store_type` VALUES ('7', '2', '烟酒茶', '2016-11-23 12:48:21');
INSERT INTO `hf_shop_store_type` VALUES ('8', '2', '零食', '2016-11-23 12:48:31');
INSERT INTO `hf_shop_store_type` VALUES ('9', '3', '药品/保健品', '2016-11-23 12:49:58');
INSERT INTO `hf_shop_store_type` VALUES ('10', '3', '化妆品/个人护理', '2016-11-23 12:50:06');
INSERT INTO `hf_shop_store_type` VALUES ('11', '4', '服装', '2016-11-23 12:50:18');
INSERT INTO `hf_shop_store_type` VALUES ('12', '4', '运动户外', '2016-11-23 12:50:27');
INSERT INTO `hf_shop_store_type` VALUES ('13', '4', '内衣', '2016-11-23 12:50:36');
INSERT INTO `hf_shop_store_type` VALUES ('14', '4', '配饰单品', '2016-11-23 12:50:48');
INSERT INTO `hf_shop_store_type` VALUES ('15', '5', '鞋包', '2016-11-23 12:50:57');
INSERT INTO `hf_shop_store_type` VALUES ('16', '6', '图书/音像制品', '2016-11-23 12:51:15');
INSERT INTO `hf_shop_store_type` VALUES ('17', '6', '家电', '2016-11-23 12:51:32');
INSERT INTO `hf_shop_store_type` VALUES ('18', '6', '电子数码/音响', '2016-11-23 12:51:32');

-- ----------------------------
-- Table structure for hf_shop_store_type_group
-- ----------------------------
DROP TABLE IF EXISTS `hf_shop_store_type_group`;
CREATE TABLE `hf_shop_store_type_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '一级业态',
  `name` varchar(55) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_shop_store_type_group
-- ----------------------------
INSERT INTO `hf_shop_store_type_group` VALUES ('1', '百货', '2016-11-23 12:45:57');
INSERT INTO `hf_shop_store_type_group` VALUES ('2', '超市_便利店', '2016-11-23 12:46:04');
INSERT INTO `hf_shop_store_type_group` VALUES ('3', '药品_护理_保健', '2016-11-23 12:46:10');
INSERT INTO `hf_shop_store_type_group` VALUES ('4', '服装', '2016-11-23 12:46:16');
INSERT INTO `hf_shop_store_type_group` VALUES ('5', '鞋包', '2016-11-23 12:46:23');
INSERT INTO `hf_shop_store_type_group` VALUES ('6', '数码音像', '2016-11-23 12:46:31');
INSERT INTO `hf_shop_store_type_group` VALUES ('7', '家居生活', '2016-11-23 12:46:40');
INSERT INTO `hf_shop_store_type_group` VALUES ('8', '饰品', '2016-11-23 12:46:46');
INSERT INTO `hf_shop_store_type_group` VALUES ('9', '餐饮', '2016-11-23 12:46:53');
INSERT INTO `hf_shop_store_type_group` VALUES ('10', '休闲娱乐', '2016-11-23 12:47:00');
INSERT INTO `hf_shop_store_type_group` VALUES ('11', '儿童', '2016-11-23 12:47:07');
INSERT INTO `hf_shop_store_type_group` VALUES ('12', '配套服务', '2016-11-23 12:47:13');

-- ----------------------------
-- Table structure for hf_system
-- ----------------------------
DROP TABLE IF EXISTS `hf_system`;
CREATE TABLE `hf_system` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '系统json',
  `system_name` varchar(85) DEFAULT NULL,
  `wechatPay` int(11) DEFAULT NULL,
  `aliPay` int(11) DEFAULT NULL,
  `sinaWeibo` int(11) DEFAULT NULL,
  `tcWeibo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_system
-- ----------------------------

-- ----------------------------
-- Table structure for hf_user_address
-- ----------------------------
DROP TABLE IF EXISTS `hf_user_address`;
CREATE TABLE `hf_user_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户地址表',
  `userid` int(11) DEFAULT NULL COMMENT '用户主键id',
  `phone` varchar(32) DEFAULT '' COMMENT '收货电话',
  `person` varchar(32) DEFAULT NULL COMMENT '收货人',
  `postcode` int(10) DEFAULT NULL COMMENT '邮编',
  `province` varchar(50) DEFAULT NULL COMMENT '省份',
  `city` varchar(50) DEFAULT NULL COMMENT '城市',
  `area` varchar(50) DEFAULT NULL COMMENT '区县',
  `address` varchar(150) DEFAULT NULL COMMENT '详细地址',
  `x_y` varchar(32) DEFAULT NULL COMMENT '经纬度',
  `state` int(11) DEFAULT '0' COMMENT '状态 0 & 1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_user_address
-- ----------------------------
INSERT INTO `hf_user_address` VALUES ('1', '148', '13554879546', '13002825989', null, '北京市', '北京市', '东城区', '不健康', '123.354,56.89', '1', '2016-12-05 17:33:54');
INSERT INTO `hf_user_address` VALUES ('2', '148', '1587457754', '54', null, '四川', '南充', '顺庆', '文化路20号', null, '0', '2016-12-05 15:33:37');
INSERT INTO `hf_user_address` VALUES ('3', '148', '13554879546', '000', null, '北京', '北京市', '东城区', '哦哦哦哦', '24125456', '1', '2016-12-05 17:04:24');
INSERT INTO `hf_user_address` VALUES ('7', null, '', null, null, null, null, null, null, null, '0', '2016-12-05 15:56:04');
INSERT INTO `hf_user_address` VALUES ('5', '147', '13002825989', 'Jyice', null, '四川', '成都', '高新区', '天府4街', '123.354，56.89', '1', '2016-12-05 15:33:37');
INSERT INTO `hf_user_address` VALUES ('8', '147', '13002825989', 'v 多少', null, null, null, null, null, null, '0', '2016-12-05 15:56:31');
INSERT INTO `hf_user_address` VALUES ('10', '148', '13987654336', '科西嘉岛', null, '北京市', '北京市', '东城区', '嘿嘿电话回到家\n', '123.354,56.89', '1', '2016-12-05 18:55:07');
INSERT INTO `hf_user_address` VALUES ('11', '148', '13985758924', 'newPerson', null, 'newProvince', 'newCity', 'newArea', 'newAddress', '\'123.354,56.89\'', '1', '2016-12-05 18:57:46');
INSERT INTO `hf_user_address` VALUES ('12', '148', '13980865435', '和顶焦度计', null, '北京市', '北京市', '东城区', '很深激动激动呢', '123.354,56.89', '1', '2016-12-05 18:59:06');
INSERT INTO `hf_user_address` VALUES ('13', '148', '13983746868', '基督教会', null, '北京市', '北京市', '东城区', '经典咖啡减肥成绩', '123.354,56.89', '1', '2016-12-05 19:00:37');

-- ----------------------------
-- Table structure for hf_user_coupon
-- ----------------------------
DROP TABLE IF EXISTS `hf_user_coupon`;
CREATE TABLE `hf_user_coupon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户优惠劵表',
  `userid` int(11) DEFAULT NULL COMMENT '用户主键',
  `coupon_id` int(11) DEFAULT NULL COMMENT '优惠劵主键',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_user_coupon
-- ----------------------------
INSERT INTO `hf_user_coupon` VALUES ('1', '1', '2');

-- ----------------------------
-- Table structure for hf_user_intergral
-- ----------------------------
DROP TABLE IF EXISTS `hf_user_intergral`;
CREATE TABLE `hf_user_intergral` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户积分纪录表',
  `userid` int(11) DEFAULT NULL,
  `intergral` int(11) DEFAULT NULL COMMENT '积分浮动值',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '产生时间',
  `notice` varchar(350) DEFAULT NULL COMMENT '说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_user_intergral
-- ----------------------------
INSERT INTO `hf_user_intergral` VALUES ('1', '5', '30', '2016-11-24 09:07:28', '签到送30积分');
INSERT INTO `hf_user_intergral` VALUES ('2', '12', '-20', '2016-11-27 15:06:18', '消费使用20积分');
INSERT INTO `hf_user_intergral` VALUES ('3', '12', '20', '2016-11-27 15:06:21', '签到送20积分');

-- ----------------------------
-- Table structure for hf_user_member
-- ----------------------------
DROP TABLE IF EXISTS `hf_user_member`;
CREATE TABLE `hf_user_member` (
  `user_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户表',
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
  `state` int(2) DEFAULT '0' COMMENT '用户是否被屏蔽  0没有  1已屏蔽',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_user_member
-- ----------------------------
INSERT INTO `hf_user_member` VALUES ('1', '1', 'abc', '超级管理元', 'e10adc3949ba59abbe56e057f20f883e', null, '15828277232', '123456', '123456@qq.com', '', null, '', null, '男', '/Users/harris-aaron/WEB/THINKJS/hongfan/HongFan/www/upload/userUpload/s6773123.jpg', null, null, null, '0', null, '6000', '0', '2016-12-04 16:50:27');
INSERT INTO `hf_user_member` VALUES ('2', '2', '系统管理员', '系统管理员', 'e10adc3949ba59abbe56e057f20f883e', null, '31241453', '13245678', '12345678@qq.com', null, null, null, null, '男', null, null, null, null, null, null, '200', '0', '2016-11-29 11:55:41');
INSERT INTO `hf_user_member` VALUES ('3', '3', '信息管理员', '信息管理员', 'e10adc3949ba59abbe56e057f20f883e', null, '13212345678', '13455785', '132457@qq.com', null, null, null, null, '女', null, null, null, null, null, null, '500', '0', '2016-11-25 15:00:33');
INSERT INTO `hf_user_member` VALUES ('4', '5', '夏目', '夏目', 'e67c10a4c8fbfc0c400e047bb9a056a1', null, '18180924082', '1692853539', '1692853539@qq.com', null, null, null, null, '男', '192.168.199.191/www/userUpload/2b136ceca2be961b94ac4c5441de647faa0760427222-7ulv6Y_sq320.jpeg', null, null, null, '2', null, '2120', '0', '2016-12-06 12:13:38');
INSERT INTO `hf_user_member` VALUES ('153', '5', null, '17781694515', 'e67c10a4c8fbfc0c400e047bb9a056a1', null, '17781694515', null, null, null, null, null, null, '', null, null, null, null, null, null, null, '0', '2016-12-02 10:22:59');
INSERT INTO `hf_user_member` VALUES ('151', '5', null, '17781694591', 'e10adc3949ba59abbe56e057f20f883e', null, '11111111111', null, null, null, null, null, null, '', null, null, null, null, null, null, null, '0', '2016-12-02 09:47:49');
INSERT INTO `hf_user_member` VALUES ('152', '5', null, '17781694593', 'e67c10a4c8fbfc0c400e047bb9a056a1', null, '17781694593', null, null, null, null, null, null, '', null, null, null, null, null, null, null, '0', '2016-12-02 10:11:51');
INSERT INTO `hf_user_member` VALUES ('150', '5', null, '17781694530', 'e67c10a4c8fbfc0c400e047bb9a056a1', null, '17781694530', null, null, null, null, null, null, '', null, null, null, null, null, null, null, '0', '2016-11-30 15:29:13');
INSERT INTO `hf_user_member` VALUES ('148', '5', null, '13002825989', 'e10adc3949ba59abbe56e057f20f883e', null, '13002825989', null, null, null, null, null, null, '', null, null, null, null, null, null, null, '0', '2016-11-30 12:05:49');
INSERT INTO `hf_user_member` VALUES ('147', '5', null, 'youxd', 'e67c10a4c8fbfc0c400e047bb9a056a1', null, '17781694509', null, null, null, null, null, null, '男', '/Users/harris-aaron/WEB/THINKJS/hongfan/HongFan/www/upload/userUpload/QQ20161120-0@2x.png', null, null, null, '0', null, null, '0', '2016-12-06 10:47:53');

-- ----------------------------
-- Table structure for hf_user_member_group
-- ----------------------------
DROP TABLE IF EXISTS `hf_user_member_group`;
CREATE TABLE `hf_user_member_group` (
  `gid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户分类表',
  `group_name` varchar(45) DEFAULT NULL COMMENT '用户分类名',
  `group_permission` varchar(350) DEFAULT NULL COMMENT '默认权限',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `other` text COMMENT '其他',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_user_member_group
-- ----------------------------
INSERT INTO `hf_user_member_group` VALUES ('1', '超级管理员', '[1,2,3,4,5,6,7,8,9]', '2016-11-23 09:56:19', null);
INSERT INTO `hf_user_member_group` VALUES ('2', '系统管理员', '[4,5,6,7,8,9]', '2016-11-23 09:56:55', null);
INSERT INTO `hf_user_member_group` VALUES ('3', '信息管理员', '[1,2]', '2016-11-24 08:12:56', null);
INSERT INTO `hf_user_member_group` VALUES ('4', '商户', '[7,9]', '2016-11-24 08:13:27', null);
INSERT INTO `hf_user_member_group` VALUES ('5', '普通用户', '[0]', '2016-11-24 08:14:01', null);

-- ----------------------------
-- Table structure for hf_user_message
-- ----------------------------
DROP TABLE IF EXISTS `hf_user_message`;
CREATE TABLE `hf_user_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户消息表',
  `userid` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL COMMENT '标题',
  `content` varchar(450) DEFAULT NULL COMMENT '内容',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `state` int(2) DEFAULT '1' COMMENT '消息状态  1没处理  0已处理',
  `sender` int(10) DEFAULT NULL COMMENT '发送人id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_user_message
-- ----------------------------
INSERT INTO `hf_user_message` VALUES ('1', '12', '啥活动空间', '三大dads', '2016-11-27 15:58:47', '1', '1');

-- ----------------------------
-- Table structure for hf_user_order
-- ----------------------------
DROP TABLE IF EXISTS `hf_user_order`;
CREATE TABLE `hf_user_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户订单表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hf_user_order
-- ----------------------------
