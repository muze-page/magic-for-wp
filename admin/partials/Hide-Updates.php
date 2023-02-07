<?php
//屏蔽指定插件更新提示

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