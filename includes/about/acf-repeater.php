<?php



/*将拿到的值打印在文章页顶部*/
add_filter( 'the_content', 'magic_add_single_top' );

function magic_add_single_top( $content ) {
    
    if ( !is_feed() && !is_home() && is_singular() && is_main_query() ) {
        
         $add_content =   magick_output_api_position('single_top')  ;
        
        
        $content =  $add_content.$content;
        
     
    }
    return $content;
};


/*将拿到的值打印在文章页第三段*/
add_filter( 'the_content', 'prefix_insert_post_ads' );

function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
	$closing_p = '</p>';
	$paragraphs = explode( $closing_p, $content );
	foreach ($paragraphs as $index => $paragraph) {
	if ( trim( $paragraph ) ) {
	$paragraphs[$index] .= $closing_p;
	}
	if ( $paragraph_id == $index + 1 ) {
	$paragraphs[$index] .= $insertion;
	}
	}
	return implode( '', $paragraphs );
}

function prefix_insert_post_ads( $content ) {
    
	$ad_code = magick_output_api_position('single_three')  ;
	
    if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
	// 下面一行数字3代表段落
	return prefix_insert_after_paragraph( $ad_code, 3, $content );
	}
	return $content;
}





/*将拿到的值打印在文章页底部*/
add_filter( 'the_content', 'magic_add_single_button' );

function magic_add_single_button( $content ) {
    if ( !is_feed() && !is_home() && is_singular() && is_main_query() ) {
        $add_content = magick_output_api_position( 'single_bottom' );
        $content =  $content.$add_content;
    }
    return $content;
}
;

//将拿到的值打印在页面顶部
//将拿到的值打印在页面底部
//将拿到的值打印在文章页面顶部
//将拿到的值打印在文章页面底部



//展示位置判断
//输入一个数组，根据其中的展示位置判断，组成新数组后输出
function magick_output_position( $arr ) {
    
    $arr_position = array();
    
     for( $i = 0; $i < count( $arr ); $i++ ) {
        //展示位置
        $position = $arr[ $i ][ 'position' ];
        
        //默认值
         if(  $position == "0") {
             
              $arr_position[ 'single_top' ] .= $arr[ $i ][ 'output_content' ];
              
         };
         
        //文章页顶部
        $arr_position[ 'single_top' ] .="";//数组的默认值为空，让single_top键一直都有
         if(  $position == "1") {
             
              $arr_position[ 'single_top' ] .= $arr[ $i ][ 'output_content' ];
         };
         
        //文章页底部
        $arr_position[ 'single_bottom' ] .="";
         if(  $position == "2") {
             
              $arr_position[ 'single_bottom' ] .= $arr[ $i ][ 'output_content' ];
              
         };
         
        //文章页第三段
        $arr_position[ 'single_three' ] .="";
         if(  $position == "3") {
             
              $arr_position[ 'single_three' ] .= $arr[ $i ][ 'output_content' ];
              
         };
         
        //文章顶部
         if(  $position == "4") {
             
              $arr_position[ 'single_page_top' ] .= $arr[ $i ][ 'output_content' ];
              
         };
         
        //文章底部
         if(  $position == "4") {
             
              $arr_position[ 'single_page_bottom' ] .= $arr[ $i ][ 'output_content' ];
              
         };
         
     }; //end for
     
     return $arr_position;
    
    
};

//展示效果判断
//输入一个数组，根据其中的展示效果，输出对应的内容
function magic_output_style( $arr ) {

    
    for( $i = 0; $i < count( $arr ); $i++ ) {
        
        //展示形式
        $style = $arr[ $i ][ 'style' ];
        
        //不展示
         if( $style == "0") {
              $arr[ $i ]["output_content"] =  "";
         };
         
        //固定展示
         if( $style == "1") {
              $arr[ $i ]["output_content"] =   $arr[ $i ]["output_content"];
         };
    };    //end for 
    
    return $arr;
};




//展示平台判断
//输入一个数组，根据其中的平台，输出对应的数组
function magic_platfrom_judge( $arr ) {
    
        for( $i = 0; $i < count( $arr ); $i++ ) {
        
        //图片
        $image = $arr[ $i ][ 'image' ];
        
        //链接
        $url    = $arr[ $i ][ 'link' ][ 'url' ];
        $target = $arr[ $i ][ 'link' ][ 'target' ];
        $title  = $arr[ $i ][ 'link' ][ 'title' ];
                
        
        //HTML
        $content = $arr[ $i ][ 'content' ];
        
        
        
        
        //展示平台
        $platform = $arr[ $i ][ 'platform' ];
        
        //判断处理的是图片还是HTML内容
        if( $content ) {
            $output_content = $content;
        } else {
                   $output_content = "
                       <div class='magick_img'><div class='magick_adTag'>广告</div>
                       <a href='$url' title='$title' target='$target'><img src='$image' /></a></div>
             ";
        }
        

             
              //$output_content = "<h5>简简单单的测试</h5>";
        
        
        //全平台展示
         if( $platform == "0") {
             
             $arr[ $i ][ "output_content" ] = $output_content;
            
         };
         
         //仅展示电脑端
        if( $platform == "1") {
            
           
             $arr[ $i ][ "output_content" ] = "<div class='magick_display_pc'>".$output_content."</div>";
        };
        
         //仅展示手机端
        if( $platform == "2") {
            
         $arr[ $i ][ "output_content" ] = "<div class='magick_display_phone'>".$output_content."</div>";
         
        
        };
        
        }; //end for
        
        return $arr;
    
}






