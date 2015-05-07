<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * hotel share
 *
 * Created by ShineTheme
 *
 */
$st_style_search="style_2";
$hotel=new STHotel();
$fields=$hotel->get_search_fields();
?>
<h3><?php st_the_language('search_for_hotel')?></h3>
<form role="search" method="get" class="search" action="<?php echo home_url( '/' ); ?>">
    <input type="hidden" name="post_type" value="st_hotel">
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
                    if($value['layout2_col'])
                    {
                        $size=$value['layout2_col'];
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

    <?php if(st()->get_option('hotel_allow_search_advance')=='on'):?>
        <!--Search Advande-->
        <div class="search_advance">
            <div class="view_more_content_box">
                <div class="row">

                    <?php

                    $fields=$hotel->get_search_adv_fields();
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
                                if($value['layout2_col'])
                                {
                                    $size=$value['layout2_col'];
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
                <span class="expand_search_box-more"><?php st_the_language('advance_search')?> <i class="fa fa-angle-down"></i></span>
                <span class="expand_search_box-less"><?php st_the_language('less')?> <i class="fa fa-angle-up"></i></span>
            </div>
        </div>
        <!--End search Advance-->
    <?php endif;?>

    <button class="btn btn-primary btn-lg" type="submit"><?php st_the_language('search_for_hotel')?></button>
</form>
