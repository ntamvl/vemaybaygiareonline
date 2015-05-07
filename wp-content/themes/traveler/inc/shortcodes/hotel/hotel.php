<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/15/14
 * Time: 9:44 AM
 */

if(!function_exists('st_hotel_detail_map'))
{
    function st_hotel_detail_map()
    {
        if(is_singular('st_hotel'))
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

if(!function_exists('st_hotel_detail_review_summary'))
{
    function st_hotel_detail_review_summary()
    {
        if(is_singular('st_hotel'))
        {
            return st()->load_template('hotel/elements/review_summary');
        }
    }
}

if(!function_exists('st_hotel_detail_review_detail'))
{
    function st_hotel_detail_review_detail()
    {
        if(is_singular('st_hotel'))
        {
            return st()->load_template('hotel/elements/review_detail');
        }
    }
}

if(!function_exists('st_hotel_detail_search_room'))
{
    function st_hotel_detail_search_room($attr=array())
    {
        if(is_singular('st_hotel'))
        {
            $a= st()->load_template('hotel/elements/search_room',null,array('attr'=>$attr));
            return $a;
        }
    }
}

if(!function_exists('st_hotel_detail_list_rooms'))
{
    function st_hotel_detail_list_rooms($attr=array())
    {
        if(is_singular('st_hotel'))
        {
            return st()->load_template('hotel/elements/loop_room',null,array('attr'=>$attr));
        }
    }
}

if(!function_exists('st_hotel_review'))
{
    function st_hotel_review()
    {
        if(is_singular('st_hotel'))
        {
            if(comments_open() and st()->get_option('hotel_review')=='on')
            {
                ob_start();
                    comments_template('/reviews/reviews.php');
                return @ob_get_clean();
            }
        }
    }
}


if(!function_exists('st_hotel_nearby'))
{
    function st_hotel_nearby()
    {
        if(is_singular('st_hotel'))
        {
           return st()->load_template('hotel/elements/nearby');
        }
    }
}

if(!function_exists('st_hotel_add_review'))
{
    function st_hotel_add_review()
    {
        if(is_singular('st_hotel'))
        {
           return '<div class="text-right mb10">
                      <a class="btn btn-primary" href="'.get_comments_link().'">'.__('Write a review',ST_TEXTDOMAIN).'</a>
                   </div>';
        }
    }
}

if(!function_exists('st_hotel_logo'))
{
    function st_hotel_logo($attr=array())
    {
        if(is_singular('st_hotel'))
        {
            $default=array(
                'size'=>'full'
            );

            extract(wp_parse_args($attr,$default));

            $meta=get_post_meta(get_the_ID(),'logo',true);
            if($meta)
            {
                return wp_get_attachment_image($meta,$size,false,array('class'=>'img-responsive','style'=>'margin-bottom:10px;'));
            }
        }
    }
}


if(!function_exists('st_hotel_price'))
{
    function st_hotel_price($attr=array())
    {
        if(is_singular('st_hotel'))
        {
            return st()->load_template('hotel/elements/price');
        }
    }
}

if(!function_exists('st_hotel_video'))
{
    function st_hotel_video($attr=array())
    {
        if(is_singular('st_hotel'))
        {
            if($video=get_post_meta(get_the_ID(),'video',true)){
                return "<div class='media-responsive'>".wp_oembed_get($video)."</div>";
            }
        }
    }
}

if(!function_exists('st_search_hotel_title'))
{
    function st_search_hotel_title($arg=array())
    {
        if(!get_post_type()=='st_hotel' and get_query_var('post_type')!="st_hotel") return;

        $default=array(
            'search_modal'=>1
        );

        extract(wp_parse_args($arg,$default));

        $hotel=new STHotel();
        $a= '<h3 class="booking-title">'.balanceTags($hotel->get_result_string());

        if($search_modal){
            $a.='<small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">'.__('Change search').'</a></small>';
        }
        $a.='</h3>';

        return $a;
    }
}

if(!function_exists('st_search_hotel_result')){
    function st_search_hotel_result($arg=array())
    {

        if(!get_post_type()=='st_hotel' and get_query_var('post_type')!="st_hotel") return;

        return st()->load_template('hotel/search-elements/result',false,array('arg'=>$arg));
    }
}

if(!function_exists('st_hotel_header'))
{
    function st_hotel_header($arg)
    {
        if(is_singular('st_hotel'))
        {
            return st()->load_template('hotel/elements/header',false,array('arg'=>$arg));
        }
        return false;
    }
}

if(!function_exists('st_hotel_detail_card_accept'))
{
    function st_hotel_detail_card_accept($arg=array())
    {
        if(is_singular('st_hotel'))
        {
            return st()->load_template('hotel/elements/card',false,array('arg'=>$arg));
        }
        return false;
    }
}

st_reg_shortcode('st_search_hotel_result','st_search_hotel_result');
st_reg_shortcode('st_search_hotel_title','st_search_hotel_title');

st_reg_shortcode('st_hotel_header','st_hotel_header');
st_reg_shortcode('st_hotel_video','st_hotel_video');
st_reg_shortcode('st_hotel_price','st_hotel_price');
st_reg_shortcode('st_hotel_logo','st_hotel_logo');
st_reg_shortcode('st_hotel_add_review','st_hotel_add_review');
st_reg_shortcode('st_hotel_nearby','st_hotel_nearby');
st_reg_shortcode('st_hotel_review','st_hotel_review');
st_reg_shortcode('st_hotel_detail_list_rooms','st_hotel_detail_list_rooms');
st_reg_shortcode('st_hotel_detail_card_accept','st_hotel_detail_card_accept');
st_reg_shortcode('st_hotel_detail_search_room','st_hotel_detail_search_room');
st_reg_shortcode('st_hotel_detail_review_detail','st_hotel_detail_review_detail');
st_reg_shortcode('st_hotel_detail_review_summary','st_hotel_detail_review_summary');
st_reg_shortcode('st_hotel_detail_map','st_hotel_detail_map');

