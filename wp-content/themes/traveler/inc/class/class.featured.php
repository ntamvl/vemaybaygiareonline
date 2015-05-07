<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class Featured
 *
 * Created by ShineTheme
 *
 */
class STFeatured extends TravelerObject
{
    function __construct()
    {

    }
    function init()
    {
        parent::init();
    }

    static function get_featured($id=null){
        if(empty($id)) $id = get_the_ID();
        $check_featured = get_post_meta($id,'is_featured',true);
        if(!empty($check_featured) and $check_featured == 'on'){
            return '<div class="st_featured">'.st()->get_option('st_text_featured',__('Featured',ST_TEXTDOMAIN)).'</div>';
        }else{
            return false;
        }
    }
}
$st=new STFeatured();
$st->init();