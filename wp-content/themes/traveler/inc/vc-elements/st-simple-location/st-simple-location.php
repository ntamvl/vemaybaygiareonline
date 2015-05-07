<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Simple Location", ST_TEXTDOMAIN),
            "base" => "st_simple_location",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Type", ST_TEXTDOMAIN),
                    "param_name" => "st_type",
                    "description" =>"",
                    'value'=>array(
                        __('Hotel',ST_TEXTDOMAIN)=>'st_hotel',
                        __('Car',ST_TEXTDOMAIN)=>'st_cars',
                        __('Tour',ST_TEXTDOMAIN)=>'st_tours',
                        __('Rental',ST_TEXTDOMAIN)=>'st_rental',
                        __('Activities',ST_TEXTDOMAIN)=>'st_activity',
                        //__('Cruise',ST_TEXTDOMAIN)=>'cruise',
                    ),
                ),
                array(
                    "type" => "st_post_type_location",
                    "holder" => "div",
                    "heading" => __("Select Location ", ST_TEXTDOMAIN),
                    "param_name" => "st_list_location",
                    "description" =>"",
                ),
            )
        ) );
    }

    if(!function_exists('st_vc_simple_location')){
        function st_vc_simple_location($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_type'=>'',
                    'st_list_location' =>0,
                ), $attr, 'st_simple_location' );
            extract($data);
            $ids = explode(',',$st_list_location);
            $query=array(
                'post_type' => 'location',
                'post__in'  => $ids
            );
            query_posts($query);
            $r ='';
            while(have_posts()){
                the_post();

                $r =  st()->load_template('vc-elements/st-simple-location/html',null,$data);

            }
            wp_reset_query();
            return $r;
        }
    }
    st_reg_shortcode('st_simple_location','st_vc_simple_location');