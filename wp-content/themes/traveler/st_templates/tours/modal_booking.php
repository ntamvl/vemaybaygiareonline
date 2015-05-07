<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours modal booking
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
<h3><?php printf(st_get_language('tour_you_are_booking_for_d'),get_the_title())?></h3>

<div id="booking_modal_<?php echo get_the_ID() ?>" class="booking_modal_form">
    <?php  wp_nonce_field('submit_form_order','travel_order'); ?>
    <?php
    $info_price = STTour::get_info_price();
    $price = $info_price['price'];
    $count_sale = $info_price['discount'];
    if(!empty($count_sale)){
        $price = $info_price['price'];
        $price_sale = $info_price['price_old'];
    }
    $day = get_post_meta(get_the_ID() , 'duration_day' ,true);
    ?>
    <?php $type_tour = get_post_meta(get_the_ID(),'type_tour',true); ?>
    <?php $type_price = get_post_meta(get_the_ID(),'type_price',true); ?>
    <input type="hidden" name="item_id" value="<?php echo get_the_ID()?>">
    <input type="hidden" name="discount" value="<?php echo esc_html($count_sale) ?>">
    <input name="price" value="<?php echo get_post_meta(get_the_ID(),'price',true) ?>" type="hidden">
    <input name="number" class="number_room st_tour_number" type="hidden" min="1" value="1">
    <input type="hidden" name="type_tour" value="<?php echo esc_html($type_tour) ?>">
    <input type="hidden" name="type_price" value="<?php echo esc_html($type_price) ?>">
    <input type="hidden" name="adult_number" class="st_tour_adult" value="1">
    <input type="hidden" name="children_number" class="st_tour_children"  value="0">
    <input name="duration" class="" type="hidden" value="<?php echo esc_attr($day) ?>">
    <?php if($type_tour == 'daily_tour'){ ?>
        <input name="check_in"  type="hidden" value="" class="tour_book_date" required />
    <?php }else{ ?>
        <input name="check_in"  type="hidden"  value="<?php echo get_post_meta(get_the_ID(),'check_in',true) ?>">
        <input name="check_out" type="hidden"  value="<?php echo get_post_meta(get_the_ID(),'check_out',true) ?>">
    <?php } ?>
    <?php echo st()->load_template('check_out/check_out')?>
</div>
