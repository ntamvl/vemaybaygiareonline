<div class="row row-wrap">
   <?php
   while(have_posts()):
       the_post();
       $col = 12 / $st_of_row;

       $price = get_post_meta(get_the_ID(),'price',true);
       $count_sale = get_post_meta(get_the_ID(),'discount',true);
       if(!empty($count_sale)){
           $x = $price;
           $price_sale = $price - $price * ( $count_sale / 100 );
           $price = $price_sale;
           $price_sale = $x;
       }
   ?>
   <div class="col-md-<?php echo esc_attr($col) ?> col-sm-6 col-xs-12 list_tour style_box">
       <?php echo STFeatured::get_featured(); ?>
       <div class="thumb">
           <?php if(!empty($count_sale)){ ?>
               <span class="box_sale btn-primary"> <?php echo esc_html($count_sale) ?>% </span>
           <?php } ?>
           <header class="thumb-header">
               <a href="<?php the_permalink() ?>" class="hover-img">
                   <?php
                   $img = get_the_post_thumbnail( get_the_ID() , array(800,600,'bfi_thumb'=>true)) ;
                   if(!empty($img)){
                       echo balanceTags($img);
                   }else{
                       echo '<img width="800" height="600" alt="no-image" class="wp-post-image" src="'.bfi_thumb(get_template_directory_uri().'/img/no-image.png',array('width'=>800,'height'=>600)) .'">';
                   }
                   ?>
                   <h5 class="hover-title-center"><?php STLanguage::st_the_language('book_now') ?></h5>
               </a>
           </header>
           <div class="thumb-caption">
               <ul class="icon-group text-tiny text-color">
                   <?php echo  TravelHelper::rate_to_string(STReview::get_avg_rate()); ?>
               </ul>
               <h5 class="thumb-title">
                   <a href="<?php the_permalink() ?>" class="text-darken">
                       <?php the_title(); ?>
                   </a>
               </h5>
               <p class="mb0">
                   <small><i class="fa fa-map-marker"></i>
                       <?php $address = get_post_meta(get_the_ID(),'address',true); ?>
                       <?php
                       if(!empty($address)){
                           echo esc_html($address);
                       }
                       ?>
                   </small>
               </p>
               <p class="mb0 text-darken">
                   <?php if(!empty($count_sale)){ ?>
                       <span class="text-small lh1em  onsale">
                           <?php echo TravelHelper::format_money( $price_sale )?>
                       </span>
                       <i class="fa fa-long-arrow-right"></i>
                   <?php } ?>
                   <span class="text-lg lh1em text-color">
                       <?php echo TravelHelper::format_money($price)?>
                   </span>
                   <small> /<?php _e('person',ST_TEXTDOMAIN) ?></small
               </p>
           </div>
       </div>
   </div>
   <?php
   endwhile;
   ?>
</div>
