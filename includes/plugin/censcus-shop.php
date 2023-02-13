<?php

//销售统计

//指定在统计商城后台添加echarts.js文件
function magick_load_echarts_shop($hook)
{
    if ('%e7%bb%9f%e8%ae%a1%e8%8f%9c%e5%8d%95_page_magick-census-shop' != $hook) {
        return;
    }
    wp_enqueue_script('echarts', plugin_dir_url(\dirname(__DIR__)) . 'assets/js/echarts_v5.4.0.js', array(), '1.0');
}
add_action('admin_enqueue_scripts', 'magick_load_echarts_shop');

function magick_censcus_shop_content()
{
    //$MA_arr = new MA_control();
    //待发货数量
    //$watit_deliver = $MA_arr->magick_get_shop_watit_deliver();
    //最近7天商城实物销售总额
    //$actual_total_seven = $MA_arr->magick_get_shop_actual_total_seven();
    ?>
    <!--
    <dl>
    <dt>商城待发货</dt>
    <dd><?php //echo $watit_deliver; ?></dd>
    <dt>最近7天商城销售总额</dt>
    <dd><?php //p($actual_total_seven);?></dd>
    <dt>待研究</dt>
    <dd><?php //echo p($tj_vip); ?></dd>
    <dt>对比</dt>
    <dd><?php //p($MA_arr->handle_array_separate($actual_total_seven['total_sales'])['time']);?></dd>
</dl>
-->
<?php echo magick_shop_order_content(); ?>
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
    } //end magick_get_shop_watit_deliver()

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
            $aa = $time[$i];
            $t = date("d", strtotime($aa));
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

    //写一个函数，对数组中的键和值分开后输出进行处理
    public function handle_array_separate($array)
    {
        //取出其中的时间组成数组
        //存储时间
        $t = [];
        //存储值
        $v = [];
        //存储返回值
        $arr = [];
        foreach ($array as $key => $value) {
            //echo "键名是：" . $key . "值是：" . $value;
            //echo "<br/>";
            $t[] .= $key;
            $v[] .= $value;
        }
        $arr['time'] = $t;
        $arr['value'] = $v;
        //取出其中的值组成新数组
        return $arr;
    }

} //en class MA_control
//初步目标
//今天的商城总销售额，总订单数、总退款订单数、总退款，实际总收入
//类型：商城
//时间：今天、本周、上周、本月
//数据类型：总销售额、总订单数、总退款额、总退款订单数
//获取本周7天的商城总销售额
//获取本周7天的商城订单已发货数量
//获取本周7天的商城订单总金额

