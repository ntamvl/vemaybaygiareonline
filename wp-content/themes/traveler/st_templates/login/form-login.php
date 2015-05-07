<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * form login
 *
 * Created by ShineTheme
 *
 */
$class_form='';
if(is_page_template('template-login.php')){
    $class_form = 'form-group-ghost';
}
    $btn_sing_in = get_post_meta(get_the_ID(),'btn_sing_in',true);
    if(empty($btn_sing_in))$btn_sing_in=__("Sing In");
?>
<form method="post" action="<?php echo TravelHelper::build_url('url',STInput::get('url')) ?>">
    <?php
        global $status_login;
        echo balanceTags($status_login);
        unset($status_login);
    ?>
    <div class="form-group <?php echo esc_attr($class_form); ?> form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
        <label><?php st_the_language('username_or_email') ?></label>
        <input name="login_name" class="form-control" placeholder="<?php _e('e.g. johndoe@gmail.com',ST_TEXTDOMAIN)?>" type="text" />
    </div>
    <div class="form-group <?php echo esc_attr($class_form); ?> form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
        <label><?php st_the_language('password') ?></label>
        <input name="login_password" class="form-control" type="password" placeholder="<?php st_the_language('my_secret_password') ?>" />
    </div>
    <input class="btn btn-primary" name="dlf_submit" type="submit" value="<?php echo esc_html($btn_sing_in) ?>" />
</form>