<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * function
 *
 * Created by ShineTheme
 *
 */

if(!defined('ST_TEXTDOMAIN'))
define ('ST_TEXTDOMAIN','traveler');

$status=load_theme_textdomain(ST_TEXTDOMAIN,get_template_directory().'/language');


//require get_template_directory().'/inc/class.traveler.php';

get_template_part('inc/class.traveler');

st();
get_template_part('demo/demo_functions');
if ( ! isset( $content_width ) ) $content_width = 900;

