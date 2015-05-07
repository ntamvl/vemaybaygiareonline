<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Activity element nearby
 *
 * Created by ShineTheme
 *
 */

$activity=new STActivity();
$nearby_posts=$activity->get_near_by();
$title_activity = st_get_language('activity_near');
if(!empty($nearby_posts)){
    if(count($nearby_posts)  > 1){
        $title_activity = st_get_language('activities_near');
    }
}
?>
    <h4><?php echo esc_html($title_activity); ?>
        <span class="title_bol"><?php echo the_title(); ?></span>
    </h4>
<?php

if($nearby_posts and !empty($nearby_posts))
{
    global $post;
    echo "<ul class='booking-list'>";
    foreach($nearby_posts as $key=>$post)
    {
        setup_postdata($post);
        $info_price = STActivity::get_info_price();
        $price = $info_price['price'];
        $count_sale = $info_price['discount'];
        if(!empty($count_sale)){
            $price = $info_price['price'];
            $price_sale = $info_price['price_old'];
        }
        ?>
        <li <?php post_class('item-nearby')?>>
            <div class="booking-item booking-item-small">
                <div class="row">
                    <div class="col-xs-4">

                        <a href="<?php the_permalink()?>">
                            <?php the_post_thumbnail()?>
                        </a>
                    </div>
                    <div class="col-xs-4">
                        <h5 class="booking-item-title"><a href="<?php the_permalink()?>"><?php the_title()?></a> </h5>
                        <ul class="icon-group booking-item-rating-stars">
                            <?php
                            $avg = STReview::get_avg_rate();
                            echo TravelHelper::rate_to_string($avg);
                            ?>
                        </ul>
                    </div>
                    <div class="col-xs-4"><span class="booking-item-price-from"><?php st_the_language('from')?></span>
                        <?php if(!empty($count_sale)){ ?>
                            <span class="text-small lh1em  onsale">
                                    <?php echo TravelHelper::format_money( $price_sale )?>
                                </span>
                           <!-- <i class="fa fa-long-arrow-right"></i>-->
                        <?php } ?>
                        <span class="booking-item-price">
                            <?php
                            echo TravelHelper::format_money($price);?>
                        </span>
                        <?php if(!empty($count_sale)){ ?>
                            <span class="box_sale sale_small btn-primary"> <?php echo esc_html($count_sale) ?>% </span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </li>


        <?php
    }
    echo "</ul>";
    wp_reset_query();
    wp_reset_postdata();
}