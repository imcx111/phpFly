-- Adminer 4.6.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tb_member`;
CREATE TABLE `tb_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `sex` int(1) DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `hits_comment` int(11) DEFAULT '0',
  `points` int(11) DEFAULT '0',
  `ident` int(11) DEFAULT '0' COMMENT '认证情况',
  `vip` int(11) DEFAULT '0',
  `hitsfans` int(11) DEFAULT '0',
  `hitsfollows` int(11) DEFAULT '0',
  `hitsthreads` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='前台会员';

INSERT INTO `tb_member` (`id`, `email`, `nickname`, `password`, `avatar`, `sex`, `create_time`, `update_time`, `delete_time`, `signature`, `city`, `hits_comment`, `points`, `ident`, `vip`, `hitsfans`, `hitsfollows`, `hitsthreads`, `status`) VALUES
(2,	'seqier@126.com',	'我的中国2',	'222',	'avatar/1576723656.png',	1,	1576508554,	1576723647,	0,	'今年是中华人民共和国成立70周年。广大离退休干部在缔造和捍卫新中国的艰苦斗争中，在建设和发展新中国的伟大征程上，建立了不可磨灭的历史功劳。党的十八大以来，广大离退休干部坚守初心使命、不懈奋斗奉献，在各条战线和各个领域服务社会、造福百姓，发挥着不可替代的作用，涌现出一大批先进典型。此次受到表彰的先进集体和先进个人，就是其中的优秀代表。中国特色社会主义进入了新时代，我们比历史上任何时期都更接 ',	'北京市',	0,	65,	0,	0,	0,	0,	0,	0),
(3,	'zxzmww@qq.com',	'小马哥',	'111',	'avatar/1576598184.png',	1,	1576596301,	1576636931,	NULL,	'',	'',	0,	5,	0,	0,	1,	0,	0,	0),
(4,	'1@1.com',	't1',	'111',	NULL,	1,	1576637518,	1576637539,	NULL,	'',	'',	0,	0,	0,	0,	0,	0,	0,	0),
(5,	'2@test.com',	'小二',	'111',	'avatar/1576666849.png',	0,	1576666708,	1576666708,	NULL,	NULL,	NULL,	0,	0,	1,	0,	1,	0,	0,	0),
(6,	'fx@test.com',	'分享会员',	'111',	NULL,	0,	1576738139,	1576738139,	NULL,	NULL,	NULL,	0,	55,	0,	1,	0,	1,	0,	0),
(7,	'fxadmin@test.com',	'分享管理员',	'111',	'avatar/1576738218.png',	1,	1576738158,	1577005231,	NULL,	'ddd',	'北京市',	0,	10,	1,	1,	1,	2,	0,	0),
(8,	'seqier1@126.com',	'seqier',	'111',	'avatar/1576831151.png',	0,	1576831107,	1576831107,	NULL,	NULL,	NULL,	0,	0,	0,	0,	0,	0,	0,	0),
(9,	'seqier2@126.com',	'seqier',	'111',	NULL,	0,	1576831121,	1576831121,	NULL,	NULL,	NULL,	0,	0,	0,	0,	0,	0,	0,	0),
(10,	't2@test.com',	'店小二',	'111',	NULL,	0,	1576995990,	1576995990,	NULL,	NULL,	NULL,	0,	5,	0,	0,	0,	0,	0,	0),
(11,	't1@test.com',	'测试2',	'111',	NULL,	0,	1577005285,	1577005384,	NULL,	'',	'',	0,	5,	0,	0,	0,	0,	0,	0),
(12,	't3@test.com',	'测试3',	'111',	NULL,	0,	1577006243,	1577006243,	NULL,	NULL,	NULL,	0,	5,	0,	0,	0,	0,	0,	0),
(13,	't4@test.com',	'444',	'111',	NULL,	0,	1577014339,	1577014339,	NULL,	NULL,	NULL,	0,	5,	0,	0,	0,	0,	0,	0);

