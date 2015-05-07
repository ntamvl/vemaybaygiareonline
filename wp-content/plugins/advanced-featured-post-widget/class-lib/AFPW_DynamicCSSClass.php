<?php

/**
 *
 * Class AFPW Dynamic CSS
 *
 * Extending A5 Dynamic Files
 *
 * Presses the dynamical CSS of the Advanced Featured Post Widget into a virtual style sheet
 *
 */

class AFPW_DynamicCSS extends A5_DynamicFiles {
	
	private static $options;
	
	function __construct() {
		
		self::$options = get_option('afpw_options');
		
		if (!isset(self::$options['inline'])) self::$options['inline'] = false;
		
		if (!isset(self::$options['priority'])) self::$options['priority'] = false;
		
		if (!array_key_exists('compress', self::$options)) self::$options['compress'] = false;
		
		parent::A5_DynamicFiles('wp', 'css', 'all', false, self::$options['inline'], self::$options['priority']);
		
		$eol = (self::$options['compress']) ? '' : "\r\n";
		$tab = (self::$options['compress']) ? '' : "\t";
		
		$css_selector = 'widget_advanced_featured_post_widget[id^="advanced_featured_post_widget"]';
		
		parent::$wp_styles .= (!self::$options['compress']) ? $eol.'/* CSS portion of the Advanced Featured Post Widget */'.$eol.$eol : '';
		
		$style = str_replace('; ', ';'.$eol.$tab, str_replace(array("\r\n", "\n", "\r"), ' ', self::$options['css']));
			
		parent::$wp_styles .= parent::build_widget_css($css_selector, '').'{'.$eol.$tab.$style.$eol.'}'.$eol;
		
		parent::$wp_styles .= parent::build_widget_css($css_selector, 'img').'{'.$eol.$tab.'height: auto;'.$eol.$tab.'max-width: 100%;'.$eol.'}'.$eol;
		
		if (!empty (self::$options['link'])) :
		
			$style=str_replace('; ', ';'.$eol.$tab, str_replace(array("\r\n", "\n", "\r"), ' ', self::$options['link']));
		
			parent::$wp_styles .= parent::build_widget_css($css_selector, 'a').'{'.$eol.$tab.$style.$eol.'}'.$eol;
			
		endif;
		
		if (!empty (self::$options['hover'])) :
		
			$style=str_replace('; ', ';'.$eol.$tab, str_replace(array("\r\n", "\n", "\r"), ' ', self::$options['hover']));
		
			parent::$wp_styles .= parent::build_widget_css($css_selector, 'a:hover').'{'.$eol.$tab.$style.$eol.'}'.$eol;
			
		endif;

	}
	
} // AFPW_Dynamic CSS

?>