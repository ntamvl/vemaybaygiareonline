<?php
/*
Plugin Name: Advanced Featured Post Widget
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/advanced-featured-post-widget
Description: The Advanced Featured Post Widget is yet another plugin to make your blog a bit more newspaper-like. Just by choosing a post from the dropdown menu, you can put it in the 'featured' area and display thumbnail, headline, excerpt or all three of them (if available) in the fully customizable widget. It just has more options than the the Featured Post Widget.
Version: 3.4.1
Author: Waldemar Stoffel
Author URI: http://www.waldemarstoffel.com
License: GPL3
Text Domain: advanced-fpw
*/

/*  Copyright 2011 - 2014  Waldemar Stoffel  (email : stoffel@atelier-fuenf.de)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/


/* Stop direct call */

defined('ABSPATH') OR exit;

if (!defined('AFPW_PATH')) define( 'AFPW_PATH', plugin_dir_path(__FILE__) );
if (!defined('AFPW_BASE')) define( 'AFPW_BASE', plugin_basename(__FILE__) );

# loading the framework
if (!class_exists('A5_Image')) require_once AFPW_PATH.'class-lib/A5_ImageClass.php';
if (!class_exists('A5_Excerpt')) require_once AFPW_PATH.'class-lib/A5_ExcerptClass.php';
if (!class_exists('A5_FormField')) require_once AFPW_PATH.'class-lib/A5_FormFieldClass.php';
if (!class_exists('A5_OptionPage')) require_once AFPW_PATH.'class-lib/A5_OptionPageClass.php';
if (!class_exists('A5_DynamicFiles')) require_once AFPW_PATH.'class-lib/A5_DynamicFileClass.php';

#loading plugin specific classes
if (!class_exists('AFPW_Admin')) require_once AFPW_PATH.'class-lib/AFPW_AdminClass.php';
if (!class_exists('AFPW_DynamicCSS')) require_once AFPW_PATH.'class-lib/AFPW_DynamicCSSClass.php';
if (!class_exists('Advanced_Featured_Post_Widget')) require_once AFPW_PATH.'class-lib/AFPW_WidgetClass.php';

class Advanced_FPW {
	
	const language_file = 'advanced-fpw', version = 3.4;
	
	private static $options;
	
	function __construct() {
		
		self::$options = get_option('afpw_options');
		
		if (self::version != self::$options['version']) $this->_update_options();
		
		// Load language files
	
		load_plugin_textdomain(self::language_file, false , basename(dirname(__FILE__)).'/languages');
		
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		
		add_filter('plugin_row_meta', array($this, 'register_links'), 10, 2);	
		add_filter('plugin_action_links', array($this, 'plugin_action_links'), 10, 2);
		
		register_activation_hook(  __FILE__, array($this, '_install') );
		register_deactivation_hook(  __FILE__, array($this, '_uninstall') );
		
		$AFPW_DynamicCSS = new AFPW_DynamicCSS();
		$AFPW_Admin = new AFPW_Admin();
		
	}

	/* attach JavaScript file for textarea resizing */
	
	function enqueue_scripts($hook) {
		
		if ($hook != 'settings_page_advanced-fpw-settings' && $hook != 'widgets.php' && $hook != 'post.php') return;
		
		$min = (WP_DEBUG == false) ? '.min.' : '.';
		
		wp_register_script('ta-expander-script', plugins_url('ta-expander'.$min.'js', __FILE__), array('jquery'), '3.0', true);
		wp_enqueue_script('ta-expander-script');
	
	}
	
	//Additional links on the plugin page
	
	function register_links($links, $file) {
		
		if ($file == AFPW_BASE) :
			
			$links[] = '<a href="http://wordpress.org/extend/plugins/advanced-featured-post-widget/faq/" target="_blank">'.__('FAQ', self::language_file).'</a>';
			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4P2ACVGPHY7WU" target="_blank">'.__('Donate', self::language_file).'</a>';
		
		endif;
		
		return $links;
	
	}
	
	function plugin_action_links( $links, $file ) {
		
		if ($file == AFPW_BASE) array_unshift($links, '<a href="'.admin_url( 'options-general.php?page=advanced-fpw-settings' ).'">'.__('Settings', self::language_file).'</a>');
	
		return $links;
	
	}
	
	// Creating default options on activation
	
	static function _install() {
		
		$default = array(
			'version' => self::version,
			'cache' => array(),
			'inline' => false,
			'compress' => false,
			'css' => "-moz-hyphens: auto;\n-o-hyphens: auto;\n-webkit-hyphens: auto;\n-ms-hyphens: auto;\nhyphens: auto;"
		);
		
		add_option('afpw_options', $default);
		
	}	
	
	// Cleaning on deactivation
	
	static function _uninstall() {
		
		delete_option('afpw_options');
		
	}
	
	// updating options in case they are outdated
	
	function _update_options() {
		
		$options_old = get_option('afpw_options');
		
		$options_new['css'] = (isset($options_old['afpw_css'])) ? $options_old['acc_css'] : '';
		
		$options_new['cache'] = array();
		
		$options_new['inline'] = (isset($options_old['inline'])) ? $options_old['inline'] : false;
		
		$options_new['compress'] = (isset($options_old['compress'])) ? $options_old['compress'] : false;
		
		$options_new['version'] = self::version;
		
		$options_new['css'] .= "-moz-hyphens: auto;\n-o-hyphens: auto;\n-webkit-hyphens: auto;\n-ms-hyphens: auto;\nhyphens: auto;".$options_new['css'];
		
		update_option('afpw_options', $options_new);
	
	}

}

$Advanced_FPW = new Advanced_FPW;

?>