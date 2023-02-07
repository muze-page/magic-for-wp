<?php
//载入后台用文件

//发文统计
require_once dirname( __FILE__ ) . '/partials/census.php';

//屏蔽插件更新提示
require_once dirname( __FILE__ ) . '/partials/Hide-Updates.php';



//统计文章后台添加echarts.js文件

function magick_load_echarts( $hook ) {
    if ( 'toplevel_page_wporg' != $hook ) {
        return;
    }

    wp_enqueue_script( 'echarts', plugin_dir_url( __DIR__ )  . 'assets/js/echarts_v5.4.0.js', array(), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'magick_load_echarts' );