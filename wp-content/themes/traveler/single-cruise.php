<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Single cruise
 *
 * Created by ShineTheme
 *
 */
get_header();
get_template_part('breadcrumb');
?>
<div class="container">
    <div class="booking-item-details">
        <?php
        $detail_hotel_layout=apply_filters('st_cruise_detail_layout',st()->get_option('cruise_single_layout'));
        if($detail_hotel_layout) {
            $content=STTemplate::get_vc_pagecontent($detail_hotel_layout);
            echo balanceTags( $content);
        }
        ?>
        <div class="gap"></div>
    </div>
</div>
<?php get_footer( ) ?>