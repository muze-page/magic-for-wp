<?php
//发文统计

//发文统计模块

//添加一个按钮

//指定在统计文章后台添加echarts.js文件
function magick_load_echarts($hook)
{
    if ('toplevel_page_magick-census-single' != $hook) {
        return;
    }
    wp_enqueue_script('echarts', plugin_dir_url(\dirname(__DIR__)) . 'assets/js/echarts_v5.4.0.js', array(), '1.0');
}
add_action('admin_enqueue_scripts', 'magick_load_echarts');

//输出需要统计人员的ID和名字
function magick_output_user_id()
{
    $arr = get_field('user', 'options');
    $id = array();
    for ($i = 0; $i < count((array) $arr); $i++) {
        //防御性编程
        $id[$i]['id'] = "";
        $id[$i]['name'] = "";
        $id[$i]['id'] .= $arr[$i]['ID'];
        $id[$i]['name'] .= $arr[$i]['display_name'];
    }
    return $id;
}
;

//发文统计类
class Magick_Single_Census
{

    //时间部分
    /**
     * 获取指定日期段内每一天的日期
     * @param  Date  $startdate 开始日期
     * @param  Date  $enddate   结束日期
     * @return Array
     */
    public function getDateFromRange($startdate, $enddate)
    {
        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);
        // 计算日期段内有多少天
        $days = ($etimestamp - $stimestamp) / 86400 + 1;
        // 保存每天日期
        $date = array();
        for ($i = 0; $i < $days; $i++) {
            $date[] = date('Y-m-d', $stimestamp + (86400 * $i));
        }
        return $date;
    }
    //$date = getDateFromRange($startTime,$overTime);
    //输入一个时间数组，将其转为m-d
    public function handle_time_md($arr)
    {
        for ($i = 0; $i < count((array) $arr); $i++) {
            $time = $arr[$i];
            $timestamp = strtotime($time);
            $arr[$i] = date("m-d", $timestamp);
            //转换为日期格式
        }
        return $arr;
    }
    //输入一个时间数组，将其转为d
    public function handle_time_d($arr)
    {
        for ($i = 0; $i < count((array) $arr); $i++) {
            $time = $arr[$i];
            $timestamp = strtotime($time);
            $arr[$i] = date("d", $timestamp);
            //转换为日期格式
        }
        return $arr;
    }
    //输出本年度数组
    public function this_year()
    {
        //本年开始
        $startTime = date("Y-m-d H:i:s", strtotime(date("Y", time()) . "-1" . "-1"));
        //本年结束
        $overTime = date("Y-m-d H:i:s", strtotime(date("Y", time()) . "-12" . "-31"));
        $date = self::getDateFromRange($startTime, $overTime);
        return $date;
    }
    //输出本季度数组
    public function this_quarter()
    {
        //获取当前季度
        $season = ceil((date('m')) / 3);
        //当前季度开始时间戳
        $startTime = date("Y-m-d H:i:s", mktime(00, 00, 00, $season * 2 + 1, 1, date('Y')));
        //获取当前季度结束时间戳
        $overTime = date("Y-m-d H:i:s", mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date("Y"))), date('Y')));
        $date = self::getDateFromRange($startTime, $overTime);
        return $date;
    }
    //输出上一个月的数组
    public function last_month()
    {
        $month = 1;
        // 1代表上个月，可以增加数字追溯前几个月的时间
        $startTime = date("Y-m-d", mktime(0, 0, 0, date("m") - 1 * $month, 1, date("Y")));
        $overTime = date("Y-m-d", mktime(23, 59, 59, date("m") - ($month - 1), 0, date("Y")));
        $date = self::getDateFromRange($startTime, $overTime);
        return $date;
    }
    //输出本月数组
    public function this_month($var = "Y-m-d")
    {
        //本月起始时间日期格式
        $startTime = date("Y-m-d ", mktime(0, 0, 0, date('m'), 1, date('Y')));
        //本月结束时间日期格式
        $overTime = date("Y-m-d", mktime(23, 59, 59, date('m'), date('t'), date('Y')));
        $date = self::getDateFromRange($startTime, $overTime);
        //进行判断，输出不同格式
        if ($var == 'y') {
            //输出年
            $date = self::handle_time_y($date);
            return $date;
        }
        if ($var == 'm-d') {
            //输出月-日
            $date = self::handle_time_md($date);
            return $date;
        }
        if ($var == 'd') {
            //输出月-日
            $date = self::handle_time_d($date);
            return $date;
        }
        return $date;
    }
    //输出上周数组
    public function last_week($var = "Y-m-d")
    {
        //本周开始时间戳
        $startTime = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), date('d') - date('w') + 1 - 7, date('Y')));
        //本周结束时间戳
        $overTime = date("Y-m-d H:i:s", mktime(23, 59, 59, date('m'), date('d') - date('w') + 7 - 7, date('Y')));
        $date = self::getDateFromRange($startTime, $overTime);
        //进行判断，输出不同格式
        if ($var == 'm-d') {
            //输出月-日
            $date = self::handle_time_md($date);
            return $date;
        }
        if ($var == 'd') {
            //输出日
            $date = self::handle_time_d($date);
            return $date;
        }
        return $date;
    }
    //输出本周数组
    public function this_week($var = "Y-m-d")
    {
        //本周开始时间戳
        $startTime = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), date('d') - date('w') + 1, date('y')));
        //本周结束时间戳
        $overTime = date("Y-m-d H:i:s", mktime(23, 59, 59, date('m'), date('d') - date('w') + 7, date('y')));
        $date = self::getDateFromRange($startTime, $overTime);
        //进行判断，输出不同格式
        if ($var == 'm-d') {
            //输出月-日
            $date = self::handle_time_md($date);
            return $date;
        }
        if ($var == 'd') {
            //输出月-日
            $date = self::handle_time_d($date);
            return $date;
        }
        return $date;
    }
    //输出昨天、今天、明天的数组
    public function this_ytt()
    {
        date_default_timezone_set("Asia/Shanghai"); //设置为上海时间 否则开始时间会相差8个小时
        //Y-m-d H:i:s
        //昨天
        $yesterday = date("Y-m-d H:i:s", strtotime("-1 day"));
        //今天
        $today = date('Y-m-d H:i:s');
        //明天
        $tomorrow = date("Y-m-d H:i:s", strtotime("+1 day"));
        $date = array('yesterday' => $yesterday, 'today' => $today, 'tomorrow' => $tomorrow);
        return $date;
    }
    //日期处理结束
    //输入一个日期数组（'2022-12-07'），和用户ID，输出指定用户ID每个日期的发文数量(日期从零开始)
    public function magick_output_month_single($arr, $id)
    {
        for ($i = 0; $i < count((array) $arr); $i++) {
            //拿到日期
            $time = $arr[$i];
            $args = array(
                'date_query' => array(
                    array(
                        'after' => $time,
                        'before' => $time,
                        //'after'     => '2022-12-09',
                        //'before'    => '2022-12-09',
                        'inclusive' => true,
                    ),
                ),
                'posts_per_page' => -1, //全显示
                'post_status' => 'publish', //已发布的文章 - 非待审、草稿、私密
                'author' => $id, //指定用户的ID
            );
            $query = new WP_Query($args);
            $arr[$i] = $query->found_posts;
        }
        return $arr;
    }
    //输入一个日期，输出该日期的发文数量
    public function magick_output_today_single($arr)
    {
        for ($i = 0; $i < count((array) $arr); $i++) {
            //拿到日期
            $time = $arr[$i];
            $args = array(
                'date_query' => array(
                    array(
                        'after' => $time,
                        'before' => $time,
                        //'after'     => '2022-12-09',
                        //'before'    => '2022-12-09',
                        'inclusive' => true,
                    ),
                ),
                'posts_per_page' => -1, //全显示
                'post_status' => 'publish', //已发布的文章 - 非待审、草稿、私密
            );
            $query = new WP_Query($args);
            //发文数量
            $single_math = $query->found_posts;
            $arr[$i] = array($time, $single_math);
        }
        return $arr;
    }
}
//end class
//输出他们在本周的发文数量
function magick_output_week_release()
{
    //实例化处理数据的类
    $handle = new Magick_Single_Census();
    //拿到用户数据
    $arr = magick_output_user_id();
    //拿到本周数组
    $data = $handle->this_week();
    for ($i = 0; $i < count((array) $arr); $i++) {
        //获取用户ID
        $id = $arr[$i]['id'];
        //拿到发文数量
        $release = $handle->magick_output_month_single($data, $id);
        $arr[$i]['release'] = $release;
    }
    return $arr;
}
//输出本月的发文数量数组
function magick_output_month_release()
{
    //实例化处理数据的类
    $handle = new Magick_Single_Census();
    //拿到用户数据
    $arr = magick_output_user_id();
    //拿到本月数组
    $data = $handle->this_month();
    for ($i = 0; $i < count((array) $arr); $i++) {
        //获取用户ID
        $id = $arr[$i]['id'];
        //拿到发文数量
        $release = $handle->magick_output_month_single($data, $id);
        $arr[$i]['release'] = $release;
    }
    return $arr;
}
;
//输出本年的，每天的发文数量数组
function magick_output_year_release()
{
    //实例化处理数据的类
    $handle = new Magick_Single_Census();
    //存储数据
    $arr = array();
    //拿到本年数组
    $data = $handle->this_year();
    //拿到发文数量
    $release = $handle->magick_output_today_single($data);
    $arr = $release;
    return $arr;
}
;
// 每周更新的文章数量
function get_week_post_count()
{
    $date_query = array(array('after' => '1 week ago'));
    $args = array('post_type' => 'post', 'post_status' => 'publish', 'date_query' => $date_query, 'no_found_rows' => true, 'suppress_filters' => true, 'fields' => 'ids', 'posts_per_page' => -1);
    $query = new WP_Query($args);
    echo $query->post_count;
}
// 今日更新的文章数量
function WeeklyUpdate()
{
    $today = getdate();
    $query = new WP_Query('year=' . $today["year"] . '&monthnum=' . $today["mon"] . '&day=' . $today["mday"]);
    $postsNumber = $query->found_posts;
    echo $postsNumber;
}
function num_posts($days = 1)
{
    //$days就是设定时间一天；
    global $wpdb;
    $today = gmdate('Y-m-d H:i:s', time() + 3600 * 8);
    //获取当前的时间
    $daysago = date("Y-m-d H:i:s", strtotime($today) - ($days * 24 * 60 * 60));
    //Today - $days
    $result = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_date BETWEEN '$daysago' AND '$today' AND post_status='publish' AND post_type='post' ORDER BY post_date DESC ");
    foreach ($result as $Item) {
        $post_ID[] = $Item->ID;
        //已发布的文章ID，写到一个数组里面去
    }
    $post_num = count($post_ID);
    //输出数组中元素个数，文章ID的数量，也就是发表的文章数量
    $output .= '<a>' . $post_num . '</a>';
    //输出文章数量
    echo $output;
}
//get_week_post_count()是统计每周更新的文章数量并输出
//WeeklyUpdate()是统计每日更新的文章数量并输出.
//num_posts( '2' ); 两天内发文数量
function magick_census_single_content()
{
    ?>
		    <!--
		     <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.0/dist/echarts.js"></script>
		     -->
		    <div class="wrap">
		      <h1><?php echo esc_html(get_admin_page_title());
    ?></h1>
		<!--
		      <?php //printf( __( '用户发布的帖子数量: %s', 'textdomain' ), count_user_posts( 1 ) );
    ?>
		      每周更新数量：<?php //get_week_post_count();
    ?>
		      今日更新：<?php //WeeklyUpdate();
    ?>
		      2天内发文数量：<?php //num_posts( '2' );
    ?>

		      -->
		 <!-- 为 ECharts 准备一个定义了宽高的 DOM -->
		<div id="main" style="width: 600px;height:400px;"></div>
		<script type="text/javascript">
		//传值给JS
	//数组
	let array = <?php echo json_encode(magick_output_week_release()) ?>;
	//console.log(array);
	//获取所有的作者名
	let user_name= array.map(item=> {
		return item.name;
	}
	)

	let time = <?php
//实例化处理数据的类
    $handle = new Magick_Single_Census();
    //拿到本周数组
    $data = $handle->this_week('m-d');
    echo json_encode($data)
    ?>;
	//获取所有数据
	let user_content= array.map(item=> {
		return {
			name: item.name,
			type: 'bar',
			data: item.release,
		}
	}
	)
		//console.log( user_content );
	// 基于准备好的dom，初始化echarts实例
	var myChart = echarts.init(document.getElementById('main'));
	// 指定图表的配置项和数据
var option = {
    title: {
        text: '本周发文统计'
    }
    ,
    tooltip: {
    }
    ,
    legend: {
        //data: ['作者1', '作者2', '作者3',]
        //data:["mqzj","user1","asdfasdf-com",]
        data: user_name
    }
    ,
    xAxis: {
        //data:["周一", "周二", "周三", "周四", "周五", "周六", "周七"]
        data: time
    }
    ,
    yAxis: {
    }
    ,
    series: user_content,
}
    ;
	// 使用刚指定的配置项和数据显示图表。
	myChart.setOption(option);
	</script>
		<!--本月发文统计-->
		<div id="mains" style="width: 1600px; height: 400px"></div>
		<script type="text/javascript">
		//准备表格所需数据
	let array_month = <?php echo json_encode(magick_output_month_release()) ?>;
	//console.log(array);
	//获取所有的作者名
	let user_name_month= array_month.map(item=> {
		return item.name;
	}
	)
		let time_month = <?php
//实例化处理数据的类
    $handle = new Magick_Single_Census();
    //拿到本月数组
    $data = $handle->this_month('d');
    echo json_encode($data)
    ?>;
	//获取所有数据
	let user_content_month= array_month.map(item=> {
		return {
			name: item.name,
						      type: 'bar',
						     data: item.release,
		}
	}
	)
		  // 基于准备好的dom，初始化echarts实例
	var myCharts = echarts.init(document.getElementById("mains"));
	// 指定图表的配置项和数据
var options = {
    title: {
        text: "本月发文统计",
    }
    ,
    tooltip: {
    }
    ,
    legend: {
        data: user_name_month,
    }
    ,
    xAxis: {
        //data: ["周一", "周二", "周三", "周四", "周五", "周六", "周七"],
        data: time_month,
    }
    ,
    yAxis: {
    }
    ,
    series: user_content_month,
}
    ;
	// 使用刚指定的配置项和数据显示图表。
	myCharts.setOption(options);
	</script>
		<!--年度热力图-->
	<!-- 为 ECharts 准备一个定义了宽高的 DOM -->
	<div id="mainss" style="width: 1600px; height: 400px"></div>
	<script type="text/javascript">
		//准备表格所需数据
	let array_year = <?php echo json_encode(magick_output_year_release()) ?>;
	//获取今年年份
	let year = <?php echo date("Y") ?>;
	// 基于准备好的dom，初始化echarts实例
	var myChartss = echarts.init(document.getElementById("mainss"));
	var option;
option = {
    title: {
        top: 30,
        left: 'center',
        text: '年度发文热力图'
    }
    ,
    tooltip: {
    }
    ,
    visualMap: {
        min: 0,
        max: 300,
        //type: 'piecewise',//分段型
        type: 'continuous',
        orient: 'horizontal',
        left: 'center',
        top: 65,
        calculable: true,
        inRange: {
            color: ["#313695", "#4575b4", "#74add1", "#abd9e9", "#e0f3f8", "#ffffbf", "#fee090", "#fdae61", "#f46d43", "#d73027", "#a50026"]
        }
        ,
    }
    ,
    calendar: {
        top: 150,
        left: 30,
        right: 30,
        cellSize: ['auto', 16],
        range: year,
        itemStyle: {
            borderWidth: 0.5
        }
        ,
        yearLabel: {
            show: false
        }
        ,
        dayLabel: {
            firstDay: 1 // 从周一开始
        }
    }
    ,
    series: {
        type: 'heatmap',
        coordinateSystem: 'calendar',
        data: array_year
    }
    ,
    emphasis: {
        itemStyle: {
            borderColor: "#333",
            borderWidth: 1
        }
    }
    ,
}
    ;
	option && myChartss.setOption(option);
	</script>
		    </div>
		    <?php
}
//end html