DROP TABLE IF EXISTS `tb_member_follow`;
CREATE TABLE `tb_member_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `follow_who` int(11) NOT NULL COMMENT '关注谁',
  `who_follow` int(11) NOT NULL COMMENT '谁关注',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关注表';

INSERT INTO `tb_member_follow` (`id`, `follow_who`, `who_follow`, `create_time`) VALUES
(499,	5,	7,	1576950447),
(503,	6,	7,	1576997646),
(504,	7,	6,	1576997700),
(505,	3,	7,	1576998324);

DROP TABLE IF EXISTS `tb_member_ident`;
CREATE TABLE `tb_member_ident` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `identification` varchar(55) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_member_ident` (`id`, `member_id`, `identification`, `update_time`) VALUES
(1,	7,	'木马牛',	1576823715),
(2,	5,	'店小二',	1576825183);

DROP TABLE IF EXISTS `tb_member_sign`;
CREATE TABLE `tb_member_sign` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `points` int(6) NOT NULL COMMENT '签到积分',
  `num` int(8) NOT NULL DEFAULT '0' COMMENT '连续签到次数',
  `sign_time` int(10) NOT NULL COMMENT '签到时间',
  `create_time` int(10) NOT NULL,
  `sign_ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `tb_member_sign` (`id`, `member_id`, `points`, `num`, `sign_time`, `create_time`, `sign_ip`) VALUES
(30,	2,	5,	1,	1576857600,	1576905928,	'127.0.0.1'),
(26,	2,	5,	1,	1576425600,	1576473851,	'127.0.0.1'),
(27,	2,	5,	2,	1576512000,	1576560259,	'127.0.0.1'),
(28,	2,	5,	3,	1576598400,	1576646664,	'127.0.0.1'),
(29,	2,	5,	4,	1576684800,	1576733071,	'127.0.0.1'),
(33,	6,	5,	2,	1576857600,	1576908216,	'127.0.0.1'),
(32,	6,	5,	1,	1576771200,	1576821789,	'127.0.0.1'),
(34,	7,	5,	1,	1576944000,	1576998303,	'127.0.0.1'),
(35,	3,	5,	1,	1576944000,	1576999124,	'127.0.0.1'),
(36,	11,	5,	1,	1576944000,	1577005304,	'127.0.0.1'),
(38,	12,	5,	1,	1576944000,	1577006398,	'127.0.0.1'),
(39,	10,	5,	1,	1576944000,	1577010522,	'127.0.0.1'),
(40,	13,	5,	1,	1576944000,	1577014369,	'114.253.225.40');

DROP TABLE IF EXISTS `tb_member_wish_thread`;
CREATE TABLE `tb_member_wish_thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_member_wish_thread` (`id`, `member_id`, `thread_id`, `create_time`) VALUES
(14,	8,	34,	1576835313),
(13,	5,	34,	1576819296),
(7,	7,	24,	1576745249),
(11,	7,	34,	1576771143),
(16,	6,	33,	1576851350),
(17,	2,	39,	1576856098),
(20,	2,	36,	1576938781),
(21,	11,	34,	1577005447);

DROP TABLE IF EXISTS `tb_message`;
CREATE TABLE `tb_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_id` int(11) DEFAULT '0',
  `recv_id` int(11) DEFAULT '0' COMMENT '如果是0，则发给所有人',
  `message_id` int(11) DEFAULT '0',
  `status` tinyint(4) DEFAULT '0' COMMENT '0未读，1读了',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tb_message` (`id`, `send_id`, `recv_id`, `message_id`, `status`) VALUES
(574,	7,	6,	12,	1),
(575,	7,	5,	13,	0),
(576,	7,	6,	14,	1),
(577,	7,	6,	15,	1),
(578,	7,	6,	16,	1),
(579,	7,	6,	17,	1),
(582,	7,	3,	20,	1),
(583,	7,	3,	21,	1),
(585,	7,	3,	23,	1);

DROP TABLE IF EXISTS `tb_message_text`;
CREATE TABLE `tb_message_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `message` text,
  `create_time` int(10) DEFAULT NULL COMMENT '站内信发送的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tb_message_text` (`id`, `title`, `message`, `create_time`) VALUES
