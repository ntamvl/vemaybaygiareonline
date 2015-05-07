<?php
extract($data);
$col = 12/$st_cars_of_row;

$info_price = STCars::get_info_price();
$price = $info_price['price'];
$count_sale = $info_price['discount'];
if(!empty($count_sale)){
    $price = $info_price['price'];
    $price_sale = $info_price['price_old'];
}
?>
<?php $category = get_the_terms(get_the_ID() ,'st_category_cars') ?>
<div class="col-md-<?php echo esc_attr($col); ?> col-sm-6 st_fix_<?php echo esc_attr($st_cars_of_row); ?>_col style_box">
    <?php echo STFeatured::get_featured(); ?>
    <div class="thumb">
        <header class="thumb-header">
            <?php if(!empty($count_sale)){ ?>
                <span class="box_sale btn-primary"> <?php echo esc_html($count_sale) ?>% </span>
            <?php } ?>
            <a href="<?php the_permalink() ?>" class="hover-img"  style="overflow: initial;">
                <?php
                if(has_post_thumbnail()){
                    the_post_thumbnail(array(800,400,'bfi_thumb' => true ));
                }else{
                    st_get_default_image();
                }
                ?>
            </a>
        </header>
        <div class="thumb-caption">
            <h5 class="thumb-title">
                <a class="text-darken" href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
            <small>
               <?php
               $txt ='';
                   if(!is_wp_error($category) and !empty($category) and is_array($category))
                   {
                       foreach($category as $k=>$v){
                           $txt .= $v->name.' ,';
                       }
                       $txt = substr($txt,0,-1);
                       echo esc_html($txt);
                   }

               ?>
            </small>
            <?php echo st()->load_template('vc-elements/st-list-cars/attribute',null,array('attr'=>$attr));
            ?>
            <div>
                <?php if(!empty($count_sale)){ ?>
                    <span class="text-small lh1em  onsale">
                                    <?php echo TravelHelper::format_money( $price_sale )?>
                                </span>
                    <i class="fa fa-long-arrow-right"></i>
                <?php } ?>
                <?php
                if(!empty($price)){
                    echo '<span class="text-darken mb0 text-color">'.TravelHelper::format_money($price).'<small> /'.STCars::get_price_unit('label').'</small></span>';
                }
                ?>
            </div>
        </div>
    </div>
</div>