<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours field duration
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
    <i class="fa fa-calendar input-icon input-icon-highlight"></i>
    <label><?php echo esc_html($title)?></label>
    <input name="duration" value="<?php echo STInput::get('duration') ?>" class="typeahead_location form-control" placeholder="<?php st_the_language('tour_duration')?>" type="text" />
</div>