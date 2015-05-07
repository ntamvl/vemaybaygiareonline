<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars success payment item row
 *
 * Created by ShineTheme
 *
 */

$order_code=STInput::get('order_code');
$object_id=$key;
$total=0;
$check_in=get_post_meta($order_code,'check_in',true);
$check_out=get_post_meta($order_code,'check_out',true);
$check_in_time=get_post_meta($order_code,'check_in_time',true);
$check_out_time=get_post_meta($order_code,'check_out_time',true);
$price=get_post_meta($order_code,'item_price',true);
$number=get_post_meta($order_code,'item_number',true);
?>
<tr>
    <td><?php echo esc_html($i) ?></td>
    <td>
        <a href="<?php echo esc_url(get_the_permalink($object_id))?>" target="_blank">
        <?php echo get_the_post_thumbnail($key,array(360,270,'bfi_thumb'=>true),array('style'=>'max-width:100%;height:auto'))?>
        </a>
    </td>
    <td>
        <p><strong><?php st_the_language('booking_address') ?></strong> <?php echo get_post_meta($object_id,'cars_address',true)?> </p>
        <p><strong><?php st_the_language('booking_email') ?></strong> <?php echo get_post_meta($object_id,'cars_email',true)?> </p>
        <p><strong><?php st_the_language('booking_phone') ?></strong> <?php echo get_post_meta($object_id,'cars_phone',true)?> </p>
        <p><strong><?php st_the_language('booking_car') ?></strong> <?php  echo get_the_title($object_id)?></p>
        <p><strong><?php st_the_language('booking_amount') ?></strong> <?php echo esc_html($number)?></p>
        <p><strong><?php st_the_language('booking_price') ?></strong> <?php
            echo TravelHelper::format_money($price);
            ?> / <?php st_the_language('booking_hour') ?></p>
        <p><strong><?php st_the_language('booking_check_in') ?></strong> <?php echo @date(get_option('date_format'),strtotime($check_in)).' '.$check_in_time ?></p>
        <p><strong><?php st_the_language('booking_check_out') ?></strong> <?php echo @date(get_option('date_format'),strtotime($check_out)).' '.$check_out_time ?></p>
    </td>
</tr>