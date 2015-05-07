<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours field check out
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
<div data-date-format="<?php echo TravelHelper::get_js_date_format()?>" class="form-group input-daterange form-group-<?php echo esc_attr($field_size) ?> form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
    <label><?php echo esc_html( $title)?></label>

    <input class="form-control" required="required" name="end" type="text" value="<?php echo STInput::get('end') ?>"  placeholder="<?php echo TravelHelper::get_js_date_format()?>" />
</div>