<?php

//载入设置文件
require_once dirname( __FILE__ ) . '/partials/magick_ad_seting.php';

//载入发文统计
require_once dirname( __FILE__ ) . '/partials/census.php';

//统计文章后台添加echarts.js文件
function magick_load_echarts( $hook ) {
    if ( 'toplevel_page_wporg' != $hook ) {
        return;
    }

    wp_enqueue_script( 'echarts', plugin_dir_url( __FILE__ ) . 'js/echarts_v5.4.0.js', array(), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'magick_load_echarts' );