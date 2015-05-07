<?php
    /**
     * @package WordPress
     * @subpackage Traveler
     * @since 1.0
     *
     * Class STTour
     *
     * Created by ShineTheme
     *
     */
    if(!class_exists('STTour'))
    {
        class STTour extends TravelerObject
        {
            protected $orderby;
            function __construct($tours_id=false)
            {
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
                        'name'=>__('Tours Name (A-Z)',ST_TEXTDOMAIN)
                    ),
                    'name_z_a'=>array(
                        'key'=>'name_z_a',
                        'name'=>__('Tours Name (Z-A)',ST_TEXTDOMAIN)
                    )
                );

            }
            public function getOrderby()
            {
                return $this->orderby;
            }

            function init()
            {
                parent::init();
                add_action('init',array($this,'init_metabox'));
                add_filter('st_tours_detail_layout',array($this,'custom_tour_layout'));

                // add to cart
                add_action('init',array($this,'tours_add_to_cart'));

                //custom search cars template
                add_filter('template_include', array($this,'choose_search_template'));

                //Filter the search hotel
                add_action('pre_get_posts',array($this,'change_search_tour_arg'));

                //add Widget Area
                add_action('widgets_init',array($this,'add_sidebar'));
                add_filter('st_search_preload_page',array($this,'_change_preload_search_title'));

                add_filter('st_tour_add_cart_validate',array($this,'_check_overdate_tour'),10,2);
            }
            function _check_overdate_tour($pass,$data)
            {
                if($data['type_tour'] == "specific_date"){
                    $date_now = new DateTime( );
                    $date_now = $date_now->format('d-m-Y');
                    $date_now = strtotime($date_now);

                    $date_tour = new DateTime( $data['check_in'] );
                    $date_tour = $date_tour->format('d-m-Y');
                    $date_tour = strtotime($date_tour);

                    if($date_now > $date_tour){
                        STTemplate::set_message(__('expired to book Tour online',ST_TEXTDOMAIN),'warning');
                        return false;
                    }else{
                        return true;
                    }
                }
                return true;
            }
            static function get_search_fields_name()
            {
                return array(
                    'address'=>array(
                        'value'=>'address',
                        'label'=>__('Address',ST_TEXTDOMAIN)
                    ),
                    'people'=>array(
                        'value'=>'people',
                        'label'=>__('People',ST_TEXTDOMAIN)
                    ),
                    'check_in'=>array(
                        'value'=>'check_in',
                        'label'=>__('Departure date',ST_TEXTDOMAIN)
                    ),
                    'check_out'=>array(
                        'value'=>'check_out',
                        'label'=>__('Arrive date',ST_TEXTDOMAIN)
                    ),
                    'taxonomy'=>array(
                        'value'=>'taxonomy',
                        'label'=>__('Taxonomy',ST_TEXTDOMAIN)
                    ),
                    'list_location'=>array(
                        'value'=>'list_location',
                        'label'=>__('Location List',ST_TEXTDOMAIN)
                    ),
                    'duration'=>array(
                        'value'=>'duration',
                        'label'=>__('Duration',ST_TEXTDOMAIN)
                    )
                );
            }
            function _change_preload_search_title($return)
            {
                if( get_query_var('post_type')=='st_tours')
                {
                    $return=" Tours";

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

            function add_sidebar()
            {
                register_sidebar( array(
                    'name' => __( 'Tours Search Sidebar 1', ST_TEXTDOMAIN ),
                    'id' => 'tours-sidebar',
                    'description' => __( 'Widgets in this area will be shown on Tours', ST_TEXTDOMAIN),
                    'before_title' => '<h4>',
                    'after_title' => '</h4>',
                    'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                    'after_widget'  => '</div>',
                ) );


                register_sidebar( array(
                    'name' => __( 'Tour Single Sidebar', ST_TEXTDOMAIN ),
                    'id' => 'tour-single-sidebar',
                    'description' => __( 'Widgets in this area will be shown on all tour.', ST_TEXTDOMAIN),
                    'before_title' => '<h4>',
                    'after_title' => '</h4>',
                    'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                    'after_widget'  => '</div>',
                ) );
            }

            function change_search_tour_arg($query)
            {

                $post_type = get_query_var('post_type');

                if($query->is_search && $post_type == 'st_tours')
                {

                    $tax=STInput::get('taxonomy');

                    if(!empty($tax) and is_array($tax))
                    {
                        $tax_query=array();
                        foreach($tax as $key=>$value)
                        {
                            if($value)
                            {
                                $tax_query[]=array(
                                    'taxonomy'=>$key,
                                    'terms'=>explode(',',$value),
                                    'COMPARE'=>"IN"
                                );
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
                            'key'=>'address',
                            'value'=>STInput::get('s'),
                            'compare'=>'like',
                        );
                    }

                    if($orderby=STInput::get('people'))
                    {
                        $meta_query[]=array(
                            'key'=>'max_people',
                            'value'=>STInput::get('people'),
                            'compare'=>'=',
                        );
                    }

                    if($orderby=STInput::get('duration'))
                    {
                        $meta_query[]=array(
                            'key'=>'duration_day',
                            'value'=>STInput::get('duration'),
                            'compare'=>'=',
                        );
                        $meta_query[]=array(
                            'key'=>'type_tour',
                            'value'=>'daily_tour',
                            'compare'=>'=',
                        );
                    }

                    $is_featured = st()->get_option('is_featured_search_tour','off');
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
                            'key'=>'price',
                            'value'=>$priceobj[0],
                            'compare'=>'>=',
                            'type'=>"NUMERIC"
                        );
                        if(isset($priceobj[1])){
                            $meta_query[]=array(
                                'key'=>'price',
                                'value'=>$priceobj[1],
                                'compare'=>'<=',
                                'type'=>"NUMERIC"
                            );
                        }
                        $meta_query['relation']='and';
                    }

                    if($price=STInput::get('start')){

                        $meta_query[]=array(
                            'key'=>'check_in',
                            'value'=>date('Y-m-d',strtotime($price=STInput::get('start'))),
                            'compare'=>'>=',
                        );
                        $meta_query['relation']='and';
                    }
                    if($price=STInput::get('end')){

                        $meta_query[]=array(
                            'key'=>'check_out',
                            'value'=>date('Y-m-d',strtotime($price=STInput::get('end'))),
                            'compare'=>'<=',
                        );
                        $meta_query['relation']='and';
                    }

                    if($star=STInput::get('star_rate')){
                        $meta_query[]=array(
                            'key'=>'rate_review',
                            'value'=>explode(',',$star),
                            'compare'=>"IN"
                        );
                    }

                    if(!empty($meta_query)){
                        $query->set('meta_query',$meta_query);
                    }



                }
            }
            function choose_search_template($template)
            {
                global $wp_query;
                $post_type = get_query_var('post_type');
                if( $wp_query->is_search && $post_type == 'st_tours' )
                {
                    return locate_template('search-tour.php');  //  redirect to archive-search.php
                }
                return $template;
            }

            function get_result_string()
            {
                global $wp_query;
                $result_string='';
                if($wp_query->found_posts > 1){
                    $result_string.=esc_html( $wp_query->found_posts).__(' tours ',ST_TEXTDOMAIN);
                }else{
                    $result_string.=esc_html( $wp_query->found_posts).__(' tour ',ST_TEXTDOMAIN);
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
            static function get_count_book($post_id=null){
                if(!$post_id) $post_id=get_the_ID();
                //  $post_type = get_post_type($id_post);
                $query = array(
                    'post_type'=>'st_order',
                    'post_per_page'=>'-1',
                    'meta_query'=>array(
                        array(
                            'key'=>'item_id',
                            'value'=>$post_id,
                            'compare'=>"="
                        )
                    ),
                );

                $query = new WP_Query( $query );
                wp_reset_query();
                return $query->post_count;
            }
            function tours_add_to_cart()
            {
                if(STInput::request('action')=='tours_add_to_cart')
                {
                    $rs=self::do_add_to_cart();

                    if($rs){

                        $link=STCart::get_cart_link();
                        wp_safe_redirect($link);
                        die;
                    }

                }

            }
            function do_add_to_cart()
            {
                $pass_validate=true;
                $item_id= STInput::request('item_id');
                $number = STInput::request('number');;
                $discount = STInput::request('discount');
                $price = STInput::request('price');
                if(!empty($discount)){
                    $price_sale =  $price - $price * ( $discount / 100 ) ;
                    $data = array(
                        'discount'=> $discount,
                        'price_sale'=>$price_sale,
                    );
                }
                $data['check_in'] = STInput::request('check_in');
                $data['check_out'] = STInput::request('check_out');
                $data['type_tour'] = STInput::request('type_tour');
                $data['type_price'] = STInput::request('type_price');

                if($data['type_price']=='people_price')
                {
                    $prices=self::get_price_person($item_id);
                    $data['adult_price']=$prices['adult'];
                    $data['child_price']=$prices['child'];
                    $data['discount']=$prices['discount'];
                    $data['adult_number']=STInput::request('adult_number',1);
                    $data['child_number']=STInput::request('children_number',0);
                }
                $data['duration']=STInput::request('duration');

                if($pass_validate)
                    $pass_validate=apply_filters('st_tour_add_cart_validate',$pass_validate,$data);


                if($pass_validate)
                    STCart::add_cart($item_id,$number,$price,$data);


                return $pass_validate;
            }
            function get_cart_item_html($item_id=false)
            {
                return st()->load_template('tours/cart_item_html',null,array('item_id'=>$item_id));
            }

            function custom_tour_layout($old_layout_id)
            {
                if(is_singular('st_tours'))
                {
                    $meta=get_post_meta(get_the_ID(),'st_custom_layout',true);

                    if($meta)
                    {
                        return $meta;
                    }
                }
                return $old_layout_id;
            }

            function get_search_fields()
            {
                $fields=st()->get_option('activity_tour_search_fields');
                return $fields;
            }

            static function get_info_price($post_id=null){

                if(!$post_id) $post_id=get_the_ID();
                $price=get_post_meta($post_id,'price',true);
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

                return $data;
            }

            static function get_price_person($post_id=null)
            {
                if(!$post_id) $post_id=get_the_ID();
                $adult_price=get_post_meta($post_id,'adult_price',true);
                $child_price=get_post_meta($post_id,'child_price',true);

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

                    $adult_price_new=$adult_price-($adult_price/100)*$discount;
                    $child_price_new=$child_price-($child_price/100)*$discount;
                    $data = array(
                        'adult'=>$adult_price,
                        'adult_new'=>$adult_price_new,
                        'child'=>$child_price,
                        'child_new'=>$child_price_new,
                        'discount'=>$discount,

                    );
                }else{
                    $data = array(
                        'adult_new'=>$adult_price,
                        'adult'    =>$adult_price,
                        'child'     =>$child_price,
                        'child_new'=>$child_price,
                        'discount'=>$discount,
                    );
                }

                return $data;
            }

            static function get_price_html($post_id=false,$get=false,$st_mid='')
            {
                if(!$post_id) $post_id=get_the_ID();

                $html='';

                $type_price = get_post_meta($post_id,'type_price',true);
                if($type_price=='people_price')
                {
                    $prices=self::get_price_person($post_id);

                    $adult_html='';

                    $adult_new_html='<span class="text-lg lh1em  ">'.TravelHelper::format_money($prices['adult_new']).'</span>';

                    // Check on sale
                    if(isset($prices['adult']) and $prices['adult'] and $prices['discount'])
                    {
                        $adult_html='<span class="text-small lh1em  onsale">'.TravelHelper::format_money($prices['adult']).'</span>&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i>';

                        $html.=sprintf(__('Adult: %s %s',ST_TEXTDOMAIN),$adult_html,$adult_new_html);
                    }else{
                        $html.=sprintf(__('Adult: %s',ST_TEXTDOMAIN),$adult_new_html);
                    }

                    $child_new_html='<span class="text-lg lh1em  ">'.TravelHelper::format_money($prices['child_new']).'</span>';


                    // Price for child
                    if($prices['child_new'])
                    {
                        $html.=' '.$st_mid.' ';

                        // Check on sale
                        if(isset($prices['child']) and $prices['child'] and $prices['discount'])
                        {
                            $child_html='<span class="text-small lh1em  onsale">'.TravelHelper::format_money($prices['child']).'</span>&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i>';

                            $html.=sprintf(__('Children: %s %s',ST_TEXTDOMAIN),$child_html,$child_new_html);
                        }else{
                            $html.=sprintf(__('Children: %s',ST_TEXTDOMAIN),$child_new_html);
                        }

                    }

                }
                else
                {
                    $prices=self::get_info_price($post_id);

                    if(isset($prices['price_old']) and $prices['price_old'] and $prices['discount'])
                    {
                        $html.='<span class="text-small lh1em  onsale">'.TravelHelper::format_money($prices['price_old']).'</span>&nbsp;&nbsp;<i class="fa fa-long-arrow-right"></i>';

                        $html.='<span class="text-lg lh1em  ">'.TravelHelper::format_money($prices['price']).'</span>';

                    }else {
                        $html.='<span class="text-lg lh1em  ">'.TravelHelper::format_money($prices['price']).'</span>';

                    }
                }

                return apply_filters('st_get_tour_price_html',$html);
            }
            static function get_cart_item_total($item_id,$item)
            {
                $count_sale=0;
                $price_sale = $item['price'];
                if(!empty($item['data']['discount'])){
                    $count_sale = $item['data']['discount'];
                    $price_sale = $item['data']['price_sale'] * $item['number'];
                }

                $type_price=$item['data']['type_price'];

                if($type_price=='people_price')
                {
                    $adult_num=$item['data']['adult_number'];
                    $child_num=$item['data']['child_number'];
                    $adult_price=$item['data']['adult_price'];
                    $child_price=$item['data']['child_price'];


                    $total_price=$adult_num*st_get_discount_value($adult_price,$count_sale,false);
                    $total_price+=$child_num*st_get_discount_value($child_price,$count_sale,false);

                    return $total_price;
                }else
                {
                    $price = $price_sale * $item['number'];
                    return $price;
                }

            }

            function init_metabox()
            {
                //Room
                $this->metabox[] = array(
                    'id'          => 'room_metabox',
                    'title'       => __( 'Tour Setting', ST_TEXTDOMAIN),
                    'desc'        => '',
                    'pages'       => array( 'st_tours' ),
                    'context'     => 'normal',
                    'priority'    => 'high',
                    'fields'      => array(
                        array(
                            'label'       => __( 'General', ST_TEXTDOMAIN),
                            'id'          => 'room_reneral_tab',
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
                            'label'       => __( 'Custom Layout', ST_TEXTDOMAIN),
                            'id'          => 'st_custom_layout',
                            'post_type'   =>'st_layouts',
                            'desc'        => __( 'Detail Tour Layout', ST_TEXTDOMAIN),
                            'type'        => 'select',
                            'choices'     => st_get_layout('st_tours')
                        ),

                        array(
                            'label'       => __( 'Gallery', ST_TEXTDOMAIN),
                            'id'          => 'gallery',
                            'type'        => 'gallery',
                            'desc'        => __( '', ST_TEXTDOMAIN),
                        ),
                        array(
                            'label'       => __( 'Gallery style', ST_TEXTDOMAIN),
                            'id'          => 'gallery_style',
                            'type'        => 'select',
                            'desc'        => __( '', ST_TEXTDOMAIN),
                            'choices'   =>array(
                                array(
                                    'value'=>'grid',
                                    'label'=>__('Grid',ST_TEXTDOMAIN)
                                ),
                                array(
                                    'value'=>'slider',
                                    'label'=>__('Slider',ST_TEXTDOMAIN)
                                ),
                            )
                        ),

                        array(
                            'label'       => __( 'Contact email addresses', ST_TEXTDOMAIN),
                            'id'          => 'contact_email',
                            'type'        => 'text',
                            'desc'        => __( 'Contact email addresses', ST_TEXTDOMAIN),
                        ),
                        array(
                            'label'       => __( 'Video', ST_TEXTDOMAIN),
                            'id'          => 'video',
                            'type'        => 'text',
                            'desc'        => __('Please use youtube or vimeo video',ST_TEXTDOMAIN)
                        ),
                        array(
                            'label'       => __( 'Location', ST_TEXTDOMAIN),
                            'id'          => 'location_reneral_tab',
                            'type'        => 'tab'
                        ),
                        array(
                            'label'       => __( 'Location', ST_TEXTDOMAIN),
                            'id'          => 'id_location',
                            'type'        => 'post_select_ajax',
                            'desc'        => __( '', ST_TEXTDOMAIN),
                            'post_type'   =>'location'
                        ),
                        array(
                            'label'       => __( 'Address', ST_TEXTDOMAIN),
                            'id'          => 'address',
                            'type'        => 'text',
                            //'desc'        => __( 'Longitude', ST_TEXTDOMAIN),
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
                            'label'       => __( 'Price setting', ST_TEXTDOMAIN),
                            'id'          => 'price_number_tab',
                            'type'        => 'tab'
                        ),
                        array(
                            'label'       => __( 'Type Price', ST_TEXTDOMAIN),
                            'id'          => 'type_price',
                            'type'        => 'select',
                            'desc'        => __( 'Type Price', ST_TEXTDOMAIN),
                            'choices'   =>array(
                                array(
                                    'value'=>'tour_price',
                                    'label'=>__('Price / Tour',ST_TEXTDOMAIN)
                                ),
                                array(
                                    'value'=>'people_price',
                                    'label'=>__('Price / Person',ST_TEXTDOMAIN)
                                ),
                            )
                        ),
                        array(
                            'label'       => __( 'Price', ST_TEXTDOMAIN),
                            'id'          => 'price',
                            'type'        => 'text',
                            'desc'        => __( 'Price of this tour', ST_TEXTDOMAIN),
                            'std'         =>0,
                            'condition'   =>'type_price:is(tour_price)'
                        ),
                        array(
                            'label'       => __( 'Adult Price', ST_TEXTDOMAIN),
                            'id'          => 'adult_price',
                            'type'        => 'text',
                            'desc'        => __( 'Price per Adult', ST_TEXTDOMAIN),
                            'std'         =>0,
                            'condition'   =>'type_price:is(people_price)'
                        ),
                        array(
                            'label'       => __( 'Child Price', ST_TEXTDOMAIN),
                            'id'          => 'child_price',
                            'type'        => 'text',
                            'desc'        => __( 'Price per Child', ST_TEXTDOMAIN),
                            'std'         =>0,
                            'condition'   =>'type_price:is(people_price)'
                        ),
                        array(
                            'label'       => __( 'Discount by percent', ST_TEXTDOMAIN),
                            'id'          => 'discount',
                            'type'        => 'text',
                            'desc'        => __( 'Discount of this tour, by percent', ST_TEXTDOMAIN),
                            'std'         =>0
                        ),
                        array(
                            'label'       =>  __( 'Sale Schedule', ST_TEXTDOMAIN),
                            'id'          => 'is_sale_schedule',
                            'type'        => 'on-off',
                            'std'        => 'off',
                        ),
                        array(
                            'label'       =>  __( 'Sale Start Date', ST_TEXTDOMAIN),
                            'desc'       =>  __( 'Sale Start Date', ST_TEXTDOMAIN),
                            'id'          => 'sale_price_from',
                            'type'        => 'date-picker',
                            'condition'   =>'is_sale_schedule:is(on)'
                        ),

                        array(
                            'label'       =>  __( 'Sale End Date', ST_TEXTDOMAIN),
                            'desc'       =>  __( 'Sale End Date', ST_TEXTDOMAIN),
                            'id'          => 'sale_price_to',
                            'type'        => 'date-picker',
                            'condition'   =>'is_sale_schedule:is(on)'
                        ),
                        array(
                            'label'       => __( 'Information', ST_TEXTDOMAIN),
                            'id'          => 'st_info_tours_tab',
                            'type'        => 'tab'
                        ),
                        array(
                            'label'       => __( 'Type Tour', ST_TEXTDOMAIN),
                            'id'          => 'type_tour',
                            'type'        => 'select',
                            'desc'        =>__('Type Tour',ST_TEXTDOMAIN),
                            'choices'   =>array(
                                array(
                                    'value'=>'daily_tour',
                                    'label'=>__('Daily Tour',ST_TEXTDOMAIN)
                                ),
                                array(
                                    'value'=>'specific_date',
                                    'label'=>__('Specific Date',ST_TEXTDOMAIN)
                                ),
                            )
                        ),
                        array(
                            'label'       => __( 'Departure date ', ST_TEXTDOMAIN),
                            'id'          => 'check_in',
                            'type'        => 'date_picker',
                            'condition'   =>'type_tour:is(specific_date)',
                            'desc'        => __( 'Departure date ', ST_TEXTDOMAIN),
                        ),
                        array(
                            'label'       => __( 'Arrive date', ST_TEXTDOMAIN),
                            'id'          => 'check_out',
                            'type'        => 'date_picker',
                            'condition'   =>'type_tour:is(specific_date)',
                            'desc'        => __( 'Arrive date', ST_TEXTDOMAIN)
                        ),
                        array(
                            'label'       => __( 'Duration (days)', ST_TEXTDOMAIN),
                            'id'          => 'duration_day',
                            'type'        => 'text',
                            'desc'        => __( 'Duration (days)', ST_TEXTDOMAIN),
                            'std'         => '1',
                            'condition'   =>'type_tour:is(daily_tour)'
                        ),
                        array(
                            'label'       => __( 'Max number of people', ST_TEXTDOMAIN),
                            'id'          => 'max_people',
                            'type'        => 'text',
                            'desc'        => __( 'Max number of people', ST_TEXTDOMAIN),
                            'std'         => '1',
                        ),
                        array(
                            'id'          => 'tours_program',
                            'label'       => __( "Tour's program ", ST_TEXTDOMAIN ),
                            'type'        => 'list-item',
                            'settings'    =>array(
                                array(
                                    'id'=>'desc',
                                    'label'=>__('Description',ST_TEXTDOMAIN),
                                    'type'=>'textarea',
                                    'rows'        => '5',
                                )
                            )
                        ),


                        /* array(
                             'label'       => __( 'Sale setting', ST_TEXTDOMAIN),
                             'id'          => 'sale_number_tab',
                             'type'        => 'tab'
                         ),

                         array(
                             'label'       => __( 'Total Sale Number', ST_TEXTDOMAIN),
                             'id'          => 'total_sale_number',
                             'type'        => 'text',
                             'desc'        => __( 'Total Number Booking of this hotel', ST_TEXTDOMAIN),
                             'std'         =>0
                         ),*/

                        /*array(
                            'label'       => __( 'Rate setting', ST_TEXTDOMAIN),
                            'id'          => 'rate_number_tab',
                            'type'        => 'tab'
                        ),*/

                        /*  array(
                              'label'       => __( 'Avg Rate Review', ST_TEXTDOMAIN),
                              'id'          => 'rate_review',
                              'type'        => 'numeric-slider',
                              'min_max_step'=> '1,5,1',
                              'desc'        => __( '', ST_TEXTDOMAIN),
                          ),*/
                    )
                );
                $custom_field = st()->get_option('tours_unlimited_custom_field');
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
            function get_near_by($post_id=false,$range=20, $limit = 5)
            {
                $this->post_type='st_tours';
                $limit = st()->get_option('tours_similar_tour',5);
                return parent::get_near_by($post_id,$range, $limit);
            }
            static function get_owner_email($item_id)
            {
                return get_post_meta($item_id,'contact_email',true);
            }

        }
        $a=new STTour();
        $a->init();
    }
