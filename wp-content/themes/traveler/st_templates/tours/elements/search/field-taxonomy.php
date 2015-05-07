<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tour field taxonomy
 *
 * Created by ShineTheme
 *
 */
$default=array(
    'title'=>'',
    'taxonomy'=>''
);

if(isset($data)){
    extract(wp_parse_args($data,$default));
}else{
    extract($default);
}

if(!isset($field_size)) $field_size='lg';

$terms = get_terms($taxonomy);


if(!empty($terms)):
?>
<div class="form-group form-group-<?php echo esc_attr($field_size)?>" taxonomy="<?php echo esc_html($taxonomy) ?>">
    <label><?php echo esc_html( $title)?></label>
    <select class="form-control" name="taxonomy[<?php echo esc_html($taxonomy) ?>]">
        <?php if(is_array($terms)){ ?>
            <?php foreach($terms as $k=>$v){ ?>
                <?php $is_taxonomy = STInput::request('taxonomy'); ?>
                <option <?php if(!empty($is_taxonomy[$taxonomy]) and $is_taxonomy[$taxonomy] == $v->term_id) echo 'selected'; ?>  value="<?php echo esc_attr($v->term_id) ?>">
                    <?php echo esc_html($v->name) ?>
                </option>
            <?php } ?>
        <?php } ?>
    </select>
</div>
<?php endif ?>
