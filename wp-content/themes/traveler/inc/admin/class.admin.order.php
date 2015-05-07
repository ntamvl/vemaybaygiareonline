<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STAdminOrder
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STAdminOrder'))
{

    class STAdminOrder extends STAdmin
    {
        function __construct()
        {
            parent::__construct();
            add_action( 'add_meta_boxes', array($this,'add_item_metabox') );


            add_action('admin_enqueue_scripts',array($this,'admin_queue_scripts'));

            add_action('wp_ajax_st_order_select',array($this,'st_order_select'));
            add_action('wp_ajax_save_order_item',array($this,'save_order_item'));

            add_action('wp_ajax_st_delete_order_item',array($this,'st_delete_order_item'));
        }

        function st_delete_order_item()
        {
            $id=isset($_REQUEST['id'])?$_REQUEST['id']:false;

            if($id)
            {
                wp_delete_post($id);
            }
            echo json_encode(array('status'=>1));
            die;
        }

        function save_order_item()
        {
            $arg=$_REQUEST;

            $default=array(
                'item_id'=>'',
                'item_type'=>'',
                'item_id2'=>'',
                'check_in'=>'',
                'check_out'=>'',
                'item_number'=>'',
                'item_price'=>'',
                'order_id'=>'',
            );

            $data=wp_parse_args($arg,$default);
            extract($data);

            if(!$order_id){
                echo json_encode(array(
                    'status'=>0,
                    'message'=>__('Order ID must be specify',ST_TEXTDOMAIN)
                ));
                die;
            }

            $item_main_id=$item_id;
            switch($item_type){
                case "st_hotel":
                    $item_main_id=$item_id2;
                    break;

            }


            $post=array(
                'post_title'=>sprintf(__('Order #%s',ST_TEXTDOMAIN),$order_id).' - '.get_the_title($item_main_id),
                'post_type'=>'st_order_item',
                'post_status'=>'publish',
            );

            $new_post=wp_insert_post($post);

            if($new_post){
                update_post_meta($new_post,'item_id',$item_main_id);
                update_post_meta($new_post,'item_number',$item_number);
                update_post_meta($new_post,'item_price',$item_price);
                update_post_meta($new_post,'check_out',$check_out);
                update_post_meta($new_post,'check_in',$check_in);
                update_post_meta($new_post,'order_parent',$order_id);
            }

            echo json_encode(array('status'=>1,'reload'=>1));
            die;

        }

        function st_order_select()
        {
            $arg=$_REQUEST;

            $default=array(
                'posts_per_page'=>10,
                'post_type'=>'st_hotel',
                'item_id'=>'',
                'q'             =>''
            );

            $data=wp_parse_args($arg,$default);

            $query=array(
                'post_per_page'=>$data['posts_per_page'],
                'post_type'=>$data['post_type'],
                's'         =>$data['q']
            );
            $r=array(
                'items'=>array(),
                'total_count'=>0
            );

            if($data['post_type']=='hotel_room' and $data['item_id']){
                $query['meta_key']='room_parent';
                $query['meta_value']=$data['item_id'];
            }


            query_posts($query);

            while(have_posts()){
                the_post();
                $r['items'][]=array(
                    'id'=>get_the_ID(),
                    'name'=>get_the_title(),
                    'description'=>get_the_ID(),
                    'price'=>get_post_meta(get_the_ID(),'price',true)
                );
            }
            wp_reset_query();

            echo json_encode($r);
            die;
        }

        function admin_queue_scripts()
        {
            $screen=get_current_screen();

            if($screen->base=='post' and $screen->post_type=='st_order'){

                wp_enqueue_script('select2');

                wp_enqueue_script('edit-orders',get_template_directory_uri().'/js/admin/edit-order.js',array('jquery','jquery-ui-datepicker'),null,true);


            }
        }

        function add_item_metabox()
        {
            $screens = array( 'st_order' );

            foreach ( $screens as $screen ) {

                add_meta_box(
                    'st_order_item_section',
                    __( 'Order Items', ST_TEXTDOMAIN ),
                    array($this,'metabox_call_back'),
                    $screen
                );
            }
        }

        function metabox_call_back($post)
        {
            echo  balanceTags($this->load_view('orders/index',null,array('post'=>$post)));
        }
    }

    new STAdminOrder();
}