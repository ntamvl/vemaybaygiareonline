<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental cart item html
 *
 * Created by ShineTheme
 *
 */
if(isset($item_id) and $item_id):

    $item=STCart::find_item($item_id);

    extract($item);

    $check_in=strtotime($item['data']['check_in']);
    $check_out=strtotime($item['data']['check_out']);

    $item_data=array(
        'adult'=>'',
        'children'=>''
    );

    $item_data=wp_parse_args($item['data'],$item_data);
    $adult=$item_data['adult'];
    $children=$item_data['children'];

    $date_diff=STDate::date_diff($check_in,$check_out);
    if($date_diff<1) $date_diff=1;

    ?>
    <header class="clearfix">
        <a class="booking-item-payment-img" href="<?php echo get_the_permalink($item_id)?>">
            <?php echo get_the_post_thumbnail($item_id,array(98,74,'bfi_thumb'=>true));?>
        </a>
        <h5 class="booking-item-payment-title"><a href="<?php echo get_permalink($item_id)?>"><?php echo get_the_title($item_id)?></a></h5>
        <ul class="icon-group booking-item-rating-stars">
            <?php echo TravelHelper::rate_to_string(STReview::get_avg_rate($item_id)); ?>
        </ul>
    </header>
    <ul class="booking-item-payment-details">
        <li>
            <h5><?php printf(st_get_language('rental_booking_for_d'),$date_diff)?> <?php st_the_language('rental_nights')?></h5>
            <div class="booking-item-payment-date">
                <p class="booking-item-payment-date-day"><?php echo date('M, d',(float)$check_in)?></p>
                <p class="booking-item-payment-date-weekday"><?php echo date('l',(float)$check_in) ?></p>
            </div>
            <i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
            <div class="booking-item-payment-date">
                <p class="booking-item-payment-date-day"><?php echo date('M, d',(float)$check_out)?></p>
                <p class="booking-item-payment-date-weekday"><?php echo date('l',(float)$check_out) ?></p>
            </div>
        </li>
        <li>
            <h5><?php st_the_language('rental_property')?>
                <?php
                    if(isset($adult ) and $adult){
                        echo '( ';
                        if($adult>1){
                            printf(st_get_language('rental_d_adults'),$adult);
                        }else{
                            printf(st_get_language('rental_d_adult'),$adult);

                        }
                        if($children){
                            echo ' - ';
                            if($children>1){
                                printf(st_get_language('rental_d_children'),$children);
                            }else{
                                printf(st_get_language('rental_d_child'),$children);

                            }
                        }
                        echo ' )';
                    }
                ?>
            </h5>
            <p class="booking-item-payment-item-title"><?php echo get_the_title($item_id)?></p>
            <ul class="booking-item-payment-price">
                <li>
                    <p class="booking-item-payment-price-title"><?php

                        if($date_diff>1){
                            printf(st_get_language('rental_s_nights'),$date_diff);
                        }else{
                            printf(st_get_language('rental_1_night'),$date_diff);

                        }

                        ?> </p>
                    <p class="booking-item-payment-price-amount"><?php echo TravelHelper::format_money($item['price']) ?><small>/<?php st_the_language('per_night')?></small>
                    </p>
                </li>
            </ul>
        </li>
    </ul>
    <?php

endif;