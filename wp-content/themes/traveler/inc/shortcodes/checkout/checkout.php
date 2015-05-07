<?php
    if(!function_exists('st_sc_checkout'))
    {
        function st_sc_checkout($attr=array(),$content=false)
        {
            return st()->load_template('checkout/html');
        }
    }
    st_reg_shortcode('st_checkout','st_sc_checkout');