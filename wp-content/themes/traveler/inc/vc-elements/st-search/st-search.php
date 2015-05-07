<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Search", ST_TEXTDOMAIN),
            "base" => "st_search",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", ST_TEXTDOMAIN),
                    "param_name" => "st_style_search",
                    "description" =>"",
                    'value'=>array(
                        __('Large',ST_TEXTDOMAIN)=>'style_1',
                        __('Small',ST_TEXTDOMAIN)=>'style_2'
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Show box shadow", ST_TEXTDOMAIN),
                    "param_name" => "st_box_shadow",
                    "description" =>"",
                    'value'=>array(
                        __('No',ST_TEXTDOMAIN)=>'no',
                        __('Yes',ST_TEXTDOMAIN)=>'yes'
                    ),
                )
            )
        ) );
    }

    if(!function_exists('st_vc_search')){
        function st_vc_search($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_style_search' =>'style_1',
                    'st_box_shadow'=>'no',
                ), $attr, 'st_search' );
            extract($data);
            $txt = st()->load_template('vc-elements/st-search/search','form',array('data'=>$data));
            return $txt;
        }
    }
    st_reg_shortcode('st_search','st_vc_search');