(12,	'',	'分享管理员 关注了你',	1576950377),
(13,	'',	'分享管理员 关注了你',	1576950447),
(14,	'',	'分享管理员 关注了你',	1576985044),
(15,	'',	'分享管理员 关注了你',	1576985054),
(16,	'',	'分享管理员 关注了你',	1576997229),
(17,	'',	'分享管理员 关注了你',	1576997646),
(20,	'',	'关注了你',	1576998324),
(21,	'',	'vvaf',	1576998332),
(23,	'',	'明天在公司吗',	1576998382);

DROP TABLE IF EXISTS `tb_nav`;
CREATE TABLE `tb_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `image` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `listorder` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `expire_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_nav` (`id`, `pid`, `title`, `content`, `image`, `create_time`, `update_time`, `listorder`, `cid`, `href`, `target`, `icon`, `description`, `expire_time`) VALUES
(39,	NULL,	'layui',	NULL,	'',	NULL,	NULL,	NULL,	3,	'http://www.layui.com',	'_blank',	'',	'',	0),
(40,	NULL,	'layui',	NULL,	'',	NULL,	NULL,	NULL,	3,	'www.baidu.com',	'_blank',	'',	'',	0),
(41,	NULL,	'layui 实用干货和常见问题的处理',	NULL,	'',	NULL,	NULL,	NULL,	5,	'https://fly.layui.com/jie/5366/',	'_blank',	'',	'',	0),
(42,	NULL,	'layui 实用干货和常见问题的处理',	NULL,	'',	NULL,	NULL,	NULL,	5,	'https://fly.layui.com/jie/5366/',	'_blank',	'',	'',	0),
(43,	NULL,	'layui 实用干货和常见问题的处理',	NULL,	'',	NULL,	NULL,	NULL,	5,	'https://fly.layui.com/jie/5366/',	'',	'',	'',	0),
(44,	NULL,	'layui 的 GitHub 及 Gitee (码云) 仓库，欢迎Star',	NULL,	'',	NULL,	NULL,	NULL,	5,	'',	'',	'',	'',	0),
(45,	NULL,	'layui 的 GitHub 及 Gitee (码云) 仓库，欢迎Star',	NULL,	'',	NULL,	NULL,	NULL,	5,	'',	'',	'',	'',	0);

DROP TABLE IF EXISTS `tb_nav_cat`;
CREATE TABLE `tb_nav_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `listorder` int(11) DEFAULT NULL,
  `alias` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_nav_cat` (`id`, `title`, `listorder`, `alias`) VALUES
(3,	'友情链接',	0,	'friend_links'),
(5,	'温馨通道',	NULL,	'quick');

DROP TABLE IF EXISTS `tb_pinyin`;
CREATE TABLE `tb_pinyin` (
  `py` char(1) NOT NULL,
  `begin` smallint(5) unsigned NOT NULL,
  `end` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`py`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tb_pinyin` (`py`, `begin`, `end`) VALUES
('A',	45217,	45252),
('B',	45253,	45760),
('C',	45761,	46317),
('D',	46318,	46825),
('E',	46826,	47009),
('F',	47010,	47296),
('G',	47297,	47613),
('H',	47614,	48118),
('J',	48119,	49061),
('K',	49062,	49323),
('L',	49324,	49895),
('M',	49896,	50370),
('N',	50371,	50613),
('O',	50614,	50621),
('P',	50622,	50905),
('Q',	50906,	51386),
('R',	51387,	51445),
('S',	51446,	52217),
('T',	52218,	52697),
('W',	52698,	52979),
('X',	52980,	53640),
('Y',	53689,	54480),
('Z',	54481,	55289);

DROP TABLE IF EXISTS `tb_system_route`;
CREATE TABLE `tb_system_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `full_url` varchar(255) NOT NULL COMMENT '完整url， 如：portal/list/index?id=1',
  `url` varchar(255) NOT NULL COMMENT '实际显示的url',
  `listorder` int(5) NOT NULL DEFAULT '0' COMMENT '排序--优先级，越小优先级越高',
  `type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='URL路由';


