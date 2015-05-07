<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STUser_f
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STUser_f'))
{
    class STUser_f extends TravelerObject
    {
        public static $msg ='';
        function init()
        {
            parent::init();
            add_action('init',array($this,'st_login_func'));
            add_action('init',array($this,'update_user'));
            add_action('init',array($this,'update_pass'));
            add_action('init',array($this,'upload_image'));
            add_action('init',array($this,'st_insert_post_type_hotel'));
            add_action('init',array($this,'st_insert_post_type_rental'));
            add_action('init',array($this,'st_insert_post_type_cruise'));
            add_action('init',array($this,'st_insert_post_type_cruise_cabin'));
            add_action('init',array($this,'st_insert_post_type_room'));
            add_action('init',array($this,'st_insert_post_type_tours'));
            add_action('init',array($this,'st_insert_post_type_activity'));
            add_action('init',array($this,'st_insert_post_type_cars'));
            add_action('init',array($this,'st_write_review'));



            add_action( 'wp_ajax_st_add_wishlist',array($this,'st_add_wishlist_func')  );
            add_action( 'wp_ajax_nopriv_st_add_wishlist', array($this,'st_add_wishlist_func'));

            add_action( 'wp_ajax_st_remove_wishlist',array($this,'st_remove_wishlist_func')  );
            add_action( 'wp_ajax_nopriv_st_remove_wishlist', array($this,'st_remove_wishlist_func'));

            add_action( 'wp_ajax_st_load_more_wishlist',array($this,'st_load_more_wishlist_func')  );
            add_action( 'wp_ajax_nopriv_st_load_more_wishlist', array($this,'st_load_more_wishlist_func'));

            add_action( 'wp_ajax_st_remove_post_type',array($this,'st_remove_post_type_func')  );
            add_action( 'wp_ajax_nopriv_st_remove_post_type', array($this,'st_remove_post_type_func'));

            add_action('template_redirect',array($this,'check_login'));

            add_action( 'wp_ajax_st_load_more_history_book',array($this,'get_book_history')  );
            add_action( 'wp_ajax_nopriv_st_load_more_history_book', array($this,'get_book_history'));

        }
        function check_login(){
            if( is_page_template('template-user.php') ){
                if(!is_user_logged_in()){
                    $page_login = st()->get_option('page_user_login');
                    if(!empty($page_login)){
                        $location = esc_url(add_query_arg( 'page_id', $page_login, home_url() ));
                        wp_redirect( $location, 301 );
                        exit;
                    }else{
                        wp_redirect( home_url() );
                        exit;
                    }

                }
            }
            if( is_page_template('template-login.php') || is_page_template('template-login-normal.php')){
                if(is_user_logged_in()){
                    wp_redirect( home_url() );
                    exit;
                }
            }
        }
        /**
         *  Login form and regedit
         */
        function dlf_auth( $username, $password ) {

            global $user;
            global $status_login;
            $creds = array();
            $creds['user_login'] = $username;
            $creds['user_password'] =  $password;
            $creds['remember'] = true;
            $user = wp_signon( $creds, false );
            if ( is_wp_error($user) ) {
                if($user->get_error_message() !=""){
                    $status_login  = '<div class="error_login">';
                    $status_login .= $user->get_error_message();
                    $status_login .= ' </div>';
                }
            }
            if ( !is_wp_error($user) ) {
                $page_login = st()->get_option('page_redirect_to_after_login');
                if(!empty($page_login)){
                    $location = esc_url(add_query_arg( 'page_id', $page_login, home_url() ));
                    wp_redirect( $location, 301 );
                    exit;
                }else{
                    wp_redirect( home_url() );
                    exit;
                }
            }
        }


        function st_login_func(){
            if (isset($_POST['dlf_submit'])) {
                $this->dlf_auth($_POST['login_name'], $_POST['login_password']);
            }
        }

        static  function validation()
        {
            $full_name = $_REQUEST['full_name'];
            $password = $_REQUEST['password'];
            $email = $_REQUEST['email'];

            if (empty($full_name) || empty($password) || empty($email)) {
                return new WP_Error('field', __('Required form field is missing', ST_TEXTDOMAIN));
            }
            if (strlen($full_name) < 3) {
                return new WP_Error('username_length', __('Name too short. At least 3 characters is required', ST_TEXTDOMAIN));
            }
            if (strlen($password) < 6) {
                return new WP_Error('password', __('Password length must be greater than 6', ST_TEXTDOMAIN));
            }
            if (!is_email($email)) {
                return new WP_Error('email_invalid', __('Email is not valid', ST_TEXTDOMAIN));
            }
            if (email_exists($email)) {
                return new WP_Error('email', __('Email Already in use', ST_TEXTDOMAIN));
            }
        }


        static  function registration_user()
        {
            $userdata = array(
                'user_login' => esc_attr( $_REQUEST['email'] ),
                'user_email' => esc_attr( $_REQUEST['email'] ),
                'user_pass' => esc_attr(  $_REQUEST['password']  ),
                // 'user_url' => esc_attr($this->website),
                'first_name' => esc_attr(  $_REQUEST['full_name'] ),
                //'last_name' => esc_attr(  $_REQUEST['full_name']  ),
                // 'nickname' => esc_attr($this->nickname),
                // 'description' => esc_attr($this->bio),
            );

            if (is_wp_error( self::validation() )) {
                echo '<div  class="error_login">';
                echo '<strong>' . self::validation()->get_error_message() . '</strong>';
                echo '</div>';
            } else {
                $register_user = wp_insert_user($userdata);
                if (!is_wp_error($register_user)) {
                    wp_new_user_notification($register_user , $_REQUEST['password']);
                    echo '<div  class="success_login">';
                    echo '<strong>Registration complete.</strong>';
                    echo '</div>';
                } else {
                    echo '<div  class="error_login">';
                    echo '<strong>' . $register_user->get_error_message() . '</strong>';
                    echo '</div>';
                }
            }

        }
        /* Function update meta user */
        function update_user()
        {
            global $current_user;
            if(!empty($_REQUEST['st_btn_update'])) {

                if(wp_verify_nonce( $_REQUEST['st_update_user'] , 'user_setting' )){
                    $id_user = $current_user->ID;

                    if(!empty($_FILES['st_avatar'])){
                        $st_avatar = $_FILES['st_avatar'];
                        $id_avatar = self::upload_image_return($st_avatar,'st_avatar',$st_avatar['type']);
                    }else{
                        $id_avatar = $_REQUEST['id_avatar'];
                    }
                    update_user_meta($id_user, 'st_avatar', $id_avatar );
                    update_user_meta($id_user, 'st_phone', $_REQUEST['st_phone'] );
                    update_user_meta($id_user, 'st_airport', $_REQUEST['st_airport'] );
                    update_user_meta($id_user, 'st_address', $_REQUEST['st_address'] );
                    update_user_meta($id_user, 'st_city', $_REQUEST['st_city'] );
                    update_user_meta($id_user, 'st_province', $_REQUEST['st_province'] );
                    update_user_meta($id_user, 'st_zip_code', $_REQUEST['st_zip_code'] );
                    update_user_meta($id_user, 'st_country', $_REQUEST['st_country'] );
                    $is_check = '';
                    if(!empty($_REQUEST['st_is_check_show_info'])){
                        $is_check='on';
                    }
                    update_user_meta($id_user, 'st_is_check_show_info', $is_check );

                    $name = $_REQUEST['st_name'];
                    $userdata = array(
                        'ID' => $id_user,
                        'display_name' => esc_attr($name),
                    );
                    wp_update_user($userdata);
                    wp_redirect( TravelHelper::build_url('url',$_GET['url']).'&status="success"');
                    exit();
                }else{
                    print 'Sorry, your nonce did not verify.';
                    exit;
                }

            }
        }
        /* Function update meta user */
        function update_pass()
        {
            if(!empty($_REQUEST['btn_update_pass'])) {
                $old_pass = $_REQUEST['old_pass'];
                $new_pass = $_REQUEST['new_pass'];
                $new_pass_again = $_REQUEST['new_pass_again'];
                $user_login = $_REQUEST['user_login'];
                $user = get_user_by( 'login', $user_login );
                if ( $user && wp_check_password( $old_pass , $user->data->user_pass, $user->ID) ){
                    if($new_pass == $new_pass_again && $new_pass != ""){
                        if (strlen($new_pass) > 6) {

                            $userdata = array(
                                'ID' => $user->ID,
                                'user_pass' => $new_pass,
                            );
                            wp_update_user($userdata);
                            //wp_set_password( $new_pass, $user->ID );
                            self::$msg = array(
                                'status'=>'success',
                                'msg'=>__('Change password successfully !',ST_TEXTDOMAIN)
                            );
                        }else{
                            self::$msg = array(
                                'status'=>'danger',
                                'msg'=>__('Password length must be greater than 6',ST_TEXTDOMAIN)
                            );
                        }
                    }else{
                        self::$msg = array(
                            'status'=>'danger',
                            'msg'=>__('Password dose not match !',ST_TEXTDOMAIN)
                        );
                    }
                }else{
                    self::$msg = array(
                        'status'=>'danger',
                        'msg'=>__('Password incorrect !',ST_TEXTDOMAIN)
                    );
                }
            }
        }
        function st_add_wishlist_func() {
            $data_id = $_REQUEST['data_id'];
            $data_type = $_REQUEST['data_type'];

            $current_user = wp_get_current_user();
            $data_list = get_user_meta( $current_user->ID , 'st_wishlist' , true);
            $data_list = json_decode($data_list);
            $date = new DateTime();
            $date = mysql2date('M d, Y', $date->format('Y-m-d') );

            $tmp_data=array();
            if($data_list !='' and is_array($data_list)){
                $check = true;
                $i=0;
                foreach($data_list as $k => $v){
                    if($v->id == $data_id and $v->type == $data_type){
                        $check = false;
                    }else{
                        array_unshift($tmp_data , $data_list[$i] );
                    }
                    $i++;
                }
                if($check == true){
                    array_unshift($tmp_data , array(
                            'id' => $data_id,
                            'type'=>$data_type,
                            'date'=>$date
                        )
                    );
                    echo json_encode(array('status'=>'true','msg'=>'ID :'.$data_id , 'icon' =>'<i class="fa fa-heart"></i>' , 'title'=>st_get_language('remove_to_wishlist')));
                }else{
                    echo json_encode(array('status'=>'true','msg'=>'ID :'.$data_id , 'icon' =>'<i class="fa fa-heart-o"></i>','title'=>st_get_language('add_to_wishlist')));
                }
                update_user_meta( $current_user->ID , 'st_wishlist', json_encode($tmp_data) );
            }else{
                $user_meta = array(
                    array(
                        'id' => $data_id,
                        'type'=>$data_type,
                        'date'=>$date
                    ),
                );
                update_user_meta( $current_user->ID , 'st_wishlist', json_encode($user_meta) );
                echo json_encode(array('status'=>'true','msg'=>'ID :'.$data_id , 'icon' =>'<i class="fa fa-heart"></i>'));
            }
            die();
        }
        function st_remove_wishlist_func() {
            $data_id = $_REQUEST['data_id'];
            $data_type = $_REQUEST['data_type'];

            $current_user = wp_get_current_user();
            $data_list = get_user_meta( $current_user->ID , 'st_wishlist' , true);
            $data_list = json_decode($data_list);
            $tmp_data=array();
            if($data_list !='' and is_array($data_list)){
                $i=0;
                foreach($data_list as $k => $v){
                    if($v->id == $data_id and $v->type == $data_type){
                    }else{
                        array_push($tmp_data , $data_list[$i] );
                    }
                    $i++;
                }
                update_user_meta( $current_user->ID , 'st_wishlist', json_encode($tmp_data) );
                echo json_encode(array('status' => 'true', 'msg' => $data_id, 'type' => 'success' , 'content'=>__('Delete successfully',ST_TEXTDOMAIN)));
            }else{
                echo json_encode(array('status' => 'false', 'msg' => $data_id, 'type' => 'danger' , 'content'=>__('Delete not successfully',ST_TEXTDOMAIN)));
            }

            die();
        }
        function st_load_more_wishlist_func() {
            $data_per = $_REQUEST['data_per'];
            $data_next = $_REQUEST['data_next'];
            $data_html='';
            $current_user = wp_get_current_user();
            $data_list = get_user_meta( $current_user->ID , 'st_wishlist' , true);
            $i_check = 0;
            if($data_list != '[]' or $data_list != '' ):
                $data_list = json_decode($data_list);
                $i = 0;
                foreach($data_list as $k=>$v):
                    if( $i >= $data_per  and $i < $data_next + $data_per):
                        $args = array(
                            'post_type' => $v->type,
                            'post__in'=>array($v->id),
                        );
                        query_posts($args);
                        $data_html .= st()->load_template('user/loop/loop','wishlist',get_object_vars($data_list[$i]));
                        $i_check ++;
                        wp_reset_query();
                    endif;
                    $i++;
                endforeach;
            endif;

            $status = 'true';
            if($i_check < $data_next){
                $status = 'false';
            }
            echo json_encode(array(
                'status'=>$status,
                'msg'   =>$data_html,
                'data_per'=>$data_next + $data_per
            ));
            die();
        }
        function upload_image(){
            if (
                isset( $_POST['my_image_upload_nonce'], $_POST['post_id'] )
                && wp_verify_nonce( $_POST['my_image_upload_nonce'], 'my_image_upload' )
                && current_user_can( 'edit_post', $_POST['post_id'] )
            ) {
                $f_type=$_FILES['my_image_upload']['type'];
                if ($f_type== "image/gif" OR $f_type== "image/png" OR $f_type== "image/jpeg" OR $f_type== "image/JPEG" OR $f_type== "image/PNG" OR $f_type== "image/GIF"){
                    // The nonce was valid and the user has the capabilities, it is safe to continue.

                    // These files need to be included as dependencies when on the front end.
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    require_once( ABSPATH . 'wp-admin/includes/media.php' );

                    // Let WordPress handle the upload.
                    // Remember, 'my_image_upload' is the name of our file input in our form above.
                    $attachment_id = media_handle_upload( 'my_image_upload', '' );

                    if ( is_wp_error( $attachment_id ) ) {
                        // There was an error uploading the image.
                    } else {
                        // The image was uploaded successfully!
                        self::$msg = array(
                            'status'=>'success',
                            'msg'=>'Uploaded successfully !'
                        );
                    }
                }else{
                    self::$msg = array(
                        'status'=>'danger',
                        'msg'=>'Uploaded not successfully !'
                    );
                }
            } else {
                // The security check failed, maybe show the user an error.
            }
        }
        function upload_image_return($file ,$flied_name, $type_file){

            $f_type = $type_file;
            if ($f_type== "image/gif" OR $f_type== "image/png" OR $f_type== "image/jpeg" OR $f_type== "image/JPEG" OR $f_type== "image/PNG" OR $f_type== "image/GIF"){
                // The nonce was valid and the user has the capabilities, it is safe to continue.

                // These files need to be included as dependencies when on the front end.
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
                require_once( ABSPATH . 'wp-admin/includes/media.php' );

                // Let WordPress handle the upload.
                // Remember, 'my_image_upload' is the name of our file input in our form above.
                $attachment_id = media_handle_upload( $flied_name , '' );

                if ( is_wp_error( $attachment_id ) ) {
                    return $attachment_id;
                    // There was an error uploading the image.
                } else {
                    // The image was uploaded successfully!
                    return $attachment_id;
                }
            }else{

            }
        }
        function st_remove_post_type_func() {
            $data_id = $_REQUEST['data_id'];
            $data_id_user = $_REQUEST['data_id_user'];
            $data_post = get_post($data_id);
            if($data_post->post_author == $data_id_user ){
                wp_delete_post( $data_id );
                echo json_encode(array('status' => 'true', 'msg' => $data_id, 'type' => 'success' , 'content'=>'Delete successfully'));
            }else {
                echo json_encode(array('status' => 'false', 'msg' => $data_id, 'type' => 'danger' , 'content'=>'Delete not successfully'));
            }
            die();
        }

        static function get_list_layout(){
            $arg = array(
                'post_type'=>'st_layouts',
                'numberposts' => -1
            );
            $list = query_posts($arg);
            $txt = '<select name="st_custom_layout" class="form-control">';
            while(have_posts()){
                the_post();
                $txt .= '<option value="'.get_the_ID().'">'.get_the_title().'</option>';
            }
            $txt .= ' </select>';
            wp_reset_query();
            return $txt;
        }
        static function get_list_taxonomy($tax='category',$array=array())
        {

            $args = array(
                'hide_empty' => 0
            );
            $taxonomies = get_terms($tax,$args);

            $r=array();

            if(!is_wp_error($taxonomies))
            {
                foreach ($taxonomies as $key => $value) {
                    # code...
                    $r[$value->term_id]=$value->name;

                }
            }

            return $r;
        }


        static function get_list_value_taxonomy($post_type){
            $data_value =array();

            $taxonomy= get_object_taxonomies($post_type,'object');
            foreach($taxonomy as $key => $value) {
                if ($key != 'st_category_cars') {
                    if ($key != 'st_cars_pickup_features') {
                        if ($key != 'cabin_type') {
                            if ($key != 'room_type') {
                                $args = array(
                                    'hide_empty' => 0
                                );
                                $data_term = get_terms($key,$args);
                                if(!empty($data_term)){
                                    foreach($data_term as $k=>$v){
                                        $icon = get_tax_meta($v->term_id,'st_icon');
                                        $icon = TravelHelper::handle_icon($icon);
                                        array_push(
                                            $data_value , array(
                                                'value'=>$v->term_id,
                                                'label'=>$v->name,
                                                'taxonomy'=>$v->taxonomy,
                                                'icon'=>$icon
                                            )
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $data_value;
        }

        static function get_msg(){
            if(!empty(STUser_f::$msg)){
                return '<div class="alert alert-'.STUser_f::$msg['status'].'">
                        <button data-dismiss="alert" type="button" class="close"><span aria-hidden="true">×</span>
                        </button>
                        <p class="text-small">'.STUser_f::$msg['msg'].'</p>
                      </div>';
            }
            return '';
        }

        /* Hotel */
        function st_insert_post_type_hotel(){
            if(!empty($_REQUEST['btn_insert_post_type_hotel'])){
                if(wp_verify_nonce( $_REQUEST['st_insert_post_hotel'] , 'user_setting' )) {
                    if(st()->get_option('partner_post_must_by_admin')=='on'){
                        $post_status = 'draft';
                    }else{
                        $post_status = 'publish';
                    }
                    $current_user = wp_get_current_user();
                    $title = $_REQUEST['title'];
                    $st_content = $_REQUEST['st_content'];
                    $desc = $_REQUEST['desc'];

                    $my_post = array(
                        'post_title' => $title,
                        'post_content' => $st_content,
                        'post_status' => $post_status,
                        'post_author' => $current_user->ID,
                        'post_type' => 'st_hotel',
                        'post_excerpt' => $desc
                    );
                    $id_post = wp_insert_post($my_post);
                    if(!empty($id_post)){
                        $featured_image = $_FILES['featured-image'];
                        // set featured_image
                        $id_featured_image = self::upload_image_return($featured_image,'featured-image',$featured_image['type']);
                        set_post_thumbnail( $id_post, $id_featured_image );
                        // metabox

                        $logo = $_FILES['logo'];
                        $id_logo = self::upload_image_return($logo,'logo',$logo['type']);
                        update_post_meta($id_post, 'logo', $id_logo );
                        // gallery
                        $gallery = $_FILES['gallery'];
                        if(!empty($gallery)){
                            $tmp_array=array();
                            for( $i=0 ; $i <count($gallery['name']) ; $i++  ){
                                array_push($tmp_array,array(
                                    'name'    =>$gallery['name'][$i],
                                    'type'    =>$gallery['type'][$i],
                                    'tmp_name'=>$gallery['tmp_name'][$i],
                                    'error'   =>$gallery['error'][$i],
                                    'size'    =>$gallery['size'][$i]
                                ));
                            }
                        }
                        $id_gallery='';
                        foreach($tmp_array as $k=>$v){
                            $_FILES['gallery'] = $v;
                            $id_gallery .= self::upload_image_return($_FILES['gallery'],'gallery',$_FILES['gallery']['type']).',';
                        }
                        $id_gallery = substr($id_gallery,0,-1);
                        update_post_meta($id_post, 'gallery', $id_gallery );
                        update_post_meta($id_post, 'id_location', $_REQUEST['id_location'] );
                        update_post_meta($id_post, 'address', $_REQUEST['address'] );
                        update_post_meta($id_post, 'email',  $_REQUEST['email'] );
                        update_post_meta($id_post, 'website', $_REQUEST['website'] );
                        update_post_meta($id_post, 'phone', $_REQUEST['phone'] );
                        update_post_meta($id_post, 'fax', $_REQUEST['fax'] );
                        update_post_meta($id_post, 'video', $_REQUEST['video'] );
                        update_post_meta($id_post, 'map_lat', $_REQUEST['map_lat'] );
                        update_post_meta($id_post, 'map_lng', $_REQUEST['map_lng'] );
                        update_post_meta($id_post, 'map_zoom', $_REQUEST['map_zoom'] );
                        update_post_meta($id_post, 'total_sale_number','1' );
                        update_post_meta($id_post, 'rate_review','1' );

                        if(!empty($_REQUEST['taxonomy'])){
                            $taxonomy = $_REQUEST['taxonomy'];
                            if(!empty($taxonomy)){
                                foreach($taxonomy as $k=>$v){
                                    $tmp = explode(",",$v);
                                    $term = get_term($tmp[0] , $tmp[1]);

                                    $ids = array();
                                    $term_up = get_the_terms($id_post, $tmp[1]);
                                    if(!empty($term_up)){
                                        foreach($term_up as $key => $value){
                                            array_push($ids,$value->term_id);
                                        }
                                    }
                                    array_push($ids,$term->term_taxonomy_id);
                                    wp_set_post_terms( $id_post, $ids , $tmp[1]  );
                                }
                            }
                        }
                        self::$msg = array(
                            'status'=>'success',
                            'msg'=>'Create hotel successfully !'
                        );
                    }else{
                        self::$msg = array(
                            'status'=>'danger',
                            'msg'=>'Error : Create hotel not successfully !'
                        );
                    }

                }
            }
        }

        /* Room */
        function st_insert_post_type_room(){
            if(!empty($_REQUEST['btn_insert_post_type_room'])){
                if(wp_verify_nonce( $_REQUEST['st_insert_room'] , 'user_setting' )) {
                    if(st()->get_option('partner_post_must_by_admin')=='on'){
                        $post_status = 'draft';
                    }else{
                        $post_status = 'publish';
                    }
                    $current_user = wp_get_current_user();
                    $title = $_REQUEST['title'];
                    $st_content = $_REQUEST['st_content'];
                    $my_post = array(
                        'post_title' => $title,
                        'post_content' => $st_content,
                        'post_status' => $post_status,
                        'post_author' => $current_user->ID,
                        'post_type' => 'hotel_room',
                        'post_excerpt' => $_REQUEST['desc']
                    );
                    $id_post = wp_insert_post($my_post);
                    if(!empty($id_post)){
                        $featured_image = $_FILES['featured-image'];
                        // set featured_image
                        $id_featured_image = self::upload_image_return($featured_image,'featured-image',$featured_image['type']);
                        set_post_thumbnail( $id_post, $id_featured_image );
                        // metabox
                        update_post_meta($id_post, 'id_location', $_REQUEST['id_location'] );
                        update_post_meta($id_post, 'address', $_REQUEST['address'] );
                        update_post_meta($id_post, 'email',  $_REQUEST['email'] );
                        update_post_meta($id_post, 'website', $_REQUEST['website'] );
                        update_post_meta($id_post, 'phone', $_REQUEST['phone'] );
                        update_post_meta($id_post, 'map_lat', $_REQUEST['map_lat'] );
                        update_post_meta($id_post, 'map_lng', $_REQUEST['map_lng'] );
                        update_post_meta($id_post, 'map_zoom', $_REQUEST['map_zoom'] );
                        update_post_meta($id_post, 'total_sale_number','1' );
                        update_post_meta($id_post, 'rate_review','1' );
                        self::$msg = array(
                            'status'=>'success',
                            'msg'=>'Create room successfully !'
                        );
                    }else{
                        self::$msg = array(
                            'status'=>'danger',
                            'msg'=>'Error : Create room not successfully !'
                        );
                    }
                }
            }
        }
        /* Tours */
        function st_insert_post_type_tours(){
            if(!empty($_REQUEST['btn_insert_post_type_tours'])){
                if(wp_verify_nonce( $_REQUEST['st_insert_post_tours'] , 'user_setting' )) {
                    if(st()->get_option('partner_post_by_admin')=='on'){
                        $post_status = 'draft';
                    }else{
                        $post_status = 'publish';
                    }
                    $current_user = wp_get_current_user();
                    $title = $_REQUEST['title'];
                    $st_content = $_REQUEST['st_content'];
                    $my_post = array(
                        'post_title' => $title,
                        'post_content' => $st_content,
                        'post_status' => $post_status,
                        'post_author' => $current_user->ID,
                        'post_type' => 'st_tours',
                        'post_excerpt' => $_REQUEST['desc'],
                    );
                    $id_post = wp_insert_post($my_post);
                    wp_set_post_terms( $id_post,  $_REQUEST['id_category'] , 'st_tour_type'  );

                    if(!empty($id_post)){
                        $featured_image = $_FILES['featured-image'];
                        // set featured_image
                        $id_featured_image = self::upload_image_return($featured_image,'featured-image',$featured_image['type']);
                        set_post_thumbnail( $id_post, $id_featured_image );
                        $gallery = $_FILES['gallery'];
                        if(!empty($gallery)){
                            $tmp_array=array();
                            for( $i=0 ; $i <count($gallery['name']) ; $i++  ){
                                array_push($tmp_array,array(
                                    'name'    =>$gallery['name'][$i],
                                    'type'    =>$gallery['type'][$i],
                                    'tmp_name'=>$gallery['tmp_name'][$i],
                                    'error'   =>$gallery['error'][$i],
                                    'size'    =>$gallery['size'][$i]
                                ));
                            }
                        }
                        $id_gallery='';
                        foreach($tmp_array as $k=>$v){
                            $_FILES['gallery'] = $v;
                            $id_gallery .= self::upload_image_return($_FILES['gallery'],'gallery',$_FILES['gallery']['type']).',';
                        }
                        $id_gallery = substr($id_gallery,0,-1);

                        update_post_meta($id_post, 'contact_email',  $_REQUEST['email'] );
                        update_post_meta($id_post, 'video',  $_REQUEST['video'] );
                        update_post_meta($id_post, 'gallery_style',  $_REQUEST['gallery_style'] );
                        update_post_meta($id_post, 'gallery', $id_gallery );
                        update_post_meta($id_post, 'id_location', $_REQUEST['id_location'] );
                        update_post_meta($id_post, 'address', $_REQUEST['address'] );
                        update_post_meta($id_post, 'map_lat', $_REQUEST['map_lat'] );
                        update_post_meta($id_post, 'map_lng', $_REQUEST['map_lng'] );
                        update_post_meta($id_post, 'map_zoom', $_REQUEST['map_zoom'] );

                        update_post_meta($id_post, 'type_price', $_REQUEST['type_price'] );
                        update_post_meta($id_post, 'price', $_REQUEST['price'] );
                        update_post_meta($id_post, 'adult_price', $_REQUEST['adult_price'] );
                        update_post_meta($id_post, 'child_price', $_REQUEST['child_price'] );
                        update_post_meta($id_post, 'discount', $_REQUEST['discount'] );
                        if(!empty($_REQUEST['is_sale_schedule']))$is_sale_schedule='on' ;else $is_sale_schedule='off';
                        update_post_meta($id_post, 'is_sale_schedule', $is_sale_schedule );
                        update_post_meta($id_post, 'sale_price_from', $_REQUEST['sale_price_from'] );
                        update_post_meta($id_post, 'sale_price_to', $_REQUEST['sale_price_to'] );

                        update_post_meta($id_post, 'type_tour', $_REQUEST['tour_type'] );
                        update_post_meta($id_post, 'check_in', $_REQUEST['check_in'] );
                        update_post_meta($id_post, 'check_out', $_REQUEST['check_out'] );
                        update_post_meta($id_post, 'max_people', $_REQUEST['max_people'] );
                        update_post_meta($id_post, 'duration_day', $_REQUEST['duration'] );

                        if(!empty($_REQUEST['program_title'])){
                            $program_title = $_REQUEST['program_title'];
                            $program_desc  = $_REQUEST['program_desc'];
                            $program =array();
                            if(!empty($program_title)){
                                foreach($program_title as $k=>$v){
                                    array_push($program,array(
                                        'title'=>$v,
                                        'desc'=>$program_desc[$k]
                                    ));
                                }
                            }
                            update_post_meta($id_post, 'tours_program',$program );
                        }
                        update_post_meta($id_post, 'rate_review','1' );
                        self::$msg = array(
                            'status'=>'success',
                            'msg'=>'Create Tours successfully !'
                        );
                    }else{
                        self::$msg = array(
                            'status'=>'danger',
                            'msg'=>'Error : Create Tours not successfully !'
                        );
                    }

                }
            }
        }

        /* Activity */
        function st_insert_post_type_activity(){
            if(!empty($_REQUEST['btn_insert_post_type_activity'])){
                if(wp_verify_nonce( $_REQUEST['st_insert_post_activity'] , 'user_setting' )) {
                    if(st()->get_option('partner_post_must_by_admin')=='on'){
                        $post_status = 'draft';
                    }else{
                        $post_status = 'publish';
                    }
                    $current_user = wp_get_current_user();
                    $title = $_REQUEST['title'];
                    $st_content = $_REQUEST['st_content'];
                    $my_post = array(
                        'post_title' => $title,
                        'post_content' => $st_content,
                        'post_status' => $post_status,
                        'post_author' => $current_user->ID,
                        'post_type' => 'st_activity',
                        'post_excerpt' => $_REQUEST['desc']
                    );
                    $id_post = wp_insert_post($my_post);
                    if(!empty($id_post)){
                        $featured_image = $_FILES['featured-image'];
                        // set featured_image
                        $id_featured_image = self::upload_image_return($featured_image,'featured-image',$featured_image['type']);
                        set_post_thumbnail( $id_post, $id_featured_image );
                        // metabox
                        // gallery
                        $gallery = $_FILES['gallery'];
                        if(!empty($gallery)){
                            $tmp_array=array();
                            for( $i=0 ; $i <count($gallery['name']) ; $i++  ){
                                array_push($tmp_array,array(
                                    'name'    =>$gallery['name'][$i],
                                    'type'    =>$gallery['type'][$i],
                                    'tmp_name'=>$gallery['tmp_name'][$i],
                                    'error'   =>$gallery['error'][$i],
                                    'size'    =>$gallery['size'][$i]
                                ));
                            }
                        }
                        $id_gallery='';
                        foreach($tmp_array as $k=>$v){
                            $_FILES['gallery'] = $v;
                            $id_gallery .= self::upload_image_return($_FILES['gallery'],'gallery',$_FILES['gallery']['type']).',';
                        }
                        $id_gallery = substr($id_gallery,0,-1);

                        update_post_meta($id_post, 'contact_email',  $_REQUEST['email'] );
                        update_post_meta($id_post, 'contact_web',  $_REQUEST['website'] );
                        update_post_meta($id_post, 'contact_phone',  $_REQUEST['phone'] );
                        update_post_meta($id_post, 'video',  $_REQUEST['video'] );
                        update_post_meta($id_post, 'gallery_style',  $_REQUEST['gallery_style'] );
                        update_post_meta($id_post, 'gallery', $id_gallery );

                        update_post_meta($id_post, 'id_location', $_REQUEST['id_location'] );
                        update_post_meta($id_post, 'address', $_REQUEST['address'] );
                        update_post_meta($id_post, 'map_lat', $_REQUEST['map_lat'] );
                        update_post_meta($id_post, 'map_lng', $_REQUEST['map_lng'] );
                        update_post_meta($id_post, 'map_zoom', $_REQUEST['map_zoom'] );

                        update_post_meta($id_post, 'check_in', $_REQUEST['check_in'] );
                        update_post_meta($id_post, 'check_out', $_REQUEST['check_out'] );
                        update_post_meta($id_post, 'activity-time', $_REQUEST['activity-time'] );
                        update_post_meta($id_post, 'duration', $_REQUEST['duration'] );
                        update_post_meta($id_post, 'venue-facilities', $_REQUEST['venue-facilities'] );

                        update_post_meta($id_post, 'price', $_REQUEST['price'] );
                        update_post_meta($id_post, 'discount', $_REQUEST['discount'] );

                        if($_REQUEST['best-price-guarantee']){
                            update_post_meta($id_post, 'best-price-guarantee', 'on' );
                        }else{
                            update_post_meta($id_post, 'best-price-guarantee', 'off' );
                        }
                        update_post_meta($id_post, 'best-price-guarantee-text', $_REQUEST['best-price-guarantee-text'] );
                        update_post_meta($id_post, 'rate_review','1' );
                        self::$msg = array(
                            'status'=>'success',
                            'msg'=>__('Create Activity successfully !',ST_TEXTDOMAIN)
                        );
                    }else{
                        self::$msg = array(
                            'status'=>'danger',
                            'msg'=>__('Error : Create Activity not successfully !',ST_TEXTDOMAIN)
                        );
                    }

                }
            }
        }

        /* Cars */
        function st_insert_post_type_cars(){
            if(!empty($_REQUEST['btn_insert_post_type_cars'])){
                if(wp_verify_nonce( $_REQUEST['st_insert_post_cars'] , 'user_setting' )) {
                    if(st()->get_option('partner_post_must_by_admin')=='on'){
                        $post_status = 'draft';
                    }else{
                        $post_status = 'publish';
                    }
                    $current_user = wp_get_current_user();
                    $title = $_REQUEST['title'];
                    $st_content = $_REQUEST['st_content'];
                    $my_post = array(
                        'post_title' => $title,
                        'post_content' => $st_content,
                        'post_status' => $post_status,
                        'post_author' => $current_user->ID,
                        'post_type' => 'st_cars',
                        'post_excerpt' => $_REQUEST['desc']
                    );
                    $id_post = wp_insert_post($my_post);
                    if(!empty($id_post)){
                        $featured_image = $_FILES['featured-image'];
                        // set featured_image
                        $id_featured_image = self::upload_image_return($featured_image,'featured-image',$featured_image['type']);
                        set_post_thumbnail( $id_post, $id_featured_image );
                        // metabox

                        $logo = $_FILES['logo'];
                        $id_logo = self::upload_image_return($logo,'logo',$logo['type']);
                        update_post_meta($id_post, 'logo', $id_logo );

                        update_post_meta($id_post, 'cars_name',  $_REQUEST['st_name'] );
                        update_post_meta($id_post, 'cars_email',  $_REQUEST['email'] );
                        update_post_meta($id_post, 'cars_phone',  $_REQUEST['phone'] );
                        update_post_meta($id_post, 'cars_about',  $_REQUEST['about'] );
                        update_post_meta($id_post, 'video',  $_REQUEST['video'] );

                        update_post_meta($id_post, 'id_location', $_REQUEST['id_location'] );
                        update_post_meta($id_post, 'cars_address', $_REQUEST['address'] );

                        update_post_meta($id_post, 'cars_price', $_REQUEST['price'] );
                        update_post_meta($id_post, 'discount', $_REQUEST['discount'] );

                        if(!empty($_REQUEST['equipment_item_title'])){
                            $equipment = array();
                            $equipment_item_title = $_REQUEST['equipment_item_title'];
                            $equipment_item_price = $_REQUEST['equipment_item_price'];
                            if(!empty($equipment_item_title)){
                                foreach($equipment_item_title as $k=>$v){
                                    array_push($equipment,array(
                                        'title'=>$v,
                                        'cars_equipment_list_price'=>$equipment_item_price[$k]
                                    ));
                                }
                            }
                            update_post_meta($id_post, 'cars_equipment_list', $equipment );
                        }
                        if(!empty($_REQUEST['taxonomy'])){
                            $taxonomy = $_REQUEST['taxonomy'];
                            $term_info = $_REQUEST['taxonomy_info'];
                            $features = array();
                            if(!empty($taxonomy)){
                                foreach($taxonomy as $k=>$v){
                                    $tmp = explode(",",$v);
                                    $term = get_term($tmp[0] , $tmp[1]);
                                    array_push($features,array(
                                        'title'=>$term->name,
                                        'cars_equipment_taxonomy_id'=>$term->term_taxonomy_id,
                                        'cars_equipment_taxonomy_info'=>$term_info[$k]
                                    ));
                                    $ids = array();
                                    $term_up = get_the_terms($id_post, $tmp[1]);
                                    if(!empty($term_up)){
                                        foreach($term_up as $key => $value){
                                            array_push($ids,$value->term_id);
                                        }
                                    }
                                    array_push($ids,$term->term_taxonomy_id);
                                    wp_set_post_terms( $id_post, $ids , $tmp[1]  );
                                }
                            }
                            update_post_meta($id_post, 'cars_equipment_info', $features );
                        }
                        self::$msg = array(
                            'status'=>'success',
                            'msg'=>__('Create Cars successfully !',ST_TEXTDOMAIN)
                        );
                    }else{
                        self::$msg = array(
                            'status'=>'danger',
                            'msg'=>__('Error : Create Cars not successfully !',ST_TEXTDOMAIN)
                        );
                    }

                }
            }
        }

        /* Rental */

        function st_insert_post_type_rental(){
            if(!empty($_REQUEST['btn_insert_post_type_rental'])){
                if(wp_verify_nonce( $_REQUEST['st_insert_post_rental'] , 'user_setting' )) {
                    if(st()->get_option('partner_post_must_by_admin')=='on'){
                        $post_status = 'draft';
                    }else{
                        $post_status = 'publish';
                    }
                    $current_user = wp_get_current_user();
                    $title = $_REQUEST['title'];
                    $st_content = $_REQUEST['st_content'];
                    $desc = $_REQUEST['desc'];
                    $my_post = array(
                        'post_title' => $title,
                        'post_content' => $st_content,
                        'post_status' => $post_status,
                        'post_author' => $current_user->ID,
                        'post_type' => 'st_rental',
                        'post_excerpt' => $desc
                    );
                    $id_post = wp_insert_post($my_post);
                    if(!empty($id_post)){
                        $featured_image = $_FILES['featured-image'];
                        // set featured_image
                        $id_featured_image = self::upload_image_return($featured_image,'featured-image',$featured_image['type']);
                        set_post_thumbnail( $id_post, $id_featured_image );

                        // gallery
                        $gallery = $_FILES['gallery'];
                        if(!empty($gallery)){
                            $tmp_array=array();
                            for( $i=0 ; $i <count($gallery['name']) ; $i++  ){
                                array_push($tmp_array,array(
                                    'name'    =>$gallery['name'][$i],
                                    'type'    =>$gallery['type'][$i],
                                    'tmp_name'=>$gallery['tmp_name'][$i],
                                    'error'   =>$gallery['error'][$i],
                                    'size'    =>$gallery['size'][$i]
                                ));
                            }
                        }
                        $id_gallery='';
                        foreach($tmp_array as $k=>$v){
                            $_FILES['gallery'] = $v;
                            $id_gallery .= self::upload_image_return($_FILES['gallery'],'gallery',$_FILES['gallery']['type']).',';
                        }
                        $id_gallery = substr($id_gallery,0,-1);
                        update_post_meta($id_post, 'gallery', $id_gallery );

                        update_post_meta($id_post, 'location_id', $_REQUEST['id_location'] );
                        update_post_meta($id_post, 'address', $_REQUEST['address'] );
                        update_post_meta($id_post, 'agent_email',  $_REQUEST['email'] );
                        update_post_meta($id_post, 'agent_website', $_REQUEST['website'] );
                        update_post_meta($id_post, 'agent_phone', $_REQUEST['phone'] );

                        update_post_meta($id_post, 'video', $_REQUEST['video'] );
                        update_post_meta($id_post, 'map_lat', $_REQUEST['map_lat'] );
                        update_post_meta($id_post, 'map_lng', $_REQUEST['map_lng'] );
                        update_post_meta($id_post, 'map_zoom', $_REQUEST['map_zoom'] );

                        update_post_meta($id_post, 'price', $_REQUEST['price'] );
                        update_post_meta($id_post, 'discount_rate', $_REQUEST['discount'] );

                        if(!empty($_REQUEST['features_title'])){
                            $features_title = $_REQUEST['features_title'];
                            $features_number = $_REQUEST['features_number'];
                            $features_icon = $_REQUEST['features_icon'];
                            $features = array();
                            foreach($features_title as $k=>$v){
                                array_push($features,array(
                                    'title'=>$v,
                                    'number'=>$features_number[$k],
                                    'icon'=>$features_icon[$k],
                                ));
                            }
                            update_post_meta($id_post, 'fetures', $features );
                        }
                        update_post_meta($id_post, 'rate_review','1' );

                        if(!empty($_REQUEST['taxonomy'])){
                            $taxonomy = $_REQUEST['taxonomy'];
                            if(!empty($taxonomy)){
                                foreach($taxonomy as $k=>$v){
                                    $tmp = explode(",",$v);
                                    $term = get_term($tmp[0] , $tmp[1]);
                                    $ids = array();
                                    $term_up = get_the_terms($id_post, $tmp[1]);
                                    if(!empty($term_up)){
                                        foreach($term_up as $key => $value){
                                            array_push($ids,$value->term_id);
                                        }
                                    }
                                    array_push($ids,$term->term_taxonomy_id);
                                    wp_set_post_terms( $id_post, $ids , $tmp[1]  );
                                }
                            }
                        }
                        self::$msg = array(
                            'status'=>'success',
                            'msg'=>__('Create Rental successfully !',ST_TEXTDOMAIN)
                        );
                    }else{
                        self::$msg = array(
                            'status'=>'danger',
                            'msg'=>__('Error : Create Rental not successfully !',ST_TEXTDOMAIN)
                        );
                    }

                }
            }
        }

        /* Cruise */

        function st_insert_post_type_cruise(){
            if(!empty($_REQUEST['btn_insert_post_type_cruise'])){
                if(wp_verify_nonce( $_REQUEST['st_insert_post_cruise'] , 'user_setting' )) {
                    if(st()->get_option('partner_post_must_by_admin')=='on'){
                        $post_status = 'draft';
                    }else{
                        $post_status = 'publish';
                    }
                    $current_user = wp_get_current_user();
                    $title = $_REQUEST['title'];
                    $st_content = $_REQUEST['st_content'];
                    $desc = $_REQUEST['desc'];

                    $my_post = array(
                        'post_title' => $title,
                        'post_content' => $st_content,
                        'post_status' => $post_status,
                        'post_author' => $current_user->ID,
                        'post_type' => 'cruise',
                        'post_excerpt' => $desc
                    );
                    $id_post = wp_insert_post($my_post);
                    if(!empty($id_post)){
                        $featured_image = $_FILES['featured-image'];
                        // set featured_image
                        $id_featured_image = self::upload_image_return($featured_image,'featured-image',$featured_image['type']);
                        set_post_thumbnail( $id_post, $id_featured_image );

                        // gallery
                        $gallery = $_FILES['gallery'];
                        if(!empty($gallery)){
                            $tmp_array=array();
                            for( $i=0 ; $i <count($gallery['name']) ; $i++  ){
                                array_push($tmp_array,array(
                                    'name'    =>$gallery['name'][$i],
                                    'type'    =>$gallery['type'][$i],
                                    'tmp_name'=>$gallery['tmp_name'][$i],
                                    'error'   =>$gallery['error'][$i],
                                    'size'    =>$gallery['size'][$i]
                                ));
                            }
                        }
                        $id_gallery='';
                        foreach($tmp_array as $k=>$v){
                            $_FILES['gallery'] = $v;
                            $id_gallery .= self::upload_image_return($_FILES['gallery'],'gallery',$_FILES['gallery']['type']).',';
                        }
                        $id_gallery = substr($id_gallery,0,-1);
                        update_post_meta($id_post, 'gallery', $id_gallery );
                        update_post_meta($id_post, 'video', $_REQUEST['video'] );

                        if(!empty($_REQUEST['program_title'])){
                            $program_title = $_REQUEST['program_title'];
                            $program_desc  = $_REQUEST['program_desc'];
                            $program =array();
                            if(!empty($program_title)){
                                foreach($program_title as $k=>$v){
                                    array_push($program,array(
                                        'title'=>$v,
                                        'desc'=>$program_desc[$k]
                                    ));
                                }
                            }
                            update_post_meta($id_post, 'programes',$program );
                        }


                        update_post_meta($id_post, 'location_id', $_REQUEST['id_location'] );
                        update_post_meta($id_post, 'address', $_REQUEST['address'] );
                        update_post_meta($id_post, 'map_lat', $_REQUEST['map_lat'] );
                        update_post_meta($id_post, 'map_lng', $_REQUEST['map_lng'] );
                        update_post_meta($id_post, 'map_zoom', $_REQUEST['map_zoom'] );

                        update_post_meta($id_post, 'email',  $_REQUEST['email'] );
                        update_post_meta($id_post, 'website', $_REQUEST['website'] );
                        update_post_meta($id_post, 'phone', $_REQUEST['phone'] );
                        update_post_meta($id_post, 'fax', $_REQUEST['fax'] );
                        update_post_meta($id_post, 'st_children_free', $_REQUEST['st_children_free'] );




                        update_post_meta($id_post, 'rate_review','1' );

                        if(!empty($_REQUEST['taxonomy'])){
                            $taxonomy = $_REQUEST['taxonomy'];
                            if(!empty($taxonomy)){
                                foreach($taxonomy as $k=>$v){
                                    $tmp = explode(",",$v);
                                    $term = get_term($tmp[0] , $tmp[1]);
                                    $ids = array();
                                    $term_up = get_the_terms($id_post, $tmp[1]);
                                    if(!empty($term_up)){
                                        foreach($term_up as $key => $value){
                                            array_push($ids,$value->term_id);
                                        }
                                    }
                                    array_push($ids,$term->term_taxonomy_id);
                                    wp_set_post_terms( $id_post, $ids , $tmp[1]  );
                                }
                            }
                        }
                        self::$msg = array(
                            'status'=>'success',
                            'msg'=>__('Create Cruise successfully !',ST_TEXTDOMAIN)
                        );
                    }else{
                        self::$msg = array(
                            'status'=>'danger',
                            'msg'=>__('Error : Create Cruise not successfully !',ST_TEXTDOMAIN)
                        );
                    }

                }
            }
        }

        /* Cruise cabin */

        function st_insert_post_type_cruise_cabin(){
            if(!empty($_REQUEST['btn_insert_cruise_cabin'])){
                if(wp_verify_nonce( $_REQUEST['st_insert_cabin'] , 'user_setting' )) {
                    if(st()->get_option('partner_post_must_by_admin')=='on'){
                        $post_status = 'draft';
                    }else{
                        $post_status = 'publish';
                    }
                    $current_user = wp_get_current_user();
                    $title = $_REQUEST['title'];
                    $st_content = $_REQUEST['st_content'];
                    $desc = $_REQUEST['desc'];

                    $my_post = array(
                        'post_title' => $title,
                        'post_content' => $st_content,
                        'post_status' => $post_status,
                        'post_author' => $current_user->ID,
                        'post_type' => 'cruise_cabin',
                        'post_excerpt' => $desc
                    );
                    $id_post = wp_insert_post($my_post);
                    wp_set_post_terms( $id_post,  $_REQUEST['id_category'] , 'cabin_type'  );

                    if(!empty($id_post)){
                        $featured_image = $_FILES['featured-image'];
                        // set featured_image
                        $id_featured_image = self::upload_image_return($featured_image,'featured-image',$featured_image['type']);
                        set_post_thumbnail( $id_post, $id_featured_image );




                        update_post_meta($id_post, 'cruise_id', $_REQUEST['cruise_id'] );
                        update_post_meta($id_post, 'max_adult', $_REQUEST['max_adult'] );
                        update_post_meta($id_post, 'max_children', $_REQUEST['max_children'] );
                        update_post_meta($id_post, 'bed_size', $_REQUEST['bed_size'] );
                        update_post_meta($id_post, 'cabin_size', $_REQUEST['cabin_size'] );

                        update_post_meta($id_post, 'price', $_REQUEST['price'] );
                        update_post_meta($id_post, 'discount_rate', $_REQUEST['discount'] );

                        if(!empty($_REQUEST['taxonomy'])){
                            $taxonomy = $_REQUEST['taxonomy'];
                            if(!empty($taxonomy)){
                                foreach($taxonomy as $k=>$v){
                                    $tmp = explode(",",$v);
                                    $term = get_term($tmp[0] , $tmp[1]);
                                    $ids = array();
                                    $term_up = get_the_terms($id_post, $tmp[1]);
                                    if(!empty($term_up)){
                                        foreach($term_up as $key => $value){
                                            array_push($ids,$value->term_id);
                                        }
                                    }
                                    array_push($ids,$term->term_taxonomy_id);
                                    wp_set_post_terms( $id_post, $ids , $tmp[1]  );
                                }
                            }
                        }

                        if(!empty($_REQUEST['features_title'])){
                            $features_title = $_REQUEST['features_title'];
                            $features_number = $_REQUEST['features_number'];
                            $features_icon = $_REQUEST['features_icon'];
                            $features = array();
                            foreach($features_title as $k=>$v){
                                array_push($features,array(
                                    'title'=>$v,
                                    'number'=>$features_number[$k],
                                    'icon'=>$features_icon[$k],
                                ));
                            }
                            update_post_meta($id_post, 'fetures', $features );
                        }

                        self::$msg = array(
                            'status'=>'success',
                            'msg'=>__('Create cruise cabin successfully !',ST_TEXTDOMAIN)
                        );
                    }else{
                        self::$msg = array(
                            'status'=>'danger',
                            'msg'=>__('Error : Create cruise cabin not successfully !',ST_TEXTDOMAIN)
                        );
                    }

                }
            }
        }
        /* book history */

        function get_book_history(){
            global $current_user;
            get_currentuserinfo();
            $user_id = $current_user->ID;

            $paged = 1;
            if(!empty($_REQUEST['paged'])){
                $paged = $_REQUEST['paged'];
            }


            // get list id order
            $arg = array(
                'post_type'=>'st_order',
                'paged'=>$paged,
                'post_author' => $user_id,
                'post_status' => array('publish'),
                'posts_per_page'=>'10'
            );

            query_posts($arg);
            $html='';
            while(have_posts()){
                the_post();
                $id_item = get_post_meta(get_the_ID(),'item_id',true);
                $check_in = get_post_meta(get_the_ID(),'check_in',true);
                $check_out = get_post_meta(get_the_ID(),'check_out',true);
                $total_price = get_post_meta(get_the_ID(),'item_price',true);

                $comment_post_id=apply_filters('st_real_comment_post_id',$id_item);
                $action='';
                if(STReview::check_reviewable($comment_post_id))
                {
                    $user_url=st()->get_option('page_my_account_dashboard');

                    $data['sc']='write_review';
                    $data['item_id']=$id_item;
                    $action='<a href="'.st_get_link_with_search(get_permalink($user_url),array('sc','item_id'),$data).'">'.st_get_language('user_write_review').'</a>';

                }
                $icon_type=$this->get_icon_type_order_item( $id_item );
                if(!empty($icon_type)){
                    $html .='
                    <tr>
                        <td class="booking-history-type">
                           '.$this->get_icon_type_order_item( $id_item ).'
                        </td>
                        <td class="booking-history-title"> <a href="'.$this->get_link_order_item($id_item).'">'.$this->get_title_order_item($id_item).'</a></td>
                        <td>'.$this->get_location_order_item($id_item).'</td>
                        <td>'.get_the_date().'</td>
                        <td>'.mysql2date('m/d/y',$check_in).' <i class="fa fa-long-arrow-right"></i> '.mysql2date('m/d/y',$check_out).'</td>
                        <td>'.TravelHelper::format_money($total_price).'</td>
                        <td>'.$action.'</td>
                    </tr>';
                }
            }
            wp_reset_query();

            if(!empty($_REQUEST['show'])){
                if(!empty($html))
                    $status = 'true';
                else
                    $status = 'false';

                echo json_encode(array(
                    'html'=>$html,
                    'data_per'=>$paged+1,
                    'status'=>$status
                ));
                die();
            }else{
                return $html;
            }
        }
        function get_location_order_item( $id_item){
            $post_type =  get_post_type( $id_item );
            switch($post_type){
                case "st_hotel":
                    $id_location = get_post_meta( $id_item ,'id_location' , true );
                    $location=get_the_title($id_location);
                    break;
                case "cruise_cabin":
                    $id_cruise = get_post_meta( $id_item ,'cruise_id',true);
                    $id_location = get_post_meta( $id_cruise ,'location_id' , true );
                    $location=get_the_title($id_location);
                    break;
                case "st_tours":
                    $id_location = get_post_meta( $id_item ,'id_location' , true );
                    $location=get_the_title($id_location);
                    break;
                case "st_cars":
                    $id_location = get_post_meta( $id_item ,'id_location' , true );
                    $location=get_the_title($id_location);
                    break;
                case "st_rental":
                    $id_location = get_post_meta( $id_item ,'location_id' , true );
                    $location=get_the_title($id_location);
                    break;
                case "st_activity":
                    $id_location = get_post_meta( $id_item ,'id_location' , true );
                    $location=get_the_title($id_location);
                    break;
                default :
                    $location='';
            }
            return $location;
        }
        function get_link_order_item( $id_item){
            $post_type =  get_post_type( $id_item );
            switch($post_type){
                case "st_hotel":
                    $title=get_the_permalink($id_item);
                    break;
                case "cruise_cabin":
                    $id_cruise = get_post_meta( $id_item ,'cruise_id',true);
                    $title=get_the_permalink($id_cruise);
                    break;
                case "st_tours":
                    $title=get_the_permalink($id_item);
                    break;
                case "st_cars":
                    $title=get_the_permalink($id_item);
                    break;
                case "st_rental":
                    $title=get_the_permalink($id_item);
                    break;
                case "st_activity":
                    $title=get_the_permalink($id_item);
                    break;
                default :
                    $title='';
            }
            return $title;
        }
        function get_title_order_item( $id_item){
            $post_type =  get_post_type( $id_item );
            switch($post_type){
                case "st_hotel":
                    $title=get_the_title($id_item);
                    break;
                case "cruise_cabin":
                    $id_cruise = get_post_meta( $id_item ,'cruise_id',true);
                    $title=get_the_title($id_cruise);
                    break;
                case "st_tours":
                    $title=get_the_title($id_item);
                    break;
                case "st_cars":
                    $title=get_the_title($id_item);
                    break;
                case "st_rental":
                    $title=get_the_title($id_item);
                    break;
                case "st_activity":
                    $title=get_the_title($id_item);
                    break;
                default :
                    $title='';
            }
            return $title;
        }
        function get_icon_type_order_item( $id_item ){
            $post_type =  get_post_type( $id_item );
            switch($post_type){
                case "st_hotel":
                    $html='<i class="fa fa-building-o"></i><small>'.__("hotel",ST_TEXTDOMAIN).'</small>';
                    break;
                case "st_tours":
                    $html='<i class="fa fa-bolt"></i><small>'.__('activity',ST_TEXTDOMAIN).'</small>';
                    break;
                case "st_cars":
                    $html='<i class="fa fa-dashboard"></i><small>'.__("car",ST_TEXTDOMAIN).'</small>';
                    break;
                case "st_rental":
                    $html='<i class="fa fa-home"></i><small>'.__("rental",ST_TEXTDOMAIN).'</small>';
                    break;
                case "st_activity":
                    $html='<i class="fa fa-bolt"></i><small>'.__("activity",ST_TEXTDOMAIN).'</small>';
                    break;
                case "cruise_cabin":
                    $html='<i class="fa fa-bolt"></i><small>'.__("cruise",ST_TEXTDOMAIN).'</small>';
                    break;
                default :
                    $html='';
            }
            return $html;
        }
        static function check_lever_partner( $lever ){
            switch($lever) {
                case "subscriber":
                    $dk = false;
                    break;
                case "contributor":
                    $dk = false;
                    break;
                case "author":
                    $dk = false;
                    break;
                case "editor":
                    $dk = false;
                    break;
                case "partner":
                    $dk = true;
                    break;
                case "administrator":
                    $dk = true;
                    break;
                default :
                    $dk = false;
            }
            return $dk;
        }

        function st_write_review()
        {
            if(STInput::request('write_review')){
                if(!STInput::request('item_id'))
                {
                    $user_url=st()->get_option('page_my_account_dashboard');
                    if($user_url){
                        wp_safe_redirect(get_permalink($user_url));
                    }else{
                        wp_safe_redirect(home_url());
                    }
                    die;
                    //wp_safe_redirect();
                }else{
                    if(!get_post_status(STInput::request('item_id')))
                    {
                        $user_url=st()->get_option('page_my_account_dashboard');
                        if($user_url){
                            wp_safe_redirect(get_permalink($user_url));
                        }else{
                            wp_safe_redirect(home_url());
                        }
                        die;
                    }
                }
            }


            if(STInput::post() and STInput::post('comment_post_ID') and STInput::post('_wp_unfiltered_html_comment')){
                if(wp_verify_nonce(STInput::post('st_user_write_review') , 'st_user_settings' )){
                    global $current_user;
                    $comment_data['comment_post_ID']=STInput::post('comment_post_ID');
                    $comment_data['comment_author']=$current_user->data->user_nicename;
                    $comment_data['comment_author_email']=$current_user->data->user_email;
                    $comment_data['comment_content']=STInput::post('comment');
                    $comment_data['comment_type']='st_reviews';
                    $comment_data['user_id']=$current_user->ID;

                    if(STReview::check_reviewable(STInput::post('comment_post_ID')))
                    {
                        $comment_id = wp_new_comment($comment_data);

                        if($comment_id){
                            update_comment_meta($comment_id,'comment_title',STInput::post('comment_title'));
                            if(STInput::post('comment_rate'))
                                update_comment_meta($comment_id,'comment_rate',STInput::post('comment_rate'));
                        }

                        wp_safe_redirect(get_permalink(STInput::post('comment_post_ID')));
                        die;
                    }

                }
            }
        }



        static function get_icon_wishlist(){
            $current_user = wp_get_current_user();
            $data_list = get_user_meta( $current_user->ID , 'st_wishlist' , true);
            $data_list = json_decode($data_list);

            if($data_list !='' and is_array($data_list)){
                $check = false;
                foreach($data_list as $k => $v){
                    if($v->id == get_the_ID() and $v->type == get_post_type(get_the_ID())){
                        $check = true;
                    }
                }
                if($check == true){
                    return array('original-title'=>st_get_language('remove_to_wishlist'),'icon'=>'<i class="fa fa-heart"></i>');
                }else{
                    return array('original-title'=>st_get_language('add_to_wishlist'),'icon'=>'<i class="fa fa-heart-o"></i>');
                }
            }else{
                return  array('original-title'=>st_get_language('add_to_wishlist'),'icon'=>'<i class="fa fa-heart-o"></i>');
            }
        }

        static function get_title_account_setting()
        {
            if(!empty($_REQUEST['sc'])){
                $type = $_REQUEST['sc'];
                switch($type){
                    case "setting":
                        st_the_language('user_settings');
                        break;
                    case "photos":
                        st_the_language('user_my_travel_photos');
                        break;
                    case "booking-history":
                        st_the_language('user_booking_history');
                        break;
                    case "wishlist":
                        st_the_language('user_wishlist');
                        break;
                    case "create-hotel":
                        st_the_language('user_create_hotel') ;
                        break;
                    case "my-hotel":
                        st_the_language('user_my_hotel');
                        break;
                    case "create-room":
                        st_the_language('user_create_room');
                        break;
                    case "my-room":
                        st_the_language('user_my_room');
                        break;
                    case "create-tours":
                        st_the_language('user_create_tour') ;
                        break;
                    case "my-tours":
                        st_the_language('user_my_tour');
                        break;
                    case "create-activity":
                        st_the_language('user_create_activity') ;
                        break;
                    case "my-activity":
                        st_the_language('user_my_activity');
                        break;
                    case "create-cars":
                        st_the_language('user_create_car');
                        break;
                    case "my-cars":
                        st_the_language('user_my_car');
                        break;
                    case "create-rental":
                        st_the_language('user_create_rental');
                        break;
                    case "my-rental":
                        st_the_language('user_my_rental');
                        break;
                    case "create-cruise":
                        st_the_language('user_create_cruise');
                        break;
                    case "my-cruise":
                        st_the_language('user_my_cruise');
                        break;
                    case "create-cruise-cabin":
                        st_the_language('user_create_cruise_cabin');
                        break;
                    case "my-cruise-cabin":
                        st_the_language('user_my_cruise_cabin');
                        break;
                    case "setting-info":
                        st_the_language('user_setting_info');
                        break;
                    case "write-review":
                        st_the_language('user_write_review');
                        break;
                }
            }else if(!empty($_REQUEST['id_user'])){
                st_the_language('user_setting_info');
            }else{
                st_the_language('user_settings');
            }
        }
        static function get_info_total_traveled(){
            global $current_user;
            get_currentuserinfo();
            $user_id = $current_user->ID;
            $query = array(
                'post_type'      => 'st_order',
                'post_status'    => array('publish'),
                'posts_per_page' => -1,
                'meta_key'       => 'id_user',
                'meta_value'     => $user_id
            );
            $data = array(
                'st_hotel'    => 0,
                'st_rental'   => 0,
                'st_cars'     => 0,
                'st_activity' => 0,
                'st_tours'    => 0,
                'address'     => array('paris')
            );
            query_posts($query);
            $list_address = array();
            while (have_posts()) {
                the_post();
                $item_id = get_post_meta(get_the_ID(), 'item_id', true);
                $post_type = get_post_type($item_id);
                if (!empty($post_type) and isset($data[$post_type])) {
                    $number = $data[$post_type];
                    $number = $number + 1;
                    $data[$post_type] = $number;

                    if ($post_type == 'st_cars') {
                        $address = get_post_meta($item_id, 'cars_address', true);
                    } else {
                        $address = get_post_meta($item_id, 'address', true);
                    }
                    $list_address[] = $address;
                }
            }
            $data['address'] = array_unique($list_address);
            wp_reset_query();

            return $data;

        }
    }
    $user = new STUser_f();
    $user->init();

}
