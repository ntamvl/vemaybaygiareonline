<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Hotel field location
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

$old_location=STInput::get('location_id');

?>
<div class="form-group form-group-<?php echo esc_attr($field_size)?> form-group-icon-left">
    <i class="fa fa-map-marker input-icon"></i>
    <label><?php echo esc_html( $title)?></label>
    <input required="required" name="s" value="<?php if($old_location and $title=get_the_title($old_location)) echo esc_html( $title); else echo get_search_query() ?>" class="typeahead_location form-control" placeholder="<?php st_the_language('city_name_or_zip_code')?>" type="text" />
    <input  type="hidden" name="location_id" value="<?php echo STInput::get('location_id') ?>" class="location_id">
</div>