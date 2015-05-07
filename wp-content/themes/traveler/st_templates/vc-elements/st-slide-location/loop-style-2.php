<?php
$thumbnail=get_post_thumbnail_id();
$img=wp_get_attachment_url($thumbnail);
if(empty($img)){
    $img = get_template_directory_uri().'/img/no-image.png';
}
$class_bg_img = Assets::build_css(" background: url(".$img.") ");
$logo = get_post_meta( get_the_ID() , 'st_logo_location' , true);

$c=TravelHelper::get_location_temp();
?>
<div class="bg-holder full">
    <div class="bg-mask"></div>
    <div class="bg-blur <?php echo esc_attr($class_bg_img) ?>" ></div>
    <div class="bg-content">
        <div class="container">
            <div class="loc-info text-right hidden-xs hidden-sm">
                <h3 class="loc-info-title">
                    <?php if(!empty($logo)){ ?>
                       <img src="<?php echo balanceTags($logo) ?>" alt="Logo" title="Image Title" />
                    <?php } ?>
                    <?php the_title() ?>
                </h3>
                <?php if($st_weather == 'yes'){ ?>
                <p class="loc-info-weather">
                    <span class="loc-info-weather-num"><?php echo esc_html($c['temp']); ?></span>
                    <?php echo balanceTags($c['icon']) ?>
                </p>
                <?php } ?>
                <ul class="loc-info-list">
                    <?php
                    $min_price = get_post_meta(get_the_ID() , 'min_price_hotel' , true );
                    $min_price = TravelHelper::format_money($min_price);
                    $offer = get_post_meta(get_the_ID() , 'offer_hotel' , true );
                    if(!empty($min_price) and !empty($offer)){
                        echo '<li><a href="'.home_url('?s=&amp;post_type=st_hotel&amp;location_id='.get_the_ID()).'"><i class="fa fa-building-o"></i> '.$offer.' '.STLanguage::st_get_language('hotels_from').' '.$min_price.'/'.STLanguage::st_get_language('night').'</a></li>';
                    }

                    $min_price = get_post_meta(get_the_ID() , 'min_price_rental' , true );
                    $min_price = TravelHelper::format_money($min_price);
                    $offer = get_post_meta(get_the_ID() , 'offer_rental' , true );
                    if(!empty($min_price) and !empty($offer)){
                        echo '<li><a href="'.home_url('?s=&amp;post_type=st_rental&amp;location_id='.get_the_ID()).'"><i class="fa fa-home"></i> '.$offer.' '.STLanguage::st_get_language('rentals_from').' '.$min_price.'/'.STLanguage::st_get_language('night').'</a></li>';
                    }

                    $min_price = get_post_meta(get_the_ID() , 'min_price_cars' , true );
                    $min_price = TravelHelper::format_money($min_price);
                    $offer = get_post_meta(get_the_ID() , 'offer_cars' , true );
                    if(!empty($min_price) and !empty($offer)){
                        echo '<li><a href="'.home_url('?s=&amp;post_type=st_cars&amp;location_id='.get_the_ID()).'"><i class="fa fa-car"></i> '.$offer.' '.STLanguage::st_get_language('cars_from').' '.$min_price.'/'.STLanguage::st_get_language('day').'</a></li>';
                    }

                    $min_price = get_post_meta(get_the_ID() , 'min_price_tours' , true );
                    $min_price = TravelHelper::format_money($min_price);
                    $offer = get_post_meta(get_the_ID() , 'offer_tours' , true );
                    if(!empty($min_price) and !empty($offer)){
                        echo '<li><a href="'.home_url('?s=&amp;post_type=st_tours&amp;location_id='.get_the_ID()).'"><i class="fa fa-bolt"></i> '.$offer.' '.STLanguage::st_get_language('tours_from').' '.$min_price.'/'.STLanguage::st_get_language('day').'</a></li>';
                    }

                    $min_price = get_post_meta(get_the_ID() , 'min_price_activity' , true );
                    $min_price = TravelHelper::format_money($min_price);
                    if(!empty($min_price)){
                        echo '<li><a href="'.home_url('?s=&amp;post_type=st_activity&amp;location_id='.get_the_ID()).'"><i class="fa fa-bolt"></i> '.$offer.' '.STLanguage::st_get_language('activities_this_week').'</a></li>';
                    }
                    ?>
                </ul>
                <a class="btn btn-white btn-ghost mt10" href="<?php echo home_url('?s=&amp;post_type='.$st_type.'&amp;location_id='.get_the_ID()) ?>">
                    <i class="fa fa-angle-right"></i>
                    <?php STLanguage::st_the_language('explore'); ?>
                </a>
            </div>
        </div>
    </div>
</div>