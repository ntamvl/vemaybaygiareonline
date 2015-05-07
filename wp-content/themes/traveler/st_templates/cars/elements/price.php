<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars element price
 *
 * Created by ShineTheme
 *
 */
$col = 12 / $attr['st_style'];

$info_price = STCars::get_info_price();
$cars_price = $info_price['price'];
$count_sale = $info_price['discount'];
if(!empty($count_sale)){
    $cars_price = $info_price['price'];
    $price_sale = $info_price['price_old'];
}

$pick_up_date=STInput::request('pick-up-date',date('m/d/Y',strtotime("now")));
$drop_off_date=STInput::request('drop-off-date',date('m/d/Y',strtotime("+1 day")));
$pick_up_time = STInput::request('pick-up-time','12:00 PM');
$drop_off_time = STInput::request('drop-off-time','12:00 PM');
$pick_up=STInput::request('pick-up');
$location_id_drop_off = STInput::request('location_id_drop_off');
$drop_off=STInput::request('drop-off');
$location_id_pick_up = STInput::request('location_id_pick_up');

$date = new DateTime($pick_up_date);
$start = $date->format('m/d/Y').' '.$pick_up_time;
$start = strtotime($start);

$date = new DateTime($drop_off_date);
$end = $date->format('m/d/Y').' '.$drop_off_time;
$end = strtotime($end);
$time=STCars::get_date_diff($start,$end);
?>
<?php // $cars_price = get_post_meta(get_the_ID(),'cars_price',true); ?>
<form method="post" class="car_booking_form"  >
<div class="booking-item-price-calc">
    <div class="row row-wrap">
        <div class="col-md-<?php echo esc_attr($col) ?> singe_cars">
            <?php $list = get_post_meta(get_the_ID(),'cars_equipment_list',true); ?>
            <?php
            if(!empty($list)){
                foreach($list as $k=>$v){
                    echo '<div class="checkbox">
                            <label>
                                <input class="i-check equipment" data-title="'.$v['title'].'" data-price="'.$v['cars_equipment_list_price'].'" type="checkbox" />'.$v['title'].'
                                <span class="pull-right">'.TravelHelper::format_money($v['cars_equipment_list_price']).'</span>
                            </label>
                       </div>';
                }
            }
            ?>
            <div class="cars_equipment_display"></div>
        </div>
        <div class="col-md-<?php echo esc_attr($col) ?>">
            <ul class="list">
                <li>
                    <p> <?php echo st_get_language('car_price_per').' '.ucfirst(STCars::get_price_unit('label')); ?>
                        <span><?php echo TravelHelper::format_money($cars_price) ?></span>
                    </p>
                </li>
                <li><p>
                        <?php


                        $data_price_tmp=STCars::get_rental_price($cars_price,$start,$end);
                        ?>
                        <?php st_the_language('car_rental_price'); ?>
                        <span class="st_cars_price" data-value="<?php echo esc_html($data_price_tmp) ?>" >
                            <?php echo TravelHelper::format_money($data_price_tmp) ?>
                        </span>
                    </p>
                    <?php
                    $pick_up_date = $drop_off_date = '';
                        $pick_up_date_html = $drop_off_date_html = '';
                    if(!empty($_REQUEST['pick-up-date'])){
                        $pick_up_date_html =  mysql2date( 'F j', $_REQUEST['pick-up-date']);
                        $pick_up_date =  mysql2date( 'm/d/Y', $_REQUEST['pick-up-date']);
                    }else{
                        $pick_up_date_html = date('F j',strtotime("now"));
                        $pick_up_date = date('m/d/Y',strtotime("now"));
                    }

                    if(!empty($_REQUEST['drop-off-date'])){
                        $drop_off_date_html =  mysql2date( 'F j', $_REQUEST['drop-off-date']);
                        $drop_off_date =  mysql2date( 'm/d/Y', $_REQUEST['drop-off-date']);
                    }else{
                        $drop_off_date_html = date('F j',strtotime("+1 day"));
                        $drop_off_date = date('m/d/Y',strtotime("+1 day"));
                    }

                    if(!empty($pick_up_date_html)){
                    ?>
                      <small><?php echo esc_attr($time) ?> <?php if($time > 1) echo STCars::get_price_unit('plural'); else echo STCars::get_price_unit(); ?> ( <?php echo esc_html($pick_up_date_html) ?> - <?php echo esc_html($drop_off_date_html) ?> )</small>
                    <?php }else{ ?>
                        <small><?php echo esc_attr($time) ?> <?php if($time > 1) echo STCars::get_price_unit('plural'); else STCars::get_price_unit(); ?> </small>
                    <?php } ?>
                </li>
                <li><p>
                        <?php st_the_language('car_equipment') ?>
                        <span class="st_data_car_equipment_total" data-value="0">
                          <?php echo TravelHelper::format_money( 0 ) ?>
                        </span>
                    </p>
                </li>
                <li><p>
                        <?php st_the_language('car_rental_total'); ?>
                        <span class="st_data_car_total"> <?php echo TravelHelper::format_money($data_price_tmp) ?>
                        </span>
                    </p>
                    <div class="spinner cars_price_img_loading ">
                    </div>
                </li>
            </ul>

            <?php if(st()->get_option('booking_modal','off')=='on'){ ?>
                <a href="#car_booking_<?php the_ID() ?>" class="btn btn-primary btn_booking_modal" data-target=#car_booking_<?php the_ID() ?>  data-effect="mfp-zoom-out" ><?php st_the_language('book_now') ?></a>
            <?php }else{ ?>
                <input type="submit"  class=" btn btn-primary" value="<?php st_the_language('book_now') ?>">
            <?php } ?>
            <?php echo st()->load_template('user/html/html_add_wishlist',null,array("title"=>"")) ?>
        </div>
    </div>
</div>
    <?php
    if(!$pick_up and $location_id_pick_up) $pick_up=get_the_title($location_id_pick_up);
    if(!$drop_off and $location_id_drop_off) $drop_off=get_the_title($location_id_drop_off);
     $data = array(
         'price_cars'=>$cars_price,
         "pick_up"=>$pick_up,
         "location_id_pick_up"=>$location_id_pick_up,
         "drop_off"=>$drop_off,
         "location_id_drop_off"=>$location_id_drop_off,
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
    <input type="hidden" name="price_old" value='<?php echo get_post_meta(get_the_ID(),'cars_price',true); ?>'>
    <input type="hidden" name="price" value='<?php echo esc_attr($cars_price) ?>'>

    <input type="hidden" name="action" value='cars_add_to_cart'>
    <input type="hidden" name="data_price_cars"  class="data_price_cars" value='<?php echo json_encode($data) ?>'>
    <input type="hidden" name="data_price_items"  class="data_price_items" value=''>

</form>
<?php
if(st()->get_option('booking_modal','off')=='on'){?>
    <div class="mfp-with-anim mfp-dialog mfp-search-dialog mfp-hide" id="car_booking_<?php the_ID()?>">
        <?php echo st()->load_template('cars/modal_booking');?>
    </div>

<?php }?>
