<?php
/*
Template Name: Login Normal
*/

/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Template Name : Login Normal
 *
 * Created by ShineTheme
 *
 */
get_header();
?>
<div class="container">
    <h1 class="page-title"><?php printf(__("Login/Register on %s",ST_TEXTDOMAIN),get_bloginfo('name')) ?></h1>
</div>
<div class="gap"></div>
<div class="container">
    <div class="row" data-gutter="60">
        <div class="col-md-4">
            <h3><?php the_title(); ?></h3>
            <?php
            while(have_posts()){
                the_post();
                the_content();
            }
            ?>
        </div>
        <div class="col-md-4">
            <h3><?php st_the_language('login') ?></h3>
            <?php echo st()->load_template('login/form','login') ?>
        </div>
        <div class="col-md-4">
            <h3><?php printf(__("New To %s ?",ST_TEXTDOMAIN),get_bloginfo('title')) ?></h3>
            <?php echo st()->load_template('login/form-new','login') ?>
        </div>
    </div>
</div>
<div class="gap"></div>
<?php  get_footer(); ?>
