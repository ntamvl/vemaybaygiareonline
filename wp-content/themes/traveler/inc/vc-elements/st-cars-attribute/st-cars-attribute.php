<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Cars Attribute", ST_TEXTDOMAIN),
            "base" => "st_cars_attribute",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy", ST_TEXTDOMAIN),
                    "param_name" => "taxonomy",
                    "description" =>"",
                    "value" => st_list_taxonomy('st_cars'),
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Title", ST_TEXTDOMAIN),
                    "param_name" => "title",
                    "description" =>"",
                )
            )
        ) );
    }

    if(!function_exists('st_vc_cars_attribute')){
        function st_vc_cars_attribute($attr,$content=false)
        {
            if(is_singular('st_cars'))
            {
                return st()->load_template('cars/elements/attribute',null,array('attr'=>$attr));
            }
        }
    }
    st_reg_shortcode('st_cars_attribute','st_vc_cars_attribute');