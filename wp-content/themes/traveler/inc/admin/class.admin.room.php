<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STAdminRoom
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STAdminRoom'))
{

    class STAdminRoom extends STAdmin
    {
        function __construct()
        {
            //alter where for search room
            add_filter( 'posts_where' , array(__CLASS__,'_alter_search_query') );

            //Hotel Hook
            /*
             * todo Re-cal hotel min price
             * */
            add_action( 'update_post_meta', array($this,'hotel_update_min_price') ,10,4);
            add_action( 'updated_post_meta', array($this,'meta_updated_update_min_price') ,10,4);
            add_action('added_post_meta',array($this,'hotel_update_min_price') ,10,4);

            parent::__construct();
        }

        static function _alter_search_query($where)
        {
            global $wp_query;

            if(!is_admin()) return $where;

            if($wp_query->get('post_type') !='hotel_room' ) return $where;

            global $wpdb;

            if($wp_query->get('s')){

                $_GET['s']=sanitize_title_for_query($_GET['s']);
                $add_where=" OR $wpdb->posts.ID IN (SELECT post_id FROM
                     $wpdb->postmeta
                    WHERE $wpdb->postmeta.meta_key ='room_parent'
                    AND $wpdb->postmeta.meta_value IN (SELECT $wpdb->posts.ID
                        FROM $wpdb->posts WHERE  $wpdb->posts.post_title LIKE '%{$_GET['s']}%'
                    )

             )  ";

                $where.=$add_where;


            }

            return $where;
        }

        function hotel_update_min_price($meta_id, $object_id, $meta_key, $meta_value)
        {

            $post_type=get_post_type($object_id);
            if ( wp_is_post_revision( $object_id ) )
                return;
            if($post_type=='hotel_room')
            {
                //Update old room and new room
                if( $meta_key=='room_parent')
                {

                    $old=get_post_meta($object_id,$meta_key,true);


                    if($old!=$meta_value)
                    {
                        $this->_do_update_hotel_min_price($old,false,$object_id);
                        $this->_do_update_hotel_min_price($meta_value);
                    }else{

                        $this->_do_update_hotel_min_price($meta_value);
                    }
                }


            }

        }
        function meta_updated_update_min_price($meta_id, $object_id, $meta_key, $meta_value)
        {
            if($meta_key=='price')
            {
                $hotel_id=get_post_meta($object_id,'room_parent',true);
                $this->_do_update_hotel_min_price($hotel_id);

            }
        }

        function _do_update_hotel_min_price($hotel_id,$current_meta_price=false,$room_id=false){
            if(!$hotel_id) return;
            $query=array(
                'post_type' =>'hotel_room',
                'posts_per_page'=>100,
                'meta_key'=>'room_parent',
                'meta_value'=>$hotel_id
            );

            if($room_id){
                $query['posts_not_in']=array($room_id);
            }


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

            if($current_meta_price!==FALSE){
                if($current_meta_price<$min_price){
                    $min_price=$current_meta_price;
                }
            }

            update_post_meta($hotel_id,'min_price',$min_price);

        }
    }

    new STAdminRoom();
}

