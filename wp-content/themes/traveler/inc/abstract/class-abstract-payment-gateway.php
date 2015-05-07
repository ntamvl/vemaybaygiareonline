<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STAbstactPaymentGateway
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STAbstactPaymentGateway'))
{
    abstract class STAbstactPaymentGateway
    {

        /**
         * Render html for checkout page
         *
         *
         * */
        abstract function html();

        /**
         * Handle checkout action after create the order
         *
         *
         * */
        abstract function do_checkout($order_id);


        /**
         * Return if current gateway is available
         *
         *
         * */
        abstract function is_available();

        /**
         * Get Payment Gateway Name
         *
         *
         * */
        abstract function get_name();

        /**
         * _pre_checkout_validate
         *
         *
         * */
        abstract function _pre_checkout_validate();

        /**
         * Get Theme Options param
         *
         *
         * */

        abstract function get_option_fields();

        /**
         *
         * Get Default Gateway Status
         *
         *
         * */
        abstract function get_default_status();
    }
}
