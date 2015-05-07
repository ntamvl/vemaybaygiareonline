<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STCars
 *
 * Created by ShineTheme
 *
 */

if(!class_exists('STCars'))
{
    class STCars extends TravelerObject
    {
        protected $orderby;

        function __construct($hotel_id=false)
        {
            $this->hotel_id=$hotel_id;
            $this->orderby=array(
                'new'=>array(
                    'key'=>'new',
                    'name'=>__('New',ST_TEXTDOMAIN)
                ),
                'price_asc'=>array(
                    'key'=>'price_asc',
                    'name'=>__('Price (low to high)',ST_TEXTDOMAIN)
                ),
                'price_desc'=>array(
                    'key'=>'price_desc',
                    'name'=>__('Price (hight to low)',ST_TEXTDOMAIN)
                ),
                'name_a_z'=>array(
                    'key'=>'name_a_z',
                    'name'=>__('Car Name (A-Z)',ST_TEXTDOMAIN)
                ),
                'name_z_a'=>array(
                    'key'=>'name_z_a',
                    'name'=>__('Car Name (Z-A)',ST_TEXTDOMAIN)
                ),

            );



        }

        function init()
        {
            parent::init();


            //Filter change layout of cars detail if choose in metabox
            add_filter('st_cars_detail_layout',array($this,'custom_cars_layout'));

            // price cars
            add_action( 'wp_ajax_st_price_cars',array($this,'st_price_cars_func')  );
            add_action( 'wp_ajax_nopriv_st_price_cars', array($this,'st_price_cars_func'));

            //custom search cars template
            add_filter('template_include', array($this,'choose_search_template'));
            //add Widget Area
            add_action('widgets_init',array($this,'add_sidebar'));
            //Sidebar Pos for SEARCH
            add_filter('st_cars_sidebar',array($this,'change_sidebar'));

            // ajax add_type_widget
            add_action( 'wp_ajax_add_type_widget',array($this,'add_type_widget_func')  );
            add_action( 'wp_ajax_nopriv_add_type_widget', array($this,'add_type_widget_func'));

            // ajax load_list_taxonomy
            add_action( 'wp_ajax_load_list_taxonomy',array($this,'load_list_taxonomy_func')  );
            add_action( 'wp_ajax_nopriv_load_list_taxonomy', array($this,'load_list_taxonomy_func'));

            //Filter the search hotel
            add_action('pre_get_posts',array($this,'change_search_cars_arg'));

            add_action('init',array($this,'get_list_value_taxonomy'),98);
            add_action('init',array($this,'init_metabox'),99);
            //$this->init_metabox();

            add_action('init',array($this,'cars_add_to_cart'));

            add_filter( 'posts_where' , array($this,'_alter_search_query') );

            add_action('st_after_checkout_fields',array($this,'add_checkout_fields'));

            add_filter('st_checkout_form_validate',array($this,'add_validate_fields'));

            add_action('st_after_save_order_item',array($this,'save_extra_fields'),10,3);

            add_action('wp_enqueue_scripts',array($this,'add_script'));

            add_filter('st_search_preload_page',array($this,'_change_preload_search_title'));

            //add_action('st_after')


        }

        function _change_preload_search_title($return)
        {
            if( get_query_var('post_type')=='st_cars')
            {
                $return=" Cars";

                if(STInput::get('location_id'))
                {
                    $return.=' in '.get_the_title(STInput::get('location_id'));
                }elseif(STInput::get('s'))
                {
                    $return.=' in '.STInput::get('s');
                }

                $return.='...';
            }





            return $return;
        }

        function _is_slot_available($post_id,$check_in,$check_out)
        {
            $check_in=date('Y-m-d H:i:s',strtotime($check_in));
            $check_out=date('Y-m-d H:i:s',strtotime($check_out));
            global $wpdb;

            $query="
SELECT count(booked_id) as total_booked from (
SELECT st_meta6.meta_value as booked_id ,st_meta2.meta_value as check_in,st_meta3.meta_value as check_out
                                         FROM {$wpdb->posts}
                                                JOIN {$wpdb->postmeta}  as st_meta2 on st_meta2.post_id={$wpdb->posts}.ID and st_meta2.meta_key='check_in'
                                                JOIN {$wpdb->postmeta}  as st_meta3 on st_meta3.post_id={$wpdb->posts}.ID and st_meta3.meta_key='check_out'
                                                JOIN {$wpdb->postmeta}  as st_meta6 on st_meta6.post_id={$wpdb->posts}.ID and st_meta6.meta_key='item_id'
                                                WHERE {$wpdb->posts}.post_type='st_order'
                                                AND st_meta6.meta_value={$post_id}
                                          GROUP BY {$wpdb->posts}.id HAVING  (

                                                    ( CAST(st_meta2.meta_value AS DATE)<'{$check_in}' AND  CAST(st_meta3.meta_value AS DATE)>'{$check_in}' )
                                                    OR ( CAST(st_meta2.meta_value AS DATE)>='{$check_in}' AND  CAST(st_meta2.meta_value AS DATE)<='{$check_out}'))) as object_booked
        ";

            $total_booked=(int)$wpdb->get_var($query);
            $total=(int)get_post_meta($post_id,'number_car',true);

            if($total>$total_booked) return true;
            else return false;

        }


        function add_script()
        {
            if(is_singular('st_cars'))
                wp_enqueue_script('single-car',get_template_directory_uri().'/js/init/single-car.js');
        }
        function save_extra_fields($order_id,$key,$value)
        {
            if(STInput::post('driver_name'))
            {
                update_post_meta($order_id,'driver_name',STInput::post('driver_name'));
            }
            if(STInput::post('driver_age'))
            {
                update_post_meta($order_id,'driver_age',STInput::post('driver_age'));
            }

            if(get_post_type($key)=='st_cars')
            {
                foreach($value['data'] as $k=>$v){

                    if($k=='data_price_cars'){
                        $date = $v->date_time;
                        update_post_meta($order_id,'check_in_time',$date->pick_up_time  );
                        update_post_meta($order_id,'check_out_time',$date->drop_off_time );
                        update_post_meta($order_id,'pick_up',$v->pick_up );
                        update_post_meta($order_id,'drop_off',$v->drop_off );
                    }

                }

                if(get_post_type($key) == 'st_cars'){
                    $items =$value['data']['data_price_items'];
                    update_post_meta($order_id,'item_equipment',json_encode($items));
                }
            }

        }
        function add_validate_fields($validate)
        {
            if($this->check_is_car_booking())
            {
                $validator=new STValidate();

                $validator->set_rules(array(
                    array(
                        'field'  =>'driver_name',
                        'label'  =>'Driver\'s Name',
                        'rules'  =>'required|trim|strip_tags'
                    ),
                    array(
                        'field'  =>'driver_age',
                        'label'  =>'Driver\'s Age',
                        'rules'  =>'required|trim|strip_tags'
                    )
                ));

                if(!$validator->run())
                {
                    $validate=false;
                    STTemplate::set_message($validator->error_string(),'danger');
                }
            }

            return $validate;
        }
        function check_is_car_booking()
        {
            $item=STCart::get_cart_item();
            if(isset($item['key']) and get_post_type($item['key'])=='st_cars')
            {
                return true;
            }
            return false;
        }

        function add_checkout_fields()
        {
            if($this->check_is_car_booking() or is_singular('st_cars'))
            {
                echo st()->load_template('cars/checkout_fields');
            }

        }

        /**
         * @return array
         */
        public function getOrderby()
        {
            return $this->orderby;
        }




        function cars_add_to_cart()
        {
            if(STInput::post('action')=='cars_add_to_cart')
            {
                if($this->do_add_to_cart())
                {

                    $link=STCart::get_cart_link();

                    $link=apply_filters('st_car_added_cart_redirect_link',$link);

                    wp_safe_redirect($link);
                    die;
                }

            }

        }
        function do_add_to_cart()
        {
            $pass_validate=true;

            $data_price_cars=json_decode( str_ireplace("\\",'',STInput::request('data_price_cars')) );
            $data_price_items=json_decode( str_ireplace("\\",'',STInput::request('data_price_items')) );
            $discount = STInput::request('discount');
            $price_unit = STInput::request('price');
            $price_old= STInput::request('price_old');
            $item_id=STInput::request('item_id');
            $number=1;

            $price_total= STInput::request('data_price_total');

            $check_in=$data_price_cars->date_time->pick_up_date.' '.$data_price_cars->date_time->pick_up_time;

            $check_in=date('Y-m-d H:i:s',strtotime($check_in));

            $check_out=$data_price_cars->date_time->drop_off_date.' '.$data_price_cars->date_time->drop_off_time;

            $check_out=date('Y-m-d H:i:s',strtotime($check_out));

            $data=array(
                'data_price_cars'=>$data_price_cars,
                'data_price_items'=>$data_price_items,
                'discount'=>$discount,
                'price_old'=>$price_old,
                'check_in'=>$check_in,
                'check_out'=>$check_out,
                'price_total'=>$price_total,
            );

            //Validate PickUp and Dropoff
            $pickup=isset($data_price_cars->pick_up)?$data_price_cars->pick_up:false;
            $drop_off=isset($data_price_cars->drop_off)?$data_price_cars->drop_off:false;
            if(!$pickup){
                STTemplate::set_message(__('Pick-Up is required',ST_TEXTDOMAIN),'danger');
                $pass_validate=false;
            }else if(!$drop_off){
                STTemplate::set_message(__('Drop-Off is required',ST_TEXTDOMAIN),'danger');
                $pass_validate=false;
            }


            if(!$this->_is_slot_available($item_id,$check_in,$check_out))
            {
                STTemplate::set_message(__('Sorry! This Car is not available.',ST_TEXTDOMAIN),'danger');
                $pass_validate= false;
            }


            // Allow to be filtered
            $pass_validate=apply_filters('st_car_add_cart_validate',$pass_validate,$item_id,$number,$price_unit,$data);



            if($pass_validate){
                STCart::add_cart($item_id,$number,$price_unit,$data);
            }
            return $pass_validate;
        }

        function get_cart_item_html($item_id=false)
        {
            return st()->load_template('cars/cart_item_html',null,array('item_id'=>$item_id));
        }

        function get_search_fields_box()
        {
            $fields=st()->get_option('car_search_fields_box');

            return $fields;
        }
        function get_search_fields()
        {
            $fields=st()->get_option('car_search_fields');

            return $fields;
        }



        function change_search_cars_arg($query)
        {

            $post_type = get_query_var('post_type');

            if($query->is_search && $post_type == 'st_cars')
            {
                $tax=STInput::get('filter_taxonomy');

                if(!empty($tax) and is_array($tax))
                {
                    $tax_query=array();
                    foreach($tax as $key=>$value)
                    {
                        if($value)
                        {
                            $ids = array();
                            foreach($value as $k=>$v){
                                if($v){
                                    array_push($ids , $v);
                                }
                            }
                            if(!empty($ids)){
                                $tax_query[]=array(
                                    'taxonomy'=>$key,
                                    'field'   => 'id',
                                    'terms'   =>$ids
                                );
                            }
                        }
                    }
                    $query->set('tax_query',$tax_query);
                }

                if($location_id=STInput::get('location_id'))
                {
                    $ids_in=array();
                    $parents = get_posts( array( 'numberposts' => -1, 'post_status' => 'publish', 'post_type' => 'location', 'post_parent' => $location_id ));

                    $ids_in[]=$location_id;

                    foreach( $parents as $child ){
                        $ids_in[]=$child->ID;
                    }



                    $meta_query[]=array(
                        'key'=>'id_location',
                        'value'=>$ids_in,
                        'compare'=>'IN'
                    );

                    $query->set('meta_query',$meta_query);
                    $query->set('s','');
                }else{
                    $meta_query[]=array(
                        'key'=>'cars_address',
                        'value'=>STInput::get('pick-up'),
                        'compare'=>'like',
                    );
                }

                $is_featured = st()->get_option('is_featured_search_car','off');
                if(!empty($is_featured) and $is_featured =='on'){
                    $query->set('meta_key','is_featured');
                    $query->set('orderby','meta_value');
                    $query->set('order','DESC');
                }
                if($orderby=STInput::get('orderby'))
                {
                    switch($orderby){
                        case "price_asc":
                            $query->set('meta_key','sale_price');
                            $query->set('orderby','meta_value_num');
                            $query->set('order','ASC');

                            break;
                        case "price_desc":
                            $query->set('meta_key','sale_price');
                            $query->set('orderby','meta_value_num');
                            $query->set('order','DESC');
                            break;
                        case "name_a_z":
                            $query->set('orderby','name');
                            $query->set('order','asc');
                            break;
                        case "name_z_a":
                            $query->set('orderby','name');
                            $query->set('order','desc');
                            break;
                    }
                }
                if($price=STInput::get('price_range')){
                    $priceobj=explode(';',$price);
                    $meta_query[]=array(
                        'key'=>'cars_price',
                        'value'=>$priceobj[0],
                        'compare'=>'>=',
                        'type'=>"NUMERIC"
                    );
                    if(isset($priceobj[1])){
                        $meta_query[]=array(
                            'key'=>'cars_price',
                            'value'=>$priceobj[1],
                            'compare'=>'<=',
                            'type'=>"NUMERIC"
                        );
                    }

                    $meta_query['relation']='and';
                }
                if(!empty($meta_query)){
                    $query->set('meta_query',$meta_query);
                }
            }
        }

        function add_type_widget_func(){
            $data_type = $_REQUEST['data_type'];
            $data_value = $_REQUEST['data_value'];
            $data_json = $_REQUEST['data_json'];
            $data_title_filter = $_REQUEST['title_filter'];

            $data_text =  '<div><h4> - '.$data_title_filter.'</h4></div>';

            if($data_type == 'price'){
                $data_value == 'price';
            }

            if(!empty($data_json)){

                $tmp_json = $data_json['data_json'];
                array_push($tmp_json , array(
                    'title'=>$data_title_filter,
                    'type'=>$data_type,
                    'value'=>$data_value
                ));

                $data_return = array(
                    'data_html'=>$data_text,
                    'data_json'=>$tmp_json
                );

            }else{
                $tmp_json = array(
                    array(
                        'title'=>$data_title_filter,
                        'type'=>$data_type,
                        'value'=>$data_value
                    )
                );
                $data_return = array(
                    'data_html'=>$data_text,
                    'data_json'=>$tmp_json
                );

            }
            echo json_encode($data_return);
            die();
        }

        function choose_search_template($template)
        {
            global $wp_query;
            $post_type = get_query_var('post_type');
            if( $wp_query->is_search && $post_type == 'st_cars' )
            {
                return locate_template('search-cars.php');  //  redirect to archive-search.php
            }
            return $template;
        }
        function add_sidebar()
        {
            register_sidebar( array(
                'name' => __( 'Cars Search Sidebar 1', ST_TEXTDOMAIN ),
                'id' => 'cars-sidebar',
                'description' => __( 'Widgets in this area will be shown on Cars', ST_TEXTDOMAIN),
                'before_title' => '<h4>',
                'after_title' => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget'  => '</div>',
            ) );

            register_sidebar( array(
                'name' => __( 'Cars Search Sidebar 2', ST_TEXTDOMAIN ),
                'id' => 'cars-sidebar-2',
                'description' => __( 'Widgets in this area will be shown on Cars', ST_TEXTDOMAIN),
                'before_title' => '<h4>',
                'after_title' => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget'  => '</div>',
            ) );

        }
        function change_sidebar($sidebar=false)
        {
            return st()->get_option('cars_sidebar_pos','left');
        }


        function st_price_cars_func() {
            $price_total = $_REQUEST['price_total'];
            $price_total_item = $_REQUEST['price_total_item'];
            echo json_encode(array(
                'price_total_number'=>$price_total,
                'price_total_text'=>TravelHelper::format_money($price_total),
                'price_total_item_number'=>$price_total_item,
                'price_total_item_text'=>TravelHelper::format_money($price_total_item),
            ));
            die();
        }

        function custom_cars_layout($old_layout_id)
        {
            if(is_singular('st_cars'))
            {
                $meta=get_post_meta(get_the_ID(),'st_custom_layout',true);

                if($meta)
                {
                    return $meta;
                }
            }
            return $old_layout_id;
        }
        function get_result_string()
        {
            global $wp_query;
            $result_string='';
            if($wp_query->found_posts > 1){
                $result_string.=esc_html( $wp_query->found_posts).__(' cars ',ST_TEXTDOMAIN);
            }else{
                $result_string.=esc_html( $wp_query->found_posts).__(' car ',ST_TEXTDOMAIN);
            }

            $location_id=STInput::get('location_id');
            if($location_id and $location=get_post($location_id))
            {
                $result_string.='in '.get_the_title($location_id);
            }else{
                if(!empty($_REQUEST['pick-up'])){
                    $result_string.='in '.STInput::get('pick-up');
                }

            }

            $start=STInput::get('pick-up-date');
            $end=STInput::get('drop-off-date');

            $start=strtotime($start);

            $end=strtotime($end);

            if($start and $end)
            {
                $result_string.=__(' on ',ST_TEXTDOMAIN).date('M d',$start).' - '.date('M d',$end);
            }

            if($adult_num=STInput::get('adult_num')){
                if($adult_num>1){
                    $result_string.=sprintf(__(' for %s adults',ST_TEXTDOMAIN),$adult_num);
                }else{

                    $result_string.=sprintf(__(' for %s adult',ST_TEXTDOMAIN),$adult_num);
                }

            }

            return $result_string;

        }

        static $data_term ;
        static function get_list_value_taxonomy(){
            $data_value =array();
            $taxonomy= get_object_taxonomies('st_cars','object');

            foreach($taxonomy as $key => $value) {
                if ($key != 'st_category_cars') {
                    if ($key != 'st_cars_pickup_features') {
                        if(is_admin() and !empty( $_REQUEST['post'] )){
                            $data_term = get_the_terms($_REQUEST['post'], $key, true);

                            if(!empty($data_term)){
                                foreach($data_term as $k=>$v){
                                    array_push(
                                        $data_value , array(
                                            'value'=>$v->term_id,
                                            'label'=>$v->name,
                                            'taxonomy'=>$v->taxonomy
                                        )
                                    );
                                }
                            }
                        }
                    }
                }
            }
            self::$data_term = $data_value ;
        }



        function init_metabox()
        {
            $this->metabox[] = array(
                'id'          => 'cars_metabox',
                'title'       => __( 'Cars Setting', ST_TEXTDOMAIN),
                'desc'        => '',
                'pages'       => array( 'st_cars' ),
                'context'     => 'normal',
                'priority'    => 'high',
                'fields'      => array(



                    array(
                        'label'       => __( 'Car Detail', ST_TEXTDOMAIN),
                        'id'          => 'room_car_tab',
                        'type'        => 'tab'
                    ),
                    array(
                        'label'       => __( 'Set as Featured', ST_TEXTDOMAIN),
                        'id'          => 'is_featured',
                        'type'        => 'on-off',
                        'desc'        => __( 'Set this location is featured', ST_TEXTDOMAIN),
                        'std'         =>'off'
                    ),
                    array(
                        'label'       => __( 'Location', ST_TEXTDOMAIN),
                        'id'          => 'id_location',
                        'type'        => 'post_select_ajax',
                        'desc'        => __( 'Search location here', ST_TEXTDOMAIN),
                        'post_type'   =>'location',
                    ),

                    array(
                        'label'       => __( 'Detail Cars Layout', ST_TEXTDOMAIN),
                        'id'          => 'st_custom_layout',
                        'post_type'   =>'st_layouts',
                        'desc'        => __( 'Detail Cars Layout', ST_TEXTDOMAIN),
                        'type'        => 'select',
                        'choices'     => st_get_layout('st_cars')
                    ),
                    array(
                        'label'       => __( 'Equipment Price List', ST_TEXTDOMAIN),
                        'id'          => 'cars_equipment_list',
                        'type'        => 'list-item',
                        'settings'    => array(
                            array(
                                'id'          => 'cars_equipment_list_price',
                                'label'       => __( 'Price', ST_TEXTDOMAIN ),
                                'type'        => 'text',
                            )
                        )
                    ),
                    array(
                        'label'       => __( 'Features', ST_TEXTDOMAIN),
                        'id'          => 'cars_equipment_info',
                        'type'        => 'list-item',
                        'settings'    => array(
                            array(
                                'id'          => 'cars_equipment_taxonomy_id',
                                'label'       => __( 'Taxonomy', ST_TEXTDOMAIN ),
                                'type'        => 'select',
                                'operator'    => 'and',
                                'choices'=> self::$data_term
                            ),
                            array(
                                'id'          => 'cars_equipment_taxonomy_info',
                                'label'       => __( 'Taxonomy Info', ST_TEXTDOMAIN ),
                                'type'        => 'text',
                            )
                        )
                    ),
                    array(
                        'label'       => __( 'Video', ST_TEXTDOMAIN),
                        'id'          => 'video',
                        'type'        => 'text',
                        'desc'        => __('Please use youtube or vimeo video',ST_TEXTDOMAIN)
                    ),
                    array(
                        'label'       => __( 'Set as featured', ST_TEXTDOMAIN),
                        'id'          => 'cars_set_as_featured',
                        'type'        => 'on-off',
                        'desc'        => __( 'Set as featured', ST_TEXTDOMAIN),
                        'std'         =>'off'
                    ),
                    array(
                        'label'       => __( 'Contact Details', ST_TEXTDOMAIN),
                        'id'          => 'room_contact_tab',
                        'type'        => 'tab'
                    ),
                    array(
                        'label'       => __( 'Logo', ST_TEXTDOMAIN),
                        'id'          => 'cars_logo',
                        'type'        => 'upload',
                        // 'desc'        => __( 'Phone', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Name', ST_TEXTDOMAIN),
                        'id'          => 'cars_name',
                        'type'        => 'text',
                        //'desc'        => __( 'Address', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Address', ST_TEXTDOMAIN),
                        'id'          => 'cars_address',
                        'type'        => 'text',
                        'desc'        => __( 'Address', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Email', ST_TEXTDOMAIN),
                        'id'          => 'cars_email',
                        'type'        => 'text',
                        'desc'        => __( 'E-mail Car Agent, this address will received email when have new booking', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Phone', ST_TEXTDOMAIN),
                        'id'          => 'cars_phone',
                        'type'        => 'text',
                        'desc'        => __( 'Phone', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'About', ST_TEXTDOMAIN),
                        'id'          => 'cars_about',
                        'type'        => 'textarea',
                    ),
                    array(
                        'label'       => __( 'Price setting', ST_TEXTDOMAIN),
                        'id'          => '_price_car_tab',
                        'type'        => 'tab'
                    ),
                    array(
                        'label'       => sprintf( __( 'Price (%s)', ST_TEXTDOMAIN),TravelHelper::get_default_currency('symbol')),
                        'id'          => 'cars_price',
                        'type'        => 'text',
                        'desc'        => __( 'Price per hour', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Discount', ST_TEXTDOMAIN),
                        'id'          => 'discount',
                        'type'        => 'text',
                        'desc'        => __( '%', ST_TEXTDOMAIN),
                        'std'         =>0
                    ),
                    array(
                        'label'       =>  __( 'Sale Schedule', ST_TEXTDOMAIN),
                        'id'          => 'is_sale_schedule',
                        'type'        => 'on-off',
                        'std'        => 'off',
                    ),
                    array(
                        'label'       =>  __( 'Sale Price Date From', ST_TEXTDOMAIN),
                        'desc'       =>  __( 'Sale Price Date From', ST_TEXTDOMAIN),
                        'id'          => 'sale_price_from',
                        'type'        => 'date-picker',
                        'condition'   =>'is_sale_schedule:is(on)'
                    ),
                    array(
                        'label'       =>  __( 'Sale Price Date To', ST_TEXTDOMAIN),
                        'desc'       =>  __( 'Sale Price Date To', ST_TEXTDOMAIN),
                        'id'          => 'sale_price_to',
                        'type'        => 'date-picker',
                        'condition'   =>'is_sale_schedule:is(on)'
                    ),
                    array(
                        'label'       => __( 'Number of car for Rent', ST_TEXTDOMAIN),
                        'desc'       => __( 'Number of car for Rent', ST_TEXTDOMAIN),
                        'id'          => 'number_car',
                        'type'        => 'text',
                        'std'         =>1
                    ),
                )
            );
            $custom_field = st()->get_option('st_cars_unlimited_custom_field');
            if(!empty($custom_field) and is_array($custom_field)){
                $this->metabox[0]['fields'][]=array(
                    'label'       => __( 'Custom fields', ST_TEXTDOMAIN),
                    'id'          => 'custom_field_tab',
                    'type'        => 'tab'
                );
                foreach($custom_field as $k => $v){
                    $key = str_ireplace('-','_','st_custom_'.sanitize_title($v['title']));
                    $this->metabox[0]['fields'][]=array(
                        'label'       => $v['title'],
                        'id'          => $key,
                        'type'        => $v['type_field'],
                        'desc'        => 'Shortcode: <br><strong>[st_custom_meta key="'.$key.'"]</strong>',
                        'std'         =>$v['default_field']
                    );
                }
            }
        }

        static function get_search_fields_name()
        {
            return array(
                'pick-up-form'=>array(
                    'value'=>'pick-up-form',
                    'label'=>__('Pick-up From',ST_TEXTDOMAIN)
                ),
                'pick-up-form-list'=>array(
                    'value'=>'pick-up-form-list',
                    'label'=>__('Pick-up From (dropdown)',ST_TEXTDOMAIN)
                ),
                'drop-off-to'=>array(
                    'value'=>'drop-off-to',
                    'label'=>__('Drop-off To',ST_TEXTDOMAIN)
                ),
                'drop-off-to-list'=>array(
                    'value'=>'drop-off-to-list',
                    'label'=>__('Drop-off To (dropdown)',ST_TEXTDOMAIN)
                ),
                'pick-up-date'=>array(
                    'value'=>'pick-up-date',
                    'label'=>__('Pick-up Date',ST_TEXTDOMAIN)
                ),
                'drop-off-time'=>array(
                    'value'=>'drop-off-time',
                    'label'=>__('Drop-off Time',ST_TEXTDOMAIN)
                ),
                'drop-off-date'=>array(
                    'value'=>'drop-off-date',
                    'label'=>__('Drop-off Date',ST_TEXTDOMAIN)
                ),
                'pick-up-time'=>array(
                    'value'=>'pick-up-time',
                    'label'=>__('Pick-up Time',ST_TEXTDOMAIN)
                ),
                'pick-up-date-time'=>array(
                    'value'=>'pick-up-date-time',
                    'label'=>__('Pick-up Date Time',ST_TEXTDOMAIN)
                ),
                'drop-off-date-time'=>array(
                    'value'=>'drop-off-date-time',
                    'label'=>__('Drop-off Date Time',ST_TEXTDOMAIN)
                ),
                'taxonomy'=>array(
                    'value'=>'taxonomy',
                    'label'=>__('Taxonomy',ST_TEXTDOMAIN)
                )

            );
        }

        function  _alter_search_query($where)
        {
            global $wp_query;
            if(is_search()){
                $post_type= $wp_query->query_vars['post_type'];

                if($post_type=='st_cars')
                {
                    //Alter From NOW
                    global $wpdb;

                    $check_in=STInput::get('pick-up-date');
                    $check_out=STInput::get('drop-off-date');



                    //Alter WHERE for check in and check out
                    if($check_in and $check_out) {
                        $check_in = @date('Y-m-d H:i:s', strtotime($check_in));
                        $check_out = @date('Y-m-d H:i:s', strtotime($check_out));

                        $check_in = esc_sql($check_in);
                        $check_out = esc_sql($check_out);


                        $where .= " AND $wpdb->posts.ID NOT IN
                            (
                                SELECT booked_id FROM (
                                    SELECT count(st_meta6.meta_value) as total_booked, st_meta5.meta_value as total,st_meta6.meta_value as booked_id ,st_meta2.meta_value as check_in,st_meta3.meta_value as check_out
                                         FROM {$wpdb->posts}
                                                JOIN {$wpdb->postmeta}  as st_meta2 on st_meta2.post_id={$wpdb->posts}.ID and st_meta2.meta_key='check_in'
                                                JOIN {$wpdb->postmeta}  as st_meta3 on st_meta3.post_id={$wpdb->posts}.ID and st_meta3.meta_key='check_out'
                                                JOIN {$wpdb->postmeta}  as st_meta6 on st_meta6.post_id={$wpdb->posts}.ID and st_meta6.meta_key='item_id'
                                                JOIN {$wpdb->postmeta}  as st_meta5 on st_meta5.post_id=st_meta6.meta_value and st_meta5.meta_key='number_car'
                                                WHERE {$wpdb->posts}.post_type='st_order'
                                        GROUP BY st_meta6.meta_value HAVING total<=total_booked AND (

                                                    ( CAST(st_meta2.meta_value AS DATE)<'{$check_in}' AND  CAST(st_meta3.meta_value AS DATE)>'{$check_in}' )
                                                    OR ( CAST(st_meta2.meta_value AS DATE)>='{$check_in}' AND  CAST(st_meta2.meta_value AS DATE)<='{$check_out}' )

                                        )
                                ) as item_booked
                            )

                    ";
                    }
                }
            }
            return $where;
        }

        static function get_price_car_by_order_item($id_item =null){
            if(empty($id_item))$id_item=get_the_ID();
            $total=0;
            $price = get_post_meta($id_item,'item_price',true);
            $check_in=get_post_meta($id_item,'check_in',true);
            $date = new DateTime($check_in);
            $check_in = $date->format('m/d/Y');

            $check_out=get_post_meta($id_item,'check_out',true);
            $date = new DateTime($check_out);
            $check_out = $date->format('m/d/Y');

            $check_in_time=get_post_meta($id_item,'check_in_time',true);
            $check_out_time=get_post_meta($id_item,'check_out_time',true);
            $time = ( strtotime($check_out.' '.$check_out_time) - strtotime($check_in.' '.$check_in_time)  ) / 3600 ;
            $item_equipment= get_post_meta($id_item,'item_equipment',true);
            $price_item = 0;
            if(!empty($item_equipment)){
                $json_decode=json_decode($item_equipment);

                // Check null for get_object_vars() function
                if($json_decode){
                    $item_equipment = get_object_vars($json_decode);
                    foreach($item_equipment as $k=>$v){
                        $price_item += $v;
                    }
                }

            }
            $number=get_post_meta($id_item,'item_number',true);
            if(!$number) $number=1;
            $total+= $price*$number * $time + $price_item;
            return $total;
        }


        static function get_info_price($post_id=null){

            if(!$post_id) $post_id=get_the_ID();
            $price=get_post_meta($post_id,'cars_price',true);
            $new_price=0;

            $discount=get_post_meta($post_id,'discount',true);
            $is_sale_schedule=get_post_meta($post_id,'is_sale_schedule',true);

            if($is_sale_schedule=='on')
            {
                $sale_from=get_post_meta($post_id,'sale_price_from',true);
                $sale_to=get_post_meta($post_id,'sale_price_to',true);
                if($sale_from and $sale_from){

                    $today=date('Y-m-d');
                    $sale_from = date('Y-m-d', strtotime($sale_from));
                    $sale_to = date('Y-m-d', strtotime($sale_to));
                    if (($today >= $sale_from) && ($today <= $sale_to))
                    {

                    }else{

                        $discount=0;
                    }

                }else{
                    $discount=0;
                }
            }
            if($discount){
                if($discount>100) $discount=100;

                $new_price=$price-($price/100)*$discount;
                $data = array(
                    'price'=>$new_price,
                    'price_old'=>$price,
                    'discount'=>$discount,

                );
            }else{
                $new_price=$price;
                $data = array(
                    'price'=>$new_price,
                    'discount'=>$discount,
                );
            }

            return apply_filters('st_car_info_price',$data,$post_id);
        }

        static function get_rental_price($price,$start,$end,$unit=false)
        {

            $diff_number=self::get_date_diff($start,$end);

            $rental_price = $price * $diff_number;

            $rental_price=apply_filters('st_car_rental_price',$rental_price,$price,$start,$end,$unit);

            return $rental_price;

        }

        static function get_date_diff($start,$end){

            $unit=self::get_price_unit();

            $format='%H';

            $datediff=STDate::timestamp_diff($start,$end);

            switch($unit){
                case "day":
                    $diff_number=ceil($datediff/24);
                    break;

                default:
                    $diff_number=$datediff;
                    break;
            }
            if($diff_number < 0)$diff_number=0;

            return $diff_number;
        }


        static function get_price_unit($need='value')
        {
            $unit=st()->get_option('cars_price_unit','day');
            $return=false;

            if($need=='value') $return= $unit;
            elseif($need=='label'){
                $all=self::get_option_price_unit();

                if(!empty($all))
                {
                    foreach($all as $key=>$value){
                        if($value['value']==$unit)
                        {
                            $return= $value['label'];
                        }
                    }
                }else $return= $unit;
            }

            elseif($need=='plural')
            {
                switch($unit){
                    case "hour":
                        $return=__("hours",ST_TEXTDOMAIN);
                        break;
                    case "day":
                        $return=__("days",ST_TEXTDOMAIN);
                        break;
                }

            }else{
                $return= $unit;
            }

            return apply_filters('st_get_price_unit',$return,$need);
        }

        static function get_option_price_unit()
        {
            return apply_filters('st_car_price_units', array(

                    array(
                        'value'     =>'day',
                        'label'     =>__('Day',ST_TEXTDOMAIN)
                    ),
                    array(
                        'value'     =>'hour',
                        'label'     =>__('Hour',ST_TEXTDOMAIN)
                    ),
                )
            );
        }

        static function get_owner_email($car_id)
        {
            return get_post_meta($car_id,'cars_email',true);
        }

        static function get_taxonomy_and_id_term_car(){
            $list_taxonomy = st_list_taxonomy('st_cars');
            $list_id_vc = array();
            $param = array();
            foreach($list_taxonomy as $k=>$v){
                $term = get_terms($v);
                if(!empty($term) and is_array($term)){
                    foreach($term as $key=>$value){
                        $list_value[$value->name]= $value->term_id;
                    }
                    $param[] = array(
                        "type" => "checkbox",
                        "holder" => "div",
                        "heading" => $k,
                        "param_name" => "id_term_".$v,
                        "value"=>$list_value,
                        'dependency' => array(
                            'element' => 'sort_taxonomy',
                            'value' => array( $v )
                        ),
                    );
                    $list_value = "";
                    $list_id_vc["id_term_".$v] = "";
                }
            }

            return array(
                "list_vc"=>$param,
                'list_id_vc'=>$list_id_vc
            );
        }
    }

    $a=new STCars();
    $a->init();
}
