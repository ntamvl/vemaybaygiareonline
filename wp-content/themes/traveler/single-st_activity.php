<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Single activity
 *
 * Created by ShineTheme
 *
 */
get_header();
get_template_part('breadcrumb');
?>
<div class="container">
    <div class="booking-item-details no-border-top">
        <header class="booking-item-header">
            <div class="row">
                <div class="col-md-9">
                    <h2 class="lh1em featured_single"><?php the_title() ?><?php echo STFeatured::get_featured(); ?></h2>
                    <p class="lh1em text-small"><i class="fa fa-map-marker"></i> <?php echo (get_post_meta(get_the_ID(),'address',true)) ?></p>
                    <ul class="list list-inline text-small">
                        <?php
                        $email = get_post_meta(get_the_ID(),'contact_email',true);
                        if(!empty($email))
                            echo '<li><a href="mailto:'.$email.'"><i class="fa fa-envelope"></i> '.st_get_language('activity_email').'</a> </li>';
                        ?>
                        <?php
                        $web = get_post_meta(get_the_ID(),'contact_web',true);
                        if(!empty($web))
                            echo '<li><a href="'.esc_url($web).'"><i class="fa fa-home"></i> '.st_get_language('activity_website').'</a></li>';
                        ?>
                        <?php
                        $phone = get_post_meta(get_the_ID(),'contact_phone',true);
                        if(!empty($phone))
                            echo '<li><i class="fa fa-phone"></i> '.$phone.'</li>';
                        ?>
                    </ul>
                </div>
                <div class="col-md-3">
                    <?php
                    $info_price = STActivity::get_info_price();
                    $price = $info_price['price'];
                    $count_sale = $info_price['discount'];
                    if(!empty($count_sale)){
                        $price = $info_price['price'];
                        $price_sale = $info_price['price_old'];
                    }
                    if(!empty($cars_price))?>
                    <p class="booking-item-header-price">
                        <small><?php st_the_language('activity_price') ?></small>
                        <?php if(!empty($count_sale)){ ?>
                            <span class=" onsale">
                                      <?php echo TravelHelper::format_money( $price_sale )?>
                                     </span>
                            <i class="fa fa-long-arrow-right"></i>
                        <?php } ?>
                        <span class="text-lg">
                            <?php echo TravelHelper::format_money($price) ?>
                        </span>
                    </p>
                </div>
            </div>
        </header>
        <?php
        $detail_layout=apply_filters('st_activity_detail_layout',st()->get_option('activity_layout'));
        if($detail_layout)
        {
            $content=STTemplate::get_vc_pagecontent($detail_layout);
            echo balanceTags( $content);
        }else{
            echo st()->load_template('activity/single','default');
        }
        ?>
    </div>
</div>
<?php get_footer( ) ?>