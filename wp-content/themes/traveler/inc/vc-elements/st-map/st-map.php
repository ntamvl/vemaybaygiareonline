<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name"      => __("ST Google Map", ST_TEXTDOMAIN),
            "base"      => "st_google_map",
            "class"     => "",
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params"    => array(
                array(
                    "type"      => "dropdown",
                    "holder"    => "div",
                    "class"     => "",
                    "heading"   => __("Type", ST_TEXTDOMAIN),
                    "param_name"=> "type",
                    "value"     => array(
                        __('Use Address',ST_TEXTDOMAIN)=>1,
                        __('User Latitude and Longitude',ST_TEXTDOMAIN)=>2,
                    ),
                    "description" => __("Address or using Latitude and Longitude", ST_TEXTDOMAIN)
                ),
                array(
                    "type"      => "textfield",
                    "holder"    => "div",
                    "class"     => "",
                    "heading"   => __("Address", ST_TEXTDOMAIN),
                    "param_name"=> "address",
                    "value"     => "",
                    "description" => __("Address", ST_TEXTDOMAIN)
                ),
                array(
                    "type"      => "textfield",
                    "holder"    => "div",
                    "class"     => "",
                    "heading"   => __("Latitude", ST_TEXTDOMAIN),
                    "param_name"=> "latitude",
                    "value"     => "",
                    "description" => __("Latitude, you can get it from  <a target='_blank' href='http://www.latlong.net/convert-address-to-lat-long.html'>here</a>", ST_TEXTDOMAIN)
                ),
                array(
                    "type"      => "textfield",
                    "holder"    => "div",
                    "class"     => "",
                    "heading"   => __("Longitude", ST_TEXTDOMAIN),
                    "param_name"=> "longitude",
                    "value"     => "",
                    "description" => __("Longitude", ST_TEXTDOMAIN)
                ),
                array(
                    "type"      => "textfield",
                    "holder"    => "div",
                    "class"     => "",
                    "heading"   => __("Lightness", ST_TEXTDOMAIN),
                    "param_name"=> "lightness",
                    "value"     => 0,
                    "description" => __("(a floating point value between -100 and 100) indicates the percentage change in brightness of the element.", ST_TEXTDOMAIN)
                ),
                array(
                    "type"      => "textfield",
                    "holder"    => "div",
                    "class"     => "",
                    "heading"   => __("Saturation", ST_TEXTDOMAIN),
                    "param_name"=> "saturation",
                    "value"     => "-100",
                ),
                array(
                    "type"      => "textfield",
                    "holder"    => "div",
                    "class"     => "",
                    "heading"   => __("Gamma", ST_TEXTDOMAIN),
                    "param_name"=> "gama",
                    "value"     => 0.5,
                ),
                array(
                    "type"      => "textfield",
                    "holder"    => "div",
                    "class"     => "",
                    "heading"   => __("Zoom", ST_TEXTDOMAIN),
                    "param_name"=> "zoom",
                    "value"     => 13,
                ),
                array(
                    "type"      => "attach_image",
                    "holder"    => "div",
                    "class"     => "",
                    "heading"   => __("Custom Marker Icon", ST_TEXTDOMAIN),
                    "param_name"=> "marker",
                    "value"     => "",
                    "description" => __("Custom Marker Icon", ST_TEXTDOMAIN)
                ),
            )));
    }

    if(!function_exists('st_vc_google_map')){
        function st_vc_google_map($attr,$content=false)
        {

            wp_enqueue_script('st-gmap-init');
            extract(shortcode_atts(array(
                'address'=>'93 Worth St, New York, NY',
                'type'=>1,
                'marker'=>'',
                'height'=>'480',
                'lightness'=>0,
                'saturation'=>0,
                'gama'=>0.5,
                'zoom'=>13,
                'longitude'=>false,
                'latitude'=>false
            ),$attr));
            /*if(!$marker)
            {
                $marker_url=get_template_directory_uri().'/images/marker.png';
            }else
            {
                $marker_url=wp_get_attachment_image_src($marker,'full');
                if(isset($marker_url[0]))
                {
                    $marker_url=$marker_url[0];
                }else
                {
                    $marker_url=get_template_directory_uri().'/img/marker.png';
                }
            }*/
            return "<div class='map_wrap'><div data-type='{$type}' data-lat='{$latitude}' data-lng='{$longitude}' data-zoom='{$zoom}' style='height: {$height}px' data-lightness='{$lightness}' data-saturation='{$saturation}' data-gama='{$gama}'  class='st_google_map' data-address='{$address}' data-marker='$marker_url'>
                    </div></div>";
        }
    }
    st_reg_shortcode('ST_Google_Map','st_vc_google_map');
   // add_action('wp_enqueue_scripts',array($googlemap,'add_scripst'));
