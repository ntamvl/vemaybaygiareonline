<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours cart item html
 *
 * Created by ShineTheme
 *
 */
if(isset($item_id) and $item_id):
    $item=STCart::find_item($item_id);

    $id_tours=$item_id;
    $count_sale=0;
    $check_in=strtotime($item['data']['check_in']);
    $check_out=strtotime($item['data']['check_out']);
    if(!empty($item['data']['discount'])){
        $count_sale = $item['data']['discount'];
        $price_sale = $item['data']['price_sale'] * $item['number'];
    }

    $type_tour=$item['data']['type_tour'];
    $type_price=$item['data']['type_price'];
    $duration=isset($item['data']['duration'])?$item['data']['duration']:0;

    if($type_tour=='daily_tour' and $duration)
    {
        $check_out=strtotime('+ '.$duration.' days ',$check_in);
    }
    $total_price=0;

    if($type_price=='people_price')
    {
        $adult_num=$item['data']['adult_number'];
        $child_num=$item['data']['child_number'];
        $adult_price=$item['data']['adult_price'];
        $child_price=$item['data']['child_price'];
    }

    $price = $item['price'] * $item['number'];
    ?>
    <header class="clearfix" style="position: relative">
        <?php if(!empty($count_sale)){ ?>
            <span class="box_sale btn-primary sale_small sale_check_out"> <?php echo esc_html($count_sale) ?>% </span>
        <?php } ?>
        <?php if(get_post_status($id_tours)):?>
        <a class="booking-item-payment-img" href="#">
            <?php echo get_the_post_thumbnail($id_tours,array(98,74,'bfi_thumb'=>true));?>
        </a>
        <h5 class="booking-item-payment-title"><a href="<?php echo get_permalink($id_tours)?>"><?php echo get_the_title($id_tours)?></a></h5>
        <ul class="icon-group booking-item-rating-stars">
            <?php echo TravelHelper::rate_to_string(STReview::get_avg_rate($id_tours)); ?>
        </ul>
        <?php
        else: st_the_language('sorry_tour_not_found');
        endif;?>
    </header>
    <ul class="booking-item-payment-details">
        <li>
            <?php if(!empty($check_in)){ ?>
            <h5><?php st_the_language('tours_information')?></h5>
            <div class="booking-item-payment-date">
                <p class="booking-item-payment-date-day"><?php echo date('M, d',($check_in) );?></p>
                <p class="booking-item-payment-date-weekday"><?php echo date('l',($check_in) ); ?></p>
            </div>
            <?php } ?>
            <?php if(!empty($check_out)){ ?>
            <i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
            <div class="booking-item-payment-date">
                <p class="booking-item-payment-date-day"><?php echo date('M, d',($check_out))?></p>
                <p class="booking-item-payment-date-weekday"><?php echo date('l',($check_out)) ?></p>
            </div>
            <?php } ?>
        </li>
        <li>
            <ul class="booking-item-payment-price">
                <?php   if($type_tour=='daily_tour' and $duration){ ?>
                <li>
                    <p class="booking-item-payment-price-title"><?php  _e('Duration',ST_TEXTDOMAIN)?> </p>
                    <p class="booking-item-payment-price-amount"><?php
                            if($duration>1){
                                printf(__('%d days',ST_TEXTDOMAIN),$duration);
                            }elseif($duration==1){
                                _e('1 day',ST_TEXTDOMAIN);
                            }
                        ?>
                    </p>
                </li>
                <?php } ?>
                <li>
                    <p class="booking-item-payment-price-title"><?php  st_the_language('tour_max_people')?> </p>
                    <p class="booking-item-payment-price-amount"><?php echo get_post_meta($item_id ,'max_people',true);  ?>
                    </p>
                </li>

                <?php if($type_price=='people_price'):?>
                <li>
                    <p class="booking-item-payment-price-title"><?php _e('Adult Price',ST_TEXTDOMAIN) ?> </p>


                    <p class="booking-item-payment-price-amount"><?php echo ($adult_num).' x '.st_get_discount_value($adult_price,$count_sale)  ?></small>
                    </p>

                </li>
                <li>
                    <p class="booking-item-payment-price-title"><?php _e('Children Price',ST_TEXTDOMAIN) ?> </p>
                    <p class="booking-item-payment-price-amount"><?php echo ($child_num).' x '.st_get_discount_value($child_price,$count_sale)  ?></small>
                    </p>
                </li>

                <?php else:?>

                <li>
                    <p class="booking-item-payment-price-title"><?php st_the_language('tour_number')?> </p>
                    <p class="booking-item-payment-price-amount"><?php echo esc_html($item['number'])?></small>
                    </p>
                </li>
                <?php endif;?>

            </ul>
        </li>
    </ul>
    <?php
endif;