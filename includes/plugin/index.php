<?php
//这些并不是广告插件中应该有的文件，但基于实际工作需要，开发出的，必要时可独立

//发文统计
require_once dirname(__FILE__) . '/census-single.php';
//销售统计
//require_once dirname(__FILE__) . '/censcus-shop.php';

//添加二级菜单

// 这段代码是插件管理主菜单的创建函数
add_action('admin_menu', 'add_diy_menu');

function add_diy_menu()
{

    add_menu_page(__('统计菜单'), __('统计菜单'), 'administrator', 'magick-census-single', false, 'dashicons-visibility');
    add_submenu_page('magick-census-single', __('发文统计'), __('发文统计'), 'administrator', 'magick-census-single', 'magick_census_single_content');
    //add_submenu_page('magick-census-single', __('销售统计'), __('销售统计'), 'administrator', 'magick-census-shop', 'magick_censcus_shop_content');

    // submenu hook
    do_action('add_diy_submenu');
}

/**
 * @internal 永远不要在回调中定义函数。
 * 这些功能可以多次运行;
这将导致致命错误。
 */

/**
 * 自定义选项和设置
 */

function test111($args)
{

    ?>
    <div id = "<?php echo esc_attr($args['id']); ?>">
    获取我们使用register_setting（）注册的设置的值
    <br />
    <span>
    <?php $options = get_option('wporg_options');
    ?>
    您的选项是：<?php p($options);
    ?>
    </span>
    您选中的药丸是：<?php echo $options['wporg_field_pill'] ?>
    </div>

    <?php
}

function wporg_settings_init()
{
    //为“wporg”页面注册新设置。
    register_setting('wporg', 'wporg_options');
    //注册一个选择选项框设置
    register_setting('wporg', 'wporg_options_choise');

    // 在“wporg”页面中注册一个新部分。
    add_settings_section(
        'wporg_section_developers',
        __('矩阵有你。', 'wporg'), 'wporg_section_developers_callback',
        //__( '矩阵有你。', 'wporg' ), 'test111',
        'wporg'
    );

    add_settings_section(
        'eg_setting_section',
        __('如何使用？：', 'textdomain'),
        'test111',
        'wporg'
    );

    //在“wporg”页面内的“wporg_section_developers”部分注册一个新字段。
    add_settings_field(
        'wporg_field_pill', //从WP 4.6开始，该值仅在内部使用。
        //使用$args的label_for在回调中填充id。
        __('药丸', 'wporg'),
        'wporg_field_pill_cb',
        'wporg',
        'wporg_section_developers',
        array(
            'label_for' => 'wporg_field_pill',
            'class' => 'wporg_row',
            'wporg_custom_data' => 'custom',
        )
    );
}

/**
 *将我们的wporg_settings_init注册到admin_init操作钩子。
 */
add_action('admin_init', 'wporg_settings_init');

/**
 *自定义选项和设置：
 *-回调函数
 */

/**
 * 开发者节回调函数。
 *
 * @param array $args  设置数组，定义标题、id和回调。
 */

