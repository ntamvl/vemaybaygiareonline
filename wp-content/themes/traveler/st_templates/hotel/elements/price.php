<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Hotel price
 *
 * Created by ShineTheme
 *
 */

$default=array(
    'align'=>'right'
);
if(isset($attr))
{
    extract(wp_parse_args($attr,$default));
}else{
    extract($default);
}

$min_price=STHotel::get_min_price();

?>
<p class="booking-item-header-price text-<?php echo esc_html($align) ?>"><small><?php st_the_language('price_from')?></small>  <span class="text-lg"><?php echo TravelHelper::format_money($min_price) ?></span>/<?php st_the_language('night')?></p>
