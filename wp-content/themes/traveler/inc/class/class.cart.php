<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STCart
 *
 * Created by ShineTheme
 *
 */

if(!class_exists('STCart'))
{
    /*
 * STCart class, handling cart action, included saving order and sending e-mail after booking
 *
 * */
    class STCart
    {
        static $coupon_error;
        /*
         * Init Session and register ajax action
         *
         * */
        static function init()
        {

            if(!session_id())
            {
                session_start();
            }

            //Checkout Fields
            st()->load_libs(
                array(
                    'helpers/st_checkout_fields'
                )
            );

            add_action('wp_ajax_booking_form_submit',array(__CLASS__,'ajax_submit_form'));
            add_action('wp_ajax_nopriv_booking_form_submit',array(__CLASS__,'ajax_submit_form'));

            add_action('st_booking_success',array(__CLASS__,'send_mail_after_booking'));
            add_action('st_booking_submit_form_success',array(__CLASS__,'send_email_confirm'));

            add_action('init',array(__CLASS__,'_confirm_order'));

            add_action('init',array(__CLASS__,'_apply_coupon'));
            add_action('init',array(__CLASS__,'_remove_coupon'));



            if(STInput::post())
            {
                add_action('init',array(__CLASS__,'_handle_form_submit'),1);

            }


        }
        static function _handle_form_submit()
        {

            if(!st_is_ajax())
            {
                $result=self::booking_form_submit();
                if(isset($result['status']) and  !$result['status'])
                {
                    STTemplate::set_message($result['message'],'danger');
                }

                if(isset($result['redirect']) and $result['redirect'])
                {
                    //var_dump($result['redirect']);
                    //header("Location: ".$result['redirect']);

                    wp_redirect($result['redirect']);
                    die;
                }
            }

        }

        static function _confirm_order()
        {
            if(STInput::get('st_action')=='confirm_order' and STInput::get('hash'))
            {
                $hash=STInput::get('hash');

                $query=new WP_Query(array(
                    'post_type'         =>'st_order',
                    'posts_per_page'    =>1,
                    'meta_key'          =>'order_confirm_hash',
                    'meta_value'        =>$hash
                ));

                $status=false;
                $message=false;
                $order_id=false;
                $order_confirm_page=st()->get_option('page_order_confirm');

                while($query->have_posts()){
                    $query->the_post();
                    $order_id=get_the_ID();

                    $status=get_post_meta($order_id,'status',true);

                    if($status=='pending'){
                        update_post_meta(get_the_ID(),'status','complete');
                        $status=true;
                        $message=__('Thank you. Your order is confirmed',ST_TEXTDOMAIN);
                    }elseif($status=='complete'){
                        $status=false;
                        $message=__('Your order is confirmed already.',ST_TEXTDOMAIN);
                    }else{

                        $status=false;
                        $message=__('Sorry. We cannot recognize your order code!',ST_TEXTDOMAIN);
                    }
                    break;
                }

                wp_reset_query();

                if($status){
                    STTemplate::set_message($message,'success');
                }else{
                    STTemplate::set_message($message,'danger');
                }

                if($order_confirm_page )
                {
                    $order_confirm_page_link=get_permalink($order_confirm_page);

                    if($order_confirm_page_link)
                        wp_redirect($order_confirm_page_link); die;
                }

                echo balanceTags($message); die;

            }
        }


        static function set_html_content_type() {

            return 'text/html';
        }

        static function send_mail_after_booking($order_id=false)
        {
            if(!$order_id) return;

            $email_to_custommer=st()->get_option('enable_email_for_custommer','on');
            $email_to_admin=st()->get_option('enable_email_for_admin','on');
            $email_to_owner=st()->get_option('enable_email_for_owner_item','on');

            // Send Email to Custommer
            if($email_to_custommer=='on')
            {
                self::_send_custommer_booking_email($order_id);
            }

            // Send booking email to admin
            if($email_to_admin=='on')
            {
                self::_send_admin_booking_email($order_id);
            }


            // Send Booking Email to Owner Item
            if($email_to_owner=='on')
            {
                self::_send_owner_booking_email($order_id);
            }

        }

        static function _send_custommer_booking_email($order_id)
        {


            $to=get_post_meta($order_id,'st_email',true);
            $subject=st()->get_option('email_subject',__('Booking Confirm - '.get_bloginfo('title'),ST_TEXTDOMAIN));


            $subject=sprintf(__('Your booking at %s',ST_TEXTDOMAIN),get_bloginfo('title'));


            //while($query->have_posts()){
            //$query->the_post();

            $item_id=get_post_meta($order_id,'item_id',true);

            $check_in=get_post_meta($order_id,'check_in',true);
            $check_out=get_post_meta($order_id,'check_out',true);

            $date_check_in=@date(get_option('date_format'),strtotime($check_in));
            $date_check_out=@date(get_option('date_format'),strtotime($check_out));

            if($item_id){
                switch(get_post_type($item_id)){
                    case "st_hotel":
                        $hotel_id=$item_id;
                        if($hotel_title=get_the_title($hotel_id))
                        {
                            $subject=sprintf(__('Your booking at %s: %s - %s',ST_TEXTDOMAIN),$hotel_title,$date_check_in,$date_check_out);
                        }
                        $message=st()->load_template('email/booking_infomation',null,array('order_id'=>$order_id));
                        break;
                    case "st_cars":

                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('Your booking at %s: %s - %s',ST_TEXTDOMAIN),$title,$date_check_in,$date_check_out);
                        }
                        $message=st()->load_template('email/booking_infomation_cars',null,array('order_id'=>$order_id));
                        break;
                    case "st_activity":
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('Your booking at %s: %s - %s',ST_TEXTDOMAIN),$title,$date_check_in,$date_check_out);
                        }
                        $message=st()->load_template('email/booking_infomation_activity',null,array('order_id'=>$order_id));
                        break;
                    case "st_tours":
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('Your booking at %s',ST_TEXTDOMAIN),$title);
                        }
                        $message=st()->load_template('email/booking_infomation_tours',null,array('order_id'=>$order_id));
                        break;
                    case "st_rental":
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('Your booking at %s',ST_TEXTDOMAIN),$title);
                        }
                        $message=st()->load_template('email/booking_infomation_rental',null,array('order_id'=>$order_id));
                        break;

                    default :
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('Your booking for %s: %s - %s',ST_TEXTDOMAIN),$title,$date_check_in,$date_check_out);
                        }
                        break;

                }

                wp_reset_query();

                $check=self::_send_mail($to,$subject,$message);
            }
            //}


            return $check;

        }

        static function _send_admin_booking_email($order_id)
        {
            $admin_email=st()->get_option('email_admin_address');

            if(!$admin_email) return false;

            $to=$admin_email;

            $subject=sprintf(__('New Booking at %s',ST_TEXTDOMAIN),get_bloginfo('title'));


            //while($query->have_posts()){
            //$query->the_post();

            $item_id=get_post_meta($order_id,'item_id',true);

            $check_in=get_post_meta($order_id,'check_in',true);
            $check_out=get_post_meta($order_id,'check_out',true);

            $date_check_in=@date(get_option('date_format'),strtotime($check_in));
            $date_check_out=@date(get_option('date_format'),strtotime($check_out));

            if($item_id){
                switch(get_post_type($item_id)){
                    case "st_hotel":
                        $hotel_id=$item_id;
                        if($hotel_title=get_the_title($hotel_id))
                        {
                            $subject=sprintf(__('New Booking at %s: %s - %s',ST_TEXTDOMAIN),$hotel_title,$date_check_in,$date_check_out);
                        }
                        $message=st()->load_template('email/booking_infomation',null,array('order_id'=>$order_id,'send_to_admin'=>true));
                        break;
                    case "st_cars":

                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking at %s: %s - %s',ST_TEXTDOMAIN),$title,$date_check_in,$date_check_out);
                        }
                        $message=st()->load_template('email/booking_infomation_cars',null,array('order_id'=>$order_id,'send_to_admin'=>true));
                        break;
                    case "st_activity":
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking at %s: %s - %s',ST_TEXTDOMAIN),$title,$date_check_in,$date_check_out);
                        }
                        $message=st()->load_template('email/booking_infomation_activity',null,array('order_id'=>$order_id,'send_to_admin'=>true));
                        break;
                    case "st_tours":
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking at %s',ST_TEXTDOMAIN),$title);
                        }
                        $message=st()->load_template('email/booking_infomation_tours',null,array('order_id'=>$order_id,'send_to_admin'=>true));
                        break;
                    case "st_rental":
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking at %s',ST_TEXTDOMAIN),$title);
                        }
                        $message=st()->load_template('email/booking_infomation_rental',null,array('order_id'=>$order_id,'send_to_admin'=>true));
                        break;

                    default :
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking for %s: %s - %s',ST_TEXTDOMAIN),$title,$date_check_in,$date_check_out);
                        }
                        break;

                }

                wp_reset_query();

                $check=self::_send_mail($to,$subject,$message);
            }
            //}


            return $check;

        }

        static function _send_owner_booking_email($order_id)
        {
            $to=false;

            $subject=sprintf(__('New Booking at %s',ST_TEXTDOMAIN),get_bloginfo('title'));


            //while($query->have_posts()){
            //$query->the_post();

            $item_id=get_post_meta($order_id,'item_id',true);

            $check_in=get_post_meta($order_id,'check_in',true);
            $check_out=get_post_meta($order_id,'check_out',true);

            $date_check_in=@date(get_option('date_format'),strtotime($check_in));
            $date_check_out=@date(get_option('date_format'),strtotime($check_out));

            if($item_id){
                switch(get_post_type($item_id)){
                    case "st_hotel":
                        $hotel_id=$item_id;
                        if($hotel_title=get_the_title($hotel_id))
                        {
                            $subject=sprintf(__('New Booking at %s: %s - %s',ST_TEXTDOMAIN),$hotel_title,$date_check_in,$date_check_out);
                        }
                        $message=st()->load_template('email/booking_infomation',null,array('order_id'=>$order_id,'send_to_admin'=>true));

                        $to=STHotel::get_owner_email($item_id);
                        break;

                    case "st_cars":

                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking at %s: %s - %s',ST_TEXTDOMAIN),$title,$date_check_in,$date_check_out);
                        }
                        $message=st()->load_template('email/booking_infomation_cars',null,array('order_id'=>$order_id,'send_to_admin'=>true));
                        $to=STCars::get_owner_email($item_id);
                        break;
                    case "st_activity":
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking at %s: %s - %s',ST_TEXTDOMAIN),$title,$date_check_in,$date_check_out);
                        }
                        $message=st()->load_template('email/booking_infomation_activity',null,array('order_id'=>$order_id,'send_to_admin'=>true));
                        $to=STActivity::get_owner_email($item_id);
                        break;
                    case "st_tours":
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking at %s',ST_TEXTDOMAIN),$title);
                        }
                        $message=st()->load_template('email/booking_infomation_tours',null,array('order_id'=>$order_id,'send_to_admin'=>true));
                        $to=STTour::get_owner_email($item_id);
                        break;
                    case "st_rental":
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking at %s',ST_TEXTDOMAIN),$title);
                        }
                        $message=st()->load_template('email/booking_infomation_rental',null,array('order_id'=>$order_id,'send_to_admin'=>true));
                        $to=STRental::get_owner_email($item_id);
                        break;

                    default :
                        if($title=get_the_title($item_id))
                        {
                            $subject=sprintf(__('New Booking for %s: %s - %s',ST_TEXTDOMAIN),$title,$date_check_in,$date_check_out);
                        }
                        break;

                }

                wp_reset_query();

                if($to)
                {
                    $check=self::_send_mail($to,$subject,$message);

                }

            }
            //}


            return $check;
        }

        private static function  _send_mail($to,$subject,$message){
            $from=st()->get_option('email_from');
            $from_address=st()->get_option('email_from_address');
            $headers=array();

            if($from and $from_address){
                $headers[]='From:'. $from .'<'.$from_address.'>';
            }

            add_filter( 'wp_mail_content_type', array(__CLASS__,'set_html_content_type') );

            $check=wp_mail( $to, $subject, $message,$headers );

// Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
            remove_filter( 'wp_mail_content_type', array(__CLASS__,'set_html_content_type') );
            return array(
                'status'=>$check,
                'data'=>array(
                    'to'=>$to,
                    'subject'=>$subject,
                    'message'=>$message,
                    'headers'=>$headers
                )
            );
        }

        static function send_email_confirm($order_id=false)
        {
            if(!$order_id) return;

            $order_confirm_code=$random_hash = md5(uniqid(rand(), true));

            update_post_meta($order_id,'order_confirm_hash',$order_confirm_code);

            $confirm_link=home_url('?st_action=confirm_order&hash='.$order_confirm_code);

            $message=st()->load_template('email/email_confirm',null,array('order_id'=>$order_id,'confirm_link'=>$confirm_link));

            $to=get_post_meta($order_id,'st_email',true);

            $subject=__('Confirmation needed',ST_TEXTDOMAIN);

            self::_send_mail($to,$subject,$message);
        }

        static function add_cart($item_id,$number=1,$price=false,$data=array())
        {
            self::destroy_cart();
            $_SESSION['st_cart'][$item_id]=array(
                'number'=>$number,
                'price'=>$price,
                'data'=>$data
            );
        }

        static function get_carts(){
            return $_SESSION['st_cart'];
        }

        static function get_cart_item()
        {
            $items= isset($_SESSION['st_cart'])?$_SESSION['st_cart']:array();
            if(!empty($items) and is_array($items))
            {
                foreach($items as $key=>$value)
                {
                    return array('key'=>$key,'value'=>$value);
                }
            }
        }

        static function count(){
            return count($_SESSION['st_cart']);
        }

        static function check_cart()
        {
            $cart=isset($_SESSION['st_cart'])?$_SESSION['st_cart']:false;
            if(!$cart or empty($cart) or !is_array($cart)) return false;
            return true;
        }


        /**
         * return total value of cart (tax included) without format money
         *
         * @return float|int|mixed|void
         */
        static function get_total()
        {

            //Tax
            $total=self::get_total_with_out_tax();
            $total-=self::get_coupon_amount();
            $total+=self::get_tax_amount();

            $total=apply_filters('st_cart_total_value',$total);
            return $total;

        }

        /*
         * Return tax percent from theme options
         *
         * */
        static function get_tax(){
            if(self::is_tax_enable()){
                return (float)st()->get_option('tax_value',0);
            }
            return 0;
        }


        /*
         * return Tax amount value.
         *
         *
         * */
        static function get_tax_amount()
        {
            if(self::is_tax_enable()) {
                $tax = self::get_tax();
                $total = self::get_total_with_out_tax();

                $total -= self::get_coupon_amount();

                return ($total / 100) * $tax;
            }
            return 0;
        }

        /*
         * Check if tax is enabled from theme options
         *
         * @return bool
         *
         * */
        static function is_tax_enable()
        {
            if(st()->get_option('tax_enable','off')=='on') return true;
            return false;
        }

        /*
         * Get cart total amount with out tax
         *
         * */
        static function get_total_with_out_tax(){

            $cart=$_SESSION['st_cart'];
            if(!empty($cart)) {
                $total = 0;
                foreach ($cart as $key => $value) {
                    $post_type = get_post_type($key);
                    $data = $value['data'];
                    switch ($post_type) {
                        case "st_hotel":
                        case "st_rental":
                            $total += self::get_hotel_price($data, $value['price'], $value['number']);
                            break;
                        case "st_cars":
                            $total +=$data['price_total'];
                            break;
                        case "st_tours":
                            $total +=STTour::get_cart_item_total($key,$value);
                            break;
                        case "st_activity":
                            $total += $value['price'] * $value['number'];
                            break;
                    }
                }
                $total=apply_filters('st_cart_total_with_out_tax',$total);
                return $total;
            }
        }



        /**
         * Get total amount of each items in cart.
         * @param $item
         * @param $key
         * @return mixed
         */
        static function get_item_total($item,$key)
        {
            $data=$item['data'];
            $post_type = get_post_type($key);
            switch($post_type){
                case "st_hotel":
                case "st_rental":
                    return self::get_hotel_price($data,$item['price'],1);
                    break;
                case "st_cars":
                    return $item['price_total'];
                    break;
                case "st_tours":

                    return STTour::get_cart_item_total($key,$item);
                    break;
                case "st_activity":
                    return $item['price'];
                    break;
            }
        }

        /**
         *
         *
         * */
        static function  get_hotel_price($data,$price,$number=1)
        {
            $default=array(
                'check_in'=>false,
                'check_out'=>false
            );

            extract(wp_parse_args($data,$default));

            //Check datediff and price per date
            if($check_in and $check_out)
            {
                $datediff=STDate::date_diff(strtotime($check_in),strtotime($check_out));


                if($datediff>=1)
                {
                    return ($price)*$datediff*$number;
                }else{
                    return $price*$number;
                }

            }else{
                return $price*$number;
            }
        }

        /**
         * Return all items in cart
         * Current version only one item in cart at once time.
         * @return mixed
         *
         * */
        static function get_items()
        {
            return isset($_SESSION['st_cart'])?$_SESSION['st_cart']:array();
        }

        static function find_item($item_id)
        {
            $cart=$_SESSION['st_cart'];

            if(!empty($cart))
            {
                if(isset($cart[$item_id])) return $cart[$item_id];
            }
        }

        static function get_cart_link()
        {
            $cart_link= get_permalink(st()->get_option('page_checkout'));

            return apply_filters('st_cart_link',$cart_link);
        }
        static function get_success_link()
        {
            $payment_success= get_permalink(st()->get_option('page_payment_success'));

            return apply_filters('st_payment_success_link',$payment_success);
        }

        static function destroy_cart()
        {
            do_action('st_before_destroy_cart');

            unset($_SESSION['st_cart']);
            unset($_SESSION['st_cart_coupon']);

            do_action('st_after_destroy_cart');

        }

        static function use_coupon(){
            if(isset($_SESSION['st_cart_coupon']) and  $_SESSION['st_cart_coupon'])
            {
                return true;
            }else
            {
                return false;
            }
        }


        static function  booking_form_submit()
        {

            if(STInput::post('st_payment_gateway') and wp_verify_nonce(STInput::post('travel_order'),'submit_form_order'))
            {

                $payment_gateways=STInput::post('st_payment_gateway');

                $payment_gateway_used=false;

                if(!is_array($payment_gateways) or empty($payment_gateways))
                {
                    return array(
                        'status'=>false,
                        'message'=>__('Sorry! No payment gateway found',ST_TEXTDOMAIN)
                    );
                }else{
                    foreach($payment_gateways as $key=>$value){
                        $payment_gateway_id=$key;

                        $payment_gateway_used=STPaymentGateways::get_gateway($payment_gateway_id);

                    }
                    //Validate gateway is avaible

                    if(!isset($payment_gateway_id) or !$payment_gateway_used)
                    {
                        return array(
                            'status'=>false,
                            'message'=>sprintf(__('Sorry! Payment Gateway: <code>%s</code> is not available!',ST_TEXTDOMAIN),$payment_gateway_id)
                        );
                    }

                }


                // Action before submit form
                do_action('st_before_form_submit_run');

                $form_validate=true;

                if(!self::check_cart()){
                    return array(
                        'status'=>false,
                        'message'=>__('Your cart is currently empty.',ST_TEXTDOMAIN),
                        'code'=>'1'
                    );
                }


                if($coupon_code=STInput::request('coupon_code'))
                {
                    $status=self::do_apply_coupon($coupon_code);

                    if(!$status['status'])
                    {
                        return array(
                            'status'=>false,
                            'message'=>$status['message']
                        );
                    }
                }



                if(st()->get_option('booking_enable_captcha','on')=='on'){

                    $st_security_key=STInput::request('st_security_key');
                    if(!$st_security_key){
                        return array(
                            'status'=>false,
                            'message'=>__('You dose not enter the captcha',ST_TEXTDOMAIN)
                        );
                    }

                    $valid=STCoolCaptcha::validate_captcha($st_security_key);
                    if(!$valid){
                        return array(
                            'status'=>false,
                            'message'=>__('Captcha is not correct',ST_TEXTDOMAIN),
                            'error_code'=>'invalid_captcha'
                        );
                    }
                }


                $default=array(
                    'st_note'=>'',
                    'term_condition'=>'',
                    'create_account'=>false,
                    'paypal_checkout'=>false

                );

                extract(wp_parse_args($_POST,$default));

                //Term and condition
                if(!$term_condition){
                    return array(
                        'status'=>false,
                        'message'=>__('Please accept our terms and conditions',ST_TEXTDOMAIN)
                    );
                }



                $form_validate=self::validate_checkout_fields();

                if($form_validate){
                    // Payment method pre checkout validate
                    $form_validate=$payment_gateway_used->_pre_checkout_validate();
                }



                if($form_validate) {
                    // Allow to hook before save order
                    $form_validate = apply_filters('st_checkout_form_validate', $form_validate);
                }

                if(!$form_validate)
                {
                    $message= array(
                        'status'=>false,
                        'message'=>STTemplate::get_message_content(),
                        'form_validate'=>'false'
                    );

                    STTemplate::clear();

                    return $message;
                }


                $post=array(
                    'post_title'=>__('Order',ST_TEXTDOMAIN).' - '.date(get_option( 'date_format' )).' @ '.date(get_option('time_format')),
                    'post_type'=>'st_order',
                    'post_status'=>'publish'
                );


                //save the order
                $insert_post=wp_insert_post($post);

                if($insert_post){

                    $cart=self::get_items();

                    // Update checkout fields
                    $fields=self::get_checkout_fields();
                    if(!empty($fields))
                    {
                        foreach($fields as $key=>$value)
                        {
                            update_post_meta($insert_post,$key,STInput::post($key));
                        }
                    }

                    update_post_meta($insert_post,'st_tax',STCart::get_tax());
                    update_post_meta($insert_post,'st_currency',TravelHelper::get_current_currency('symbol'));
                    update_post_meta($insert_post,'coupon_code',STCart::get_coupon_code());
                    update_post_meta($insert_post,'coupon_amount',STCart::get_coupon_amount());
                    update_post_meta($insert_post,'status','pending');
                    update_post_meta($insert_post,'st_cart_info',$cart);
                    update_post_meta($insert_post,'total_price',STCart::get_total());
                    self::saveOrderItems($insert_post);

                    if(!is_user_logged_in())
                    {
                        $user_name=STInput::post('st_email');
                        $user_id = username_exists( $user_name );

                        //Now Create Account if user agree
                        if($create_account)
                        {

                            if ( !$user_id and email_exists($user_name) == false ) {
                                $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
                                $userdata = array(
                                    'user_login'  =>  $user_name,
                                    'user_pass'   =>  $random_password,
                                    'user_email'  =>$user_name,
                                    'first_name'  =>STInput::post('st_first_name'), // When creating an user, `user_pass` is expected.
                                    'last_name'  =>STInput::post('st_last_name') // When creating an user, `user_pass` is expected.
                                );
                                $user_id = wp_insert_user( $userdata );
                                //Create User Success, send the nofitication
                                wp_new_user_notification($user_id,$random_password);
                            }
                        }
                    }else{
                        $user_id=get_current_user_id();
                    }

                    if($user_id)
                    {
                        //Now Update the Post Meta
                        update_post_meta($insert_post,'id_user',$user_id);
                        //Update User Meta
                        update_user_meta($user_id,'st_phone',STInput::post('st_phone'));
                        update_user_meta($user_id,'first_name',STInput::post('st_first_name'));
                        update_user_meta($user_id,'last_name',STInput::post('st_last_name'));
                        update_user_meta($user_id,'st_address',STInput::post('st_address'));
                        update_user_meta($user_id,'st_address2',STInput::post('st_address2'));
                        update_user_meta($user_id,'st_city',STInput::post('st_city'));
                        update_user_meta($user_id,'st_province',STInput::post('st_province'));
                        update_user_meta($user_id,'st_zip_code',STInput::post('st_zip_code'));
                        update_user_meta($user_id,'st_country',STInput::post('st_country'));
                        update_user_meta($user_id,'st_zip_code',STInput::post('st_zip_code'));
                    }


                    update_post_meta($insert_post,'payment_method',$payment_gateway_id);
                    do_action('st_booking_success',$insert_post);


                    // Now gateway do the rest
                    return $payment_gateway_used->do_checkout($insert_post);


                }else{
                    return array(
                        'status'=>false,
                        'message'=>__('Can not save order.',ST_TEXTDOMAIN)
                    );
                }

            }
        }

        /**
         *
         *
         * @return Bool
         *
         * */
        static function validate_checkout_fields()
        {
            $fields=self::get_checkout_fields();

            $result=true;
            $validator=new STValidate();

            if(is_array($fields) and !empty($fields))
            {
                foreach($fields as $key=>$value)
                {
                    $default=array(
                        'label'=>'',
                        'placeholder'=>'',
                        'class'=>array(
                            'form-control'
                        ),
                        'type'=>'text',
                        'size'=>6,
                        'icon'=>'',
                        'validate'=>''
                    );

                    $value=wp_parse_args($value,$default);
                    if($value['validate'])
                        $validator->set_rules($key,$value['label'],$value['validate']);
                }
            }


            $result=$validator->run();

            if(!$result){
                STTemplate::set_message($validator->error_string(),'danger');
            }

            return $result;
        }

        static function saveOrderItems($order_id)
        {
            $cart=self::get_items();

            if(!empty($cart)){
                foreach($cart as $key=>$value){


                    $value=apply_filters('st_order_item_data',$value);

                    $new_post=$order_id;

                    if($new_post){
                        update_post_meta($new_post,'item_price',$value['price']);
                        update_post_meta($new_post,'item_id',$key);
                        update_post_meta($new_post,'item_number',$value['number']);
                        update_post_meta($new_post,'item_post_type',get_post_type($key));

                        if(!empty($value['data']) and is_array($value['data']) and !empty($value['data']))
                        {
                            $dk =true;
                            foreach($value['data'] as $k=>$v){
                                if($k=='check_in' or $k=='check_out' and $dk == true){
                                    update_post_meta($new_post,$k,date('Y-m-d H:i:s',strtotime($v)));
                                }else{
                                    update_post_meta($new_post,$k,$v);
                                }
                            }

                        }
                    }

                    do_action('st_after_save_order_item',$order_id,$key,$value);


                }
            }
        }

        static function ajax_submit_form()
        {
            //Add to cart then submit form
            $item_id=STInput::post('item_id');

            if(!$item_id)
            {
                $return =array(
                    'status'=>false,
                    'message'=>__('Please choose an item',ST_TEXTDOMAIN)
                );

            }else{

                $post_type=get_post_type($item_id);

                $number_room=STInput::post('number_room')?STInput::post('number_room'):false;
                if(!$number_room) $number_room=STInput::post('room_num_search')?STInput::post('room_num_search'):1;

                self::destroy_cart();

                $validate=true;

                switch($post_type){
                    case "st_hotel":
                        $hotel=new STHotel();
                        $validate=$hotel->do_add_to_cart(array(
                            'item_id'=>STInput::post('item_id'),
                            'number_room'=>$number_room,
                            'price'=>STInput::post('price'),
                            'check_in'=>STInput::post('check_in'),
                            'check_out'=>STInput::post('check_out'),
                            'room_num_search'=>STInput::post('room_num_search'),
                            'room_num_config'=>STInput::post('room_num_config'),
                            'room_id'=>STInput::post('room_id')
                        ));
                        break;
                    case "st_cars":
                        $car=new STCars();
                        $validate=$car->do_add_to_cart();
                        break;
                    case "st_activity":
                        $class=new STActivity();
                        $validate=$class->do_add_to_cart();
                        break;
                    case "st_tours":
                        $class=new STTour();
                        $validate=$class->do_add_to_cart();
                        break;
                    case "st_rental":
                        $class=new STRental();
                        $validate=$class->do_add_to_cart();
                        break;
                }

                if($validate){
                    $return =self::booking_form_submit();
                }else
                {
                    $return=array(
                        'status'=>false,
                        'message'=>STTemplate::get_message_content()
                    );
                    STTemplate::clear();
                }
            }


            echo json_encode($return);
            die;
        }


        static function save_user_checkout($user=array())
        {

        }

        static function handle_link($link1,$link2){
            {
                global $wp_rewrite;
                if ($wp_rewrite->permalink_structure == '')
                {
                    return $link1.'&'.$link2;
                }else{
                    return $link1.'?'.$link2;
                }
            }
        }

        static function get_order_item_total($item_id,$tax=0)
        {
            return get_post_meta($item_id,'total_price',true);

            $total=0;
            $post_id=get_post_meta($item_id,'item_id',true);
            switch(get_post_type($post_id))
            {
                case "st_hotel":
                case "st_rental":
                    $data['check_in']= get_post_meta($item_id,'check_in',true);
                    $data['check_out']= get_post_meta($item_id,'check_out',true);
                    $item_price= get_post_meta($item_id,'item_price',true);
                    $item_number= get_post_meta($item_id,'item_number',true);

                    $total=self::get_hotel_price($data,$item_price,$item_number);
                    break;
                case "st_cars":
                    $date = new DateTime(get_post_meta($item_id,'check_in',true));
                    $check_in=  strtotime($date->format('m/d/Y')." ".get_post_meta($item_id,'check_in_time',true));
                    $date = new DateTime(get_post_meta($item_id,'check_out',true));
                    $check_out= strtotime($date->format('m/d/Y')." ".get_post_meta($item_id,'check_out_time',true));
                    $time = ( $check_out - $check_in ) /3600 ;

                    $item_price= get_post_meta($item_id,'item_price',true);
                    $item_number= get_post_meta($item_id,'item_number',true);
                    $item_equipment= get_post_meta($item_id,'item_equipment',true);

                    $price_item = 0;
                    if(!empty($item_equipment)){
                        if($item_json=json_decode($item_equipment))
                        {
                            $item_equipment = get_object_vars($item_json);
                            foreach($item_equipment as $k=>$v){
                                $price_item += $v;
                            }
                        }

                    }
                    $total = $item_price * $item_number * $time + $price_item ;

                    break;
                case "st_activity":
                    $item_price= get_post_meta($item_id,'item_price',true);
                    $item_number= get_post_meta($item_id,'item_number',true);
                    $total = $item_price * $item_number;
                    break;
                case "st_tours":
                    $total=STTour::get_cart_item_total($item_id,get_post_meta($item_id,'st_cart_info',true));

                    break;
            }

            if($tax > 0){
                $total+=($total/100)*$tax;
            }
            return $total;
        }

        static function _apply_coupon()
        {
            if(STInput::post('st_action')=='apply_coupon')
            {
                $code=STInput::post('coupon_code');

                if(!$code){
                    self::$coupon_error=array(
                        'status'=>0,
                        'message'=>__('Coupon is not correct',ST_TEXTDOMAIN)
                    );
                }

                $status=self::do_apply_coupon($code);
                if(!$status['status'])
                {
                    self::$coupon_error=array(
                        'status'=>0,
                        'message'=>$status['message']
                    );

                }

            }else{
                self::$coupon_error=array();
            }
        }
        static function do_apply_coupon($code){
            $status=STCoupon::get_coupon_value($code);
            if(!$status['status'])
            {
                return array(
                    'status'=>0,
                    'message'=>$status['message']
                );

            }else
            {
                $_SESSION['st_cart_coupon']=array(
                    'code'=>$code,
                    'amount'=>$status['value']
                );
                return array(
                    'status'=>1
                );

            }
        }
        static function _remove_coupon()
        {
            if($removed_code=STInput::get('remove_coupon'))
            {
                $_SESSION['st_cart_coupon']=array();

            }
        }

        static function get_coupon_amount()
        {
            return isset($_SESSION['st_cart_coupon']['amount'])?$_SESSION['st_cart_coupon']['amount']:0;
        }

        static function get_coupon_code()
        {
            return isset($_SESSION['st_cart_coupon']['code'])?$_SESSION['st_cart_coupon']['code']:'';
        }

        static function get_checkout_field_html($field_name,$field)
        {
            $html=false;
            $default=array(
                'label'=>'',
                'placeholder'=>'',
                'class'=>array(
                    'form-control'
                ),
                'type'=>'text',
                'size'=>6,
                'icon'=>'',
                'validate'=>''
            );

            $field=wp_parse_args($field,$default);

            $field_type=$field['type'];
            if(function_exists('st_checkout_fieldtype_'.$field_type))
            {
                $function='st_checkout_fieldtype_'.$field_type;
                $html=$function($field_name,$field);
            }

            return apply_filters('st_checkout_fieldtype_'.$field_type,$html);
        }

        static function get_checkout_fields()
        {
            //Logged in User Info
            global $firstname , $user_email;
            get_currentuserinfo();
            $st_phone=false;
            $first_name=false;
            $last_name=false;
            $st_address=false;
            $st_address2=false;
            $st_city=false;
            $st_province=false;
            $st_zip_code=false;
            $st_country=false;
            if(is_user_logged_in())
            {
                $user_id=get_current_user_id();
                $st_phone=get_user_meta($user_id,'st_phone',true);
                $first_name=get_user_meta($user_id,'first_name',true);
                $last_name=get_user_meta($user_id,'last_name',true);
                $st_address=get_user_meta($user_id,'st_address',true);
                $st_address2=get_user_meta($user_id,'st_address2',true);
                $st_city=get_user_meta($user_id,'st_city',true);
                $st_province=get_user_meta($user_id,'st_province',true);
                $st_zip_code=get_user_meta($user_id,'st_zip_code',true);
                $st_country=get_user_meta($user_id,'st_country',true);
            }

            $terms_link='<a target="_blank" href="'.get_the_permalink(st()->get_option('page_terms_conditions')).'">'.st_get_language('terms_and_conditions').'</a>';
            $checkout_form_fields=array(
                'st_first_name'=>array(
                    'label'=>st_get_language('first_name'),
                    'icon'=>'fa-user',
                    'value'         =>STInput::post('st_first_name',$first_name),
                    'validate'      =>'required|trim|strip_tags',
                ),
                'st_last_name'=>array(
                    'label'         =>st_get_language('last_name'),
                    'placeholder'   =>st_get_language('last_name'),
                    'validate'      =>'required|trim|strip_tags',
                    'icon'          =>'fa-user',
                    'value'         =>STInput::post('st_last_name',$last_name)
                ),
                'st_email'=>array(
                    'label'         =>st_get_language('Email'),
                    'placeholder'   =>st_get_language('email_domain'),
                    'type'          =>'text',
                    'validate'      =>'required|trim|strip_tags|valid_email',
                    'value'         =>STInput::post('st_email',$user_email),
                    'icon'          =>'fa-envelope'

                ),
                'st_phone'          =>array(
                    'label'         =>st_get_language('Phone'),
                    'placeholder'   =>st_get_language('Your_Phone'),
                    'validate'      =>'required|trim|strip_tags',
                    'icon'          =>'fa-phone',
                    'value'         =>STInput::post('st_phone',$st_phone),

                ),
                'st_address'=>array(
                    'label'=>st_get_language('address_line_1'),
                    'placeholder'=>st_get_language('your_address_line_1'),
                    'icon'          =>'fa-map-marker',
                    'value'         =>STInput::post('st_address',$st_address),
                ),
                'st_address2'       =>array(
                    'label'         =>st_get_language('address_line_2'),
                    'placeholder'   =>st_get_language('your_address_line_2'),
                    'icon'          =>'fa-map-marker',
                    'value'         =>STInput::post('st_address2',$st_address2),
                ),
                'st_city'=>array(
                    'label'         =>st_get_language('city'),
                    'placeholder'   =>st_get_language('your_city'),                                 'icon'          =>'fa-map-marker',
                    'value'         =>STInput::post('st_city',$st_city),

                ),
                'st_province'       =>array(
                    'label'         =>st_get_language('state_province_region'),
                    'placeholder'   =>st_get_language('state_province_region'),
                    'icon'          =>'fa-map-marker',
                    'value'         =>STInput::post('st_province',$st_province),
                ),
                'st_zip_code'       =>array(
                    'label'         =>st_get_language('zip_postal_code'),
                    'placeholder'   =>st_get_language('zip_postal_code'),
                    'icon'          =>'fa-map-marker',
                    'value'         =>STInput::post('st_zip_code',$st_zip_code),
                ),
                'st_country'        =>array(
                    'label'         =>st_get_language('country'),
                    'icon'          =>'fa-globe',
                    'value'         =>STInput::post('st_country',$st_country),
                ),
                'st_note'        =>array(
                    'label'         =>st_get_language('special_requirements'),
                    'icon'          =>false,
                    'type'          =>'textarea',
                    'size'          =>12,
                    'value'         =>STInput::post('st_note'),
                    'attrs'         =>array(
                        'rows'       =>6
                    )
                )

            );


            $checkout_form_fields=apply_filters('st_booking_form_fields',$checkout_form_fields);

            return $checkout_form_fields;
        }

    }

    STCart::init();
}
