<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Cars filter price
 *
 * Created by ShineTheme
 *
 */
?>
<form method="get" action="">
    <?php $get=STInput::get();
    if(!empty($get)){

        foreach($get as $key=>$value){

            if(is_array($value)){
                if(!empty($value)){
                    if(!empty($value) and is_array($value)){
                        foreach($value as $key2=>$value2){
                            if(!empty($value2) and is_array($value2)) {
                                foreach ($value2 as $key3 => $value3) {
                                    echo "<input  type='hidden' name='{$key}[{$key2}][{$key3}]' value='$value3' >";
                                }
                            }
                        }
                    }
                }
            }else{
                if($key!="price_range")
                echo "<input type='hidden' name='$key' value='$value' >";
            }
        }
    }
    $data_min_max = TravelerObject::get_min_max_price('st_cars');
    echo '<input type="text" name="price_range" value="'.STInput::get('price_range').'" class="price-slider" data-min="'.$data_min_max['price_min'].'" data-max="'.$data_min_max['price_max'].'" data-step="'.st()->get_option('search_price_range_step',0).'">';

    ?>
    <button style="margin-top: 4px;" type="submit" class="btn btn-primary"><?php st_the_language('car_filter')?></button>
</form>