DROP TABLE IF EXISTS `tb_system_user`;
CREATE TABLE `tb_system_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL,
  `nickname` varchar(55) NOT NULL,
  `sex` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='后台用户';

INSERT INTO `tb_system_user` (`id`, `account`, `password`, `nickname`, `sex`, `create_time`, `update_time`) VALUES
(1,	'superadmin',	'nariims',	'超级管理员',	1,	1558924947,	1558924947);

DROP TABLE IF EXISTS `tb_test`;
CREATE TABLE `tb_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_test` (`id`, `title`) VALUES
(1,	'aa'),
(2,	'bb'),
(3,	'cc');

DROP TABLE IF EXISTS `tb_thread`;
CREATE TABLE `tb_thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  `content` text NOT NULL,
  `cid` int(11) NOT NULL COMMENT '所属栏目',
  `points` int(11) NOT NULL COMMENT '悬赏积分',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态 1精华',
  `recommend` int(11) NOT NULL DEFAULT '0' COMMENT '推荐',
  `top` int(11) NOT NULL DEFAULT '0' COMMENT '置顶',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `hits_zan` int(11) DEFAULT '0',
  `hits_comment` int(11) DEFAULT '0',
  `hits_wish` int(11) DEFAULT '0',
  `hits` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='帖子';

