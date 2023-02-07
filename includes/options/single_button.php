<?php
    //文章底部广告数判断 - 需要几个广告位？
function magickAd_single_button( $wp_customize ) {
	$wp_customize->add_setting( 'magickAd_single_button_space',
	       array(
	          'default' => '0',//默认一个广告位
	'transport' => 'refresh',
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_space',
	       array(
	          'label' => __( '需要几个广告位？' ),
	          'description' => esc_html__( '默认无广告位，发布后请刷新页面查看选项' ),
	          'section' => 'magickAd_sections_single_button',
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
add_action( 'customize_register', 'magickAd_single_button' );
//添加第一个广告位
function magickAd_single_button_one( $wp_customize ) {
	$wp_customize->add_setting( 'magickAd_single_button_type_one',
	       array(
	          'default' => '1',
	          'transport' => 'refresh',
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_type_one',
	       array(
	          'label' => __( '1-广告类型' ),
	          'description' => esc_html__( '选择需要的广告类型' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	          'type' => 'select',
	          'capability' => 'edit_theme_options', 
	          'choices' => array( 
	             '0' => __( 'HTML' ),
	             '1' => __( '图片' ),
	             '2' => __( '幻灯片' ),
	          )
	       )
	    );
	$wp_customize->add_setting( 'magickAd_single_button_try_one',
	       array(
	          'default' => '0',//默认全平台展示
	'transport' => 'refresh',
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_try_one',
	       array(
	          'label' => __( '1-哪里展现？' ),
	          'description' => esc_html__( '此选项无法预览效果，保存即可' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	          'type' => 'select',
	          'capability' => 'edit_theme_options', 
	          'choices' => array( 
	             '0' => __( '全平台展示' ),
	             '1' => __( '仅电脑端展示' ),
	             '2' => __( '仅平板端展示' ),
	             '3' => __( '仅手机端展示' ),
	          )
	       )
	    );
}
//添加第二个广告位
function magickAd_single_button_two( $wp_customize ) {
	$wp_customize->add_setting( 'magickAd_single_button_type_two',
	       array(
	          'default' => '1',
	          'transport' => 'refresh',
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_type_two',
	       array(
	          'label' => __( '2-广告类型' ),
	          'description' => esc_html__( '选择需要的广告类型' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	          'type' => 'select',
	          'capability' => 'edit_theme_options', 
	          'choices' => array( 
	             '0' => __( 'HTML' ),
	             '1' => __( '图片' ),
	             '2' => __( '幻灯片' ),
	          )
	       )
	    );
	$wp_customize->add_setting( 'magickAd_single_button_try_two',
	       array(
	          'default' => '0',//默认全平台展示
	'transport' => 'refresh',
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_try_two',
	       array(
	          'label' => __( '2-哪里展现？' ),
	          'description' => esc_html__( '展现设备' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	          'type' => 'select',
	          'capability' => 'edit_theme_options', 
	          'choices' => array( 
	             '0' => __( '全平台展示' ),
	             '1' => __( '仅电脑端展示' ),
	             '2' => __( '仅平板端展示' ),
	             '3' => __( '仅手机端展示' ),
	          )
	       )
	    );
}
//添加第三个广告位
function magickAd_single_button_three( $wp_customize ) {
	$wp_customize->add_setting( 'magickAd_single_button_type_three',
	       array(
	          'default' => '1',
	          'transport' => 'refresh',
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_type_three',
	       array(
	          'label' => __( '3-广告类型' ),
	          'description' => esc_html__( '选择需要的广告类型' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	          'type' => 'select',
	          'capability' => 'edit_theme_options', 
	          'choices' => array( 
	             '0' => __( 'HTML' ),
	             '1' => __( '图片' ),
	             '2' => __( '幻灯片' ),
	          )
	       )
	    );
	$wp_customize->add_setting( 'magickAd_single_button_try_three',
	       array(
	          'default' => '0',//默认全平台展示
	'transport' => 'refresh',
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_try_three',
	       array(
	          'label' => __( '3-哪里展现？' ),
	          'description' => esc_html__( '展现设备' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	          'type' => 'select',
	          'capability' => 'edit_theme_options', 
	          'choices' => array( 
	             '0' => __( '全平台展示' ),
	             '1' => __( '仅电脑端展示' ),
	             '2' => __( '仅平板端展示' ),
	             '3' => __( '仅手机端展示' ),
	          )
	       )
	    );
}
//若选择HTML - 1
function magickAd_single_button_html_one( $wp_customize ) {
	$wp_customize->add_setting( 'magickAd_single_button_type_html_one',
	       array(
	          'default' => '',
	          'transport' => 'refresh',
	          //'sanitize_callback' => 'wp_filter_nohtml_kses'
	)
	    );
	$wp_customize->add_control( 'magickAd_single_button_type_html_one',
	       array(
	          'label' => __( '1-HTML' ),
	          'description' => esc_html__( '展示位置：文章下方' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	          'type' => 'textarea',
	          'capability' => 'edit_theme_options', 
	          'input_attrs' => array( 
	             'class' => 'my-custom-class',
	             'style' => 'border: 1px solid #999',
	             'placeholder' => __( '输入内容...' ),
	          ),
	       )
	    );
}
//第二个HTML
function magickAd_single_button_html_two( $wp_customize ) {
	$wp_customize->add_setting( 'magickAd_single_button_type_html_two',
	       array(
	          'default' => '',
	          'transport' => 'refresh',
	          //'sanitize_callback' => 'wp_filter_nohtml_kses'
	)
	    );
	$wp_customize->add_control( 'magickAd_single_button_type_html_two',
	       array(
	          'label' => __( '2-HTML' ),
	          'description' => esc_html__( '展示位置：文章下方' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	          'type' => 'textarea',
	          'capability' => 'edit_theme_options', 
	          'input_attrs' => array( 
	             'class' => 'my-custom-class',
	             'style' => 'border: 1px solid #999',
	             'placeholder' => __( '输入内容...' ),
	          ),
	       )
	    );
}
//第三个HTML
function magickAd_single_button_html_three( $wp_customize ) {
	$wp_customize->add_setting( 'magickAd_single_button_type_html_three',
	       array(
	          'default' => '',
	          'transport' => 'refresh',
	          
	)
	    );
	$wp_customize->add_control( 'magickAd_single_button_type_html_three',
	       array(
	          'label' => __( '3-HTML' ),
	          'description' => esc_html__( '展示位置：文章下方' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	          'type' => 'textarea',
	          'capability' => 'edit_theme_options', 
	          'input_attrs' => array( 
	             'class' => 'my-custom-class',
	             'style' => 'border: 1px solid #999',
	             'placeholder' => __( '输入内容...' ),
	          ),
	       )
	    );
}
//若选择图片-1
function magickAd_single_button_images_one( $wp_customize ) {
	
	$wp_customize->add_setting( 'magickAd_single_button_image_one',
	   array(
	      'default' => '',
	      'transport' => 'refresh',
	      'sanitize_callback' => 'esc_url_raw'
	   )
	);
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'magickAd_single_button_image_one',
	   array(
	      'label' => __( '默认图像控件' ),
	      'description' => esc_html__( '这是图像控件的说明' ),
	      'section' => 'magickAd_sections_single_button',
	      'button_labels' => array( 
	'select' => __( '选择图像' ),
	         'change' => __( '更改图像' ),
	         'remove' => __( '移除' ),
	         'default' => __( 'Default' ),
	         'placeholder' => __( '未选择图像' ),
	         'frame_title' => __( 'Select Image' ),
	         'frame_button' => __( 'Choose Image' ),
	      )
	   )
	) );
	
	$wp_customize->add_setting( 'magickAd_single_button_text_one',
	       array(
	          'default' => '',
	          'transport' => 'refresh',
	          'sanitize_callback' => 'esc_url_raw'
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_text_one',
	       array(
	          'label' => __( '1-点击图片需要跳转的链接' ),
	          'description' => esc_html__( '任何网址都可以，会打开新页面跳转过去的' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	'type' => 'url', 
	'capability' => 'edit_theme_options', 
	'input_attrs' => array( 
	'class' => 'my-custom-class',
	             'style' => 'border: 1px solid rebeccapurple',
	             'placeholder' => __( '输入跳转网址' ),
	          ),
	       )
	    );
}
//若选择图片-2
function magickAd_single_button_images_two( $wp_customize ) {
	$wp_customize->add_setting( 'magickAd_single_button_image_two',
	   array(
	      'default' => '',
	      'transport' => 'refresh',
	      'sanitize_callback' => 'esc_url_raw'
	   )
	);
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'magickAd_single_button_image_two',
	   array(
	      'label' => __( '默认图像控件' ),
	      'description' => esc_html__( '这是图像控件的说明' ),
	      'section' => 'magickAd_sections_single_button',
	      'button_labels' => array( // Optional.
	'select' => __( '选择图像' ),
	         'change' => __( '更改图像' ),
	         'remove' => __( '移除' ),
	         'default' => __( 'Default' ),
	         'placeholder' => __( '未选择图像' ),
	         'frame_title' => __( 'Select Image' ),
	         'frame_button' => __( 'Choose Image' ),
	      )
	   )
	) );
	
	$wp_customize->add_setting( 'magickAd_single_button_text_two',
	       array(
	          'default' => '',
	          'transport' => 'refresh',
	          'sanitize_callback' => 'esc_url_raw'
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_text_two',
	       array(
	          'label' => __( '2-点击图片需要跳转的链接' ),
	          'description' => esc_html__( '任何网址都可以，会打开新页面跳转过去的' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, 
	'type' => 'url', 
	'capability' => 'edit_theme_options', 
	'input_attrs' => array( 
	'class' => 'my-custom-class',
	             'style' => 'border: 1px solid rebeccapurple',
	             'placeholder' => __( '输入跳转网址' ),
	          ),
	       )
	    );
}
//图片类型 - 3
function magickAd_single_button_images_three( $wp_customize ) {
	$wp_customize->add_setting( 'magickAd_single_button_image_three',
	   array(
	      'default' => '',
	      'transport' => 'refresh',
	      'sanitize_callback' => 'esc_url_raw'
	   )
	);
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'magickAd_single_button_image_three',
	   array(
	      'label' => __( '默认图像控件' ),
	      'description' => esc_html__( '这是图像控件的说明' ),
	      'section' => 'magickAd_sections_single_button',
	      'button_labels' => array( // Optional.
	'select' => __( '选择图像' ),
	         'change' => __( '更改图像' ),
	         'remove' => __( '移除' ),
	         'default' => __( 'Default' ),
	         'placeholder' => __( '未选择图像' ),
	         'frame_title' => __( 'Select Image' ),
	         'frame_button' => __( 'Choose Image' ),
	      )
	   )
	) );
	
	$wp_customize->add_setting( 'magickAd_single_button_text_three',
	       array(
	          'default' => '',
	          'transport' => 'refresh',
	          'sanitize_callback' => 'esc_url_raw'
	       )
	    );
	$wp_customize->add_control( 'magickAd_single_button_text_three',
	       array(
	          'label' => __( '3-点击图片需要跳转的链接' ),
	          'description' => esc_html__( '任何网址都可以，会打开新页面跳转过去的' ),
	          'section' => 'magickAd_sections_single_button',
	          'priority' => 10, // Optional. Order priority to load the control. Default: 10
	'type' => 'url', // Can be either text, email, url, number, hidden, or date
	'capability' => 'edit_theme_options', // Optional. Default: 'edit_theme_options'
	'input_attrs' => array( // Optional.
	'class' => 'my-custom-class',
	             'style' => 'border: 1px solid rebeccapurple',
	             'placeholder' => __( '输入跳转网址' ),
	          ),
	       )
	    );
}


//功能代码 - 在所有文章底部添加自定义内容
//HTML-1
function magicAd_add_after_single_content_one($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		$value= get_theme_mod( 'magickAd_single_button_type_html_one' );
		$content .= "<div class='magick_custom_single_button_class_one'>$value</div>";
		//
	}
	return $content;
}
//HTML-2
function magicAd_add_after_single_content_two($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		$value=get_theme_mod( 'magickAd_single_button_type_html_two' );
		$content .= "<div class='magick_custom_single_button_class_two'>$value</div>";
		//
	}
	return $content;
}
//HTML-3
function magicAd_add_after_single_content_three($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		$value= get_theme_mod( 'magickAd_single_button_type_html_three' );
		$content .= "<div class='magick_custom_single_button_class_three'>$value</div>";
	}
	return $content;
}
//图片广告
//1
function magicAd_add_after_single_content_image_one($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$images=get_theme_mod( 'magickAd_single_button_image_one' );
		$link=get_theme_mod( 'magickAd_single_button_text_one' );
		$value="<a href=$link><img src=$images /></a>";
		$content .= "<div class='magick_custom_single_button_class_one'>$value</div>";
		//
	}
	return $content;
}
//2
function magicAd_add_after_single_content_image_two($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$images=get_theme_mod( 'magickAd_single_button_image_two' );
		$link=get_theme_mod( 'magickAd_single_button_text_two' );
		$value="<a href=$link><img src=$images /></a>";
		$content .= "<div class='magick_custom_single_button_class_two'>$value</div>";
		//
	}
	return $content;
}
//3
function magicAd_add_after_single_content_image_three($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$images=get_theme_mod( 'magickAd_single_button_image_three' );
		$link=get_theme_mod( 'magickAd_single_button_text_three' );
		$value="<a href=$link><img src=$images /></a>";
		$content .= "<div class='magick_custom_single_button_class_three'>$value</div>";
	}
	return $content;
}
//控制展示平台
//1号广告，仅电脑端展示
function magick_custom_class_one_pc($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$value=magick_custom_pc_see('magick_custom_single_button_class_one');
		$content .= $value;
	}
	return $content;
}
//add_filter('the_content', 'magick_custom_class_one_pc');
//1号广告，仅平板端展示
function magick_custom_class_one_flat($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$value=magick_custom_flat_see('magick_custom_single_button_class_one');
		$content .= $value;
	}
	return $content;
}
//add_filter('the_content', 'magick_custom_class_one_flat');
//1号广告，仅手机端展示
function magick_custom_class_one_phone($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$value=magick_custom_phone_see('magick_custom_single_button_class_one');
		$content .= $value;
	}
	return $content;
}
//add_filter('the_content', 'magick_custom_class_one_phone');
//2号广告，仅电脑端展示
function magick_custom_class_two_pc($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$value=magick_custom_pc_see('magick_custom_single_button_class_two');
		$content .= $value;
	}
	return $content;
}
//add_filter('the_content', 'magick_custom_class_two_pc');
//2号广告，仅平板端展示
function magick_custom_class_two_flat($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$value=magick_custom_flat_see('magick_custom_single_button_class_two');
		$content .= $value;
	}
	return $content;
}
//add_filter('the_content', 'magick_custom_class_two_flat');
//2号广告，仅手机端展示
function magick_custom_class_two_phone($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$value=magick_custom_phone_see('magick_custom_single_button_class_two');
		$content .= $value;
	}
	return $content;
}
//add_filter('the_content', 'magick_custom_class_two_phone');
//3号广告，仅电脑端展示
function magick_custom_class_three_pc($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$value=magick_custom_pc_see('magick_custom_single_button_class_three');
		$content .= $value;
	}
	return $content;
}
//add_filter('the_content', 'magick_custom_class_three_pc');
//3号广告，仅平板端展示
function magick_custom_class_three_flat($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$value=magick_custom_flat_see('magick_custom_single_button_class_three');
		$content .= $value;
	}
	return $content;
}
//add_filter('the_content', 'magick_custom_class_three_flat');
//1号广告，仅手机端展示
function magick_custom_class_three_phone($content) {
	if(!is_feed() && !is_home() && is_singular() && is_main_query()) {
		//图片
		$value=magick_custom_phone_see('magick_custom_single_button_class_three');
		$content .= $value;
	}
	return $content;
}
//add_filter('the_content', 'magick_custom_class_three_phone');


//添加铅笔 - HTML 
//1
function magic_cutom_single_button_customize_register_html_one( $wp_customize ) {
	$wp_customize->selective_refresh->add_partial( 'magickAd_single_button_type_html_one', array(
	            'selector'        => '.magick_custom_single_button_class_one',
	        ) );
}
//add_action( 'customize_register', 'magic_cutom_single_button_customize_register_html_one' );
//2
function magic_cutom_single_button_customize_register_html_two( $wp_customize ) {
	$wp_customize->selective_refresh->add_partial( 'magickAd_single_button_type_html_two', array(
	            'selector'        => '.magick_custom_single_button_class_two',
	        ) );
}
//add_action( 'customize_register', 'magic_cutom_single_button_customize_register_html_two' );
//3
function magic_cutom_single_button_customize_register_html_three( $wp_customize ) {
	$wp_customize->selective_refresh->add_partial( 'magickAd_single_button_type_html_three', array(
	            'selector'        => '.magick_custom_single_button_class_three',
	        ) );
}
//add_action( 'customize_register', 'magic_cutom_single_button_customize_register_html_three' );
//添加铅笔 - images
//1
function magic_cutom_single_button_customize_register_images_one( $wp_customize ) {
	$wp_customize->selective_refresh->add_partial( 'magickAd_single_button_image_one', array(
	            'selector'        => '.magick_custom_single_button_class_one',
	        ) );
}
//add_action( 'customize_register', 'magic_cutom_single_button_customize_register_images_one' );
//2
function magic_cutom_single_button_customize_register_images_two( $wp_customize ) {
	$wp_customize->selective_refresh->add_partial( 'magickAd_single_button_image_two', array(
	            'selector'        => '.magick_custom_single_button_class_two',
	        ) );
}
//add_action( 'customize_register', 'magic_cutom_single_button_customize_register_images_two' );
//3
function magic_cutom_single_button_customize_register_images_three( $wp_customize ) {
	$wp_customize->selective_refresh->add_partial( 'magickAd_single_button_image_three', array(
	            'selector'        => '.magick_custom_single_button_class_three',
	        ) );
}
//add_action( 'customize_register', 'magic_cutom_single_button_customize_register_images_three' );








//广告位判断
$ad=get_theme_mod( 'magickAd_single_button_space' );
if($ad!==0) {
	$ad_space = get_theme_mod( 'magickAd_single_button_space' );
	if($ad_space==1) {
		//一个广告位
		add_action( 'customize_register', 'magickAd_single_button_one' );
	} elseif ($ad_space==2) {
		//两个广告位
		add_action( 'customize_register', 'magickAd_single_button_one' );
		add_action( 'customize_register', 'magickAd_single_button_two' );
	} elseif ($ad_space==3) {
		//三个广告位
		add_action( 'customize_register', 'magickAd_single_button_one' );
		add_action( 'customize_register', 'magickAd_single_button_two' );
		add_action( 'customize_register', 'magickAd_single_button_three' );
	}
	;
}
;
//判断
//判断一号广告位是否存在
if($ad>=1) {
	//判断展示类型
	$ad_type = get_theme_mod( 'magickAd_single_button_type_one' );
	if($ad_type==0) {
		//加载HTML设置模块
		add_action( 'customize_register', 'magickAd_single_button_html_one' );
		//展示HTML模块内容
		add_filter('the_content', 'magicAd_add_after_single_content_one');
		//加载HTML铅笔
		add_action( 'customize_register', 'magic_cutom_single_button_customize_register_html_one' );
	} elseif ($ad_type==1) {
		//加载图片模块
		add_action( 'customize_register', 'magickAd_single_button_images_one' );
		//展示图片模块内容
		add_filter('the_content', 'magicAd_add_after_single_content_image_one');
		//加载图片铅笔
		add_action( 'customize_register', 'magic_cutom_single_button_customize_register_images_one' );
	} elseif ($ad_type==2) {
		//类型为幻灯片
		echo "slid";
	}
	;
	//判断1号展示平台
	$magick_platefrom_value = get_theme_mod( 'magickAd_single_button_try_one' );
	if($magick_platefrom_value==0) {
		//全平台展示
	} elseif($magick_platefrom_value==1) {
		//仅电脑端展示
		add_filter('the_content', 'magick_custom_class_one_pc');
	} elseif($magick_platefrom_value==2) {
		//仅平板端展示
		add_filter('the_content', 'magick_custom_class_one_flat');
	} elseif($magick_platefrom_value==3) {
		//仅手机端展示
		add_filter('the_content', 'magick_custom_class_one_phone');
	}
	;
}
;
//判断二号广告位是否存在
if($ad>=2) {
	//判断展示类型
	$ad_type = get_theme_mod( 'magickAd_single_button_type_two' );
	if($ad_type==0) {
		//加载HTML设置模块
		add_action( 'customize_register', 'magickAd_single_button_html_two' );
		//展示HTML模块内容
		add_filter('the_content', 'magicAd_add_after_single_content_two');
		//加载HTML铅笔
		add_action( 'customize_register', 'magic_cutom_single_button_customize_register_html_two' );
	} elseif ($ad_type==1) {
		//加载图片设置模块
		add_action( 'customize_register', 'magickAd_single_button_images_two' );
		//展示图片模块内容
		add_filter('the_content', 'magicAd_add_after_single_content_image_two');
		//加载图片铅笔
		add_action( 'customize_register', 'magic_cutom_single_button_customize_register_images_two' );
	} elseif ($ad_type==2) {
		//类型为幻灯片
		echo "slid";
	}
	;
	//判断2号展示平台
	$magick_platefrom_value = get_theme_mod( 'magickAd_single_button_try_two' );
	if($magick_platefrom_value==0) {
		//全平台展示
	} elseif($magick_platefrom_value==1) {
		//仅电脑端展示
		add_filter('the_content', 'magick_custom_class_two_pc');
	} elseif($magick_platefrom_value==2) {
		//仅平板端展示
		add_filter('the_content', 'magick_custom_class_two_flat');
	} elseif($magick_platefrom_value==3) {
		//仅手机端展示
		add_filter('the_content', 'magick_custom_class_two_phone');
	}
	;
}
;
//判断三号广告位是否存在
if($ad>=3) {
	//判断展示类型
	$ad_type = get_theme_mod( 'magickAd_single_button_type_three' );
	if($ad_type==0) {
		//加载HTML设置模块
		add_action( 'customize_register', 'magickAd_single_button_html_three' );
		//展示HTML模块内容
		add_filter('the_content', 'magicAd_add_after_single_content_three');
		//加载HTML铅笔
		add_action( 'customize_register', 'magic_cutom_single_button_customize_register_html_three' );
	} elseif ($ad_type==1) {
		//加载图片设置模块
		add_action( 'customize_register', 'magickAd_single_button_images_three' );
		//展示图片模块内容
		add_filter('the_content', 'magicAd_add_after_single_content_image_three');
		//加载图片铅笔
		add_action( 'customize_register', 'magic_cutom_single_button_customize_register_images_three' );
	} elseif ($ad_type==2) {
		//类型为幻灯片
		echo "slid";
	}
	;
	//判断3号展示平台
	$magick_platefrom_value = get_theme_mod( 'magickAd_single_button_try_three' );
	if($magick_platefrom_value==0) {
		//全平台展示
	} elseif($magick_platefrom_value==1) {
		//仅电脑端展示
		add_filter('the_content', 'magick_custom_class_three_pc');
	} elseif($magick_platefrom_value==2) {
		//仅平板端展示
		add_filter('the_content', 'magick_custom_class_three_flat');
	} elseif($magick_platefrom_value==3) {
		//仅手机端展示
		add_filter('the_content', 'magick_custom_class_three_phone');
	}
	;
}
;