<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Single room
 *
 * Created by ShineTheme
 *
 */
$hotel_id=get_post_meta(get_the_ID(),'room_parent',true);
if($link=get_permalink($hotel_id)){
    wp_safe_redirect($link);die;
}else{
    wp_safe_redirect(home_url('/'));die;
}
get_header();
get_template_part('breadcrumb');
?>
<?php get_footer( ) ?>