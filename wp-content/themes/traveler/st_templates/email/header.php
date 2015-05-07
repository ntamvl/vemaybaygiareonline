<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Email header
 *
 * Created by ShineTheme
 *
 */

$main_color=st()->get_option('main_color','#ed8323');
?>
<div style="background:#f5f5f5 ;padding-bottom: 20px;"  id="email_main">
    <table width="750" cellspacing="0" cellpadding="0" align="center" style="">
        <tr>
            <td width="200px" style="padding-bottom: 5px;padding-left: 10px" valign="middle" align="left">
                <a href="<?php echo home_url('/')?>" target="_blank">
                    <img src="<?php echo st()->get_option('email_logo',get_template_directory_uri().'/img/logo.png') ?>" alt="logo" title="<?php bloginfo('name')?>">
                </a>
            </td>
            <td align="right" valign="middle" style="padding: 5px 10px;">
                <h3><?php bloginfo('title')?></h3>
                <p><?php bloginfo('description')?></p>
            </td>
        </tr>

        <tr style="padding-bottom: 20px;padding-right: 10px">
            <td colspan="10" align="left" style="padding:30px" bgcolor="<?php echo esc_attr($main_color)?>">
                <h1 style="margin:0px;font-size: 40px;color:white;"><?php echo isset($email_title)?$email_title:get_bloginfo('title'); ?></h1>
            </td>
        </tr>