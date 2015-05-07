<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class TravelerObject
 *
 * Created by ShineTheme
 *
 */
class TravelerObject
{
    public $min_price;

    protected $post_type='st_hotel';

    protected $metabox=array();

    protected $orderby=array();

    function init()
    {
        add_action( 'admin_init', array($this,'do_init_metabox') );
        //Add Stats display for posted review
        add_action('st_review_more_content',array($this,'display_posted_review_stats'));

        add_action('save_post', array($this,'update_avg_rate'));

        add_filter('post_class',array($this,'change_post_class'));

        add_filter('pre_get_posts', array($this,'_admin_posts_for_current_author'));

        add_action('init',array($this,'_top_ajax_search'));
    }
    function _admin_posts_for_current_author($query)
    {
        if($query->is_admin) {

            if(!current_user_can('manage_options'))
            {
                global $user_ID;
                $query->set('author',  $user_ID);
            }
        }
        return $query;
    }

    function _top_ajax_search(){

        if(STInput::request('action')!='st_top_ajax_search')  return;

        //Small security
        check_ajax_referer( 'st_search_security', 'security' );

        $s=STInput::get('s');
        $arg=array(
            'post_type'=>array('post','st_hotel','st_rental','location','st_tours','st_cars','st_activity'),
            'posts_per_page'=>10,
            's'=>$s,
            'suppress_filters'=>false
        );

        $query=new WP_Query();
        $query->is_admin=false;
        $query->query($arg);
        $r=array();

        while($query->have_posts()){
            $query->the_post();
            $post_type=get_post_type(get_the_ID());
            $obj=get_post_type_object($post_type);

            $item=array(
                'title'=> get_the_title(),
                'id'=>get_the_ID(),
                'type'=>$obj->labels->singular_name,
                'url'=>get_permalink(),
                'obj'=>$obj
            );

            if($post_type=='location'){
                $item['url']=home_url(esc_url_raw('?s=&post_type=st_hotel&location_id='.get_the_ID()));
            }


            $r['data'][]=$item;
        }

        wp_reset_query();
        echo json_encode($r);

        die();
    }

    function change_post_class($class)
    {
        return $class;
    }

    function update_avg_rate($post_id){
        $avg=STReview::get_avg_rate($post_id);
        update_post_meta($post_id,'rate_review',$avg);
    }





    /**
     *
     * $range in kilometer
     *
     *
     * */
    function get_near_by($post_id=false,$range=20,$limit=5)
    {
        if(!$post_id) $post_id=get_the_ID();


        if ( false !== ( $value = get_transient( 'st_items_nearby_'.$post_id ) ) )
            return $value;

        $map_lat=(float)get_post_meta($post_id,'map_lat',true);
        $map_lng=(float)get_post_meta($post_id,'map_lng',true);



        //Search by Kilometer :6371
        //Miles: 3959
        global $wpdb;
            $querystr = "
            SELECT $wpdb->posts.*,( 6371 * acos( cos( radians({$map_lat}) ) * cos( radians( mt1.meta_value ) ) *
cos( radians( mt2.meta_value ) - radians({$map_lng}) ) + sin( radians({$map_lat}) ) *
sin( radians( mt1.meta_value ) ) ) ) AS distance
            FROM $wpdb->posts, $wpdb->postmeta as mt1,$wpdb->postmeta as mt2
            WHERE $wpdb->posts.ID = mt1.post_id
            and $wpdb->posts.ID=mt2.post_id
            AND mt1.meta_key = 'map_lat'
            and mt2.meta_key = 'map_lng'
            and $wpdb->posts.ID !=$post_id
            AND $wpdb->posts.post_status = 'publish'
            AND $wpdb->posts.post_type = '{$this->post_type}'
            AND $wpdb->posts.post_date < NOW()
            ORDER BY $wpdb->posts.post_date DESC
            LIMIT 0,{$limit}
         ";


          $pageposts = $wpdb->get_results($querystr, OBJECT);

          set_transient('st_items_nearby_'.$post_id,$pageposts,5*HOUR_IN_SECONDS);
          return $pageposts;

    }
    function get_review_stats()
    {
        return array();
    }

    function display_posted_review_stats($comment_id)
    {
        if(get_post_type()==$this->post_type) {
            $data=$this->get_review_stats();

            $output[]='<ul class="list booking-item-raiting-summary-list mt20">';

            if(!empty($data) and is_array($data))
            {
                foreach($data as $value)
                {
                    $key=$value['title'];

                    $stat_value=get_comment_meta($comment_id,'st_stat_'.sanitize_title($value['title']),true);

                    $output[]='
                    <li>
                        <div class="booking-item-raiting-list-title">'.$key.'</div>
                        <ul class="icon-group booking-item-rating-stars">';
                    for($i=1;$i<=5;$i++)
                    {
                        $class='';
                        if($i>$stat_value) $class='text-gray';
                        $output[]='<li><i class="fa fa-smile-o '.$class.'"></i>';
                    }

                    $output[]='
                        </ul>
                    </li>';
                }
            }

            $output[]='</ul>';


            echo implode("\n",$output);
        }
    }
    function getOrderby()
    {
        $this->orderby=array(
            'price_asc'=>array(
                'key'=>'price_asc',
                'name'=>__('Price (low to high)',ST_TEXTDOMAIN)
            ),
            'price_desc'=>array(
                'key'=>'price_desc',
                'name'=>__('Price (hight to low)',ST_TEXTDOMAIN)
            ),
            'avg_rate'=>array(
                'key'=>'avg_rate',
                'name'=>__('Review',ST_TEXTDOMAIN)
            )
        );

        return $this->orderby;
    }
    public  function do_init_metabox()
    {
        $custom_metabox=$this->metabox;
        /**
         * Register our meta boxes using the
         * ot_register_meta_box() function.
         */
        if ( function_exists( 'ot_register_meta_box' ) )
        {
            if(!empty($custom_metabox))
            {
                foreach ($custom_metabox as $value)
                {
                    ot_register_meta_box( $value );
                }
            }
        }
    }

