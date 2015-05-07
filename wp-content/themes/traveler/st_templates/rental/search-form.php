<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental search form
 *
 * Created by ShineTheme
 *
 */
$st_style_search="style_2";
$object=new STRental();
$fields=$object->get_search_fields();
?>
<h3><?php st_the_language('rental_search_for_vacation_rentals')?></h3>
<form role="search" method="get" class="search" action="<?php echo home_url( '/' ); ?>">
    <input type="hidden" name="post_type" value="st_rental">
    <input type="hidden" name="layout" value="<?php echo STInput::get('layout') ?>">
    <div class="row">
        <?php
        if(!empty($fields))
        {
            foreach($fields as $key=>$value)
            {
                $name=$value['name'];
                $size='4';
                if($st_style_search=="style_1")
                {
                    $size=$value['layout_col'];
                }else
                {
                    if($value['layout_col2'])
                    {
                        $size=$value['layout_col2'];
                    }
                }
                ?>
                <div class="col-md-<?php echo esc_attr($size);
                ?>">
                    <?php echo st()->load_template('hotel/elements/search/field_'.$name,false,array('data'=>$value)) ?>
                </div>
            <?php
            }
        }?>
    </div>
    <?php if(st()->get_option('rental_allow_search_advance')=='on'):?>
        <!--Search Advande-->
        <div class="search_advance">
            <div class="view_more_content_box">
                <div class="row">

                    <?php

                    $fields=$object->get_search_adv_fields();
                    if(!empty($fields))
                    {
                        foreach($fields as $key=>$value)
                        {
                            $name=$value['name'];
                            $size='4';
                            if($st_style_search=="style_1")
                            {
                                $size=$value['layout_col'];
                            }else
                            {
                                if($value['layout_col2'])
                                {
                                    $size=$value['layout_col2'];
                                }
                            }
                            ?>
                            <div class="col-md-<?php echo esc_attr($size);
                            ?>">
                                <?php echo st()->load_template('hotel/elements/search/field_'.$name,false,array('data'=>$value)) ?>
                            </div>
                        <?php
                        }
                    }?>
                </div>
            </div>
            <div class="expand_search_box">
                <span class="expand_search_box-more"><?php st_the_language('rental_advance_search')?> <i class="fa fa-angle-down"></i></span>
                <span class="expand_search_box-less"><?php st_the_language('rental_less')?> <i class="fa fa-angle-up"></i></span>
            </div>
        </div>
        <!--End search Advance-->
    <?php endif;?>
    <button class="btn btn-primary btn-lg" type="submit"><?php st_the_language('search_for_rental')?></button>
</form>
