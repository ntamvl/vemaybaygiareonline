<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User create cars
 *
 * Created by ShineTheme
 *
 */
?>
<div class="st-create">
    <h2><?php st_the_language('user_create_car') ?></h2>
</div>
<div class="msg">
    <?php echo STUser_f::get_msg(); ?>
</div>
<form action="" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('user_setting','st_insert_post_cars'); ?>
    <div class="form-group form-group-icon-left">
        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
        <label><?php st_the_language('user_create_car_title') ?></label>
        <input id="title" name="title" type="text" placeholder="<?php st_the_language('user_create_car_title') ?>" class="form-control">
        <div class="st_msg console_msg_title"></div>
    </div>
    <div class="form-group form-group-icon-left">
        <label><?php st_the_language('user_create_car_content') ?></label>
        <?php wp_editor('','st_content'); ?>
    </div>
    <div class="form-group form-group-icon-left">
        <label><?php st_the_language('user_create_car_description') ?></label>
        <textarea id="desc" name="desc" class="form-control"></textarea>
        <div class="st_msg console_msg_desc"></div>
    </div>
    <div class="form-group form-group-icon-left">
        <label> <?php st_the_language('user_create_car_featured_image') ?></label>
        <input id="featured-image" name="featured-image" type="file" class="">
    </div>
    <h4><?php st_the_language('user_create_car_detail') ?></h4>
    <div class="row">
        <div class="col-md-12">
            <?php
            $category = STUser_f::get_list_taxonomy('st_category_cars');
            if(!empty($category)):
                ?>
                <div class="form-group form-group-icon-left">
                    <label> <?php st_the_language('user_create_car_category') ?></label>
                    <div class="row">
                        <?php foreach($category as $k=>$v): ?>
                            <div class="col-md-3">
                                <div class="checkbox-inline checkbox-stroke">
                                    <label>
                                        <input name="id_category[]" class="i-check" type="checkbox" value="<?php echo esc_attr($k) ?>" /><?php echo esc_html($v) ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <div class="col-md-12">
            <?php
            $category = STUser_f::get_list_taxonomy('st_cars_pickup_features');
            if(!empty($category)):
                ?>
                <div class="form-group form-group-icon-left">
                    <label> <?php st_the_language('user_create_car_pickup_features') ?></label>
                    <div class="row">
                        <?php foreach($category as $k=>$v):
                            $icon = get_tax_meta($k,'st_icon');
                            $icon = TravelHelper::handle_icon($icon);
                            ?>
                            <div class="col-md-3">
                                <div class="checkbox-inline checkbox-stroke">
                                    <label>
                                        <i class="<?php echo esc_html($icon) ?>"></i>
                                        <input name="pickup_features[]" class="i-check" type="checkbox" value="<?php echo esc_attr($k) ?>" /><?php echo esc_html($v) ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_car_equipment_price_list') ?></label>
            </div>
        </div>
        <div class="" id="data_equipment_item">
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <button id="btn_add_equipment_item" type="button" class="btn btn-info"><?php st_the_language('user_create_car_add_equipment') ?></button><br>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_car_features') ?></label>
            </div>
        </div>
        <div class="" id="data_features">
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <button id="btn_add_features" type="button" class="btn btn-info"><?php st_the_language('user_create_car_add_features') ?></button><br>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-youtube input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_car_video') ?></label>
                <input id="video" name="video" type="text" placeholder="<?php st_the_language('user_create_car_video') ?>" class="form-control">
            </div>
        </div>

    </div>
    <h4><?php st_the_language('user_create_car_car_contact') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label> <?php st_the_language('user_create_car_logo') ?></label>
                <input id="logo" name="logo" type="file" class="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-star input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_car_name') ?></label>
                <input id="st_name" name="st_name" type="name" placeholder="<?php st_the_language('user_create_car_name') ?>" class="form-control">
                <div class="st_msg console_msg_email"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-envelope-o input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_car_email') ?></label>
                <input id="email" name="email" type="email" placeholder="<?php st_the_language('user_create_car_email') ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa  fa-phone input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_car_phone') ?></label>
                <input id="phone" name="phone" type="phone" placeholder="<?php st_the_language('user_create_car_phone') ?>" class="form-control">
                <div class="st_msg console_msg_email"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_car_about') ?></label>
                <textarea name="about" class="form-control" ></textarea>
            </div>
        </div>
    </div>
    <h4><?php st_the_language('user_create_car_location') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_car_location') ?></label>
                <input type="text" name="id_location" placeholder="<?php st_the_language('user_create_car_location_search') ?>" id="id_location" class="st_post_select" data-post-type="location" style="width: 100%">
                <div class="st_msg console_msg_id_location"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-home input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_car_address') ?></label>
                <input id="address" name="address" type="text" placeholder="<?php st_the_language('user_create_car_address') ?>" class="form-control">
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
    </div>

    <h4><?php st_the_language('user_create_car_price') ?></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-money input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_car_price') ?></label>
                <input id="price" name="price" type="text" placeholder="<?php st_the_language('user_create_car_price') ?>" class="form-control">
                <div class="st_msg console_msg_id_location"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-star  input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_car_discount') ?></label>
                <input id="discount" name="discount" type="text" placeholder="<?php st_the_language('user_create_car_discount') ?>" class="form-control">
                <div class="st_msg console_msg_address"></div>
            </div>
        </div>
    </div>
    <input  type="button" id="btn_check_insert_cars"  class="btn btn-primary" value="<?php st_the_language('user_create_car_submit') ?>">
    <input name="btn_insert_post_type_cars" id="btn_insert_post_type_cars" type="submit"  class="btn btn-primary hidden" hidden="" value="SUBMIT">
</form>

<div id="html_equipment_item" style="display: none">
    <div class="item">
        <div class="col-md-4">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_car_equipment_title') ?></label>
                <input id="title" name="equipment_item_title[]" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_car_equipment_price') ?></label>
                <input id="price" name="equipment_item_price[]" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group form-group-icon-left">
                <div class="btn btn-danger btn_del_program" style="margin-top: 27px">
                    <?php st_the_language('user_create_car_del') ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="html_features" style="display: none">
    <?php $list = STUser_f::get_list_value_taxonomy('st_cars'); ?>
    <?php if(!empty($list)){ ?>
    <div class="item">
        <div class="col-md-4">
            <div class="form-group form-group-icon-left">
                <i id="icon_create_car_taxonomy" class="input-icon input-icon-hightlight"></i>
                <label><?php st_the_language('user_create_car_features_attributes') ?></label>
                <?php
                if(!empty($list)){
                ?>
                    <select name="taxonomy[]" class="form-control taxonomy_car">
                        <?php foreach($list as $k=>$v){ ?>
                             <option data-icon="<?php echo esc_attr($v['icon']) ?>" value="<?php echo esc_attr($v['value'].','.$v['taxonomy']) ?>"><?php echo esc_attr($v['label']) ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group form-group-icon-left">
                <label><?php st_the_language('user_create_car_features_attributes_info') ?></label>
                <input id="title" name="taxonomy_info[]" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group form-group-icon-left">
                <div class="btn btn-danger btn_del_program" style="margin-top: 27px">
                    <?php st_the_language('user_create_car_del') ?>
                </div>
            </div>
        </div>
    </div>
    <?php }else{ ?>
    <div class="col-md-12">
        <label><?php st_the_language('user_create_car_no_data') ?></label>
    </div>
    <?php } ?>
</div>