    //Helper class
    static function get_last_booking_string($post_id=false)
    {
       if(!$post_id and !is_singular()) return false;
        global $wpdb;

        $post_id=get_the_ID();
        $where='';
        $join='';

        $post_type=get_post_type($post_id);

        switch($post_type) {


            default:
                $where.="and meta_value in (
                    SELECT ID from {$wpdb->posts}
                    where post_type='{$post_type}'
                )";
                break;
        }




        $query="SELECT * from ".$wpdb->postmeta."
                {$join}
                where meta_key='item_id'
                {$where}

                order by meta_id desc
                limit 0,1";

        $data= $wpdb->get_results($query,OBJECT);

        if(!empty($data)){
            foreach($data as $key=>$value)
            {
                return human_time_diff(get_the_time('U',$value->post_id), current_time('timestamp')).__(' ago',ST_TEXTDOMAIN);
            }
        }




    }

    static function get_card($card_name)
    {
        $options=st()->get_option('booking_card_accepted',array());


        if(!empty($options)){
            foreach($options as $key){
                if(sanitize_title_with_dashes($key['title'])==$card_name) return $key;
            }
        }
    }

    static function get_orgin_booking_id($item_id)
    {
        if(get_post_type($item_id)=='hotel_room'){
            if($hotel_id=get_post_meta($item_id,'room_parent',true)){
                $item_id=$hotel_id;
            }
        }
        return apply_filters('st_orgin_booking_item_id',$item_id);
    }

    static function get_min_max_price($post_type){
        if(empty($post_type)){
            return array('price_min'=>0,'price_max'=>500);
        }
        $arg = array(
            'post_type'=>$post_type,
            'posts_per_page'=>'1',
            'order'=>'ASC',
            'meta_key'=>'sale_price',
            'orderby'=>'meta_value_num',
        );
        $query=new WP_Query($arg);
        if($query->have_posts()) {
            $query->the_post();
            $price_min = get_post_meta(get_the_ID(),'sale_price',true);
        }
        wp_reset_postdata();
        $arg = array(
            'post_type'=>$post_type,
            'posts_per_page'=>'1',
            'order'=>'DESC',
            'meta_key'=>'sale_price',
            'orderby'=>'meta_value_num',
        );
        $query=new WP_Query($arg);
        if($query->have_posts()) {
            $query->the_post();
            $price_max = get_post_meta(get_the_ID(),'sale_price',true);
        }
        wp_reset_postdata();
        if(empty($price_min))$price_min=0;
        if(empty($price_max))$price_max=500;
        return array('price_min'=>ceil($price_min),'price_max'=>ceil($price_max));
    }

    static function get_list_location(){
        $arg = array(
            'post_type'=>'location',
            'posts_per_page'=>'-1',
            'order'=>'ASC',
            'orderby'=>'title',
            'post_parent'=>0,
        );
        $array_list=array();
        query_posts($arg);
        while(have_posts()){
            the_post();
            $array_list[]=array(
                'id'=>get_the_ID(),
                'title'=>get_the_title()
            );
            $children_array = self::get_child_location(get_the_ID(),'-');
            if(!empty($children_array)){
               foreach($children_array as $k=>$v){
                   $array_list[]=array(
                       'id'=>$v['id'],
                       'title'=>$v['title']
                   );
                   $children_array2 = self::get_child_location($v['id'],'--');
                   if(!empty($children_array2)) {
                       foreach ($children_array2 as $k2 => $v2) {
                           $array_list[]=array(
                               'id'=>$v2['id'],
                               'title'=>$v2['title']
                           );
                           $children_array3 = self::get_child_location($v2['id'],'---');
                           if(!empty($children_array3)) {
                               foreach ($children_array3 as $k3 => $v3) {
                                   $array_list[]=array(
                                       'id'=>$v3['id'],
                                       'title'=>$v3['title']
                                   );
                               }
                           }
                       }
                   }
               }
            }
        }
        wp_reset_query();
        return $array_list;
    }
    static function get_child_location($id , $prent){
        $args = array(
            'post_parent' => $id,
            'post_type'   => 'location',
            'posts_per_page' => -1,
        );
        $children_array = get_children( $args );
        $array_list = array();
        if(!empty($children_array)){
            foreach($children_array as $k=>$v){
                $array_list[]=array(
                    'id'=>$v->ID,
                    'title'=>$prent.$v->post_title
                );
            }
        }
        return $array_list;
    }
}

$a=new TravelerObject();
