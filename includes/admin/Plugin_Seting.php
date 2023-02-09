<?php
//广告插件配置

//隐藏字段值
//magick_option_acf();

function magick_option_acf() {
    $a = get_field( 'acf_hide', 'options' );
    if ( $a == '1' ) {
        //显示字段

    } else {
        //隐藏字段
        add_filter( 'acf/settings/show_admin', 'my_acf_settings_show_admin' );

        function my_acf_settings_show_admin( $show_admin ) {
            return false;
        }
    }
    ;
}

