<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STUser
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STUser'))
{

    class STUser extends STAdmin
    {
        private $extra_fields=array();

        function __construct()
        {
            parent::__construct();

        }



        //Do one time
        function init()
        {
            $this->extra_fields =array(

                'st_address'=>array(
                    'type'=>'text',
                    'label'=>__('Address Line 1',ST_TEXTDOMAIN),
                    'desc'=>__('Show under your reviews',ST_TEXTDOMAIN)
                ),
                'st_address2'=>array(
                    'type'=>'text',
                    'label'=>__('Address Line 2',ST_TEXTDOMAIN),
                    'desc'=>__('Address Line 2',ST_TEXTDOMAIN)
                ),
                'st_phone'=>array(
                    'type'=>'text',
                    'label'=>__('Phone',ST_TEXTDOMAIN),
                    'desc'=>__('Phone',ST_TEXTDOMAIN)
                ),
                'st_airport'=>array(
                    'type'=>'text',
                    'label'=>__('Airport',ST_TEXTDOMAIN),
                    'desc'=>__('Airport',ST_TEXTDOMAIN)
                ),
                'st_city'=>array(
                    'type'=>'text',
                    'label'=>__('City',ST_TEXTDOMAIN),
                    'desc'=>__('City',ST_TEXTDOMAIN)
                ),
                'st_province'=>array(
                    'type'=>'text',
                    'label'=>__('State/Province/Region',ST_TEXTDOMAIN),
                    'desc'=>__('State/Province/Region',ST_TEXTDOMAIN)
                ),
                'st_zip_code'=>array(
                    'type'=>'text',
                    'label'=>__('ZIP code/Postal code',ST_TEXTDOMAIN),
                    'desc'=>__('ZIP code/Postal code',ST_TEXTDOMAIN)
                ),
                'st_country'=>array(
                    'type'=>'text',
                    'label'=>__('Country',ST_TEXTDOMAIN),
                    'desc'=>__('Country',ST_TEXTDOMAIN)
                )

            );

            $this->extra_fields=apply_filters('st_user_extra_fields',$this->extra_fields);


            add_action( 'show_user_profile',array($this,'show_user_profile')  );
            add_action( 'edit_user_profile', array($this,'show_user_profile') );

            add_action( 'personal_options_update', array($this,'personal_options_update') );
            add_action( 'edit_user_profile_update', array($this,'personal_options_update') );


        }


        function show_user_profile($user)
        {
            echo balanceTags($this->load_view('users/profile',null,array('user'=>$user,'extra_fields'=>$this->extra_fields)));


        }

        function personal_options_update($user_id)
        {
            if ( !current_user_can( 'edit_user', $user_id ) )
                return false;

            if(!empty($this->extra_fields))
            {
                foreach($this->extra_fields as $key=> $value)
                {
                    update_user_meta($user_id, $key, sanitize_text_field($_POST[$key]));
                }
            }

        }

        static function count_comment($user_id=false,$post_id=false,$comment_type=false)
        {
            if(!$user_id)
            {
                if(is_user_logged_in())
                {

                    global $current_user;

                    $user_id=$current_user->ID;
                }
            }

            if($user_id)
            {
                global $wpdb;

                $query='SELECT COUNT(comment_ID) FROM ' . $wpdb->comments. ' WHERE user_id = "' . sanitize_title_for_query($user_id) . '"';


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

        static function count_review($user_id=false,$post_id=false)
        {
            return self::count_comment($user_id,$post_id,"st_reviews");
        }

    }

    $User=new STUser();

    $User->init();
}