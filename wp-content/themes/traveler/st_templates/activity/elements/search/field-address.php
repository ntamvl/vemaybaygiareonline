<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Activity element search address
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
if(!isset($field_size)) $field_size='lg';
?>
<div class="form-group form-group-<?php echo esc_attr($field_size)?> form-group-icon-left">
    <i class="fa fa-map-marker input-icon input-icon-highlight"></i>
    <label><?php echo balanceTags( $title)?></label>
    <input name="s" required="required" value="<?php echo STInput::get('s') ?>" class="typeahead_location form-control" placeholder="<?php st_the_language('activity_or_us_zip_code')?>" type="text" />
    <input type="hidden"  name="location_id" value="<?php echo STInput::get('location_id') ?>" class="location_id">
</div>