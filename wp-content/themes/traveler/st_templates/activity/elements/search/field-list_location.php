<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Activity field list location
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
$list_location = TravelerObject::get_list_location();
?>
<?php if(!empty($list_location) and is_array($list_location)): ?>
<div class="form-group form-group-<?php echo esc_attr($field_size)?> form-group-icon-left">
    <i class="fa fa-map-marker input-icon"></i>
    <label><?php echo esc_html( $title)?></label>
   <select name="location_id" class="form-control">
       <?php foreach($list_location as $k=>$v): ?>
            <option <?php if($old_location == $v['id'] ) echo 'selected' ?> value="<?php echo esc_html($v['id']) ?>">
                <?php echo esc_html($v['title']) ?>
            </option>
       <?php endforeach; ?>
   </select>
</div>
<?php endif ?>