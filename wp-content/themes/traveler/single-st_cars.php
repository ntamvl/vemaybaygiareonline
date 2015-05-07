<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Single cars
 *
 * Created by ShineTheme
 *
 */
get_header();
get_template_part('breadcrumb');
?>
    <div class="mfp-with-anim mfp-dialog mfp-search-dialog mfp-hide" id="search-dialog">
        <?php echo st()->load_template('cars/change-search-form');?>
    </div>
    <div class="container">
        <div class="booking-item-details no-border-top">
            <header class="booking-item-header ">
                <?php echo STTemplate::message()?>
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="lh1em featured_single"><?php the_title() ?><?php echo STFeatured::get_featured(); ?></h2>
                        <ul class="list list-inline text-small">
                            <?php
                            $email = get_post_meta(get_the_ID(),'cars_email',true);
                            if(!empty($email))
                                echo '<li><a href="mailto:'.$email.'"><i class="fa fa-envelope"></i> '.st_get_language('car_email').'</a> </li>';
                            ?>
                            <?php
                            $phone = get_post_meta(get_the_ID(),'cars_phone',true);
                            if(!empty($phone))
                                echo '<li><i class="fa fa-phone"></i> '.$phone.'</li>';
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $info_price = STCars::get_info_price();
                        $price = $info_price['price'];
                        $count_sale = $info_price['discount'];
                        $price_sale=0;
                        if(!empty($count_sale)){
                            $price = $info_price['price'];
                            $price_sale = $info_price['price_old'];
                        }
                        if(!empty($price))?>
                            <p class="booking-item-header-price">
                                <small><?php  st_the_language('car_price') ?></small>
                                <?php if(!empty($count_sale)){ ?>
                                     <span class=" onsale">
                                      <?php echo TravelHelper::format_money( $price_sale )?>
                                     </span>
                                    <i class="fa fa-long-arrow-right"></i>
                                <?php } ?>
                                <span class="text-lg">
                                        <?php echo TravelHelper::format_money($price) ?>
                                </span>/<?php echo STCars::get_price_unit() ?>
                            </p>
                    </div>
                </div>
            </header>
            <div class="gap gap-small"></div>
            <?php
            $detail_cars_layout=apply_filters('st_cars_detail_layout',st()->get_option('cars_single_layout'));
            if($detail_cars_layout)
            {
                echo  STTemplate::get_vc_pagecontent($detail_cars_layout);
            }else{
                echo st()->load_template('cars/single','default');
            }
            ?>
        </div><!-- End .booking-item-details-->
    </div>
<?php get_footer( ) ?>