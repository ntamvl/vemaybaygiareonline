<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours loop content 2
 *
 * Created by ShineTheme
 *
 */
?>
<div class="row row-wrap">
   <?php
   while(have_posts()):
       the_post();
       $col = 12 / 3;
       $info_price = STTour::get_info_price();
       $price = $info_price['price'];
       $count_sale = $info_price['discount'];
       if(!empty($count_sale)){
           $price = $info_price['price'];
           $price_sale = $info_price['price_old'];
       }
   ?>
   <div class="col-md-<?php echo esc_attr($col) ?> col-sm-6 col-xs-12 list_activity style_box">
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
                   <h5 class="hover-title-center"><?php st_the_language('book_now')?></h5>
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
               <p class="mb0">
                   <small>
                       <?php $type_tour = get_post_meta(get_the_ID(),'type_tour',true); ?>
                       <?php if($type_tour == 'daily_tour'){ ?>
                           <i class="fa fa-calendar"></i>
                           <span class=""><?php  _e('Duration',ST_TEXTDOMAIN)?> : </span>
                           <?php  $day =  get_post_meta(get_the_ID(),'duration_day',true)?>
                           <?php echo esc_html($day) ?>
                           <?php if($day > 1) _e('days',ST_TEXTDOMAIN); else _e('day',ST_TEXTDOMAIN) ?>
                       <?php }else{ ?>
                           <?php
                           $check_in = get_post_meta(get_the_ID() , 'check_in' ,true);
                           $check_out = get_post_meta(get_the_ID() , 'check_out' ,true);
                           if(!empty($check_out) and !empty($check_out)):
                               ?>
                               <i class="fa fa-calendar"></i>
                               <span class=""><?php st_the_language('tour_date') ?> : </span>
                               <?php
                               $date = mysql2date('m/d/Y',$check_in).' <i class="fa fa-long-arrow-right"></i> '.mysql2date('m/d/Y',$check_out);
                               echo balanceTags($date);
                           endif;
                           ?>
                       <?php } ?>
                   </small>
               </p>
               <p class="mb0">
                   <small>
                       <?php $info_book = STTour::get_count_book(get_the_ID());?>
                       <i class="fa  fa-user"></i>
                                <span class="">
                                    <?php
                                    if($info_book > 1){
                                        echo sprintf( __( '%d users booked',ST_TEXTDOMAIN ), $info_book );
                                    }else{
                                        echo sprintf( __( '%d user booked',ST_TEXTDOMAIN ), $info_book );
                                    }
                                    ?>
                                </span>
                   </small>
               </p>
               <p class="mb0 text-darken">

                   <?php echo STTour::get_price_html() ?>


               </p>

           </div>
       </div>
   </div>
   <?php
   endwhile;
   ?>
</div>
