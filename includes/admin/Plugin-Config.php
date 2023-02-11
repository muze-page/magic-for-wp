<?php

//插件配置
/**
 * 插件设置信息
 * 屏蔽ACF插件更新
 * 载入相关资源
 */

//插件管理

//增加插件信息
add_filter('plugin_row_meta', function ($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $links[] = '<a target="_blank" href="https://www.npc.ink/276641.html">使用帮助</a>';
        $links[] = '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1355471563">联系QQ</a>';
    }
    return $links;
}, 10, 2);

//显示菜单
//显示菜单选项
//https://www.advancedcustomfields.com/resources/options-page/
if (function_exists('acf_add_options_page')) {

    //acf_add_options_page();
    acf_add_options_page(array(
        'page_title' => '魔法广告插件',
        'menu_title' => '广告',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
        'post_id' => 'options',
        'icon_url' => 'dashicons-filter',
        'update_button' => __('保存'),
        'updated_message' => __("保存成功"),
    ));

}

//屏蔽ACF Pro 插件更新提示
function wcr_remove_update_notifications($value)
{
    // 要屏蔽的插件位置 (在wp-content/plugins文件夹下)
    $plugins = array(
        'advanced-custom-fields-pro/acf.php',
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

//载入图标
/**前台加載 Dashicons**/

add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style('dashicons');

});
//载入样式
//载入所需VUE框架 - 顶部
function magick_load_vue()
{
    wp_enqueue_script('vue', plugin_dir_url(\dirname(__DIR__)) . 'assets/js/vue.global_v3.2.45.js', array(), '1.0.0', false);
}
//add_action( 'wp_enqueue_scripts', 'magick_load_vue' );

//起冲突就用这个
add_action('wp_head', 'magick_load_vues');
function magick_load_vues()
{
    $vue = plugin_dir_url(\dirname(__DIR__)) . 'assets/js/vue.global_v3.2.45.js';
    $add_content = '<script type="text/javascript" src=' . $vue . '></script>';
    echo $add_content;
}
;

//载入所需Elements Pro框架 - 顶部
function magick_load_elementsPro()
{
    wp_enqueue_style('elementsPro_style', plugin_dir_url(\dirname(__DIR__)) . 'assets/css/element-plus-v2.2.25.css', array(), '1.0.0', false);
    wp_enqueue_script('elementsPro_javascript', plugin_dir_url(\dirname(__DIR__)) . 'assets/js/element-plus_v2.2.25.js', array(), '1.0.0', false);
}
add_action('wp_enqueue_scripts', 'magick_load_elementsPro');

//载入插件所需用的样式

function magick_load_style()
{
    wp_enqueue_style('style', plugin_dir_url(\dirname(__DIR__)) . 'assets/css/style.css', array(), '1.0.0', false);
}
add_action('wp_enqueue_scripts', 'magick_load_style');
