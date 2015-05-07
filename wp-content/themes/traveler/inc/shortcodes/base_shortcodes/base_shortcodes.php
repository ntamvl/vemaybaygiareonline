<?php

    if(!function_exists('st_sc_custom_meta'))
    {
        function st_sc_custom_meta($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'key' =>''
                ), $attr, 'st_custom_meta' );
            extract($data);
            if(!empty($key) and is_singular()){
                $data = get_post_meta(get_the_ID() , $key  ,true);
                echo balanceTags($data);
            }

        }
    }
    st_reg_shortcode('st_custom_meta','st_sc_custom_meta');