function magick_shop_order_content()
{
    $MA_arr = new MA_control();
    $get = $MA_arr->magick_get_shop_actual_total_seven();
    //待发货
    $watit_deliver = $MA_arr->magick_get_shop_watit_deliver();
    //今日总销售额
    $today_sale = $MA_arr->handle_array_separate($get['total_sales'])['value']['0'];
    //今日总订单
    $today_order = $MA_arr->handle_array_separate($get['total_order'])['value']['0'];
    //今日总退款
    $today_refund = $MA_arr->handle_array_separate($get['total_refund'])['value']['0'];
    //今日总退款订单
    $today_refund_order = $MA_arr->handle_array_separate($get['total_refund_order'])['value']['0'];

    ?>
    <?php //echo "配和下".implode(',', $MA_arr->handle_array_separate($get['total_sales'])['time'] )?>

    <?php //p($MA_arr->handle_array_separate($get['total_sales']));?>
    <section class="magick_shop_box">
        <div class="content">
            <div class="child-box">
                <span>待发货</span>
                <div class="child">
                    <p><span><?php $watit_deliver ? print $watit_deliver : print "0";?></span>个</p>
                    <span class="dashicons dashicons-store"></span>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="child-box">
                <span>今日总销售额（已减退款）</span>
                <div class="child">
                    <p><span><?php $today_sale ? print $today_sale : print "0";?></span>￥</p>
                    <span class="dashicons dashicons-insert"></span>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="child-box">
                <span>今日总订单（已减退款）</span>
                <div class="child">
                    <p><span><?php $today_order ? print $today_order : print "0";?></span>个</p>
                    <span class="dashicons dashicons-database-add"></span>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="child-box">
                <span>今日总退款</span>
                <div class="child">
                    <p><span><?php $today_refund ? print $today_refund : print "0";?></span>￥</p>
                    <span class="dashicons dashicons-remove"></span>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="child-box">
                <span>今日总退款订单</span>
                <div class="child">
                    <p><span><?php $today_refund_order ? print $today_refund_order : print "0";?></span>个</p>
                    <span class="dashicons dashicons-database-remove"></span>
                </div>
            </div>
        </div>

    </section>

    <!--四栏分隔-->
    <style>
        .magick_four-column .content > div {
  width: 600px;
  height: 300px;
}
        </style>
    <section class="magick_four-column">
        <div class="content">
            <!--最近7天总销售额-->
            <div id="total-sales"></div>
        </div>
        <div class="content">
            <!--最近7天总销售订单-->
            <div id="total-order"></div>
        </div>
        <div class="content">
            <!--最近7天总退款销售额-->
            <div id="total-refund"></div>
        </div>
        <div class="content">
            <!--最近7天总退款订单-->
            <div id="total-refund-order"></div>
        </div>
    </section>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        //最近7天总销售额
        let total_sales = echarts.init(document.getElementById("total-sales"));
        //最近7天总销售订单
        let total_order = echarts.init(document.getElementById("total-order"));
        //最近7天总退款销售额
        let total_refund = echarts.init(document.getElementById("total-refund"));
        //最近7天总退款订单
        let total_refund_order = echarts.init(document.getElementById("total-refund-order"));



        // 指定图表的配置项和数据
        let total_sales_option = {
            title: {
                text: "最近7天总销售额",
            },
            tooltip: {
                valueFormatter: (value) =>  value.toFixed(2)+'￥'
            },
            xAxis: {
                type: 'category',
                //data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                data: [<?php echo implode(',', array_reverse($MA_arr->handle_array_separate($get['total_sales'])['time'])) ?>]
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    //data: [120, 200, 150, 80, 70, 110, 130],
                     data: [<?php echo implode(',', array_reverse($MA_arr->handle_array_separate($get['total_sales'])['value'])) ?>],
                    type: 'bar',
                    showBackground: true,
                    backgroundStyle: {
                        color: 'rgba(180, 180, 180, 0.2)'
                    }
                }
            ]
        };

        let total_order_option = {
            title: {
                text: "最近7天总销售订单",
            },
            tooltip: {
                valueFormatter: (value) =>  value.toFixed(2)+'￥'
            },
            xAxis: {
                type: 'category',
                //data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                 data: [<?php echo implode(',', array_reverse($MA_arr->handle_array_separate($get['total_order'])['time'])) ?>]
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    //data: [120, 200, 150, 80, 70, 110, 130],
                    data: [<?php echo implode(',', array_reverse($MA_arr->handle_array_separate($get['total_order'])['value'])) ?>],
                    type: 'bar',
                    showBackground: true,
                    backgroundStyle: {
                        color: 'rgba(180, 180, 180, 0.2)'
                    }
                }
            ]
        };

        let total_refund_option = {
            title: {
                text: "最近7天总退款销售额",
            },
            tooltip: {
                valueFormatter: (value) =>  value.toFixed(2)+'￥'
            },
            xAxis: {
                type: 'category',
                //data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                data: [<?php echo implode(',', array_reverse($MA_arr->handle_array_separate($get['total_refund'])['time'])) ?>],
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    //data: [120, 200, 150, 80, 70, 110, 130],
                    data: [<?php echo implode(',', array_reverse($MA_arr->handle_array_separate($get['total_refund'])['value'])) ?>],
                    type: 'bar',
                    showBackground: true,
                    backgroundStyle: {
                        color: 'rgba(180, 180, 180, 0.2)'
                    }
                }
            ]
        };

        let total_refund_order_option = {
            title: {
                text: "最近7天总退款订单",
            },
            tooltip: {
                valueFormatter: (value) => value.toFixed(2) + '￥'
            },
            xAxis: {
                type: 'category',
                //data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                data: [<?php echo implode(',', array_reverse($MA_arr->handle_array_separate($get['total_refund_order'])['value'])) ?>],
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    //data: [120, 200, 150, 80, 70, 110, 130],
                    data: [<?php echo implode(',', array_reverse($MA_arr->handle_array_separate($get['total_refund_order'])['value'])) ?>],
                    type: 'bar',
                    showBackground: true,
                    backgroundStyle: {
                        color: 'rgba(180, 180, 180, 0.2)'
                    }
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        //最近7天总销售额
        total_sales.setOption(total_sales_option);
        //最近7天总销售订单
        total_order.setOption(total_order_option);
        //最近7天总退款销售额
        total_refund.setOption(total_refund_option);
        //最近7天总退款订单
        total_refund_order.setOption(total_refund_order_option);


    </script>
    <style>
.magick_shop_box {
  display: flex;
  max-width: 1200px;
  margin: 0 auto;
  /*两端居中对齐,仅包含子元素*/
  justify-content: space-evenly;
  /*垂直居中,仅包含子元素*/
  align-items: center;
  /*换行*/
  flex-wrap: wrap;
}
.magick_shop_box .content {
  flex: 0 0 240px;
}
.magick_shop_box .content .child-box {
  padding: 10px 20px;
  box-shadow: 8px 8px 20px 0 rgba(55, 99, 170, 0.1), -8px -8px 20px 0 #fff;
  margin: 20px 4px;
}
.magick_shop_box .content .child-box > span {
  font-size: 16px;
  font-weight: bold;
}
.magick_shop_box .content .child-box .child {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.magick_shop_box .content .child-box .child p span {
  font-size: 26px;
  font-weight: bold;
}
.magick_shop_box .content .child-box .child img {
  width: 36px;
  height: 36px;
}
.magick_shop_box .content .child-box .child > span {
  font-size: 28px;
  width: 36px;
  height: 36px;
}
.magick_shop_box img {
  width: 100%;
  height: 100%;
}
.magick_four-column {
  display: flex;
  max-width: 1200px;
  margin: 0 auto;
  /*两端居中对齐,仅包含子元素*/
  justify-content: space-evenly;
  /*垂直居中,仅包含子元素*/
  align-items: center;
  /*换行*/
  flex-wrap: wrap;
}
.magick_four-column .content {
  flex: 0 0 600px;
}

        </style>
    <?php
}
