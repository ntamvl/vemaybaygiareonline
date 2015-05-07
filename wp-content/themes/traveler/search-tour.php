<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Search custom tours
 *
 * Created by ShineTheme
 *
 */
global $wp_query;
$tours=new STTour();
get_header();
get_template_part('breadcrumb');
$result_string='';

echo st()->load_template('search-loading');
?>
    <div class="mfp-with-anim mfp-dialog mfp-search-dialog mfp-hide" id="search-dialog">
        <?php echo st()->load_template('tours/search-form');?>
    </div>
    <div class="container">
        <h3 class="booking-title"><?php echo balanceTags($tours->get_result_string())?>
            <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out"><?php st_the_language('change_search')?></a></small></h3>
        <?php
        $tours_layout_layout=st()->get_option('tours_search_layout');
        if(!empty($_REQUEST['layout_id'])){
            $tours_layout_layout = $_REQUEST['layout_id'];
        }
        if($tours_layout_layout){
            echo  STTemplate::get_vc_pagecontent($tours_layout_layout);
        }
        ?>
    </div>
<?php
get_footer();
?>