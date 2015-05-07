<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/29/14
 * Time: 4:03 PM
 */

echo '<div class="row row-wrap">';
while($query->have_posts())
{
    $query->the_post();

    $col = 12 / $st_ht_of_row;
    $hotel=new STHotel(get_the_ID());
    ?>
    <div <?php post_class('col-md-'.esc_attr($col)." col-sm-6 style_box")?>>
        <?php echo STFeatured::get_featured(); ?>
        <div class="thumb">
            <header class="thumb-header">
                <a class="hover-img" href="<?php the_permalink()?>">
                    <?php the_post_thumbnail(array(400,300,'bfi_thumb'=>true));?>

                    <h5 class="hover-title-center"><?php _e('Book Now',ST_TEXTDOMAIN)?></h5>
                </a>
            </header>
            <div class="thumb-caption">
                <ul class="icon-group text-tiny text-color">
                    <?php
                    $avg = STReview::get_avg_rate();
                    echo TravelHelper::rate_to_string($avg);
                    ?>
                </ul>
                <h5 class="thumb-title"><a class="text-darken" href="<?php the_permalink()?>"><?php the_title()?></a></h5>
                <?php $address=get_post_meta(get_the_ID(),'address',true); ?>
                <p class="mb0"><small><i class="fa fa-map-marker"></i> <?php echo balanceTags($address)?></small>
                </p>
                <p class="mb0 text-darken">
                    <span class="text-lg lh1em text-color"><?php
                        $min_price=STHotel::get_min_price();
                        echo TravelHelper::format_money($min_price)?></span><small> <?php _e('avg/night',ST_TEXTDOMAIN)?></small>

            </div>
        </div>
    </div>
<?php
}
echo "</div>";