function wporg_section_developers_callback($args)
{
    ?>
    <p id = "<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('跟着白兔。', 'wporg');
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

function wporg_field_pill_cb($args)
{
    //获取我们使用register_setting（）注册的设置的值
    $options = get_option('wporg_options');

    ?>

    <select
    id = "<?php echo esc_attr($args['label_for']); ?>"

    name = "wporg_options[<?php echo esc_attr($args['label_for']); ?>]">
    <option value = 'red' <?php echo selected($options['wporg_field_pill'], 'red', false);
    ?>>
    <?php esc_html_e('红色药丸', 'wporg');
    ?>
    </option>
    <option value = 'blue' <?php echo selected($options['wporg_field_pill'], 'blue', false);
    ?>>
    <?php esc_html_e('蓝色药丸', 'wporg');
    ?>
    </option>
    </select>
    <p class = 'description'>
    <?php esc_html_e('你吃了蓝色药丸，故事就结束了。你在床上醒来，你相信任何你想相信的。', 'wporg');
    ?>
    </p>
    <p class = 'description'>
    <?php esc_html_e('你吃了红色药丸，你留在仙境，我告诉你兔子洞有多深。', 'wporg');
    ?>
    </p>
    测试下选项是否有用

    <?php

}

/**
 *添加顶级菜单页。
 */

function wporg_options_pages()
{
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
add_action('admin_menu', 'wporg_options_pages');

/**
 *顶级菜单回调函数
 */

function wporg_options_page_htmls()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    //添加错误/更新消息
    //检查用户是否已提交设置
    //WordPress将向url添加“设置更新”$_GET参数
    if (isset($_GET['settings-updated'])) {
        // 添加“已更新”类的设置已保存邮件
        add_settings_error('wporg_messages', 'wporg_message', __('选项保存了', 'wporg'), 'updated');
    }

    //显示错误/更新消息
    settings_errors('wporg_messages');
    ?>
    <div class = 'wrap'>
    <h1><?php echo esc_html(get_admin_page_title());
    ?></h1>
    <form action = 'options.php' method = 'post'>
    <?php
// 已注册设置“wporg”的输出安全字段
    settings_fields('wporg');
    //输出设置部分及其字段
    //（部分注册为“wporg”，每个字段注册到特定部分）
    do_settings_sections('wporg');
    //输出保存设置按钮
    submit_button('保存选项');
    ?>
    </form>
    </div>
    <?php
}

//尝试添加一个开关

//研究下
//添加一个多选复选框

//注册一个设置
add_action('admin_init', 'magick_plugin_options');
function magick_plugin_options()
{
    // 首先，我们注册一个部分。这是必要的，因为所有未来的选项都必须属于一个。
    add_settings_section(
        'magick_settings_section', // 用于标识此部分以及用于注册选项的ID
        '自定义设置', // 要在管理页面上显示的标题
        'magick_plugin_options_callback', // 用于呈现节描述的回调
        'general' // 添加此部分选项的页面
    );

    //添加一个下拉框选项
    add_settings_field(
        'option_id', // 用于标识整个主题中的字段的ID
        '选择', // 选项接口元素左侧的标签
        'magick_option_callback', // 负责呈现选项界面的函数的名称
        'general', // 将显示此选项的页面
        'magick_settings_section', // 此字段所属的节的名称
        array( // 要传递给回调的参数数组。在这种情况下，只是一个描述。
            '开始您的选择',
        )
    );

    //注册这个设置
    register_setting(
        'general', //选项组
        'magick_plugin_config', //选项名称,存储选项用
    );
} //结束magick_plugin_options
/* ------------------------------------------------------------------------ *
 *节回调
 * ------------------------------------------------------------------------ */
/**
 *此函数为“常规选项”页面提供简单说明。
 *
 *它是通过作为参数传递从“magick_plugin_options”函数调用的
 *在add_settings_section函数中。
 */
function magick_plugin_options_callback()
{
    //拿到选项
    $options = get_option('magick_plugin_config');
    if ($options) {
        echo "您选择的是：" . implode(',', $options['option_id']);
        return;
    } else {
        echo "您没有选择值";
        return;
    }
} //结束magick_plugin_options_callback

//链接输入框设置的回调
function magick_option_callback($args)
{

    // 首先，我们拿到选项
    $options = get_option('magick_plugin_config');

    $uwcc_checkbox_field_1 = isset($options['option_id']) ? (array) $options['option_id'] : [];
    //name值很关键
    ?>

    <input type='checkbox' name='magick_plugin_config[option_id][]' <?php checked(in_array('Mastercard', $uwcc_checkbox_field_1), 1);?> value='Mastercard'>
    <label>Mastercard</label>
    <input type='checkbox' name='magick_plugin_config[option_id][]' <?php checked(in_array('Visa', $uwcc_checkbox_field_1), 1);?> value='Visa'>
    <label>Visa</label>
    <input type='checkbox' name='magick_plugin_config[option_id][]' <?php checked(in_array('Amex', $uwcc_checkbox_field_1), 1);?> value='Amex'>
    <label>Amex</label>

    <label for="option_id"> <?php echo $args[0]; ?></label>

<?php

} // end magick_option_callback

/* ------------------------------------------------------------------------ *
 *设置注册
 * ------------------------------------------------------------------------ */
/**
 *通过注册节来初始化主题选项页，
 *字段和设置。
 *
 *此函数使用“admin_init”钩子注册。
 */
add_action('admin_init', 'sandbox_initialize_theme_options');
function sandbox_initialize_theme_options()
{
    // 首先，我们注册一个部分。这是必要的，因为所有未来的选项都必须属于一个。
    add_settings_section(
        'general_settings_section', // 用于标识此部分以及用于注册选项的ID
        '显示选项', // 要在管理页面上显示的标题
        'sandbox_general_options_callback', // 用于呈现节描述的回调
        'sandbox_theme_display_options' // 添加此部分选项的页面
    );

    //注册一个部分，用来显示效果
    add_settings_section(
        'general_settings_hcf',
        '使用选项',
        'option_test_hcf',
        'sandbox_theme_display_options',
    );

    //节
    // 接下来，我们将介绍用于切换内容元素可见性的字段。
    add_settings_field(
        'show_header', // 用于标识整个主题中的字段的ID
        '头部', // 选项接口元素左侧的标签
        'sandbox_toggle_header_callback', // 负责呈现选项界面的函数的名称
        'sandbox_theme_display_options', // 将显示此选项的页面
        'general_settings_section', // 此字段所属的节的名称
        array( // 要传递给回调的参数数组。在这种情况下，只是一个描述。
            '激活此设置以显示标题。',
        )
    );

    //第二个字段
    add_settings_field(
        'show_content',
        '内容',
        'sandbox_toggle_content_callback',
        'sandbox_theme_display_options',
        'general_settings_section',
        array(
            '激活此设置以显示内容。',
        )
    );

    //第三个字段
    add_settings_field(
        'show_footer',
        '底部',
        'sandbox_toggle_footer_callback',
        'sandbox_theme_display_options',
        'general_settings_section',
        array(
            '激活此设置以显示页脚。',
        )
    );

    // 最后，我们用WordPress注册这些字段
    register_setting(
        'sandbox_theme_display_options', //选项组
        'sandbox_theme_display_options' //选项名称
    );
} //结束sandbox_initialize_theme_options
/* ------------------------------------------------------------------------ *
 *节回调
 * ------------------------------------------------------------------------ */
/**
 *此函数为“常规选项”页面提供简单说明。
 *
 *它是通过作为参数传递从“sandbox_initialize_theme_options”函数调用的
 *在add_settings_section函数中。
 */
function sandbox_general_options_callback()
{
    echo '<p>选择要显示的内容区域。</p>';
} //结束sandbox_general_options_callback

/* ------------------------------------------------------------------------ *
 *字段回调
 * ------------------------------------------------------------------------ */

/**
 *此函数呈现用于切换头元素可见性的接口元素。
 *
 *它接受一个参数数组，并期望数组中的第一个元素是描述
 *将显示在复选框旁边。
 */
function sandbox_toggle_header_callback($args)
{

    // 首先，我们阅读选项集合
    $options = get_option('sandbox_theme_display_options');

    // 接下来，我们更新name属性以在display options数组的上下文中访问该元素的ID
    //在调用checked（）helper函数时，我们还访问了options集合的show_header元素
    $html = '<input type="checkbox" id="show_header" name="sandbox_theme_display_options[show_header]" value="1" ' . checked(1, $options['show_header'], false) . '/>';

    // 在这里，我们将获取数组的第一个参数，并将其添加到复选框旁边的标签中
    $html .= '<label for="show_header"> ' . $args[0] . '</label>';

    echo $html;
} // end sandbox_toggle_header_callback

//第二个设置回调函数
function sandbox_toggle_content_callback($args)
{
    $options = get_option('sandbox_theme_display_options');
    $html = '<input type="checkbox" id="show_content" name="sandbox_theme_display_options[show_content]" value="1" ' . checked(1, $options['show_content'], false) . '/>';
    $html .= '<label for="show_content"> ' . $args[0] . '</label>';
    echo $html;
} // end sandbox_toggle_content_callback

//第三个设置回调函数
function sandbox_toggle_footer_callback($args)
{

    $options = get_option('sandbox_theme_display_options');
    $html = '<input type="checkbox" id="show_footer" name="sandbox_theme_display_options[show_footer]" value="1" ' . checked(1, $options['show_footer'], false) . '/>';
    $html .= '<label for="show_footer"> ' . $args[0] . '</label>';
    echo $html;
} // end sandbox_toggle_footer_callback

//使用回调
function magick_option_test_switch($a = '')
{
    if ($a) {
        //有值
        echo "您选择了";
        return;
    } else {
        //无值
        echo "您没有选择";
        return;
    }
}
function option_test_hcf()
{
    $header = get_option('sandbox_theme_display_options')['show_header'];
    $content = get_option('sandbox_theme_display_options')['show_content'];
    $footer = get_option('sandbox_theme_display_options')['show_footer'];

    ?>

    您的首页：<?php magick_option_test_switch($header);?>
    <br />
    您的内容：<?php magick_option_test_switch($content);?>
    <br />
    您的底部：<?php magick_option_test_switch($footer);?>


<?php

}

//添加主题菜单
function sandbox_example_theme_menu()
{
    add_theme_page(
        '沙盒主题', // 要在此页面的浏览器窗口中显示的标题。
        '沙盒主题', // 要为此菜单项显示的文本
        'administrator', // 哪种类型的用户可以看到此菜单项
        'sandbox_theme_options', // The unique ID - that is, the slug - for this menu item
        'sandbox_theme_display' // 呈现此菜单的页面时要调用的函数的名称
    );
} // end sandbox_example_theme_menu
add_action('admin_menu', 'sandbox_example_theme_menu');

function sandbox_theme_display()
{
    ?>
            <!-- Create a header in the default WordPress 'wrap' container -->
            <div class="wrap">

                <div id="icon-themes" class="icon32"></div>
                <h2>Sandbox Theme Options</h2>
                <?php settings_errors();?>

                <?php
if (isset($_GET['tab'])) {
        $active_tab = $_GET['tab'];
    } // end if

    //设置默认值
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'display_options';
    ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=sandbox_theme_options&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>">Display Options</a>
                <a href="?page=sandbox_theme_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>">Social Options</a>
            </h2>



            <form method="post" action="options.php">
            <?php

    if ($active_tab == 'display_options') {
        settings_fields('sandbox_theme_display_options');
        do_settings_sections('sandbox_theme_display_options');
    } else {
        settings_fields('sandbox_theme_social_options');
        do_settings_sections('sandbox_theme_social_options');
    } // end if/else

    submit_button();

    ?>
        </form>

            </div><!-- /.wrap -->
        <?php
} // end sandbox_theme_display
