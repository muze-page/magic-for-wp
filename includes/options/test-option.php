<?php

//添加自定义设置选项
function youself_customize_register( $wp_customize ) {

	
	//添加主题设置面板，ID = youself_options
	$wp_customize->add_panel( 'youself_options',
	array(
		'title'       => __( '添加设置选项演示', 'npcink' ),
		'description' => __( 'Npcink出品', 'npcink' ),
		'priority'    => 30,
		'capabitity'  => 'edit_theme_options',
	) );
	
	//添加1-1选项节点，ID = youself_sections_text
	$wp_customize->add_section('youself_sections_text',
	array(                
		'title'     => '1-1文本设置',
		'description' => '主题的文本设置',     
		'panel' => 'youself_options',
	) );
	//添加1-1-1的文本框，ID = youself_sections_text_one
	$wp_customize->add_setting('youself_sections_text_one',
		array(
			'default' => '1-1-1',
		)
	);
	$wp_customize->add_control('youself_sections_text_one',
		array(
			'label' => '文本设置：1-1-1',
			'section' => 'youself_sections_text',
			'type' => 'text',
		)
	);
	//添加1-1-2的文本框，ID = youself_sections_text_two
	$wp_customize->add_setting('youself_sections_text_two',
		array(
			'default' => '1-1-2',
		)
	);
	$wp_customize->add_control('youself_sections_text_two',
		array(
			'label' => '文本设置：1-1-2',
			'section' => 'youself_sections_text',
			'type' => 'text',
		)
	);
	
	//添加1-2选项节点
		$wp_customize->add_section('youself_sections_two_text',
	array(                
		'title'     => '1-2设置',
		'description' => '主题的文本设置',     
		'panel' => 'youself_options',
	) );
	
	//添加1-2-1的文本框
		$wp_customize->add_setting('youself_sections_text_two_one',
		array(
			'default' => '1-2-1',
		)
	);
	$wp_customize->add_control('youself_sections_text_two_one',
		array(
			'label' => '文本设置：1-2-1',
			'section' => 'youself_sections_two_text',
			'type' => 'text',
		)
	);
	
		//添加1-2-2的文本框
		$wp_customize->add_setting('youself_sections_text_two_two',
		array(
			'default' => '1-2-2',
		)
	);
	$wp_customize->add_control('youself_sections_text_two_two',
		array(
			'label' => '文本设置：1-2-2',
			'section' => 'youself_sections_two_text',
			'type' => 'text',
		)
	);
	
	
	//添加文本框
	$wp_customize->add_setting( 'sample_default_textarea',
   array(
      'default' => '',
      'transport' => 'refresh',
      //'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);
 
$wp_customize->add_control( 'sample_default_textarea',
   array(
      'label' => __( 'Default Textarea Control' ),
      'description' => esc_html__( 'Sample description' ),
      'section' => 'youself_sections_two_text',
      'priority' => 10, // Optional. Order priority to load the control. Default: 10
      'type' => 'textarea',
      'capability' => 'edit_theme_options', // 可选择的默认值：“edit_theme_options”
      'input_attrs' => array( // Optional.
         'class' => 'my-custom-class',
         'style' => 'border: 1px solid #999',
         'placeholder' => __( 'Enter message...' ),
      ),
   )
);



	$wp_customize->add_setting( 'sample_date_time',
   array(
      'default' => '2020-08-28 16:30:00',
      'transport' => 'refresh',
      'sanitize_callback' => 'skyrocket_date_time_sanitization'
   )
);
 
$wp_customize->add_control( new WP_Customize_Date_Time_Control( $wp_customize, 'sample_date_time',
   array(
      'label' => __( '默认日期控件' ),
      'description' => esc_html__( '这是日期时间控件。它还设置了最大和最小年份。' ),
      'section' => 'youself_sections_two_text',
      'include_time' => true, // Optional. Default: true
      'allow_past_date' => true, // Optional. Default: true
      'twelve_hour_format' => true, // Optional. Default: true
      'min_year' => '2010', // Optional. Default: 1000
      'max_year' => '2025' // Optional. Default: 9999
   )
) );









class Skyrocket_Simple_Notice_Custom_Controls extends WP_Customize_Control {
   /**
    * 正在呈现的控件类型
    */
   public $type = 'simple_notice';
   /**
    * 在自定义程序中渲染控件
    */
   public function render_content() {
   ?>
   <div class="simple-notice-custom-control">
      <?php if( !empty( $this->label ) ) { ?>
         <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><hr />
      <?php } ?>
      <?php if( !empty( $this->description ) ) { ?>
         <span class="customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
      <?php } ?>
   </div>
   <?php
   }
}



// 样本自定义控件测试
$wp_customize->add_setting( 'sample_custom_control',
   array(
      'default' => '',
      'transport' => 'refresh',
      'sanitize_callback' => 'wp_filter_nohtml_kses'
   )
);
$wp_customize->add_control( new Skyrocket_Simple_Notice_Custom_Controls( $wp_customize, 'sample_custom_control',
   array(
      'label' => __( '自定义控件示例' ),
      'description'  => esc_html__( '这是自定义控件描述。' ),
      'section' => 'youself_sections_two_text'
   )
) );



$wp_customize->add_section( new Skyrocket_Upsell_Sections( $wp_customize, 'upsell_sectionss',
   array(
      'title' => __( '简单的测试', 'skyrocket' ),//标题
      'url' => 'https://skyrocketthemes.com',//跳转的网址
      'backgroundcolor' => 'red',//背景色
      'textcolor' => '#fff',//文本颜色
      'priority' => 2,//显示的顺序
   )
) );








	





//-----------------------------------------------------------------------------
    	//给相关设置项目加小铅笔
	if ( isset( $wp_customize->selective_refresh ) ) {
        //1-1-1
        $wp_customize->selective_refresh->add_partial( 'youself_sections_text_one', array(
            'selector'        => '.1-1-1',
            //'render_callback' => 'lifet_customize_partial_npcink_sections_text_one',
        ) );
        //1-1-2
            $wp_customize->selective_refresh->add_partial( 'youself_sections_text_two', array(
                'selector'        => '.1-1-2',
                //'render_callback' => 'lifet_customize_partial_npcink_sections_text_two',
            ) );
            
            //1-2-1
                $wp_customize->selective_refresh->add_partial( 'youself_sections_text_two_one', array(
            'selector'        => '.1-2-1',
            //'render_callback' => 'lifet_customize_partial_npcink_sections_text_ones',
        ) );
            //1-2-2
                        $wp_customize->selective_refresh->add_partial( 'youself_sections_text_two_two', array(
            'selector'        => '.1-2-2',
            //'render_callback' => 'lifet_customize_partial_npcink_sections_text_onesee',
        ) );
            
        }



}
add_action( 'customize_register', 'youself_customize_register' );



include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';


//add_action( 'customize_register', 'my_customize_register' );
//
//function my_customize_register($wp_customize) {
//
//  //类定义必须在my_custome_register函数中
//  class ublxlportfolio_textarea extends WP_Customize_Control {  }
//
//  //其他东西
//}

/**
 * 简单通知自定义控件
 */
 




//引入我们需要的类
include_once ABSPATH . 'wp-includes/class-wp-customize-section.php';

//判断有没有这个WP_Customize_Control类
if ( class_exists( 'WP_Customize_Control' ) ) {

    //新做一个类

    class Skyrocket_Custom_Sections extends WP_Customize_Section {

        ////在类的内部可以调用外部不能 可以被继承
        //        protected function get_skyrocket_resource_url() {
        //            if ( strpos( wp_normalize_path( __DIR__ ), wp_normalize_path( WP_PLUGIN_DIR ) ) === 0 ) {
        //                // 我们在插件目录中，需要相应地确定url。
        //                //获取传递的插件__FILE__的URL目录路径（带有尾随斜杠）
        //                return plugin_dir_url( __DIR__ );
        //            }
        //
        ////检索活动主题的模板目录URI( 尾部有斜杠 )。
        //            return trailingslashit( get_template_directory_uri() );
        //        }
    }

    class Skyrocket_Upsell_Sections extends Skyrocket_Custom_Sections {
        /**
        * 正在呈现的控件类型
        */
        public $type = 'skyrocket-upsell';
        /**
        * 追加销售URL
        */
        public $url = '';
        /**
        * 控件的背景色
        */
        public $backgroundcolor = '';
        /**
        * 控件的文本颜色
        */
        public $textcolor = '';
        /**
        * 加入我们的脚本和样式
        */

        //public function enqueue() {
        //    wp_enqueue_script( 'skyrocket-custom-controls-js', $this->get_skyrocket_resource_url() . 'js/customizer.js', array( 'jquery' ), '1.0'//, true );
        //    wp_enqueue_style( 'skyrocket-custom-controls-css', $this->get_skyrocket_resource_url() . 'css/customizer.css', array(), '1.0', 'all' // );
        //}
        /**
        * 渲染部分以及已添加到其中的控件。
        */
        protected function render() {
            $bkgrndcolor = !empty( $this->backgroundcolor ) ? esc_attr( $this->backgroundcolor ) : '#fff';
            $color = !empty( $this->textcolor ) ? esc_attr( $this->textcolor ) : '#555d66';
            ?>
            <li id = "accordion-section-<?php echo esc_attr( $this->id ); ?>" class = "skyrocket_upsell_section accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
            <h3 class = 'upsell-section-title' <?php echo ' style="color:' . $color . ';border-left-color:' . $bkgrndcolor .';border-right-color:' . $bkgrndcolor .';"';
            ?>>
            <a href = "<?php echo esc_url( $this->url); ?>" target = '_blank'<?php echo ' style="background-color:' . $bkgrndcolor . ';color:' . $color .';"';
            ?>><?php echo esc_html( $this->title );
            ?></a>
            </h3>
            </li>
            <?php
        }
    }

}