INSERT INTO `tb_thread` (`id`, `title`, `content`, `cid`, `points`, `status`, `recommend`, `top`, `create_time`, `update_time`, `delete_time`, `member_id`, `hits_zan`, `hits_comment`, `hits_wish`, `hits`) VALUES
(25,	'为什么地球是圆的？',	'fdsfa',	12,	20,	0,	0,	0,	1576638283,	1576638283,	NULL,	4,	0,	2,	0,	0),
(21,	'谁会这个系统 的开发？？',	'谁会这个系统fsdafasdfasd',	13,	30,	0,	0,	0,	1576578254,	1576638560,	NULL,	2,	0,	0,	0,	0),
(22,	'谁会这个系统 的开发？？',	'谁会这个系统 的开发？？谁会这个系统 的开发？？谁会这个系统 的开发？？谁会这个系统 的开发？？',	13,	20,	1,	0,	0,	1576585067,	1576585067,	NULL,	2,	0,	0,	0,	0),
(23,	'国内这18条自驾路线，条条惊艳无比！有生之年，一定要走完！ ',	'网上的自驾路线多得眼花缭乱，不知道如何选适合自己的？\n\nimg[http://5b0988e595225.cdn.sohucs.com/images/20180715/24c14cb581bc440d81f003105fec82b7.gif] \n\n今天小编给大家带来了这18条自驾路线，对比一下，看下你最爱哪条，在2018年，走起！\n\n\n\n',	13,	20,	1,	1,	0,	1576631620,	1576631620,	NULL,	3,	0,	0,	0,	0),
(24,	'基于 layui 的极简社区页面模版',	'基于 layui 的极简社区页面模版基于 layui 的极简社区页面模版基于 layui 的极简社区页面模版基于 layui 的极简社区页面模版',	13,	20,	1,	0,	0,	1576637575,	1576637575,	NULL,	4,	0,	11,	0,	0),
(26,	'美国最新有哪些电影可以看看看',	'美国最新有哪些电影可以看看看美国最新有哪些电影可以看看看',	12,	20,	0,	0,	0,	1576649113,	1576649113,	NULL,	2,	0,	0,	0,	0),
(27,	'教育部公布“双高计划”学校名单 197所高职院校入选',	'中国网12月18日讯 教育部、财政部今日正式公布中国特色高水平高职学校和高水平专业建设计划名单，简称“双高计划”，这是继我国普通高等教育“双一流”后，国家在职业教育领域的一次重要制度设计。\n\n共有197所高职学校入选此批次“双高计划”，其中，56所高职学校入选高水平学校建设，141所高职学校入选高水平专业群建设。“双高计划”目的是支持基础条件良好的高职院校和专业优先发展，引领职业教育服务国家战略、融入区域发展、促进产业升级，最终打造一批当地离不开、业内都认同、国际可交流的职业教育“样板房”。\n\n据了解，此次“双高计划”建设每五年一个支持周期，每年将投入20余亿，五年后，将进行考核，实现有进有出、优胜劣汰。 资金将重点投入在教学改革、课程标准研发、教师队伍建设等方面，实现职业教育整体内涵的提升。\n\n此外，“双高计划”还给出了与国家职业教育改革、中国教育现代化对标的时间表，提出到2022年，一批高职学校和专业群办学水平、服务能力、国际影响显著提升，形成一批有效支撑职业教育高质量发展的政策、制度、标准；到2035年，一批高职学校和专业群达到国际先进水平，职业教育高质量发展的政策、制度、标准体系更加成熟完善，形成中国特色职业教育发展模式。',	12,	20,	0,	0,	0,	1576653476,	1576653476,	NULL,	2,	0,	3,	0,	0),
(28,	'dfsdaf',	'img[http://5b0988e595225.cdn.sohucs.com/images/20180715/24c14cb581bc440d81f003105fec82b7.gif] \n\nFDSA\nface[偷笑]  a(http://www.baidu.com)[http://www.baidu.com] [hr]',	12,	20,	0,	0,	0,	1576653881,	1576653881,	NULL,	2,	0,	0,	0,	0),
(29,	'FD',	'',	12,	20,	0,	0,	0,	1576659715,	1576659715,	NULL,	2,	0,	1,	0,	0),
(30,	'dd',	'ddd',	13,	20,	0,	0,	0,	1576666061,	1576666061,	NULL,	2,	0,	1,	0,	0),
(31,	'sss',	'ss',	14,	20,	0,	0,	0,	1576668697,	1576668697,	NULL,	5,	0,	1,	0,	0),
(32,	'fsdf',	'fdsafsad',	13,	20,	0,	0,	0,	1576672009,	1576672009,	NULL,	5,	0,	0,	0,	0),
(33,	'13名矿工被困80多小时后获救生',	'　　本报成都12月18日电  （记者王明峰）“救出来了！救出来了！”18日7时56分，守候在杉木树煤矿井口救援现场的人群中响起阵阵掌声。经过80多个小时的紧张救援，四川川煤集团杉木树煤矿透水事故中13名被困人员全部安全升井，并被迅速送往附近医院接受治疗。\n\n　　14日15时26分，位于宜宾市珙县的川煤集团芙蓉公司杉木树煤矿发生透水事故，造成5人遇难、13人失联。事故发生后，四川省委、省政府高度重视，省政府主要负责人到现场组织救援。应急管理部也派出工作组赴现场指导。专业救援队伍奔赴营救现场，救援人员分梯队轮流进入井下开展搜寻、排水、清淤、通风等工作。',	12,	20,	0,	0,	0,	1576723779,	1576723779,	NULL,	2,	0,	3,	0,	0),
(34,	'可以改进搜索功能,搜索框输',	'可以改进搜索功能,搜索框输可以改进搜索功能,搜索框输可以改进搜索功能,搜索框输可以改进搜索功能,搜索框输\nimg[/phpFly/public/uploads/20191221\\27a563a0c2cbd44cf0243121a2f18e03.jpg] ',	13,	20,	1,	0,	1,	1576738296,	1576900085,	NULL,	7,	0,	5,	0,	0),
(35,	'11',	'11',	12,	20,	0,	0,	0,	1576813630,	1576813630,	NULL,	5,	0,	0,	0,	0),
(36,	'分享的帖子。。 不是管理员哦。。',	'ddd',	13,	20,	0,	1,	0,	1576831034,	1576831034,	NULL,	6,	0,	1,	0,	0),
(37,	'百度',	'img[https://www.baidu.com/img/bd_logo1.png?wherxxe=super] ',	12,	20,	0,	0,	0,	1576838255,	1576838255,	1576838878,	6,	0,	1,	0,	0),
(38,	'ss',	'sss',	13,	20,	0,	0,	0,	1576855492,	1576855492,	NULL,	6,	0,	0,	0,	0),
(39,	'xx',	'xx',	13,	20,	0,	0,	0,	1576855710,	1576855710,	NULL,	2,	0,	0,	0,	0),
(40,	'xx',	'fsdaf',	16,	20,	0,	0,	0,	1576858474,	1576858474,	NULL,	7,	0,	0,	0,	0),
(41,	'精致旗袍性感美女图片',	'精致旗袍性感美女图片 精致旗袍 美女旗袍 精致 性感 旗袍 美女 精致美女 旗袍美女 性感美女 性感精致旗袍性感美女图片 精致旗袍 美女旗袍 精致 性感 旗袍 美女 精致美女 旗袍美女 性感美女 性感精致旗袍性感美女图片 精致旗袍 美女旗袍 精致 性感 旗袍 美女 精致美女 旗袍美女 性感美女 性感',	13,	20,	1,	0,	0,	1576859117,	1576859117,	NULL,	7,	0,	0,	0,	0),
(43,	'xxx',	'img[/phpFly/public/uploads/20191221\\843c4e483612dd0ec1948b3db53f1e2f.jpg] ',	14,	20,	0,	0,	0,	1576899992,	1576899992,	NULL,	7,	0,	1,	0,	0),
(44,	'美女',	'img[/phpFly/public/uploads/20191222\\03a91ec7c6cd1c46a2e75ab61544e1c1.jpg] ',	17,	20,	0,	0,	0,	1577004464,	1577004464,	NULL,	7,	0,	0,	0,	0),
(45,	'美女',	'img[/phpFly/public/uploads/20191222\\daa858747be50f0cd0e6828c00c83e68.jpg] ',	17,	20,	0,	0,	0,	1577004486,	1577004486,	NULL,	7,	0,	0,	0,	0),
(46,	'美女',	'img[/phpFly/public/uploads/20191222\\55be524e4a808ab648f0f7a98b8747ff.jpg] ',	17,	20,	0,	0,	0,	1577004504,	1577004504,	NULL,	7,	0,	1,	0,	0);

