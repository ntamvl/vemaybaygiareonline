<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Header
 *
 * Created by ShineTheme
 *
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php do_action('before_body_content')?>
<div class="global-wrap <?php echo apply_filters('st_container',true) ?>">
<div class="row">
    <header id="main-header">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <a class="logo" href="<?php echo site_url('/')?>">
                            <img src="<?php echo st()->get_option('logo',get_template_directory_uri().'/img/logo-invert.png') ?>" alt="logo" title="<?php bloginfo('name')?>">
                        </a>
                    </div>
                    <?php get_template_part('users/user','nav');?>
                </div>
            </div>
        </div>
        <div class="main_menu_wrap">
            <div class="container">
                <div class="nav">
                    <?php if(has_nav_menu('primary')){
                        wp_nav_menu(array('theme_location'=>'primary',
                                            "container"=>"",
                                            'items_wrap'      => '<ul id="slimmenu" class="%2$s slimmenu">%3$s</ul>',
                        ));
                    }
                    ?>
                </div>
            </div>
        </div><!-- End .main_menu_wrap-->
    </header>