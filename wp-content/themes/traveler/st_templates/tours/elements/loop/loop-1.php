<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours loop content 1
 *
 * Created by ShineTheme
 *
 */
if(have_posts())
{
    echo '<ul class="booking-list loop-tours style_list">';
        while(have_posts())
        {
            the_post();
            $tours = new STTour();
            $info_price = STTour::get_info_price();
            $price = $info_price['price'];
            $count_sale = $info_price['discount'];
            if(!empty($count_sale)){
                $price = $info_price['price'];
                $price_sale = $info_price['price_old'];
            }

            ?>
            <li <?php post_class('booking-item') ?>>
                <?php echo STFeatured::get_featured(); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="booking-item-img-wrap">
                                <?php the_post_thumbnail(array(360, 270, 'bfi_thumb' => true)) ?>
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
                                    class="booking-item-rating-number"><b><?php echo esc_html($avg) ?></b> <?php st_the_language('tour_of_5') ?></span>
                                <small>
                                    (<?php comments_number(st_get_language('tour_no_review'), st_get_language('tour_1_review'), "% ".st_get_language('reviews')); ?>)
                                </small>
                            </div>
                            <a class="" href="<?php the_permalink() ?>">
                            <h5 class="booking-item-title"><?php the_title() ?></h5>
                            </a>
                            <?php if ($address = get_post_meta(get_the_ID(), 'address', true)): ?>
                                <p class="booking-item-address"><i class="fa fa-map-marker"></i> <?php echo esc_html($address) ?>
                                </p>
                            <?php endif; ?>
                            <div class="package-info">
                                <?php $max_people = get_post_meta(get_the_ID(),'max_people', true) ?>
                                <i class="fa    fa-users"></i>
                                <span class=""><?php st_the_language('tour_max_people') ?> : </span>
                                <?php echo esc_html($max_people.' ') ; st_the_language('tour_people')?>
                            </div>
                            <div class="package-info">
                                <?php $type_tour = get_post_meta(get_the_ID(),'type_tour',true); ?>
                                <?php if($type_tour == 'daily_tour'){ ?>
                                    <i class="fa fa-calendar"></i>
                                    <span class=""><?php  _e('Duration',ST_TEXTDOMAIN)?> : </span>
                                    <?php  $day =  get_post_meta(get_the_ID(),'duration_day',true)?>
                                    <?php echo esc_html($day) ?>
                                    <?php if($day > 1) _e('days',ST_TEXTDOMAIN); else _e('day',ST_TEXTDOMAIN) ?>
                                <?php }else{ ?>
                                    <?php
                                    $check_in = get_post_meta(get_the_ID() , 'check_in' ,true);
                                    $check_out = get_post_meta(get_the_ID() , 'check_out' ,true);
                                    if(!empty($check_out) and !empty($check_out)):
                                        ?>
                                        <i class="fa fa-calendar"></i>
                                        <span class=""><?php st_the_language('tour_date') ?> : </span>
                                        <?php
                                        $date = mysql2date('m/d/Y',$check_in).' <i class="fa fa-long-arrow-right"></i> '.mysql2date('m/d/Y',$check_out);
                                        echo balanceTags($date);
                                    endif;
                                    ?>
                                <?php } ?>
                            </div>
                            <div class="package-info">
                                <?php $info_book = STTour::get_count_book(get_the_ID());?>
                                <i class="fa  fa-user"></i>
                                <span class="">
                                    <?php
                                       if($info_book > 1){
                                           echo sprintf( __( '%d users booked',ST_TEXTDOMAIN ), $info_book );
                                       }else{
                                           echo sprintf( __( '%d user booked',ST_TEXTDOMAIN ), $info_book );
                                       }
                                    ?>
                                </span>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <span class="booking-item-price-from"><?php st_the_language('tour_from') ?></span>

                            <?php echo STTour::get_price_html() ?>

                            <span class="info_price"></span>
                            <a href="<?php the_permalink()?>">
                            <span class="btn btn-primary btn_book"><?php st_the_language('tour_book_now') ?></span>
                            </a>
                            <?php if(!empty($count_sale)){ ?>
                                <span class="box_sale sale_small btn-primary"> <?php echo esc_html($count_sale) ?>% </span>
                            <?php } ?>
                        </div>
                    </div>
            </li>
            <?php
        }

    echo "</ul>";

}