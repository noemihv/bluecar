<?php
/*
 * CUSTOM POST TYPE ARCHIVE TEMPLATE
*/
?>

<?php get_header(); ?>
<!-- Modal for products preview -->
<div id="modal1" class="modal">
	<div class="modal-content">
		<h4 class="product-title">Producto</h4>
		<p>A bunch of text</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
	</div>
</div>
<!-- /Modal for products preview -->
<div class="main-container">

	<div class="row section">
		<h3><?php post_type_archive_title(); ?></h1>
		<?php
			$args = array(
				'post_type' => 'bikini',
				'posts_per_page' => 10,
			);

			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
				// get post meta.
				$metadata = get_post_meta( $post->ID );
				$price = isset( $metadata['price'] ) ? $metadata['price'][0] : null;
				$price_as_str = ( isset( $price ) && ( $price > 0 ) ) ? '$' . $price : 'Precio no disponible';
		?>
				<div class="col s6 m4 l3">
						<div class="archive-single-product-content" >
							<img class="product-archive-img" src="<?php echo esc_html( the_post_thumbnail_url() ); ?>" alt="<?php echo esc_html( the_title() ); ?>">
							<div 
									class="fast-view-chip pink darken-1"
									modal-title="<?php echo esc_html( the_title() ); ?>" 
									modal-img="<?php echo esc_html( the_post_thumbnail_url() ); ?>"
									modal-description="<?php echo esc_html( get_the_excerpt() ); ?>"
									modal-permalink="<?php echo esc_html( the_permalink() ); ?>"
							>
								<p class="center-align fast-view-chip-p">Vista rápida</p>
							</div>
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
								<?php esc_html( the_title() ); ?>
							</a>
							<p><?php echo esc_html( $price_as_str ); ?></p>
							<?php
							$sizes = isset( $metadata['sizes'] ) ? explode( ',', $metadata['sizes'][0] ) : null;
							$inventory = isset( $metadata['inventory'] ) ? $metadata['inventory'][0] : 0;
							?>
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
