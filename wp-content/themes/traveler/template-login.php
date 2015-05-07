<?php
/*
Template Name: Login Full
*/
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Template Name : Login Full
 *
 * Created by ShineTheme
 *
 */
get_header("full");
?>
<div class="full-center">
    <div class="container">
        <div class="row row-wrap" data-gutter="60">
            <div class="col-md-4">
                <div class="visible-lg visible-md">
                    <h3 class="mb15"><?php the_title(); ?></h3>
                    <?php
                    while(have_posts()){
                        the_post();
                        the_content();
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-4">
                <h3 class="mb15"><?php st_the_language('login') ?></h3>
                <?php echo st()->load_template('login/form','login') ?>
            </div>
            <div class="col-md-4">
                <h3 class="mb15"><?php printf(__("New To %s ?",ST_TEXTDOMAIN),get_bloginfo('title')) ?></h3>
                <?php echo st()->load_template('login/form-new','login') ?>
            </div>
        </div>
    </div>
</div>
<?php  get_footer('full'); ?>
