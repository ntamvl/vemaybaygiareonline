<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * hotel loop
 *
 * Created by ShineTheme
 *
 */
global $wp_query;

if(!isset($style)) $style='list';
if($style=='list') {
    if (have_posts()) {
        echo '<ul class="booking-list loop-hotel style_list">';
        while (have_posts()) {
            the_post();
            $link=st_get_link_with_search(get_permalink(),array('start','end','room_num_search','adult_num'),$_GET);
            $hotel = new STHotel(get_the_ID());
            $thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
            ?>
            <li <?php post_class('booking-item') ?>>
                <?php echo STFeatured::get_featured(); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="booking-item-img-wrap st-popup-gallery">
                                <a href="<?php echo esc_url($thumb_url)?>" class="st-gp-item">
                                    <?php the_post_thumbnail(array(360, 270, 'bfi_thumb' => true)) ?>
                                </a>
                                <?php
                                $count = 0;
                                $gallery = get_post_meta(get_the_ID(), 'gallery', true);

                                $gallery = explode(',', $gallery);


                                if (!empty($gallery) and $gallery[0]) {
                                    $count += count($gallery);
                                }

                                if(has_post_thumbnail()){
                                    $count++;
                                }


                                if ($count) {
                                    echo '<div class="booking-item-img-num"><i class="fa fa-picture-o"></i>';
                                    echo esc_attr($count);
                                    echo '</div>';
                                }
                                ?>
                                <div class="hidden">
                                    <?php if (!empty($gallery) and $gallery[0]) {
                                        $count += count($gallery);
                                        foreach($gallery as $key=>$value)
                                        {
                                            $img_link=wp_get_attachment_image_src($value,array(800,600,'bfi_thumb'=>true));
                                            if(isset($img_link[0]))
                                            echo "<a class='st-gp-item' href='{$img_link[0]}'></a>";
                                        }

                                    }?>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">


                            <div class="booking-item-rating">
                                <ul class="icon-group booking-item-rating-stars">
                                    <?php
                                    $avg = STReview::get_avg_rate();
                                    echo TravelHelper::rate_to_string($avg);
                                    ?>
                                </ul>
                                <span
                                    class="booking-item-rating-number"><b><?php echo esc_html($avg) ?></b> <?php st_the_language('of_5') ?></span>
                                <small>
                                    (<?php comments_number(st_get_language('no_review'), st_get_language('1_review'), st_get_language('s_reviews')); ?>
                                    )
                                </small>
                            </div>
                            <a class="color-inherit" href="<?php echo esc_url($link) ?>">
                                <h5 class="booking-item-title"><?php the_title() ?>
                                    <?php if($hotel_star=get_post_meta(get_the_ID(),'hotel_star',true)){
                                        echo " <small class='hotel_star'>(";
                                       printf(st_get_language('s_star'),$hotel_star);
                                        echo ")</small>";
                                    }?>
                                </h5>
                            </a>
                            <?php if ($address = get_post_meta(get_the_ID(), 'address', true)): ?>
                                <p class="booking-item-address"><i class="fa fa-map-marker"></i> <?php echo esc_html($address) ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($last_booking = $hotel->get_last_booking()): ?>
                                <small
                                    class="booking-item-last-booked"><?php echo st_get_language('lastest_booking') . ' ' . $last_booking ?></small>
                            <?php endif; ?>

                        </div>
                        <div class="col-md-3"><span class="booking-item-price-from"><?php st_the_language('from') ?></span><span
                                class="booking-item-price"><?php echo TravelHelper::format_money(STHotel::get_min_price()) ?></span><span>/<?php st_the_language('night')?></span><a
                                class="btn btn-primary btn_book" href="<?php echo esc_url($link) ?>"><?php st_the_language('book_now') ?></a>


                        </div>
                    </div>
            </li>
        <?php
        }

        echo "</ul>";

    }

}else{
    ?>
        <div class="row row-wrap loop_hotel loop_grid_hotel style_box">

            <?php
                while(have_posts()){
                    the_post();
                    $link=st_get_link_with_search(get_permalink(),array('start','end','room_num_search','adult_num'),$_GET);
                    $thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                    ?>
                    <div class="col-md-4">
                        <?php echo STFeatured::get_featured(); ?>
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img" href="<?php echo esc_url($link)?>">

                                    <?php the_post_thumbnail(array(360, 270, 'bfi_thumb' => true)) ?>
                                    <h5 class="hover-title-center"><?php st_the_language('book_now')?> </h5>
                                </a>

                            </header>
                            <div class="thumb-caption">
                                <ul class="icon-group text-color">
                                    <?php
                                    $avg = STReview::get_avg_rate();
                                    echo TravelHelper::rate_to_string($avg);
                                    ?>
                                </ul>
                                <h5 class="thumb-title"><a class="text-darken" href="<?php echo esc_url($link)?>"><?php the_title()?></a></h5>
                            <?php if ($address = get_post_meta(get_the_ID(), 'address', true)): ?>
                                <p class="mb0"><small> <?php echo esc_html($address) ?></small>
                                </p>
                            <?php endif;?>
                                <p class="mb0 text-darken"><span class="text-lg lh1em"><?php echo TravelHelper::format_money(get_post_meta(get_the_ID(), 'min_price', true)) ?></span><small> <?php st_the_language('avg/night')?></small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    <?php
}