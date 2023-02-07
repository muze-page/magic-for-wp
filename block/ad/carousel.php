<?php

//走马灯功能
//处理走马灯内容，输出一维数组
function magick_ad_carousel_content( $content, $v, $arr, $i) {
	//添加幻灯片标识,方便后续处理
	$arr[ $i ][ 'layout' ] =  "ad_carousel";
	//拿到需要处理的内容数组
	$box = $content[ $v ][ 'box'];
	//存储数据
	$carousel = array();
	for ( $x = 0; $x < count( (array)$box ); $x++ ) {
		//拿到链接标题的值
		$link_title  = $box[ $x ][ 'link' ][ 'title' ];
		//拿到链接URL的值
		$link_url  = $box[ $x ][ 'link' ][ 'url' ];
		//拿到链接跳转的值
		$link_target  = $box[ $x ][ 'link' ][ 'target' ];
		//拿到链接跳转的值
		$img_url  = $box[ $x ][ 'img' ][ 'url' ];
		$carousel[] = array(
				             "title"=>$link_title,
		                     "url"=>$link_url,
		                     "target"=>$link_target,
		                     "img"=>$img_url,
				    );
	}
	
	//将处理好的走马灯配置JSON传给输出
	//$arr[ $i ][ 'output_content' ] =  $carousel;
	
	//处理好的数组
	$content_json =  magick_ad_carousel_content_handle( $carousel ) ;
	
	$arr[ $i ][ 'output_content' ] =    $content_json ;
	
	return $arr;
}
;

//将取得的走马灯数据处理成vue后输出




function magick_ad_carousel_content_handle( $arr ) {
    //将走马灯配置数组转为json数据
    $json = json_encode( $arr , JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE );//不转码反斜杠和中文
    

    
   $json_content = '

        <div id="app_carousel">
        <el-carousel indicator-position="outside">
            <el-carousel-item v-for="item in list" :key="item">
                <a :href="item.src" :target="item.target" :title="item.title">
                    <img :src="item.img">
                </a>
            </el-carousel-item>
        </el-carousel>
    </div>
    <script>
        const Appss = {
            setup() {
                
                return {
                   
                    list: ' .  $json  . ',
 
                };
            },
        };
        const app = Vue.createApp(Appss);
        app.use(ElementPlus);
        app.mount("#app_carousel");
    </script>
    ';
    

    //$json = printf(  $json  );
    //return $json;
    return $json_content;
}




