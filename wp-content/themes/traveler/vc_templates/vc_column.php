<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Custom vc column
 *
 * Created by ShineTheme
 *
 */
$output = $font_color = $el_class = $width = $offset = '';
extract(shortcode_atts(array(
    'font_color'      => '',
    'el_class' => '',
    'width' => '1/1',
    'css' => '',
    'offset' => '',
    'data_effect'=>''
), $atts));

$class_effect="";
if($data_effect !=""){
    $class_effect = " wow ".$data_effect." ";
}

$el_class = $this->getExtraClass($el_class);
$width = wpb_translateColumnWidthToSpan($width);
$width = vc_column_offset_class_merge($offset, $width);
$el_class .= ' wpb_column vc_column_container';
$style = $this->buildStyle( $font_color );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );


$output .= "\n\t".'<div class="'.$css_class.$class_effect.'"'.$style.'>';

$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);

$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo balanceTags($output);