<?php
/*
Template Name: Confirm Order
*/
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Template Name : confirm
 *
 * Created by ShineTheme
 *
 */
get_header();
$message=STTemplate::get_message();
?>
<div class="gap"></div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php if($message['type']):?>
            <i class="fa fa-check round box-icon-large box-icon-center box-icon-success mb30"></i>
            <?php else:?>
                <i class="fa fa-close round box-icon-large box-icon-center box-icon-danger mb30"></i>
            <?php endif;?>
            <h2 class="text-center">
                <?php echo esc_html($message['content']) ?>
            </h2>
        </div>
    </div>
</div>
<?php
get_footer();