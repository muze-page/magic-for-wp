<?php

//插件配置
/**
 * 插件设置信息
 * 屏蔽ACF插件更新
 * 载入相关资源
*/

//插件管理
 //设置按钮
 add_filter('plugin_action_links_'.plugin_basename(__FILE__), function($links){
    $links[] = '<a href="'.get_admin_url(null, 'admin.php?page=theme-general-settings') . '">' . __('设置','n') . '</a>';
    return $links;
});


 //增加插件信息
add_filter('plugin_row_meta',function($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $links[] = '<a target="_blank" href="https://www.npc.ink/276641.html">使用帮助</a>';
        $links[] = '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1355471563">联系QQ</a>';
    }
    return $links;
}, 10, 2);



//屏蔽ACF Pro 插件更新提示
function wcr_remove_update_notifications($value) {
    // 要屏蔽的插件位置 (在wp-content/plugins文件夹下)
    $plugins = array(
    'advanced-custom-fields-pro/acf.php'
    );
    foreach ($plugins as $key => $plugin) {
    if (empty($value->response[$plugin])) {
    continue;
    }
    unset($value->response[$plugin]);
    }
    return $value;
    }
    add_filter('site_transient_update_plugins', 'wcr_remove_update_notifications');


    //载入样式
//载入所需VUE框架 - 顶部
function magick_load_vue() {
    wp_enqueue_script( 'vue',  plugin_dir_url(\dirname(__DIR__)). 'assets/js/vue.global_v3.2.45.js', array(), '1.0.0', false );
}
add_action( 'wp_enqueue_scripts', 'magick_load_vue' );


//载入所需Elements Pro框架 - 顶部
function magick_load_elementsPro() {
    wp_enqueue_style( 'elementsPro_style',  plugin_dir_url(\dirname(__DIR__)). 'assets/css/element-plus-v2.2.25.css', array(), '1.0.0', false );
    wp_enqueue_script( 'elementsPro_javascript',  plugin_dir_url(\dirname(__DIR__)). 'assets/js/element-plus_v2.2.25.js', array(), '1.0.0', false );
}
add_action( 'wp_enqueue_scripts', 'magick_load_elementsPro' );

//载入插件所需用的样式

function magick_load_style() {
    wp_enqueue_style( 'style',  plugin_dir_url(\dirname(__DIR__)). 'assets/css/style.css', array(), '1.0.0', false );
}
add_action( 'wp_enqueue_scripts', 'magick_load_style' );