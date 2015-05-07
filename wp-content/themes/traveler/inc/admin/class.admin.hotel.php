<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STAdminHotel
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STAdminHotel'))
{

    class STAdminHotel extends STAdmin
    {

        static  $parent_key='room_parent';
        static $booking_page;


        function __construct()
        {
            self::$booking_page=admin_url('edit.php?post_type=st_hotel&page=st_hotel_booking');


            //add colum for rooms
            add_filter('manage_hotel_room_posts_columns', array($this,'add_col_header'), 10);
            add_action('manage_hotel_room_posts_custom_column', array($this,'add_col_content'), 10, 2);

            //add colum for rooms
            add_filter('manage_st_hotel_posts_columns', array($this,'add_hotel_col_header'), 10);
            add_action('manage_st_hotel_posts_custom_column', array($this,'add_hotel_col_content'), 10, 2);

            add_action('admin_menu',array($this,'add_menu_page'));

            //Check booking edit and redirect
            if(self::is_booking_page())
            {

                add_action('admin_enqueue_scripts',array(__CLASS__,'add_edit_scripts'));
                $section=isset($_GET['section'])?$_GET['section']:false;
                switch($section){
                    case "edit_order_item":
                        $this->is_able_edit();
                        break;
                    case "add_booking":
                        if(isset($_POST['submit']) and $_POST['submit']) $this->_add_booking();
                        break;

                    case 'resend_email':
                        add_action('init',array($this,'_resend_mail'));
                        //$this->_resend_mail();
                        break;
                }
            }

            if(isset($_GET['send_mail']) and $_GET['send_mail']=='success')
            {
                self::set_message(__('Email sent',ST_TEXTDOMAIN),'updated');
            }

            add_action('wp_ajax_st_room_select_ajax',array(__CLASS__,'st_room_select_ajax'));

            parent::__construct();
        }


        function _resend_mail()
        {
            $order_item=isset($_GET['order_item_id'])?$_GET['order_item_id']:false;

            $test=isset($_GET['test'])?$_GET['test']:false;


            if($order_item){

                $order=$order_item;

                if($test){
                    $message=st()->load_template('email/booking_infomation',null,array('order_id'=>$order,'confirm_link'=>'xxx'));

                    echo ($message);

                    die;

                }


                if($order){
                    STCart::send_mail_after_booking($order);
                }
            }

            wp_safe_redirect(self::$booking_page.'&send_mail=success');
        }
        static  function  st_room_select_ajax()
        {
            extract( wp_parse_args($_GET,array(
                'room_parent'=>'',
                'post_type'=>'',
                'q'=>''
            )));


            query_posts(array('post_type'=>$post_type,'posts_per_page'=>10,'s'=>$q,'meta_key'=>'room_parent','meta_value'=>$room_parent));

            $r=array(
                'items'=>array(),
            );
            while(have_posts())
            {
                the_post();
                $r['items'][]=array(
                    'id'=>get_the_ID(),
                    'name'=>get_the_title(),
                    'description'=>''
                );
            }

            wp_reset_query();

            echo json_encode($r);
            die;

        }
        static function  add_edit_scripts()
        {
            wp_enqueue_script('select2');
            wp_enqueue_script('st-edit-booking',get_template_directory_uri().'/js/admin/edit-booking.js',array('jquery'),null,true);
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_style('jjquery-ui.theme.min.css',get_template_directory_uri().'/css/admin/jquery-ui.min.css');
        }
        static function is_booking_page()
        {
            if(is_admin()
                and isset($_GET['post_type'])
                and $_GET['post_type']=='st_hotel'
                and isset($_GET['page'])
                and $_GET['page']='st_hotel_booking'
            ) return true;
            return false;
        }

        function add_menu_page()
        {
            //Add booking page
            add_submenu_page('edit.php?post_type=st_hotel',__('Hotel Booking',ST_TEXTDOMAIN), __('Hotel Booking',ST_TEXTDOMAIN), 'manage_options', 'st_hotel_booking', array($this,'__hotel_booking_page'));
        }

        function  __hotel_booking_page(){

            $section=isset($_GET['section'])?$_GET['section']:false;

            if($section){
                switch($section)
                {
                    case "edit_order_item":
                        $this->edit_order_item();
                        break;
                    case 'add_booking':
                        $this->add_booking();
                        break;
                }
            }else{

                $action=isset($_POST['st_action'])?$_POST['st_action']:false;
                switch($action){
                    case "delete":
                        $this->_delete_items();
                        break;
                }
                echo balanceTags($this->load_view('hotel/booking_index',false));
            }

        }
        function add_booking()
        {

            echo  balanceTags($this->load_view('hotel/booking_edit',false,array('page_title'=>__('Add new Hotel Booking',ST_TEXTDOMAIN))));
        }
        function _delete_items(){

            if ( empty( $_POST ) or  !check_admin_referer( 'shb_action', 'shb_field' ) ) {
                //// process form data, e.g. update fields
                return;
            }
            $ids=isset($_POST['post'])?$_POST['post']:array();
            if(!empty($ids))
            {
                foreach($ids as $id)
                    wp_delete_post($id,true);

            }

            STAdmin::set_message(__("Delete item(s) success",ST_TEXTDOMAIN),'updated');

        }

        function edit_order_item()
        {
            $item_id=isset($_GET['order_item_id'])?$_GET['order_item_id']:false;
            if(!$item_id or get_post_type($item_id)!='st_order')
            {
                //wp_safe_redirect(self::$booking_page); die;
                return false;
            }


            if(isset($_POST['submit']) and $_POST['submit']) $this->_save_booking($item_id);

            echo  balanceTags($this->load_view('hotel/booking_edit'));
        }
        function _add_booking()
        {
            if(!check_admin_referer( 'shb_action', 'shb_field' )) die;

            //Create Order
            $order=array(
                'post_title'=>__('Order',ST_TEXTDOMAIN).' - '.date(get_option( 'date_format' )).' @ '.date(get_option('time_format')),
                'post_type'=>'st_order',
                'post_status'=>'publish'
            );

            $order_id=wp_insert_post($order);

            if($order_id){

                $check_out_field=STCart::get_checkout_fields();

                if(!empty($check_out_field))
                {
                    foreach($check_out_field as $field_name=>$field_desc)
                    {
                        update_post_meta($order_id,$field_name,STInput::post($field_name));
                    }
                }


                $user_fields=array(
                    'id_user'=>'',
                    'status'=>'',
                    'st_tax'=>'',
                    'room_id'=>''

                );
                $data=wp_parse_args($_POST,$user_fields);
                if($order_id){
                    foreach($user_fields as $val=>$value){
                        update_post_meta($order_id,$val,$data[$val]);
                    }
                }
                update_post_meta($order_id,'payment_method','submit_form');

                //Save Items

                $item_data=array(
                    'item_number'=>'',
                    'item_id'=>'',
                    'item_price'=>'',
                    'check_in'=>'',
                    'check_out'=>''
                );
                $data=wp_parse_args($_POST,$item_data);

                $item_id=$order_id;
                if($item_id){
                    foreach($item_data as $val=>$value){

                        if($val=='check_in' or $val=='check_out'){
                            update_post_meta($item_id,$val,date('Y-m-d',strtotime($data[$val])));
                        }else
                            update_post_meta($item_id,$val,$data[$val]);
                    }


                    do_action('st_booking_success',$order_id);

                    //Success
                    wp_safe_redirect(self::$booking_page);
                }


            }
            //STAdmin::set_message('Update Success','updated');

        }
        function _save_booking($order_id)
        {
            if(!check_admin_referer( 'shb_action', 'shb_field' )) die;
            //Update Order
            $orderitem=array(
                'item_number'=>'',
                'item_id'=>'',
                'item_price'=>'',
                'check_in'=>'',
                'check_out'=>'',
                'room_id'=>''
            );

            $data=wp_parse_args($_POST,$orderitem);

            foreach($orderitem as $val=>$value){

                if($val=='check_in' or $val=='check_out'){
                    update_post_meta($order_id,$val,date('Y-m-d',strtotime($data[$val])));
                }else
                    update_post_meta($order_id,$val,$data[$val]);
            }

            //Update User
            $order_parent=$order_id;
            $id_user=isset($_POST['id_user'])?$_POST['id_user']:false;
            if($order_parent and $id_user){

                update_post_meta($order_parent,'id_user',$id_user);
            }

            $check_out_field=STCart::get_checkout_fields();

            if(!empty($check_out_field))
            {
                foreach($check_out_field as $field_name=>$field_desc)
                {
                    update_post_meta($order_parent,$field_name,STInput::post($field_name));
                }
            }

            $user_fields=array(

                'status'=>'',
                'st_tax'=>''
            );
            $data=wp_parse_args($_POST,$user_fields);
            if($order_parent){
                foreach($user_fields as $val=>$value){
                    update_post_meta($order_parent,$val,$data[$val]);
                }
            }


            STAdmin::set_message('Update Success','updated');
        }
        function is_able_edit()
        {
            $item_id=isset($_GET['order_item_id'])?$_GET['order_item_id']:false;
            if(!$item_id or get_post_type($item_id)!='st_order')
            {
                wp_safe_redirect(self::$booking_page); die;
            }
            return true;
        }


        function add_col_header($defaults)
        {
            $this->array_splice_assoc($defaults,2,0,array('room_number'=>__('Rooms',ST_TEXTDOMAIN)));
            $this->array_splice_assoc($defaults,2,0,array('hotel_parent'=>__('Hotel',ST_TEXTDOMAIN)));

            return $defaults;
        }
        function add_hotel_col_header($defaults)
        {
            $this->array_splice_assoc($defaults,2,0,array('hotel_layout'=>__('Layout',ST_TEXTDOMAIN)));

            return $defaults;
        }
        function array_splice_assoc(&$input, $offset, $length = 0, $replacement = array()) {
            $tail = array_splice($input, $offset);
            $extracted = array_splice($tail, 0, $length);
            $input += $replacement + $tail;
            return $extracted;
        }
        function add_col_content($column_name, $post_ID)
        {

            if ($column_name == 'hotel_parent') {
                // show content of 'directors_name' column
                $parent=get_post_meta($post_ID,'room_parent',true);

                if($parent)
                {
                    echo "<a href='".get_edit_post_link($parent)."'>".get_the_title($parent)."</a>";
                }

            }
            if($column_name=='room_number')
            {
                echo get_post_meta($post_ID,'number_room',true);
            }
        }
        function add_hotel_col_content($column_name, $post_ID)
        {

            if ($column_name == 'hotel_layout') {
                // show content of 'directors_name' column
                $parent=get_post_meta($post_ID,'st_custom_layout',true);

                if($parent)
                {
                    echo "<a href='".get_edit_post_link($parent)."'>".get_the_title($parent)."</a>";
                }else
                {
                    echo __('Default',ST_TEXTDOMAIN);
                }


            }
        }

    }
    new STAdminHotel();
}