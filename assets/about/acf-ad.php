<?php

//载入广告功能函数

//广告中继器处理




//最终组合 - 将整理好的变量输出
function magic_ad_output( $str ) {
    //拿到需要的值
    $arr = magick_get_value_ad();
    
    //选项处理 - 原始内容数组
    $arr = magick_output_ad_content( $arr );
    
    //处理数组 - 自定义处理后数组
    $arr = magick_handle_style( $arr );
    
    //输出需要用到的一维数组 -  - 原始输出数组
    $arr = magick_output_position_value( $arr );
    
    return $arr[ $str ];
    
};


// 拿到选项数组 -》 选项处理（对每一个内容进行处理） -》 自定义处理（对需要输出的内容进行处理） -》 调用
//




//选项处理 - 对每一个内容进行处理
//接收一个数组，对要输出的内容进行整理，处理其中的content字段并输出到output_content标
function magick_output_ad_content( $arr ) {
    
    for( $i = 0; $i < count( (array)$arr ); $i++ ) {
        
        //拿到数组中content数组 - 内容
        $content = $arr[ $i ][ 'content' ];
        
        //拿到数组中的判断数组 - 隐藏、显示、随机
        $judge = $arr[ $i ][ 'judge' ];
        
        //展示平台 - 全平台、仅电脑端、仅手机端
        $platform = $arr[ $i ][ 'platform' ];
        
        //展示位置
        $position = $arr[ $i ][ 'position' ];
        
        
        //判断展示形式 - 隐藏、显示、随机
        //需要输出的数据已处理好放在output_content键
        $arr = magick_ad_judge( $judge , $arr, $i, $content);
        
        //判断展示平台 - 全平台、仅电脑端、仅手机端
        $arr = magick_ad_platform( $platform, $arr, $i);
        
        //内容处理完毕
        
    }    //end for
     
    return $arr;
    //return $content;
    
    
};












//判断输出类型
//处理content字段 - 显示内容，根据内容形式，整理后输出到output_content标
function magick_ad_fixed_content( $content,  $arr, $i ) {
    
        for( $v = 0; $v < count( (array)$content ); $v++ ) {
            
            //拿到内容类型 - HTML、图片、幻灯片、特色内容
            $layout = $content[ $v ][ 'acf_fc_layout'];
            
            //判断是HTML内容
            if( $layout == 'ad_html' ){
                
                $arr[ $i ][ 'output_content' ] .= $content[ $v ][ 'content'];
                
            };
            
            
            //判断是图片内容
            if( $layout == 'ad_img' ){
                
                //处理图片内容
                $arr = magick_ad_img_content( $content, $v, $arr, $i );
                
            }; //end if
            
            //判断是幻灯片内容
            if( $layout == 'ad_carousel' ){
                 //$arr[ $i ][ 'output_content' ] .= "1122";
                 //处理幻灯片内容
                 $arr = magick_ad_carousel_content( $content, $v, $arr, $i );
            };
            
            //判断是重点关注内容
            if( $layout == 'ad_attentio' ){
                 //$arr[ $i ][ 'output_content' ] .= "112233";
                 $arr = magick_ad_attentio( $content, $v, $arr, $i );

            };
            
        };
    return $arr;
    
};

//输出前整理
//内容输出前再整理下，在内容前后添加自定义内容
function magick_handle_style( $arr ){
    
    for( $i = 0; $i < count( (array)$arr ); $i++ ) {
        
        //类型
        $layout = $arr[ $i ][ 'layout' ];
        
        //输出的内容
        $content = $arr[ $i ][ 'output_content' ];
        
        //是幻灯片
        if( $layout == 'ad_carousel'){
            
            
            $carousel_content = magic_output_ad_carousel ( $content );
           //$arr[ $i ][ 'output_content' ] =  htmlentities($slide_content) ;
           $arr[ $i ][ 'output_content' ] = $carousel_content ;
            
            //$arr[ $i ][ 'output_content' ] = "1122";
            
        };
        
        //重点关注内容
        //if( $layout == 'ad_attentio'){
        //    
        //    $arr[ $i ][ 'output_content' ] = "重点关注内容";
        //};
        
    }
    
    return $arr;
    
};



