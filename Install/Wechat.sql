CREATE TABLE `cms_wechat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `subscribe` tinyint(1) NOT NULL COMMENT '是否关注',
  `sex` int(11) NOT NULL COMMENT '性别',
  `openid` varchar(64) NOT NULL DEFAULT '' COMMENT 'openid',
  `city` varchar(128) NOT NULL DEFAULT '' COMMENT '所属城市',
  `province` varchar(128) NOT NULL DEFAULT '' COMMENT '所属城市',
  `country` varchar(128) NOT NULL DEFAULT '' COMMENT '所属国家',
  `headimgurl` varchar(512) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `language` varchar(32) NOT NULL DEFAULT '' COMMENT '所用语言',
  `subscribe_time` int(11) NOT NULL COMMENT '关注事件',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `privilege` varchar(255) NOT NULL DEFAULT '' COMMENT '特权信息',
  `open_app_id` varchar(255) NOT NULL DEFAULT '' COMMENT '开放平台app_id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE `cms_wechat_app` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `wx_app_id` varchar(256) NOT NULL DEFAULT '' COMMENT '微信公众号平台app_id',
  `wx_secret_key` varchar(256) NOT NULL DEFAULT '' COMMENT '微信公众号平台密钥',
  `open_app_id` varchar(256) NOT NULL DEFAULT '' COMMENT '开放平台app_id',
  `open_secret_key` varchar(256) NOT NULL DEFAULT '' COMMENT '开放平台密钥secret_key',
  `open_alias` varchar(256) NOT NULL DEFAULT '' COMMENT '开放平台的别名',
  `default` tinyint(11) NOT NULL DEFAULT '0' COMMENT '是否默认 0否，1是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;