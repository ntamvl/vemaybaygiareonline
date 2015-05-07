<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Activity element form book
 *
 * Created by ShineTheme
 *
 */
?>
<div class="info-activity">
    <?php
    $activity_time = get_post_meta(get_the_ID() ,'activity-time',true);
    if(!empty($activity_time)):
        ?>
        <div class="info">
            <span class="head"><i class="fa fa-clock-o"></i> <?php st_the_language('activity_time') ?> : </span>
            <span><?php echo esc_html($activity_time) ;  ?> </span>
        </div>
    <?php endif; ?>
    <?php
    $duration = get_post_meta(get_the_ID() ,'duration',true);
    if(!empty($duration)):
    ?>
        <div class="info">
            <span class="head"><i class="fa fa-clock-o"></i> <?php st_the_language('duration') ?> : </span>
            <span><?php echo esc_html($duration) ; ?> </span>
        </div>
    <?php endif; ?>
    <?php
    $check_in = get_post_meta(get_the_ID() ,'check_in',true);
    $check_out = get_post_meta(get_the_ID() ,'check_out',true);
    if(!empty($check_in) and !empty($check_out)):
    ?>
        <div class="info">
            <span class="head"><i class="fa fa-calendar"></i> <?php st_the_language('availability') ?> : </span>
            <span>
                <?php echo mysql2date('l, m/d/Y',$check_in) ?>
                <i class="fa fa-arrow-right"></i>
                <?php echo mysql2date('l, m/d/Y',$check_out) ?>
            </span>
        </div>
    <?php endif; ?>
    <?php
    $facilities = get_post_meta(get_the_ID() ,'venue-facilities',true);
    if(!empty($facilities)):
    ?>
        <div class="info">
            <span class="head"><i class="fa fa-cogs"></i> <?php st_the_language('venue_facilities') ?> : </span>
            <span><?php echo esc_html($facilities) ; ?> </span>
        </div>
    <?php endif; ?>
</div>
<?php

$info_price = STActivity::get_info_price();
$count_sale = $info_price['discount'];
?>
<form method="get" action="<?php echo home_url('/')?>">
    <input type="hidden" name="action" value="activity_add_to_cart" >
    <input type="hidden" name="item_id" value="<?php echo get_the_ID()?>">
    <input type="hidden" name="discount" value="<?php echo esc_attr($count_sale) ?>">
    <input name="price" value="<?php echo get_post_meta(get_the_ID(),'price',true) ?>" type="hidden">
    <div class="book_form">
        <span style=" display: none;"><?php st_the_language('guests') ?> :</span>
        <input name="number" class="number_room number_activity_1" type="number" min="1" value="1" style=" display: none; width: 50px; height: 44px;">
        <?php if(st()->get_option('booking_modal','off')=='on'){ ?>
            <a href="#activity_booking_<?php the_ID() ?>" class="btn btn-primary btn-lg popup-text btn_activity" data-effect="mfp-zoom-out" ><?php st_the_language('book_now') ?></a>
        <?php }else{ ?>
            <button class="btn btn-primary btn-lg" type="submit"><?php st_the_language('book_now')?></button>
        <?php } ?>
        <?php
        $best_price = get_post_meta(get_the_ID() , 'best-price-guarantee' ,true);
        if($best_price == 'on'){
        ?>
        <div class="btn btn-ghost btn-lg btn-info tooltip_2 tooltip_2-effect-1 activity" style="font-size: 16px">
            <span class="">
                <?php st_the_language('best_price_guarantee') ?>
                <i class="fa  fa-check-square-o fa-lg  primary"></i>
            </span>
            <span class="tooltip_2-content clearfix title" >
                <?php echo get_post_meta(get_the_ID() , 'best-price-guarantee-text' ,true) ?>
            </span>
        </div>
        <?php } ?>
    </div>
    <input name="check_in"  type="hidden"  value="<?php echo get_post_meta(get_the_ID(),'check_in',true) ?>">
    <input name="check_out" type="hidden"  value="<?php echo get_post_meta(get_the_ID(),'check_out',true) ?>">
</form>
<?php
if(st()->get_option('booking_modal','off')=='on'){?>
    <div class="mfp-with-anim mfp-dialog mfp-search-dialog mfp-hide" id="activity_booking_<?php the_ID()?>">
        <?php echo st()->load_template('activity/modal_booking');?>
    </div>

<?php }?>
<script>
    jQuery(function($){
          $('.btn_activity').click(function(){
              $('.number_activity_2').val( $('.number_activity_1').val() )
          });
    });
</script>