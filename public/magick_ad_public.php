<?php

//载入所需VUE框架 - 顶部
function magick_load_vue() {
    wp_enqueue_script( 'vue', plugin_dir_url( __FILE__ ) . 'js/vue.global_v3.2.45.js', array(), '1.0.0', false );
}
add_action( 'wp_enqueue_scripts', 'magick_load_vue' );


//载入所需Elements Pro框架 - 顶部
function magick_load_elementsPro() {
    wp_enqueue_style( 'elementsPro_style', plugin_dir_url( __FILE__ ) . 'css/element-plus-v2.2.25.css', array(), '1.0.0', false );
    wp_enqueue_script( 'elementsPro_javascript', plugin_dir_url( __FILE__ ) . 'js/element-plus_v2.2.25.js', array(), '1.0.0', false );
}
add_action( 'wp_enqueue_scripts', 'magick_load_elementsPro' );

//载入插件所需用的样式

function magick_load_style() {
    wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), '1.0.0', false );
}
add_action( 'wp_enqueue_scripts', 'magick_load_style' );





