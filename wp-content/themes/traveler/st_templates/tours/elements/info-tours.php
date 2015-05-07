<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours info
 *
 * Created by ShineTheme
 *
 */
$type_price = get_post_meta(get_the_ID(),'type_price',true);
$type_tour = get_post_meta(get_the_ID(),'type_tour',true);

if($type_price=='people_price')
{
    $info_price=STTour::get_price_person(get_the_ID());
}else{
    $info_price = STTour::get_info_price(get_the_ID());

}
echo STTemplate::message();
?>
<div class="package-info-wrapper pull-left" style="width: 100%">
    <div class="row">
        <div class="col-md-6">
            <?php if($type_tour == 'specific_date'){ ?>
                <div class="package-info">
                    <i class="fa fa-calendar"></i>
                    <span class="head"><?php st_the_language('tour_duration') ?>: </span>
                    <?php
                    $check_in = get_post_meta(get_the_ID() , 'check_in' ,true);
                    $check_out = get_post_meta(get_the_ID() , 'check_out' ,true);
                    $date = mysql2date('m/d/Y',$check_in).' <i class="fa fa-long-arrow-right"></i> '.mysql2date('m/d/Y',$check_out);
                    if(!empty($check_in) and !empty($check_out)){
                        echo balanceTags($date);
                    }else{
                        st_the_language('tour_none');
                    }
                    ?>
                </div>
            <?php }else{ ?>
                <div class="package-info">
                    <i class="fa fa-calendar"></i>
                    <span class="head"><?php _e('Duration',ST_TEXTDOMAIN) ?>: </span>
                    <?php $duration_day =  get_post_meta(get_the_ID() , 'duration_day', true); ?>
                    <?php if($duration_day>1){
                        printf(__('%d days',ST_TEXTDOMAIN),$duration_day);
                    }elseif($duration_day==1){
                        _e('1 day',ST_TEXTDOMAIN);
                    } ?>
                </div>
            <?php } ?>
            <div class="package-info">
                <?php $max_people = get_post_meta(get_the_ID(),'max_people', true) ?>
                <i class="fa    fa-users"></i>
                <span class="head"><?php st_the_language('tour_max_people') ?>: </span>
                <?php echo esc_html($max_people) ?>
            </div>

            <div class="package-info">
                <i class="fa fa-location-arrow"></i>
                <span class="head"><?php st_the_language('tour_location') ?>: </span>
                <?php echo get_the_title(get_post_meta(get_the_ID() , 'id_location', true)); ?>
            </div>
            <div class="package-info">
                <i class="fa fa-money"></i>
                <span class="head"><?php st_the_language('tour_price') ?>: </span>
                <?php echo STTour::get_price_html(false,false,'-'); ?>
            </div>
            <div class="package-info pull-left">
                <div class="pull-left">
                    <i class="fa fa-info"></i>
                    <span class="head"><?php st_the_language('tour_rate') ?>:</span>
                </div>
                <div  class="pull-left pl-5">
                    <ul class="icon-group booking-item-rating-stars">
                        <?php
                        $avg = STReview::get_avg_rate();
                        echo TravelHelper::rate_to_string($avg);
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="package-book-now-button">
                <form method="post" action="">
                    <input type="hidden" name="action" value="tours_add_to_cart" >
                    <input type="hidden" name="item_id" value="<?php echo get_the_ID()?>">
                    <input type="hidden" name="discount" value="<?php echo esc_html($info_price['discount']) ?>">
                    <input name="price" value="<?php echo get_post_meta(get_the_ID(),'price',true) ?>" type="hidden">
                    <input type="hidden" name="type_tour" value="<?php echo esc_html($type_tour) ?>">
                    <input type="hidden" name="type_price" value="<?php echo esc_html($type_price) ?>">
                    <div class="div_book">
                        <div class="div_book_tour">
                            <?php if($type_price == 'people_price'){?>

                                <span><?php _e('Adults',ST_TEXTDOMAIN)?>: </span>
                                <select class="form-control st_tour_adult" name="adult_number" required>
                                    <?php for($i=1;$i<=20;$i++){
                                        echo  "<option value='{$i}'>{$i}</option>";
                                    } ?>
                                </select>
                                <span><?php _e('Children',ST_TEXTDOMAIN)?>: </span>
                                <select class="form-control st_tour_children" name="children_number" required>
                                    <?php for($i=0;$i<=20;$i++){
                                        echo  "<option value='{$i}'>{$i}</option>";
                                    } ?>
                                </select>
                            <?php }else{ ?>
                                <span><?php _e('Number Tours',ST_TEXTDOMAIN)?>: </span>
                                <select class="form-control" name="number" required>
                                    <?php for($i=1;$i<=20;$i++){
                                        echo  "<option value='{$i}'>{$i}</option>";
                                    } ?>
                                </select>
                            <?php } ?>
                            <?php if($type_tour == 'daily_tour'){ ?>
                                <input name="duration" class="" type="hidden" value="<?php echo esc_attr($duration_day) ?>">
                                <span><?php _e('Travel Date',ST_TEXTDOMAIN)?>: </span>
                                <input name="check_in" data-date-format="<?php echo TravelHelper::get_js_date_format()?>"   type="text" value="" class="tour_book_date form-control" required />
                            <?php }else{ ?>
                                <input name="check_in"  type="hidden"  value="<?php echo get_post_meta(get_the_ID(),'check_in',true) ?>">
                                <input name="check_out" type="hidden"  value="<?php echo get_post_meta(get_the_ID(),'check_out',true) ?>">
                            <?php } ?>
                        </div>
                        <div class="div_btn_book_tour">
                            <?php if(st()->get_option('booking_modal','off')=='on'){ ?>
                                <a href="#tour_booking_<?php the_ID() ?>" class="btn btn-primary popup-text" data-effect="mfp-zoom-out" ><?php st_the_language('book_now') ?></a>
                            <?php }else{ ?>
                                <button class="btn btn-primary" type="submit"><?php st_the_language('book_now')?></button>
                            <?php } ?>
                            <?php echo st()->load_template('user/html/html_add_wishlist',null,array("title"=>'','class'=>'')) ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if(!empty($info_price['discount'])){ ?>
        <span class="box_sale sale_small btn-primary"> <?php echo esc_html($info_price['discount']) ?>% </span>
    <?php } ?>
</div>
<?php
if(st()->get_option('booking_modal','off')=='on'){?>
    <div class="mfp-with-anim mfp-dialog mfp-search-dialog mfp-hide" id="tour_booking_<?php the_ID()?>">
        <?php echo st()->load_template('tours/modal_booking');?>
    </div>

<?php }?>

