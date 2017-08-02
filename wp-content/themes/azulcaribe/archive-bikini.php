<?php
/*
 * CUSTOM POST TYPE ARCHIVE TEMPLATE
*/
?>

<?php get_header(); ?>
<div class="main-container">

	<!--<div id="inner-content" class="wrap cf">-->

		<!--<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">-->

			<div class="row section">
				<h3><?php post_type_archive_title(); ?></h1>
				<?php
					$args = array(
						'post_type' => 'bikini',
						'posts_per_page' => 10,
					);

					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
				?>
						<div class="col s6 m4 l3">
								<div class="archive-single-product-content">
									<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
										<?php the_post_thumbnail() ?>
										<?php esc_html( the_title() ); ?>
									</a>
									<p><?php esc_html( the_excerpt() ); ?></p>
									
									<?php
									// get post meta
									$metadata = get_post_meta( $post->ID );
									$price = isset( $metadata['price'] ) ? $metadata['price'][0] : null;
									$price_as_str = isset( $price ) ? '$' . $price : 'No disponible';
									?>
									
									<p>PRECIO: <?php echo esc_html( $price_as_str ); ?></p>
								</div>
						</div>

				<?php
					endwhile;
				?>
			</div>
		<!--</main>-->
	<!--</div>-->
</div>

<?php get_footer(); ?>
