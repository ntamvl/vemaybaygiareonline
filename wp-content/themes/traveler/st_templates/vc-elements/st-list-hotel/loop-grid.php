<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/25/14
 * Time: 10:12 AM
 */

echo '<div class="row row-wrap">';
while($query->have_posts())
{
    $query->the_post();

    $col = 12 / $st_ht_of_row;
    $hotel=new STHotel(get_the_ID());
    ?>
        <div class="col-md-<?php echo esc_attr($col)?> col-sm-6 style_box">
            <?php echo STFeatured::get_featured(); ?>
            <div class="thumb">
                <a class="hover-img" href="<?php the_permalink()?>">
                    <?php the_post_thumbnail(array(400,300,'bfi_thumb'=>true));?>
                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                        <div class="text-small">
                            <h5><?php the_title()?></h5>
                            <p><?php comments_number(__('no review',ST_TEXTDOMAIN),__('1 review',ST_TEXTDOMAIN),__('% reviews',ST_TEXTDOMAIN))  ?></p>
                            <?php
                            $count_offer=100;
                            $count_offer=$hotel->count_offers(get_the_ID());

                            if($count_offer):
                                $min_price=STHotel::get_min_price();
                            ?>
                                <p class="mb0"><?php printf(_n('%s offer','%s offers',$count_offer,ST_TEXTDOMAIN),$count_offer);
                                    printf(__(' from %s',ST_TEXTDOMAIN),TravelHelper::format_money($min_price))
                                    ?></p>
                            <?php endif;?>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php
}
echo "</div>";