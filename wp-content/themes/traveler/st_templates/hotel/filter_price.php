<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * hotel filter price
 *
 * Created by ShineTheme
 *
 */

$prices=STHotel::get_price_slider();
if(isset($prices['min']) and $prices['min'])
{
    $min=$prices['min'];
}else
{
    $min=0;
}
if(isset($prices['max']) and $prices['max'])
{
    $max=$prices['max'];
}else{
    $max=0;
}
?>
<form method="get" action="">
    <?php $get=STInput::get();
    if(!empty($get)){
        foreach($get as $key=>$value){

            if(is_array($value)){
                if(!empty($value)){
                    foreach($value as $key2=>$value2){

                        echo "<input  type='hidden' name='{$key}[{$key2}]' value='$value2' >";
                    }
                }
            }else{
                if($key!="price_range")
                echo "<input type='hidden' name='$key' value='$value' >";
            }
        }
    }
    echo '<input type="text" name="price_range" value="'.STInput::get('price_range').'" class="price-slider" data-min="'.esc_attr($min).'" data-max="'.esc_attr($max).'" data-step="'.st()->get_option('search_price_range_step',0).'">';

    ?>
    <button style="margin-top: 4px;" type="submit" class="btn btn-primary"><?php st_the_language('filter')?></button>
</form>

