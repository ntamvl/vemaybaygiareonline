<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STRoom
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STRoom'))
{
    class STRoom extends TravelerObject
    {

        function init()
        {
            parent::init();
//        $this->init_metabox();

            add_action('init',array($this,'init_metabox'));
            add_action('posts_where',array($this,'_alter_search_query'));
        }

        function _alter_search_query($where)
        {
            if(is_admin()) return $where;
            global $wp_query,$wpdb;
            $post_type='';
            if(isset($wp_query->query_vars['post_type']) and is_string($wp_query->query_vars['post_type']))
            {
                $post_type= $wp_query->query_vars['post_type'];

            }

            if($post_type=='hotel_room')
            {
                if(STInput::request('start') and STInput::request('end'))
                {
                    $check_in=date('Y-m-d H:i:s',strtotime(STInput::request('start')));
                    $check_out=date('Y-m-d H:i:s',strtotime(STInput::request('end')));

                    $where_add=" AND {$wpdb->posts}.ID NOT IN (SELECT room_id FROM (
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
                            ) as room_booked)";

                    $where.=$where_add;
                }
            }

            return $where;
        }

        static function get_room_price($room_id=false)
        {

            if(!$room_id) $room_id=get_the_ID();
            $price=get_post_meta($room_id,'price',true);

            if($price>0){
                $discount_rate=get_post_meta($room_id,'discount_rate',true);
                $is_sale_schedule=get_post_meta($room_id,'is_sale_schedule',true);

                if($is_sale_schedule=='on')
                {
                    $sale_from=get_post_meta($room_id,'sale_price_from',true);
                    $sale_to=get_post_meta($room_id,'sale_price_to',true);
                    if($sale_from and $sale_from){

                        $today=date('Y-m-d');
                        $sale_from = date('Y-m-d', strtotime($sale_from));
                        $sale_to = date('Y-m-d', strtotime($sale_to));
                        if (($today >= $sale_from) && ($today <= $sale_to))
                        {

                        }else{

                            $discount_rate=0;
                        }

                    }else{
                        $discount_rate=0;
                    }
                }

                if($discount_rate>100){
                    $discount_rate=100;
                }

                if($discount_rate)
                    $price=$price - ($price/100)*$discount_rate;
            }

            return $price;
        }

        function init_metabox()
        {

            //Room
            $this->metabox[] = array(
                'id'          => 'room_metabox',
                'title'       => __( 'Room Setting', ST_TEXTDOMAIN),
                'desc'        => '',
                'pages'       => array( 'hotel_room' ),
                'context'     => 'normal',
                'priority'    => 'high',
                'fields'      => array(


                    array(
                        'label'       => __( 'General', ST_TEXTDOMAIN),
                        'id'          => 'room_reneral_tab',
                        'type'        => 'tab'
                    ),

                    array(
                        'label'       => __( 'Hotel', ST_TEXTDOMAIN),
                        'id'          => 'room_parent',
                        'type'        => 'post_select_ajax',
                        'desc'        => __( 'Choose the hotel that the room belong', ST_TEXTDOMAIN),
                        'post_type'   =>'st_hotel',
                        'placeholder' =>__('Search for a Hotel',ST_TEXTDOMAIN)
                    ),

                    array(
                        'label'       => __( 'Number of Room', ST_TEXTDOMAIN),
                        'id'          => 'number_room',
                        'type'        => 'text',
                        'desc'        => __( 'Number of rooms available for book', ST_TEXTDOMAIN),
                    ),


                    array(
                        'label'       => __( 'Room Price', ST_TEXTDOMAIN),
                        'id'          => 'room_price_tab',
                        'type'        => 'tab'
                    ),

                    array(
                        'label'       => sprintf( __( 'Price (%s)', ST_TEXTDOMAIN),TravelHelper::get_default_currency('symbol')),
                        'id'          => 'price',
                        'type'        => 'text',
                        'desc'        => __( 'Per night', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       =>  __( 'Discount Rate', ST_TEXTDOMAIN),
                        'id'          => 'discount_rate',
                        'type'        => 'text',
                        'desc'        => __( 'Discount by %', ST_TEXTDOMAIN),
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
                        'label'       => __( 'Room Facility', ST_TEXTDOMAIN),
                        'id'          => 'room_detail_tab',
                        'type'        => 'tab'
                    ),

                    array(
                        'label'       => __( 'Adults Number', ST_TEXTDOMAIN),
                        'id'          => 'adult_number',
                        'type'        => 'text',
                        'desc'        => __( 'Number of Adults in room', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Children Number', ST_TEXTDOMAIN),
                        'id'          => 'children_number',
                        'type'        => 'text',
                        'desc'        => __( 'Number of Children in room', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Beds Number', ST_TEXTDOMAIN),
                        'id'          => 'bed_number',
                        'type'        => 'text',
                        'desc'        => __( 'Number of Beds in room', ST_TEXTDOMAIN),
                    ),
                    array(
                        'label'       => __( 'Room footage (square feet)', ST_TEXTDOMAIN),
                        'id'          => 'room_footage',
                        'type'        => 'text',
                    ),
                )
            );
        }


    }

    $a=new STRoom();
    $a->init();
}
