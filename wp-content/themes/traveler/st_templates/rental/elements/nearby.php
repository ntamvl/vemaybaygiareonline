<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental nearby
 *
 * Created by ShineTheme
 *
 */

$object=new STRental();

$nearby_posts=$object->get_near_by();

$default=array(
    'show_title'=>true,
    'class'=>''
);

if(isset($arg))
{
    extract(wp_parse_args($arg,$default));
}else
{
    extract($default);
}
if($show_title):

?>
    <h4><?php printf(st_get_language('rental_properties_near_d'),'<span class="title_nearby">'.get_the_title().'</span>')?></h4>
<?php
endif;
if($nearby_posts and !empty($nearby_posts))
{
    global $post;
    echo "<ul class='booking-list {$class}' >";
    foreach($nearby_posts as $key=>$post)
    {
        setup_postdata($post);
        $new_price=STRental::get_price();
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
                            $is_sale=STRental::is_sale();
                            ?>
                        </ul>
                    </div>
                    <div class="col-xs-3">
                        <?php
                        if($is_sale):

                            echo "<span class='booking-item-old-price'>".TravelHelper::format_money(STRental::get_orgin_price())."</span>";
                        endif;
                        ?>
                        <span class="booking-item-price-from"><span class="booking-item-price">
                            <?php
                            echo TravelHelper::format_money($new_price);?>
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