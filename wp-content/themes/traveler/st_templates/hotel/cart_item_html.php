<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * hotel cart item html
 *
 * Created by ShineTheme
 *
 */
if(isset($item_id) and $item_id):


    $item=STCart::find_item($item_id);

    $hotel=$item_id;
    $room_id=$item['data']['room_id'];
    $check_in=strtotime($item['data']['check_in']);
    $check_out=strtotime($item['data']['check_out']);

    $date_diff=STDate::date_diff($check_in,$check_out);


    ?>
    <header class="clearfix">
        <?php if(get_post_status($hotel)):?>
        <a class="booking-item-payment-img" href="#">
            <?php echo get_the_post_thumbnail($hotel,array(98,74,'bfi_thumb'=>true));?>
        </a>
        <h5 class="booking-item-payment-title"><a href="<?php echo get_permalink($hotel)?>"><?php echo get_the_title($hotel)?></a></h5>
        <ul class="icon-group booking-item-rating-stars">
            <?php echo TravelHelper::rate_to_string(STReview::get_avg_rate($hotel)); ?>
        </ul>
        <?php
        else: echo st_get_language('no_hotel_found');
        endif;?>
    </header>
    <ul class="booking-item-payment-details">
        <li>
            <h5><?php
                if($date_diff>1)
                {
                    printf(st_get_language('booking_for_d_night'),$date_diff);
                }else{
                    printf(st_get_language('booking_for_1_night'),$date_diff);
                }

                 ?></h5>
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
            <h5><?php st_the_language('room')?></h5>
            <p class="booking-item-payment-item-title"><?php echo get_the_title($room_id)?></p>
            <ul class="booking-item-payment-price">
                <li>
                    <p class="booking-item-payment-price-title"><?php
                        if($date_diff>1){
                            printf(st_get_language('d_night'),$date_diff);
                        }else{
                            printf(st_get_language('1_night'),$date_diff);
                        }

                        ?> </p>
                    <p class="booking-item-payment-price-amount"><?php echo TravelHelper::format_money($item['price']) ?><small>/<?php st_the_language('per_night')?></small>
                    </p>
                </li>
<!--                --><?php //if(STCart::is_tax_enable()):$tax_pc=STCart::get_tax();$tax_amount=($item['price']/100)*$tax_pc;?>
<!--                <li>-->
<!--                    <p class="booking-item-payment-price-title">--><?php //_e('Taxes',ST_TEXTDOMAIN)?><!--</p>-->
<!--                    <p class="booking-item-payment-price-amount">--><?php //echo TravelHelper::format_money($tax_amount)?><!--<small>--><?php //_e('/per day',ST_TEXTDOMAIN)?><!--</small>-->
<!--                    </p>-->
<!--                </li>-->
<!--                --><?php //endif;?>
            </ul>
        </li>
    </ul>
    <?php

endif;