<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STOptiontree
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STOptiontree'))
{
    class STOptiontree
    {
        public $theme;

        function __construct()
        {
            if (!class_exists('OT_Loader')) return;
            add_action('admin_init', array($this, 'custom_theme_options'));


            add_action('admin_init', array($this, 'custom_meta_boxes'));

            $this->theme = wp_get_theme();

            add_filter('ot_header_version_text', array($this, 'ot_header_version_text'));

            add_filter('ot_theme_options_menu_slug', array($this, 'change_menu_slug'));
            add_filter('ot_theme_options_icon_url', array($this, 'change_icon_url'));
            add_filter('ot_theme_options_parent_slug', array($this, 'change_parent_slug'));
            add_filter('ot_theme_options_menu_title', array($this, 'change_menu_title'));
            add_filter('ot_theme_options_position', array($this, 'change_position'));
            add_filter('ot_header_logo_link', array($this, '_change_header_logo_link'));

            //Check WPML Installed
            if(defined('ICL_LANGUAGE_CODE') and defined('ICL_SITEPRESS_VERSION')){

                add_action('admin_init', array($this, '_copy_default_theme_option'));
                add_filter('ot_options_id',array($this,'_get_option_by_lang'),10,1);
            }

        }
        function _get_option_by_lang($option)
        {
            return $option_key = $option.'_'.ICL_LANGUAGE_CODE;
        }

        function _copy_default_theme_option()
        {
            $option_name='option_tree';
            if(defined('ICL_SITEPRESS_VERSION') && defined('ICL_LANGUAGE_CODE')){
                global $sitepress;
                $options = get_option($option_name);
                $wpml_lang = icl_get_languages('skip_missing=0&orderby=custom');
                $default_lang = $sitepress->get_default_language();
                if(is_array($wpml_lang) && !empty($wpml_lang))
                {
                    foreach ($wpml_lang as $lang) {
                        $lang_option = get_option($option_name.'_'.$lang['language_code']);
                        if($lang_option==''){
                            update_option($option_name.'_'.$lang['language_code'],$options);
                        }
                    }
                }
            }
        }

        function _change_header_logo_link()
        {
            return "<a ><img src='".get_template_directory_uri()."/css/admin/logo-st.png'></a>";
        }
        function change_position()
        {
            if(class_exists('Envato_WP_Toolkit'))
            {
                return 59;
            }
            return 58;
        }
        function change_menu_title()
        {
            return __('Traveler Settings',ST_TEXTDOMAIN);
        }
        function change_parent_slug()
        {
            return false;
        }
        function change_icon_url()
        {
            return "dashicons-st-traveler";
        }
        function change_menu_slug($slug)
        {
            return 'st_traveler_options';
        }

        function ot_header_version_text($title)
        {
            $title=  esc_html(  $this->theme->display('Name') );
            $title.=' - '. sprintf(__('Version %s', ST_TEXTDOMAIN), $this->theme->display('Version'));

            if(class_exists('SitePress') and defined('ICL_LANGUAGE_NAME'))
            {
                $title.=' '.sprintf(__('for %s',ST_TEXTDOMAIN),ICL_LANGUAGE_NAME);

            }


            return $title;
        }



        function custom_meta_boxes()
        {
            /**
             * Get a copy of the saved settings array.
             */
            $custom_metabox=array();

            include_once ST()->dir('st-metabox.php');

            /**
             * Register our meta boxes using the
             * ot_register_meta_box() function.
             */
            if ( function_exists( 'ot_register_meta_box' ) )
            {
                if(!empty($custom_metabox))
                {
                    foreach ($custom_metabox as $value)
                    {
                        ot_register_meta_box( $value );
                    }
                }
            }

        }

        function custom_theme_options()
        {

            /**
             * Get a copy of the saved settings array.
             */
            $saved_settings = get_option(ot_settings_id(), array());

            $custom_settings=array();

            include_once ST()->dir('st-theme-options.php');

            /* allow settings to be filtered before saving */
            $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );

            /* settings are not the same update the DB */
            if ( $saved_settings !== $custom_settings ) {
                update_option( ot_settings_id(), $custom_settings );
            }
        }




    }
    new STOptiontree();
}
