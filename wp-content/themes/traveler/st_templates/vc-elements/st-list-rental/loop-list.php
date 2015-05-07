<?php
extract($data);
$col = 12/$number_of_row;

$price=STRental::get_orgin_price();
$is_sale=STRental::is_sale();
$price_sale=STRental::get_price();

?>
<div <?php post_class('col-md-'.$col.' style_box')?> >
    <?php echo STFeatured::get_featured(); ?>
    <div class="thumb">

        <header class="thumb-header">
            <a class="hover-img" href="<?php the_permalink()?>">
                <?php
                if(has_post_thumbnail()){
                    the_post_thumbnail(array(400,300,'bfi_thumb' => true ));
                }else{
                    st_get_default_image();
                }
                ?>
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
            <h5 class="thumb-title">
                <a class="text-darken" href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
            <?php $address=get_post_meta(get_the_ID(),'address',true);
                  if($address):
            ?>
                    <p class="mb0"><small><i class="fa fa-map-marker"></i> <?php echo balanceTags($address)?></small>
                    </p>
            <?php endif;?>

            <?php
            $features=get_post_meta(get_the_ID(),'fetures',true);
            if(!empty($features)):?>
                <?php
                echo '<ul class="booking-item-features booking-item-features-rentals booking-item-features-sign clearfix mt5 mb5">';
                foreach($features as $key=>$value):
                    echo '<li rel="tooltip" data-placement="top" title="" data-original-title="'.$value['title'].'"><i class="'.TravelHelper::handle_icon($value['icon']).'"></i>';
                    if($value['number']){
                        echo '<span class="booking-item-feature-sign">x '.$value['number'].'</span>';
                    }

                    echo '</li>';
                endforeach;
                echo "</ul>";
                ?>
            <?php endif;?>
            <div>
                <?php if(!empty($is_sale)){ ?>
                    <span class="text-small lh1em  onsale">
                                    <?php echo TravelHelper::format_money( $price )?>
                                </span>
                    <i class="fa fa-long-arrow-right"></i>
                <?php } ?>
                <?php
                if(!empty($price)){
                    echo '<span class="text-darken mb0 text-color">'.TravelHelper::format_money($price_sale).'<small> /'.__('night',ST_TEXTDOMAIN).'</small></span>';
                }
                ?>
            </div>
        </div>
    </div>
</div>