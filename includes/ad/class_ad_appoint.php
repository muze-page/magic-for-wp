<?php
//指定文章的专属广告
//获取指定广告选项的值，输出内容数组
function magick_get_ad_appoint()
{
    $arr = array();
    $arr = get_field('add_ad_appoint', 'options');
    return $arr;
}
;
//继承广告内容处理类，创建自己的指定文章处理类
class Magick_Content_Appoint extends Magick_Ad_Content
{
    //补充一个函数，将内容和指定文章数组组合成新的二维数组并输出
    public function magick_handle_appoint($arr)
    {
        //需要输出的数组
        $arr_content = array();
        for ($i = 0; $i < count((array) $arr); $i++) {
            //拿到输出内容
            $content = $arr[$i]['output_content'];
            //拿到位置
            $position = $arr[$i]['options']['position'];
            //拿到位置数组
            $location = $arr[$i]['options']['location'];
            $arr_content[] = array(
                'output_content' => $content,
                'output_position' => $position,
                'output_location' => $location,
            );
        }
        return $arr_content;
    }
}
;
//end Magick_Content_Appoint
//将选项处理成输出数组
function magick_output_appoint()
{
    //需要处理的数组
    $content = magick_get_ad_appoint();
    //实例化类 - 处理数组类
    $handle = new Magick_Content_Appoint();
    //基础处理过的数组
    $content = $handle->magick_output_ad_content($content);
    //根据指定需求输出
    $content = $handle->magick_handle_appoint($content);
    return $content;
}

/*将拿到的值打印在指定文章页*/
/*
 ** 文章顶部
 ** 文章第三段后
 ** 文章底部
 ** 文章页面顶部
 ** 文章页面底部
 */
add_filter('the_content', 'magick_single_add_ad');
function magick_single_add_ad($content)
{
    $arr = magick_output_appoint();

    //依次判断，位置、文章、内容
    for ($i = 0; $i < count((array) $arr); $i++) {

        //将数组转为标量变量
        extract($arr[$i]);
        //判断广告位置
        //顶部
        if ($output_position <= '1') {
            //判断指定文章
            if (is_single($output_location)) {
                $add_content = $output_content;
                $content = $add_content . $content;
            }
            ;
        }
        ;
        //底部
        if ($output_position == '2') {
            //判断指定文章
            if (is_single($output_location)) {
                $add_content = $output_content;
                $content = $content . $add_content;
            }
            ;
        }
        ;
        //文章第三段后
        if ($output_position == '3') {
            //判断指定文章
            if (is_single($output_location)) {
                function prefix_insert_after_paragraphs($insertion, $paragraph_id, $content)
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
                // 下面一行数字3代表段落
                return prefix_insert_after_paragraphs($output_content, 4, $content);
            }
            ;
        }
        ;
    }
    return $content;
}
;

//添加到顶部
add_action('wp_head', 'magick_output_single_page_top_appoint');
function magick_output_single_page_top_appoint()
{

    $arr = magick_output_appoint();
    //将数组转为标量变量
    //依次判断，位置、文章、内容
    for ($i = 0; $i < count((array) $arr); $i++) {
        extract($arr[$i]);
        //判断广告位置
        //文章页顶部
        if ($output_position == '4') {
            if (is_single($output_location)) {
                echo $output_content;
            }

        }
    }
}
;
//添加到底部
add_action('wp_footer', 'magick_output_single_page_bottom_appoint');
function magick_output_single_page_bottom_appoint()
{

    $arr = magick_output_appoint();
    //将数组转为标量变量
    //依次判断，位置、文章、内容
    for ($i = 0; $i < count((array) $arr); $i++) {
        extract($arr[$i]);
        //判断广告位置
        //文章页顶部
        if ($output_position == '5') {
            if (is_single($output_location)) {
                echo $output_content;
            }

        }
    }
}
;
