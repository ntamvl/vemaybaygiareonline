<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Admin cars booking edit
 *
 * Created by ShineTheme
 *
 */

$item_id=isset($_GET['order_item_id'])?$_GET['order_item_id']:false;

$order_item_id=get_post_meta($item_id,'item_id',true);

$order=$item_id;

if(!isset($page_title))
{
    $page_title=__('Edit Car Booking',ST_TEXTDOMAIN);
}

?>
<div class="wrap">
    <?php echo '<h2>'.$page_title.'<a href="'.admin_url('edit.php?post_type=st_cars&page=st_car_booking&section=add_booking').'" class="add-new-h2">'.__('Add New',ST_TEXTDOMAIN).'</a></h2>';?>
    <?php STAdmin::message() ?>
    <div id="post-body" class="columns-2">
        <div id="post-body-content">
            <div class="postbox-container">
                <form method="post" action="" method="post">
                    <?php wp_nonce_field('shb_action','shb_field') ?>
                    <div id="poststuff">
                        <div class="postbox">
                            <div class="handlediv" title="<?php _e('Click to toggle',ST_TEXTDOMAIN)?>"><br></div>
                            <h3 class="hndle ui-sortable-handle"><span><?php _e('Order Information',ST_TEXTDOMAIN)?></span></h3>


                            <div class="inside">
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Customer ID',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <?php
                                        $id_user='';
                                        if($order){
                                            $id_user= get_post_meta($order,'id_user',true);
                                        }
                                        $pl_name='';
                                        $pl_desc='';
                                        if($id_user)
                                        {
                                            $user=get_userdata($id_user);
                                            if($user)
                                            {
                                                $pl_name=$user->user_login.' (#'.$user->ID.' - '.$user->user_email.')';
                                                $pl_desc="";//"ID: ".get_the_ID($field_value);
                                            }
                                        }
                                        ?>
                                        <input type="hidden" name="id_user" value="<?php echo esc_attr($id_user); ?>" data-pl-name="<?php echo esc_attr($pl_name)  ?>" class="form-control st_user_select_ajax " data-pl-desc="<?php echo esc_attr($pl_desc)  ?>">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Customer First Name',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_first_name" value="<?php echo get_post_meta($order,'st_first_name',true)?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Customer Last Name',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_last_name" value="<?php echo get_post_meta($order,'st_last_name',true)?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Customer Email',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_email" value="<?php echo get_post_meta($order,'st_email',true)?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Customer Phone',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_phone" value="<?php echo get_post_meta($order,'st_phone',true)?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Customer Address line 1',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_address" value="<?php echo get_post_meta($order,'st_address',true)?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Customer Address line 2',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_address2" value="<?php echo get_post_meta($order,'st_address2',true)?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Customer City',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_city" value="<?php echo get_post_meta($order,'st_city',true)?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('State/Province/Region',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_province" value="<?php echo get_post_meta($order,'st_province',true)?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('ZIP code/Postal code',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_zip_code" value="<?php echo get_post_meta($order,'st_zip_code',true)?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Country',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_country" value="<?php echo get_post_meta($order,'st_country',true)?>" class="form-control">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Car',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="hidden" name="item_id" value="<?php  echo get_post_meta($item_id,'item_id',true)?>" data-post-type="st_cars" class="form-control st_post_select_ajax " data-pl-name="<?php echo get_the_title( get_post_meta($item_id,'item_id',true) ) ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Driver’s Name',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="driver_name" value="<?php  echo get_post_meta($item_id,'driver_name',true)?>" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Driver’s Age',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="driver_age" value="<?php  echo get_post_meta($item_id,'driver_age',true)?>"  class="form-control ">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Number',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="item_number" value="<?php echo get_post_meta($item_id,'item_number',true)?>" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Price',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="item_price" value="<?php echo get_post_meta($item_id,'item_price',true)?>" class="form-control ">
                                    </div>
                                </div>
                                <?php
                                $items = get_post_meta($item_id,"item_equipment",true);
                                if(!empty($items) and $items != 'null'){
                                    if(!is_array(json_decode($items)))
                                    $items = get_object_vars(json_decode($items));

                                }else{
                                    $items =array();
                                }
                                $id_car = get_post_meta($item_id,'item_id',true);
                                $items_car =  get_post_meta($id_car,'cars_equipment_list',true);
                                ?>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Equipment Price List',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <?php
                                        if(!empty($items_car)){
                                            foreach($items_car as $key=>$value):
                                                $dk =false;
                                                $check ="";
                                                foreach($items as $k=>$v){
                                                    if($k == $value['title']){
                                                        $dk = true;
                                                    }
                                                }
                                                if($dk == true){
                                                    $check = 'checked';
                                                }
                                                ?>


                                        <div>
                                            <input type="checkbox" <?php echo esc_attr($check) ?> name="item_equipment[]" value="<?php echo esc_attr($value['cars_equipment_list_price'].'|'.$value['title']) ?>" class="form-control "><?php echo esc_html($value['cars_equipment_list_price'])." - ".esc_html($value['title']) ?>
                                        </div>
                                        <?php endforeach;  }?>
                                    </div>

                                </div>
                                <?php  ?>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Tax',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="st_tax" value="<?php echo get_post_meta($order,'st_tax',true)?>" class="form-control ">%
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for=""><?php _e('Total',ST_TEXTDOMAIN)?></label>
                                    <div class="controls" data-price-item="<?php echo get_post_meta($item_id,'item_price',true) ?>">
                                        <input type="text" disabled value="<?php
                                        echo number_format((float) STCart::get_order_item_total($item_id,get_post_meta($order,'st_tax',true)),2);
                                        ?>" class="form-control "><?php _e('Auto calculate',ST_TEXTDOMAIN)?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for="check_in"><?php _e('Pick up',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="pick_up" value="<?php echo get_post_meta($item_id,'pick_up',true);?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for="check_in"><?php _e('Check in',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input placeholder="dd/mm/yyyy" type="text" name="check_in" value="<?php $time= get_post_meta($item_id,'check_in',true);if($time) echo date('m/d/Y',strtotime($time))?>" class="form-control st_datepicker ">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for="check_in"><?php _e('Check in time',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input id="<?php echo esc_attr($item_id) ?>" type="text" name="check_in_time" value="<?php echo get_post_meta($item_id,'check_in_time',true) ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for="check_in"><?php _e('Drop off',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input type="text" name="drop_off" value="<?php echo get_post_meta($item_id,'drop_off',true);?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for="check_out"><?php _e('Check out',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input placeholder="dd/mm/yyyy" type="text" name="check_out" value="<?php $time= get_post_meta($item_id,'check_out',true);
                                        if($time) echo date('m/d/Y',strtotime($time))
                                        ?>" class="form-control st_datepicker">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for="check_out"><?php _e('Check out time',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <input id="<?php echo esc_attr($item_id) ?>"  type="text" name="check_out_time" value="<?php echo get_post_meta($item_id,'check_out_time',true) ?>" class="form-control ">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for="st_note"><?php _e('Special Requirements',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <textarea name="st_note" rows="6"><?php echo get_post_meta($order,'st_note',true); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="form-label" for="status"><?php _e('Status',ST_TEXTDOMAIN)?></label>
                                    <div class="controls">
                                        <select data-block="" class="form-control" name="status">
                                            <?php $status=get_post_meta($order,'status',true); ?>

                                            <option value="pending" <?php selected($status,'pending') ?> ><?php _e('Pending',ST_TEXTDOMAIN)?></option>
                                            <option value="complete" <?php selected($status,'complete') ?> ><?php _e('Complete',ST_TEXTDOMAIN)?></option>
                                            <option value="canceled" <?php selected($status,'canceled') ?> ><?php _e('Canceled',ST_TEXTDOMAIN)?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="controls">
                                        <label class="form-label" for="" >&nbsp;</label>
                                        <input type="submit" name="submit" value="<?php echo __('Save',ST_TEXTDOMAIN)?>" class="button button-primary ">
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>