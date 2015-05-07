<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * hotel payment item row
 *
 * Created by ShineTheme
 *
 */

$hotel_id=$key;
$object_id=$key;
$total=0;
$room_id=$data['data']['room_id'];
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
$hotel_link='';
if(isset($hotel_id) and $hotel_id){
    $hotel_link=get_permalink($hotel_id);
}
?>
<tr>
    <td><?php echo esc_html($i) ?></td>
    <td>
        <a href="<?php echo esc_url($hotel_link)?>" target="_blank">

        <?php echo get_the_post_thumbnail($key,array(360,270,'bfi_thumb'=>true),array('style'=>'max-width:100%;height:auto'))?>
        </a>
    </td>
    <td>
        <?php if(isset($hotel_id) and $hotel_id):?>

            <p style="margin-top:10px;"><strong> <?php st_the_language('hotel') ?>:</strong> <a href="<?php echo esc_url($hotel_link)?>" target="_blank"><?php echo strtoupper( get_the_title($hotel_id))?> </a></p>

            <p><strong><?php st_the_language('booking_address') ?></strong> <?php echo get_post_meta($hotel_id,'address',true)?> </p>
            <p><strong><?php st_the_language('booking_email') ?></strong> <?php echo get_post_meta($hotel_id,'email',true)?> </p>
            <p><strong><?php st_the_language('booking_phone') ?></strong> <?php echo get_post_meta($hotel_id,'phone',true)?> </p>

        <?php endif;?>

        <p><strong><?php st_the_language('booking_room') ?></strong> <?php  echo get_the_title($room_id)?></p>


        <p><strong><?php st_the_language('booking_room_number') ?></strong> <?php echo esc_html($number)?></p>
        <p><strong><?php st_the_language('booking_price') ?></strong> <?php
            echo TravelHelper::format_money($price);
            ?></p>
        <p><strong><?php st_the_language('booking_check_in') ?></strong> <?php echo @date(get_option('date_format'),strtotime($check_in)) ?></p>
        <p><strong><?php st_the_language('booking_check_out') ?></strong> <?php echo @date(get_option('date_format'),strtotime($check_out)) ?></p>
    </td>
</tr>