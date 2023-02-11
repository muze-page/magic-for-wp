<?php
//处理全局广告的数组

//获取广告选项的值，输出数组

function magick_get_add_ad_all()
{
    $arr = array();

    $arr = get_field('add_ad_all', 'options');

    return $arr;
}
;

class Magick_Content_ADD_AD_All extends Magick_Ad_Content
{
    //将传入的全局数组整理输出

    public function magick_handle_all($arr)
    {
        //需要输出的数组
        $arr_content = array();
        for ($i = 0; $i < count((array) $arr);
            $i++) {
            //拿到输出内容
            $content = $arr[$i]['output_content'];
            //拿到位置
            $position = $arr[$i]['options']['position'];
            $arr_content[] = array(
                'output_position' => $position, //输出位置
                'output_content' => $content, //输出内容
            );
        }
        return $arr_content;
    }

    //将传入的数据进行整理，同一个位置添加的内容合并成一个数组

    public function magick_handle_all_value($arr)
    {
        for ($i = 0; $i < count((array) $arr);
            $i++) {
            //拿到position
            $position = $arr[$i]['position'];
        }
    }
}

//将输出的内容和位置处理成二维数组，并输出
function magick_output_add_ad_all()
{
    //需要处理的数组
    $content = magick_get_add_ad_all();
    //实例化类 - 处理数组类
    $handle = new Magick_Content_ADD_AD_All();
    //基础处理过的数组
    $content = $handle->magick_output_ad_content($content);
    //根据指定需求输出
    $content = $handle->magick_handle_all($content);
    return $content;
}

//将自定义内容添加到文章第三段用的函数
//添加的内容、 添加的位置、内容

function prefix_insert_after_paragraph_all($insertion, $paragraph_id, $content)
{
    $closing_p = '</p>';
    $paragraphs = explode($closing_p, $content);
    foreach ($paragraphs as $index => $paragraph) {
        if (trim($paragraph)) {
            $paragraphs[$index] .= $closing_p;
        }
        if ($paragraph_id == $index + 1) {
            $paragraphs[$index] .= $insertion;
        }
    }
    return implode('', $paragraphs);
}
//end 自定义添加内容函数

//文章中输出广告
add_filter('the_content', 'magick_single_add_ad_all');

function magick_single_add_ad_all($content)
{
    $arr = magick_output_add_ad_all();

    //将数组传入并输出到需要输出的位置
    for ($i = 0; $i < count((array) $arr);
        $i++) {
        //将数组转为标量变量
        extract($arr[$i]);
        /*
        output_position - 输出的位置
        output_content - 输出的内容
         */

        //将要添加的数据收集下
        $add_content_top = '';
        $add_content_bottom = '';
        //输出到文章顶部
        if ($output_position <= '1') {
            /*将拿到的值打印在文章页*/
            if (is_single()) {
                $add_content_top .= $output_content;
            }
        }
        ;
        //输出到文章底部
        if ($output_position == '2') {
            /*将拿到的值打印在文章页*/
            if (is_single()) {

                $add_content_bottom .= $output_content;
            }
        }
        ;
        //输出到文章第三段
        if ($output_position == '3') {
            /*将拿到的值打印在文章页*/
            if (is_single()) {
                $content = prefix_insert_after_paragraph_all($output_content, 3, $content);

            }
        }
        ;
    }
    ;
    //end for循环
    $content = $add_content_top . $content . $add_content_bottom;
    return $content;
}
;

//在页面顶部输出广告
add_action('wp_head', 'magick_add_ad_all_page_top');

function magick_add_ad_all_page_top()
{

    //待处理的数组
    $arr = magick_output_add_ad_all();

    for ($i = 0; $i < count((array) $arr);
        $i++) {
        //将数组转为标量变量
        extract($arr[$i]);
        /*
        output_position - 输出的位置
        output_content - 输出的内容
         */
        //输出到全站顶部
        if ($output_position == '4') {
            echo $output_content;
        }
        ;

        //输出到仅文章页顶部
        if ($output_position == '6') {

            if (is_single()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅首页顶部
        if ($output_position == '8') {

            if (is_home()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅分类页顶部
        if ($output_position == '10') {

            if (is_category()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅标签页顶部
        if ($output_position == '12') {

            if (is_tag()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅单页顶部
        if ($output_position == '14') {

            if (is_page()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅搜索结果页顶部
        if ($output_position == '16') {

            if (is_search()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅404页顶部
        if ($output_position == '18') {

            if (is_404()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅作者页顶部
        if ($output_position == '20') {

            if (is_author()) {
                echo $output_content;
            }
        }
        ;

    }
    // end for循环

}
;

//在页面底部输出广告
add_action('wp_footer', 'magick_add_ad_all_page_bottom');

function magick_add_ad_all_page_bottom()
{

    //待处理的数组
    $arr = magick_output_add_ad_all();

    for ($i = 0; $i < count((array) $arr);
        $i++) {
        //将数组转为标量变量
        extract($arr[$i]);
        /*
        output_position - 输出的位置
        output_content - 输出的内容
         */
        //输出到全站底部
        if ($output_position == '5') {
            echo $output_content;
        }
        ;

        //输出到仅文章页底部
        if ($output_position == '7') {

            if (is_single()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅首页底部
        if ($output_position == '9') {

            if (is_home()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅分类页底部
        if ($output_position == '11') {

            if (is_category()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅标签页底部
        if ($output_position == '13') {

            if (is_tag()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅单页底部
        if ($output_position == '15') {

            if (is_page()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅搜索结果页底部
        if ($output_position == '17') {

            if (is_search()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅404页底部
        if ($output_position == '19') {

            if (is_404()) {
                echo $output_content;
            }
        }
        ;

        //输出到仅作者页底部
        if ($output_position == '21') {

            if (is_author()) {
                echo $output_content;
            }
        }
        ;

    }
    // end for循环

}
;
