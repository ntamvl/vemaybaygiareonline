<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User create hotel
 *
 * Created by ShineTheme
 *
 */
?>
<div class="st-create">
    <h2><?php st_the_language('user_create_hotel') ?></h2>
</div>
<div class="msg">
    <?php echo STUser_f::get_msg(); ?>
</div>
<form action="" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('user_setting','st_insert_post_hotel'); ?>
    <div class="form-group form-group-icon-left">
        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
        <label><?php st_the_language('user_create_hotel_title') ?></label>
        <input id="title" name="title" type="text" placeholder="Title" class="form-control">
        <div class="st_msg console_msg_title"></div>
    </div>
    <div class="form-group form-group-icon-left">
        <label><?php st_the_language('user_create_hotel_content') ?></label>
        <?php wp_editor('','st_content'); ?>
    </div>
    <div class="form-group form-group-icon-left">
        <label><?php st_the_language('user_create_hotel_description') ?></label>
        <textarea id="desc" name="desc" class="form-control"></textarea>
        <div class="st_msg console_msg_desc"></div>
    </div>
    <h4><?php st_the_language('user_create_hotel_detail') ?></h4>
    <div class="row">
        <div class="col-md-12">
            <?php
            $taxonomy = STUser_f::get_list_value_taxonomy('st_hotel');
            if(!empty($taxonomy)):
                ?>
                <div class="form-group form-group-icon-left">
                    <label> <?php st_the_language('user_create_hotel_attributes') ?></label>
                    <div class="row">
                        <?php foreach($taxonomy as $k=>$v): ?>
                            <div class="col-md-3">
                                <div class="checkbox-inline checkbox-stroke">
                                    <label>
                                        <i class="<?php echo esc_html($v['icon']) ?>"></i>
                                        <input name="taxonomy[]" class="i-check" type="checkbox" value="<?php echo esc_attr($v['value'].','.$v['taxonomy']) ?>" /><?php echo esc_html($v['label']) ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-envelope-o input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_hotel_email') ?></label>
                <input id="email" name="email" type="email" placeholder="<?php st_the_language('user_create_hotel_email') ?>" class="form-control">
                <div class="st_msg console_msg_email"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-info-circle input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_hotel_website') ?></label>
                <input id="website" name="website" type="text" placeholder="<?php st_the_language('user_create_hotel_website') ?>" class="form-control">
                <div class="st_msg console_msg_website"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-phone input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_hotel_phone') ?></label>
                <input id="phone" name="phone" type="text" placeholder="<?php st_the_language('user_create_hotel_phone') ?>" class="form-control">
                <div class="st_msg console_msg_phone"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-phone input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_hotel_fax_number') ?></label>
                <input id="fax" name="fax" type="text" placeholder="<?php st_the_language('user_create_hotel_fax_number') ?>" class="form-control">
                <div class="st_msg console_msg_fax"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-youtube input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_hotel_video') ?></label>
                <input id="video" name="video" type="text" placeholder="<?php st_the_language('user_create_hotel_video') ?>" class="form-control">
                <div class="st_msg console_msg_video"></div>
            </div>
        </div>
    </div>
    <h4><?php st_the_language('user_create_hotel_location') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_hotel_location') ?></label>
                <input type="text" name="id_location" placeholder="<?php st_the_language('user_create_hotel_search') ?>" id="id_location" class="st_post_select" data-post-type="location" style="width: 100%">
                <div class="st_msg console_msg_id_location"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-home input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_hotel_address') ?></label>
                <input id="address" name="address" type="text" placeholder="<?php st_the_language('user_create_hotel_address') ?>" class="form-control">
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-rocket input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_hotel_latitude') ?></label>
                <input id="map_lat" name="map_lat" type="text" placeholder="<?php st_the_language('user_create_hotel_latitude') ?>" class="form-control">
                <div class="st_msg console_msg_map_lat"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-rocket input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_hotel_longitude') ?></label>
                <input id="map_lng" name="map_lng" type="text" placeholder="<?php st_the_language('user_create_hotel_longitude') ?>" class="form-control">
                <div class="st_msg console_msg_map_lng"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-plus-square input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_hotel_map_zoom') ?></label>
                <input id="map_zoom" name="map_zoom" type="text" placeholder="<?php st_the_language('user_create_hotel_map_zoom') ?>" class="form-control" value="13">
                <div class="st_msg console_msg_map_zoom"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group form-group-icon-left">
                <label> <?php st_the_language('user_create_hotel_featured_image') ?></label>
                <input id="featured-image" name="featured-image" type="file" class="">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_hotel_logo') ?></label>
                <input id="logo" name="logo" type="file" placeholder="Logo" class="">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_hotel_gallery') ?></label>
                <input id="gallery" name="gallery[]" type="file" placeholder="Gallery" multiple class="">
            </div>
        </div>
    </div>
    <input  type="button" id="btn_check_insert_post_type_hotel"  class="btn btn-primary" value="<?php st_the_language('user_create_hotel_submit') ?>">
    <input name="btn_insert_post_type_hotel" id="btn_insert_post_type_hotel" type="submit"  class="btn btn-primary hidden" hidden="" value="SUBMIT">
</form>
