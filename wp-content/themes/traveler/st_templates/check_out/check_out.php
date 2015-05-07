<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Check out
 *
 * Created by ShineTheme
 *
 */


?>

    <?php wp_nonce_field('submit_form_order','travel_order');?>
    <?php echo st()->load_template('hotel/booking_form',false,array(
        'field_coupon'=>false
    )); ?>

    <?php do_action('st_booking_form_field')?>



    <div class="checkbox">
        <label>
            <input class="i-check" value="1" name="create_account" type="checkbox" <?php if(empty($_POST) or STInput::post('create_account')==1) echo 'checked'; ?>/><?php printf(__('Create %s account ',ST_TEXTDOMAIN),get_bloginfo('title')) ?> <small><?php st_the_language('password_will_be_send_to_your_email')?></small>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input class="i-check" value="1" name="term_condition" type="checkbox" <?php if(STInput::post('term_condition')==1) echo 'checked'; ?>/><?php echo  st_get_language('i_have_read_and_accept_the').'<a target="_blank" href="'.get_the_permalink(st()->get_option('page_terms_conditions')).'"> '.st_get_language('terms_and_conditions').'</a>';?>
        </label>
    </div>
    <div class="alert form_alert hidden"></div>
    <div class="payment_gateways">
        <?php STPaymentGateways::get_payment_gateways_html() ?>
    </div>
