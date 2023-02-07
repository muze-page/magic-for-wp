<?php 

//公用函数

//输入一个数组，处理ACF插件的链接数组输出链接
//需要处理的数组、数组的上标、数组的组件名、自定义添加的内容
function magick_publice_link( $content, $v, $mark, $cstom) {
    
      //拿到值
      $title = $content[ $v ][ $mark ][ 'title' ];
      //判断值
      if( $title )  { $title =  $title;  };
     
     //URL
     $url = $content[ $v ][ $mark ][ 'url' ];
     if( $url )  { $url =  " href=".$url;  };
     
     //target
     $target = $content[ $v ][ $mark ][ 'target' ];
     if( $target )  { $target =  " target=".$target."\" ";  };
     
     
     //判断URL是否存在
     if( $url ){
         //URL存在
        $output = "<a" .$url.$target.$cstom.">$title</a>";
         
     }else {
         // URL不存在 
         $output = "";
     };
     
     return $output;
    
};


/*将拿到的值打印在文章页顶部*/
add_filter( 'the_content', 'magick_output_single_top' );
function magick_output_single_top( $content ) {
	if ( !is_feed() && !is_home() && is_singular() && is_main_query() ) {
		$add_content =   magic_ad_output( 'single_top' )  ;
		$content =  $add_content.$content;
	}
	return $content;
}
;
/*将拿到的值打印在文章页底部*/
add_filter( 'the_content', 'magick_output_single_bottom' );
function magick_output_single_bottom( $content ) {
	if ( !is_feed() && !is_home() && is_singular() && is_main_query() ) {
		$add_content = magic_ad_output( 'single_bottom' );
		$content =  $content.$add_content;
	}
	return $content;
}
;
/*将拿到的值打印在文章页第三段*/
add_filter( 'the_content', 'magick_output_single_third' );
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
function magick_output_single_third( $content ) {
	$ad_code = magic_ad_output( 'single_third' );
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		// 下面一行数字3代表段落
		return prefix_insert_after_paragraph( $ad_code, 4, $content );
	}
	return $content;
}
;
//文章顶部添加内容
add_action( 'wp_head', 'magick_output_single_page_top' );
function magick_output_single_page_top() {
	if ( !is_feed() && !is_home() && is_singular() && is_main_query() ) {
		$add_content = magic_ad_output( 'single_page_top' );
		echo $add_content;
	}
	;
}
;
//文章底部添加内容
add_action( 'wp_footer', 'magick_output_single_page_bottom' );
function magick_output_single_page_bottom() {
	if ( !is_feed() && !is_home() && is_singular() && is_main_query() ) {
		$add_content = magic_ad_output( 'single_page_bottom' );
		echo $add_content;
	}
	;
}
;
//全站顶部添加内容
add_action( 'wp_head', 'magick_output_all_page_top' );
function magick_output_all_page_top() {
	$add_content = magic_ad_output( 'page_top' );
	echo $add_content;
}
;
//全站底部添加内容
add_action( 'wp_footer', 'magick_output_all_page_bottom' );
function magick_output_all_page_bottom() {
	$add_content = magic_ad_output( 'page_bottom' );
	echo $add_content;
}
;


//仅首页顶部
//仅文章页顶部
//仅单页顶部
//仅分类页顶部
//仅标签页顶部
//仅搜索结果页顶部
//仅404页顶部
//仅作者页顶部



//首页顶部添加自定义内容
add_action( 'wp_head', 'magick_output_home_page_top' );
function magick_output_home_page_top() {
	if ( is_home()  ) {
		//$add_content = magic_ad_output( 'single_page_top' );
		$add_content = "<h1>我仅展示在首页顶部</h1>";
		echo $add_content;
	}
	;
}
;

//单页顶部添加自定义内容
add_action( 'wp_head', 'magick_output_page_top' );
function magick_output_page_top() {
	if ( is_page()  ) {
		//$add_content = magic_ad_output( 'single_page_top' );
		$add_content = "<h1>我仅展示在单页顶部</h1>";
		echo $add_content;
	}
	;
}
;


//分类页顶部添加自定义内容
add_action( 'wp_head', 'magick_output_category_page_top' );
function magick_output_category_page_top() {
	if ( is_category()  ) {
		//$add_content = magic_ad_output( 'single_page_top' );
		$add_content = "<h1>我仅展示在分类页顶部</h1>";
		echo $add_content;
	}
	;
}
;


//标签页顶部添加自定义内容
add_action( 'wp_head', 'magick_output_tag_page_top' );
function magick_output_tag_page_top() {
	if ( is_tag()  ) {
		//$add_content = magic_ad_output( 'single_page_top' );
		$add_content = "<h1>我仅展示在标签页顶部</h1>";
		echo $add_content;
	}
	;
}
;


//搜索结果页顶部添加自定义内容
add_action( 'wp_head', 'magick_output_search_page_top' );
function magick_output_search_page_top() {
	if ( is_search() ) {
		//$add_content = magic_ad_output( 'single_page_top' );
		$add_content = "<h1>我仅展示在搜索结果页顶部</h1>";
		echo $add_content;
	}
	;
}
;

//404页顶部添加自定义内容
add_action( 'wp_head', 'magick_output_404_page_top' );
function magick_output_404_page_top() {
	if ( is_404() ) {
		//$add_content = magic_ad_output( 'single_page_top' );
		$add_content = "<h1>我仅展示在404页顶部</h1>";
		echo $add_content;
	}
	;
}
;


//作者页顶部添加自定义内容
add_action( 'wp_head', 'magick_output_author_page_top' );
function magick_output_author_page_top() {
	if ( is_author() ) {
		//$add_content = magic_ad_output( 'single_page_top' );
		$add_content = "<h1>我仅展示在作者页顶部</h1>";
		echo $add_content;
	}
	;
}
;










//在页面底部添加平台显示用css和JS
add_action( 'wp_footer', 'magick_display_platform_css' );

function magick_display_platform_css( $content ) {
    ?>
    <style>
    /*广告图标用CSS*/
    .magick_img {
        position: relative;
    }
    .magick_img .magick_adTag {
        background-color: #000;
        border: 1px solid #ebebeb;
        border-radius: 5px;
        bottom: 10px;
        right: 10px;
        color: #ebebeb;
        font-size: 12px;
        line-height: 27px;
        opacity: .5;
        position: absolute;
        
        text-align: center;
        width: 45px;
        z-index: 1;
    }
    </style>

    <?php
}