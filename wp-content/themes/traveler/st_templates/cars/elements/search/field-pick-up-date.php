<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars element search field pick up date
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
<div data-date-format="<?php echo TravelHelper::get_js_date_format()?>" class="form-group form-group-lg form-group-icon-left">
    <i class="fa fa-calendar input-icon input-icon-highlight"></i>
    <label><?php echo esc_html($title)?></label>
    <input placeholder="<?php echo TravelHelper::get_js_date_format()?>" required="required" value="<?php echo STInput::request('pick-up-date') ?>" class="form-control pick-up-date" name="pick-up-date" type="text" />
</div>