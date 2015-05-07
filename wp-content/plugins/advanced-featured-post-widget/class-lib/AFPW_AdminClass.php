<?php

/**
 *
 * Class Advanced Featured Post Widget Admin
 *
 * @ A5 Advanced Featured Post Widget
 *
 * building admin page
 *
 */
class AFPW_Admin extends A5_OptionPage {
	
	const language_file = 'advanced-fpw';
	
	static $options;
	
	function __construct() {
	
		add_action('admin_init', array($this, 'initialize_settings'));
		add_action('admin_menu', array($this, 'add_admin_menu'));
		if (WP_DEBUG == true) add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		
		self::$options = get_option('afpw_options');
		
	}
	
	/**
	 *
	 * Make debug info collapsable
	 *
	 */
	function enqueue_scripts($hook){
		
		if ($hook != 'settings_page_advanced-fpw-settings') return;
		
		wp_enqueue_script('dashboard');
		
		if (wp_is_mobile()) wp_enqueue_script('jquery-touch-punch');
		
	}
	
	/**
	 *
	 * Add options-page for single site
	 *
	 */
	function add_admin_menu() {
		
		add_options_page('Advanced FP '.__('Settings', self::language_file), '<img alt="" src="'.plugins_url('advanced-featured-post-widget/img/a5-icon-11.png').'"> Advanced Featured Post Widget', 'administrator', 'advanced-fpw-settings', array($this, 'build_options_page'));
		
	}
	
	/**
	 *
	 * Actually build the option pages
	 *
	 */
	function build_options_page() {
		
		$eol = "\r\n";
		
		parent::open_page('Advanced Featured Post Widget', __('http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/advanced-featured-post-widget', self::language_file), 'advanced-featured-post-widget', __('Plugin Support', self::language_file));
		
		_e('Style the links of the widget. If you leave this empty, your theme will style the hyperlinks.', self::language_file);
		
        echo '<p>'.__('Just input something like,', self::language_file).'</p>'.$eol.'<p><strong>font-weight: bold;<br />'.$eol.'color: #0000ff;<br />';
		
		echo 'text-decoration: underline;'.$eol.'</strong></p>'.$eol.__('to get fat, blue, underlined links.', self::language_file).$eol.'</p>'.$eol;
		
		echo '<p><strong>'.__('You most probably have to use &#39;!important&#39; at the end of each line, to make it work.', self::language_file).'</strong></p>'.$eol;
		
		parent::open_form('options.php');
		
		settings_fields('afpw_options');
		do_settings_sections('afpw_styles');
		submit_button();
		
		if (WP_DEBUG === true) :
		
			self::open_tab();
			
			self::sortable('deep-down', self::debug_info(self::$options, __('Debug Info', self::language_file)));
		
			self::close_tab();
		
		endif;
		
		parent::close_page();
		
	}
	
	/**
	 *
	 * Initialize the admin screen of the plugin
	 *
	 */
	function initialize_settings() {
		
		register_setting( 'afpw_options', 'afpw_options', array($this, 'validate') );
		
		add_settings_section('afpw_settings', __('Styling of the links', self::language_file), array($this, 'display_section'), 'afpw_styles');
		
		add_settings_field('afpw_link_style', __('Link style:', self::language_file), array($this, 'link_field'), 'afpw_styles', 'afpw_settings');
		
		add_settings_field('afpw_hover_style', __('Hover style:', self::language_file), array($this, 'hover_field'), 'afpw_styles', 'afpw_settings');
		
		add_settings_field('afpw_css', __('Widget container:', self::language_file), array($this, 'css_field'), 'afpw_styles', 'afpw_settings', array(__('You can enter your own style for the widgets here. This will overwrite the styles of your theme.', self::language_file), __('If you leave this empty, you can still style every instance of the widget individually.', self::language_file)));
		
		add_settings_field('afpw_compress', __('Compress Style Sheet:', self::language_file), array($this, 'compress_field'), 'afpw_styles', 'afpw_settings', array(__('Click here to compress the style sheet.', self::language_file)));
		
		add_settings_field('afpw_inline', __('Debug:', self::language_file), array($this, 'inline_field'), 'afpw_styles', 'afpw_settings', array(__('If you can&#39;t reach the dynamical style sheet, you&#39;ll have to display the styles inline. By clicking here you can do so.', self::language_file)));
		
		if (self::$options['inline']) add_settings_field('afpw_priority', __('Priority of the inline style:', self::language_file), array($this, 'priority_field'), 'afpw_styles', 'afpw_settings', array(__('This only affects inline styles. Some other plugins could be using the same selectors as this one. In that case, writing your&#39;s later in the code might help.', self::language_file)));
		
		$cachesize = count(self::$options['cache']);
		
		$entry = ($cachesize > 1) ? __('entries', self::language_file) : __('entry', self::language_file);
		
		if ($cachesize > 0) add_settings_field('afpw_reset', sprintf(__('Empty cache (%d %s):', self::language_file), $cachesize, $entry), array($this, 'reset_field'), 'afpw_styles', 'afpw_settings', array(__('You can empty the plugin&#39;s cache here, if necessary.', self::language_file)));
		
		add_settings_field('afpw_resize', false, array($this, 'resize_field'), 'afpw_styles', 'afpw_settings');
	
	}
	
	function display_section() {
		
		echo '<p>'.__('Just put some css code here.', self::language_file).'</p>';
	
	}
	
	function link_field() {
		
		a5_textarea('link', 'afpw_options[link]', @self::$options['link'], false, array('cols' => 35, 'rows' => 3));
		
	}
	
	function hover_field() {
		
		a5_textarea('hover', 'afpw_options[hover]', @self::$options['hover'], false, array('cols' => 35, 'rows' => 3));
		
	}
	
	function css_field($labels) {
		
		echo $labels[0].'<br />'.$labels[1].'<br />';
		
		a5_textarea('css', 'afpw_options[css]', @self::$options['css'], false, array('rows' => 7, 'cols' => 35));
		
	}
	
	function compress_field($labels) {
		
		a5_checkbox('compress', 'afpw_options[compress]', @self::$options['compress'], $labels[0]);
		
	}
	
	function inline_field($labels) {
		
		a5_checkbox('inline', 'afpw_options[inline]', @self::$options['inline'], $labels[0]);
		
	}
	
	function priority_field($labels) {
		
		echo $labels[0].'<br />';
		
		a5_number_field('priority', 'afpw_options[priority]', @self::$options['priority'], false, array('step' => 10, 'min' => 0));
		
	}
	
	function reset_field($labels) {
		
		a5_checkbox('reset_options', 'afpw_options[reset_options]', @self::$options['reset_options'], $labels[0]);
		
	}
	
	function resize_field() {
		
		a5_resize_textarea(array('link', 'hover', 'css'));
		
	}
		
	function validate($input) {
		
		self::$options['link'] = trim($input['link']);
		self::$options['hover'] = trim($input['hover']);
		self::$options['css'] = trim($input['css']);
		self::$options['compress'] = isset($input['compress']) ? true : false;
		self::$options['inline'] = isset($input['inline']) ? true : false;
		self::$options['priority'] = isset($input['priority']) ? trim($input['priority']) : false;
		
		if (isset($input['reset_options'])) :
		
			self::$options['cache'] = array();
			
			add_settings_error('afpw_options', 'empty-cache', __('Cache emptied.', self::language_file), 'updated');
			
		endif;
		
		return self::$options;
	
	}

} // end of class

?>