<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/30/14
 * Time: 5:13 PM
 */
if(!function_exists('st_cruise_detail_map'))
{
    function st_cruise_detail_map()
    {
        if(is_singular('cruise'))
        {
            $lat=get_post_meta(get_the_ID(),'map_lat',true);
            $lng=get_post_meta(get_the_ID(),'map_lng',true);
            $zoom=get_post_meta(get_the_ID(),'map_zoom',true);
            $html=' <div style="width:100%; height:500px;" class="st_google_map" data-type="2" data-lat="'.$lat.'"
                             data-lng="'.$lng.'"
                             data-zoom="'.$zoom.'"
                            ></div>';

            return $html;
        }
    }
}

if(!function_exists('st_cruise_detail_review_summary'))
{
    function st_cruise_detail_review_summary()
    {
        if(is_singular('cruise'))
        {
            return st()->load_template('cruise/elements/review_summary');
        }
    }
}

if(!function_exists('st_cruise_detail_review_detail'))
{
    function st_cruise_detail_review_detail()
    {
        if(is_singular('cruise'))
        {
            return st()->load_template('cruise/elements/review_detail');
        }
    }
}

if(!function_exists('st_cruise_review'))
{
    function st_cruise_review()
    {
        if(is_singular('cruise'))
        {
            if(comments_open() and st()->get_option('cruise_review')=='on')
            {
                ob_start();
                comments_template('/reviews/reviews.php');
                return @ob_get_clean();
            }
        }
    }
}

if(!function_exists('st_cruise_nearby'))
{
    function st_cruise_nearby($arg=array())
    {
        if(is_singular('cruise'))
        {
            return st()->load_template('cruise/elements/nearby',null,array('arg'=>$arg));
        }
    }
}

if(!function_exists('st_cruise_add_review'))
{
    function st_cruise_add_review()
    {
        if(is_singular('cruise'))
        {
            return '<div class="text-right mb10">
                       <a class="btn btn-primary" href="'.get_comments_link().'">'.__('Write a review',ST_TEXTDOMAIN).'</a>
                       <a class="btn_add_wishlist btn btn-primary" data-type="'.get_post_type(get_the_ID()).'" data-id="'.get_the_ID().'" >
                        '.STUser_f::get_icon_wishlist().'
                       </a>
                    </div>';
        }
    }
}

if(!function_exists('st_cruise_price')){
    function st_cruise_price()
    {
        if(is_singular('cruise'))
        {
            return st()->load_template('cruise/elements/price');
        }
    }
}

if(!function_exists('st_cruise_video'))
{
    function st_cruise_video()
    {
        if(is_singular('cruise'))
        {
            if($video=get_post_meta(get_the_ID(),'video',true)){
                return "<div class='media-responsive'>".wp_oembed_get($video)."</div>";
            }
        }
    }
}

if(!function_exists('st_cruise_header'))
{
    function st_cruise_header($arg)
    {
        if(is_singular('cruise'))
        {
            return st()->load_template('cruise/elements/header',false,array('arg'=>$arg));
        }
        return false;
    }
}

if(!function_exists('st_cruise_book_form'))
{
    function st_cruise_book_form($arg=array())
    {
        if(is_singular('cruise'))
        {
            return st()->load_template('cruise/elements/book_form',false,array('arg'=>$arg));
        }
        return false;
    }
}

if(!function_exists('st_search_cruise_title'))
{
    function st_search_cruise_title($arg=array())
    {
        if(!get_post_type()=='cruise') return;

        $default=array(
            'search_modal'=>1
        );

        extract(wp_parse_args($arg,$default));

        $object=new STCruise();
        $a= '<h3 class="booking-title">'.balanceTags($object->get_result_string());

        if($search_modal){
            $a.='<small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">'.__('Change search').'</a></small>';
        }
        $a.='</h3>';

        return $a;
    }
}

if(!function_exists('st_search_cruise_result')){
    function st_search_cruise_result($arg=array())
    {
        if(!get_post_type()=='cruise') return;

        return st()->load_template('cruise/search-elements/result',false,array('arg'=>$arg));
    }
}

if(!function_exists('st_cruise_programes'))
{
    function st_cruise_programes($arg)
    {
        if(is_singular('cruise'))
        {
            return st()->load_template('cruise/elements/programes',false,array('arg'=>$arg));
        }
        return false;
    }
}

if(!function_exists('st_cruise_search_cabins'))
{
    function st_cruise_search_cabins($arg)
    {
        if(is_singular('cruise'))
        {
            return st()->load_template('cruise/elements/search_cabin',false,array('arg'=>$arg));
        }
        return false;
    }
}

if(!function_exists('st_cruise_list_cabins'))
{
    function st_cruise_list_cabins($arg)
    {
        if(is_singular('cruise'))
        {
            return st()->load_template('cruise/elements/loop_cabin',false,array('arg'=>$arg));
        }
        return false;
    }
}

st_reg_shortcode('st_search_cruise_result','st_search_cruise_result');
st_reg_shortcode('st_search_cruise_title','st_search_cruise_title');

st_reg_shortcode('st_cruise_book_form','st_cruise_book_form');
st_reg_shortcode('st_cruise_header','st_cruise_header');
st_reg_shortcode('st_cruise_video','st_cruise_video');
st_reg_shortcode('st_cruise_price','st_cruise_price');
st_reg_shortcode('st_cruise_add_review','st_cruise_add_review');
st_reg_shortcode('st_cruise_nearby','st_cruise_nearby');
st_reg_shortcode('st_cruise_review','st_cruise_review');
st_reg_shortcode('st_cruise_review_detail','st_cruise_detail_review_detail');
st_reg_shortcode('st_cruise_review_summary','st_cruise_detail_review_summary');
st_reg_shortcode('st_cruise_map','st_cruise_detail_map');
st_reg_shortcode('st_cruise_programes','st_cruise_programes');

st_reg_shortcode('st_cruise_search_cabins','st_cruise_search_cabins');
st_reg_shortcode('st_cruise_list_cabins','st_cruise_list_cabins');
