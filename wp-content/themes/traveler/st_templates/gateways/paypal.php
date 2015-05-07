<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Payment
 *
 * Created by ShineTheme
 *
 */
?>

    <div class="text-center">
        <img class="pp-img" src="<?php echo get_template_directory_uri() ?>/img/paypal.png" alt="<?php st_the_language('paypal')?>">
        <p><?php st_the_language('you_will_be_redirected_to_payPal')?></p>
    </div>
    <div class="text-center">
        <input class="btn btn-primary btn-st-big st_payment_gatewaw_submit" type="submit" name="st_payment_gateway[st_paypal]" value="<?php st_the_language('checkout_via_paypal')?>">
    </div>
