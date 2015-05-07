<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours nearby
 *
 * Created by ShineTheme
 *
 */

$tour=new STTour();
$nearby_posts=$tour->get_near_by();

?>
    <h4><?php
        $limit = st()->get_option('tours_similar_tour',5);
        if($limit > 0){
            st_the_language('similar_tours');
        }else{
            st_the_language('similar_tour');
        }
        ?></h4>

<?php

if($nearby_posts and !empty($nearby_posts))
{
    global $post;
    echo "<ul class='booking-list'>";
    foreach($nearby_posts as $key=>$post)
    {
        setup_postdata($post);
        $info_price = STTour::get_info_price();
        $price = $info_price['price'];
        $count_sale = $info_price['discount'];
        if(!empty($count_sale)){
            $price = $info_price['price'];
            $price_sale = $info_price['price_old'];
        }
        ?>
        <li <?php post_class('item-nearby')?>>
            <?php echo STFeatured::get_featured(); ?>
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
                    <div class="col-xs-4"><span class="booking-item-price-from"><?php st_the_language('tour_from')?></span>
                        <?php if(!empty($count_sale)){ ?>
                            <span class="text-small lh1em  onsale">
                                    <?php echo TravelHelper::format_money( $price_sale )?>
                                </span>
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