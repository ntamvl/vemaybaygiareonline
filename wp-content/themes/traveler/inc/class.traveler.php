<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class code traver
 *
 * Created by ShineTheme
 *
 */
require_once get_template_directory().'/inc/core/class.shinetheme.php';
if(!class_exists('STTraveler'))
{
    class STTraveler extends  STFramework
    {

        //define location of Included Theme's plugins

        static $booking_type=array();

        static $_is_inited=false;

        function __construct()
        {

            if(self::$_is_inited) return;

            self::$_is_inited=true;

            $this->plugin_name='traveler-code';

            parent::__construct();

            $file=array(

                'travel-helper',
                'admin/class.stadmin',
                'st.customvc',
                'helpers/st-languages',
                'class/class.travelobject',
                'class/class.hotel',
                'class/class.room',
                'class/class.review',
                'class/class.order',
                'st.customvc',
                'class/class.hotel',
                'helpers/class.validate',
                'class/class.payment_gateways',
                'class/class.cart',
                'class/class.paypal',
                'class/class.user',
                'class/class.location',
                'class/class.cars',
                'class/class.tour',
                'class/class.rental',
                'class/class.cruise',
                'class/class.cabin',
                'class/class.activity',
                'class/class.coupon',
                'class/class.featured',
                'class/class.woocommerce',
                'helpers/class.date',
                'helpers/class.social.login',
                'helpers/class.analytics',
                'helpers/class.cool-captcha',
                'plugins/custom-option-tree/custom-option-tree',
                'plugins/custom-select-post/custom-select-post',

            );


            $this->load_libs($file);
            $this->_load_abstract();
            $this->_load_modules();

            self::$booking_type=apply_filters('st_booking_post_type',array(
                'st_hotel',
                'st_activity',
                'st_tours',
                'st_cars',
                'st_rental'
            ));

            if(function_exists('st_reg_post_type') and function_exists('st_reg_taxonomy'))
            {

                add_action( 'init', array($this,'st_hotel_init') );
                add_action( 'init', array($this,'st_attribute_to_taxonomy') );
                add_action( 'init', array($this,'st_location_init') );
                add_action( 'init', array($this,'st_order_init') );
            }

            if(function_exists('st_reg_shortcode')){
                /**
                 * Load widget, shortcodes and vc elements. No need use it from plugins
                 *
                 *
                 * @since 1.0.7
                 * */
                $this->loadWidgets();
                $this->loadShortCodes();
                if(class_exists('Vc_Manager'))
                {
                    add_action('init',array($this,'loadVcElements'),20);
                }
            }


        }

        /**
         * Load all shortcodes from folder inc/shortcodes/
         *
         *
         * @since 1.0.7
         *
         * */
        function loadShortCodes()
        {
            $widgets=glob($this->dir().'/shortcodes/*');
            if(!is_array($widgets) or empty($widgets)) return false;



            $dirs = array_filter($widgets, 'is_dir');

            $exclude=apply_filters('st_exclude_shortcodes',array());

            $hasExclude=false;

            if(is_array($exclude) and !empty($exclude))
            {
                $hasExclude=true;
            }

            if(!empty($dirs))
            {
                foreach($dirs as $key=>$value)
                {
                    $dirname=basename($value);

                    if(!$hasExclude or !in_array($dirname,$exclude))
                    {
                        $file=$this->dir_name('shortcodes/'.$dirname.'/'.$dirname);
                        get_template_part($file);
                    }
                }
            }


            return true;
        }


        /**
         * Load all vc-elements from folder inc/vc-elements/
         *
         *
         * @since 1.0.7
         *
         * */
        function loadVcElements()
        {
            $widgets=glob($this->dir().'/vc-elements/*');
            if(!is_array($widgets) or empty($widgets)) return false;



            $dirs = array_filter($widgets, 'is_dir');

            $exclude=apply_filters('st_exclude_vcelements',array());

            $hasExclude=false;

            if(is_array($exclude) and !empty($exclude))
            {
                $hasExclude=true;
            }

            if(!empty($dirs))
            {
                foreach($dirs as $key=>$value)
                {
                    $dirname=basename($value);

                    if(!$hasExclude or !in_array($dirname,$exclude))
                    {
                        $file=$this->dir_name('vc-elements/'.$dirname.'/'.$dirname);
                        get_template_part($file);
                    }
                }
            }


            return true;
        }



        /**
         * Load all widgets from folder inc/widgets/
         *
         *
         * @since 1.0.7
         *
         * */
        function  loadWidgets()
        {
            $widgets=glob($this->dir().'/widgets/*');
            if(!is_array($widgets) or empty($widgets)) return false;



            $dirs = array_filter($widgets, 'is_dir');

            $exclude=apply_filters('st_exclude_widgets',array());

            $hasExclude=false;

            if(is_array($exclude) and !empty($exclude))
            {
                $hasExclude=true;
            }

            if(!empty($dirs))
            {
                foreach($dirs as $key=>$value)
                {
                    $dirname=basename($value);

                    if(!$hasExclude or !in_array($dirname,$exclude))
                    {
                        $file=$this->dir_name('widgets/'.$dirname.'/'.$dirname);
                        get_template_part($file);
                    }
                }
            }


            return true;
        }

        function _load_abstract()
        {
            $files=array(
                'abstract/class-abstract-controller',
                'abstract/class-abstract-front-controller',
                'abstract/class-abstract-admin-controller',
            );

            $this->load_libs($files);
        }

        /**
         * New Module Systems
         *
         * Load all modules from folder inc/modules
         *
         * Module must be
         * -controllers/
         * ----admin.php - Admin Controller
         * ----default.php - Fontend Controller
         * -models -> Access database
         * -views -> Contain parts of templates
         *
         * @since 1.0.5
         *
         * */
        function _load_modules()
        {
            $folders=glob(get_template_directory().'/inc/modules/*');
            if(!is_array($folders) or empty($folders)) return;

            $modules_dir=array_filter($folders,'is_dir');

            if(!is_array($modules_dir)) return;


            if(!empty($modules_dir))
            {
                foreach($modules_dir as $key=>$value)
                {

                    // Load Front Controller
                    $front_controller_file=$value.'/controllers/default.php';
                    if(!is_admin() and file_exists($front_controller_file))
                    {
                        require_once $front_controller_file;
                    }

                    // Load Admin Controller
                    $admin_controller_file=$value.'/controllers/admin.php';
                    if(is_admin() and file_exists($admin_controller_file))
                    {
                        require_once $admin_controller_file;
                    }


                }
            }
        }




        function booking_post_type()
        {

            return self::$booking_type;
        }

        static function booking_type()
        {
            return self::$booking_type;
        }

        // Hotel ==============================================================


        function st_hotel_init() {
            $labels = array(
                'name'               => __( 'Hotels', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Hotel', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Hotels', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Hotel', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add New', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Hotel', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Hotel', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Hotel', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Hotel', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Hotels', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Hotels', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Hotels:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No hotels found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No hotels found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'menu_icon'               =>'dashicons-building-yl',
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => get_option( 'hotel_permalink' ,'st_hotel' ) ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                //'menu_position'      => null,
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
            );

            st_reg_post_type( 'st_hotel', $args );

            $labels = array(
                'name'               => __( 'Rooms', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Room', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Rooms', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Room', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add New', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Room', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Room', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Room', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Room', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Rooms', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Rooms', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Rooms:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No rooms found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No rooms found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                //'show_in_menu'       => 'edit.php?post_type=hotel',
                'query_var'          => true,
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
                'menu_icon'               =>'dashicons-building-yl',
                'exclude_from_search'=>true
            );

            st_reg_post_type( 'hotel_room', $args );
        }
        function st_attribute_to_taxonomy()
        {
            $name=__('Room Type',ST_TEXTDOMAIN);
            $labels = array(
                'name'              => $name ,
                'singular_name'     => $name,
                'search_items'      => sprintf(__( 'Search %s' ,ST_TEXTDOMAIN),$name),
                'all_items'         => sprintf(__( 'All %s' ,ST_TEXTDOMAIN),$name),
                'parent_item'       => sprintf(__( 'Parent %s' ,ST_TEXTDOMAIN),$name),
                'parent_item_colon' => sprintf(__( 'Parent %s' ,ST_TEXTDOMAIN),$name),
                'edit_item'         => sprintf(__( 'Edit %s' ,ST_TEXTDOMAIN),$name),
                'update_item'       => sprintf(__( 'Update %s' ,ST_TEXTDOMAIN),$name),
                'add_new_item'      => sprintf(__( 'New %s' ,ST_TEXTDOMAIN),$name),
                'new_item_name'     => sprintf(__( 'New %s' ,ST_TEXTDOMAIN),$name),
                'menu_name'         => $name,
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           =>true,
                'show_ui'           => 'edit.php?post_type=st_hotel',
                'query_var'         => true,
            );

            st_reg_taxonomy('room_type' ,'hotel_room', $args );

            $attributes=$attr=get_option('st_attribute_taxonomy');

            if(!empty($attributes) and is_array($attributes))
            {
                foreach($attributes as $key=>$value)
                {
                    $name=$value['name'];
                    $slug=$key;
                    $hierarchical=$value['hierarchical'];

                    $post_type=$value['post_type'];
                    // Add new taxonomy, make it hierarchical (like categories)
                    $labels = array(
                        'name'              => $name ,
                        'singular_name'     => $name,
                        'search_items'      => sprintf(__( 'Search %s' ,ST_TEXTDOMAIN),$name),
                        'all_items'         => sprintf(__( 'All %s' ,ST_TEXTDOMAIN),$name),
                        'parent_item'       => sprintf(__( 'Parent %s' ,ST_TEXTDOMAIN),$name),
                        'parent_item_colon' => sprintf(__( 'Parent %s' ,ST_TEXTDOMAIN),$name),
                        'edit_item'         => sprintf(__( 'Edit %s' ,ST_TEXTDOMAIN),$name),
                        'update_item'       => sprintf(__( 'Update %s' ,ST_TEXTDOMAIN),$name),
                        'add_new_item'      => sprintf(__( 'New %s' ,ST_TEXTDOMAIN),$name),
                        'new_item_name'     => sprintf(__( 'New %s' ,ST_TEXTDOMAIN),$name),
                        'menu_name'         => $name,
                    );

                    $args = array(
                        'hierarchical'      => $hierarchical,
                        'labels'            => $labels,
                        'show_ui'           => true,
                        'show_admin_column' => true,
                        'query_var'         => true,
                    );


                    st_reg_taxonomy($slug ,$post_type, $args );

                }
            }
        }

//Location ==============================================================



        function st_location_init() {
            $labels = array(
                'name'               => __( 'Locations', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Location', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Locations', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Location', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add New', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Location', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Location', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Location', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Location', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Locations', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Locations', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Locations:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No locations found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No locations found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'location' ),
                'has_archive'        => true,
                'hierarchical'       => true,
                //'menu_position'      => null,
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ,'page-attributes'),
                'menu_icon'         =>'dashicons-location-alt-bl',
                'exclude_from_search'=>true,
                'capabilities' => array(
                    'publish_posts' => 'manage_options',
                    'edit_posts' => 'manage_options',
                    'edit_others_posts' => 'manage_options',
                    'delete_posts' => 'manage_options',
                    'delete_others_posts' => 'manage_options',
                    'read_private_posts' => 'manage_options',
                    'edit_post' => 'manage_options',
                    'delete_post' => 'manage_options',
                    'read_post' => 'manage_options',
                ),
            );

            st_reg_post_type( 'location', $args );
            // Location ==============================================================

            $labels = array(
                'name'                       => __( 'Location Type', ST_TEXTDOMAIN ),
                'singular_name'              => __( 'Location Type',  ST_TEXTDOMAIN ),
                'search_items'               => __( 'Search Location Type' , ST_TEXTDOMAIN),
                'popular_items'              => __( 'Popular Location Type' , ST_TEXTDOMAIN),
                'all_items'                  => __( 'All Location Type', ST_TEXTDOMAIN ),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __( 'Edit Location Type' , ST_TEXTDOMAIN),
                'update_item'                => __( 'Update Location Type' , ST_TEXTDOMAIN),
                'add_new_item'               => __( 'Add New Location Type', ST_TEXTDOMAIN ),
                'new_item_name'              => __( 'New Location Type Name', ST_TEXTDOMAIN ),
                'separate_items_with_commas' => __( 'Separate Location Type with commas' , ST_TEXTDOMAIN),
                'add_or_remove_items'        => __( 'Add or remove Location Type', ST_TEXTDOMAIN ),
                'choose_from_most_used'      => __( 'Choose from the most used Location Type', ST_TEXTDOMAIN ),
                'not_found'                  => __( 'No Pickup Location Type.', ST_TEXTDOMAIN ),
                'menu_name'                  => __( 'Location Type', ST_TEXTDOMAIN ),
            );

            $args = array(
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_ui'               => true,
                'show_admin_column'     => true,
                'query_var'             => true,
            );

            st_reg_taxonomy( 'st_location_type', 'location', $args );
        }

// Order ==============================================================



        function st_order_init() {
            $labels = array(
                'name'               => __( 'Order', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Order', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Orders', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Order', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add New', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Order', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Order', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Order', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Order', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Orders', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Orders', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Orders:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No Orders found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No Orders found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => false,
                'show_in_menu'       => false,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'st_order' ),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                //'menu_position'      => null,
                'supports'           => array( 'title', 'author' ),
                'exclude_from_search'=>true
            );

            st_reg_post_type( 'st_order', $args );


            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => false,
                'show_in_menu'       => 'edit.php?post_type=st_order',
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'st_order_item' ),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                //'menu_position'      => null,
                'supports'           => array( 'author' ),
                'exclude_from_search'=>true
            );

            //register_post_type( 'st_order_item', $args );

            // Layout ==============================================================

            $labels = array(
                'name'               => __( 'Layouts ', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Layout', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Layouts', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Layout', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add New', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Layout', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Layout', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Layout', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Layout', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Layouts', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Layout', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Layout:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No Layouts found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No Layouts found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'st_layouts' ),
                'capability_type'    => '',
                'has_archive'        => false,
                'hierarchical'       => false,
                //'menu_position'      => null,
                'supports'           => array( 'author','title','editor' ),
                'menu_icon'          =>'dashicons-desktop-red',
                'exclude_from_search'=>true,
                'capabilities' => array(
                    'publish_posts' => 'manage_options',
                    'edit_posts' => 'manage_options',
                    'edit_others_posts' => 'manage_options',
                    'delete_posts' => 'manage_options',
                    'delete_others_posts' => 'manage_options',
                    'read_private_posts' => 'manage_options',
                    'edit_post' => 'manage_options',
                    'delete_post' => 'manage_options',
                    'read_post' => 'manage_options',
                ),
            );

            st_reg_post_type( 'st_layouts', $args );

            // Cars ==============================================================
            $labels = array(
                'name'               => __( 'Cars', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Car', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Cars', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Car', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add New', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Car', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Car', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Car', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Car', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Cars', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Cars', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Cars:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No Cars found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No Cars found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => get_option( 'car_permalink' ,'st_car' ) ),
                'capability_type'    => 'post',
                'has_archive'        => false,
                'hierarchical'       => false,
                //'menu_position'      => null,
                'supports'           => array( 'author','title','editor','excerpt','thumbnail' ),
                'menu_icon'          =>'dashicons-dashboard-st'
            );
            st_reg_post_type( 'st_cars', $args );

            // category cars
            $labels = array(
                'name'                       => __( 'Car Category', 'taxonomy general name', ST_TEXTDOMAIN ),
                'singular_name'              => __( 'Car Category', 'taxonomy singular name', ST_TEXTDOMAIN ),
                'search_items'               => __( 'Search Car Category' , ST_TEXTDOMAIN),
                'popular_items'              => __( 'Popular Car Category' , ST_TEXTDOMAIN),
                'all_items'                  => __( 'All Car Category', ST_TEXTDOMAIN ),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __( 'Edit Car Category' , ST_TEXTDOMAIN),
                'update_item'                => __( 'Update Car Category' , ST_TEXTDOMAIN),
                'add_new_item'               => __( 'Add New Car Category', ST_TEXTDOMAIN ),
                'new_item_name'              => __( 'New Pickup Car Category', ST_TEXTDOMAIN ),
                'separate_items_with_commas' => __( 'Separate Car Category  with commas' , ST_TEXTDOMAIN),
                'add_or_remove_items'        => __( 'Add or remove Car Category', ST_TEXTDOMAIN ),
                'choose_from_most_used'      => __( 'Choose from the most used Car Category', ST_TEXTDOMAIN ),
                'not_found'                  => __( 'No Car Category found.', ST_TEXTDOMAIN ),
                'menu_name'                  => __( 'Car Category', ST_TEXTDOMAIN ),
            );

            $args = array(
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_ui'               => true,
                'show_admin_column'     => true,
                'query_var'             => true,
                'rewrite'               => array( 'slug' => 'st_category_cars' ),
            );

            st_reg_taxonomy( 'st_category_cars', 'st_cars', $args );

            $labels = array(
                'name'                       => st_get_language('car_pickup_features'),
                'singular_name'              => st_get_language('car_pickup_features'),
                'search_items'               => st_get_language('car_search_pickup_features'),
                'popular_items'              => __( 'Popular Pickup Features' , ST_TEXTDOMAIN),
                'all_items'                  => __( 'All Pickup Features', ST_TEXTDOMAIN ),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __( 'Edit Pickup Feature' , ST_TEXTDOMAIN),
                'update_item'                => __( 'Update Pickup Feature' , ST_TEXTDOMAIN),
                'add_new_item'               => __( 'Add New Pickup Feature', ST_TEXTDOMAIN ),
                'new_item_name'              => __( 'New Pickup Feature Name', ST_TEXTDOMAIN ),
                'separate_items_with_commas' => __( 'Separate Pickup Features with commas' , ST_TEXTDOMAIN),
                'add_or_remove_items'        => __( 'Add or remove Pickup Features', ST_TEXTDOMAIN ),
                'choose_from_most_used'      => __( 'Choose from the most used Pickup Features', ST_TEXTDOMAIN ),
                'not_found'                  => __( 'No Pickup Features found.', ST_TEXTDOMAIN ),
                'menu_name'                  => __( 'Pickup Features', ST_TEXTDOMAIN ),
            );

            $args = array(
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_ui'               => true,
                'show_admin_column'     => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var'             => true,
                'rewrite'               => array( 'slug' => 'st_cars_pickup_features' ),
            );

            st_reg_taxonomy( 'st_cars_pickup_features', 'st_cars', $args );

            // Tours ==============================================================
            $labels = array(
                'name'               => __( 'Tours', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Tour', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Tours', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Tour', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add New', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Tour', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Tour', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Tour', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Tour', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Tour', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Tour', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Tour:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No Tours found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No Tours found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' =>  get_option( 'tour_permalink' ,'st_tour' ) ),
                'capability_type'    => 'post',
                'hierarchical'       => false,
                //'menu_position'      => null,
                'supports'           => array( 'author','title','editor' , 'excerpt','thumbnail', 'comments' ),
                'menu_icon'          =>'dashicons-palmtree-st'
            );

            st_reg_post_type( 'st_tours', $args );

            $labels = array(
                'name'                       => __( 'Tours Type', 'taxonomy general name', ST_TEXTDOMAIN ),
                'singular_name'              => __( 'Tours Type', 'taxonomy singular name', ST_TEXTDOMAIN ),
                'search_items'               => __( 'Search Tours Type' , ST_TEXTDOMAIN),
                'popular_items'              => __( 'Popular Tours Type' , ST_TEXTDOMAIN),
                'all_items'                  => __( 'All Tours Type', ST_TEXTDOMAIN ),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __( 'Edit Tour Type' , ST_TEXTDOMAIN),
                'update_item'                => __( 'Update Tour Type' , ST_TEXTDOMAIN),
                'add_new_item'               => __( 'Add New Pickup Feature', ST_TEXTDOMAIN ),
                'new_item_name'              => __( 'New Tour Type Name', ST_TEXTDOMAIN ),
                'separate_items_with_commas' => __( 'Separate Tour Type with commas' , ST_TEXTDOMAIN),
                'add_or_remove_items'        => __( 'Add or remove Tour Type', ST_TEXTDOMAIN ),
                'choose_from_most_used'      => __( 'Choose from the most used Tour Type', ST_TEXTDOMAIN ),
                'not_found'                  => __( 'No Pickup Tour Type.', ST_TEXTDOMAIN ),
                'menu_name'                  => __( 'Tours Type', ST_TEXTDOMAIN ),
            );
            $args = array(
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_ui'               => true,
                'show_admin_column'     => true,
                'query_var'             => true,
                'rewrite'               => array( 'slug' => 'st_tour_type' ),
            );

            st_reg_taxonomy( 'st_tour_type', 'st_tours', $args );

            // Activity ==============================================================

            $labels = array(
                'name'               => __( 'Activity', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Activity', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Activity', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Tour', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add New', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Activity', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Activity', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Activity', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Activity', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Activity', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Activity', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Activity:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No Activity found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No Activity found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => get_option( 'activity_permalink' ,'st_activity' ) ),
                'capability_type'    => 'post',
                'hierarchical'       => false,
                //'menu_position'      => null,
                'supports'           => array( 'author','title','editor' , 'excerpt','thumbnail', 'comments' ),
                'menu_icon'         =>'dashicons-tickets-alt-st'
            );
            st_reg_post_type( 'st_activity', $args );




            // Rental ==============================================================
            $labels = array(
                'name'               => __( 'Rental', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Rental', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Rental', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Rental', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add Rental', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Rental', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Rental', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Rental', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Rental', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Rental', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Rental', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Rental:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No Rental found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No Rental found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => get_option( 'rental_permalink' ,'st_rental' ) ),
                'capability_type'    => 'post',
                'hierarchical'       => false,
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
                'menu_icon'          =>'dashicons-admin-home-st'
            );
            st_reg_post_type( 'st_rental', $args );// post type cars

            // Coupon Code ==============================================================
            $labels = array(
                'name'               => __( 'Coupon Code', ST_TEXTDOMAIN ),
                'singular_name'      => __( 'Coupon Code', ST_TEXTDOMAIN ),
                'menu_name'          => __( 'Coupon', ST_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Coupon Code', ST_TEXTDOMAIN ),
                'add_new'            => __( 'Add Coupon Code', ST_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Coupon Code', ST_TEXTDOMAIN ),
                'new_item'           => __( 'New Coupon Code', ST_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Coupon Code', ST_TEXTDOMAIN ),
                'view_item'          => __( 'View Coupon Code', ST_TEXTDOMAIN ),
                'all_items'          => __( 'All Coupon Code', ST_TEXTDOMAIN ),
                'search_items'       => __( 'Search Coupon Code', ST_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Coupon Code:', ST_TEXTDOMAIN ),
                'not_found'          => __( 'No Coupon Code found.', ST_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No Coupon Code found in Trash.', ST_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'coupon_code' ),
                'capability_type'    => '',
                'has_archive'        => false,
                'hierarchical'       => false,
                //'menu_position'      => null,
                'supports'           => array( 'title'),
                'menu_icon'          =>'dashicons-tag-st',
                'exclude_from_search'=>true,
                'capabilities' => array(
                    'publish_posts' => 'manage_options',
                    'edit_posts' => 'manage_options',
                    'edit_others_posts' => 'manage_options',
                    'delete_posts' => 'manage_options',
                    'delete_others_posts' => 'manage_options',
                    'read_private_posts' => 'manage_options',
                    'edit_post' => 'manage_options',
                    'delete_post' => 'manage_options',
                    'read_post' => 'manage_options',
                ),
            );
            st_reg_post_type( 'st_coupon_code', $args );// post type cars

        }


    }

    if(!function_exists('st'))
    {
        function st()
        {
            global $stframework;
            if(!$stframework){
                $stframework=new STTraveler();
            }
            return $stframework;
        }
    }

}
