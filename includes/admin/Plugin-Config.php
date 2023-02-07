<?php

//插件配置
/**
 * 插件设置信息
 * 屏蔽ACF插件更新
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