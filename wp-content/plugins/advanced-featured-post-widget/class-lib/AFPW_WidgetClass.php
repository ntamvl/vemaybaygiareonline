<?php

/**
 *
 * Class AFPW Widget
 *
 * @ Advanced Featured Post Widget
 *
 * building the actual widget
 *
 */
class Advanced_Featured_Post_Widget extends WP_Widget {
	
	const language_file = 'advanced-fpw';
	
	private static $options;
	
	function Advanced_Featured_Post_Widget() {
		 
		$widget_opts = array( 'description' => __('You can feature a certain post in this widget and display it, where and however you want, in your widget areas. A backup post can be given to avoid dubble content. Define, on what pages the widget will show.', self::language_file) );
		 
		$control_opts = array( 'width' => 400 );
		 
		parent::WP_Widget(false, $name = 'Advanced Featured Post', $widget_opts, $control_opts);
		
		self::$options = get_option('afpw_options');
		 
	 }
	 
	function form($instance) {
		
	// setup some default settings
		
		$defaults = array(
			'title' => NULL,
			'article' => NULL,
			'backup' => NULL,
			'id' => NULL,
			'bid' => NULL,
			'image' => NULL,
			'width' => get_option('thumbnail_size_w'),
			'headline' => NULL,
			'h' => 3,
			'excerpt' => NULL,
			'linespace' => false,
			'notext' => false,
			'noshorts' => false,
			'readmore' => false,
			'rmtext' => NULL,
			'thumb' => false,
			'style' => NULL,
			'homepage' => true,
			'frontpage' => false,
			'page' => false, 
			'category' => true,
			'single' => false,
			'date' => false,
			'archive' => false,
			'tag' => false,
			'attachment' => false,
			'taxonomy' => false,
			'author' => false,
			'search' => false,
			'not_found' => false,
			'login_page' => false,
			'class' => NULL,
			'filter' => false,
			'showcat' => NULL,
			'showcat_txt'=> NULL,
			'imgborder' => NULL,
			'fullpost' => false,
			'wordcount' => 3,
			'words' => false
		);
		
		$instance = wp_parse_args( $instance, $defaults );
		
		$title = esc_attr($instance['title']);
		$thumb = esc_attr($instance['thumb']);
		$image = esc_attr($instance['image']);
		$article = esc_attr($instance['article']);
		$backup = esc_attr($instance['backup']);
		$width = esc_attr($instance['width']);
		$headline = esc_attr($instance['headline']);	
		$excerpt = esc_attr($instance['excerpt']);
		$linespace = esc_attr($instance['linespace']);
		$notext = esc_attr($instance['notext']);
		$noshorts = esc_attr($instance['noshorts']);
		$readmore = esc_attr($instance['readmore']);
		$rmtext = esc_attr($instance['rmtext']);
		$style = esc_attr($instance['style']);
		$homepage=esc_attr($instance['homepage']);
		$frontpage=esc_attr($instance['frontpage']);
		$page=esc_attr($instance['page']);
		$category=esc_attr($instance['category']);
		$single=esc_attr($instance['single']);
		$date=esc_attr($instance['date']);
		$archive=esc_attr($instance['archive']);
		$tag=esc_attr($instance['tag']);
		$attachment=esc_attr($instance['attachment']);
		$taxonomy=esc_attr($instance['taxonomy']);
		$author=esc_attr($instance['author']);
		$search=esc_attr($instance['search']);
		$not_found=esc_attr($instance['not_found']);
		$login_page=esc_attr($instance['login_page']);
		$h=esc_attr($instance['h']);
		$class=esc_attr($instance['class']);
		$filter=esc_attr($instance['filter']);
		$id=esc_attr($instance['id']);
		$bid=esc_attr($instance['bid']);
		$showcat = esc_attr($instance['showcat']);
		$showcat_txt = esc_attr($instance['showcat_txt']);
		$imgborder = esc_attr($instance['imgborder']);
		$fullpost = esc_attr($instance['fullpost']);
		$wordcount = esc_attr($instance['wordcount']);
		$words = esc_attr($instance['words']);
		
		$args = array(
			'posts_per_page' => -1,
			'post_status' => 'publish'
		);
		
		$features = get_posts($args);
		foreach ( $features as $feature ) :
		
			$posts[] = array($feature->ID, $feature->post_title );
		
		endforeach;
		
		$base_id = 'widget-'.$this->id_base.'-'.$this->number.'-';
		$base_name = 'widget-'.$this->id_base.'['.$this->number.']';
		
		$pages = array (
				array($base_id.'homepage', $base_name.'[homepage]', $homepage, __('Homepage', self::language_file)),
				array($base_id.'frontpage', $base_name.'[frontpage]', $frontpage, __('Frontpage (e.g. a static page as homepage)', self::language_file)),
				array($base_id.'page', $base_name.'[page]', $page, __('&#34;Page&#34; pages', self::language_file)),
				array($base_id.'category', $base_name.'[category]', $category, __('Category pages', self::language_file)),
				array($base_id.'single', $base_name.'[single]', $single, __('Single post pages', self::language_file)),
				array($base_id.'date', $base_name.'[date]', $date, __('Archive pages', self::language_file)),
				array($base_id.'archive', $base_name.'[archive]', $archive, __('Post type archives', self::language_file)),
				array($base_id.'tag', $base_name.'[tag]', $tag, __('Tag pages', self::language_file)),
				array($base_id.'attachment', $base_name.'[attachment]', $attachment, __('Attachments', self::language_file)),
				array($base_id.'taxonomy', $base_name.'[taxonomy]', $taxonomy, __('Custom Taxonomy pages (only available, if having a plugin)', self::language_file)),
				array($base_id.'author', $base_name.'[author]', $author, __('Author pages', self::language_file)),
				array($base_id.'search', $base_name.'[search]', $search, __('Search Results', self::language_file)),
				array($base_id.'not_found', $base_name.'[not_found]', $not_found, __('&#34;Not Found&#34;', self::language_file)),
				array($base_id.'login_page', $base_name.'[login_page]', $login_page, __('Login page (only available, if having a plugin)', self::language_file)),
		);
			
		$checkall = array($base_id.'checkall', $base_name.'[checkall]', __('Check all', self::language_file));
		
		$headings = array(array('1', 'h1'), array('2', 'h2'), array('3', 'h3'), array('4', 'h4'), array('5', 'h5'), array('6', 'h6'));
			
		$options = array (array('top', __('Above thumbnail', self::language_file)) , array('bottom', __('Under thumbnail', self::language_file)), array('none', __('Don&#39;t show title', self::language_file)));
		
		a5_text_field($base_id.'title', $base_name.'[title]', $title, __('Title:', self::language_file), array('space' => true, 'class' => 'widefat'));
		a5_select($base_id.'article', $base_name.'[article]', $posts, $article, __('Choose here the post, you want to appear in the widget.', self::language_file), __('Take a random post', self::language_file), array('space' => true, 'class' => 'widefat'));
		a5_select($base_id.'backup', $base_name.'[backup]',$posts,  $backup, __('Choose here the backup post. It will appear, when a single post page shows the featured article.', self::language_file), __('Take a random post', self::language_file), array('space' => true, 'class' => 'widefat'));
		a5_number_field($base_id.'id', $base_name.'[id]', $id, __('Post ID (if you want a custom post type or simply don&#39;t want to use the dropdown menu):', self::language_file), array('space' => true, 'size' => 4, 'step' => 1));
		a5_number_field($base_id.'bid', $base_name.'[bid]', $bid, __('ID for backup post (if you want a custom post type or simply you don&#39;t want to use the dropdown menu):', self::language_file), array('space' => true, 'size' => 4, 'step' => 1));
		a5_checkbox($base_id.'showcat', $base_name.'[showcat]', $showcat, __('Check to show the categories in which the post is filed.', self::language_file), array('space' => true));
		a5_text_field($base_id.'showcat_txt', $base_name.'[showcat_txt]', $showcat_txt, __('Give some text that you want in front of the post&#39;s categtories (i.e &#39;filed under&#39;:', self::language_file), array('space' => true, 'class' => 'widefat'));
		a5_checkbox($base_id.'image', $base_name.'[image]', $image, __('Check to get the first image of the post as thumbnail.', self::language_file), array('space' => true));
		a5_number_field($base_id.'width', $base_name.'[width]', $width, __('Width of the thumbnail (in px):', self::language_file), array('space' => true, 'size' => 4, 'step' => 1));
		a5_text_field($base_id.'imgborder', $base_name.'[imgborder]', $imgborder, sprintf(__('If wanting a border around the image, write the style here. %s would make it a black border, 1px wide.', self::language_file), '<strong>1px solid #000000</strong>'), array('space' => true, 'class' => 'widefat'));
		a5_checkbox($base_id.'thumb', $base_name.'[thumb]', $thumb, sprintf(__('Check to %snot%s display the thumbnail of the post.', self::language_file), '<strong>', '</strong>'), array('space' => true));
		a5_select($base_id.'headline', $base_name.'[headline]', $options, $headline, __('Choose, whether or not to display the title and whether it comes above or under the thumbnail.', self::language_file), false, array('space' => true));
		a5_select($base_id.'h', $base_name.'[h]', $headings, $h, __('Weight of the Post Title:', self::language_file), false, array('space' => true));
		a5_textarea($base_id.'excerpt', $base_name.'[excerpt]', $excerpt, __('If the excerpt of the post is not defined, by default the first 3 sentences of the post are shown. You can enter your own excerpt here, if you want.', self::language_file), array('space' => true, 'class' => 'widefat', 'style' => 'height: 60px;'));
		a5_number_field($base_id.'wordcount', $base_name.'[wordcount]', $wordcount, __('In case there is no excerpt defined, how many sentences are displayed:', self::language_file), array('space' => true, 'size' => 4, 'step' => 1));
		a5_checkbox($base_id.'words', $base_name.'[words]', $words, __('Check to display words instead of sentences.', self::language_file), array('space' => true));
		a5_checkbox($base_id.'fullpost', $base_name.'[fullpost]', $fullpost, __('Check to display the full post instead of an excerpt.', self::language_file), array('space' => true));
		a5_checkbox($base_id.'linespace', $base_name.'[linespace]', $linespace, __('Check to have each sentence in a new line.', self::language_file), array('space' => true));
		a5_checkbox($base_id.'notext', $base_name.'[notext]', $notext, sprintf(__('Check to %snot%s display the excerpt.', self::language_file), '<strong>', '</strong>'), array('space' => true));
		a5_checkbox($base_id.'noshorts', $base_name.'[noshorts]', $noshorts, __('Check to suppress shortcodes in the widget (in case the content is showing).', self::language_file), array('space' => true));
		a5_checkbox($base_id.'filter', $base_name.'[filter]', $filter, __('Check to return the excerpt unfiltered (might avoid interferences with other plugins).', self::language_file), array('space' => true));
		a5_checkbox($base_id.'readmore', $base_name.'[readmore]', $readmore, __('Check to have an additional &#39;read more&#39; link at the end of the excerpt.', self::language_file), array('space' => true));
		a5_text_field($base_id.'rmtext', $base_name.'[rmtext]', $rmtext, sprintf(__('Write here some text for the &#39;read more&#39; link. By default, it is %s:', self::language_file), '[&#8230;]'), array('space' => true, 'class' => 'widefat'));
		a5_text_field($base_id.'class', $base_name.'[class]', $class, __('If you want to style the &#39;read more&#39; link, you can enter a class here.', self::language_file), array('space' => true, 'class' => 'widefat'));	
		a5_checkgroup(false, false, $pages, __('Check, where you want to show the widget. By default, it is showing on the homepage and the category pages:', self::language_file), $checkall);
		a5_textarea($base_id.'style', $base_name.'[style]', $style, sprintf(__('Here you can finally style the widget. Simply type something like%1$s%2$sborder: 2px solid;%2$sborder-color: #cccccc;%2$spadding: 10px;%3$s%2$sto get just a gray outline and a padding of 10 px. If you leave that section empty, your theme will style the widget.', self::language_file), '<strong>', '<br />', '</strong>'), array('space' => true, 'class' => 'widefat', 'style' => 'height: 60px;'));
		a5_resize_textarea(array($base_id.'excerpt', $base_id.'style'), true);
	
	}
	 
