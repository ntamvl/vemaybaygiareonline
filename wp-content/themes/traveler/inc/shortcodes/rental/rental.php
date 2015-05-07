<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/30/14
 * Time: 5:13 PM
 */
if(!function_exists('st_rental_detail_map'))
{
    function st_rental_detail_map()
    {
        if(is_singular('st_rental'))
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

if(!function_exists('st_rental_detail_review_summary'))
{
    function st_rental_detail_review_summary()
    {
        if(is_singular('st_rental'))
        {
            return st()->load_template('rental/elements/review_summary');
        }
    }
}

if(!function_exists('st_rental_detail_review_detail'))
{
    function st_rental_detail_review_detail()
    {
        if(is_singular('st_rental'))
        {
            return st()->load_template('rental/elements/review_detail');
        }
    }
}

if(!function_exists('st_rental_review'))
{
    function st_rental_review()
    {
        if(is_singular('st_rental'))
        {
            if(comments_open() and st()->get_option('rental_review')=='on')
            {
                ob_start();
                comments_template('/reviews/reviews.php');
                return @ob_get_clean();
            }
        }
    }
}

if(!function_exists('st_rental_nearby'))
{
    function st_rental_nearby($arg=array())
    {
        if(is_singular('st_rental'))
        {
            return st()->load_template('rental/elements/nearby',null,array('arg'=>$arg));
        }
    }
}

if(!function_exists('st_rental_add_review'))
{
    function st_rental_add_review()
    {
        if(is_singular('st_rental'))
        {
            return '<div class="text-right mb10"><a class="btn btn-primary" href="'.get_comments_link().'">'.__('Write a review',ST_TEXTDOMAIN).'</a>
                                        </div>';
        }
    }
}

if(!function_exists('st_rental_price')){
    function st_rental_price()
    {
        if(is_singular('st_rental'))
        {
            return st()->load_template('rental/elements/price');
        }
    }
}

if(!function_exists('st_rental_video'))
{
    function st_rental_video()
    {
        if(is_singular('st_rental'))
        {
            if($video=get_post_meta(get_the_ID(),'video',true)){
                return "<div class='media-responsive'>".wp_oembed_get($video)."</div>";
            }
        }
    }
}

if(!function_exists('st_rental_header'))
{
    function st_rental_header($arg)
    {
        if(is_singular('st_rental'))
        {
            return st()->load_template('rental/elements/header',false,array('arg'=>$arg));
        }
        return false;
    }
}

if(!function_exists('st_rental_book_form'))
{
    function st_rental_book_form($arg=array())
    {
        if(is_singular('st_rental'))
        {
            return st()->load_template('rental/elements/book_form',false,array('arg'=>$arg));
        }
        return false;
    }
}

if(!function_exists('st_search_rental_title'))
{
    function st_search_rental_title($arg=array())
    {
        if(!get_post_type()=='st_rental' and get_query_var('post_type')!='st_rental') return;

        $default=array(
            'search_modal'=>1
        );

        extract(wp_parse_args($arg,$default));

        $object=new STRental();
        $a= '<h3 class="booking-title">'.balanceTags($object->get_result_string());

        if($search_modal){
            $a.='<small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">'.__('Change search').'</a></small>';
        }
        $a.='</h3>';

        return $a;
    }
}

if(!function_exists('st_search_rental_result')){
    function st_search_rental_result($arg=array())
    {
        if(!get_post_type()=='st_rental' and get_query_var('post_type')!="st_rental") return;

        return st()->load_template('rental/search-elements/result',false,array('arg'=>$arg));
    }
}

st_reg_shortcode('st_search_rental_result','st_search_rental_result');
st_reg_shortcode('st_search_rental_title','st_search_rental_title');

st_reg_shortcode('st_rental_book_form','st_rental_book_form');
st_reg_shortcode('st_rental_header','st_rental_header');
st_reg_shortcode('st_rental_video','st_rental_video');
st_reg_shortcode('st_rental_price','st_rental_price');
st_reg_shortcode('st_rental_add_review','st_rental_add_review');
st_reg_shortcode('st_rental_nearby','st_rental_nearby');
st_reg_shortcode('st_rental_review','st_rental_review');
st_reg_shortcode('st_rental_review_detail','st_rental_detail_review_detail');
st_reg_shortcode('st_rental_review_summary','st_rental_detail_review_summary');
st_reg_shortcode('st_rental_map','st_rental_detail_map');