<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Email booking information cars
 *
 * Created by ShineTheme
 *
 */

if(!isset($order_id)) return false;
$first_name=get_post_meta($order_id,'st_first_name',true);
$last_name=get_post_meta($order_id,'st_last_name',true);
echo st()->load_template('email/header',null,array('email_title'=>st_get_language('booking_infomation')));

$main_color=st()->get_option('main_color','#ed8323');
?>
    <tr style="background: white">
        <td colspan="10" style="padding: 10px;">
            <?php if(!isset($send_to_admin)):?>
            <h3 style="
margin-top: 30px;
padding-top: 10px;">
                <?php printf(st_get_language('hi').' <strong>%s</strong>',$first_name.' '.$last_name)?>,
                <br>
                <p><?php st_the_language('thank_you_for_booking') ?></p>

            </h3>
            <?php endif;?>
            <p><strong><?php st_the_language('booking_number')?></strong> <?php echo esc_html($order_id)?></p>
            <p><strong><?php st_the_language('booking_date')?></strong> <?php echo get_the_time(get_option('date_format'),$order_id)?></p>
            <p><strong><?php st_the_language('booking_method')?></strong> <?php

                echo STPaymentGateways::get_gatewayname(get_post_meta($order_id,'payment_method',true));

                ?></p>

            <table cellpadding="0" cellspacing="0" width="100%">
                <tbody>

                <tr>
                    <td style="
border-left: 1px solid #bcbcbc;
border-top: 1px solid #bcbcbc;
border-bottom: 1px solid #bcbcbc;
padding: 6px;
background: #e4e4e4;
"

                        >
                        *
                    </td>

                    <td style="
border-left: 1px solid #bcbcbc;
border-top: 1px solid #bcbcbc;
border-bottom: 1px solid #bcbcbc;
padding: 6px;
background: #e4e4e4;">
                        <?php st_the_language('item') ?>
                    </td>
                    <td style="
border-left: 1px solid #bcbcbc;
border-top: 1px solid #bcbcbc;
border-bottom: 1px solid #bcbcbc;
padding: 6px;
background: #e4e4e4;
border-right: 1px solid #bcbcbc;">
                        <?php st_the_language('infomation') ?>
                    </td>
                </tr>
                <?php
//                $args=array(
//                    'post_type'=>'st_order_item',
//                    'posts_per_page'=>'10',
//                    'meta_key'=>'order_parent',
//                    'meta_value'=>$order_id,
//                );
//                query_posts($args);
                $total=0;
                $i=0;
//                while(have_posts()){
//
//                    the_post();
                    $i++;

                    $order_item_id=$order_id;

                    $object_id=get_post_meta($order_item_id,'item_id',true);

                    $check_in=strtotime(get_post_meta($order_item_id,'check_in',true)." ".get_post_meta($order_item_id,'check_in_time',true) );
                    $check_out=strtotime(get_post_meta($order_item_id,'check_out',true)." ".get_post_meta($order_item_id,'check_out_time',true) );
                    $time = ( $check_out - $check_in ) / 3600 ;
                    $number=get_post_meta($order_item_id,'item_number',true);if(!$number) $number=1;
                    $price=get_post_meta($order_item_id,'item_price',true);
                    $item_equipment= get_post_meta($order_item_id,'item_equipment',true);
                    $price_item = 0;
                    if(!empty($item_equipment)){
                        if(json_decode($item_equipment)){
                            $item_equipment = get_object_vars(json_decode($item_equipment));
                            if(is_array($item_equipment) and !empty($item_equipment))
                            {
                                foreach($item_equipment as $k=>$v){
                                    $price_item += $v;
                                }
                            }
                        }

                    }
                    //$total+= $price * $number * $time + $price_item;

                    $total += STCars::get_price_car_by_order_item($order_item_id);

                    ?>
                    <tr>
                        <td style="
padding: 6px;
border-left: 1px solid #bcbcbc;
border-bottom: 1px solid #bcbcbc;" valign="top" align="center" width="5%">
                            <?php echo esc_html($i) ?>
                        </td>
                        <td width="35%" style="vertical-align: top;padding: 6px;border-bottom:1px dashed #ccc;
