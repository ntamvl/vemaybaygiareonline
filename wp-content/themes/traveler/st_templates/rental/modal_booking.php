<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental modal booking
 *
 * Created by ShineTheme
 *
 */

//Logged in User Info
global $firstname , $user_email;
get_currentuserinfo();



?>
<h3><?php printf(st_get_language('tour_you_are_booking_for_d'),get_the_title())?></h3>

<div id="booking_modal_<?php echo get_the_ID() ?>" class="booking_modal_form">
    <?php
    wp_nonce_field('submit_form_order','travel_order');
    ?>
    <?php

    ?>
    <input type="hidden" name="item_id" value="<?php echo get_the_ID()?>">
    <input name="price" value="<?php echo STRental::get_price() ?>" type="hidden">
    <input name="number" type="hidden" min="1" value="1">
    <?php echo st()->load_template('check_out/check_out')?>


</div>
