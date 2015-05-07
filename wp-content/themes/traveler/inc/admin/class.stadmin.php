<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STAdmin
 *
 * Created by ShineTheme
 *
 */

if(!class_exists('STAdmin'))
{

    class STAdmin
    {
        private  $template_dir='inc/admin/views';
        static private $message="";
        static private $message_type="";

        function __construct()
        {
            add_action('admin_enqueue_scripts',array($this,'admin_enqueue_scripts'));
            add_action( 'save_post', array($this,'update_location_info') );
            add_action( 'deleted_post', array($this,'update_location_info') );
        }

        function admin_enqueue_scripts()
        {
            wp_enqueue_style('st-admin',get_template_directory_uri().'/css/admin/admin.css');
            wp_enqueue_script('font-awesome',get_template_directory_uri().'/css/font-awesome.css');
        }

        function update_location_info($post_id)
        {
            if ( wp_is_post_revision( $post_id ) )
                return;
            $post_type=get_post_type($post_id);

            if($post_type=='st_cars' or $post_type=='st_activity'
                or $post_type=='st_tours'  or $post_type=='st_rental' /*or $post_type=='hotel'*/)
            {
                if($post_type=='st_rental' /*or $post_type=='hotel'*/){
                    $location = 'location_id';
                    $location_id = get_post_meta( $post_id ,$location,true);
                }else{
                    $location = 'id_location';
                    $location_id = get_post_meta( $post_id ,$location,true);
                }
                $ids_in=array();
                $parents = get_posts( array( 'numberposts' => -1, 'post_status' => 'publish', 'post_type' => 'location', 'post_parent' => $location_id ));

                $ids_in[]=$location_id;

                foreach( $parents as $child ){
                    $ids_in[]=$child->ID;
                }
                $arg = array(
                    'post_type'=>$post_type,
                    'posts_per_page'=>'-1',
                    'meta_query' => array(
                        array(
                            'key'     => $location,
                            'value'   => $ids_in,
                            'compare' => 'IN',
                        ),
                    ),
                );
                $query=new WP_Query($arg);
                $offer = $query->post_count;

                // get total review
                $arg = array(
                    'post_type'=>$post_type,
                    'posts_per_page'=>'-1',
                    'meta_query' => array(
                        array(
                            'key'     => $location,
                            'value'   => $ids_in,
                            'compare' => 'IN',
                        ),
                    ),
                );
                $query=new WP_Query($arg);
                $total=0;
                if($query->have_posts()) {
                    while($query->have_posts()){
                        $query->the_post();
                        $total +=get_comments_number();
                    }
                }
                // get car min price
                $arg = array(
                    'post_type'=>$post_type,
                    'posts_per_page'=>'1',
                    'order'=>'ASC',
                    'meta_key'=>'sale_price',
                    'orderby'=>'meta_value_num',
                    'meta_query' => array(
                        array(
                            'key'     => $location,
                            'value'   => $ids_in,
                            'compare' => 'IN',
                        ),
                    ),
                );
                $query=new WP_Query($arg);
                if($query->have_posts()) {
                    $query->the_post();
                    $price_min = get_post_meta(get_the_ID(),'sale_price',true);
                }
                wp_reset_postdata();
                update_post_meta($location_id,'review_'.$post_type,$total);
                if(isset($price_min))
                update_post_meta($location_id,'min_price_'.$post_type,$price_min);
                update_post_meta($location_id,'offer_'.$post_type,$offer);
            }
        }

        function array_splice_assoc(&$input, $offset, $length = 0, $replacement = array()) {
            $tail = array_splice($input, $offset);
            $extracted = array_splice($tail, 0, $length);
            $input += $replacement + $tail;
            return $extracted;
        }

        static function get_history_bookings($type="st_hotel",$offset,$limit)
        {
            global $wpdb;
            $where='';
            $join='';
            $select='';

            if(isset($_GET['st_date_start']) and $_GET['st_date_start'])
            {
                $date=date('Y-m-d',strtotime($_GET['st_date_start']));
                $join.=" INNER JOIN $wpdb->postmeta as mt1 on mt1.post_id=$wpdb->posts.ID";
                $where.=' AND  mt1.meta_key=\'check_in\'
                    AND CAST(mt1.meta_value AS DATE) >=\''.esc_sql($date).'\'
             ';
                //$select.=", STR_TO_DATE(mt1.meta_value,'%m-%d-%y') as date_picker";
            }

            if(isset($_GET['st_date_end']) and $_GET['st_date_end'])
            {
                $date=date('Y-m-d',strtotime($_GET['st_date_end']));
                $join.=" INNER JOIN $wpdb->postmeta as mt2 on mt2.post_id=$wpdb->posts.ID";
                $where.=' AND  mt2.meta_key=\'check_out\'
                    AND CAST(mt2.meta_value AS DATE) <=\''.esc_sql($date).'\'
             ';
                //$select.=", STR_TO_DATE(mt1.meta_value,'%m-%d-%y') as date_picker";
            }

            if($c_name=STInput::get('st_custommer_name'))
            {
                $join.=" INNER JOIN $wpdb->postmeta as mt3 on mt3.post_id=$wpdb->posts.ID";
                $where.=' AND  mt3.meta_key=\'st_first_name\'
             ';
                $where.=' AND mt3.meta_value like \'%'.esc_sql($c_name).'%\'';
            }

            $querystr = " SELECT SQL_CALC_FOUND_ROWS  $wpdb->posts.* {$select}";
            $querystr.="    FROM $wpdb->posts
                        INNER JOIN $wpdb->postmeta ON $wpdb->posts.ID=$wpdb->postmeta.post_id
                        {$join}
                        WHERE 1=1
                        AND $wpdb->posts.post_type = 'st_order'
                        AND $wpdb->postmeta.meta_key = 'item_id'
                        AND $wpdb->postmeta.meta_value in (SELECT {$wpdb->posts}.ID FROM $wpdb->posts WHERE {$wpdb->posts}.post_type='".sanitize_title_for_query($type)."' )
                        ".$where."
            ORDER BY $wpdb->posts.post_date DESC
            LIMIT {$offset},{$limit}
         ";


            $pageposts = $wpdb->get_results($querystr, OBJECT);


            return array('total'=>$wpdb->get_var( "SELECT FOUND_ROWS();" ),'rows'=>$pageposts);
        }

        static function set_message($message,$type=''){
            self::$message=$message;
            self::$message_type=$type;
        }

        static function message()
        {
            if(self::$message):
                ?>
                <div id="message" class="<?php echo self::$message_type?> below-h2">
                    <p><?php echo self::$message ?>
                    </p>
                </div>
            <?php endif;
        }


        function load_view($slug,$name=false,$data=array())
        {

            extract($data);

            if($name){
                $slug=$slug.'-'.$name;
            }

            //Find template in folder inc/admin/views/
            $template=locate_template($this->template_dir.'/'.$slug.'.php');


            //If file not found
            if(is_file($template))
            {
                ob_start();

                include $template;

                $data=@ob_get_clean();

                return $data;
            }
        }

        function init()
        {

            $files=array(

                'admin/class.user',
                'admin/class.admin.menus',
                'admin/class.attributes',
                'admin/class.admin.hotel',
                'admin/class.admin.room',
                'admin/class.admin.rental',
                'admin/class.admin.cars',
                'admin/class.admin.tours',
                'admin/class.admin.activity',
                'admin/class.admin.location',
                'admin/class.admin.order',
                'admin/class.admin.permalink',
            );


            st()->load_libs($files);
        }
    }

    $Admin=new STAdmin();

    $Admin->init();
}