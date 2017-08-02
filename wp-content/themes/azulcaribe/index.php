<?php get_header(); ?>

	<div class="main-container">
		<div class="slider">
			<ul class="slides">
			<li>
				<img src="http://tinyurl.com/nxyjo6m"> <!-- random image -->
				<div class="caption center-align">
				<h3>Bienvenidos a Azul Caribe</h3>
				<h5 class="light grey-text text-lighten-3">El mejor lugar en México para adquirir tu outfit de playa</h5>
				</div>
			</li>
			<li>
				<img src="http://tinyurl.com/l7r4u7v"> <!-- random image -->
				<div class="caption left-align">
				<h3>Presentes en varios países</h3>
				<h5 class="light grey-text text-lighten-3">Envíos a toda Latinoamérica y E.U.A.</h5>
				</div>
			</li>
			<li>
				<img src="http://tinyurl.com/l9weddp"> <!-- random image -->
				<div class="caption right-align">
				<h3>¿Vacaciones en la playa?</h3>
				<h5 class="light grey-text text-lighten-3">Azul Caribe es tu mejor opción en outfits</h5>
				</div>
			</li>
			<li>
				<img src="http://tinyurl.com/lomuyzb"> <!-- random image -->
				<div class="caption center-align">
				<h3>Descúbrenos</h3>
				<h5 class="light grey-text text-lighten-3">La mejor variedad y la más alta calidad</h5>
				</div>
			</li>
			</ul>
		</div>

		<!-- Product categories -->
		<div class="row section">
			<h3>Nuestros productos</h3>
			<div class="col s12 m6 l4">
				<div class="card small">
					<div class="card-image">
						<img src="<?php echo esc_html( get_template_directory_uri() ) . '/library/images/bikini-verde.jpg'; ?>">
						<span class="card-title">Bikinis</span>
					</div>
					<div class="card-action">
						<a href="<?php echo esc_html( get_post_type_archive_link( 'bikini' ) ); ?>">Ver todo</a>
					</div>
				</div>
			</div>

			<div class="col s12 m6 l4">
				<div class="card small">
					<div class="card-image">
						<img src="<?php echo esc_html( get_template_directory_uri() ) . '/library/images/lentes.jpg'; ?>">
						<span class="card-title">Lentes</span>
					</div>
					<div class="card-action">
							<a href="<?php echo esc_html( get_post_type_archive_link( 'lentes' ) ); ?>">Ver todo</a>
					</div>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card small">
					<div class="card-image">
						<img src="<?php echo esc_html( get_template_directory_uri() ) . '/library/images/inflable.jpg'; ?>">
						<span class="card-title">Inflables</span>
					</div>
					<div class="card-action">
						<a href="<?php echo esc_html( get_post_type_archive_link( 'inflable' ) ); ?>">Ver todo</a>
					</div>
				</div>
			</div>

			<div class="col s12 m6 l4">
				<div class="card small">
					<div class="card-image">
						<img src="<?php echo esc_html( get_template_directory_uri() ) . '/library/images/manta.jpg'; ?>">
						<span class="card-title">Mantas</span>
					</div>
					<div class="card-action">
						<a href="<?php echo esc_html( get_post_type_archive_link( 'mantita' ) ); ?>">Ver todo</a>
					</div>
				</div>
			</div>

			<div class="col s12 m6 l4">
				<div class="card small">
					<div class="card-image">
						<img src="<?php echo esc_html( get_template_directory_uri() ) . '/library/images/sombrero.jpg'; ?>">
						<span class="card-title">Sombreros</span>
					</div>
					<div class="card-action">
						<a href="<?php echo esc_html( get_post_type_archive_link( 'sombrero' ) ); ?>">Ver todo</a>
					</div>
				</div>
			</div>
			
			<div class="col s12 m6 l4">
				<div class="card small">
					<div class="card-image">
						<img src="<?php echo esc_html( get_template_directory_uri() ) . '/library/images/bolso-pina.jpg'; ?>">
						<span class="card-title">Bolsas</span>
					</div>
					<div class="card-action">
						<a href="<?php echo esc_html( get_post_type_archive_link( 'bolsas' ) ); ?>">Ver todo</a>
					</div>
				</div>
			</div>
			<!--<div class="col s12 m6 l4 offset-m3 offset-l4">
				<div class="card small">
					<div class="card-image">
						<img src="https://tinyurl.com/l4ffhxn">
						<span class="card-title">Accesorios</span>
					</div>
					<div class="card-action">
						<a href="<?php echo esc_html( get_post_type_archive_link( 'accesorio' ) ); ?>">Ver todo</a>
					</div>
				</div>
			</div>-->
		</div>
		<!-- /Product categories -->

		<!--Parallax section-->
		<div class="parallax-container">
				<div class="within-parallax">
						<h3>El outfit perfecto para tus vacaciones</h3>
						<h5 class="light grey-text text-lighten-3">Los mejores productos, al mejor precio.</h5>
				</div>
				<div class="parallax">
						<img src="<?php echo esc_html( get_template_directory_uri() ) . '/library/images/beach-parallax.jpg'; ?>">
				</div>
		</div>
		<!--/Parallax section-->

		<!--Highlighted products-->
		<div class="row section">
			<h3>Productos destacados</h3>
		</div>
		<!--/Highlighted products-->

		<!--New products-->
		<div class="row section">
			<h3>Lo más nuevo</h3>
		</div>
		<!--/New products-->

	</div>
</div>

<?php get_footer(); ?>