//判断后输出
//判断 - 隐藏、显示、随机
function magick_ad_judge( $judge , $arr, $i, $content) {
    
        //判断是隐藏
        if( $judge == '0' ){
            
            //输出空值
            $arr[ $i ][ 'output_content' ] = "";
            
        };
        
        //判断是展示
        if( $judge == '1' ){
            

            //拿到需要展示的值，判断类型后输出值到output_content
            $arr = magick_ad_fixed_content( $content, $arr, $i );
            
        };
        
        //判断是随机
        if( $judge == '2' ){
            
            //随机输出数组中的一个数组
            //乱序该数组
            shuffle( $content );
            //取出其中第一个数组
            $content_value[] = $content[ '0' ];
            
            //完成随机目的
            $content = $content_value ;
            
            
            //拿到需要展示的值，判断类型后输出值到output_content
            $arr = magick_ad_fixed_content( $content, $arr, $i );
            
            //$arr[ $i ][ 'output_content' ] = "随机";
            
        };
        
        return $arr;
    
};


//判断展示平台 - 全平台、仅电脑端、仅手机端
function magick_ad_platform( $platform, $arr, $i) {
            
        //全平台展示
        if( $platform == '0' ){
            //啥也不做
             //$arr[ $i ][ 'output_content' ] = "全平台";
        };
        
        //仅电脑端展示
        if( $platform == '1' ){
            
            //$arr[ $i ][ 'output_content' ] = "仅电脑端展示";
            if ( wp_is_mobile() ) {
                
                //是手机端，输出值为空
                $arr[ $i ][ 'output_content' ] = "";
            } else {
                
                //是PC端，啥也不做
            };
        };
        
        //仅手机端展示
        if( $platform == '2' ){
            
            if ( wp_is_mobile() ) {
                //是手机端，啥也不做
                
            } else {
                // 不是手机端，输出的值为空
                $arr[ $i ][ 'output_content' ] = "";
            }
            
            
            
        };
        
        return $arr;
};

//判断显示位置
//对拿到的值进行处理，输出一个二维数组
function magick_output_position_value( $arr ) {
    
    $arr_position = array();
    
    for( $i = 0; $i < count( (array)$arr ); $i++ ) {
        
        //拿到展示位置
        $position = $arr[ $i ][ 'position' ];
        
        $output_content = $arr[ $i ][ 'output_content' ];
        
        //默认
        if( $position == '0' ){
            
             $arr_position[ 'single_top' ] .= $output_content;
             
        };
        
        //文章页顶部
        if( $position == '1' ){
            
             $arr_position[ 'single_top' ] .= $output_content;
             
        };
        
        //文章页底部
        if( $position == '2' ){
            
             $arr_position[ 'single_bottom' ] .= $output_content;
             
        };
        
        //文章页第3段
        if( $position == '3' ){
            
             $arr_position[ 'single_third' ] .= $output_content;
             
        };
        
        
        //文章顶部
        if( $position == '4' ){
            
             $arr_position[ 'single_page_top' ] .= $output_content;
             
        };
        
        
        //文章底部
        if( $position == '5' ){
            
             $arr_position[ 'single_page_bottom' ] .= $output_content;
             
        };
        
        
        //页面顶部
        if( $position == '6' ){
            
             $arr_position[ 'page_top' ] .= $output_content;
             
        };
        
        
        //页面底部
        if( $position == '7' ){
            
             $arr_position[ 'page_bottom' ] .= $output_content;
             
        };
        
        
        
        
    };
    
    return $arr_position;
};





//处理广告内容 - 拿到关于广告内容的信息，输出一维数组,以供调用
function magick_handle_ad_content( $content, $v ) {
    

                //拿到链接的值
                $link_title  = $content[ $v ][ 'link' ][ 'title' ];
                //有则输出，无则为空
                if( $link_title )  { $link_title =  "title=".$link_title;  };
                //将值添加到数组
                 $arr[ 'link_title' ] = $link_title;
                
                $link_url    = $content[ $v ][ 'link' ][ 'url' ];
                if( $link_url )  { $link_url =  "href=".$link_url;  };
                $arr[ 'link_url' ] = $link_url;
                
                
                
                $link_target = $content[ $v ][ 'link' ][ 'target' ];
                if( $link_target )  { $link_target =  "target=".$link_target;  };
                $arr[ 'link_target' ] = $link_target;
                
                
                //拿到图片的值
                $img_title = $content[ $v ][ 'img' ][ 'title' ];
                if( $img_title )  { $img_title =  "title=".$img_title;  };
                $arr[ 'img_title' ] = $img_title;
                
                
                $img_url   = $content[ $v ][ 'img' ][ 'url' ];
                if( $img_url )  { $img_url =  "src=".$img_url;  };
                $arr[ 'img_url' ] = $img_url;
                
                $img_alt   = $content[ $v ][ 'img' ][ 'alt' ];
                if( $img_alt )  { $img_alt =  "alt=".$img_alt;  };
                $arr[ 'img_alt' ] = $img_alt;
                
                return $arr;
    
};