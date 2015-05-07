<?php
/**
 * Plugin Name: Traveler-code
 * Plugin URI: #
 * Description: Plugin only for Theme: Shinetheme Traveler. Please only use with Shinetheme Traveler
 * Version: 1.0.6
 * Author: Shinetheme
 * Author URI: http://shinetheme.com
 * Requires at least: 3.8
 * Tested up to: 4.0
 */
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$theme_name = wp_get_theme();
$theme_used=$theme_name->get('TextDomain');
if(!$theme_used){
    $theme_used=$theme_name->get('Template');
}

if(!defined('STP_TEXTDOMAIN'))
{
    define('STP_TEXTDOMAIN','traveler-code');
}


if($theme_used == 'traveler') {

    if(!defined('ST_TEXTDOMAIN'))
    {
        define('ST_TEXTDOMAIN','traveler');
    }



    if(!defined('ST_PLUGIN_DIR'))
    {
        require_once plugin_dir_path(__FILE__) . '/inc/class.stplugin.php';


    if(!class_exists('STTravelCode'))
    {
        class STTravelCode extends STPlugin
        {
            function __construct()
            {



                //require plugin_dir_path(__FILE__).'/importer/st.init.php';
                require plugin_dir_path(__FILE__).'/update_taxonomy.php';
                parent::__construct(__FILE__);

                $file = array(
                    'importer/st.init',
                    'plugins/Tax-meta-class/Tax-meta-class',
                    'plugins/cool-php-captcha/captcha',
                    'plugins/TwitterAPIExchange',
                    'plugins/class-wp-twitter-api',
                    'include/attribute_meta',
                    '',
                    //'user/user'
                );


                $this->load_libs($file);
            }
            static function _plugins_loaded()
            {
                load_plugin_textdomain('traveler-code',false,trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . trailingslashit( 'lang' ));
            }

            static function load_tax_meta()
            {
                $file = array(
                    'plugins/Tax-meta-class/Tax-meta-class',
                );

                $plugin = new STPlugin(__FILE__);

                $plugin->load_libs($file);
            }

            static function loadComposer()
            {
                $file = array(
                    'plugins/vendor/autoload',
                );

                $plugin = new STPlugin(__FILE__);

                $plugin->load_libs($file);
            }

        }

        add_action('plugins_loaded',array('STTravelCode','_plugins_loaded'));

        STTravelCode::load_tax_meta();
        STTravelCode::loadComposer();

        add_action('after_setup_theme', 'st_init_travel_plugin');

        function st_init_travel_plugin()
        {
            new STTravelCode();
        }
    }


}

}


