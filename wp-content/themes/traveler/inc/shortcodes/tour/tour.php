<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/15/14
 * Time: 9:44 AM
 */

if(!function_exists('st_thumbnail_tours_func'))
{
    function st_thumbnail_tours_func()
    {
        if(is_singular('st_tours'))
        {
            return st()->load_template('tours/elements/image','featured');
        }
    }
    st_reg_shortcode('st_thumbnail_tours','st_thumbnail_tours_func');
}

if(!function_exists('st_excerpt_tours_func'))
{
    function st_excerpt_tours_func()
    {
        if(is_singular('st_tours'))
        {
            return '<blockquote class="center">'.get_the_excerpt()."</blockquote>";
        }
    }
    st_reg_shortcode('st_excerpt_tour','st_excerpt_tours_func');
}


if(!function_exists('st_tour_content_func'))
{
    function st_tour_content_func()
    {
        if(is_singular('st_tours'))
        {
             return st()->load_template('tours/elements/content','tours');
        }
    }
    st_reg_shortcode('st_tour_content','st_tour_content_func');
}

if(!function_exists('st_info_tours_func'))
{
    function st_info_tours_func()
    {
        if(is_singular('st_tours'))
        {
            return st()->load_template('tours/elements/info','tours');
        }
    }
    st_reg_shortcode('st_info_tours','st_info_tours_func');
}

if(!function_exists('st_tour_detail_map'))
{
    function st_tour_detail_map()
    {
        if(is_singular('st_tours'))
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

if(!function_exists('st_tour_detail_review_summary'))
{
    function st_tour_detail_review_summary()
    {

        if(is_singular('st_tours'))
        {
            return st()->load_template('tours/elements/review_summary');
        }
    }
}

if(!function_exists('st_tour_detail_review_detail'))
{
    function st_tour_detail_review_detail()
    {
        if(is_singular('st_tours'))
        {
            return st()->load_template('tours/elements/review_detail');
        }
    }
}


if(!function_exists('st_tour_program'))
{
    function st_tour_program()
    {
        if(is_singular('st_tours'))
        {
            return st()->load_template('tours/elements/program');
        }
    }
}
st_reg_shortcode('st_tour_program','st_tour_program');

if(!function_exists('st_tour_share'))
{
    function st_tour_share()
    {
        if(is_singular('st_tours'))
        {
            return '<div class="package-info tour_share" style="clear: both;text-align: right">
                        '.st()->load_template('hotel/share').'
                    </div>';
        }
    }
}
st_reg_shortcode('st_tour_share','st_tour_share');


if(!function_exists('st_tour_review'))
{
    function st_tour_review()
    {
        if(is_singular('st_tours'))
        {

            if(comments_open() and st()->get_option('activity_tour_review')=='on')
            {
                ob_start();
                    comments_template('/reviews/reviews.php');
                return @ob_get_clean();
            }
        }
    }
}


if(!function_exists('st_tour_price'))
{

    function st_tour_price($attr=array())
    {
        if(is_singular('st_tours'))
        {
            return st()->load_template('tours/elements/price');
        }
    }
}

if(!function_exists('st_tour_video'))
{
    function st_tour_video($attr=array())
    {
        if(is_singular('st_tours'))
        {
            if($video=get_post_meta(get_the_ID(),'video',true)){
                return "<div class='media-responsive'>".wp_oembed_get($video)."</div>";
            }
        }
    }
}

if(!function_exists('st_tour_nearby'))
{
    function st_tour_nearby()
    {
        if(is_singular('st_tours'))
        {
            return st()->load_template('tours/elements/nearby');
        }
    }
}
st_reg_shortcode('st_tour_nearby','st_tour_nearby');


st_reg_shortcode('st_tour_video','st_tour_video');

st_reg_shortcode('st_tour_price','st_tour_price');


st_reg_shortcode('st_tour_review','st_tour_review');

st_reg_shortcode('st_tour_detail_list_schedules','st_tour_detail_list_schedules');



st_reg_shortcode('st_tour_detail_review_detail','st_tour_detail_review_detail');
st_reg_shortcode('st_tour_detail_review_summary','st_tour_detail_review_summary');

st_reg_shortcode('st_tour_detail_map','st_tour_detail_map');

