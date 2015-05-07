<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Loop content blog
 *
 * Created by ShineTheme
 *
 */
?>
<div <?php  post_class('article post') ?> >
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
    <div class="post-desciption">
        <?php the_excerpt()?>
    </div>
    <a class="btn btn-small btn-primary" href="<?php the_permalink()?>"><?php st_the_language('read_more')?></a>
</div>
</div>