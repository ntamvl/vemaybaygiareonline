<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User create rental
 *
 * Created by ShineTheme
 *
 */
?>
<div class="st-create">
    <h2><?php st_the_language('user_create_rental') ?></h2>
</div>
<div class="msg">
    <?php echo STUser_f::get_msg(); ?>
</div>
<form action="" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('user_setting','st_insert_post_rental'); ?>
    <div class="form-group form-group-icon-left">
        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
        <label><?php st_the_language('user_create_rental_title') ?></label>
        <input id="title" name="title" type="text" placeholder="Title" class="form-control">
        <div class="st_msg console_msg_title"></div>
    </div>
    <div class="form-group form-group-icon-left">
        <label><?php st_the_language('user_create_rental_content') ?></label>
        <?php wp_editor('','st_content'); ?>
    </div>
    <div class="form-group form-group-icon-left">
        <label><?php st_the_language('user_create_rental_description') ?></label>
        <textarea id="desc" name="desc" class="form-control"></textarea>
        <div class="st_msg console_msg_desc"></div>
    </div>
    <h4><?php st_the_language('user_create_rental_detail') ?></h4>
    <div class="row"><div class="col-md-12">
            <?php
            $taxonomy = STUser_f::get_list_value_taxonomy('st_rental');
            if(!empty($taxonomy)):
                ?>
                <div class="form-group form-group-icon-left">
                    <label> <?php st_the_language('user_create_rental_attributes') ?></label>
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
                <label><?php st_the_language('user_create_rental_email') ?></label>
                <input id="email" name="email" type="email" placeholder="<?php st_the_language('user_create_rental_email') ?>" class="form-control">
                <div class="st_msg console_msg_email"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-info-circle input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_rental_website') ?></label>
                <input id="website" name="website" type="text" placeholder="<?php st_the_language('user_create_rental_website') ?>" class="form-control">
                <div class="st_msg console_msg_website"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-phone input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_rental_phone') ?></label>
                <input id="phone" name="phone" type="text" placeholder="<?php st_the_language('user_create_rental_phone') ?>" class="form-control">
                <div class="st_msg console_msg_phone"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-youtube input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_rental_video') ?></label>
                <input id="video" name="video" type="text" placeholder="<?php st_the_language('user_create_rental_video') ?>" class="form-control">
                <div class="st_msg console_msg_video"></div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_rental_features') ?></label>
            </div>
        </div>
        <div class="" id="data_features_rental">
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <button id="btn_add_features_rental" type="button" class="btn btn-info"><?php st_the_language('user_create_rental_add_features') ?></button><br>
            </div>
        </div>
    </div>
    <h4><?php st_the_language('user_create_rental_location') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_rental_location') ?></label>
                <input type="text" name="id_location" placeholder="<?php st_the_language('user_create_rental_search') ?>" id="id_location" class="st_post_select" data-post-type="location" style="width: 100%">
                <div class="st_msg console_msg_id_location"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-home input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_rental_address') ?></label>
                <input id="address" name="address" type="text" placeholder="<?php st_the_language('user_create_rental_address') ?>" class="form-control">
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-rocket input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_rental_latitude') ?></label>
                <input id="map_lat" name="map_lat" type="text" placeholder="Latitude" class="form-control">
                <div class="st_msg console_msg_map_lat"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-rocket input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_rental_longitude') ?></label>
                <input id="map_lng" name="map_lng" type="text" placeholder="Longitude" class="form-control">
                <div class="st_msg console_msg_map_lng"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-plus-square input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_rental_map_zoom') ?></label>
                <input id="map_zoom" name="map_zoom" type="text" placeholder="Map Zoom" class="form-control" value="13">
                <div class="st_msg console_msg_map_zoom"></div>
            </div>
        </div>
    </div>
    <h4><?php st_the_language('user_create_rental_price') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-money input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_rental_price') ?></label>
                <input id="price" name="price" type="text" placeholder="<?php st_the_language('user_create_rental_price') ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-star input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_rental_discount') ?></label>
                <input id="discount" name="discount" type="text" placeholder="<?php st_the_language('user_create_rental_discount') ?>" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label> <?php st_the_language('user_create_rental_featured_image') ?></label>
                <input id="featured-image" name="featured-image" type="file" class="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_rental_gallery') ?></label>
                <input id="gallery" name="gallery[]" type="file" multiple class="">
            </div>
        </div>
    </div>
    <input  type="button" id="btn_check_insert_post_type_rental"  class="btn btn-primary" value="<?php st_the_language('user_create_rental_submit') ?>">
    <input name="btn_insert_post_type_rental" id="btn_insert_post_type_rental" type="submit"  class="btn btn-primary hidden" hidden="" value="SUBMIT">
</form>
<div id="html_features_rental" style="display: none">
    <div class="item">
        <div class="col-md-4">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_rental_features_title') ?></label>
                <input id="title" name="features_title[]" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_rental_features_number') ?></label>
                <input id="title" name="features_number[]" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_rental_features_icon') ?></label>
                <input id="title" name="features_icon[]" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group form-group-icon-left">
                <div class="btn btn-danger btn_del_program" style="margin-top: 27px">
                    <?php st_the_language('user_create_rental_features_del') ?>
                </div>
            </div>
        </div>
    </div>
</div>