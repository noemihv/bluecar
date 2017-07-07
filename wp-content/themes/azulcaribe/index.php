<?php get_header(); ?>

	<div class="slider">
		<ul class="slides">
		<li>
			<img src="http://tinyurl.com/nxyjo6m"> <!-- random image -->
			<div class="caption center-align">
			<h3>Bienvenidos a Azul caribe</h3>
			<h5 class="light grey-text text-lighten-3">El mejor lugar en México para adquirir tu outfit de playa</h5>
			</div>
		</li>
		<li>
			<img src="http://tinyurl.com/l7r4u7v"> <!-- random image -->
			<div class="caption left-align">
			<h3>Recibimos tus pedidos vía mensaje o WhatsApp: 3319612855</h3>
			<h5 class="light grey-text text-lighten-3">Envíos a toda latinoamérica y E.U.A.</h5>
			</div>
		</li>
		<li>
			<img src="http://tinyurl.com/l9weddp"> <!-- random image -->
			<div class="caption right-align">
			<h3>"Excelente servicio, respuesta inmediata y la entrega fue muy rápida. Muy recomendable comprar Aquí."</h3>
			<h5 class="light grey-text text-lighten-3">Maricarmen Khalaf.</h5>
			</div>
		</li>
		<li>
			<img src="http://tinyurl.com/lomuyzb"> <!-- random image -->
			<div class="caption center-align">
			<h3>Búscanos también en nuestras redes sociales y correo electrónico</h3>
			<h5 class="light grey-text text-lighten-3">Instagram y Facebook:@azulcaribemx   E-mail:azulcaribemx@gmail.com</h5>
			</div>
		</li>
		</ul>
	</div>

	<!-- Product categories -->
	<div class="row">
		<div class="col s12 m6">
			<div class="card">
				<div class="card-image">
					<img src="https://tinyurl.com/kw6rs3b">
					<span class="card-title">Bikinis</span>
				</div>
				<div class="card-content">
					<p>Toda nuestra selección de bikinis.</p>
				</div>
				<div class="card-action">
					<a href="<?php echo get_post_type_archive_link( 'bikini' ); ?>">Ir a todos los bikinis</a>
				</div>
			</div>
		</div>

		<div class="col s12 m6">
			<div class="card">
				<div class="card-image">
					<img src="https://tinyurl.com/m3wszh7">
					<span class="card-title">Lentes</span>
				</div>
				<div class="card-content">
					<p>Toda nuestra selección de lentes</p>
				</div>
				<div class="card-action">
						<a href="<?php echo get_post_type_archive_link( 'lentes' ); ?>">Ir a todos los lentes</a>
				</div>
			</div>
		</div>
		<div class="col s12 m6">
			<div class="card">
				<div class="card-image">
					<img src="http://tinyurl.com/jvpbgaf">
					<span class="card-title">Inflables</span>
				</div>
				<div class="card-content">
					<p>Toda nuestra selección de inflables</p>
				</div>
				<div class="card-action">
					<a href="<?php echo get_post_type_archive_link( 'inflable' ); ?>">Ir a todos los inflables</a>
				</div>
			</div>
		</div>

		<div class="col s12 m6">
			<div class="card">
				<div class="card-image">
					<img src="https://tinyurl.com/kswzqdm">
					<span class="card-title">Mantas</span>
				</div>
				<div class="card-content">
					<p>Toda nuestra selección de mantas.</p>
				</div>
				<div class="card-action">
					<a href="<?php echo get_post_type_archive_link( 'mantita' ); ?>">Todas las mantas</a>
				</div>
			</div>
		</div>

		<div class="col s12 m6">
			<div class="card">
				<div class="card-image">
					<img src="https://tinyurl.com/ma8yqgc">
					<span class="card-title">Sombreros</span>
				</div>
				<div class="card-content">
					<p>Toda nuestra selección de sombreros.</p>
				</div>
				<div class="card-action">
					<a href="<?php echo get_post_type_archive_link( 'sombrero' ); ?>">Todos los sombreros</a>
				</div>
			</div>
		</div>
		
		<div class="col s12 m6">
			<div class="card">
				<div class="card-image">
					<img src="https://tinyurl.com/lrnmyna">
					<span class="card-title">Bolsas</span>
				</div>
				<div class="card-content">
					<p>Toda nuestra selección de bolsas.</p>
				</div>
				<div class="card-action">
					<a href="<?php echo get_post_type_archive_link( 'bolsas' ); ?>">Todas nuestras bolsas</a>
				</div>
			</div>
		</div>
		<div class="col s12 m6">
			<div class="card">
				<div class="card-image">
					<img src="https://tinyurl.com/l4ffhxn">
					<span class="card-title">Accesorios</span>
				</div>
				<div class="card-content">
					<p>Toda nuestra selección de accesorios.</p>
				</div>
				<div class="card-action">
					<a href="<?php echo get_post_type_archive_link( 'accesorio' ); ?>">Ir a todos los accesorios</a>
				</div>
			</div>
		</div>
	</div>
	<!-- /Product categories -->

	<!-- Carousel of top products -->
	<div class="carousel">
		<a class="carousel-item" href="#one!"><img src="http://lorempixel.com/250/250/nature/1"></a>
		<a class="carousel-item" href="#two!"><img src="http://lorempixel.com/250/250/nature/2"></a>
		<a class="carousel-item" href="#three!"><img src="http://lorempixel.com/250/250/nature/3"></a>
		<a class="carousel-item" href="#four!"><img src="http://lorempixel.com/250/250/nature/4"></a>
		<a class="carousel-item" href="#five!"><img src="http://lorempixel.com/250/250/nature/5"></a>
	</div>
	<!-- /Carousel of top products -->
</div>

<?php get_footer(); ?>
