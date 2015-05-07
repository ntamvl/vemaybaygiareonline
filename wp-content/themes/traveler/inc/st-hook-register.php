<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * List all hook register
 *
 * Created by ShineTheme
 *
 */
//Default Framwork Hooked
add_filter( 'wp_title', 'st_wp_title', 10, 2 );
add_action( 'wp', 'st_setup_author' );
add_action( 'after_setup_theme', 'st_setup_theme' );
add_action('wp_head','st_set_post_view');
add_action( 'widgets_init', 'st_add_sidebar' );
//Add Scripts
add_action('wp_enqueue_scripts','st_add_scripts');
//Ad admin scripts
add_action('admin_enqueue_scripts','st_admin_add_scripts');
//add Favicon
add_action('wp_head','st_add_favicon');
add_action('wp_head','st_add_ie8_support',999);
add_action('wp_head','st_add_custom_style',999);
//add Preload
add_action('before_body_content','st_before_body_content');
//add_body_class
/**
 *  * Nice Scroll Class
 *
 *
 * */
add_action('body_class','st_add_body_class');
//add html compression
add_action('init','st_add_compress_html');
add_filter('st_container','st_control_container');
//Change Sidebar Position of Blog
add_filter('st_blog_sidebar','st_blog_sidebar');
add_filter('st_blog_sidebar_id','st_blog_sidebar_id');
add_filter('comment_excerpt','st_change_comment_excerpt_limit');
//add_action();
add_filter('admin_body_class','st_admin_body_class');
add_action('wp_head','st_add_custom_css');
add_filter('post_gallery', 'st_inside_post_gallery', 10, 2);

add_action('login_enqueue_scripts','st_add_login_css');

add_action('wp_footer','st_show_box_icon_css');


