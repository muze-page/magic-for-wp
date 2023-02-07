<?php

//处理图片内容

//处理图片内容
function magick_ad_img_content( $content, $v, $arr, $i ) {
                
                //拿到内容数组
                $handle_img = new Magick_Ad_Content();
                $arr_content = $handle_img -> magick_handle_ad_content( $content, $v );
                
                //将数组转为标量变量
                extract( $arr_content );
                
                //判断 - 是否展示广告
                //拿到判断的值option_watermark

                //输出
                $arr[ $i ][ 'output_content' ] .= "
                <div class='magick_img'><div class='magick_adTag'>广告</div>
                <a $link_url $link_title $link_target >
                <img $img_url $img_title $img_alt />
                </a>
                </div>

    
                ";
                
                return $arr;

    
};