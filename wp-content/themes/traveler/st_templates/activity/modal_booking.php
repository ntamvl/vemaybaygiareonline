<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Activity modal booking
 *
 * Created by ShineTheme
 *
 */

$paypal_allow=false;

if(class_exists('STPaypal'))
{
    $paypal_allow=true;
}
//Logged in User Info
global $firstname , $user_email;
get_currentuserinfo();



$paypal_allow=apply_filters('st_checkout_paypal_allow',$paypal_allow);


?>
<h3><?php printf(st_get_language('you_are_booking_for_s'),get_the_title())?></h3>

<div id="booking_modal_<?php echo get_the_ID() ?>" class="booking_modal_form">
    <?php
        wp_nonce_field('submit_form_order','travel_order');
    ?>

    <input type="hidden" name="item_id" value="<?php echo get_the_ID()?>">
    <input type="hidden" name="discount" value="<?php echo get_post_meta(get_the_ID(),'discount',true) ?>">
    <input name="price" value="<?php echo get_post_meta(get_the_ID(),'price',true) ?>" type="hidden">
    <input name="number" class="number_activity_2" type="hidden">
    <input name="check_in"  type="hidden"  value="<?php echo get_post_meta(get_the_ID(),'check_in',true) ?>">
    <input name="check_out" type="hidden"  value="<?php echo get_post_meta(get_the_ID(),'check_out',true) ?>">


    <?php echo st()->load_template('check_out/check_out')?>


</div>
