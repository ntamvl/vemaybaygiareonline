	<div class="row">
		<div class="col-sm-12 col-md-12 hotline">
			<h2>Hotline đặt vé máy bay giá rẻ </h2>
			<p><strong class="highlight">(08) 730-50-500</strong>, <strong>(08) 730-50-181, (08) 730-50-182, (08) 730-50-183</strong><br>
			Di Động: <strong class="highlight">0902 98 53 55</strong></p>
		</div>
	</div>

	<!-- <div class="social">
		<a href=""><i class="fa fa-facebook fa-2x"></i></a>
		<a href=""><i class="fa fa-twitter fa-2x"></i></a>
		<a href=""><i class="fa fa-pinterest fa-2x"></i></a>
		<a href=""><i class="fa fa-instagram fa-2x"></i></a>
		<a href=""><i class="fa fa-linkedin fa-2x"></i></a>
		<a href=""><i class="fa fa-youtube fa-2x"></i></a>
	</div> -->

	<?php if (!is_home()) { ?>
	<div style="clear: both;"></div>
	<div class="col-sm-12 col-md-12 bordered">
		<?php get_template_part( 'search-box-sidebar' ); ?>
		<br/>
  </div>
  <?php } ?>

	<div class="tab-spacer">

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" id="myTab">

			<li class="active"><a href="#home" data-toggle="tab"> <i class="fa fa-bolt"></i> Tin khuyến mãi</a></li>
			<li><a href="#profile" data-toggle="tab"> <i class="fa fa-clock-o"></i> Tin mới nhất</a></li>

		</ul>

		<!-- Tab panes -->
		<div class="tab-content">

			<div class="tab-pane fade in active" id="home">

				<?php // POPULAR POST
				$popularpost = new WP_Query( array( 'posts_per_page' => 4, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );
				while ( $popularpost->have_posts() ) : $popularpost->the_post();?>

				<a href="<?php the_permalink(); ?>">

					<?php $video = get_post_meta($post->ID, 'fullby_video', true );

					if($video != '') {?>

						<img src="http://img.youtube.com/vi/<?php echo $video ?>/1.jpg" class="grid-cop"/>

					<?php

	             	} else if ( has_post_thumbnail() ) { ?>

	                    <?php the_post_thumbnail('thumbnail', array('class' => 'thumbnail')); ?>

	                <?php } ?>

		    		<h2 class="title"><?php the_title(); ?></h2>

		    		<div class="date"><i class="fa fa-clock-o"></i> <?php the_time('d/m/Y') ?> &nbsp;

						<?php
						$video = get_post_meta($post->ID, 'fullby_video', true );

						if($video != '') { ?>

		             		<i class="fa fa-video-camera"></i> Video

		             	<?php } else if (strpos($post->post_content,'[gallery') !== false) { ?>

		             		<i class="fa fa-th"></i> Gallery

	             		<?php } else {?>

	             		<?php } ?>

		    		</div>

		    	</a>

				<?php endwhile; ?>

			</div>

			<div class="tab-pane fade" id="profile">

		  		<?php
				$popularpost = new WP_Query( array( 'posts_per_page' => 4) );
				while ( $popularpost->have_posts() ) : $popularpost->the_post();?>

					<a href="<?php the_permalink(); ?>">

						<?php $video = get_post_meta($post->ID, 'fullby_video', true );

						if($video != '') {?>

							<img src="http://img.youtube.com/vi/<?php echo $video ?>/1.jpg" class="grid-cop"/>

						<?php

		             	} else if ( has_post_thumbnail() ) { ?>

	                        <?php the_post_thumbnail('thumbnail', array('class' => 'thumbnail')); ?>

	                    <?php } ?>

			    		<h2 class="title"><?php the_title(); ?></h2>

			    		<div class="date"><i class="fa fa-clock-o"></i> <?php the_time('d/m/Y') ?> &nbsp;

							<?php
							$video = get_post_meta($post->ID, 'fullby_video', true );

							if($video != '') { ?>

			             		<i class="fa fa-video-camera"></i> Video

			             	<?php } else if (strpos($post->post_content,'[gallery') !== false) { ?>

			             		<i class="fa fa-th"></i> Gallery

		             		<?php } else {?>

		             		<?php } ?>

			    		</div>

			    	</a>

				<?php endwhile; ?>

			</div>

		</div>

	</div>

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Primary Sidebar') ) : ?>

	<?php endif; ?>