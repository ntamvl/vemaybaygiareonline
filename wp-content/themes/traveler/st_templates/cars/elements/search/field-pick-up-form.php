<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars element search field pick up form
 *
 * Created by ShineTheme
 *
 */
$default=array(
    'title'=>''
);
if(isset($data)){
    extract(wp_parse_args($data,$default));
}else{
    extract($default);
}
?>
<div class="form-group form-group-lg form-group-icon-left">
    <i class="fa fa-map-marker input-icon input-icon-highlight"></i>
    <label><?php echo esc_html($title)?></label>
    <input name="pick-up" required="required" value="<?php echo STInput::get('pick-up') ?>" class="typeahead_location form-control" placeholder="<?php st_the_language('car_city_airport_or_us_zip_code')?>" type="text" />
    <input type="hidden" name="location_id_pick_up" value="<?php echo STInput::get('location_id_pick_up') ?>" class="location_id">
</div>