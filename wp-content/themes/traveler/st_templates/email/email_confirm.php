<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Email confirm
 *
 * Created by ShineTheme
 *
 */

$main_color=st()->get_option('main_color','#ed8323');
$title=st_get_language('confirmation_needed');
echo st()->load_template('email/header',null,array('email_title'=>$title));
?>
<tr style="background: white">
    <td colspan="10" style="padding: 20px;">
            <div class="" style="text-align: center">
                <p><?php  st_the_language('you_added_an_email_to_your_account') ?></p>
                <p><?php  st_the_language('click_confirm_to_import_the_booking') ?></p>

                <div class=" " style="padding: 100px 0px 50px;;">
                <a class="btn btn-primary" style="
                    text-decoration: none;
padding-left: 30px;
padding-right: 30px;
padding-top: 14px;
padding-bottom: 14px;
color:white;
background: <?php echo esc_attr($main_color)?>;
font-size: 30px;;
" href="<?php echo esc_url($confirm_link)?>" target="_blank"><?php st_the_language('email_confirm')?></a>


            </div>
                <p><?php echo st_get_language('email_can_see_the_button').' <a href="'.$confirm_link.'" target="_blank">'.$confirm_link.'</a>';?></p>
       </div>
    </td>

</tr>
<?php
echo st()->load_template('email/footer');
