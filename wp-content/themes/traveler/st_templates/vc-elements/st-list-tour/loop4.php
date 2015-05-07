<ul class='booking-list'>
    <?php
    while(have_posts()):
        the_post();

        $info_price = STTour::get_info_price();
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
                    <div class="col-xs-4"><span class="booking-item-price-from"><?php _e('from',ST_TEXTDOMAIN)?></span>
                        <span class="booking-item-price list_tour_4">
                             <?php echo STTour::get_price_html(false,false,' <br> '); ?>
                        </span>
                        <?php if(!empty($count_sale)){ ?>
                            <span class="box_sale sale_small btn-primary"> <?php echo esc_html($count_sale) ?>% </span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </li>

    <?php
    endwhile;
    ?>

</ul>