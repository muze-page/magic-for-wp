<?php
//载入推荐安装插件
require_once dirname( __FILE__ ) . '/admin/plugins/plugins.php';

//插件配置信息
require_once dirname( __FILE__ ) . '/admin/Plugin-Config.php';

//未安装ACF 插件的警告信息

function magick_admin_notice_acf() {
    ?>
    <div class = 'notice notice-error '>
    <p><?php _e( '请安装下方提示插件，或禁用WordPress 魔法广告插件', 'sample-text-domain' );
    ?></p>
    </div>
    <?php
}

//判断有没有安装ACF插件
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( !is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
    //没有安装
    add_action( 'admin_notices', 'magick_admin_notice_acf' );

} else {
    //已安装插件
    //载入广设置关
    /*
    *插件设置
    */
    require_once dirname( __FILE__ ) . '/admin/Plugin_Seting.php';

    //载入后台用文件

    //发文统计
    require_once dirname( __FILE__ ) . '/admin/Census.php';

    //载入广告相关

    //核心类
    require_once dirname( __FILE__ ) . '/ad/class-ad.php';

    //全局广告类
    require_once dirname( __FILE__ ) . '/ad/class_ad_all.php';

    //指定广告类
    require_once dirname( __FILE__ ) . '/ad/class_ad_appoint.php';

    /*
    *功能模块 - 弹窗
    */
    require_once dirname( __FILE__ ) . '/ad/pop-up.php';

    /*
    *功能模块 - 全局两侧广告
    */
    require_once dirname( __FILE__ ) . '/ad/both-sides.php';

    /*
    *功能模块 - 全局底部横栏广告
    */
    require_once dirname( __FILE__ ) . '/ad/bottom_bar.php';

    //广告模块
    /*
    *广告模块 - 图片
    */
    require_once dirname( __FILE__ ) . '/ad/block/images.php';

    /*
    *广告模块 - 轮播图
    */
    require_once dirname( __FILE__ ) . '/ad/block/carousel.php';

}