DROP TABLE IF EXISTS `tb_thread_column`;
CREATE TABLE `tb_thread_column` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  `alias` varchar(55) NOT NULL,
  `publish_type` int(11) NOT NULL DEFAULT '0' COMMENT '发贴权限',
  `join_type` int(11) NOT NULL DEFAULT '0' COMMENT '进入权限',
  `vip_limit` int(11) NOT NULL DEFAULT '0' COMMENT '进入权限(vip级别)',
  `points_limit` int(11) NOT NULL DEFAULT '0' COMMENT '进入权限(积分值)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='论坛栏目';

INSERT INTO `tb_thread_column` (`id`, `title`, `alias`, `publish_type`, `join_type`, `vip_limit`, `points_limit`) VALUES
(12,	'提问',	'question',	0,	0,	0,	0),
(13,	'分享',	'share',	0,	0,	0,	0),
(14,	'讨论',	'discuss',	0,	0,	0,	0),
(15,	'建议',	'suggest',	0,	0,	0,	0),
(16,	'公告',	'notice',	0,	2,	1,	5),
(17,	'美女',	'prettily-girl',	0,	1,	1,	10);

DROP TABLE IF EXISTS `tb_thread_column_member`;
CREATE TABLE `tb_thread_column_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_thread_column_member` (`id`, `member_id`, `column_id`, `create_time`) VALUES
(7,	7,	13,	1576738192);

