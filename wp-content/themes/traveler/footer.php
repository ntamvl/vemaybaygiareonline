<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Footer
 *
 * Created by ShineTheme
 *
 */
    $footer_template=st()->get_option('footer_template');
    if(is_singular())
    {
        if($meta=get_post_meta(get_the_ID(),'footer_template',true)){
            $footer_template=$meta;
        }
    }
    if($footer_template){
        echo '<footer id="main-footer">';
        echo STTemplate::get_vc_pagecontent($footer_template);
        echo ' </footer>';
    }else
    {
?>
<!--        Default Footer -->
    <footer id="main-footer">
        <div class="container text-center">
            <p><?php _e('Copy &copy; 2014 Shinetheme. All Rights Reserved',ST_TEXTDOMAIN)?></p>
        </div>

    </footer>
<?php }?>
        </div><!--End Row-->
    </div>
<!--    End #Wrap-->

<!-- Gotop -->
<div id="gotop" title="<?php _e('Go to top',ST_TEXTDOMAIN)?>">
    <i class="fa fa-chevron-up"></i>
</div>
<!-- End Gotop -->
<?php wp_footer(); ?>
</body>
</html>