border-left: 1px solid #bcbcbc;
border-bottom: 1px solid #bcbcbc;">
                            <?php echo get_the_post_thumbnail($object_id,array(360,270,'bfi_thumb'=>true),array('style'=>'max-width:100%;height:auto'))?>
                        </td >
                        <td style="padding: 6px;vertical-align: top;border-bottom:1px dashed #ccc;
border-left: 1px solid #bcbcbc;
border-bottom: 1px solid #bcbcbc;
border-right: 1px solid #bcbcbc;

">
                            <p><strong><?php st_the_language('booking_address');?> </strong><?php echo get_post_meta($object_id,'cars_address',true)?> </p>
                            <p><strong><?php st_the_language('booking_email') ?></strong><?php echo get_post_meta($object_id,'cars_email',true)?> </p>
                            <p><strong><?php st_the_language('booking_phone') ?></strong><?php echo get_post_meta($object_id,'cars_phone',true)?> </p>


                            <p><strong><?php st_the_language('car') ?> : </strong><a target="_blank" href="<?php  echo get_the_permalink($object_id)?>"><?php  echo get_the_title($object_id)?></a></p>


                            <p><strong><?php st_the_language('booking_number') ?></strong> <?php echo get_post_meta(get_the_ID(),'item_number',true)?></p>
                            <p><strong><?php st_the_language('booking_price') ?></strong> <?php
                                $price= get_post_meta($order_item_id,'item_price',true);
                                echo TravelHelper::format_money($price);
                                ?> / <?php st_the_language('booking_hour') ?></p>
                            <p><strong><?php st_the_language('booking_check_in') ?></strong> <?php echo @date(get_option('date_format'),strtotime(get_post_meta($order_item_id,'check_in',true))).' - '.get_post_meta($order_item_id,'check_in_time',true) ?></p>
                            <p><strong><?php st_the_language('booking_check_out') ?></strong> <?php echo @date(get_option('date_format'),strtotime(get_post_meta($order_item_id,'check_out',true))).' - '.get_post_meta($order_item_id,'check_out_time',true)  ?></p>
                        </td>
                    </tr>
                <?php

//                }
//                wp_reset_query();

                ?>
                </tbody>
                <tfoot >
                <tr>
                    <td colspan="2" style="
                    text-align: center;
border-left: 1px solid #bcbcbc;
border-bottom: 1px solid #bcbcbc;
padding: 6px;
background: #e4e4e4;"></td>
                    <td  style="
border-bottom: 1px solid #bcbcbc;
border-right:1px solid #bcbcbc;
padding: 6px;
background: #e4e4e4;">
                        <table cellspacing="0px" cellpadding="0" width="100%">
                            <tr  >
                                <td  style="border-bottom: 1px dashed #ccc;padding:10px;"><strong><?php st_the_language('sub_total')?></strong></td>
                                <td style="border-bottom: 1px dashed #ccc;padding:10px;"><?php echo TravelHelper::format_money($total); ?></td>
                            </tr>
                            <tr>
                                <td  style="border-bottom: 1px dashed #ccc;padding:10px;"><strong><?php st_the_language('tax')?></strong></td>
                                <td style="border-bottom: 1px dashed #ccc;padding:10px;"><?php
                                    $tax=get_post_meta($order_id,'st_tax',true);
                                    if(!$tax){
                                        $tax=STCart::get_tax();
                                    }

                                    $tax_amount=($total/100)*$tax;

                                    echo TravelHelper::format_money($tax_amount);
                                    ?></td>
                            </tr>
                            <tr>
                                <td  style="border-bottom: 1px dashed #ccc;padding:10px;"><strong><?php st_the_language('total')?></strong></td>
                                <td style="border-bottom: 1px dashed #ccc;padding:10px;">
                                    <?php echo TravelHelper::format_money($total+$tax_amount) ?>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                </tfoot>

            </table>
            <?php
            echo st()->load_template('email/booking_customer_infomation',null,array('order_id'=>$order_id));?>
        </td>
    </tr>

<?php
echo st()->load_template('email/footer');
