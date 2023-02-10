<?php
//这些并不是广告插件中应该有的文件，但基于实际工作需要，开发出的，必要时可独立

//添加二级菜单

// 这段代码是插件管理主菜单的创建函数
add_action( 'admin_menu', 'add_diy_menu' );

function add_diy_menu() {

    add_menu_page( __( '魔法菜单' ), __( '魔法菜单' ), 'administrator', 'magick-census-single', false, 'dashicons-visibility' );
    add_submenu_page( 'magick-census-single', __( '发文统计' ), __( '发文统计' ), 'administrator', 'magick-census-single', 'magick_census_single_content' );
    add_submenu_page( 'magick-census-single', __( '销售统计' ), __( '销售统计' ), 'administrator', 'magick-census-shop', 'magick_censcus_shop_content' );

    // submenu hook
    do_action( 'yjw_add_diy_submenu' );
}

//发文统计
require_once dirname( __FILE__ ) . '/census-single.php';
//销售统计
require_once dirname( __FILE__ ) . '/censcus-shop.php';

/**
* @internal 永远不要在回调中定义函数。
* 这些功能可以多次运行;
这将导致致命错误。
*/

/**
* 自定义选项和设置
*/

function test111( $args ) {

    ?>
    <div id = "<?php echo esc_attr( $args['id'] ); ?>">
    获取我们使用register_setting（）注册的设置的值
    <br />
    <span>
    <?php $options = get_option( 'wporg_options' );
    ?>
    您的选项是：<?php p( $options );
    ?>
    </span>
    您选中的药丸是：<?php echo $options[ 'wporg_field_pill' ] ?>
    </div>

    <?php
}

function wporg_settings_init() {
    //为“wporg”页面注册新设置。
    register_setting( 'wporg', 'wporg_options' );
    //注册一个选择选项框设置
    register_setting( 'wporg', 'wporg_options_choise' );

    // 在“wporg”页面中注册一个新部分。
    add_settings_section(
        'wporg_section_developers',
        __( '矩阵有你。', 'wporg' ), 'wporg_section_developers_callback',
        //__( '矩阵有你。', 'wporg' ), 'test111',
        'wporg'
    );

    add_settings_section(
        'eg_setting_section',
        __( '如何使用？：', 'textdomain' ),
        'test111',
        'wporg'
    );

    //在“wporg”页面内的“wporg_section_developers”部分注册一个新字段。
    add_settings_field(
        'wporg_field_pill', //从WP 4.6开始，该值仅在内部使用。
        //使用$args的label_for在回调中填充id。
        __( '药丸', 'wporg' ),
        'wporg_field_pill_cb',
        'wporg',
        'wporg_section_developers',
        array(
            'label_for'         => 'wporg_field_pill',
            'class'             => 'wporg_row',
            'wporg_custom_data' => 'custom',
        )
    );
}

/**
*将我们的wporg_settings_init注册到admin_init操作钩子。
*/
add_action( 'admin_init', 'wporg_settings_init' );

/**
*自定义选项和设置：
*-回调函数
*/

/**
* 开发者节回调函数。
*
* @param array $args  设置数组，定义标题、id和回调。
*/

function wporg_section_developers_callback( $args ) {
    ?>
    <p id = "<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( '跟着白兔。', 'wporg' );
    ?></p>
    <?php
}

/**
*药丸字段callbakc函数。
*
*WordPress具有以下键的神奇交互：label_for、class。
*-“label_for”键值用于<label>的“for”属性。
*-“class”键值用于包含字段的<tr>的“class”属性。
*注意：您可以添加自定义键值对，以便在回调中使用。
*
* @param array $args
*/

function wporg_field_pill_cb( $args ) {
    //获取我们使用register_setting（）注册的设置的值
    $options = get_option( 'wporg_options' );

    ?>

    <select
    id = "<?php echo esc_attr( $args['label_for'] ); ?>"
    
    name = "wporg_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
    <option value = 'red' <?php echo   selected( $options[ 'wporg_field_pill' ], 'red', false )  ;
    ?>>
    <?php esc_html_e( '红色药丸', 'wporg' );
    ?>
    </option>
    <option value = 'blue' <?php echo   selected( $options[ 'wporg_field_pill' ], 'blue', false )  ;
    ?>>
    <?php esc_html_e( '蓝色药丸', 'wporg' );
    ?>
    </option>
    </select>
    <p class = 'description'>
    <?php esc_html_e( '你吃了蓝色药丸，故事就结束了。你在床上醒来，你相信任何你想相信的。', 'wporg' );
    ?>
    </p>
    <p class = 'description'>
    <?php esc_html_e( '你吃了红色药丸，你留在仙境，我告诉你兔子洞有多深。', 'wporg' );
    ?>
    </p>
    测试下选项是否有用

    <?php

}

/**
*添加顶级菜单页。
*/

function wporg_options_pages() {
    add_menu_page(
        'WPOrg',
        '自定义选项',
        'manage_options',
        'wporgs',
        'wporg_options_page_htmls'
    );
}

/**
*将我们的wporg_options_page注册到admin_menu操作钩子。
*/
add_action( 'admin_menu', 'wporg_options_pages' );

/**
*顶级菜单回调函数
*/

function wporg_options_page_htmls() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    //添加错误/更新消息
    //检查用户是否已提交设置
    //WordPress将向url添加“设置更新”$_GET参数
    if ( isset( $_GET[ 'settings-updated' ] ) ) {
        // 添加“已更新”类的设置已保存邮件
        add_settings_error( 'wporg_messages', 'wporg_message', __( '选项保存了', 'wporg' ), 'updated' );
    }

    //显示错误/更新消息
    settings_errors( 'wporg_messages' );
    ?>
    <div class = 'wrap'>
    <h1><?php echo esc_html( get_admin_page_title() );
    ?></h1>
    <form action = 'options.php' method = 'post'>
    <?php
    // 已注册设置“wporg”的输出安全字段
    settings_fields( 'wporg' );
    //输出设置部分及其字段
    //（部分注册为“wporg”，每个字段注册到特定部分）
    do_settings_sections( 'wporg' );
    //输出保存设置按钮
    submit_button( '保存选项' );
    ?>
    </form>
    </div>
    <?php
}

//尝试添加一个开关