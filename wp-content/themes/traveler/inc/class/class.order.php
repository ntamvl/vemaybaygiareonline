<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STOrder
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STOrder'))
{
    class STOrder extends TravelerObject
    {

        function init()
        {
            parent::init();
            $this->init_metabox();

        }


        function count_order($where=false)
        {
            global $wpdb;

            $query="SELECT count({$wpdb->posts}.ID) as total from {$wpdb->posts} join {$wpdb->postmeta} on {$wpdb->posts}.ID={$wpdb->postmeta}.post_id where 1=1";

            $query.=" and `post_type`='st_order' ";

            $query.=$where;

            $count= $wpdb->get_var($query);
            return $count;
        }

        function check_user_booked($user_id,$item_id,$post_type){
            global $wpdb;

            $where='';
            $join='';

            switch($post_type){
                default:
                    $where.=" and {$wpdb->postmeta}.meta_key='item_id' and  {$wpdb->postmeta}.meta_value={$item_id}";
                    break;
            }

            $query="SELECT count({$wpdb->posts}.ID) as total from {$wpdb->posts}
                join {$wpdb->postmeta} on {$wpdb->posts}.ID={$wpdb->postmeta}.post_id
                join {$wpdb->postmeta} as tbl2 on tbl2.post_id={$wpdb->posts}.ID
                {$join}
                where 1=1";

            $query.=" and `post_type`='st_order' ";
            $query.=" and {$wpdb->posts}.post_status='publish'
                  and {$wpdb->postmeta}.meta_key='item_id'

                    ";
            $query.=$where;

            $query.=" and tbl2.meta_key='id_user'
                  AND tbl2.meta_value='{$user_id}'";


            $count= $wpdb->get_var($query);

            return $count;
        }

        function init_metabox()
        {

            //Room
            $this->metabox[] = array(
                'id'          => 'order_metabox',
                'title'       => __( 'Order Setting', ST_TEXTDOMAIN),
                'desc'        => '',
                'pages'       => array( 'st_order' ),
                'context'     => 'normal',
                'priority'    => 'high',
                'fields'      => array(

                    array(
                        'label'       => __( 'General', ST_TEXTDOMAIN),
                        'id'          => 'order_reneral_tab',
                        'type'        => 'tab'
                    ),
                    array(
                        'label'       => __( 'Total Price', ST_TEXTDOMAIN),
                        'id'          => 'total_price',
                        'type'        => 'text',
                        'desc'        => __( '', ST_TEXTDOMAIN),
                    ),


                    array(
                        'label'       => __( 'Customer', ST_TEXTDOMAIN),
                        'id'          => 'id_user',
                        'type'        => 'user_select_ajax',
                        'desc'        => __( '', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       =>__('Request Booking',ST_TEXTDOMAIN),
                        'id'          =>'st_o_note',
                        'type'        =>'textarea_simple'
                    ),
                    array(
                        'label'       => __( 'Payment Method', ST_TEXTDOMAIN),
                        'id'          => 'payment_method',
                        'type'        => 'select',
                        'desc'        => __( '', ST_TEXTDOMAIN),
                        'choices'     =>array(
                            array(
                                'label'             =>__('Paypal',ST_TEXTDOMAIN),
                                'value'             =>'paypal',

                            ),
                            array(
                                'label'             =>__('Submit Form',ST_TEXTDOMAIN),
                                'value'             =>'submit_form',

                            )
                        ),
                        'std'                       =>'submit_form'
                    ),

                )
            );
        }


    }

    $a=new STOrder();
    $a->init();

}

