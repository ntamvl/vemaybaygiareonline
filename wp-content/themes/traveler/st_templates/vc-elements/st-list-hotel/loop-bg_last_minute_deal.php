<?php
while($query->have_posts()){
    $query->the_post();
    $info_room = $info_room[0];
    $price = STRental::get_price($info_room->ID);
    $price = TravelHelper::format_money($price);

    $date  = date('l d M',strtotime(get_post_meta($info_room->ID ,'sale_price_from' ,true)))." - ".date('l d M',strtotime(get_post_meta($info_room->ID ,'sale_price_to' ,true)));

    $txt =  '<div class="text-center text-white">
                        <h2 class="text-uc mb20">'.STLanguage::st_get_language('last_minute_deal').'</h2>
                        <ul class="icon-list list-inline-block mb0 last-minute-rating">
                            '.TravelHelper::rate_to_string(STReview::get_avg_rate()).'
                        </ul>
                        <h5 class="last-minute-title">'.get_the_title().' - '.$info_room->post_title.' </h5>

                        <p class="last-minute-date">'.$date.'</p>
                        <p class="mb20">
                             <b>'.$price.'</b> / '.STLanguage::st_get_language('night').'
                        </p>
                        <a href="'.get_the_permalink().'" class="btn btn-lg btn-white btn-ghost">
                           '.STLanguage::st_get_language('book_now').'<i class="fa fa-angle-right"></i>
                        </a>
                    </div>';
    echo balanceTags($txt);
}