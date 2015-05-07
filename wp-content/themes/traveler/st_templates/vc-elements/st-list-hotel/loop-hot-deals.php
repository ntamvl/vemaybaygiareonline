<?php
while($query->have_posts()):
    $query->the_post();?>
    <ul class="booking-list">
        <li>
            <a href="<?php the_permalink() ?>">
                <div class="booking-item booking-item-small">
                    <div class="row">
                        <div class="col-xs-4">
                            <?php
                            $img = get_the_post_thumbnail( get_the_ID() , array(800,600,'bfi_thumb'=>true)) ;
                            if(!empty($img)){
                                echo balanceTags($img);
                            }else{
                                echo '<img width="800" height="600" alt="no-image" class="wp-post-image" src="'.bfi_thumb(get_template_directory_uri().'/img/no-image.png',array('width'=>800,'height'=>600)).'">';
                            }
                            ?>
                        </div>
                        <div class="col-xs-5">
                            <h5 class="booking-item-title"><?php the_title() ?></h5>
                            <ul class="icon-group booking-item-rating-stars">
                                <?php
                                echo TravelHelper::rate_to_string(STReview::get_avg_rate());
                                ?>
                            </ul>
                        </div>
                        <?php
                        $price=0;
                        $price =  STHotel::get_min_price();
                        ?>
                        <div class="col-xs-3">
                            <span class="booking-item-price-from"><?php _e('from',ST_TEXTDOMAIN)?></span>
                            <span class="booking-item-price"><?php echo TravelHelper::format_money( $price )?></span>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    </ul>

<?php endwhile; ?>