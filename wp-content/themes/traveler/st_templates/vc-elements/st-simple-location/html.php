<?php  $c=TravelHelper::get_location_temp();
?>
<div class="loc-info text-right hidden-xs hidden-sm">
    <h3 class="loc-info-title"><?php the_title() ?></h3>
    <p class="loc-info-weather">
       <span class="loc-info-weather-num">
       <?php echo balanceTags($c['temp']) ?>
       </span>
       <?php echo balanceTags($c['icon']) ?>
    </p>
    <ul class="loc-info-list">
        <?php
            $min_price = get_post_meta(get_the_ID() , 'min_price_hotel' , true );
            $min_price = TravelHelper::format_money($min_price);
            $offer = get_post_meta(get_the_ID() , 'offer_hotel' , true );
            if(!empty($min_price) and !empty($offer)){
                echo '<li><a href="'.home_url(esc_url('?s=&post_type=st_hotel&location_id='.get_the_ID())).'"><i class="fa fa-building-o"></i> '.$offer.' '.STLanguage::st_get_language('hotels_from').' '.$min_price.'/'.STLanguage::st_get_language('night').'</a></li>';
            }

            $min_price = get_post_meta(get_the_ID() , 'min_price_rental' , true );
            $min_price = TravelHelper::format_money($min_price);
            $offer = get_post_meta(get_the_ID() , 'offer_rental' , true );
            if(!empty($min_price) and !empty($offer)){
                echo '<li><a href="'.home_url(esc_url('?s=&post_type=st_rental&location_id='.get_the_ID())).'"><i class="fa fa-home"></i> '.$offer.' '.STLanguage::st_get_language('rentals_from').' '.$min_price.'/'.STLanguage::st_get_language('night').'</a></li>';
            }

            $min_price = get_post_meta(get_the_ID() , 'min_price_st_cars' , true );
            $min_price = TravelHelper::format_money($min_price);
            $offer = get_post_meta(get_the_ID() , 'offer_st_cars' , true );
            if(!empty($min_price) and !empty($offer)){
                echo '<li><a href="'.home_url(esc_url('?s=&post_type=st_cars&location_id='.get_the_ID())).'"><i class="fa fa-car"></i> '.$offer.' '.STLanguage::st_get_language('cars_from').' '.$min_price.'/'.STLanguage::st_get_language('day').'</a></li>';
            }

            $min_price = get_post_meta(get_the_ID() , 'min_price_st_tours' , true );
            $min_price = TravelHelper::format_money($min_price);
            $offer = get_post_meta(get_the_ID() , 'offer_st_tours' , true );
            if(!empty($min_price) and !empty($offer)){
                echo '<li><a href="'.home_url(esc_url('?s=&post_type=st_tours&location_id='.get_the_ID())).'"><i class="fa fa-bolt"></i> '.$offer.' '.STLanguage::st_get_language('tours_from').' '.$min_price.'/'.STLanguage::st_get_language('day').'</a></li>';
            }

            $min_price = get_post_meta(get_the_ID() , 'min_price_st_activity' , true );
            $min_price = TravelHelper::format_money($min_price);
            $offer = get_post_meta(get_the_ID() , 'offer_st_activity' , true );
            if(!empty($offer)){
                echo '<li><a href="'.home_url(esc_url('?s=&post_type=st_activity&location_id='.get_the_ID())).'"><i class="fa fa-bolt"></i> '.$offer.' '.STLanguage::st_get_language('activities_this_week').'</a></li>';
            }
        ?>
    </ul>
    <a class="btn btn-white btn-ghost mt10" href="<?php echo home_url(esc_url('?s=&post_type='.$st_type.'&location_id='.get_the_ID())) ?>">
        <i class="fa fa-angle-right"></i>
        <?php echo STLanguage::st_get_language('explore') ?>
    </a>
</div>