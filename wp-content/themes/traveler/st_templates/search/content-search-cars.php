<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Content search cars
 *
 * Created by ShineTheme
 *
 */
$cars=new STCars();
if($st_style_search=="style_1"){
    $fields=$cars->get_search_fields();
}else{
    $fields=$cars->get_search_fields_box();
}

?>

    <h2><?php echo esc_html($st_title_search) ?></h2>
    <form method="get" action="<?php echo home_url( '/' ); ?>">
        <input type="hidden" name="post_type" value="st_cars">
        <input type="hidden" name="s" value="">
        <div class="<?php  if($st_direction=='horizontal') echo 'row';?> input-daterange" data-date-format="<?php echo TravelHelper::get_js_date_format()?>">
            <?php
            if(!empty($fields)){
                foreach($fields as $key=>$value){
                    $name=$value['title'];
                    $size='4';
                    if($st_style_search=="style_1")
                    {
                        $size=$value['layout_col_normal'];
                    }else
                    {
                        $size=$value['layout_col_box'];
                    }

                    if($st_direction!='horizontal'){
                        $size='x';
                    }
                    ?>
                    <div class="col-md-<?php echo esc_attr($size); ?>">
                        <?php echo st()->load_template('cars/elements/search/field-'.$value['field_atrribute'],false,array('data'=>$value,'field_size'=>$size,'st_direction'=>$st_direction)) ?>
                    </div>
                <?php
                }
            }
            ?>
        </div>
        <button class="btn btn-primary btn-lg" type="submit"><?php st_the_language('search_for_cars') ?></button>
    </form>
