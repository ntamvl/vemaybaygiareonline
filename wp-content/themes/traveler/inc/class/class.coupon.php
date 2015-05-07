<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STCoupon
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STCoupon'))
{
    class STCoupon extends TravelerObject
    {
        protected $post_type='st_coupon_code';
        function init()
        {
            parent::init();
            add_action('init',array($this,'_add_metabox'),10);

        }

        function _add_metabox()
        {
            $this->metabox[] = array(
                'id'          => 'st_coupon_metabox',
                'title'       => __( 'Coupon Detail', ST_TEXTDOMAIN),
                'desc'        => '',
                'pages'       => array( $this->post_type ),
                'context'     => 'normal',
                'priority'    => 'high',
                'fields'      => array(
                    array(
                        'label'       => __( 'General', ST_TEXTDOMAIN),
                        'id'          => 'general_tab',
                        'type'        => 'tab'
                    )

                ,array(
                        'id'                    =>'discount_type',
                        'label'                 =>__('Discount Type',ST_TEXTDOMAIN),
                        'type'                  =>'select',
                        'desc'                  =>__('Select Discount Type',ST_TEXTDOMAIN),
                        'choices'               =>array(
                            array(
                                'value'     =>'cart_amount',
                                'label'      =>__('Cart Discount',ST_TEXTDOMAIN)
                            ),
                            array(
                                'value'     =>'cart_percent',
                                'label'      =>__('Cart % Discount',ST_TEXTDOMAIN)
                            ),
//                        array(
//                            'value'     =>'product_amount',
//                            'label'      =>__('Product Discount',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'     =>'product_percent',
//                            'label'      =>__('Product % Discount',ST_TEXTDOMAIN)
//                        )
                        )
                    ),
                    array(
                        'id'            =>'booking_type_available',
                        'label'         =>__('Available for:',ST_TEXTDOMAIN),
                        'desc'         =>__('This coupon only available for. Selected nothing for all types',ST_TEXTDOMAIN),
                        'type'          =>'checkbox',
                        'choices'       =>self::_get_metabox_booking_types()
                    ),
                    array(
                        'id'            =>'amount',
                        'label'         =>__('Discount Amount',ST_TEXTDOMAIN),
                        'desc'         =>__('Discount Amount',ST_TEXTDOMAIN),
                        'type'          =>'text',
                    ),
                    array(
                        'id'            =>'expiry_date',
                        'label'         =>__('Expiry Date',ST_TEXTDOMAIN),
                        'desc'         =>__('Left empty for unlimited',ST_TEXTDOMAIN),
                        'type'          =>'date-picker',
                    ),
                    array(
                        'id'            =>'restriction_tab',
                        'label'         =>__('Restriction',ST_TEXTDOMAIN),
                        'type'          =>'tab',
                    ),
                    array(
                        'id'            =>'minimum_spend',
                        'label'         =>__('Minimum spend',ST_TEXTDOMAIN),
                        'desc'         =>__('Minimum spend',ST_TEXTDOMAIN),
                        'type'          =>'text',
                    ),
                    array(
                        'id'            =>'maximum_spend',
                        'label'         =>__('Maximum spend',ST_TEXTDOMAIN),
                        'desc'         =>__('Maximum spend',ST_TEXTDOMAIN),
                        'type'          =>'text',
                    ),
                    array(
                        'id'            =>'include_products',
                        'label'         =>__('Products',ST_TEXTDOMAIN),
                        'desc'         =>__('Products which need to be in the cart to use this coupon or, for "Product Discounts", which products are discounted.',ST_TEXTDOMAIN),
                        'type'          =>'product_select_ajax',
                    ),
                    array(
                        'id'            =>'exclude_products',
                        'label'         =>__('Exclude Products',ST_TEXTDOMAIN),
                        'desc'         =>__('Products which must not be in the cart to use this coupon or, for "Product Discounts", which products are not discounted.',ST_TEXTDOMAIN),
                        'type'          =>'product_select_ajax',
                    ),
                    array(
                        'id'            =>'limit_per_coupon',
                        'label'         =>__('Limit per coupon',ST_TEXTDOMAIN),
                        'desc'         =>__('How many time this coupon can be used. Left empty for unlimited',ST_TEXTDOMAIN),
                        'type'          =>'text',
                    ),
                    array(
                        'id'            =>'limit_per_user',
                        'label'         =>__('Limit per User',ST_TEXTDOMAIN),
                        'desc'         =>__('How many time this coupon can be used. Left empty for unlimited',ST_TEXTDOMAIN),
                        'type'          =>'text',
                    ),
                )
            );
        }

        static function get_coupon_value($coupon,$total=false,$cart_items=array(),$customer_email=false){

            if(!$total){
                $total=STCart::get_total_with_out_tax();
            }


            if(empty($cart_items)){
                $cart_items=STCart::get_items();
            }

            $coupon_object=get_page_by_title($coupon,OBJECT,'st_coupon_code');
            if(!$coupon_object) return array(
                'status'=>0,
                'message'=>__('Coupon Not Found',ST_TEXTDOMAIN)
            );

            $discount_value=0;

            $coupon_post_id=$coupon_object->ID;

            $discount_type=get_post_meta($coupon_post_id,'discount_type',true);

            $booking_type_available=get_post_meta($coupon_post_id,'booking_type_available',true);

            $amount=get_post_meta($coupon_post_id,'amount',true);

            $expiry_date=get_post_meta($coupon_post_id,'expiry_date',true);

            $minimum_spend=get_post_meta($coupon_post_id,'minimum_spend',true);

            $maximum_spend=get_post_meta($coupon_post_id,'maximum_spend',true);

            $required_porduct=get_post_meta($coupon_post_id,'include_products',true);

            $exclude_products=get_post_meta($coupon_post_id,'exclude_products',true);

            $limit_per_coupon=get_post_meta($coupon_post_id,'limit_per_coupon',true);

            $limit_per_user=get_post_meta($coupon_post_id,'limit_per_user',true);


            //Validate Booking Type
            if($booking_type_available){
                $check=false;
                $messages=array();

                foreach($booking_type_available as $key){
                    if(post_type_exists($key)) {
                        $post_type_obj = get_post_type_object($key);
                        if (self::_check_post_type_items($key, $cart_items)) {
                            $check = true;
                        }

                        $messages[] = $post_type_obj->labels->name;
                    }
                }

                if(!$check){
                    return array(
                        'status'=>0,
                        'message'=>sprintf(__('This coupon is only use for %s',ST_TEXTDOMAIN),implode(', ',$messages))
                    );
                }
            }




            //Validate Expiry Date
            if($expiry_date){
                $datediff=STDate::date_diff2($expiry_date,date('Y-m-d'));

                if($datediff<=1){
                    return array(
                        'status'=>0,
                        'message'=>__('This coupon is expired',ST_TEXTDOMAIN)
                    );
                }
            }

            //Validate Minium Spend
            if($minimum_spend){
                if($minimum_spend>$total){
                    return array(
                        'status'=>0,
                        'message'=>sprintf(__('This coupon is only applicable for bills spent over %s',ST_TEXTDOMAIN),TravelHelper::format_money($minimum_spend))
                    );
                }
            }

            //Validate Maximum Spend
            if($maximum_spend){
                if($maximum_spend<$total){
                    return array(
                        'status'=>0,
                        'message'=>sprintf(__('This coupon is only applicable for bills spent less than %s',ST_TEXTDOMAIN),TravelHelper::format_money($maximum_spend))
                    );
                }
            }



            //Validate Required Product
            if($required_porduct){
                $ids=explode(',',$required_porduct);
                $products_name=array();
                $check=true;
                foreach($ids as $key){
                    if(!self::_check_in_items($key,$cart_items))
                    {
                        $check=false;
                    }

                    $products_name[]="<a class='dotted_bottom' href='".get_permalink($key)."' target='_blank'>". get_the_title($key)."</a>";
                }

                if(!$check){
                    return array(
                        'status'=>0,
                        'message'=>sprintf(__('This coupon is required %s in the cart',ST_TEXTDOMAIN),implode(', ',$products_name))
                    );
                }
            }

            //Validate Exclude Product
            if($exclude_products){
                $ids=explode(',',$exclude_products);
                $products_name=array();
                $check=true;
                foreach($ids as $key){
                    if(self::_check_in_items($key,$cart_items))
                    {
                        $check=false;
                    }

                    $products_name[]="<a class='dotted_bottom' href='".get_permalink($key)."' target='_blank'>". get_the_title($key)."</a>";
                }


                if(!$check){
                    return array(
                        'status'=>0,
                        'message'=>sprintf(__('This coupon is required %s NOT in the cart',ST_TEXTDOMAIN),implode(', ',$products_name))
                    );
                }
            }

            //Validate Used Time
            if($limit_per_coupon)
            {
                global $wpdb;

                $query="SELECT COUNT(meta_id) as total FROM $wpdb->postmeta
                    WHERE meta_key='coupon_code'
                    AND meta_value=%s
                  ";
                $count_used=$wpdb->get_var($wpdb->prepare($query,$coupon));

                if($count_used>=$limit_per_coupon){
                    return array(
                        'status'=>0,
                        'message'=>__('This coupon is reach the limit of usage',ST_TEXTDOMAIN)
                    );
                }
            }

            // Validate Per User
            if($limit_per_user and (is_user_logged_in() or $customer_email))
            {
                $q_arg=array(
                    'post_type'=>'st_order'
                );

                if(is_user_logged_in()){
                    $q_arg['meta_key']='id_user';
                    $q_arg['meta_value']=get_current_user_id();
                }elseif($customer_email){
                    $q_arg['meta_key']='st_email';
                    $q_arg['meta_value']=$customer_email;
                }

                $query=new WP_Query($q_arg);
                if($query->found_posts>=$limit_per_user){
                    return array(
                        'status'=>0,
                        'message'=>__('This coupon is reach the limit of usage per user',ST_TEXTDOMAIN)
                    );
                }
            }

            if($amount){
                switch($discount_type){
                    case "cart_percent":
                        if($amount<100)
                            $discount_value=($total/100)*$amount;
                        else $discount_value=$total;
                        break;
                    // Currently, Only one product in cart, so dont need to use bellow discount type
//                case "product_amount":
//                    $discount_value=self::_get_product_discount($amount,explode(',',$required_porduct),$cart_items,'amount');
//                    break;
//                case "product_percent":
//                    $discount_value=self::_get_product_discount($amount,explode(',',$required_porduct),$cart_items,'percent');
//                    break;

                    // Default: Card Discount
                    default:
                        $discount_value=($amount>$total)?$total:$amount;
                        break;
                }
            }

            $result=apply_filters('st_get_coupon_value',array('status'=>1,'value'=>$discount_value,'coupon'=>$coupon,'total'=>$total,'cart_items'=>$cart_items));

            return array(
                'status'=>$result['status'],
                'value'=>isset($result['value'])?$result['value']:0,
                'message'=>isset($result['message'])?$result['message']:0,
                'data'=>isset($result['data'])?$result['data']:0,
            );


        }

        static function _get_product_discount($amount,$products,$cart_items,$type='amount')
        {
            $discount=0;
//        var_dump($cart_items);

            if(!empty($products)){
                foreach($products as $key){
                    if(self::_check_in_items($key,$cart_items))
                    {
                        if($type=='amount'){
                            if($cart_items[$key]['price']>$amount){
                                $discount+=$amount;
                            }else{
                                $discount+=$cart_items[$key]['price'];
                            }
                        }elseif($type=='percent')
                        {
                            if($amount>100){
                                $amount=100;
                            }

                            $discount+=($cart_items[$key]['price']/100)*$amount;
                        }
                    }
                }
            }

            if(!empty($cart_items))
            {
                foreach($cart_items as $key=>$value)
                {
                    $booking_id=TravelerObject::get_orgin_booking_id($key);

                    if(in_array($booking_id,$products)){
                        if($type=='amount'){
                            if($value['price']>$amount){
                                $discount+=$amount;
                            }else{
                                $discount+=$value['price'];
                            }
                        }elseif($type=='percent')
                        {
                            if($amount>100){
                                $amount=100;
                            }

                            $discount+=($value['price']/100)*$amount;
                        }
                    }
                }
            }



//        var_dump($discount);

            return $discount;
        }

        static function _check_in_items($post_id,$cart_items)
        {
            foreach($cart_items as $key=>$value){
                if($post_id==$key) return true;
                else{
                    $hotel_id=get_post_meta($key,'room_parent',true);
                    if($hotel_id and $hotel_id==$post_id){
                        return true;
                    }
                }


            }

            return false;
        }
        static function _check_post_type_items($post_type,$cart_items,$start=false)
        {
            $return =$start;
            foreach($cart_items as $key=>$value){
                if(get_post_type($key)==$post_type) $return= true;
                else{
                    if(get_post_type($key)=='hotel_room'){
                        if($post_type=='st_hotel') $return=true;
                    }else
                    {
                        $return=false;
                    }
                }

            }

            return $return;
        }

        static function _get_metabox_booking_types(){
            $booking_types=STTraveler::booking_type();
            $r=array();
            if(!empty($booking_types)){
                foreach($booking_types as $key=>$value){
                    if(post_type_exists($value))
                    {
                        $post_type_obj=get_post_type_object($value);
                        $r[]=array(
                            'label'         =>$post_type_obj->labels->singular_name,
                            'value'         =>$value
                        );
                    }
                }
            }

            return $r;
        }
    }

    $a=new STCoupon();
    $a->init();
}
