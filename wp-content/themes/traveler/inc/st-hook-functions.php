<?php
    /**
     * @package WordPress
     * @subpackage Traveler
     * @since 1.0
     *
     * List all hook function
     *
     * Created by ShineTheme
     *
     */
    if (!function_exists('bravo_setup_theme')) :
        function st_setup_theme()
        {

            add_role('partner', 'Partner', array(
                'read'                    => true,  // true allows this capability
                'delete_posts'            => true,  // true allows this capability
                'edit_posts'              => true,  // true allows this capability
                'edit_published_posts'    => true,
                'upload_files'            => true,
                'delete_published_posts'  => true,
                'manage_options'          => false,
                'wpcf7_edit_contact_form' => false
            ));
//            remove_role('partner');
            /*
             * Make theme available for translation.
             * Translations can be filed in the /languages/ directory.
             * If you're building a theme based on stframework, use a find and replace
             * to change $st_textdomain to the name of your theme in all the template files
             */

            // Add default posts and comments RSS feed links to head.
            add_theme_support('automatic-feed-links');

            /*
             * Enable support for Post Thumbnails on posts and pages.
             *
             * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
             */
            //add_theme_support( 'post-thumbnails' );

            // This theme uses wp_nav_menu() in one location.
            register_nav_menus(array(
                'primary' => __('Primary Navigation', ST_TEXTDOMAIN),
            ));


            /*
             * Switch default core markup for search form, comment form, and comments
             * to output valid HTML5.
             */
            add_theme_support('html5', array(
                'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
            ));
            add_theme_support('custom-header', array());
            add_theme_support('custom-background', array());
            add_theme_support('woocommerce');

            /*
             * Enable support for Post Formats.
             * See http://codex.wordpress.org/Post_Formats
             */
            add_theme_support('post-thumbnails');

            add_theme_support('post-formats', array(
                'image', 'video', 'gallery', 'audio', 'quote', 'link'
            ));
            add_theme_support("title-tag");

            // Setup the WordPress core custom background feature.
//        add_theme_support( 'custom-background', apply_filters( 'stframework_custom_background_args', array(
//            'default-color' => 'ffffff',
//            'default-image' => '',
//        ) ) );
        }
    endif; // stframework_setup


    if (!function_exists('st_add_sidebar')) {
        function st_add_sidebar()
        {
            register_sidebar(array(
                'name'          => __('Blog Sidebar', ST_TEXTDOMAIN),
                'id'            => 'blog-sidebar',
                'description'   => __('Widgets in this area will be shown on all posts and pages.', ST_TEXTDOMAIN),
                'before_title'  => '<h4>',
                'after_title'   => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget'  => '</div>',
            ));

            register_sidebar(array(
                'name'          => __('Page Sidebar', ST_TEXTDOMAIN),
                'id'            => 'page-sidebar',
                'description'   => __('Widgets in this area will be shown on all  pages.', ST_TEXTDOMAIN),
                'before_title'  => '<h4>',
                'after_title'   => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget'  => '</div>',
            ));
            register_sidebar(array(
                'name'          => __('Shop Sidebar', ST_TEXTDOMAIN),
                'id'            => 'shop',
                'description'   => __('Widgets in this area will be shown on all shop page.', ST_TEXTDOMAIN),
                'before_title'  => '<h4 class="shop-widget-title">',
                'after_title'   => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget shop-widget %2$s">',
                'after_widget'  => '</div>',
            ));


        }
    }

    if (!function_exists('st_setup_author')) {

        function st_setup_author()
        {
            global $wp_query;

            if ($wp_query->is_author() && isset($wp_query->post)) {
                $GLOBALS['authordata'] = get_userdata($wp_query->post->post_author);
            }
        }

    }

    if (!function_exists('st_wp_title')) {

        function st_wp_title($title, $sep)
        {


            if (is_feed()) {
                return $title;
            }

            global $page, $paged;

            // Add the blog name
            $title .= get_bloginfo('name', 'display');

            // Add the blog description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            if ($site_description && (is_home() || is_front_page())) {
                $title .= " $sep $site_description";
            }

            // Add a page number if necessary:
            if (($paged >= 2 || $page >= 2) && !is_404()) {
                $title .= " $sep " . sprintf(__('Page %s', ST_TEXTDOMAIN), max($paged, $page));
            }


            if (is_search()) {
                $post_type = STInput::get('post_type');
                $s = STInput::get('s');
                $location_id = STInput::get('location_id');

                $extra = '';
                if (post_type_exists($post_type)) {
                    $post_type_obj = get_post_type_object($post_type);
                    $extra .= '  ' . $post_type_obj->labels->singular_name;
                }

                if ($location_id and $location_name = get_the_title($location_id)) {
                    $extra .= ' in ' . $location_name;
                }

                if ($extra) $extra = __('Search for ', ST_TEXTDOMAIN) . $extra;


                $title = $extra . $title;
            }


            return $title;

        }

    }


    if (!function_exists('st_add_scripts')) {
        function st_add_scripts()
        {

            if (is_singular()) {
                wp_enqueue_script('comment');
                wp_enqueue_script('comment-reply');

                wp_enqueue_script('st-reviews-form', get_template_directory_uri() . '/js/init/review_form.js', array('jquery'), null, true);
            }

            wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), null, true);
            wp_enqueue_script('slimmenu', get_template_directory_uri() . '/js/slimmenu.js', array('jquery'), null, true);
            wp_enqueue_script('bootstrap-datepicker.js', get_template_directory_uri() . '/js/bootstrap-datepicker.js', array('bootstrap'), null, true);
            wp_enqueue_script('bootstrap-timepicker.js', get_template_directory_uri() . '/js/bootstrap-timepicker.js', array('bootstrap'), null, true);


            wp_enqueue_script('ionrangeslider.js', get_template_directory_uri() . '/js/ionrangeslider.js', array('jquery'), null, true);
            wp_enqueue_script('icheck.js', get_template_directory_uri() . '/js/icheck.js', array('jquery'), null, true);
            wp_enqueue_script('fotorama.js', get_template_directory_uri() . '/js/fotorama.js', array('jquery'), null, true);

            wp_register_script('handlebars-v2.0.0.js', get_template_directory_uri() . '/js/handlebars-v2.0.0.js', array(), null, true);
            wp_enqueue_script('typeahead.js', get_template_directory_uri() . '/js/typeahead.js', array('jquery', 'handlebars-v2.0.0.js'), null, true);
            wp_enqueue_script('magnific.js', get_template_directory_uri() . '/js/magnific.js', array('jquery'), null, true);
            wp_enqueue_script('owl-carousel.js', get_template_directory_uri() . '/js/owl-carousel.js', array('jquery'), null, true);
            if (is_page_template('template-commingsoon.php')) {
                wp_enqueue_script('countdown.js', get_template_directory_uri() . '/js/countdown.js', array('jquery'), null, true);

            }

            wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.js', array('jquery'), null, true);

            wp_register_script('gridrotator.js', get_template_directory_uri() . '/js/gridrotator.js', array('jquery'), null, true);

            if(st_is_https()){
                wp_register_script('gmap-apiv3', 'https://maps.googleapis.com/maps/api/js?sensor=false', array(), null, true);

            }else
            {
                wp_register_script('gmap-apiv3', 'http://maps.googleapis.com/maps/api/js?sensor=false', array(), null, true);

            }
            wp_register_script('gmaplib', get_template_directory_uri() . '/js/gmap3.js', array('gmap-apiv3'), null, true);
            wp_register_script('gmap-init', get_template_directory_uri() . '/js/init/gmap.init.js', array('gmaplib'), null, true);

            wp_register_script('jquery.noty', get_template_directory_uri() . '/js/noty/packaged/jquery.noty.packaged.min.js', array('jquery'), null, true);
            wp_register_script('st.noty', get_template_directory_uri() . '/js/init/class.notice.js', array('jquery', 'jquery.noty'), null, true);


            if (is_singular()) {
                wp_enqueue_script('gmap-init');
            }


            wp_enqueue_script('hotel-ajax', get_template_directory_uri() . '/js/init/hotel-ajax.js', array('jquery'), null, true);

            wp_enqueue_script('booking_modal', get_template_directory_uri() . '/js/init/booking_modal.js', array('jquery'), null, true);
            wp_enqueue_script('chosen.jquery', get_template_directory_uri() . '/js/chosen/chosen.jquery.min.js', array('jquery'), null, true);

            wp_enqueue_script('st.noty');

            wp_enqueue_script('custom.js', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
            wp_enqueue_script('custom2.js', get_template_directory_uri() . '/js/custom2.js', array('jquery'), null, true);
            wp_enqueue_script('user.js', get_template_directory_uri() . '/js/user.js', array('jquery'), null, true);
            wp_enqueue_script('social-login.js', get_template_directory_uri() . '/js/init/social-login.js', array('jquery'), null, true);


            if (st()->get_option('gen_enable_sticky_menu', 'off') == 'on') {
                wp_enqueue_script('jquery-sticky', get_template_directory_uri() . '/js/sticky.js', array('jquery'), null, true);
            }


            if (is_page_template('template-checkout.php')) {
                wp_enqueue_script('checkout-js', get_template_directory_uri() . '/js/init/template-checkout.js', array('jquery'), null, true);

            }
            wp_localize_script('jquery', 'st_checkout_text', array(
                'without_pp'        => __('Submit Request', ST_TEXTDOMAIN),
                'with_pp'           => __('Booking Now', ST_TEXTDOMAIN),
                'validate_form'     => __('Please fill all required fields', ST_TEXTDOMAIN),
                'error_accept_term' => __('Please accept our terms and conditions', ST_TEXTDOMAIN)
            ));

            wp_localize_script('jquery', 'st_params', array(
                'theme_url'       => get_template_directory_uri(),
                'site_url'        => site_url(),
                'ajax_url'        => admin_url('admin-ajax.php'),
                'loading_url'     => admin_url('/images/wpspin_light.gif'),
                'st_search_nonce' => wp_create_nonce("st_search_security"),
                'facebook_enable' => st()->get_option('social_fb_login', 'on'),
                'facbook_app_id'  => st()->get_option('social_fb_app_id')


            ));

            if (st()->get_option('social_fb_login', 'on')) {
                //wp_enqueue_script('st-facebook',get_template_directory_uri().'/js/init/facebook.js',null,true);
            }

            //Allow turn on nicescroll
            if (st()->get_option('gen_enable_smscroll', 'off') == 'on') {
                wp_enqueue_script('nicescroll.js', get_template_directory_uri() . '/js/nicescroll.js', array('jquery'), null, true);
            }

            wp_enqueue_style('bootstrap.css', get_template_directory_uri() . '/css/bootstrap.css');
            wp_enqueue_style('animate.css', get_template_directory_uri() . '/css/animate.css');
            wp_enqueue_style('font-awesome.css', get_template_directory_uri() . '/css/font-awesome.css');


            wp_enqueue_style('icomoon.css', get_template_directory_uri() . '/css/icomoon.css');
            wp_enqueue_style('weather-icons.css', get_template_directory_uri() . '/css/weather-icons.min.css');
            wp_enqueue_style('styles.css', get_template_directory_uri() . '/css/styles.css');
            wp_enqueue_style('mystyles.css', get_template_directory_uri() . '/css/mystyles.css');
            wp_enqueue_style('tooltip-classic.css', get_template_directory_uri() . '/css/tooltip-classic.css');
            wp_enqueue_style('chosen-css', get_template_directory_uri() . '/js/chosen/chosen.min.css');

            wp_enqueue_style('default-style', get_stylesheet_uri());

            wp_enqueue_style('custom.css', get_template_directory_uri() . '/css/custom.css');
            wp_enqueue_style('custom2css', get_template_directory_uri() . '/css/custom2.css');
            wp_enqueue_style('custom-responsive', get_template_directory_uri() . '/css/custom-responsive.css');

            if (st()->get_option('right_to_left') == 'on') {
                wp_enqueue_style('rtl.css', get_template_directory_uri() . '/rtl.css');
            }

        }
    }

    if (!function_exists('bravo_add_favicon')) {
        function st_add_favicon()
        {
            $favicon = st()->get_option('favicon', get_template_directory_uri() . '/images/favicon.png');

            $ext = pathinfo($favicon, PATHINFO_EXTENSION);

            //if(strtolower($ext)=="pne")

            $type = "";

            switch (strtolower($ext)) {

                case "png":
                    $type = "image/png";
                    break;

                case "jpg":
                    $type = "image/jpg";
                    break;

                case "jpeg":
                    $type = "image/jpeg";
                    break;

                case "gif":
                    $type = "image/gif";
                    break;
            }

            echo '<link rel="icon"  type="' . esc_attr($type) . '"  href="' . esc_url($favicon) . '">';
        }
    }

    if (!function_exists('st_before_body_content')) {
        function st_before_body_content()
        {
            if (st()->get_option('gen_disable_preload') == "off") {
                ?>
                <!-- Preload -->
                <div id="bt-preload"></div>
                <!-- End Preload -->
            <?php
            }

            echo st()->get_option('adv_before_body_content');
        }
    }

    if (!function_exists('st_add_compress_html')) {
        function st_add_compress_html()
        {
            if (st()->get_option('adv_compress_html') == "on") {
                include_once st()->dir('plugins/html-compression.php');
            }
        }
    }

    if (!function_exists('st_add_ie8_support')) {
        function st_add_ie8_support()
        {
            ?>
            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        <?php
        }
    }

    if (!function_exists('st_add_custom_style')) {
        function st_add_custom_style()
        {
            get_template_part('custom-style');
        }
    }

    if (!function_exists('st_control_container')) {
        function st_control_container($is_wrap = false)
        {
            $layout = st()->get_option('style_layout');

            if (is_singular()) {
                if ($layout_meta = get_post_meta(get_the_ID(), 'style_layout', true)) {
                    $layout = $layout_meta;
                }
            }

            if ($layout == "boxed") {
                return "container";
            } else {
                return "container-fluid";
            }
        }
    }

    if (!function_exists('st_blog_sidebar')) {
        function st_blog_sidebar()
        {
            $sidebar_pos = st()->get_option('blog_sidebar_pos', 'right');


            if (is_single()) {
                if ($sidebar_pos_meta = get_post_meta(get_the_ID(), 'post_sidebar_pos', true)) {
                    $sidebar_pos = $sidebar_pos_meta;
                }
            } else if (is_page()) {

                if ($sidebar_pos_meta = get_post_meta(get_the_ID(), 'post_sidebar_pos', true)) {
                    $sidebar_pos = $sidebar_pos_meta;
                }

            }

            return $sidebar_pos;
        }

    }

    if (!function_exists('st_blog_sidebar_id')) {
        function st_blog_sidebar_id()
        {
            $sidebar_id = st()->get_option('blog_sidebar_id');


            if (is_single()) {
                if ($sidebar_id_meta = get_post_meta(get_the_ID(), 'post_sidebar', true)) {
                    $sidebar_id = $sidebar_id_meta;
                }
            } else if (is_page()) {

                if ($sidebar_id_meta = get_post_meta(get_the_ID(), 'post_sidebar', true)) {
                    $sidebar_id = $sidebar_id_meta;
                }

            }

            return $sidebar_id;
        }

    }


    if (!function_exists('st_change_comment_excerpt_limit')) {
        function st_change_comment_excerpt_limit($comment)
        {
            return TravelHelper::cutnchar($comment, 55);
        }
    }
    if (!function_exists('st_set_post_view')) {
        function st_set_post_view()
        {
            if (is_singular()) {
                $count_key = 'post_views_count';
                $count = get_post_meta(get_the_ID(), $count_key, true);


                if ($count) {
                    $count = 0;
                    $count++;
                }
                update_post_meta(get_the_ID(), $count_key, $count);
            }
        }
    }


    if (!function_exists('st_admin_add_scripts')) {
        function st_admin_add_scripts()
        {
            wp_enqueue_script('admin-custom-js', st()->url('js/custom.js'));
            wp_enqueue_style('admin-custom-css', st()->url('css/custom_admin.css'));
        }
    }

    if (!function_exists('st_admin_body_class')) {
        function st_admin_body_class($class = array())
        {

            return $class;
        }
    }


    if (!function_exists('st_add_body_class')) {

        function st_add_body_class($class)
        {
            if (st()->get_option('gen_enable_smscroll') == 'on') {
                $class[] = ' enable_nice_scroll';
            }


            if (st()->get_option('search_enable_preload', 'on') == 'on' and is_search()) {
                $class[] = 'search_enable_preload';
            }

            if (st()->get_option('gen_enable_sticky_menu', 'off') == 'on') {
                $class[] = 'enable_sticky_menu';
            }


            return $class;
        }

    }


    add_action('admin_footer', 'st_add_vc_element_icon');
    if (!function_exists('st_add_vc_element_icon')) {
        function st_add_vc_element_icon()
        {
            ?>
            <style>
                .vc-element-icon.icon-st,
                .vc_element-icon.icon-st {
                    background-image: url('<?php echo get_template_directory_uri().'/img/logo80x80.png' ?>') !important;
                    background-size: 100% 100%;
                }

                .vc_shortcodes_container > .wpb_element_wrapper > .wpb_element_title .vc_element-icon.icon-st {
                    background-position: 0px
                }

            </style>
        <?php
        }
    }

    if (!function_exists('st_add_custom_css')) {
        function st_add_custom_css()
        {
            $css = '';

            if ($scheme = st()->get_option('style_default_scheme')) {
                $css .= st()->load_template('custom_css', null, array('main_color_char' => $scheme));
            } else {
                $css .= st()->load_template('custom_css');
            }

            echo "\r\n";
            ?>
            <!-- Custom_css.php-->
            <style id="st_custom_css_php">
                <?php echo ($css)?>
            </style>
            <!-- End Custom_css.php-->
            <style>
                <?php echo st()->get_option('custom_css');?>
            </style>
        <?php
        }
    }

    if (!function_exists('st_get_layout')) {
        function st_get_layout($post_type)
        {
            if (empty($post_type)) return false;
            $arg = array(
                'post_type'      => 'st_layouts',
                'posts_per_page' => '-1',
                'meta_query'     => array(
                    array(
                        'key'     => 'st_type_layout',
                        'value'   => $post_type,
                        'compare' => '=',
                    ),
                ),
            );
            $data[] = array(
                'value' => '',
                'label' => __('-- Choose One --', ST_TEXTDOMAIN)
            );
            query_posts($arg);
            while (have_posts()) {
                the_post();
                $data[] = array(
                    'value' => get_the_ID(),
                    'label' => get_the_title()
                );
            }
            wp_reset_query();
            if (!empty($data)) {
                return $data;
            } else {
                return false;
            }
        }
    }


    if (!function_exists('st_inside_post_gallery')) {
        function st_inside_post_gallery($output, $attr)
        {
            global $post, $wp_locale;

            static $instance = 0;
            $instance++;

            // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
            if (isset($attr['orderby'])) {
                $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
                if (!$attr['orderby'])
                    unset($attr['orderby']);
            }

            extract(shortcode_atts(array(
                'order'      => 'ASC',
                'orderby'    => 'menu_order ID',
                'id'         => $post->ID,
                'itemtag'    => 'dl',
                'icontag'    => 'dt',
                'captiontag' => 'dd',
                'columns'    => 3,
                'size'       => array(1000, 9999),
                'include'    => '',
                'exclude'    => ''
            ), $attr));

            $id = intval($id);
            if ('RAND' == $order)
                $orderby = 'none';

            if (!empty($include)) {
                $include = preg_replace('/[^0-9,]+/', '', $include);
                $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

                $attachments = array();
                foreach ($_attachments as $key => $val) {
                    $attachments[$val->ID] = $_attachments[$key];
                }
            } elseif (!empty($exclude)) {
                $exclude = preg_replace('/[^0-9,]+/', '', $exclude);
                $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
            } else {
                $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
            }

            if (empty($attachments))
                return '';

            if (is_feed()) {
                $output = "\n";
                foreach ($attachments as $att_id => $attachment)
                    $output .= wp_get_attachment_link($att_id, $size, true) . "\n";

                return $output;
            }

            $itemtag = tag_escape($itemtag);
            $captiontag = tag_escape($captiontag);
            $columns = intval($columns);
            $itemwidth = $columns > 0 ? floor(100 / $columns) : 100;
            $float = is_rtl() ? 'right' : 'left';

            $selector = "gallery-{$instance}";

            $output = apply_filters('gallery_style', "

        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div data-width=\"100%\" class=\"fotorama gallery galleryid-{$id} \" data-allowfullscreen=\"true\">");

            $i = 0;
            foreach ($attachments as $id => $attachment) {
                $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

                $output .= $link;

            }

            $output .= "

        </div>\n";

            return $output;
        }
    }
    if (!function_exists('st_add_login_css')) {
        function st_add_login_css()
        {

            ?>
            <style type="text/css">
                .wp-social-login-widget {
                    display: none;
                }
            </style>

        <?php

        }
    }

    if (!function_exists('st_show_box_icon_css')) {
        function st_show_box_icon_css()
        {
            echo "<link rel='stylesheet' href='" . get_template_directory_uri() . "/css/box-icon-color.css'>";
        }
    }