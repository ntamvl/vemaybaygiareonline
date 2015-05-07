<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User loop wishlist
 *
 * Created by ShineTheme
 *
 */
$price_type ="";
switch($data['type']){
    case 'st_hotel':
        $icon_type='<i class="fa fa-building-o"></i>';
        $price_type = st_get_language("night");
        $price = get_post_meta($data['id'],'min_price',true);
        $count_sale = get_post_meta($data['id'],'discount',true);
        if(!empty($count_sale)){
            $x = $price;
            $price_sale = $price - $price * ( $count_sale / 100 );
            $price = $price_sale;
            $price_sale = $x;
        }
        break;
    case 'st_rental':
        $icon_type='<i class="fa fa-home"></i>';
        $price_type = st_get_language("night");
        $price = get_post_meta($data['id'],'price',true);
        $count_sale = get_post_meta($data['id'],'discount',true);
        if(!empty($count_sale)){
            $x = $price;
            $price_sale = $price - $price * ( $count_sale / 100 );
            $price = $price_sale;
            $price_sale = $x;
        }
        break;
    case 'st_activity':
        $icon_type='<i class="fa fa-bolt"></i>';
        $price_type = st_get_language("activity");
        $price = get_post_meta($data['id'],'price',true);
        $count_sale = get_post_meta($data['id'],'discount',true);
        if(!empty($count_sale)){
            $x = $price;
            $price_sale = $price - $price * ( $count_sale / 100 );
            $price = $price_sale;
            $price_sale = $x;
        }
        break;
    case 'st_tours':
        $icon_type='<i class="fa fa-bolt"></i>';
        $price_type = st_get_language("tour");
        $price = get_post_meta($data['id'],'price',true);
        $count_sale = get_post_meta($data['id'],'discount',true);
        if(!empty($count_sale)){
            $x = $price;
            $price_sale = $price - $price * ( $count_sale / 100 );
            $price = $price_sale;
            $price_sale = $x;
        }
        break;
    case 'st_cars':
        $icon_type='<i class="fa fa-car"></i>';
        $price_type = st_get_language('user_person');
        $price = get_post_meta($data['id'],'cars_price',true);
        $count_sale = get_post_meta($data['id'],'discount',true);
        if(!empty($count_sale)){
            $x = $price;
            $price_sale = $price - $price * ( $count_sale / 100 );
            $price = $price_sale;
            $price_sale = $x;
        }
        break;
    case 'cruise':
        $icon_type='<i class="fa fa-bolt"></i>';
        $price_type =  st_get_language("night");
        $price = get_post_meta($data['id'],'price',true);
        $count_sale = get_post_meta($data['id'],'discount',true);
        if(!empty($count_sale)){
            $x = $price;
            $price_sale = $price - $price * ( $count_sale / 100 );
            $price = $price_sale;
            $price_sale = $x;
        }
        break;
}
?>
    <?php
    while(have_posts()){
        the_post();
        ?>
        <li <?php  post_class() ?>>
            <span class="booking-item-wishlist-title">
                <?php echo balanceTags($icon_type) ?>
                <?php echo esc_html(mb_convert_case(str_ireplace("st_","",$data['type']), MB_CASE_TITLE, "UTF-8")) ?>
                <span><?php st_the_language("added_on") ?> <?php echo esc_html($data['date']) ?></span>
            </span>
            <a data-id="<?php the_ID() ?>" data-type="<?php echo get_post_type(get_the_ID()) ?>" data-placement="top" rel="tooltip"  class="btn_remove_wishlist cursor fa fa-times booking-item-wishlist-remove" data-original-title="<?php st_the_language('remove') ?>"></a>
            <div class="spinner user_img_loading ">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
            <a href="<?php the_permalink() ?>" class="booking-item">
                <div class="row">
                    <div class="col-md-3">
                        <?php
                        $img = get_the_post_thumbnail( get_the_ID() , array(800,600,'bfi_thumb'=>true)) ;
                        if(!empty($img)){
                            echo balanceTags($img);
                        }else{
                            echo '<img width="800" height="600" alt="no-image" class="wp-post-image" src="'.bfi_thumb(get_template_directory_uri().'/img/no-image.png',array('width'=>800,'height'=>600)) .'">';
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <div class="booking-item-rating">
                            <ul class="icon-group booking-item-rating-stars">
                                <?php echo  TravelHelper::rate_to_string(STReview::get_avg_rate()); ?>
                            </ul>
                            <span class="booking-item-rating-number">
                                <b><?php echo STReview::get_avg_rate() ?></b> <?php st_the_language('user_of_5') ?></span>
                            <small>
                                (<?php comments_number( st_get_language('user_no_reviews'), st_get_language('user_1_review'), '% '.st_get_language('user_reviews') );?>)
                            </small>
                        </div>
                        <h5 class="booking-item-title"><?php the_title() ?></h5>
                        <p class="booking-item-address">
                            <?php  $address =  get_post_meta(get_the_ID() ,'address' ,true);
                                   if(!empty($address)){
                                        echo '<i class="fa fa-map-marker"></i> '.$address;
                                   }
                            ?>
                        </p>
                        <p class="booking-item-description">
                            <?php echo st_get_the_excerpt_max_charlength(150); ?>
                        </p>
                    </div>

                    <div class="col-md-3">
                        <span class="booking-item-price-from"><?php st_the_language('user_from') ?></span>
                        <span class="booking-item-price">
                            <?php if(!empty($count_sale)){ ?>
                                <span class="text-lg lh1em sale_block onsale">
                                      <?php echo TravelHelper::format_money( $price_sale )?>
                                 </span>
                            <?php } ?>
                                    <?php echo TravelHelper::format_money($price) ?>
                        </span>
                        <span>/<?php echo esc_html(strtolower($price_type)) ?></span>
                        <span class="btn btn-primary"><?php st_the_language('user_book_now') ?></span>
                    </div>
                </div>
            </a>
        </li>
    <?php } ?>