	function update($new_instance, $old_instance) {
		 
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['article'] = strip_tags($new_instance['article']);
		$instance['backup'] = strip_tags($new_instance['backup']);	 
		$instance['thumb'] = @$new_instance['thumb'];	 
		$instance['image'] = @$new_instance['image'];	 
		$instance['width'] = strip_tags($new_instance['width']);	 
		$instance['headline'] = strip_tags($new_instance['headline']);
		$instance['excerpt'] = strip_tags($new_instance['excerpt']);
		$instance['linespace'] = @$new_instance['linespace'];
		$instance['notext'] = @$new_instance['notext'];
		$instance['noshorts'] = @$new_instance['noshorts'];
		$instance['readmore'] =@$new_instance['readmore'];
		$instance['rmtext'] = strip_tags($new_instance['rmtext']);
		$instance['style'] = strip_tags($new_instance['style']);
		$instance['homepage'] = @$new_instance['homepage'];
		$instance['frontpage'] = @$new_instance['frontpage'];
		$instance['page'] = @$new_instance['page'];
		$instance['category'] = @$new_instance['category'];
		$instance['single'] = @$new_instance['single'];
		$instance['date'] = @$new_instance['date'];
		$instance['archive'] = @$new_instance['archive']; 
		$instance['tag'] = @$new_instance['tag'];
		$instance['attachment'] = @$new_instance['attachment'];
		$instance['taxonomy'] = @$new_instance['taxonomy'];
		$instance['author'] = @$new_instance['author'];
		$instance['search'] = @$new_instance['search'];
		$instance['not_found'] = @$new_instance['not_found'];
		$instance['login_page'] = @$new_instance['login_page'];
		$instance['h'] = strip_tags($new_instance['h']);
		$instance['class'] = strip_tags($new_instance['class']);
		$instance['filter'] = @$new_instance['filter'];
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['bid'] = strip_tags($new_instance['bid']);
		$instance['showcat'] = @$new_instance['showcat'];
		$instance['showcat_txt'] = strip_tags($new_instance['showcat_txt']);
		$instance['imgborder'] = strip_tags($new_instance['imgborder']);
		$instance['fullpost'] = @$new_instance['fullpost'];
		$instance['wordcount'] = strip_tags($new_instance['wordcount']);
		$instance['words'] = @$new_instance['words'];
		
		return $instance;
	}
	
