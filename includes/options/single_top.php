<?php

function magick_costom_single_top( $wp_customize ) {
	$wp_customize->add_setting( 'magick_costom_single_top_space',
	       array(
	          'default' => '0',//默认一个广告位
	'transport' => 'refresh',
	       )
	    );
	$wp_customize->add_control( 'magick_costom_single_top_space',
	       array(
	          'label' => __( '需要几个广告位？' ),
	          'description' => esc_html__( '默认无广告位，发布后请刷新页面查看选项' ),
	          'section' => 'magick_custom_single_top',
	          'priority' => 10, 
	          'type' => 'select',
	          'capability' => 'edit_theme_options', 
	          'choices' => array( 
	             '0' => __( '关闭广告' ),
	             '1' => __( '一个' ),
	             '2' => __( '二个' ),
	             '3' => __( '三个' ),
	          )
	       )
	    );
}
add_action( 'customize_register', 'magick_costom_single_top' );