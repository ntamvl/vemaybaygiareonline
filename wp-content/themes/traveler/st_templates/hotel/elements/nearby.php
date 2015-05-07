<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Hotel nearby
 *
 * Created by ShineTheme
 *
 */

$hotel=new STHotel();

$nearby_posts=$hotel->get_near_by();
$title = st_get_language('hotel_near');
if(!empty($nearby_posts)){
    if(count($nearby_posts)  > 1){
        $title = st_get_language('hotels_near');
    }
}
?>
    <h4><?php echo esc_html($title); ?>
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
        ?>
        <li <?php post_class('item-nearby')?>>
            <div class="booking-item booking-item-small">
                <div class="row">
                    <div class="col-xs-4">
                        <a href="<?php the_permalink()?>">
                        <?php the_post_thumbnail()?>
                        </a>
                    </div>
                    <div class="col-xs-5">
                        <h5 class="booking-item-title"><a href="<?php the_permalink()?>"><?php the_title()?></a> </h5>
                        <ul class="icon-group booking-item-rating-stars">
                            <?php
                            $avg = STReview::get_avg_rate();
                            echo TravelHelper::rate_to_string($avg);
                            ?>
                        </ul>
                    </div>
                    <div class="col-xs-3"><span class="booking-item-price-from"><?php st_the_language('from')?></span><span class="booking-item-price">
                            <?php $min_price=get_post_meta(get_the_ID(),'min_price',true);
                            echo TravelHelper::format_money($min_price);?>
                            </span>
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