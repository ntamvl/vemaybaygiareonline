<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * form new login
 *
 * Created by ShineTheme
 *
 */
if(isset($_REQUEST['btn-reg'])){
    STUser_f::registration_user();
}
$class_form = "";
if(is_page_template('template-login.php')){
    $class_form = 'form-group-ghost';
}
    $btn_sing_up = get_post_meta(get_the_ID(),'btn_sing_up',true);
    if(empty($btn_sing_up))$btn_sing_up=__("Sing Up");
?>

<form  method="post" action="<?php echo TravelHelper::build_url('url',STInput::get('url')) ?>">
    <div class="form-group <?php echo esc_attr($class_form); ?> form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
        <label><?php st_the_language('full_name') ?></label>
        <input name="full_name" class="form-control" placeholder="<?php _e('e.g. John Doe',ST_TEXTDOMAIN)?>" type="text" />
    </div>
    <div class="form-group <?php echo esc_attr($class_form); ?> form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-show"></i>
        <label><?php st_the_language('email') ?></label>
        <input name="email" class="form-control" placeholder="<?php _e('e.g. johndoe@gmail.com',ST_TEXTDOMAIN)?>" type="text" />
    </div>
    <div class="form-group <?php echo esc_attr($class_form); ?> form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
        <label><?php st_the_language('password') ?></label>
        <input name="password" class="form-control" type="password" placeholder="<?php _e('my secret password',ST_TEXTDOMAIN)?>" />
    </div>
    <input name="btn-reg" class="btn btn-primary" type="submit" value="<?php echo esc_html($btn_sing_up) ?>" />
</form>

