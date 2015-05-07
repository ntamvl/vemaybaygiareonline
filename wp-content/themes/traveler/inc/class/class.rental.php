<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STRental
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STRental'))
{
    class STRental extends TravelerObject
    {
        protected  $post_type='st_rental';

        function __construct()
        {
            $this->orderby=array(
                'ID'       =>array(
                    'key'   =>'ID',
                    'name'  =>__('Date',ST_TEXTDOMAIN)
                ),
                'price_asc'=>array(
                    'key'=>'price_asc',
                    'name'=>__('Price (low to high)',ST_TEXTDOMAIN)
                ),
                'price_desc'=>array(
                    'key'=>'price_desc',
                    'name'=>__('Price (hight to low)',ST_TEXTDOMAIN)
                ),
                'name_asc'=>array(
                    'key'=>'name_asc',
                    'name'=>__('Name (A-Z)',ST_TEXTDOMAIN)
                ),
                'name_desc'=>array(
                    'key'=>'name_desc',
                    'name'=>__('Name (Z-A)',ST_TEXTDOMAIN)
                ),
            );
        }
        /**
         * @return array
         */
        public function getOrderby()
        {
            return $this->orderby;
        }

        function init()
        {
            parent::init();
//        $this->init_metabox();

//            'avg_rate'=>array(
//                'key'=>'avg_rate',
//                'name'=>__('Review',ST_TEXTDOMAIN)
//            )

            add_action('init',array($this,'init_metabox'));

            //Filter change layout of rental detail if choose in metabox
            add_filter('rental_single_layout',array($this,'custom_rental_layout'));

            add_filter('template_include', array($this,'choose_search_template'));

            //add Widget Area
            add_action('widgets_init',array($this,'add_sidebar'));

            //Sidebar Pos for SEARCH
            add_filter('st_rental_sidebar',array($this,'change_sidebar'));

            //Filter the search hotel
            add_action('pre_get_posts',array($this,'change_search_arg'));

            add_action('save_post', array($this,'update_sale_price'));

            add_action('init',array($this,'add_to_cart'));

            add_filter('st_search_preload_page',array($this,'_change_preload_search_title'));

            add_action('wp_enqueue_scripts',array($this,'_add_script'));


            //Save Rental Review Stats
            add_action( 'comment_post', array($this,'save_review_stats') );

            //        Change rental review arg
            add_filter('wp_review_form_args',array($this,'comment_args'),10,2);


        }
        function comment_args($comment_form,$post_id=false)
        {
            if(!$post_id) $post_id=get_the_ID();
            if(get_post_type($post_id)=='st_rental')
            {
                $stats=$this->get_review_stats();

                if($stats and is_array($stats))
                {
                    $stat_html='<ul class="list booking-item-raiting-summary-list stats-list-select">';

                    foreach($stats as $key=>$value)
                    {
                        $stat_html.='<li class=""><div class="booking-item-raiting-list-title">'.$value['title'].'</div>
                                                    <ul class="icon-group booking-item-rating-stars">
                                                    <li class=""><i class="fa fa-smile-o"></i>
                                                    </li>
                                                    <li class=""><i class="fa fa-smile-o"></i>
                                                    </li>
                                                    <li class=""><i class="fa fa-smile-o"></i>
                                                    </li>
                                                    <li class=""><i class="fa fa-smile-o"></i>
                                                    </li>
                                                    <li><i class="fa fa-smile-o"></i>
                                                    </li>
                                                </ul>
                                                <input type="hidden" class="st_review_stats" value="0" name="st_review_stats['.$value['title'].']">
                                                    </li>';
                    }
                    $stat_html.='</ul>';


                    $comment_form['comment_field']="
                        <div class='row'>
                            <div class=\"col-sm-8\">
                    ";
                    $comment_form['comment_field'].='<div class="form-group">
                                            <label>'.__('Review Title',ST_TEXTDOMAIN).'</label>
                                            <input class="form-control" type="text" name="comment_title">
                                        </div>';

                    $comment_form['comment_field'].='<div class="form-group">
                                            <label>'.__('Review Text').'</label>
                                            <textarea name="comment" id="comment" class="form-control" rows="6"></textarea>
                                        </div>
                                        </div><!--End col-sm-8-->
                                        ';

                    $comment_form['comment_field'].='<div class="col-sm-4">'.$stat_html.'</div></div><!--End Row-->';
                }
            }

            return $comment_form;
        }
        function save_review_stats($comment_id)
        {

            $comemntObj= get_comment( $comment_id );
            $post_id = $comemntObj->comment_post_ID;

            if(get_post_type($post_id)=='st_rental')
            {
                $all_stats=$this->get_review_stats();
                $st_review_stats=STInput::post('st_review_stats');

                if(!empty($all_stats) and is_array($all_stats))
                {
                    $total_point=0;
                    foreach($all_stats as $key=>$value)
                    {
                        if(isset($st_review_stats[$value['title']]))
                        {
                            $total_point+=$st_review_stats[$value['title']];
                            //Now Update the Each Stat Value
                            update_comment_meta( $comment_id, 'st_stat_'.sanitize_title($value['title']), $st_review_stats[$value['title']] );
                        }
                    }

                    $avg=round($total_point/count($all_stats),1);

                    //Update comment rate with avg point
                    $rate = wp_filter_nohtml_kses($avg);
                    if($rate>5)
                    {
                        //Max rate is 5
                        $rate=5;
                    }
                    update_comment_meta( $comment_id, 'comment_rate', $rate );
                    //Now Update the Stats Value
                    update_comment_meta( $comment_id, 'st_review_stats', $st_review_stats );
                }


            }
            //Class hotel do the rest
        }
        function  _alter_search_query($where)
        {
            global $wp_query;
            if(is_search()){
                $post_type= $wp_query->query_vars['post_type'];

                if($post_type=='st_rental')
                {
                    //Alter From NOW
                    global $wpdb;

                    $check_in=STInput::get('start');
                    $check_out=STInput::get('end');



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
                                                JOIN {$wpdb->postmeta}  as st_meta5 on st_meta5.post_id=st_meta6.meta_value and st_meta5.meta_key='rental_number'
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


        function _add_script()
        {
            if(is_singular('st_rental'))
            {
                wp_enqueue_script('single-rental',get_template_directory_uri().'/js/init/single-rental.js');
            }
        }


        function _change_preload_search_title($return)
        {
            if( get_query_var('post_type')=='st_rental')
            {
                $return=" Rentals";

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
        function get_cart_item_html($item_id){
            return st()->load_template('rental/cart_item_html',null,array('item_id'=>$item_id));
        }

        function add_to_cart()
        {
            if(STInput::request('action')=='rental_add_cart'){

                if(!STInput::request('start') or !STInput::request('end'))
                {
                    STTemplate::set_message(st_get_language('check_in_and_check_out_are_required'),'danger');
                    return;
                }

                //var_dump($_GET);die;

                $validate=$this->do_add_to_cart(array(
                    'item_id'=>STInput::request('item_id'),
                    'number_room'=>STInput::request('number_room'),
                    'price'=>STInput::request('price'),
                    'start'=>STInput::request('start'),
                    'end'=>STInput::request('end'),
                    'adult'             =>STInput::request('adult'),
                    'children'          =>STInput::request('children')
                ));

                if($validate)
                {
                    $link=STCart::get_cart_link();
                    wp_safe_redirect($link);
                    die;
                }


            }
        }
        function do_add_to_cart($array=array()){

            $form_validate=true;
            if(empty($array)) $array=STInput::post();
            $default=array(
                'item_id'=>'',
                'number_room'=>1,
                'price'=>'',
                'start'=>'',
                'end'=>'',
                'adult'         =>1,
                'children'      =>0,
            );

            $array=wp_parse_args($array,$default);

            extract($array);

            $data=array(
                'check_in'=>$start,
                'check_out'=>$end,
                'currency'=>TravelHelper::get_default_currency('symbol'),
                'adult'                     =>$adult,
                'children'                  =>$children
            );

            //Validate available number
            $form_validate=$this->_add_cart_check_available($item_id,$data);

            if($form_validate)
                $form_validate=apply_filters('st_rental_add_cart_validate',$form_validate);

            if($form_validate){
                STCart::add_cart($item_id,$number_room,$price,$data);
            }

            return $form_validate;

        }

        function _add_cart_check_available($post_id=false,$data=array())
        {
            if(!$post_id or get_post_status($post_id)!='publish')
            {
                STTemplate::set_message(__('Rental doese not exists',ST_TEXTDOMAIN),'danger');
                return false;
            }


            $validator=new STValidate();

            $validator->set_rules('start',__('Check in',ST_TEXTDOMAIN),'required');
            $validator->set_rules('end',__('Check out',ST_TEXTDOMAIN),'required');

            if(!$validator->run())
            {
                STTemplate::set_message($validator->error_string(),'danger');
                return false;
            }

            $check_in=date('Y-m-d H:i:s',strtotime(STInput::post('start')));
            $check_out=date('Y-m-d H:i:s',strtotime(STInput::post('end')));

            if(!$this->_is_slot_available($post_id,$check_in,$check_out))
            {
                STTemplate::set_message(__('Sorry! This rental is not available.',ST_TEXTDOMAIN),'danger');
                return false;
            }

            return true;

        }

        function _is_slot_available($post_id,$check_in,$check_out)
        {

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
            $total=(int)get_post_meta($post_id,'rental_number',true);

            if($total>$total_booked) return true;
            else return false;

        }

        function update_sale_price($post_id)
        {
            if(get_post_type($post_id)==$this->post_type)
            {
                $price=STRental::get_price($post_id);
                update_post_meta($post_id,'sale_price',$price);
            }
        }

        function get_search_fields()
        {
            $fields=st()->get_option('rental_search_fields');

            return $fields;
        }
        function get_search_adv_fields()
        {
            $fields=st()->get_option('rental_search_advance');

            return $fields;
        }
        static function get_search_fields_name()
        {
            return array(
                'location'=>array(
                    'value'=>'location',
                    'label'=>__('Location',ST_TEXTDOMAIN)
                ),
                'list_location'=>array(
                    'value'=>'list_location',
                    'label'=>__('Location List',ST_TEXTDOMAIN)
                ),
                'checkin'=>array(
                    'value'=>'checkin',
                    'label'=>__('Check in',ST_TEXTDOMAIN)
                ),
                'checkout'=>array(
                    'value'=>'checkout',
                    'label'=>__('Check out',ST_TEXTDOMAIN)
                ),
                'adult'=>array(
                    'value'=>'adult',
                    'label'=>__('Adult',ST_TEXTDOMAIN)
                ),
                'children'=>array(
                    'value'=>'children',
                    'label'=>__('Children',ST_TEXTDOMAIN)
                ),
                'room_num'=>array(
                    'value'=>'room_num',
                    'label'=>__('Rooms',ST_TEXTDOMAIN)
                ),
                'taxonomy'=>array(
                    'value'=>'taxonomy',
                    'label'=>__('Taxonomy',ST_TEXTDOMAIN)
                )

            );
        }

        function change_search_arg($query)
        {
            $post_type = get_query_var('post_type');

            $meta_query=array();

            if($query->is_search && $post_type == 'st_rental') {
                add_filter( 'posts_where' , array($this,'_alter_search_query') );

                $tax = STInput::get('taxonomy');

                if (!empty($tax) and is_array($tax)) {
                    $tax_query = array();
                    foreach ($tax as $key => $value) {
                        if ($value) {
                            $tax_query[] = array(
                                'taxonomy' => $key,
                                'terms' => explode(',', $value),
                                'COMPARE' => "IN"
                            );
                        }
                    }

                    $query->set('tax_query', $tax_query);
                }

                if ($location_id = STInput::get('location_id')) {
                    $ids_in=array();
                    $parents = get_posts( array( 'numberposts' => -1, 'post_status' => 'publish', 'post_type' => 'location', 'post_parent' => $location_id ));

                    $ids_in[]=$location_id;

                    foreach( $parents as $child ){
                        $ids_in[]=$child->ID;
                    }

                    $meta_query[]=array(
                        'key'=>'location_id',
                        'value'=>$ids_in,
                        'compare'=>'IN'
                    );

                    $query->set('s', '');
                }

                $is_featured = st()->get_option('is_featured_search_rental','off');
                if(!empty($is_featured) and $is_featured =='on'){
                    $query->set('meta_key','is_featured');
                    $query->set('orderby','meta_value');
                    $query->set('order','DESC');
                }

                if ($orderby = STInput::get('orderby')) {
                    switch ($orderby) {
                        case "price_asc":
                            $query->set('meta_key', 'sale_price');
                            $query->set('orderby', 'meta_value');
                            $query->set('order', 'asc');

                            break;
                        case "price_desc":
                            $query->set('meta_key', 'sale_price');
                            $query->set('orderby', 'meta_value');
                            $query->set('order', 'desc');

                            break;
                        case "avg_rate":
                            $query->set('meta_key', 'rate_review');
                            $query->set('orderby', 'meta_value');
                            $query->set('order', 'desc');

                            break;
                        case "name_asc":
                            $query->set('orderby','title');
                            $query->set('order','asc');

                            break;
                        case "name_desc":
                            $query->set('orderby','title');
                            $query->set('order','desc');

                            break;
                    }
                }

                if ($star = STInput::get('star_rate')) {
                    $meta_query[] = array(
                        'key' => 'rate_review',
                        'value' => explode(',', $star),
                        'compare' => "IN"
                    );
                }
                if ($price = STInput::get('price_range')) {
                    $priceobj = explode(';', $price);
                    $meta_query[] = array(
                        'key' => 'sale_price',
                        'value' => $priceobj[0],
                        'compare' => '>=',
                        'type' => "NUMERIC"
                    );
                    if (isset($priceobj[1])) {
                        $meta_query[] = array(
                            'key' => 'sale_price',
                            'value' => $priceobj[1],
                            'compare' => '<=',
                            'type' => "NUMERIC"
                        );
                    }

                    $meta_query['relation'] = 'and';
                }
                if (!empty($meta_query)) {
                    $query->set('meta_query', $meta_query);
                }
            }
            else{
                remove_filter( 'posts_where' , array($this,'_alter_search_query') );
            }

        }
        function change_sidebar()
        {
            return st()->get_option('rental_sidebar_pos','left');
        }

        function choose_search_template($template)
        {
            global $wp_query;
            $post_type = get_query_var('post_type');
            if( $wp_query->is_search && $post_type == 'st_rental' )
            {
                return locate_template('search-rental.php');  //  redirect to archive-search.php
            }
            return $template;
        }
        function add_sidebar()
        {
            register_sidebar( array(
                'name' => __( 'Rental Search Sidebar 1', ST_TEXTDOMAIN ),
                'id' => 'rental-sidebar',
                'description' => __( 'Widgets in this area will be shown on Rental', ST_TEXTDOMAIN),
                'before_title' => '<h4>',
                'after_title' => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget'  => '</div>',
            ) );

            register_sidebar( array(
                'name' => __( 'Rental Search Sidebar 2', ST_TEXTDOMAIN ),
                'id' => 'rental-sidebar-2',
                'description' => __( 'Widgets in this area will be shown on Rental', ST_TEXTDOMAIN),
                'before_title' => '<h4>',
                'after_title' => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget'  => '</div>',
            ) );


        }



        function  get_result_string()
        {
            global $wp_query;
            $result_string='';

            if($wp_query->found_posts){
                $result_string.=sprintf(_n('%s vacation rental ','%s vacation rentals ',$wp_query->found_posts,ST_TEXTDOMAIN),$wp_query->found_posts);
            }else{
                $result_string.=__('No rental found',ST_TEXTDOMAIN);
            }

            $location_id=STInput::get('location_id');
            if($location_id and $location=get_post($location_id))
            {
                $result_string.=' in '.get_the_title($location_id);
            }

            $start=STInput::get('start');
            $end=STInput::get('end');

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


        function custom_rental_layout($old_layout_id=false)
        {
            if(is_singular('st_rental'))
            {
                $meta=get_post_meta(get_the_ID(),'custom_layout',true);

                if($meta)
                {
                    return $meta;
                }
            }
            return $old_layout_id;
        }

        function get_near_by($post_id=false,$range=20,$limit=5)
        {
            $this->post_type='st_rental';
            return parent::get_near_by($post_id,$range,$limit);
        }
        function get_review_stats()
        {
            $review_stat=st()->get_option('rental_review_stats');

            return $review_stat;
        }

        function get_custom_fields()
        {
            return st()->get_option('rental_custom_fields',array());
        }

        function init_metabox()
        {
            $fields=$this->get_custom_fields();
            $meta=array();
            $additions_tabs=array();

            if(!empty($fields) and is_array($fields))
            {
                foreach($fields as $key=>$value){
                    $meta[]=array(
                        'label'         =>$value['title'],
                        'id'            =>isset($value['field_name'])?$value['field_name']:'pro_'.sanitize_key($value['title']),
                        'type'          =>$value['field_type'],
                        'desc'          =>$value['title']
                    );
                }
            }

            if(!empty($meta)):

                $additions_tabs[]=array(
                    'label'         =>__('Custom Fields',ST_TEXTDOMAIN),
                    'type'          =>'tab',
                    'id'            =>'addition_tab'
                );
                $additions_tabs=array_merge($additions_tabs,$meta);
            endif;

            $this->metabox[] = array(
                'id'          => 'st_location',
                'title'       => __( 'Rental Detail', ST_TEXTDOMAIN),
                'desc'        => '',
                'pages'       => array( 'st_rental' ),
                'context'     => 'normal',
                'priority'    => 'high',
                'fields'      => array(
                    array(
                        'label'       => __( 'Rental Information', ST_TEXTDOMAIN),
                        'id'          => 'detail_tab',
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
                        'id'          =>'rental_number',
                        'label'       =>__('Numbers',ST_TEXTDOMAIN),
                        'desc'        =>__('Number of rental available for booking',ST_TEXTDOMAIN),
                        'type'        =>'text',
                        'std'         =>1
                    ),
                    array(
                        'label'       => __( 'Custom Layout', ST_TEXTDOMAIN),
                        'id'          => 'custom_layout',
                        'post_type'        => 'st_layouts',
                        'desc'        => __( 'Address of Rental', ST_TEXTDOMAIN),
                        'type'        => 'select',
                        'choices'     => st_get_layout('st_rental')
                    ),
                    array(
                        'label'       => __( 'Location', ST_TEXTDOMAIN),
                        'id'          => 'location_id',
                        'type'        => 'post_select_ajax',
                        'desc'        => __( 'Location of Rental', ST_TEXTDOMAIN),
                        'post_type'   =>'location'
                    ),
                    array(
                        'label'       => __( 'Address', ST_TEXTDOMAIN),
                        'id'          => 'address',
                        'type'        => 'text',
                        'desc'        => __( 'Address of Rental', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Latitude', ST_TEXTDOMAIN),
                        'id'          => 'map_lat',
                        'type'        => 'text',
                        'desc'        => __( 'Latitude <a href="http://www.latlong.net/" target="_blank">Get here</a>', ST_TEXTDOMAIN),
                    ),

                    array(
                        'label'       => __( 'Longitude', ST_TEXTDOMAIN),
                        'id'          => 'map_lng',
                        'type'        => 'text',
                        'desc'        => __( 'Longitude', ST_TEXTDOMAIN),
                    ),

                    array(
                        'label'       => __( 'Map Zoom', ST_TEXTDOMAIN),
                        'id'          => 'map_zoom',
                        'type'        => 'text',
                        'desc'        => __( 'Map Zoom', ST_TEXTDOMAIN),
                        'std'         =>13
                    ),
                    array(
                        'label'       => __( 'Gallery', ST_TEXTDOMAIN),
                        'id'          => 'gallery',
                        'type'        => 'gallery',
                        'desc'        => __( 'Rental Gallery', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Video', ST_TEXTDOMAIN),
                        'id'          => 'video',
                        'type'        => 'text',
                        'desc'        => __( 'Youtube or Video url', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Agent Information', ST_TEXTDOMAIN),
                        'id'          => 'agent_tab',
                        'type'        => 'tab'
                    ),array(
                        'label'       => __( 'Agent Email', ST_TEXTDOMAIN),
                        'id'          => 'agent_email',
                        'type'        => 'text',
                        'desc'        => __( 'Agent Email. This email will received email about new booking', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Agent Website', ST_TEXTDOMAIN),
                        'id'          => 'agent_website',
                        'type'        => 'text',
                        'desc'        => __( 'Agent Website', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Agent Phone', ST_TEXTDOMAIN),
                        'id'          => 'agent_phone',
                        'type'        => 'text',
                        'desc'        => __( 'Agent Phone', ST_TEXTDOMAIN),
                    )
                ,array(
                        'label'       => __( 'Rental Price', ST_TEXTDOMAIN),
                        'id'          => 'price_tab',
                        'type'        => 'tab'
                    )
                ,array(
                        'label'       => sprintf( __( 'Price (%s)', ST_TEXTDOMAIN),TravelHelper::get_default_currency('symbol')),
                        'id'          => 'price',
                        'type'        => 'text',
                        'desc'        =>__('Regular Price',ST_TEXTDOMAIN)
                    )
                ,array(
                        'label'       => __( 'Discount Rate', ST_TEXTDOMAIN),
                        'id'          => 'discount_rate',
                        'type'        => 'text',
                        'desc'        =>__('Discount Rate By %',ST_TEXTDOMAIN)
                    )
                ,array(
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
                )
            );

            $custom_field = st()->get_option('rental_unlimited_custom_field');
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

//        if(!empty($additions_tabs)){
//            $this->metabox[0]['fields']=array_merge($this->metabox[0]['fields'],$additions_tabs);
//        }
        }

        static function get_price($post_id=false)
        {
            if(!$post_id) $post_id=get_the_ID();

            $price=get_post_meta($post_id,'price',true);
            $new_price=0;

            $discount=get_post_meta($post_id,'discount_rate',true);
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
            }else{
                $new_price=$price;
            }

            return $new_price;

        }
        static function get_orgin_price($post_id=false)
        {
            if(!$post_id) $post_id=get_the_ID();

            return  $price=get_post_meta($post_id,'price',true);

        }
        static function is_sale($post_id=false)
        {
            if(!$post_id) $post_id=get_the_ID();
            $discount=get_post_meta($post_id,'discount_rate',true);
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

            if($discount){ return true;}
            return false;
        }

        function change_post_class($class)
        {
            if(self::is_sale()){
                $class[]='is_sale';
            }

            return $class;
        }


        static function get_owner_email($item_id)
        {
            return get_post_meta($item_id,'agent_email',true);
        }

    }

    $rental=new STRental();
    $rental->init();
}
