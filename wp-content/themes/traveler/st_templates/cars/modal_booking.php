<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars modal booking
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
<h3><?php printf(st_get_language('you_are_booking_for_s'),get_the_title())?></h3>

<div id="booking_modal_<?php echo get_the_ID() ?>" class="booking_modal_form">
    <?php
        wp_nonce_field('submit_form_order','travel_order');

    ?>

    <?php
    $info_price = STCars::get_info_price();
    $cars_price = $info_price['price'];
    $count_sale = $info_price['discount'];
    if(!empty($count_sale)){
        $price = $info_price['price'];
        $price_sale = $info_price['price_old'];
    }

    $pick_up_date=STInput::request('pick-up-date',date('m/d/Y',strtotime("now")));
    $drop_off_date=STInput::request('drop-off-date',date('m/d/Y',strtotime("+1 day")));
    $pick_up_time = STInput::request('pick-up-time','12:00 PM');
    $drop_off_time = STInput::request('drop-off-time','12:00 PM');
    $pick_up=STInput::request('pick-up');
    $drop_off=STInput::request('drop-off');

    $date = new DateTime($pick_up_date);
    $start = $date->format('m/d/Y').' '.$pick_up_time;
    $start = strtotime($start);

    $date = new DateTime($drop_off_date);
    $end = $date->format('m/d/Y').' '.$drop_off_time;
    $end = strtotime($end);
    $time=STCars::get_date_diff($start,$end);

    $data_price_tmp = $cars_price * $time;

    $data = array(
        'price_cars'=>$cars_price,
        "pick_up"=>$pick_up,
        "drop_off"=>$drop_off,
        'date_time'=>array(
            "pick_up_date"=>$pick_up_date,
            "pick_up_time"=>$pick_up_time,
            "drop_off_date"=>$drop_off_date,
            "drop_off_time"=>$drop_off_time,
            "total_time"=>$time
        ),
    );
    ?>
    <input type="hidden" name="time" value='<?php echo esc_attr($time) ?>'>
    <input type="hidden" name="data_price_total" class="data_price_total" value='<?php echo esc_html($data_price_tmp) ?>'>
    <input type="hidden" name="item_id" value='<?php echo get_the_ID() ?>'>

    <input type="hidden" name="discount" value='<?php echo esc_attr($count_sale) ?>'>
    <input type="hidden" name="price" value='<?php echo esc_attr($cars_price) ?>'>
    <input type="hidden" name="price_old" value='<?php echo get_post_meta(get_the_ID(),'cars_price',true); ?>'>

    <input type="hidden" name="data_price_cars"  class="data_price_cars" value='<?php echo json_encode($data) ?>'>
    <input type="hidden" name="data_price_items"  class="data_price_items" value=''>


    <?php echo st()->load_template('check_out/check_out')?>


</div>
