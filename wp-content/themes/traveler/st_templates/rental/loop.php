<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental loop
 *
 * Created by ShineTheme
 *
 */

if(!isset($style)) $style='list';

if($style=='list') {
    if (have_posts()) {
        echo '<ul class="booking-list loop-hotel style_list">';
        while (have_posts()) {
            the_post();
            $hotel = new STHotel(get_the_ID());
            $object= new STRental();
            $custom_feild=$object->get_custom_fields();
            $link=st_get_link_with_search(get_permalink(),array('start','end','room_num_search','adult_num'),$_GET);
            $thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
            ?>
            <li <?php post_class('booking-item') ?>>
                <?php echo STFeatured::get_featured(); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="booking-item-img-wrap st-popup-gallery">
                                <a href="<?php echo esc_url($thumb_url)?>" class="st-gp-item">
                                    <?php the_post_thumbnail(array(360, 270, 'bfi_thumb' => true)) ?>
                                </a>
                                <?php
                                $count = 0;
                                $gallery = get_post_meta(get_the_ID(), 'gallery', true);
                                $gallery = explode(',', $gallery);
                                if (!empty($gallery) and $gallery[0]) {
                                    $count += count($gallery);
                                }
                                if(has_post_thumbnail()){
                                    $count++;
                                }
                                if ($count) {
                                    echo '<div class="booking-item-img-num"><i class="fa fa-picture-o"></i>';
                                    echo esc_attr($count);
                                    echo '</div>';
                                }
                                ?>
                                <div class="hidden">
                                    <?php if (!empty($gallery) and $gallery[0]) {
                                        $count += count($gallery);
                                        foreach($gallery as $key=>$value)
                                        {
                                            $img_link=wp_get_attachment_image_src($value,array(800,600,'bfi_thumb'=>true));
                                            if(isset($img_link[0]))
                                                echo "<a class='st-gp-item' href='{$img_link[0]}'></a>";
                                        }

                                    }?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="booking-item-rating">
                                <ul class="icon-group booking-item-rating-stars">
                                    <?php
                                    $avg = STReview::get_avg_rate();
                                    echo TravelHelper::rate_to_string($avg);
                                    ?>
                                </ul>
                                <span
                                    class="booking-item-rating-number"><b><?php echo esc_html($avg) ?></b> <?php st_the_language('rental_of_5') ?></span>
                                <small>
                                    (<?php comments_number(st_get_language('rental_no_review'), st_get_language('rental_1_review'),st_get_language('rental_d_reviews')); ?>)
                                </small>
                            </div>
                            <h5 class="booking-item-title"><a class="color-inherit" href="<?php echo esc_url($link) ?>"><?php the_title() ?></a></h5>
                            <?php if ($address = get_post_meta(get_the_ID(), 'address', true)): ?>
                                <p class="booking-item-address"><i class="fa fa-map-marker"></i> <?php echo esc_html($address) ?>
                                </p>
                            <?php endif; ?>

                            <?php

                            if(!empty($custom_feild) and is_array($custom_feild)):?>
                                <?php
                                echo '<ul class="booking-item-features booking-item-features-rentals booking-item-features-sign clearfix mt5 mb5">';
                                foreach($custom_feild as $key=>$value):
                                    if($value['show_in_list']=='on'):
                                        echo '<li rel="tooltip" data-placement="top" title="" data-original-title="'.$value['title'].'"><i class="'.TravelHelper::handle_icon($value['icon']).'"></i>';
                                        $field_name=isset($value['field_name'])?$value['field_name']:'pro_'.sanitize_key($value['title']);
                                        $meta=get_post_meta(get_the_ID(),$field_name,true);
                                        if($meta){
                                            echo '<span class="booking-item-feature-sign">x '.$meta.'</span>';
                                        }
                                    endif;

                                    echo '</li>';
                                endforeach;
                                echo "</ul>";
                                ?>
                            <?php endif;?>

                        </div>
                        <?php
                        $is_sale=STRental::is_sale();
                        $orgin_price=STRental::get_orgin_price();
                        $price=STRental::get_price();
                        ?>
                        <div class="col-md-3">
                             <?php
                             if($is_sale):

                                 echo "<span class='booking-item-old-price'>".TravelHelper::format_money($orgin_price)."</span>";
                             endif;
                             ?>
                             <span class="booking-item-price"><?php echo TravelHelper::format_money($price) ?></span>
                             <span>/<?php st_the_language('rental_night')?></span>
                             <a href="<?php echo esc_url($link)?>" class="btn btn-primary btn_book "><?php st_the_language('rental_book_now') ?></a>
                        </div>
                    </div>
            </li>
        <?php
        }

        echo "</ul>";

    }

}else{
    ?>
        <div class="row row-wrap st_fix_clear style_box">

            <?php
                while(have_posts()){
                    the_post();
                    $link=st_get_link_with_search(get_permalink(),array('start','end','room_num_search','adult_num'),$_GET);
                    $thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                    ?>
                    <div class="col-md-4">
                        <?php echo STFeatured::get_featured(); ?>
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img" href="<?php echo esc_url($link)?>">
                                    <?php the_post_thumbnail(array(360, 270, 'bfi_thumb' => true)) ?>
                                    <h5 class="hover-title-center"><?php st_the_language('rental_book_now')?> </h5>
                                </a>
                            </header>
                            <div class="thumb-caption">
                                <ul class="icon-group text-tiny text-color">
                                    <?php
                                    $avg = STReview::get_avg_rate();
                                    echo TravelHelper::rate_to_string($avg);
                                    ?>
                                </ul>
                                <h5 class="thumb-title"><a class="text-darken" href="<?php echo esc_url($link)?>"><?php the_title()?></a></h5>
                            <?php if ($address = get_post_meta(get_the_ID(), 'address', true)): ?>
                                <p class="mb0"><small> <?php echo esc_html($address) ?></small>
                                </p>
                            <?php endif;?>
                                <?php
                                $is_sale=STRental::is_sale();
                                $orgin_price=STRental::get_orgin_price();
                                $price=STRental::get_price();
                                ?>
                                <?php
                                $features=get_post_meta(get_the_ID(),'fetures',true);
                                if(!empty($features)):?>
                                    <?php
                                        echo '<ul class="booking-item-features booking-item-features-rentals booking-item-features-sign clearfix mt5 mb5">';
                                        foreach($features as $key=>$value):

                                            $d=array('icon'=>'','title'=>'');
                                            $value=wp_parse_args($value,$d);

                                            echo '<li rel="tooltip" data-placement="top" title="" data-original-title="'.$value['title'].'"><i class="'.TravelHelper::handle_icon($value['icon']).'"></i>';
                                            if($value['number']){
                                                echo '<span class="booking-item-feature-sign">x '.$value['number'].'</span>';
                                            }

                                            echo '</li>';
                                        endforeach;
                                        echo "</ul>";
                                    ?>
                                <?php endif;?>

                                <p class="mb0 text-darken">
                                    <?php
                                    if($is_sale):

                                        echo "<span class='booking-item-old-price'>".TravelHelper::format_money($orgin_price)."</span>";
                                    endif;
                                    ?>
                                    <span class="text-lg lh1em text-color"><?php echo TravelHelper::format_money($price) ?></span><small> /<?php st_the_language('rental_night')?></small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    <?php
}