	function widget($args, $instance) {
		
		// get the type of page, we're actually on
		
		if (is_front_page()) $pagetype='frontpage';
		if (is_home()) $pagetype='homepage';
		if (is_page()) $pagetype='page';
		if (is_category()) $pagetype='category';
		if (is_single()) $pagetype='single';
		if (is_date()) $pagetype='date';
		if (is_archive()) $pagetype='archive';
		if (is_tag()) $pagetype='tag';
		if (is_attachment()) $pagetype='attachment';
		if (is_tax()) $pagetype='taxonomy';
		if (is_author()) $pagetype='author';
		if (is_search()) $pagetype='search';
		if (is_404()) $pagetype='not_found';
		if (!isset($pagetype)) $pagetype='login_page';
		
		// display only, if said so in the settings of the widget
		
		if ($instance[$pagetype]) :
		
			$eol = "\r\n";
			
			// the widget is displayed	
			extract( $args );
			
			$title = apply_filters('widget_title', $instance['title']);
			
			if (!empty($instance['style'])) :
			
				$style=str_replace(array("\r\n", "\n", "\r"), '', $instance['style']);
				
				$before_widget = str_replace('>', 'style="'.$style.'">', $before_widget);
			
			endif;
				
			// widget starts
			
			echo $before_widget.$eol;
			
			if ( $title ) echo $before_title . $title . $after_title . $eol;
			
			global $wp_query;
			
			$article = ($instance['id']) ? $instance['id'] : $instance['article'];
			$backup = ($instance['bid']) ? $instance['bid'] : $instance['backup'];
				
			$afpw_post_id = get_post($article);
			$afpw_post_name = $afpw_post_id->post_name;
			
			$afpw_post = ($article == $wp_query->get( 'p' ) || $afpw_post_name == $wp_query->get ( 'name' )) ? 'post_type=any&p='.$backup : 'post_type=any&p='.$article;
				
			if ($afpw_post=='post_type=any&p=') $afpw_post = 'posts_per_page=1&orderby=rand';
		 
			/* This is the actual function of the plugin, it fills the widget with the customized post */
		
			global $post;
			
			$afpw_posts = new WP_Query($afpw_post);
			
			while($afpw_posts->have_posts()) :
			
				$afpw_posts->the_post();
				
				if ($instance['showcat']) :
					
					$post_byline = ($instance['showcat_txt']) ? $eol.'<p id="afpw_byline-'.$widget_id.'">'.$eol.$instance['showcat_txt'].' ' : $eol.'<p id="afpw_byline-'.$widget_id.'">';
					
					echo $post_byline;
				
					the_category(', ');
				
					echo $eol.'</p>'.$eol;
				
				endif;
		 
				$afpw_tags = A5_Image::tags(self::language_file);
				
				$afpw_image_alt = $afpw_tags['image_alt'];
				$afpw_image_title = $afpw_tags['image_title'];
				$afpw_title_tag = $afpw_tags['title_tag'];
				
				// headline, if wanted
				
				if ($instance['headline'] != 'none') :
				
					$afpw_options = get_option('afpw_options');
			
					$afpw_headline = '<h'.$instance['h'].'>'.$eol.'<a href="'.get_permalink().'" title="'.$afpw_title_tag.'">'.get_the_title().'</a>'.$eol.'</h'.$instance['h'].'>';
					
				endif;
				
				// thumbnail, if wanted
			
				if (!$instance['thumb']) :
				
					$afpw_imgborder = (!empty($instance['imgborder'])) ? ' style="border: '.$instance['imgborder'].';"' : '';
					
					$id = get_the_ID();
					
					$number = ($instance['image']) ? $instance['image'] : NULL;
					
					$args = array (
						'id' => $id,
						'option' => 'afpw_options',
						'width' => $instance['width'],
						'number' => $number
					);	
				   
					$afpw_image_info = A5_Image::thumbnail($args);
					
					$afpw_thumb = $afpw_image_info[0];
					
					$afpw_width = $afpw_image_info[1];
			
					$afpw_height = ($afpw_image_info[2]) ? ' height="'.$afpw_image_info[2].'"' :'';
					
					if ($afpw_thumb) $afpw_img_tag = '<img title="'.$afpw_image_title.'" src="'.$afpw_thumb.'" alt="'.$afpw_image_alt.'" class="wp-post-image" width="'.$afpw_width.'"'.$afpw_height.$afpw_imgborder.' />';
						
					if (!empty($afpw_img_tag)) $afpw_image = '<a href="'.get_permalink().'">'.$afpw_img_tag.'</a>'.$eol.'<div style="clear: both;"></div>'.$eol;
					
				endif;
				
				// excerpt if wanted
				
				if (!$instance['notext']) :
				
					$rmtext = ($instance['rmtext']) ? $instance['rmtext'] : '[&#8230;]';
					
					$shortcode = ($instance['noshorts']);
					
					$filter = ($instance['filter']) ? false : true;
				
					$args = array(
						'usertext' => $instance['excerpt'],
						'excerpt' => $post->post_excerpt,
						'content' => $post->post_content,
						'shortcode' => $shortcode,
						'count' => $instance['wordcount'],
						'linespace' => $instance['linespace'],
						'link' => get_permalink(),
						'title' => $afpw_title_tag,
						'readmore' => $instance['readmore'],
						'rmtext' => $rmtext,
						'class' => $instance['class'],
						'filter' => $filter
					);
					
					if (!empty($instance['fullpost'])) $args['type'] = 'post';
					
					if (!empty($instance['words'])) $args['type'] = 'words';
			
					$afpw_text = A5_Excerpt::text($args);
				
				endif;
				
				// writing the stuff in the widget
				
				if ($instance['headline'] == 'top') echo $afpw_headline.$eol;
				
				if (!$instance['thumb'] && isset($afpw_image)) echo $afpw_image;
				
				if ($instance['headline'] == 'bottom') echo $afpw_headline.$eol;
				
				if (!$instance['notext']) echo do_shortcode($afpw_text).$eol;
				
			endwhile;
				
			// Restore original Query & Post Data
			wp_reset_query();
			wp_reset_postdata();
		
			echo $after_widget.$eol;
				
		else:
	
			echo "<!-- Advanced Featured Post Widget is not setup for this view. -->";
		 
		endif;
	
	} // widget
 
} // Advanced Featured Post Widget

add_action('widgets_init', create_function('', 'return register_widget("Advanced_Featured_Post_Widget");'));

?>