<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User create activity
 *
 * Created by ShineTheme
 *
 */
?>
<div class="st-create">
    <h2><?php st_the_language('user_create_activity') ?></h2>
</div>
<div class="msg">
    <?php echo STUser_f::get_msg(); ?>
</div>
<form action="" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('user_setting','st_insert_post_activity'); ?>
    <div class="form-group form-group-icon-left">
        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
        <label><?php st_the_language('user_create_activity_title') ?></label>
        <input id="title" name="title" type="text" placeholder="<?php st_the_language('user_create_activity_title') ?>" class="form-control">
        <div class="st_msg console_msg_title"></div>
    </div>
    <div class="form-group form-group-icon-left">
        <label><?php st_the_language('user_create_activity_content') ?></label>
        <?php wp_editor('','st_content'); ?>
    </div>
    <div class="form-group form-group-icon-left">
        <label><?php st_the_language('user_create_activity_description') ?></label>
        <textarea id="desc" name="desc" class="form-control"></textarea>
        <div class="st_msg console_msg_desc"></div>
    </div>
    <div class="form-group form-group-icon-left">
        <label> <?php st_the_language('user_create_activity_featured_image') ?></label>
        <input id="featured-image" name="featured-image" type="file" placeholder="<?php st_the_language('user_create_activity_featured_image') ?>" class="">
    </div>
    <h4><?php st_the_language('user_create_activity_general') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-envelope-o input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_email') ?></label>
                <input id="email" name="email" type="email" placeholder="<?php st_the_language('user_create_activity_email') ?>" class="form-control">
                <div class="st_msg console_msg_email"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-phone input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_phone') ?></label>
                <input id="phone" name="phone" type="phone" placeholder="<?php st_the_language('user_create_activity_phone') ?>" class="form-control">
                <div class="st_msg console_msg_email"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-wordpress input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_website') ?></label>
                <input id="website" name="website" type="website" placeholder="<?php st_the_language('user_create_activity_website') ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-youtube input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_video') ?></label>
                <input id="video" name="video" type="text" placeholder="<?php st_the_language('user_create_activity_video') ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-cogs input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_style_gallery') ?></label>
                <select id="gallery_style" name="gallery_style" class="form-control">
                    <option selected="selected" value="grid"><?php st_the_language('user_create_activity_grid')?></option>
                    <option value="slider"><?php st_the_language('user_create_activity_slider') ?></option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_activity_gallery') ?></label>
                <input id="gallery" name="gallery[]" type="file" multiple class="">
                <div class="st_msg console_msg_email"></div>
            </div>
        </div>
    </div>
    <h4><?php st_the_language('user_create_activity_location') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_activity_location') ?></label>
                <input type="text" name="id_location" placeholder="<?php st_the_language('user_create_activity_location_search') ?>" id="id_location" class="st_post_select" data-post-type="location" style="width: 100%">
                <div class="st_msg console_msg_id_location"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-home input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_address') ?></label>
                <input id="address" name="address" type="text" placeholder="<?php st_the_language('user_create_activity_address') ?>" class="form-control">
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-rocket input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_latitude') ?></label>
                <input id="map_lat" name="map_lat" type="text" placeholder="<?php st_the_language('user_create_activity_latitude') ?>" class="form-control">
                <div class="st_msg console_msg_map_lat"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-rocket input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_longitude') ?></label>
                <input id="map_lng" name="map_lng" type="text" placeholder="<?php st_the_language('user_create_activity_longitude') ?>" class="form-control">
                <div class="st_msg console_msg_map_lng"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-plus-square input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_map_zoom')?></label>
                <input id="map_zoom" name="map_zoom" type="text" placeholder="<?php st_the_language('user_create_activity_map_zoom') ?>" class="form-control" value="13">
                <div class="st_msg console_msg_map_zoom"></div>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
    <h4><?php st_the_language('user_create_activity_info') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_start_date') ?></label>
                <input type="text" data-date-format="<?php echo TravelHelper::get_js_date_format()?>" name="check_in" class="date-pick form-control">
                <div class="st_msg console_msg_id_location"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_end_date') ?></label>
                <input type="text" data-date-format="<?php echo TravelHelper::get_js_date_format()?>" name="check_out" class="date-pick form-control">
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-clock-o input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_activity_time') ?></label>
                <input name="activity-time" class="time-pick form-control" type="text" placeholder="<?php st_the_language('user_create_activity_activity_time') ?>">
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-clock-o input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_duration') ?></label>
                <input type="text" name="duration" class="form-control" placeholder="<?php st_the_language('user_create_activity_duration') ?>">
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_activity_venue_facilities') ?></label>
                <textarea class="form-control" name="venue-facilities"></textarea>
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
    </div>
    <h4><?php st_the_language('user_create_activity_price') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-money input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_price') ?></label>
                <input id="price" name="price" type="text" placeholder="<?php st_the_language('user_create_activity_price') ?>" class="form-control">
                <div class="st_msg console_msg_id_location"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-star  input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_activity_discount') ?></label>
                <input id="discount" name="discount" type="text" placeholder="<?php st_the_language('user_create_activity_discount') ?>" class="form-control">
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_activity_best_price_guarantee') ?></label>
                <div class="checkbox checkbox-switch">
                    <label>
                        <input name="best-price-guarantee" class="i-check" type="checkbox" /><?php st_the_language('user_create_activity_on_off') ?></label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_activity_best_price_guarantee_text') ?></label>
                <textarea class="form-control" name="best-price-guarantee-text"></textarea>
            </div>
        </div>
    </div>
    <input  type="button" id="btn_check_insert_activity"  class="btn btn-primary" value="<?php st_the_language('user_create_activity_submit') ?>">
    <input name="btn_insert_post_type_activity" id="btn_insert_post_type_activity" type="submit"  class="btn btn-primary hidden" hidden="" value="SUBMIT">
</form>


