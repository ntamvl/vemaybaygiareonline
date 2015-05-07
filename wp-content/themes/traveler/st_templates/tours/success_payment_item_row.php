<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours payment success
 *
 * Created by ShineTheme
 *
 */


$object_id=$key;
$total=0;
$check_in=$data['data']['check_in'];
$check_out=$data['data']['check_out'];
$number=$data['number'];
$price=$data['price'];
if(!$number) $number=1;
$total+= $price;
$link='';
if(isset($object_id) and $object_id){
    $link=get_permalink($object_id);
}
?>
<?php $type_price = get_post_meta($object_id,'type_price',true); ?>
<tr>
    <td><?php echo esc_html($i) ?></td>
    <td>
        <a href="<?php echo esc_url($link)?>" target="_blank">
        <?php echo get_the_post_thumbnail($key,array(360,270,'bfi_thumb'=>true),array('style'=>'max-width:100%;height:auto'))?>
        </a>
    </td>
    <td>
        <p><strong><?php st_the_language('booking_address') ?></strong> <?php echo get_post_meta($object_id,'address',true)?> </p>
        <p><strong><?php st_the_language('booking_email') ?></strong> <?php echo get_post_meta($object_id,'contact_email',true)?> </p>
        <p><strong><?php st_the_language('booking_tour') ?></strong> <?php  echo get_the_title($object_id)?></p>
        <p><strong><?php st_the_language('tour_max_people') ?>: </strong> <?php echo get_post_meta($object_id,'max_people',true)?> </p>
        <?php if($type_price == 'people_price'){ ?>
            <p><strong><?php _e('Adult Price',ST_TEXTDOMAIN) ?>: </strong>
                <?php echo get_post_meta($order_id,'adult_number',true);?> x
                <?php echo TravelHelper::format_money(get_post_meta($object_id,'adult_price',true));?>
            </p>
            <p><strong><?php _e('Child Price',ST_TEXTDOMAIN) ?>: </strong>
                <?php echo get_post_meta($order_id,'child_number',true);?> x
                <?php echo TravelHelper::format_money(get_post_meta($object_id,'child_price',true));?>
            </p>
        <?php }else{ ?>
            <p><strong><?php st_the_language('booking_amount') ?></strong> <?php echo esc_html($number)?></p>
            <p><strong><?php st_the_language('booking_price') ?></strong>
                <?php echo TravelHelper::format_money($price);?>
            </p>
        <?php } ?>

        <p><strong><?php st_the_language('tour_date') ?> : </strong>
            <?php $type_tour = get_post_meta($order_id,'type_tour',true); ?>
            <?php if($type_tour == 'specific_date'){ ?>
                <?php if($check_in) echo date('m/d/Y',strtotime($check_in)); ?>
                -
                <?php if($check_out) echo date('m/d/Y',strtotime($check_out)); ?>
            <?php }else{ ?>
                <?php if($check_in) echo date('m/d/Y',strtotime($check_in)); ?>
                <p><strong>
                <?php _e('Duration',ST_TEXTDOMAIN) ?>: </strong>
                <?php  $day =  get_post_meta($object_id,'duration_day',true)?>
                <?php echo esc_html($day) ?>
                <?php if($day > 1) _e('days',ST_TEXTDOMAIN); else _e('day',ST_TEXTDOMAIN) ?>
                </p>
        <?php } ?>
        </p>
    </td>
</tr>