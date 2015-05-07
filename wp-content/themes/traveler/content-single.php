<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Content custom single
 *
 * Created by ShineTheme
 *
 */
?>
<article <?php post_class('post')?>>
    <?php if(get_post_format()):?>
        <header class="post-header">
            <?php get_template_part('loop/loop',get_post_format());?>
        </header>
        <?php elseif(has_post_thumbnail()):?>
        <header class="post-header">
            <?php get_template_part('loop/loop-image');?>
        </header>
    <?php endif;?>
    <div class="post-inner">
        <?php get_template_part('single/content','meta');?>
       <?php
           the_content();
           wp_link_pages( );
           the_tags(st_get_language('tags:'));
           edit_post_link(st_get_language('edit_this_post'), '<p>', '</p>');
       ?>
    </div>
</article>