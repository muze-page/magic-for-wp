<?php
/**
*
*
* @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
*
* @package    TGM-Plugin-Activation
* @subpackage Example
* @version    2.6.1 for plugin Test
* @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
* @copyright  Copyright ( c ) 2011, Thomas Griffin
* @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
* @link       https://github.com/TGMPA/TGM-Plugin-Activation
*/

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'test_register_required_plugins' );

function test_register_required_plugins() {

    $plugins = array(

        array(
            'name'     => 'Advanced Custom Fields',
            'slug'    => 'advanced-custom-fields-pro',
            'source' => plugin_dir_url( __FILE__ ) . 'advanced-custom-fields-pro.zip',
            'required'    => true,
            'version'            => '',
            'force_activation'   => true,
            'force_deactivation' => false,
            'external_url'       => 'https://www.npc.ink',
            'is_callable'        => '',
        ),

    );

    $config = array(
        'id'           => 'magicks',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'plugins.php',
        'capability'   => 'manage_options',
        'has_notices'  => true,
        'dismissable'  => false,
        'dismiss_msg'  => '您必须安装此插件，才能保证功能正常使用',
        'is_automatic' => false,
        'message'      => '<h3>请您一定要安装下方插件</h3>',

    );

    tgmpa( $plugins, $config );
}
