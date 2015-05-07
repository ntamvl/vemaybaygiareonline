<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * hotel booking form
 *
 * Created by ShineTheme
 *
 */


$checkout_fields=STCart::get_checkout_fields();

?>
<div class="clearfix">

    <div class="row">
        <?php
        if(!empty($checkout_fields))
        {
            foreach($checkout_fields as $key=>$value){
                echo STCart::get_checkout_field_html($key,$value);
            }
        }

        ?>

    </div>
</div>

<?php do_action('st_after_checkout_fields',get_post_type(get_the_ID()))?>

<div class="clearfix">
    <div class="row">
        <div class="col-sm-6">
            <?php if(st()->get_option('booking_enable_captcha','on')=='on'){
                $code=STCoolCaptcha::get_code();
                ?>
                <div class="form-group captcha_box" >
                    <label><?php st_the_language('captcha')?></label>
                    <img src="<?php echo STCoolCaptcha::get_captcha_url($code) ?>" align="captcha code" class="captcha_img">
                    <input type="text" name="<?php echo esc_attr($code) ?>" value="" class="form-control">
                    <input type="hidden" name="st_security_key" value="<?php echo esc_attr($code) ?>">
                </div>
            <?php }?>
        </div>
    </div>
</div>

