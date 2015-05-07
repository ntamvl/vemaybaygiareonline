<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars element search field drop off time
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
    <i class="fa fa-clock-o input-icon input-icon-highlight"></i>
    <label><?php echo esc_html( $title) ?></label>
    <input name="drop-off-time" class="time-pick form-control" value="<?php echo STInput::request('drop-off-time') ?>" type="text" />
</div>