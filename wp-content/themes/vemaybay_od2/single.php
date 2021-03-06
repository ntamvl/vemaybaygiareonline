<?php get_header(); ?>

	<div class="col-md-9 single">

		<div class="col-md-9 single-in">

			<?php if (have_posts()) :?><?php while(have_posts()) : the_post(); ?>

				<?php $video = get_post_meta($post->ID, 'fullby_video', true );

				if($video != '') {?>

					<div class="videoWrapper">

					 	<div class='video-container'><iframe title='YouTube video player' width='400' height='275' src='http://www.youtube.com/embed/<?php echo $video; ?>' frameborder='0' allowfullscreen></iframe></div>

					</div>

				<?php

             	} else if ( has_post_thumbnail() ) { ?>

                    <?php the_post_thumbnail('single', array('class' => 'sing-cop')); ?>

                <?php } else { ?>

                	<div class="row spacer-sing"> </div>

                <?php }  ?>


				<div class="sing-tit-cont">
					<h2 class="cat"><?php the_category(','); ?></h2>

					<h1 class="sing-tit"><?php the_title(); ?></h1>

					<p class="meta">

						<i class="fa fa-clock-o"></i> <?php the_time('d/m/Y') ?>  &nbsp;
						<span class="post-view">
							<i class="fa fa-eye"></i>
							<?php echo get_post_meta( get_the_ID(), 'wpb_post_views_count', true ); ?> lượt xem</span>
						<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>

						<?php
						$video = get_post_meta($post->ID, 'fullby_video', true );

						if($video != '') { ?>

		             		<i class="fa fa-video-camera"></i> Video

		             	<?php } else if (strpos($post->post_content,'[gallery') !== false) { ?>

		             		<i class="fa fa-th"></i> Gallery

	             		<?php } else {?>

	             		<?php } ?>

					</p>

				</div>

				<div class="sing-cont">

					<div class="sing-spacer">

						<?php the_content('Leggi...');?>

						<?php
							// $args = array('name' => 'thong-tin-dat-ve-may-bay-gia-re', 'post_type' => 'page');
							// $posts_from_slug = get_posts( $args );
							// echo $posts_from_slug[0]->post_content;
							$page_data = get_page_by_path('thong-tin-dat-ve-may-bay-gia-re');

							function remove_filters_kk_rating( $hook = '' ) {
							    global $wp_filter;
							    if( empty( $hook ) || !isset( $wp_filter[$hook] ) )
							        return;

					      	foreach ($wp_filter[$hook] as $key_filter) {
					      		foreach ($key_filter as $key => $value) {
								    	if (strpos($key,'filter') !== false) {
												remove_filter( 'the_content', $key );
								    	}
								    }
					      	}

							}
							remove_filters_kk_rating( 'the_content' );

							echo apply_filters('the_content', $page_data->post_content);

					 	?>

						<?php wp_link_pages('pagelink=Page %'); ?>

						<p>
							<?php $post_tags = wp_get_post_tags($post->ID); if(!empty($post_tags)) {?>
								<span class="tag"> <i class="fa fa-tag"></i> <?php the_tags('', ', ', ''); ?> </span>
							<?php } ?>
						</p>

						<hr />

						<div id="comments" class="hide">

							<?php //comments_template(); ?>

						</div>

					</div>

				</div>

			<?php endwhile; ?>
	        <?php else : ?>

	                <p>Sorry, no posts matched your criteria.</p>

	        <?php endif; ?>

		</div>

		<div class="col-md-3">

			<div class="sec-sidebar">

				<?php get_sidebar( 'secondary' ); ?>

		    </div>

		 </div>

	</div>

	<div class="col-md-3 sidebar">

		<?php get_sidebar( 'primary' ); ?>

	</div>

<?php get_footer(); ?>
