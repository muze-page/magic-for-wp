<?php


//添加自定义设置选项
function magic_ad_option( $wp_customize ) {

	
	//添加主题设置面板，ID = youself_options
	$wp_customize->add_panel( 'magickAd_options',
	array(
		'title'       => __( '魔法自定义', 'npcink' ),
		'description' => __( 'Npcink出品', 'npcink' ),
		'priority'    => 30,
		'capabitity'  => 'edit_theme_options',
	) );
	
	
	//添加1-1选项节点，文章页顶部代码
	$wp_customize->add_section('magick_custom_single_top',
	array(                
		'title'     => '文章页顶部自定义内容',
		'description' => '展示在文章页顶部',     
		'panel' => 'magickAd_options',
	) );
	
	//添加1-2选项节点，文章页底部代码
	$wp_customize->add_section('magickAd_sections_single_button',
	array(                
		'title'     => '文章页底部自定义内容',
		'description' => '展示在文章页底部',     
		'panel' => 'magickAd_options',
	) );
	
	//添加1-2选项节点，文章页底部代码
	$wp_customize->add_section('magick_custom_popup',
	array(                
		'title'     => '弹窗设置',
		'description' => '展示在文章页底部',     
		'panel' => '展示弹窗内容',
	) );
	
	
	

	
	
	

}
add_action( 'customize_register', 'magic_ad_option' );


