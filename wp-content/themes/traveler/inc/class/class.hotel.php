<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STHotel
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STHotel'))
{
    class STHotel extends TravelerObject
    {
        //Current Hotel ID
        private $hotel_id;

        protected $orderby;

        protected $post_type='st_hotel';

        function __construct($hotel_id=false)
        {

            $this->hotel_id=$hotel_id;
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

            //Add metabox
            add_action('init',array($this,'init_metabox'));


            add_action('template_redirect',array($this,'ajax_search_room'),1);

            //Filter the search hotel
            add_action('pre_get_posts',array($this,'change_search_hotel_arg'));


            //custom search hotel template
            add_filter('template_include', array($this,'choose_search_template'));


            //Sidebar Pos for SEARCH
            add_filter('st_hotel_sidebar',array($this,'change_sidebar'));

            //add Widget Area
            add_action('widgets_init',array($this,'add_sidebar'));

            //Create Hotel Booking Link
            add_action('init',array($this,'hotel_add_to_cart'));

//        Change hotel review arg
            add_filter('wp_review_form_args',array($this,'comment_args'),10,2);

            //Save Hotel Review Stats
            add_action( 'comment_post', array($this,'save_review_stats') );

            //Reduce total stats of posts after comment_delete
            add_action('delete_comment',array($this,'save_post_review_stats'));


            //Filter change layout of hotel detail if choose in metabox
            add_filter('st_hotel_detail_layout',array($this,'custom_hotel_layout'));

            add_action('wp_enqueue_scripts',array($this,'add_localize'));

            add_action('wp_ajax_ajax_search_room',array($this,'ajax_search_room'));
            add_action('wp_ajax_nopriv_ajax_search_room',array($this,'ajax_search_room'));


            add_action('st_single_breadcrumb',array($this,'add_breadcrumb'));



            add_filter('st_real_comment_post_id',array($this,'_change_comment_post_id'));

            add_filter('st_search_preload_page',array($this,'_change_preload_search_title'));

            add_action('st_after_checkout_fields',array($this,'_add_room_number_field'));
            add_filter('st_checkout_form_validate',array($this,'_add_validate_fields'));

        }

        function _add_room_number_field($post_type=false)
        {

            if($post_type=='hotel_room')
            {
                echo st()->load_template('hotel/checkout_fields',null,array('key'=>get_the_ID()));
                return;
            }else{
                $is_hotel=false;
                $items=STCart::get_items();
                if(!empty($items))
                {
                    foreach($items as $key=>$value){
                        if(get_post_type($key)=='st_hotel'){
                            {
                                echo st()->load_template('hotel/checkout_fields',null,array('key'=>$key,'value'=>$value));
                                return;
                            }

                        }
                    }
                }
            }

        }
        function _is_hotel_booking()
        {
            $items=STCart::get_items();
            if(!empty($items)) {
                foreach ($items as $key => $value) {
                    if (get_post_type($key) == 'st_hotel') return true;
                }
            }
        }
        function _add_validate_fields($validate)
        {
            $items=STCart::get_items();
            if(!empty($items)) {
                foreach ($items as $key => $value) {
                    if (get_post_type($key) == 'st_hotel'){

                        // validate

                        $default=array(
                            'number'=>1
                        );

                        $value=wp_parse_args($value,$default);

                        $room_num=$value['number'];

                        $room_data=STInput::request('room_data',array());

                        if($room_num>1){

                            if(!is_array($room_data) or empty($room_data))
                            {
                                STTemplate::set_message(__('Room infomation is required',ST_TEXTDOMAIN),'danger');
                                $validate=false;
                            }else{

                                for($k=1;$k<=$room_num;$k++)
                                {
                                    $valid=true;
                                    if(!isset($room_data[$k]['adult_num']) or !$room_data[$k]['adult_num']){
                                        STTemplate::set_message(__('Adult number in room is required!',ST_TEXTDOMAIN),'danger');
                                        $valid=false;
                                    }
                                    if(!isset($room_data[$k]['host_name']) or !$room_data[$k]['host_name']){
                                        STTemplate::set_message(__('Room Host Name is required!',ST_TEXTDOMAIN),'danger');
                                        $valid=false;
                                    }

                                    if(isset($room_data[$k]['child_num']))
                                    {
                                        $child_num=(int)$room_data[$k]['child_num'];

                                        if($child_num>0){
                                            if(!isset($room_data[$k]['age_of_children']) or !is_array($room_data[$k]['age_of_children']) or empty($room_data[$k]['age_of_children']))
                                            {
                                                STTemplate::set_message(__('Ages of Children is required!',ST_TEXTDOMAIN),'danger');
                                                $valid=false;
                                            }else{
                                                foreach($room_data[$k]['age_of_children'] as $k2=>$v2){
                                                    if(!$v2){
                                                        STTemplate::set_message(__('Ages of Children is required!',ST_TEXTDOMAIN),'danger');
                                                        $valid=false;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    if(!$valid){
                                        $validate=false;
                                        break;
                                    }



                                }
                            }

                        }


                    }
                }
            }

            return $validate;
        }
        function _change_preload_search_title($return)
        {

            if( get_query_var('post_type')=='st_hotel')
            {
                $return=" Hotels";

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
        function _change_comment_post_id($id_item)
        {


            return $id_item;
        }

        function add_breadcrumb($sep)
        {
            $location_id=get_post_meta(get_the_ID(),'id_location',true);

            if(!$location_id){
                $location_id=get_post_meta(get_the_ID(),'location_id',true);
            }

            $array=array();
            $parents=get_post_ancestors($location_id);
            if(!empty($parents) and is_array($parents))
            {
                foreach($parents as $key=>$value){
                    $link=get_home_url('/');
                    //.'&post_type='.get_post_type().'&location_id='.$value;
                    $link=esc_url(add_query_arg(array('post_type'=>get_post_type(),
                        'location_id'=>$value,'s'=>get_the_title($value)),$link));
                    echo '<li><a href="'.$link.'">'.get_the_title($value).'</a></li>';
                }
            }

            //var_dump($location_id);
            if($location_id){

                $link=get_home_url('/');
                $link=esc_url(add_query_arg(array('post_type'=>get_post_type(),
                    'location_id'=>$location_id,'s'=>get_the_title($location_id)),$link));
                echo '<li><a href="'.$link.'">'.get_the_title($location_id).'</a></li>';
            }



        }



        function add_localize(){
            wp_localize_script('jquery','st_hotel_localize',array(
                'booking_required_adult'=>__('Please select adult number',ST_TEXTDOMAIN),
                'booking_required_children'=>__('Please select children number',ST_TEXTDOMAIN),
                'booking_required_adult_children'=>__('Please select Adult and  Children number',ST_TEXTDOMAIN),
                'room'                      =>__('Room',ST_TEXTDOMAIN),
                'is_aoc_fail'               =>__('Please select the ages of children',ST_TEXTDOMAIN),
                'is_not_select_date'        =>__('Please select Check-in and Check-out date',ST_TEXTDOMAIN),
                'is_host_name_fail'         =>__('Please provide Host Name(s)',ST_TEXTDOMAIN)
            ));
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

        function count_offers($post_id=false)
        {
            if(!$post_id) $post_id=$this->hotel_id;
            //Count Rooms
            $arg=array(
                'post_type'=>'hotel_room',
                'posts_per_page'=>1,
                'meta_key'=>'room_parent',
                'meta_value'=>$post_id
            );

            $q=new WP_Query($arg);
            $count= $q->found_posts;

            wp_reset_query();

            return $count;

        }
        function get_search_fields()
        {
            $fields=st()->get_option('hotel_search_fields');

            return $fields;
        }
        function get_search_adv_fields()
        {
            $fields=st()->get_option('hotel_search_advance');

            return $fields;
        }

        function custom_hotel_layout($old_layout_id)
        {
            if(is_singular($this->post_type))
            {
                $meta=get_post_meta(get_the_ID(),'st_custom_layout',true);

                if($meta)
                {
                    return $meta;
                }
            }
            return $old_layout_id;
        }



        function save_review_stats($comment_id)
        {
            $comemntObj= get_comment( $comment_id );
            $post_id = $comemntObj->comment_post_ID;

            if(get_post_type($post_id)=='st_hotel')
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


            if(STInput::post('comment_rate'))
            {
                update_comment_meta( $comment_id, 'comment_rate', STInput::post('comment_rate') );

            }
            //review_stats
            $avg=STReview::get_avg_rate($post_id);

            update_post_meta($post_id,'rate_review',$avg);
        }

        function save_post_review_stats($comment_id)
        {
            $comemntObj= get_comment( $comment_id );
            $post_id = $comemntObj->comment_post_ID;

            $avg=STReview::get_avg_rate($post_id);

            update_post_meta($post_id,'rate_review',$avg);
        }


        function get_review_stats()
        {
            $review_stat=st()->get_option('hotel_review_stats');

            return $review_stat;
        }

        function get_review_stats_metabox()
        {
            $review_stat=st()->get_option('hotel_review_stats');

            $result=array();

            if(!empty($review_stat))
            {
                foreach($review_stat as $key=>$value)
                {
                    $result[]=array(
                        'label'=>$value['title'],
                        'value'=>sanitize_title($value['title'])
                    );
                }

            }

            return $result;
        }

        function comment_args($comment_form,$post_id=false)
        {
            if(!$post_id) $post_id=get_the_ID();
            if(get_post_type($post_id)=='st_hotel')
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
        function hotel_add_to_cart()
        {
            if(STInput::request('action')=='hotel_add_to_cart')
            {

                $return=$this->do_add_to_cart(array(
                    'item_id'=>STInput::request('item_id'),
                    'number_room'=>STInput::request('room_num_search'),
                    'price'=>STInput::request('price'),
                    'check_in'=>STInput::request('check_in'),
                    'check_out'=>STInput::request('check_out'),
                    'room_num_search'=>STInput::request('room_num_search'),
                    'room_id'=>STInput::request('room_id'),
                    'adult_num'=>STInput::request('adult_num'),
                    'child_num'=>STInput::request('child_num')
                ));

                if($return) {

                    $link = STCart::get_cart_link();
                    wp_safe_redirect($link);
                    die;
                }
            }

        }

        function do_add_to_cart($array=array()){

            $pass_validate=true;

            $default=array(
                'item_id'=>'',
                'number_room'=>1,
                'price'=>'',
                'check_in'=>'',
                'check_out'=>'',
                'room_num_search'=>'',
                'room_id'=>'',
                'adult_num'=>1,
                'child_num'=>0
            );


//        var_dump($array);

            $array=wp_parse_args($array,$default);

            extract($array);

            $data=array(
                'check_in'=>$check_in,
                'check_out'=>$check_out,
                'currency'=>TravelHelper::get_default_currency('symbol'),
                'room_num_search'=>$room_num_search,
                'room_id'=>$room_id,
                'room_data'=>array(),
                'adult_num'=>$adult_num,
                'child_num'=>$child_num
            );

            if(!$this->_is_slot_available($room_id,$check_in,$check_out))
            {
                STTemplate::set_message(__('Sorry! This Room is not available.',ST_TEXTDOMAIN),'danger');
                $pass_validate= false;
            }

            if($pass_validate)
            {
                $pass_validate=apply_filters('st_hotel_add_cart_validate',$pass_validate,$array);
            }


            if($pass_validate)
                STCart::add_cart($item_id,$number_room,$price,$data);

            return $pass_validate;

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
                                                JOIN {$wpdb->postmeta}  as st_meta6 on st_meta6.post_id={$wpdb->posts}.ID and st_meta6.meta_key='room_id'
                                                WHERE {$wpdb->posts}.post_type='st_order'
                                                AND st_meta6.meta_value={$post_id}
                                          GROUP BY {$wpdb->posts}.id HAVING  (

                                                    ( CAST(st_meta2.meta_value AS DATE)<'{$check_in}' AND  CAST(st_meta3.meta_value AS DATE)>'{$check_in}' )
                                                    OR ( CAST(st_meta2.meta_value AS DATE)>='{$check_in}' AND  CAST(st_meta2.meta_value AS DATE)<='{$check_out}'))) as object_booked
        ";

            $total_booked=(int)$wpdb->get_var($query);


            $total=(int)get_post_meta($post_id,'number_room',true);

            if($total>$total_booked) return true;
            else return false;

        }

        function get_cart_item_html($item_id=false)
        {
            return st()->load_template('hotel/cart_item_html',null,array('item_id'=>$item_id));
        }
        function add_sidebar()
        {
            register_sidebar( array(
                'name' => __( 'Hotel Search Sidebar 1', ST_TEXTDOMAIN ),
                'id' => 'hotel-sidebar',
                'description' => __( 'Widgets in this area will be shown on Hotel', ST_TEXTDOMAIN),
                'before_title' => '<h4>',
                'after_title' => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget'  => '</div>',
            ) );

            register_sidebar( array(
                'name' => __( 'Hotel Search Sidebar 2', ST_TEXTDOMAIN ),
                'id' => 'hotel-sidebar-2',
                'description' => __( 'Widgets in this area will be shown on Hotel', ST_TEXTDOMAIN),
                'before_title' => '<h4>',
                'after_title' => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget'  => '</div>',
            ) );


        }

        function change_sidebar($sidebar=false)
        {
            return st()->get_option('hotel_sidebar_pos','left');
        }

        function get_result_string()
        {
            global $wp_query;
            $result_string='';

            if($wp_query->found_posts){
                $result_string.=sprintf(_n('%s hotel','%s hotels',$wp_query->found_posts,ST_TEXTDOMAIN),$wp_query->found_posts);
            }else{
                $result_string.=__('No hotel found',ST_TEXTDOMAIN);
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



        function ajax_search_room()
        {
            if(st_is_ajax() and STInput::post('room_search'))
            {
                if (!wp_verify_nonce(STInput::post('room_search'), 'room_search'))
                {
                    $result=array(
                        'status'=>0,
                        'data'=>"",
                    );

                    echo json_encode($result);
                    die;
                }



                $result=array(
                    'status'=>1,
                    'data'=>"",
                );

                $hotel_id=get_the_ID();
                $post=STInput::request();
                $post['room_parent']=$hotel_id;

                //Check Date

                $check_in=strtotime($post['start']);
                $check_out=strtotime($post['end']);
                $date_diff=STDate::date_diff($check_in,$check_out);


                if($date_diff<1){
                    $result=array(
                        'status'=>0,
                        'data'=>"",
                        'message'=>__('Make sure your check-out date is at least 1 day after check-in.',ST_TEXTDOMAIN),
                        'more-data'=>$date_diff
                    );

                    echo json_encode($result);
                    die;
                }

                query_posts($this->search_room($post));




                $post['check_in']=date('d-m-Y',strtotime($post['start']));
                $post['check_out']=date('d-m-Y',strtotime($post['end']));
                global $wp_query;


                if(have_posts())
                {
                    while(have_posts())
                    {
                        the_post();
                        $result['data'].=st()->load_template('hotel/elements/loop-room-item');
                    }

                }else{
                    $result['data'].=st()->load_template('hotel/elements/loop-room-none');

                }

                wp_reset_query();

                echo json_encode($result);

                die();
            }
        }

        function get_search_arg($param)
        {
            $default=array(
                's'=>false
            );

            extract(wp_parse_args($param,$default));

            $arg=array();

            return $arg;

        }

        function choose_search_template($template)
        {
            global $wp_query;
            $post_type = get_query_var('post_type');
            if( $wp_query->is_search && $post_type == 'st_hotel' )
            {
                return locate_template('search-hotel.php');  //  redirect to archive-search.php
            }
            return $template;
        }

        function  _alter_search_query($where)
        {
            if(is_admin()) return $where;
            global $wp_query;
            if(is_search()){
                $post_type= $wp_query->query_vars['post_type'];

                if($post_type=='st_hotel' and is_search())
                {
                    //Alter From NOW
                    global $wpdb;

                    $check_in=STInput::get('start');
                    $check_out=STInput::get('end');



                    //Alter WHERE for check in and check out
                    if($check_in and $check_out)
                    {
                        $check_in=@date('Y-m-d',strtotime($check_in));
                        $check_out=@date('Y-m-d',strtotime($check_out));

                        $check_in=esc_sql($check_in);
                        $check_out=esc_sql($check_out);

                        $where.=" AND $wpdb->posts.ID in ((SELECT {$wpdb->postmeta}.meta_value
                        FROM {$wpdb->postmeta}
                        WHERE {$wpdb->postmeta}.meta_key='room_parent'
                        AND  {$wpdb->postmeta}.post_id NOT IN(
                            SELECT room_id FROM (
                                SELECT count(st_meta6.meta_value) as total,
                                    st_meta5.meta_value as total_room,st_meta6.meta_value as room_id ,st_meta2.meta_value as check_in,st_meta3.meta_value as check_out
                                     FROM {$wpdb->posts}
                                            JOIN {$wpdb->postmeta}  as st_meta2 on st_meta2.post_id={$wpdb->posts}.ID and st_meta2.meta_key='check_in'
                                            JOIN {$wpdb->postmeta}  as st_meta3 on st_meta3.post_id={$wpdb->posts}.ID and st_meta3.meta_key='check_out'
                                            JOIN {$wpdb->postmeta}  as st_meta6 on st_meta6.post_id={$wpdb->posts}.ID and st_meta6.meta_key='room_id'
                                            JOIN {$wpdb->postmeta}  as st_meta5 on st_meta5.post_id=st_meta6.meta_value and st_meta5.meta_key='number_room'
                                            WHERE {$wpdb->posts}.post_type='st_order'
                                    GROUP BY st_meta6.meta_value HAVING total>=total_room AND (

                                                ( CAST(st_meta2.meta_value AS DATE)<'{$check_in}' AND  CAST(st_meta3.meta_value AS DATE)>'{$check_in}' )
                                                OR ( CAST(st_meta2.meta_value AS DATE)>='{$check_in}' AND  CAST(st_meta2.meta_value AS DATE)<='{$check_out}' )

                                    )
                            ) as room_booked
                        )
                    ))";


                    }


                    if($price_range=STInput::request('price_range'))
                    {
                        $price_obj=explode(';',$price_range);
                        if(!isset($price_obj[1])){
                            $price_from=0;
                            $price_to=$price_obj[0];
                        }else
                        {
                            $price_from=$price_obj[0];
                            $price_to=$price_obj[1];
                        }

                        global $wpdb;

                        $query=" AND {$wpdb->posts}.ID IN (

                                SELECT ID FROM
                                (
                                    SELECT ID, MIN(min_price) as min_price_new FROM
                                    (
                                    select {$wpdb->posts}.ID,
                                    IF(
                                        st_meta3.meta_value is not NULL,
                                        IF((st_meta2.meta_value = 'on' and CAST(st_meta5.meta_value as DATE)<=NOW() and CAST(st_meta4.meta_value as DATE)>=NOW()) or
                                        st_meta2.meta_value='off'
                                        ,
                                        st_meta1.meta_value-(st_meta1.meta_value/100)*st_meta3.meta_value,
                                        CAST(st_meta1.meta_value as DECIMAL)
                                        ),
                                        CAST(st_meta1.meta_value as DECIMAL)
                                    ) as min_price

                                    from {$wpdb->posts}
                                    JOIN {$wpdb->postmeta} on {$wpdb->postmeta}.meta_value={$wpdb->posts}.ID and {$wpdb->postmeta}.meta_key='room_parent'
                                    JOIN {$wpdb->postmeta} as st_meta1 on st_meta1.post_id={$wpdb->postmeta}.post_id AND st_meta1.meta_key='price'
                                    LEFT JOIN {$wpdb->postmeta} as st_meta2 on st_meta2.post_id={$wpdb->postmeta}.post_id AND st_meta2.meta_key='is_sale_schedule'
                                    LEFT JOIN {$wpdb->postmeta} as st_meta3 on st_meta3.post_id={$wpdb->postmeta}.post_id AND st_meta3.meta_key='discount_rate'
                                    LEFT JOIN {$wpdb->postmeta} as st_meta4 on st_meta4.post_id={$wpdb->postmeta}.post_id AND st_meta4.meta_key='sale_price_to'
                                    LEFT JOIN {$wpdb->postmeta} as st_meta5 on st_meta5.post_id={$wpdb->postmeta}.post_id AND st_meta5.meta_key='sale_price_from'

                                     )as min_price_table
                                    group by ID Having  min_price_new>=%d and min_price_new<=%d ) as min_price_table_new
                                ) ";

                        $query=$wpdb->prepare($query,$price_from,$price_to);

                        $where.=$query;

                    }
                }
            }
            return $where;
        }
        function change_search_hotel_arg($query)
        {
            if(is_admin()) return false;


            $post_type = get_query_var('post_type');
            $posts_per_page=st()->get_option('hotel_posts_per_page',12);

            $meta_query=array();

            if($query->is_search && $post_type == 'st_hotel')
            {
                add_filter( 'posts_where' , array($this,'_alter_search_query') );

                $query->set('posts_per_page',$posts_per_page);

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


                    $query->set('s','');
                }

                $is_featured = st()->get_option('is_featured_search_hotel','off');
                if(!empty($is_featured) and $is_featured =='on'){
                    $query->set('meta_key','is_featured');
                    $query->set('orderby','meta_value');
                    $query->set('order','DESC');
                }

                if($orderby=STInput::get('orderby'))
                {
                    switch($orderby){
                        case "price_asc":
                            $query->set('meta_key','min_price');
                            $query->set('orderby','meta_value_num');
                            $query->set('order','asc');

                            break;
                        case "price_desc":
                            $query->set('meta_key','min_price');
                            $query->set('orderby','meta_value_num');
                            $query->set('order','desc');

                            break;
                        case "avg_rate":
                            $query->set('meta_key','rate_review');
                            $query->set('orderby','meta_value_num');
                            $query->set('order','desc');
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
                }else{
                    //Default Sorting
                    $query->set('meta_key','min_price');
                    $query->set('orderby','meta_value_num');
                    $query->set('order','asc');
                }

                if($star=STInput::get('star_rate')){

                    $stars=explode(',',$star);
                    $min_star=0;
                    if(!empty($stars))
                    {
                        foreach($stars as $key=>$val)
                        {
                            if($key==0) $min_star=$val;
                            else{
                                if($val<$min_star){
                                    $min_star=$val;
                                }
                            }
                        }
                    }
                    if($min_star)
                    {
                        $meta_query[]=array(
                            'key'=>'rate_review',
                            'value'=>$min_star,
                            'compare'=>">=",
                            'type'=>'DECIMAL'
                        );
                    }

                }
                if($hotel_rate=STInput::get('hotel_rate'))
                {
                    $meta_query[]=array(
                        'key'=>'hotel_star',
                        'value'=>explode(',',$hotel_rate),
                        'compare'=>"IN"
                    );
                }

//            if($price=STInput::get('price_range')){
//                $priceobj=explode(';',$price);
//                    $meta_query[]=array(
//                        'key'=>'min_price',
//                        'value'=>$priceobj[0],
//                        'compare'=>'>=',
//                        'type'=>"NUMERIC"
//                    );
//                if(isset($priceobj[1])){
//                    $meta_query[]=array(
//                        'key'=>'min_price',
//                        'value'=>$priceobj[1],
//                        'compare'=>'<=',
//                        'type'=>"NUMERIC"
//                    );
//                }
//
//                $meta_query['relation']='and';
//            }
                if(!empty($meta_query)){
                    $query->set('meta_query',$meta_query);
                }

            }
            else{
                remove_filter( 'posts_where' , array($this,'_alter_search_query') );
            }
        }


        function search_room($param=array())
        {
            $default=array(
                'room_parent'=>false,
                'adult_num'=>false,
                'child_num'=>false,
                'room_type'=>0,
                'room_num_search'=>1,
                'room_num_config'=>array()
            );

            $page=STInput::request('paged');
            if(!$page)
            {
                $page=get_query_var('paged');
            }

            extract(wp_parse_args($param,$default));

            $arg=array(
                'post_type'=>'hotel_room',
                'posts_per_page'=>'15',
                'paged'=>$page
            );


            $max_adult=1;
            $max_child=0;
            if($room_num_search==1){
                $max_adult=$adult_num;
                $max_child=$child_num;
            }

            if($room_num_search)
            {
                $arg['meta_query'][]=array(
                    'key'=>'number_room',
                    'compare'=>'>=',
                    'value'=>$room_num_search,
                );
            }

            if($room_num_search>1)
            {
                if(!empty($room_num_config) and is_array($room_num_config))
                {

                    foreach($room_num_config as $key=>$value){
                        if($value['adults']>$max_adult)
                        {
                            $max_adult=$value['adults'];
                        }
                        if($value['children']>$max_child)
                        {
                            $max_child=$value['children'];
                        }
                    }
                }
            }
            $arg['meta_query'][]=array(

                'key'=>'children_number',
                'compare'=>'>=',
                'value'=>$max_child,
            );
            $arg['meta_query'][]=array(

                'key'=>'adult_number',
                'compare'=>'>=',
                'value'=>$max_adult,
            );


            if($room_parent)
            {
                $arg['meta_key']='room_parent';
                $arg['meta_value']=$room_parent;
            }

            if($room_type)
            {
                $arg['tax_query'][]=array(
                    'taxonomy'=>'room_type',
                    'terms'=>$room_type
                );
            }



            return $arg;
        }

        function get_card_accepted_list()
        {
            $data=array();

            $options=st()->get_option('booking_card_accepted',array());

            if(!empty($options))
            {
                foreach($options as $key=>$value){
                    $data[]=array(
                        'label'=>$value['title'],
                        'src'=>$value['image'],
                        'value'=>sanitize_title_with_dashes($value['title'])
                    );
                }
            }

            return $data;
        }

        function init_metabox()
        {

            $this->metabox[] = array(
                'id'          => 'hotel_metabox',
                'title'       => __( 'Hotel Information', ST_TEXTDOMAIN),
                'desc'        => '',
                'pages'       => array( 'st_hotel' ),
                'context'     => 'normal',
                'priority'    => 'high',
                'fields'      => array(
                    array(
                        'label'       => __( 'Hotel Detail', ST_TEXTDOMAIN),
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
                        'label'       => __( 'Hotel Logo', ST_TEXTDOMAIN),
                        'id'          => 'logo',
                        'type'        => 'upload',
                        'class'       => 'ot-upload-attachment-id',
                        'desc'        => __( 'Upload your hotel\'s logo; Recommend: 260px x 195px', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Card Accepted', ST_TEXTDOMAIN),
                        'desc'       => __( 'Card Accepted', ST_TEXTDOMAIN),
                        'id'          => 'card_accepted',
                        'type'        => 'checkbox',
                        'choices'     =>$this->get_card_accepted_list()
                    ),
//
//                    array(
//                        'label'       => __( 'Min Price', ST_TEXTDOMAIN),
//                        'id'          => 'min_price',
//                        'type'        => 'text',
//                        'desc'        => __( 'Min price of this hotel', ST_TEXTDOMAIN),
//                        'std'         =>0
//                    ),

                    array(
                        'label'       => __( 'Custom Layout', ST_TEXTDOMAIN),
                        'id'          => 'st_custom_layout',
                        'post_type'   =>'st_layouts',
                        'desc'        => __( 'Detail Hotel Layout', ST_TEXTDOMAIN),
                        'type'        => 'select',
                        'choices'     => st_get_layout('st_hotel')
                    ),

                    array(
                        'label'       => __( 'Hotel Email', ST_TEXTDOMAIN),
                        'id'          => 'email',
                        'type'        => 'text',
                        'desc'        => __( 'Hotel Email Address, this address will received email when have new booking', ST_TEXTDOMAIN),
                    ),

                    array(
                        'label'       => __( 'Hotel Website', ST_TEXTDOMAIN),
                        'id'          => 'website',
                        'type'        => 'text',
                        'desc'        => __( 'Hotel Website. Ex: <em>http://domain.com</em>', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Hotel Phone', ST_TEXTDOMAIN),
                        'id'          => 'phone',
                        'type'        => 'text',
                        'desc'        => __( 'Hotel Phone Number', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Fax Number', ST_TEXTDOMAIN),
                        'id'          => 'fax',
                        'type'        => 'text',
                        'desc'        => __( 'Hotel Fax Number', ST_TEXTDOMAIN),
                    ),

                    array(
                        'label'       => __( 'Gallery', ST_TEXTDOMAIN),
                        'id'          => 'gallery',
                        'type'        => 'gallery',
                        'desc'        => __( 'Pick your own image for this hotel', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Hotel Video', ST_TEXTDOMAIN),
                        'id'          => 'video',
                        'type'        => 'text',
                        'desc'        => __( 'Please use youtube or vimeo video', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Star Rating', ST_TEXTDOMAIN),
                        'id'          => 'hotel_star',
                        'type'        => 'numeric-slider',
                        'min_max_step'=> '0,5,1',
                        'desc'        => __( '', ST_TEXTDOMAIN),
                        'std'         =>0
                    ),
                    array(
                        'label'       => __( 'Hotel Location', ST_TEXTDOMAIN),
                        'id'          => 'location_tab',
                        'type'        => 'tab'
                    ),
                    array(
                        'label'       => __( 'Location', ST_TEXTDOMAIN),
                        'id'          => 'id_location',
                        'type'        => 'post_select_ajax',
                        'desc'        => __( 'Search for location', ST_TEXTDOMAIN),
                        'post_type'   =>'location',
                    ),

                    array(
                        'label'       => __( 'Address', ST_TEXTDOMAIN),
                        'id'          => 'address',
                        'type'        => 'text',
                        'desc'        => __( 'Hotel Address', ST_TEXTDOMAIN),
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
                    ),

//            array(
//                'label'       => __( 'Avg Rate Review', ST_TEXTDOMAIN),
//                'id'          => 'rate_review',
//                'type'        => 'numeric-slider',
//                'min_max_step'=> '1,5,1',
//                'desc'        => __( '', ST_TEXTDOMAIN),
//            ),



                )
            );

            $custom_field = st()->get_option('hotel_unlimited_custom_field');
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


        //Helper class
        function get_last_booking()
        {
            if($this->hotel_id==false)
            {
                $this->hotel_id=get_the_ID();
            }
            global $wpdb;


            $query="SELECT * from ".$wpdb->postmeta."
                where meta_key='item_id'
                and meta_value in (
                    SELECT ID from {$wpdb->posts}
                    join ".$wpdb->postmeta." on ".$wpdb->posts.".ID=".$wpdb->postmeta.".post_id and ".$wpdb->postmeta.".meta_key='room_parent'
                    where post_type='hotel_room'
                    and ".$wpdb->postmeta.".meta_value='".$this->hotel_id."'

                )

                order by meta_id
                limit 0,1";

            $data= $wpdb->get_results($query,OBJECT);

            if(!empty($data)){
                foreach($data as $key=>$value)
                {
                    return human_time_diff(get_the_time('U',$value->post_id), current_time('timestamp')).__(' ago',ST_TEXTDOMAIN);
                }
            }




        }

        static function count_meta_key($key,$value,$post_type='st_hotel',$location_key='id_location'){

            $arg=array(
                'post_type'=>$post_type,
                'posts_per_page'=>1,


            );

            if(STInput::get('location_id'))
            {
                $arg['meta_query'][]=array(
                    'key'=>$location_key,
                    'value'=>STInput::get('location_id')
                );
            }

            if($key=='rate_review')
            {

                $arg['meta_query'][]=array(
                    'key'=>$key,
                    'value'=>$value,
                    'type'=>'DECIMAL',
                    'compare'=>'>='
                );
            }else{
                $arg['meta_key']=$key;
                $arg['meta_value']=$value;
            }

            $query=new WP_Query(
                $arg
            );
            $count=$query->found_posts;
            wp_reset_query();
            return $count;
        }


        static function get_min_price($post_id=false)
        {
            if(!$post_id)
            {
                $post_id=get_the_ID();
            }
            $query=array(
                'post_type' =>'hotel_room',
                'posts_per_page'=>100,
                'meta_key'=>'room_parent',
                'meta_value'=>$post_id
            );

            $q=new WP_Query($query);


            $min_price=0;
            $i=1;
            while($q->have_posts()){
                $q->the_post();
                $price=get_post_meta(get_the_ID(),'price',true);
                if($i==1){
                    $min_price=$price;
                }else{
                    if($price<$min_price){
                        $min_price=$price;
                    }
                }


                $i++;
            }

            wp_reset_query();

            return $min_price;
        }


        static function get_price_slider()
        {
            global $wpdb;
            $query="SELECT min(orgin_price) as min_price,MAX(orgin_price) as max_price from
                (SELECT
                 IF( st_meta3.meta_value is not NULL,
                    IF((st_meta2.meta_value = 'on' and CAST(st_meta5.meta_value as DATE)<=NOW() and CAST(st_meta4.meta_value as DATE)>=NOW())
                      or st_meta2.meta_value='off' ,
                      {$wpdb->postmeta}.meta_value-({$wpdb->postmeta}.meta_value/100)*st_meta3.meta_value,
                      CAST({$wpdb->postmeta}.meta_value as DECIMAL) ),
                  CAST({$wpdb->postmeta}.meta_value as DECIMAL) ) as orgin_price
                  FROM {$wpdb->postmeta}
                  JOIN {$wpdb->postmeta} as st_meta1 on st_meta1.post_id={$wpdb->postmeta}.post_id
                  LEFT JOIN {$wpdb->postmeta} as st_meta2 on st_meta2.post_id={$wpdb->postmeta}.post_id AND st_meta2.meta_key='is_sale_schedule'
                  LEFT JOIN {$wpdb->postmeta} as st_meta3 on st_meta3.post_id={$wpdb->postmeta}.post_id AND st_meta3.meta_key='discount_rate'
                  LEFT JOIN {$wpdb->postmeta} as st_meta4 on st_meta4.post_id={$wpdb->postmeta}.post_id AND st_meta4.meta_key='sale_price_to'
                  LEFT JOIN {$wpdb->postmeta} as st_meta5 on st_meta5.post_id={$wpdb->postmeta}.post_id AND st_meta5.meta_key='sale_price_from'
                  WHERE st_meta1.meta_key='room_parent' AND {$wpdb->postmeta}.meta_key='price')
        as orgin_price_table";

            $data=$wpdb->get_row($query);

            return array('min'=>floor($data->min_price),'max'=>ceil($data->max_price));
        }

        static function get_owner_email($hotel_id=false)
        {
            return get_post_meta($hotel_id,'email',true);
        }


    }
    $a=new STHotel();

    $a->init();
}
