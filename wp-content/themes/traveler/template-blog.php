<?php
/*
Template Name: Blog
*/
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Template Name : Blog
 *
 * Created by ShineTheme
 *
 */
get_header();
?>
    <div class="container">
        <h1 class="page-title"><?php the_title() ?></h1>
    </div>
    <div class="container">
        <div class="row">
            <?php
            $sidebar_pos=apply_filters('st_blog_sidebar','right');
            if($sidebar_pos=="left"){
                get_sidebar('blog');
            }
            ?>
            <div class="<?php echo apply_filters('st_blog_sidebar','right')=='no'?'col-sm-12':'col-sm-9'; ?>">
                <?php
                $query=array(
                    'post_type' => 'post',
                );
                query_posts($query);
                if(have_posts()):
                    while(have_posts())
                    {
                        the_post();
                        get_template_part('content','loop');
                    }
                    TravelHelper::paging();
                else:
                    get_template_part('content','none');
                endif;
                wp_reset_query();
                ?>
            </div>
            <?php $sidebar_pos=apply_filters('st_blog_sidebar','right');
            if($sidebar_pos=="right"){
                get_sidebar('blog');
            }
            ?>
        </div>
    </div>
<?php
    get_footer();
?>