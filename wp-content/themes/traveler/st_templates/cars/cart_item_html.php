<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars cart item html
 *
 * Created by ShineTheme
 *
 */
if(isset($item_id) and $item_id):

    $item=STCart::find_item($item_id);
    $data_price_cars = $item['data']['data_price_cars'];

    $pick_up_date = $data_price_cars->date_time->pick_up_date;
    $pick_up_time = $data_price_cars->date_time->pick_up_time;
    $drop_off_date = $data_price_cars->date_time->drop_off_date;
    $drop_off_time = $data_price_cars->date_time->drop_off_time;
    $total_time = $data_price_cars->date_time->total_time;

    $date = new DateTime($pick_up_date);
    $start = $date->format('m/d/Y').' '.$pick_up_time;
    $start = strtotime($start);

    $date = new DateTime($drop_off_date);
    $end = $date->format('m/d/Y').' '.$drop_off_time;
    $end = strtotime($end);
    $day=STCars::get_date_diff($start,$end);

    if(!empty($item['data']['discount'])){
        $count_sale = $item['data']['discount'];
        $price_old = $item['data']['price_old'];
    }
    $price_car = $data_price_cars->price_cars;

    $total_price_items = 0;
    $data_price_items = array();
    $html_item='';
    if(!empty($item['data']['data_price_items'])){
        $data_price_items = get_object_vars($item['data']['data_price_items']);
        foreach($data_price_items as $k=>$v){
            $total_price_items +=$v;
            $html_item .='<li>
                                <p class="booking-item-payment-price-title">'.$k.'</p>
                                <p class="booking-item-payment-price-amount">'.TravelHelper::format_money($v).'</p>
                          </li>';
        }
    }
    ?>
    <header class="clearfix" style="position: relative">
        <?php if(!empty($count_sale)){ ?>
            <span class="box_sale btn-primary sale_small sale_check_out"> <?php echo esc_html($count_sale) ?>% </span>
        <?php } ?>
        <a href="<?php echo get_permalink($item_id) ?>" class="booking-item-payment-img">
            <?php echo get_the_post_thumbnail($item_id,array(800,400,'bfi_thumb'=>true));?>
        </a>
        <h5 class="booking-item-payment-title">
            <a href="<?php echo get_permalink($item_id) ?>"><?php echo get_the_title($item_id) ?></a>
        </h5>
    </header>
    <ul class="booking-item-payment-details">
        <li>
            <h5><?php st_the_language('car_for') ?> <?php echo esc_html($day) ?> <?php if($day > 1) echo STCars::get_price_unit('plural'); else echo STCars::get_price_unit(); ?></h5>
            <div class="booking-item-payment-date">
                <p class="booking-item-payment-date-day"><?php echo  mysql2date( 'F j', $pick_up_date) ?></p>
                <p class="booking-item-payment-date-weekday"><?php echo  mysql2date( 'l', $pick_up_date) ?></p>
                <p class="booking-item-payment-date-time"><?php echo esc_html($pick_up_time) ?></p>
            </div><i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
            <div class="booking-item-payment-date">
                <p class="booking-item-payment-date-day"><?php echo  mysql2date( 'F j', $drop_off_date) ?></p>
                <p class="booking-item-payment-date-weekday"><?php echo  mysql2date( 'l', $drop_off_date) ?></p>
                <p class="booking-item-payment-date-time"><?php echo esc_html($drop_off_time) ?></p>
            </div>
        </li>
        <?php if(!empty($html_item)){ ?>
            <li>
                <h5>
                    <?php st_the_language('car_due_at_pick_up') ?>
                    (<?php echo count($data_price_items) ?> <?php if(count($data_price_items) > 1 ) st_the_language('car_passengers'); else  st_the_language('car_passenger');?>)
                </h5>
                <ul class="booking-item-payment-price">
                   <?php echo balanceTags($html_item) ?>
                </ul>
            </li>
        <?php } ?>
        <li>
            <h5> <?php st_the_language('car'); ?> </h5>
            <ul class="booking-item-payment-price">
                <li>
                    <p class="booking-item-payment-price-title"><?php st_the_language('car_equipment') ?></p>
                    <p class="booking-item-payment-price-amount"><?php  echo TravelHelper::format_money( $total_price_items )  ?></p>
                </li>
                <li>
                    <p class="booking-item-payment-price-title"><?php echo esc_html($day) ?> <?php if($day > 1) echo STCars::get_price_unit('plural'); else echo STCars::get_price_unit(); ?></p>
                    <p class="booking-item-payment-price-amount">
                        <?php if(!empty($price_old)){ ?>
                        <?php echo '<span class="onsale">'.$price_old.'</span> <i class="fa fa-arrow-right "></i>' ?>
                        <?php } ?>
                        <strong><?php  echo TravelHelper::format_money( $price_car )  ?></strong>
                        <small>/<?php echo STCars::get_price_unit() ?></small>
                    </p>
                </li>
                <li>
                    <p class="booking-item-payment-price-title"><?php st_the_language('car_total') ?> </p>
                    <p class="booking-item-payment-price-amount"><?php  echo TravelHelper::format_money( $item['data']['price_total']  )?>
                    </p>
                </li>
            </ul>
        </li>
    </ul>
<?php
endif;