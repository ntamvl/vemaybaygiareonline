<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars element search field pick up date time
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

$title_date = 'Date';
$title_time ='Time';
$title = explode(',',$title);
if(!empty($title[0])){
    $title_date = $title[0] ;
}
if(!empty($title[1])){
    $title_time = $title[1] ;
}
$size=6;
if(!empty($st_direction)){
    if($st_direction!='horizontal'){
        $size='x';
    }
}else{
    $st_direction = 'horizontal';
}
?>
<div class="<?php  if($st_direction=='horizontal') echo 'row';?>">
    <div class="col-md-<?php echo esc_attr($size) ?>">
        <div class="form-group form-group-lg form-group-icon-left">
            <i class="fa fa-calendar input-icon input-icon-highlight"></i>
            <label><?php echo esc_html( $title_date)?></label>
            <input placeholder="<?php echo TravelHelper::get_js_date_format()?>"  class="form-control pick-up-date" name="pick-up-date" type="text" />
        </div>
    </div>
    <div class="col-md-<?php echo esc_attr($size) ?>">
        <div class="form-group form-group-lg form-group-icon-left">
            <i class="fa fa-clock-o input-icon input-icon-highlight"></i>
            <label><?php echo esc_html($title_time)?></label>
            <input name="pick-up-time" class="time-pick form-control" value="<?php _e('12:00 PM',ST_TEXTDOMAIN)?>" type="text" />
        </div>
    </div>
</div>


