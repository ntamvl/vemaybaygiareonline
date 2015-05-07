<?php
/*
Template Name: Home
*/
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Template Name : Home
 *
 * Created by ShineTheme
 *
 */
get_header();
while(have_posts()){
    the_post();
    the_content();
}
get_footer();
