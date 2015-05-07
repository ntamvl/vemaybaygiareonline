<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STGatewaySubmitform
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STGatewaySubmitform'))
{
    class STGatewaySubmitform extends STAbstactPaymentGateway
    {

        function __construct()
        {

        }

        function html()
        {
            echo st()->load_template('gateways/submit_form');
        }

        function do_checkout($order_id)
        {
            update_post_meta($order_id,'status','pending');

            //Destroy cart on success
            STCart::destroy_cart();

            $booking_success=STCart::get_success_link();

            do_action('st_booking_submit_form_success',$order_id);

            return array(
                'status'=>true,
                'redirect'=>esc_url(add_query_arg(array(
                    'order_code'=>$order_id,

                ),$booking_success))
            );

        }


        function get_name()
        {
            return __('Submit Form',ST_TEXTDOMAIN);
        }

        function is_available()
        {
            if(st()->get_option('pm_gway_st_submit_form_enable')=='on')
            {
                return true;
            }
            return false;
        }
        function _pre_checkout_validate()
        {
            return true;
        }

        function get_option_fields()
        {
            return array();
        }
        function get_default_status()
        {
            return true;
        }
    }
}