/*
* 输出图像中继组件的数组值
*/

function magic_get_value_img( ) {
    $arr = array();
    $arr = get_field( 'repeater_images', 'options' );
    
    $arr_img = array();
    
        if (  $arr ) {
        foreach (  $arr as $row ) {
            //显示图片
            $image    = $row[ 'add_img_image' ];
            
            //显示链接
            $link     = $row[ 'add_img_link' ] ;
            
            //展示形式
            $style    = $row[ 'add_img_style' ];
            
            //显示位置
            $position = $row[ 'add_img_position' ];
            
            //显示平台
            $platform = $row[ 'add_img_platform' ];
            

            $arr_img[]=array('image'=>$image, 'link'=>$link, 'style'=>$style, 'position'=>$position, 'platform'=>$platform,);
        }
    }
    
    //判断展示平台
    $arr = magic_platfrom_judge( $arr_img );
    
    //判断是否展示
    $arr = magic_output_style( $arr );
    
     $arr = magick_output_position( $arr );
    
    return  $arr;
}


/*
* 输出H5中继组件的数组值
*/

function magic_get_value_html() {
    $arr = array();
    $arr = get_field( 'repeater_html', 'options' );
    
    $arr_value = array();
    
        if (  $arr ) {
        foreach (  $arr as $row ) {

            
            //显示内容
            $content     = $row[ 'add_html_content' ] ;
            
            //展示形式
            $style    = $row[ 'add_html_style' ];
            
            //显示位置
            $position = $row[ 'add_html_position' ];
            
            //显示平台
            $platform = $row[ 'add_html_platform' ];
            

            $arr_value[]=array('content'=>$content,  'style'=>$style, 'position'=>$position, 'platform'=>$platform,);
        }
    }
    
    //判断展示平台
    $arr = magic_platfrom_judge( $arr_value );
    
    //判断是否展示
    $arr = magic_output_style( $arr );
    
    $arr = magick_output_position( $arr );
    
    return  $arr;
    //return  $arr_value;
}


//将数组中的内容取出组合字符串并返回
function magic_easy( $arr, $str){
       $arr = $arr[ $str ];
       $arr_str = '';
       foreach ( $arr as $key => $value) {
           $arr_str .= $value;
       }
       $arr = $arr_str;
       return $arr;
}


//数组合并，
//将多个需要判断内容的数组合并起来，根据提供的变量输出对应的数组
function magick_output_api_position( $str ) {
    
   
    $arr_position = array();
    
    //图片的数组
    $img = magic_get_value_img();
    //$img = magick_output_position( $img );
    
    //HTML的数组
    $html = magic_get_value_html();
    //$html = magick_output_position( $html );
    
    //随机的数组
    $random = magic_get_value_random();
    //$random = magick_output_position( $random );
    
    // 将两个数组，相同键名的键值合并成二维数组
    //调整此处的数组位置，可改变前台展示数据的顺序
   $arr_position = array_merge_recursive(  $img, $html, $random ); 
   
   
   $arr_position = magic_easy( $arr_position, $str );
   
   //输出到顶部需要的数组
   //if( $str == 'single_top') {
       //$arr_zero     = $arr_position[ 'single_top' ][ '0' ];
       //$arr_one      = $arr_position[ 'single_top' ][ '1' ];
       //$arr_random   = $arr_position[ 'single_top' ][ '2' ];
       //$arr_position = $arr_zero.$arr_one.$arr_random;
       
       //$arr = $arr_position[ 'single_top' ];
       //$arr_str = '';
       //foreach ( $arr as $key => $value) {
       //    $arr_str .= $value;
       //}
       //$arr_position = $arr_str;
       
      // $arr_position = magic_easy( $arr_position, 'single_top' );
   //}
   
   //输出到底部需要的数组
   //if( $str == 'single_bottom') {
   //    $arr_zero = $arr_position[ 'single_bottom' ][ '0' ];
   //    $arr_one = $arr_position[ 'single_bottom' ][ '1' ];
   //    $arr_position = $arr_zero.$arr_one;
   //}
   //
   ////输出到文章第三段需要的数组
   //if( $str == 'single_three') {
   //    $arr_zero = $arr_position[ 'single_three' ][ '0' ];
   //    $arr_one = $arr_position[ 'single_three' ][ '1' ];
   //    $arr_position = $arr_zero.$arr_one;
   //}
   //
   //
   ////输出到文章页面顶部需要的数组
   //if( $str == 'single_page_top') {
   //    $arr_zero = $arr_position[ 'single_page_top' ][ '0' ];
   //    $arr_one = $arr_position[ 'single_page_top' ][ '1' ];
   //    $arr_position = $arr_zero.$arr_one;
   //}
   //
   ////输出到文章页面底部需要的数组
   //if( $str == 'single_page_bottom') {
   //    $arr_zero = $arr_position[ 'single_page_bottom' ][ '0' ];
   //    $arr_one = $arr_position[ 'single_page_bottom' ][ '1' ];
   //    $arr_position = $arr_zero.$arr_one;
   //}
   
   

   
   
    return $arr_position;
    
};




