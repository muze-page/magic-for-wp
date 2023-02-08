<?php

//载入广设置关
/*
*插件设置
*/
require_once dirname( __FILE__ ) . '/admin/Plugin_Seting.php';

//载入后台用文件

//载入推荐安装插件
require_once dirname( __FILE__ ) . '/admin/plugins/plugins.php';

//发文统计
require_once dirname( __FILE__ ) . '/admin/Census.php';

//插件配置信息
require_once dirname( __FILE__ ) . '/admin/Plugin-Config.php';

//载入广告相关

//核心类
require_once dirname( __FILE__ ) . '/ad/class-ad.php';

//全局广告类
require_once dirname( __FILE__ ) . '/ad/class_magick_ad_all.php';

//指定广告类
require_once dirname( __FILE__ ) . '/ad/class_magick_ad_appoint.php';

/*
*功能模块 - 弹窗
*/
require_once dirname( __FILE__ ) . '/ad/pop-up.php';

/*
*功能模块 - 全局两侧广告
*/
require_once dirname( __FILE__ ) . '/ad/both-sides.php';

/*
*广告模块 - 图片
*/
require_once dirname( __FILE__ ) . '/ad/block/images.php';

/*
*广告模块 - 轮播图
*/
require_once dirname( __FILE__ ) . '/ad/block/carousel.php';

