<?php
//底部横栏广告

//获取选项配置

function magic_get_ad_bottom_bar( $str ) {
    $arr = get_field( 'ad_bottom_bar', 'options' );
    $a = $arr[ $str ];
    return $a;
}

//载入弹窗

add_action( 'wp_footer', 'magick_ad_bottom_bar' );

function magick_ad_bottom_bar( $content ) {

    if ( magic_get_ad_bottom_bar( 'bottom_hide' ) == '1' ) {
        //开启广告
        echo magick_bottom_bar_content();

    } else {
        //关闭广告
        return;
    }
    ;

}

//准备内容

function magick_bottom_bar_content() {
    //广告内容
    $content = magic_get_ad_bottom_bar( 'bottom_content' );
    //弹出周期
    $content = magic_get_ad_bottom_bar( 'bottom_eject' );
    ?>
    <h1>启用广告咯</h1>
    <?php

}