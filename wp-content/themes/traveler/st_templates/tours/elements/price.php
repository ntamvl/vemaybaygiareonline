<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours price
 *
 * Created by ShineTheme
 *
 */

$default=array(
    'align'=>'left'
);
if(isset($attr))
{
    extract(wp_parse_args($attr,$default));
}else{
    extract($default);
}

?>
<p class="booking-item-header-price text-<?php echo esc_attr($align) ?>"><small><?php st_the_language('tour_price_from')?></small>  <span class="text-lg"><?php echo TravelHelper::format_money(get_post_meta(get_the_ID(),'price',true)) ?></span>/<?php st_the_language('tour')?></p>
