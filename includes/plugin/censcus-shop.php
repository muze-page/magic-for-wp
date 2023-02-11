<?php

//销售统计

function magick_censcus_shop_content()
{
    $MA_arr = new MA_control();
    //待发货数量
    $watit_deliver = $MA_arr->magick_get_shop_watit_deliver();
    //最近7天商城实物销售总额
    $actual_total_seven = $MA_arr->magick_get_shop_actual_total_seven();
    ?>
    <dl>
    <dt>商城待发货</dt>
    <dd><?php echo $watit_deliver; ?></dd>
    <dt>最近7天商城销售总额</dt>
    <dd><?php p($actual_total_seven);?></dd>
    <dt>待研究</dt>
    <dd><?php //echo p($tj_vip); ?></dd>
    <dt>对比</dt>
    <dd><?php //echo p($tj_vips); ?></dd>
</dl>
<?php

}
//拿到近7天，每天的
//总销售额（减退款）
//总订单数（减退款）
//总退款
//总退款订单

//创建数据获取类
class MA_control
{
    private $wpdb;
    private $time;

    //有构造方法的类在实例化对象后，对象自动调用
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->time = $this->tz_get_time();
    }

    //时间很重要
    public function tz_get_time()
    {
        date_default_timezone_set("Asia/Shanghai");
        $a = strtotime(date("Y-m-d H:i:s")); //当前时间戳
        $todaytime = strtotime("today"); //今日起始时间戳

        return array(
            'a' => array(
                date("Y-m-d H:i:s", $todaytime),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 1),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 2),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 3),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 4),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 5),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 6),
            ),
            'b' => array(
                date("Y-m-d H:i:s", $todaytime - 8 * 60 * 60),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 1 - 8 * 60 * 60),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 2 - 8 * 60 * 60),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 3 - 8 * 60 * 60),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 4 - 8 * 60 * 60),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 5 - 8 * 60 * 60),
                date("Y-m-d H:i:s", $todaytime - 24 * 60 * 60 * 6 - 8 * 60 * 60),
            ),
        );
    }

    //返回商城待发货订单
        //返回商城待发货订单
        public function magick_get_shop_watit_deliver()
        {
            $table_name = $this->wpdb->prefix . 'zrz_order';
            $num = $this->wpdb->get_var("SELECT COUNT(*) FROM $table_name where order_state='f'");
            return $num;
        }//end magick_get_shop_watit_deliver()

    //返回近七天，商城相关信息
    public function magick_get_shop_actual_total_seven()
    {
        $time = $this->time;
        $time = $time['a'];
        //拿到表格
        $table_name = $this->wpdb->prefix . 'zrz_order';
        //创建数组，存储数据
        $array = array();
        //最近七天，每天的总销售额（减退款）
        $total_sales;
        //最近七天，每天的总订单数（减退款）
        $total_order;
        //最近七天，每天的总退款
        $total_refund;
        //最近七天，每天的总退款订单数
        $total_refund_order;
        for ($i = 0; $i < 7; $i++) {
            $b = $i - 1;
            //判断条件
            if ($i == 0) {
                //总销售额
                $judge_first_a = "SELECT SUM(BINARY(order_total)) AS total FROM $table_name WHERE order_type = 'gx' and order_commodity = 1 and (order_state = 'c' or order_state = 'q') and order_date > '$time[0]'";
                //总订单数
                $judge_first_b = "SELECT COUNT(*)  FROM $table_name WHERE order_type = 'gx' and order_commodity = 1 and (order_state = 'c' or order_state = 'q') and order_date > '$time[0]'";

                //总退款
                $judge_first_c = "SELECT SUM(BINARY(order_total)) AS refund FROM $table_name WHERE order_type = 'gx' and order_commodity = 1 and order_state = 't'  and order_date > '$time[0]'";

                //总退款订单数
                $judge_first_d = "SELECT COUNT(*)  FROM $table_name WHERE order_type = 'gx' and order_commodity = 1 and  order_state = 't' and order_date > '$time[0]'";
                //第一天

                //总销售额
                $a = $this->wpdb->get_results($judge_first_a, ARRAY_A);

                //总订单数
                $b = $this->wpdb->get_var($judge_first_b);

                //总退款
                $c = $this->wpdb->get_results($judge_first_c, ARRAY_A);

                //总退款订单
                $d = $this->wpdb->get_var($judge_first_d);

            } else {
                //总销售额
                $judge_later_a = "SELECT SUM(BINARY(order_total)) AS total FROM $table_name WHERE order_type = 'gx' and order_commodity = 1 and (order_state = 'c' or order_state = 'q') and order_date > '$time[$i]' and order_date < '$time[$b]'";
                //总订单数
                $judge_later_b = "SELECT COUNT(*) FROM $table_name WHERE order_type = 'gx' and order_commodity = 1 and (order_state = 'c' or order_state = 'q') and order_date > '$time[$i]' and order_date < '$time[$b]'";

                //总退款
                $judge_later_c = "SELECT SUM(BINARY(order_total)) AS refund FROM $table_name WHERE order_type = 'gx' and order_commodity = 1 and order_state = 't' and order_date > '$time[$i]' and order_date < '$time[$b]'";

                //总退款订单数
                $judge_later_d = "SELECT COUNT(*) FROM $table_name WHERE order_type = 'gx' and order_commodity = 1 and  order_state = 't' and order_date > '$time[$i]' and order_date < '$time[$b]'";
                //第二天到第7天拿到的值
                //总销售额
                $a = $this->wpdb->get_results($judge_later_a, ARRAY_A);

                //总订单数
                $b = $this->wpdb->get_var($judge_later_b);

                //总退款
                $c = $this->wpdb->get_results($judge_later_c, ARRAY_A);

                //总退款订单
                $d = $this->wpdb->get_var($judge_later_d);

            }

            //放进数组
            //处理下时间

            //$t = date("H:i:s", strtotime($time[$i]));
            $t = $time[$i];
            //总销售额
            $arr['total_sales'][$t] = $a[0]['total'];
            //总订单数
            $arr['total_order'][$t] = $b[0];

            //总退款
            $arr['total_refund'][$t] = $c[0]['refund'];

            //总退款订单数
            $arr['total_refund_order'][$t] = $d[0];
        }
        return $arr;
    } //end magick_get_shop_actual_total_seven()

} //en class MA_control
//初步目标
//今天的商城总销售额，总订单数、总退款订单数、总退款，实际总收入
//类型：商城
//时间：今天、本周、上周、本月
//数据类型：总销售额、总订单数、总退款额、总退款订单数
//获取本周7天的商城总销售额
//获取本周7天的商城订单已发货数量
//获取本周7天的商城订单总金额

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
    <!-- 在默认WordPress“wrap”容器中创建标题 -->
    <div class="wrap">
        <!-- 将图标添加到页面 -->

        <h2><span class="dashicons dashicons-buddicons-topics"></span>沙盒主题选项</h2>
        <!-- 在保存设置时调用WordPress函数以呈现错误。 -->
        <?php settings_errors();?>
        <!-- 创建用于呈现选项的表单 -->
        <form method="post" action="options.php">
            <!---->
            <?php settings_fields('sandbox_theme_display_options');?>
            <!---->
            <?php do_settings_sections('sandbox_theme_display_options');?>
            <!--这个是提交按钮-->
            <?php submit_button();?>
        </form>
    </div><!-- /.wrap -->
<?php
} // end sandbox_theme_display
