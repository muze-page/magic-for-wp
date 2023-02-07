<?php
/*
Plugin Name: WordPress 的魔法插件
Plugin URI: https://dongbd.com/
Description: 控制您站点的广告位
Version: 1.6.0
Author: Muze
Author URI: https://www.npc.ink/276641.html
*/

//载入ACF用的设置文件
//require_once dirname( __FILE__ ) . '/admin/partials/magick_ad_seting.php';




//载入后台相关设置选项
require_once dirname( __FILE__ ) . '/includes/magick_ad_admin.php';


//载入测试类
//核心类
require_once dirname( __FILE__ ) . '/includes/class_magick_ad.php';

//全局广告类
require_once dirname( __FILE__ ) . '/includes/class_magick_ad_all.php';

//指定广告类
require_once dirname( __FILE__ ) . '/includes/class_magick_ad_appoint.php';




//载入功能模块
require_once dirname( __FILE__ ) . '/block/acf_block.php';



////（可选）隐藏ACF管理菜单项。
//add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
function my_acf_settings_show_admin( $show_admin ) {
    return false;
}


//显示菜单选项
//https://www.advancedcustomfields.com/resources/options-page/
if( function_exists('acf_add_options_page') ) {
    
    //acf_add_options_page();
acf_add_options_page(array(
        'page_title'    => '自定义添加各种内容',
        'menu_title'    => '广告',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'post_id' => 'options',
        'icon_url' => 'dashicons-filter',
        'update_button' => __('保存'),
        'updated_message' => __("保存成功"),
    ));
    

    
}


/**前台加載 Dashicons 图标**/

add_action( 'wp_enqueue_scripts', function() {

wp_enqueue_style( 'dashicons' );

});






//打印变量用
function p($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}


//add_action( 'all', 'test_top' );
function test_top() {
	//$add_content = "<h1>".p( test )."</h1>";
	$add_content = "1";
	echo $add_content;
}
;


//插件
//define() 函数定义一个常量。
$a = get_stylesheet_uri();
define( 'test', $a );


//载入广告功能函数
//require_once dirname( __FILE__ ) . '/acf-ad.php';

//载入公共函数
//require_once dirname( __FILE__ ) . '/acf-public.php';

