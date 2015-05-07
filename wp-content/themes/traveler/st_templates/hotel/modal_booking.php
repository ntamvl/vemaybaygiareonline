<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * hotel modal booking
 *
 * Created by ShineTheme
 *
 */

//Logged in User Info
global $firstname , $user_email;
get_currentuserinfo();


?>
<h3><?php printf(st_get_language('you_are_booking_for_s'),get_the_title())?></h3>

<form action="" method="post" onsubmit="return false">
    <div id="booking_modal_<?php echo get_the_ID() ?>" class="booking_modal_form">

        <input name="check_in" value="<?php echo STInput::request('start') ?>" type="hidden">
        <input name="check_out" value="<?php
        echo STInput::request('end') ?>" type="hidden">

        <input type="hidden" name="item_id" value="<?php echo get_post_meta(get_the_ID(),'room_parent',true); ?>">
        <input type="hidden" name="room_id" value="<?php echo get_the_ID()?>">
        <input type="hidden" name="room_num_search" value="<?php echo (STInput::request('room_num_search'))?STInput::request('room_num_search'):1 ?>">
        <input type="hidden" name="room_num_config" value="<?php echo esc_attr( serialize( STInput::post('room_num_config'))) ?>">
        <input type="hidden" name="adult_num" value="<?php echo esc_attr( serialize( STInput::request('adult_num'))) ?>">
        <?php
        $old_price=get_post_meta(get_the_ID(),'price',true);
        $new_price=STRoom::get_room_price();

        ?>
        <input name="price" value="<?php echo esc_attr($new_price) ?>" type="hidden">

        <?php echo st()->load_template('check_out/check_out')?>


    </div>
</form>