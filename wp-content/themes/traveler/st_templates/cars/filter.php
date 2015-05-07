<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars filter
 *
 * Created by ShineTheme
 *
 */
if(!isset($instance)) $instance=array();
$default=array(
    'title'=>st_get_language('car_filter_by').':',
    'st_search_fields'=>'',
    'st_style'=>''
);

extract(wp_parse_args($instance,$default));

$all_fields=json_decode($st_search_fields);

if($st_style =='dark' ){
    $class_side_bar = 'booking-filters text-white cars-filters';
}else{
    $class_side_bar = 'booking-filters booking-filters-white';
}
?>
<aside class="<?php echo esc_attr($class_side_bar) ?> <?php if($st_style=='dark') echo 'text-white'; else echo 'booking-filters-white';?>">
    <h3><?php echo esc_html($title)?></h3>
    <ul class="list booking-filters-list">
        <?php foreach($all_fields as $k=>$v): ?>
            <?php if($v->field == 'taxonomy'){ ?>
                <li>
                    <h5 class="booking-filters-title"><?php echo esc_html($v->title) ?></h5>
                    <?php
                    $all_attribute=get_terms($v->taxonomy);
                    foreach($all_attribute as $k_2=>$v_2){
                        if( !empty($_REQUEST['filter_taxonomy'][$v_2->taxonomy][$v_2->slug]) and $_REQUEST['filter_taxonomy'][$v_2->taxonomy][$v_2->slug] == $v_2->term_id )
                        {
                            $checked = 'checked="checked"';
                            $link=TravelHelper::build_url_muti_array('filter_taxonomy',$v_2->taxonomy,$v_2->slug,'');
                        }else{
                            $checked="";
                            $link=TravelHelper::build_url_muti_array('filter_taxonomy',$v_2->taxonomy,$v_2->slug,$v_2->term_id);
                        }
                    ?>
                    <div class="checkbox">
                        <label>
                            <input <?php echo esc_attr($checked); ?> class="i-check" type="checkbox" data-url="<?php echo esc_url($link) ?>" />
                            <?php echo esc_html($v_2->name) ?>
                           <!-- ( <?php /*echo esc_html($v_2->count) */?> )-->
                        </label>
                    </div>
                    <?php } ?>
                </li>
            <?php }; ?>
            <?php if($v->field == 'price'){ ?>
                <li>
                    <h5 class="booking-filters-title"><?php st_the_language('car_price') ?></h5>
                    <?php  echo st()->load_template('cars/filter_price'); ?>
                </li>
            <?php }; ?>
        <?php endforeach; ?>
    </ul>
</aside>
<script>
    jQuery(document).ready(function($){
        $('.cars-filters input[type=checkbox]').on('ifClicked', function(event){
            var url=$(this).attr('data-url');
            if(url){
                window.location.href=url;
            }
        });
    });
</script>