<?php
/*
 * CUSTOM POST TYPE ARCHIVE TEMPLATE
*/
?>

<?php get_header(); ?>
			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
						<div class="row">
							<?php $args = array( 'post_type' => 'bikini', 'posts_per_page' => 10 );
								  $loop = new WP_Query( $args );
								  while ( $loop->have_posts() ) : $loop->the_post();
  							?>
									<div class="col s12 m6 l3">
  								    <div class="entry-content">
  										<?php echo esc_html(the_content()); ?>
  								    </div>
								    	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php esc_html(the_title()); ?></a>
								    </div>

							    <?php
									endwhile;
								?>
						</div>
					</main>
				</div>
			</div>

<?php get_footer(); ?>