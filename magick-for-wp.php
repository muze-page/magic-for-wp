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
//require_once dirname( __FILE__ ) . '/admin/ACF_Congif.php';

//载入后台相关设置选项
require_once dirname( __FILE__ ) . '/includes/ad_admin.php';

//打印变量用

function p( $data ) {
    echo '<pre>';
    print_r( $data );
    echo '</pre>';
}

//add_action( 'all', 'test_top' );

function test_top() {
    //$add_content = '<h1>'.p( test ).'</h1>';
    $add_content = '1';
    echo $add_content;
}
;

//插件
//define() 函数定义一个常量。
$a = get_stylesheet_uri();
define( 'test', $a );

