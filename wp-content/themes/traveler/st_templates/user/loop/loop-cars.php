<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User loop cars
 *
 * Created by ShineTheme
 *
 */
$status = get_post_status(get_the_ID());
if($status == 'draft'){
    $icon_class = 'status_warning fa-warning';
}else{
    $icon_class = 'status_ok  fa-check-square-o';
}
$info_price = STCars::get_info_price();
$price = $info_price['price'];
$count_sale = $info_price['discount'];
if(!empty($count_sale)){
    $price = $info_price['price'];
    $price_sale = $info_price['price_old'];
}
?>
<li <?php  post_class() ?>>
    <a data-id="<?php the_ID() ?>" data-id-user="<?php echo esc_attr($data['ID']) ?>" data-placement="top" rel="tooltip"  class="btn_remove_post_type cursor fa fa-times booking-item-wishlist-remove" data-original-title="<?php st_the_language('user_remove') ?>"></a>
    <a rel="tooltip" data-original-title="<?php st_the_language('user_edit') ?>" href="<?php echo home_url("wp-admin/post.php?post=".get_the_ID()."&action=edit") ?>"  class="btn_remove_post_type cursor fa fa-edit booking-item-wishlist-remove" style="top:90px ; background: #ed8323 ; color: #fff"></a>
    <i rel="tooltip" data-original-title="<?php st_the_language('user_status') ?>" data-placement="top"  class="<?php echo esc_attr($icon_class) ?> cursor fa  booking-item-wishlist-remove" style="top: 60px;"></i>

    <div class="spinner user_img_loading ">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
    <a href="<?php the_permalink() ?>" class="booking-item">
        <div class="row">
            <div class="col-md-3">
                <?php if(!empty($count_sale)){ ?>
                    <span style="left: -20px;" class="box_sale sale_small btn-primary"> <?php echo esc_html($count_sale) ?>% </span>
                <?php } ?>
                <div class="booking-item-car-img">
                    <?php
                    if(has_post_thumbnail()){
                        the_post_thumbnail(array(800,400,'bfi_thumb'=>true));
                    }else{
                        echo st_get_default_image();
                    }
                    ?>
                    <p class="booking-item-car-title"><?php the_title() ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-8">
                        <?php
                        $i=0;
                        $limit = st()->get_option('car_equipment_info_limit',11);
                        $data_text_small = $data_text_lg ='';
                        $taxonomy= get_object_taxonomies('st_cars','object');
                        $taxonomy_info = get_post_meta(get_the_ID(),'cars_equipment_info',true);
                        foreach($taxonomy as $key => $value){
                            if($key != 'st_category_cars'){
                                if($key != 'st_cars_pickup_features') {
                                    $data_term = get_the_terms(get_the_ID(), $key, true);
                                    if(!empty($data_term)){
                                        foreach($data_term as $k=>$v){
                                            // check taxonomy info
                                            $dk_check = false;
                                            if(is_array($taxonomy_info)){
                                                foreach($taxonomy_info as $k_info => $v_info){
                                                    if( $v->term_id == $v_info['cars_equipment_taxonomy_id'] ){
                                                        $dk_check = true;
                                                        $data_info = $v_info['cars_equipment_taxonomy_info'];
                                                        $data_title_info = $v_info['title'];
                                                    }
                                                }
                                            }
                                            if($i<$limit){
                                                if($dk_check == true){
                                                    $data_text_lg .=  '<li title="" data-placement="top" rel="tooltip" data-original-title="'.$data_title_info.'">
                                                                            <i class="'.TravelHelper::handle_icon(get_tax_meta($v->term_id, 'st_icon',true)).'"></i>
                                                                            <span class="booking-item-feature-sign">'.$data_info.'</span>
                                                                        </li>';
                                                }else{
                                                    $data_text_small .= '<li title="" data-placement="top" rel="tooltip" data-original-title="'.esc_html($v->name).'">
                                                                            <i class="'.TravelHelper::handle_icon(get_tax_meta($v->term_id, 'st_icon',true)).'"></i>
                                                                      </li>';
                                                }
                                            }
                                            $i++;
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                        <ul class="booking-item-features booking-item-features-sign clearfix"><?php echo balanceTags($data_text_lg)?></ul>
                        <ul class="booking-item-features booking-item-features-small clearfix"><?php echo balanceTags($data_text_small)?></ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="booking-item-features booking-item-features-dark">
                            <?php $data_terms = get_the_terms(get_the_ID(),'st_cars_pickup_features');
                            if(!empty($data_terms)){
                                foreach($data_terms as $k=>$v){
                                    $icon = get_tax_meta($v->term_id ,'st_icon',true);
                                    echo '<li title="" data-placement="top" rel="tooltip" data-original-title="'.$v->name.'">
                                                           <i class="'.TravelHelper::handle_icon( $icon ).'"></i>
                                                         </li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <span class="booking-item-price">
                    <?php if(!empty($count_sale)){ ?>
                        <span class="text-lg lh1em sale_block onsale">
                         <?php echo TravelHelper::format_money( $price_sale )?>
                        </span>
                    <?php } ?>
                    <?php echo TravelHelper::format_money($price) ?>
                </span>
                <span>/<?php st_the_language('user_day') ?></span>
                <?php $category = get_the_terms(get_the_ID() ,'st_category_cars') ?>
                <?php
                $txt ='';
                if(!empty($category)){
                    foreach($category as $k=>$v){
                        $txt .= $v->name.' ,';
                    }
                    $txt = substr($txt,0,-1);
                }
                ?>
                <p class="booking-item-flight-class"><?php echo esc_html($txt); ?></p>
            </div>
        </div>
    </a>
</li>

