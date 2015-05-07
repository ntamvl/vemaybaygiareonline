<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 4/16/15
 * Time: 8:49 AM
 */

if(!class_exists('ST_Woocommerce'))
{
    class ST_Woocommerce
    {
        private $_is_inited=false;

        function __construct()
        {
            if($this->_is_inited) return;

            $this->_is_inited=true;

            // Hook Init
            add_action('woocommerce_before_main_content',array($this,'_add_before_main_content'),100);
            add_action('woocommerce_after_main_content',array($this,'_add_after_main_content'),1);
            add_filter('woocommerce_show_page_title',array($this,'_hide_page_title'));
            add_filter('woocommerce_breadcrumb_defaults',array($this,'_change_bc_class'));
            add_filter('st_shop_sidebar',array($this,'_change_shop_sidebar'));

            add_action('pre_get_posts',array($this,'_change_posts_per_page'));

            add_filter('loop_shop_columns',array($this,'_change_loop_shop_columns'));
            add_action('woocommerce_before_shop_loop_item_title',array($this,'_add_thumb_img_hover'));
        }
        function _add_thumb_img_hover()
        {
            global $product;
            $attachment_ids=$product->get_gallery_attachment_ids();
            if ( $attachment_ids ) {
                foreach($attachment_ids as $key=>$value){
                    $image       = wp_get_attachment_image( $value, apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ),false,array('class'=>'product-image-hover') );

                    echo ($image);
                    break;
                }
            }
        }
        function _change_loop_shop_columns()
        {
            return 3;
        }

         function _change_posts_per_page($query)
        {
            if($limit=STInput::get('posts_per_page'))
            {
                $query->set('posts_per_page',$limit);
            }


        }

        static function _hide_page_title()
        {
            return false;
        }


        function _add_before_main_content()
        {
            $sidebar=apply_filters('st_shop_sidebar',array('position'=>'left','id'=>'shop'));
            echo '<div class="container shop_main_container" >';
            ?>

            <div class="row shop_main_row">

            <?php

            if($sidebar['position']=='left'){
                do_action('woocommerce_sidebar');
                remove_all_actions('woocommerce_sidebar');
            }
            ?>
            <div class="shop_product_col col-sm-<?php echo ($sidebar['position']=='no')?12:8; ?> col-md-<?php echo ($sidebar['position']=='no')?12:9; echo ($sidebar['position']!='no')?' padding-'.$sidebar['position'].'-lg':'' ?>">

                <?php
        }
        function _add_after_main_content()
        {
            $sidebar = apply_filters('st_shop_sidebar',array('position'=>'left','id'=>'shop'));

            ?>
                </div><!-- End shop_product_col-->
            <?php
            if($sidebar['position']=='right'){
                do_action('woocommerce_sidebar');
                remove_all_actions('woocommerce_sidebar');
            }

            if ($sidebar['position'] != 'right') {
                echo "</div><!--End shop_main_row-->";
            }
            echo "</div><!-- End shop_main_container-->";


            remove_all_actions('woocommerce_sidebar');
        }

        function _change_shop_sidebar($sidebar)
        {
            if(is_archive('product'))
            {
                $sidebar['position']=st()->get_option('shop_sidebar_pos','left');
                $sidebar['id']=st()->get_option('shop_sidebar_id','shop');
            }

            if(is_singular('product'))
            {
                $sidebar['position']=st()->get_option('shop_single_sidebar_pos','left');
                $sidebar['id']=st()->get_option('shop_single_sidebar_id','shop');

                if($meta=get_post_meta(get_the_ID(),'post_sidebar_pos',true))
                {
                    $sidebar['position']=$meta;
                }

                if($meta=get_post_meta(get_the_ID(),'post_sidebar',true))
                {
                    $sidebar['id']=$meta;
                }

            }

            return $sidebar;
        }

         function _change_bc_class($data)
        {
            $data['wrap_before']='<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '><div class="container">';
            $data['wrap_after']='</div></nav>';

            return $data;
        }

    }

    new ST_Woocommerce();
}