DROP TABLE IF EXISTS `tb_thread_comment`;
CREATE TABLE `tb_thread_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
  `create_time` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `is_take` int(1) NOT NULL DEFAULT '0' COMMENT '是否被采纳',
  `hits_zan` int(11) NOT NULL DEFAULT '0' COMMENT '赞数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='帖子回复';

INSERT INTO `tb_thread_comment` (`id`, `content`, `create_time`, `member_id`, `thread_id`, `is_take`, `hits_zan`) VALUES
(1,	'不错不错',	1576636478,	3,	23,	0,	0),
(2,	'霜期',	1576636514,	3,	23,	0,	0),
(3,	'最后来的人',	1576636965,	3,	23,	0,	0),
(4,	'。。。。',	1576637717,	4,	23,	0,	0),
(5,	'fsda',	1576638343,	4,	25,	0,	0),
(6,	'fdsafasd',	1576638366,	3,	25,	0,	0),
(7,	'fds',	1576638663,	2,	24,	0,	0),
(8,	'魂牵梦萦f',	1576644754,	2,	24,	0,	0),
(9,	'aaa',	1576644857,	2,	24,	0,	0),
(10,	'fdsa',	1576645675,	2,	25,	0,	0),
(11,	'fds',	1576645680,	2,	25,	0,	0),
(12,	'eee',	1576663627,	2,	24,	0,	0),
(13,	'fsda',	1576663669,	2,	27,	0,	0),
(14,	'face[嘻嘻] ',	1576663701,	2,	27,	0,	0),
(15,	'fdsaf',	1576666049,	2,	29,	0,	0),
(16,	'eee',	1576666321,	2,	30,	0,	0),
(17,	' 这个方案出台后感觉不错啊',	1576670776,	5,	27,	0,	0),
(18,	'女vvvvv',	1576671158,	5,	31,	0,	0),
(19,	'face[嘻嘻] ',	1576718601,	5,	24,	0,	0),
(20,	'fsdaf',	1576718610,	5,	24,	0,	0),
(21,	'gsdafsda',	1576718616,	5,	24,	0,	0),
(22,	'eee',	1576718621,	5,	24,	0,	0),
(23,	'xxxx',	1576718626,	5,	24,	0,	0),
(24,	'eeeee',	1576718634,	5,	24,	0,	0),
(25,	'vvvv',	1576718639,	5,	24,	0,	0),
(26,	'sss',	1576718648,	5,	24,	0,	0),
(27,	'fsdf',	1576723791,	2,	33,	0,	0),
(28,	'vv',	1576723797,	2,	33,	0,	0),
(30,	'@我的中国2 ',	1576770386,	7,	33,	0,	0),
(33,	'eee',	1576810659,	5,	34,	0,	0),
(32,	'ddd',	1576772425,	7,	34,	0,	1),
(34,	'666',	1576831224,	8,	36,	0,	0),
(35,	'img[https://www.baidu.com/img/bd_logo1.png?where=super] ',	1576838228,	6,	34,	0,	0),
(36,	'img[https://www.baidu.com/img/bd_logo1.png?wherxxe=super] ',	1576838431,	6,	37,	0,	0),
(37,	'NB 啊face[嘻嘻] ',	1576859869,	7,	42,	0,	0),
(38,	'img[/phpFly/public/uploads/20191221\\83e440e17995fa5eb159dfa6ad6b167c.jpg] ',	1576900009,	7,	43,	0,	0),
(39,	'美女1face[嘻嘻] ',	1577004521,	7,	46,	0,	1);

DROP TABLE IF EXISTS `tb_thread_comment_hits_zan`;
CREATE TABLE `tb_thread_comment_hits_zan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `thread_comment_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_thread_comment_hits_zan` (`id`, `member_id`, `thread_comment_id`, `create_time`) VALUES
(15,	7,	39,	1577004526),
(12,	5,	33,	1576810666),
(14,	7,	32,	1576985703);

DROP TABLE IF EXISTS `tb_thread_hits_comment`;
CREATE TABLE `tb_thread_hits_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `tb_thread_hits_wish`;
CREATE TABLE `tb_thread_hits_wish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `tb_thread_hits_zan`;
CREATE TABLE `tb_thread_hits_zan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


-- 2019-12-22 11:50:05
