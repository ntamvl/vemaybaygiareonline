<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Custom vc row
 *
 * Created by ShineTheme
 *
 */
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'css' => '',
    'row_fullwidth'=>'no',
    'parallax_class'=>"no",
    'bg_video'=>'no',
    'st_media'=>'',
    'row_id'=>''
), $atts));
wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' st bg-holder' . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);


if(!empty($row_id)){
    $row_id = 'id="'.$row_id.'"';
}

if($parallax_class =='yes' ){

    $css_class .= " bg-parallax ";

}

$output .= '<div '.$row_id.' class="'.$css_class.'"'.$style.' >';

if($parallax_class =='yes' ){

    $output .= '<div class="bg-mask"></div>';

}

if($bg_video == 'yes'){
    if(!empty($st_media)){
        $output .= '<video class="bg-video hidden-sm hidden-xs" preload="auto" autoplay="true" loop="loop" muted="muted" poster="'.get_template_directory_uri().'/img/video-bg.jpg">
                    <source src="'.$st_media.'" type="video/webm" />
                    <source src="'.$st_media.'" type="video/mp4" />
                </video>';
    }

}

if($row_fullwidth == "yes")
{
    $output.="<div class='container-fluid'> ";

}else
{
    $output.="<div class='container '>";
}

$output.="<div class='row'>";

$output .= wpb_js_remove_wpautop($content);

$output.="</div><!--End .row-->";

$output.="</div><!--End .container-->";




$output .= '</div>';


$output.$this->endBlockComment('row');

$st_row_fullwidth=0;

echo balanceTags($output);