<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental form book
 *
 * Created by ShineTheme
 *
 */
if(!isset($field_size)) $field_size='';

$adult_max=st()->get_option('hotel_max_adult',14);
$child_max=st()->get_option('hotel_max_child',14);

echo STTemplate::message();

global $post;
?>
<form method="post" action="">
    <input type="hidden" name="action" value="rental_add_cart">
    <input type="hidden" name="item_id" value="<?php the_ID()?>">
    <input type="hidden" name="price" value="<?php echo STRental::get_price() ?>">
    <input type="hidden" name="number_room" value="1">
    <input type="hidden" name="rental" value="<?php echo esc_attr($post->post_name)?>">

<div class="booking-item-dates-change">

        <div class="input-daterange" data-date-format="<?php echo TravelHelper::get_js_date_format()?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon"></i>
                        <label><?php st_the_language('rental_check_in')?></label>
                        <input required="required" placeholder="<?php echo TravelHelper::get_js_date_format()?>" value="<?php echo STInput::get('start') ?>" class="form-control required" name="start" type="text" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon"></i>
                        <label><?php st_the_language('rental_check_out')?></label>
                        <input required="required" placeholder="<?php echo TravelHelper::get_js_date_format()?>" value="<?php echo STInput::get('end') ?>" class="form-control required" name="end" type="text" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6">
                <?php


                $old=STInput::get('adult',1);
                ?>
                <div class="form-group form-group-<?php echo esc_attr($field_size) ?> form-group-select-plus">
                    <label><?php st_the_language('rental_adult')?></label>
                    <div class="btn-group btn-group-select-num <?php if($old>=4)echo 'hidden';?>" data-toggle="buttons">
                        <label class="btn btn-primary <?php echo (!$old or $old==1)?'active':false; ?>">
                            <input type="radio" value="1" name="options" />1</label>
                        <label class="btn btn-primary <?php echo ($old==2)?'active':false; ?>">
                            <input type="radio" value="2" name="options" />2</label>
                        <label class="btn btn-primary <?php echo ($old==3)?'active':false; ?>">
                            <input type="radio" value="3" name="options" />3</label>
                        <label class="btn btn-primary <?php echo ($old==4)?'active':false; ?>">
                            <input type="radio" value="4" name="options" />3+</label>
                    </div>
                    <select class="form-control required <?php if($old<4)echo 'hidden';?>" name="adult">
                        <?php $max=14;
                        for($i=1;$i<=$adult_max;$i++){
                            echo "<option ".selected($i,$old)." value='{$i}'>{$i}</option>";
                        }
                        ?>
                    </select>
                </div>
                </div>
            <div class="col-sm-6">
                <?php
                $old=STInput::get('children',0);
                ?>
                <div class="form-group form-group-<?php echo esc_attr($field_size) ?> form-group-select-plus">
                    <label><?php st_the_language('rental_children')?></label>
                    <div class="btn-group btn-group-select-num <?php if($old>=3)echo 'hidden';?>" data-toggle="buttons">
                        <label class="btn btn-primary <?php echo (!$old or $old==0)?'active':false; ?>">
                            <input type="radio" value="0" name="options" />0</label>
                        <label class="btn btn-primary <?php echo ($old==1)?'active':false; ?>">
                            <input type="radio" value="1" name="options" />1</label>
                        <label class="btn btn-primary <?php echo ($old==2)?'active':false; ?>">
                            <input type="radio" value="2" name="options" />2</label>
                        <label class="btn btn-primary <?php echo ($old==3)?'active':false; ?>">
                            <input type="radio" value="3" name="options" />2+</label>
                    </div>
                    <select class="form-control required <?php if($old<4)echo 'hidden';?>" name="children">
                        <?php $max=14;
                        for($i=0;$i<=$child_max;$i++){
                            echo "<option ".selected($i,$old)." value='{$i}'>{$i}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

</div>
<div class="gap gap-small"></div>
    <?php if(st()->get_option('booking_modal','off')=='off'):?>
        <button type="submit" class="btn btn-primary btn-lg"><?php st_the_language('rental_book_now')?></button>
    <?php else:?>
        <a href="#rental_booking_<?php the_ID() ?>" class="btn btn-primary btn_booking_modal" data-target=#rental_booking_<?php the_ID() ?>  data-effect="mfp-zoom-out" ><?php st_the_language('rental_book_now') ?></a>
    <?php endif;?>
</form>
<?php
if(st()->get_option('booking_modal','off')=='on'){?>
    <div class="mfp-with-anim mfp-dialog mfp-search-dialog mfp-hide" id="rental_booking_<?php the_ID()?>">
        <?php echo st()->load_template('rental/modal_booking');?>
    </div>

<?php }?>