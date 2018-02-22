<?php

// +----------------------------------------------------------------------
// | 微信管理模块配置
// +----------------------------------------------------------------------

return array(
	//模块名称
	'modulename' => '微信管理',
	//图标
	'icon' => 'https://dn-coding-net-production-pp.qbox.me/e57af720-f26c-4f3b-90b9-88241b680b7b.png',
	//模块简介
	'introduce' => '微信授权登录，api调用',
	//模块介绍地址
	'address' => 'http://doc.ztbcms.com/module/wechat/',
	//模块作者
	'author' => 'zhlhuang',
	//作者地址
	'authorsite' => 'http://github.com/zhlhuang',
	//作者邮箱
	'authoremail' => 'zhlhuang888@foxmail.com',
	//版本号，请不要带除数字外的其他字符
	'version' => '3.0.3.3',
	//适配最低ZtbFCMS版本，
	'adaptation' => '3.0.0.0',
	//签名
	'sign' => '1aadbcb060ccb23cea16e886b9de7f57',
	//依赖模块
	'depend' => array(
		'Member'
	),
	//行为注册
	'tags' => array(),
	//缓存，格式：缓存key=>array('module','model','action')
	'cache' => array(),
);
