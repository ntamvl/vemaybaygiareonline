<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental payment success item
 *
 * Created by ShineTheme
 *
 */
$object_id=$key;
$total=0;
$check_in=$data['data']['check_in'];
$check_out=$data['data']['check_out'];
$datediff=STDate::date_diff(strtotime($check_in),strtotime($check_out));
$number=$data['number'];
$price=$data['price'];
if(!$number) $number=1;

if($datediff>=1)
{
    $total+= ($price)*$datediff*$number;
}else{
    $total+= $price*$number;
}
$rental_link=get_permalink($object_id);
?>
<tr>
    <td><?php echo esc_html($i) ?></td>
    <td >
        <a href="<?php echo esc_url($rental_link)?>" target="_blank">
        <?php echo get_the_post_thumbnail($key,array(360,270,'bfi_thumb'=>true),array('style'=>'max-width:100%;height:auto'))?>
        </a>
    </td>
    <td valign="top">
        <p><strong><a href="<?php echo esc_url($rental_link)?>" target="_blank"> <?php st_the_language('booking_room') ?></strong> <?php  echo get_the_title($object_id)?></a></p>
        <p><strong><?php st_the_language('booking_amount') ?></strong> <?php echo esc_html($number)?></p>
        <p><strong><?php st_the_language('booking_price') ?></strong> <?php
            echo TravelHelper::format_money($price);
            ?></p>
        <p><strong><?php st_the_language('booking_check_in') ?></strong> <?php echo @date(get_option('date_format'),strtotime($check_in)) ?></p>
        <p><strong><?php st_the_language('booking_check_out') ?></strong> <?php echo @date(get_option('date_format'),strtotime($check_out)) ?></p>
    </td>
</tr>