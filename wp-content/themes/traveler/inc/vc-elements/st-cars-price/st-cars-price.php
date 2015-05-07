<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Cars Price ", ST_TEXTDOMAIN),
            "base" => "st_cars_price",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", ST_TEXTDOMAIN),
                    "param_name" => "st_style",
                    "description" =>"",
                    "value" => array(
                        __('Style 1 column',ST_TEXTDOMAIN)=>'1',
                        __('Style 2 column',ST_TEXTDOMAIN)=>'2'
                    ),
                )
            )
        ) );
    }

    if(!function_exists('st_vc_cars_price')){
        function st_vc_cars_price($attr,$content=false)
        {
            if(is_singular('st_cars'))
            {
                return st()->load_template('cars/elements/price',null,array('attr'=>$attr));
            }
        }
    }
    st_reg_shortcode('st_cars_price','st_vc_cars_price');