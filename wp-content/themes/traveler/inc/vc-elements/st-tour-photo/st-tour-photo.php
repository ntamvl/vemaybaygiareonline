<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Tour Detail Photo", ST_TEXTDOMAIN),
            "base" => "st_tour_detail_photo",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", ST_TEXTDOMAIN),
                    "param_name" => "style",
                    "description" =>"",
                    "value" => array(
                        __('Slide',ST_TEXTDOMAIN)=>'slide',
                        __('Grid',ST_TEXTDOMAIN)=>'grid',
                    ),
                )
            )
        ) );
    }

    if(!function_exists('st_vc_tour_detail_photo')){
        function st_vc_tour_detail_photo($attr,$content=false)
        {
            if(is_singular('st_tours'))
            {
                return st()->load_template('tours/elements/photo',null,array('attr'=>$attr));
            }
        }
    }
    st_reg_shortcode('st_tour_detail_photo','st_vc_tour_detail_photo');