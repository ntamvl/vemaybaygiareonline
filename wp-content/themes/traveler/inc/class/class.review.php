<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STReview
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STReview'))
{
    class STReview
    {

        function __construct()
        {

        }

        function init()
        {
            add_action( 'comment_post', array($this,'save_comment_meta_data') );

            add_action('wp_ajax_like_review',array($this,'like_review'));
            add_action('wp_ajax_nopriv_like_review',array($this,'like_review'));


        }

        function like_review()
        {

            $comment_id=STInput::post('comment_ID');

            if($this->find_by($comment_id))
            {

                $comment_like_count = get_comment_meta( $comment_id, "_comment_like_count", true ); // comment like count

                $data=array(
                    'like_status'=>true,
                    'message'=>__('You like this',ST_TEXTDOMAIN),
                    'like_count'=>$comment_like_count
                );

                //For logged user
                if(is_user_logged_in()){
                    $user_id = get_current_user_id(); // current user

                    $meta_COMMENTS = get_user_option( "_liked_comments", $user_id  ); // comments ids from user meta

                    $meta_USERS = get_comment_meta( $comment_id, "_user_liked" ); // user ids from comment meta


                    $liked_COMMENTS = NULL; // setup array variable
                    $liked_USERS = NULL; // setup array variable

                    if ( count( $meta_COMMENTS ) != 0 ) { // meta exists, set up values
                        $liked_COMMENTS = $meta_COMMENTS;
                    }

                    if ( !is_array( $liked_COMMENTS ) ) // make array just in case
                        $liked_COMMENTS = array();

                    if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
                        $liked_USERS = $meta_USERS[0];
                    }
                    if ( !is_array( $liked_USERS ) ) // make array just in case
                        $liked_USERS = array();

                    $liked_COMMENTS['comment-'.$comment_id] = $comment_id; // Add comment id to user meta array
                    $liked_USERS['user-'.$user_id] = $user_id; // add user id to comment meta array
                    $user_likes = count( $liked_COMMENTS ); // count user likes

                    if ( !$this->check_like( $comment_id ) ) { // like the comment

                        update_comment_meta( $comment_id, "_user_liked", $liked_USERS ); // Add user ID to comment meta
                        update_comment_meta( $comment_id, "_comment_like_count", ++$comment_like_count ); // +1 count comment meta
                        update_user_option( $user_id, "_liked_comments", $liked_COMMENTS ); // Add comment ID to user meta
                        update_user_option( $user_id, "_user_like_count", $user_likes ); // +1 count user meta


                        $data['like_count']=$comment_like_count;

                    } else { // unlike the comment
                        $pid_key = array_search( $comment_id, $liked_COMMENTS ); // find the key
                        $uid_key = array_search( $user_id, $liked_USERS ); // find the key
                        unset( $liked_COMMENTS[$pid_key] ); // remove from array
                        unset( $liked_USERS[$uid_key] ); // remove from array
                        $user_likes = count( $liked_COMMENTS ); // recount user likes
                        update_comment_meta( $comment_id, "_user_liked", $liked_USERS ); // Remove user ID from comment meta
                        update_comment_meta($comment_id, "_comment_like_count", --$comment_like_count ); // -1 count comment meta
                        update_user_option( $user_id, "_liked_comments", $liked_COMMENTS ); // Remove comment ID from user meta
                        update_user_option( $user_id, "_user_like_count", $user_likes ); // -1 count user meta


                        $data['like_status']=false;
                        $data['like_count']=$comment_like_count;
                        $data['message']=false;
                    }


                }else{
                    // user is not logged in (anonymous)
                    $ip = STInput::ip_address(); // user IP address
                    $meta_IPS = get_comment_meta( $comment_id, "_user_IP" ); // stored IP addresses
                    $liked_IPS = NULL; // set up array variable

                    if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
                        $liked_IPS = $meta_IPS[0];
                    }

                    if ( !is_array( $liked_IPS ) ) // make array just in case
                        $liked_IPS = array();

                    if ( !in_array( $ip, $liked_IPS ) ) // if IP not in array
                        $liked_IPS['ip-'.$ip] = $ip; // add IP to array

                    if ( !$this->check_like( $comment_id ) ) { // like the comment
                        update_comment_meta( $comment_id, "_user_IP", $liked_IPS ); // Add user IP to comment meta
                        update_comment_meta( $comment_id, "_comment_like_count", ++$comment_like_count ); // +1 count comment meta
                        $data['like_count']=$comment_like_count;

                    } else { // unlike the comment
                        $ip_key = array_search( $ip, $liked_IPS ); // find the key
                        unset( $liked_IPS[$ip_key] ); // remove from array
                        update_comment_meta( $comment_id, "_user_IP", $liked_IPS ); // Remove user IP from comment meta
                        update_comment_meta( $comment_id, "_comment_like_count", --$comment_like_count ); // -1 count comment meta

                        $data['like_status']=false;
                        $data['like_count']=$comment_like_count;
                        $data['message']=false;

                    }
                }

                echo json_encode(array(
                    'status'=>1,
                    'data'=>$data
                ));


            }else{
                echo json_encode(array(
                    'status'=>0,
                    'error'=>array(
                        'error_code'=>'comment_not_exists',
                        'error_message'=>__('Review does not exists',ST_TEXTDOMAIN)
                    )
                ));
            }

            exit();


        }

        function check_like( $comment_id ) { // test if user liked before
            if ( is_user_logged_in() ) { // user is logged in
                $user_id = get_current_user_id(); // current user
                $meta_USERS = get_comment_meta( $comment_id, "_user_liked" ); // user ids from comment meta
                $liked_USERS = ""; // set up array variable

                if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
                    $liked_USERS = $meta_USERS[0];
                }

                if( !is_array( $liked_USERS ) ) // make array just in case
                    $liked_USERS = array();

                if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
                    return true;
                }
                return false;

            } else { // user is anonymous, use IP address for voting

                $meta_IPS = get_comment_meta( $comment_id, "_user_IP" ); // get previously voted IP address
                $ip = STInput::ip_address();

                $liked_IPS = ""; // set up array variable

                if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
                    $liked_IPS = $meta_IPS[0];
                }

                if ( !is_array( $liked_IPS ) ) // make array just in case
                    $liked_IPS = array();

                if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
                    return true;
                }
                return false;
            }

        }


        function find_by($comment_id=false,$key='comment_ID')
        {
            if($comment_id and $key)
            {
                global $wpdb;

                $query="SELECT count({$wpdb->comments}.comment_ID) as total from {$wpdb->comments} WHERE 1=1 ";


                $query.=" and {$key}='{$comment_id}'";

                $count= $wpdb->get_var($query);

                return $count;
            }
        }

        function save_comment_meta_data( $comment_id ) {



            if ( ( isset( $_POST['comment_title'] ) ) && ( $_POST['comment_title'] != '') )
            {
                $title = wp_filter_nohtml_kses($_POST['comment_title']);
                add_comment_meta( $comment_id, 'comment_title', $title );
            }


            if ( ( isset( $_POST['comment_rate'] ) ) && ( $_POST['comment_rate'] != '') )
            {
                $rate = wp_filter_nohtml_kses($_POST['comment_rate']);
                if($rate>5)
                {
                    //Max rate is 5
                    $rate=5;
                }
                add_comment_meta( $comment_id, ' q', $rate );
            }



            $all_postype=st()->booking_post_type();

            $current_post_type=get_post_type( get_comment($comment_id)->comment_post_ID);

            if(in_array($current_post_type,$all_postype))
            {

                $comment_type = wp_filter_nohtml_kses('st_reviews');

                global $wpdb;
                $wpdb->update( $wpdb->comments, array('comment_type'=>$comment_type), array('comment_ID'=>$comment_id) ) ;
            }

            $comemntObj= get_comment( $comment_id );
            $post_id = $comemntObj->comment_post_ID;

            $avg=STReview::get_avg_rate($post_id);
            update_post_meta($post_id,'rate_review',$avg);


        }

        static function count_comment($post_id=false,$comment_type=false)
        {

            if($post_id)
            {
                global $wpdb;

                $query='SELECT COUNT(comment_ID) FROM ' . $wpdb->comments. ' WHERE 1=1 ';


                if($post_id)
                {
                    $query.=' AND comment_post_ID="'.sanitize_title_for_query($post_id).'"';
                }

                if($comment_type)
                {
                    $query.=' AND comment_type="'.sanitize_title_for_query($comment_type).'"';
                }

                $count = $wpdb->get_var($query);


                return $count;
            }
        }

        static function count_review($post_id=false)
        {
            return self::count_comment($post_id,"st_reviews");
        }

        static function get_avg_rate($post_id=false)
        {
            if(!$post_id)
            {
                $post_id=get_the_ID();
            }

            if($post_id)
            {
                global $wpdb;

                $query="SELECT ROUND( AVG(meta_value),1 ) as avg_rate from {$wpdb->comments} join {$wpdb->commentmeta} on {$wpdb->comments}.comment_ID={$wpdb->commentmeta}.comment_ID where 1=1";

                $query.=" and `comment_type`='st_reviews' ";
                $query.=" and `comment_approved`=1 ";

                $query.=" and comment_post_ID='".sanitize_title_for_query($post_id)."'";

                $query.="  and meta_key='comment_rate' ";


                return (float) $wpdb->get_var($query);
            }
            return 0;
        }
        static function get_percent_recommend($post_id=false,$min_rate=3)
        {
            if(!$post_id)
            {
                $post_id=get_the_ID();
            }

            if($post_id)
            {

                $total=get_comments_number($post_id);

                global $wpdb;

                $query="SELECT count({$wpdb->comments}.comment_ID) as total from {$wpdb->comments} join {$wpdb->commentmeta} on {$wpdb->comments}.comment_ID={$wpdb->commentmeta}.comment_ID where 1=1";

                $query.=" and `comment_type`='st_reviews' ";

                $query.=" and comment_post_ID='".sanitize_title_for_query($post_id)."'";

                $query.=" and `comment_approved`=1 ";


                $query.=" and meta_value>='".sanitize_title_for_query($min_rate)."'";


                $query.="  and meta_key='comment_rate' ";


                $count= $wpdb->get_var($query);

                if(!$total) return 0;

                $percent= round(($count/$total)*100);

                if($percent>100)
                    $percent=100;

                return $percent;
            }
        }

        static function count_review_by_rate($post_id=false,$rate='')
        {
            if(!$post_id)
            {
                $post_id=get_the_ID();
            }

            if($post_id)
            {

                global $wpdb;

                $query="SELECT count({$wpdb->comments}.comment_ID) as total from {$wpdb->comments} join {$wpdb->commentmeta} on {$wpdb->comments}.comment_ID={$wpdb->commentmeta}.comment_ID where 1=1";

                $query.=" and `comment_type`='st_reviews'";

                $query.=" and comment_post_ID='".sanitize_title_for_query($post_id)."'";


                $query.=" and meta_value='".sanitize_title_for_query($rate)."'";
                $query.=" and `comment_approved`=1 ";


                $query.="  and meta_key='comment_rate' ";


                $count= $wpdb->get_var($query);

                return $count;
            }
        }

        static function get_avg_stat($post_id=false,$stat=false)
        {
            if(!$post_id)
            {
                $post_id=get_the_ID();
            }

            if($post_id and $stat)
            {
                $stat=sanitize_title($stat);
                global $wpdb;

                $query="SELECT avg({$wpdb->commentmeta}.meta_value) as avg_rate from {$wpdb->comments} join {$wpdb->commentmeta} on {$wpdb->comments}.comment_ID={$wpdb->commentmeta}.comment_ID where 1=1";

                $query.=" and `comment_type`='st_reviews'";

                $query.=" and comment_post_ID='".sanitize_title_for_query($post_id)."'";

                $query.=" and `comment_approved`=1 ";

                $query.=" and meta_key='st_stat_$stat' ";


                $count= $wpdb->get_var($query);

                return $count;
            }
        }
        static function user_booked($post_id=false)
        {

            if(!$post_id) $post_id=get_the_ID();
            if(!is_user_logged_in()){
                return false;
            }
            $post_type=get_post_type($post_id);

            $user_id=get_current_user_id();

            $allow_review=true;
            switch($post_type)
            {
                case "st_hotel":
                    //Search Order By Customer ID
                    $order=new STOrder();
                    $count=$order->check_user_booked($user_id,$post_id,$post_type);

                    if($count<1){
                        $allow_review=FALSE;
                    }
                    break;

                case "st_rental":
                    //Search Order By Customer ID
                    $order=new STOrder();
                    $count=$order->check_user_booked($user_id,$post_id,$post_type);

                    if($count<1){
                        $allow_review=FALSE;
                    }
                    break;
                case "st_cars":
                    $allow_review=false;
                    break;
                case "st_tours":
                case "st_activity":
                    //Search Order By Customer ID
                    $order=new STOrder();
                    $count=$order->check_user_booked($user_id,$post_id,$post_type);

                    if($count<1){
                        $allow_review=FALSE;
                    }
                    break;
                    break;


                default:
                    $allow_review=FALSE;
                    break;
            }


            return $allow_review;


        }
        static function check_reviewed($post_id=false)
        {
            if(!$post_id){
                $post_id=get_the_ID();
            }

            if(!is_user_logged_in()){
                return false;
            }

            if(self::count_user_comment($post_id)>=1){
                return true;
            }
            return false;
        }

        static function check_reviewable($post_id=false)
        {
            if(!$post_id){
                $post_id=get_the_ID();
            }

            if(!is_user_logged_in()){
                return false;
            }

            if(self::count_user_comment($post_id)>=1){
                return false;
            }

            $is_review_need_booked=self::is_review_need_booked();
            if($is_review_need_booked){
                return self::user_booked($post_id);
            }else{
                return true;
            }

        }

        static function count_user_comment($post_id=false)
        {

            if(!$post_id) $post_id=get_the_ID();

            $user=wp_get_current_user();

            $email=$user->user_email;


            if($email){
                global $wpdb;

                $query="SELECT count({$wpdb->comments}.comment_ID) as total from {$wpdb->comments}  where 1=1";

                $query.=" and `comment_type`='st_reviews'";

                $query.=" and comment_post_ID='".sanitize_title_for_query($post_id)."'";
                $query.=" and comment_author_email='".sanitize_email($email)."'";
                $query.=" and comment_approved=1";


                $count= $wpdb->get_var($query);


                return $count;
            }
        }

        static function is_review_need_booked()
        {
            $option=st()->get_option('review_need_booked','on');
            if($option=='on') $rs=true;

            else $rs=false;

            return apply_filters('st_is_review_need_booked',$rs);
        }

    }
    $a=new STReview();

    $a->init();
}
