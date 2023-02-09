<?php

/**
*当前插件版本。
*定义常量
*/
define( 'PLUGIN_NAME_VERSION', '1.2.0' );
//测试类

class Magick_Ad {
    protected $plugin_name;
    protected $version;
    //主要用来在创建对象时初始化对象， 即为对象成员变量赋初始值

    public function __construct() {
        if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
            $this->version = PLUGIN_NAME_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'plugin-name';
    }

    function pp() {
        echo $this->plugin_name;
        echo $this->version;
    }
}

//定义一个公共处理广告内容的类
//对输入的内容进行基础的处理

class Magick_Ad_Content {
    function test( $a ) {
        echo '您输入的是：'.$a;
    }
    //选项处理 - 对每一个内容进行选项处理后输出
    //接收一个数组，对要输出的内容进行整理，处理其中的content字段并输出到output_content下标

    function magick_output_ad_content( $arr ) {
        for ( $i = 0; $i < count( ( array )$arr );
        $i++ ) {
            //拿到数组中content数组 - 内容数组
            $content = $arr[ $i ][ 'content' ];
            //拿到数组中的判断变量 - 隐藏、显示、随机
            $judge = $arr[ $i ][ 'options' ][ 'judge' ];
            //拿到数组中的用户判断变量 - 默认、仅登录、仅非登录
            $sign = $arr[ $i ][ 'options' ][ 'sign' ];
            //展示平台变量 - 全平台、仅电脑端、仅手机端
            $platform = $arr[ $i ][ 'options' ][ 'platform' ];
            //展示位置变量
            $position = $arr[ $i ][ 'options' ][ 'position' ];

            //判断展示形式 - 隐藏、显示、随机
            //需要输出的数据已处理好放在output_content键
            $arr = $this -> magick_ad_judge( $judge, $sign, $arr, $i, $content );
            //判断展示平台 - 全平台、仅电脑端、仅手机端
            $arr = $this -> magick_ad_platform( $platform, $arr, $i );
            //内容处理完毕，已放在output_content下标
        }
        //end for
        return $arr;

    }

    //判断后输出
    //判断 - 隐藏、显示、随机

    function magick_ad_judge( $judge, $sign, $arr, $i, $content ) {
        //判断是默认 - 展示
        if ( $judge == '0' ) {
            //判断登录类型
            if ( $this ->magick_ad_sign( $sign ) ) {
                //拿到需要展示的值，判断类型后输出值到output_content
                $arr = $this -> magick_ad_fixed_content( $content, $arr, $i );
            }

        }
        ;
        //判断是随机
        if ( $judge == '1' ) {
            //判断登录类型
            if ( $this ->magick_ad_sign( $sign ) ) {
                //随机输出数组中的一个数组
                //乱序该数组
                shuffle( $content );
                //取出其中第一个数组
                $content_value[] = $content[ '0' ];
                //完成随机目的
                $content = $content_value ;
                //拿到需要展示的值，判断类型后输出值到output_content
                $arr = $this -> magick_ad_fixed_content( $content, $arr, $i );
            }

        }
        ;
        //判断是隐藏
        if ( $judge == '2' ) {
            //输出空值
            $arr[ $i ][ 'output_content' ] = '';

        }
        ;
        return $arr;

    }

    //判断登录类型

    function magick_ad_sign( $sign ) {
        //默认
        if ( $sign == '0' ) {
            return true;
        }
        //仅登录展示
        if ( $sign == '1' ) {
            //登录判断
            if ( is_user_logged_in() ) {
                //登录了
                return true;
            }

            //未登录
            return false;

        }
        //仅非登录展示
        if ( $sign == '2' ) {
            //登录判断
            if ( is_user_logged_in() ) {
                //登录了
                return false;
            }

            //未登录
            return true;

        }

    }

    //判断输出类型
    //处理content字段 - 显示内容，根据内容形式，整理后输出到output_content标

    function magick_ad_fixed_content( $content,  $arr, $i ) {
        for ( $v = 0; $v < count( ( array )$content );
        $v++ ) {
            //拿到内容类型 - HTML、图片、幻灯片、特色内容
            $layout = $content[ $v ][ 'acf_fc_layout' ];
            //$arr[ $i ][ 'output_content' ] = '简简单单的测试111';

            //判断是HTML内容
            if ( $layout == 'ad_html' ) {
                $arr[ $i ][ 'output_content' ] .= $content[ $v ][ 'content' ];
                //$arr[ $i ][ 'output_content' ] = '666';
            }
            ;

            //判断是图片内容
            if ( $layout == 'ad_img' ) {
                //处理图片内容
                $arr = magick_ad_img_content( $content, $v, $arr, $i );
            }
            ;
            //end if

            //判断是走马灯内容
            if ( $layout == 'ad_carousel' ) {
                //处理走马灯内容
                $arr = magick_ad_carousel_content( $content, $v, $arr, $i );
            }
            ;
            //end if

        }
        ;
        return $arr;
    }
    //判断展示平台 - 全平台、仅电脑端、仅手机端

    function magick_ad_platform( $platform, $arr, $i ) {
        //全平台展示
        if ( $platform == '0' ) {

        }
        ;

        //仅手机端展示
        if ( $platform == '1' ) {
            if ( wp_is_mobile() ) {
                //是手机端，啥也不做
            } else {
                // 不是手机端，输出的值为空
                $arr[ $i ][ 'output_content' ] = '';
            }
        }
        ;
        //仅电脑端展示
        if ( $platform == '2' ) {
            if ( wp_is_mobile() ) {
                //是手机端，输出值为空
                $arr[ $i ][ 'output_content' ] = '';
            }

            ;
        }
        ;
        return $arr;
    }
    //处理广告内容 - 拿到关于广告内容的信息，输出一维数组, 以供调用

    function magick_handle_ad_content( $content, $v ) {
        //拿到链接的值
        $link_title  = $content[ $v ][ 'link' ][ 'title' ];
        //有则输出，无则为空
        if ( $link_title ) {
            $link_title =  'title='.$link_title;
        }
        ;
        //将值添加到数组
        $arr[ 'link_title' ] = $link_title;
        $link_url    = $content[ $v ][ 'link' ][ 'url' ];
        if ( $link_url ) {
            $link_url =  'href='.$link_url;
        }
        ;
        $arr[ 'link_url' ] = $link_url;
        $link_target = $content[ $v ][ 'link' ][ 'target' ];
        if ( $link_target ) {
            $link_target =  'target='.$link_target;
        }
        ;
        $arr[ 'link_target' ] = $link_target;
        //拿到图片的值
        $img_title = $content[ $v ][ 'img' ][ 'title' ];
        if ( $img_title ) {
            $img_title =  'title='.$img_title;
        }
        ;
        $arr[ 'img_title' ] = $img_title;
        $img_url   = $content[ $v ][ 'img' ][ 'url' ];
        if ( $img_url ) {
            $img_url =  'src='.$img_url;
        }
        ;
        $arr[ 'img_url' ] = $img_url;
		
        $img_alt   = $content[ $v ][ 'img' ][ 'alt' ];
        if ( $img_alt ) {
            $img_alt =  'alt='.$img_alt;
        }
        ;
        $arr[ 'img_alt' ] = $img_alt;

		//拿到配置选项
        return $arr;
    }


    //处理Cookie
    
}
;
//end Magick_Ad_Content

