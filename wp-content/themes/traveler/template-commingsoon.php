<?php
/*
Template Name: Comming Soon
*/
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Template Name : Comming Soon
 *
 * Created by ShineTheme
 *
 */
  get_header("full");
?>
<div class="full-center">
    <div class="container">
        <h2 class="text-center"><?php the_title(); ?></h2>
        <div class="countdown countdown-lg" inline_comment="countdown" data-countdown="<?php echo get_post_meta(get_the_ID(),'data_countdown',true); ?>" id="countdown"></div>
        <div class="gap"></div>
        <!--<p><?php /*_e("be notified. we just need your email address",ST_TEXTDOMAIN) */?></p>-->
        <!--<div class="row">
            <div class="col-md-4 col-md-offset-4">
                <form>
                    <div class="form-group form-group-ghost form-group-lg">
                        <input class="form-control" placeholder="Type your email address" type="text" />
                    </div>
                </form>
            </div>
        </div>-->
    </div>
</div>
<?php 
  while(have_posts()){
	the_post();
	the_content();
  }
?>
<?php  get_footer("full"); ?>
