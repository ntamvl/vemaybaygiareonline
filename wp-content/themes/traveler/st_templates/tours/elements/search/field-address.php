<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours field address
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
$old_location=STInput::get('location_id');
?>
<div class="form-group form-group-lg form-group-icon-left">
    <i class="fa fa-map-marker input-icon input-icon-highlight"></i>
    <label><?php echo esc_html($title)?></label>
    <input name="s" required="required" value="<?php if($old_location and $title=get_the_title($old_location)) echo esc_html( $title); else echo get_search_query() ?>" class="typeahead_location form-control" placeholder="<?php st_the_language('tours_or_us_zip_Code')?>" type="text" />
    <input type="hidden"  name="location_id" value="<?php echo STInput::get('location_id') ?>" class="location_id">
</div>