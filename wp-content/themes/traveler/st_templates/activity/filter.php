<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Activity filter
 *
 * Created by ShineTheme
 *
 */
if(!isset($instance)) $instance=array();
$default=array(
    'title'=>st_get_language('Filter By').':',
    'st_search_fields'=>'',
    'st_style'         =>'dark'
);

extract(wp_parse_args($instance,$default));

$all_fields=json_decode($st_search_fields);
if($st_style =='dark' ){
    $class_side_bar = 'booking-filters text-white cars-filters';
}else{
    $class_side_bar = 'booking-filters booking-filters-white';
}
?>
<aside class="booking-filters <?php if($st_style=='dark') echo 'text-white'; else echo 'booking-filters-white';?> tours-filters">
    <h3><?php echo esc_html($title)?></h3>
    <ul class="list booking-filters-list">
        <?php
        if(!empty($all_fields)and is_array($all_fields)):
                foreach($all_fields as $key=>$value):
                    echo '<li>';
                        echo ' <h5 class="booking-filters-title">'.$value->title.'</h5>';
                        switch($value->field){
                            case "price":
                                echo st()->load_template('activity/filter_price');
                                break;
                            case "rate":
                                    $max_rate=5;
                                    for($i=$max_rate;$i>=1;$i--)
                                    {
                                        $checked=TravelHelper::checked_array(explode(',',STInput::get('star_rate')),$i);
                                        if($checked)
                                        {
                                            $link=TravelHelper::build_url_auto_key('star_rate',$i,false);
                                        }else{
                                            $link=TravelHelper::build_url_auto_key('star_rate',$i);
                                        }
                                        ?>
                                        <div class="checkbox">
                                            <label>
                                                <input <?php if($checked) echo 'checked'; ?> value="<?php echo esc_attr( $i)?>" name="star_rate" data-url="<?php echo esc_url($link) ?>" class="i-check" type="checkbox" />
                                    <ul class="icon-group search_rating_star">                                                        <?php $i_s='<li><i class="fa fa-star"></i></li>';
                                            for($k=1;$k<=$i;$k++){
                                                echo balanceTags($i_s);
                                            }
                                                    ?>
                                        <?php /*$count=STHotel::count_meta_key('rate_review',$i,'st_activity');
                                        echo "&nbsp;({$count})";*/?>
                                   </ul>
                                                 </label>
                                        </div>
                                    <?php
                                    }
                                break;
                            case "taxonomy":
                                $terms=get_terms($value->taxonomy);
                                $key=$value->taxonomy;
                                foreach($terms as $key2=>$value2){

                                    $current=STInput::get('taxonomy');

                                    if(isset($current[$key])) $current=$current[$value->taxonomy];
                                    else $current='';

                                    $checked=TravelHelper::checked_array(explode(',',$current),$value2->term_id);

                                    if($checked)
                                    {
                                        $link=TravelHelper::build_url_array('taxonomy',$value->taxonomy,$value2->term_id,false);
                                    }else{
                                        $link=TravelHelper::build_url_array('taxonomy',$value->taxonomy,$value2->term_id);
                                    }

                                    ?>
                                    <div class="checkbox">
                                        <label>
                                            <input <?php if($checked) echo "checked" ?> value="<?php echo esc_attr( $value2->term_id)?>" name="star_rate" data-url="<?php echo esc_url($link) ?>" class="i-check" type="checkbox" /><?php echo esc_html( $value2->name)?> <!--(--><?php // echo  esc_html( $value2->count) ?><!--)--></label>
                                    </div>
                                <?php
                                }
                                break;
                        }
                    echo "</li>";
                endforeach;
            endif;
        ?>

    </ul>
</aside>
<script>
    jQuery(document).ready(function($){
        $('.tours-filters input[type=checkbox]').on('ifClicked', function(event){
            var url=$(this).data('url');
            if(url){
                window.location.href=url;
            }
        });
    });
</script>