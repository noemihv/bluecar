<?php get_header(); ?>
			<?php echo 'ESTE ES EL INDEX'; ?>
<div id="content" >
	<div id="inner-content" class="wrap cf">
		<main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<?php //if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php //post_class( 'cf' ); ?> role="article">
				<header class="article-header">
				<h1 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php //the_title(); ?></a></h1>
					<p class="byline entry-meta vcard">
                    	<?php //printf( __( 'Posted', 'bonestheme' ).' %1$s %2$s',
							/* the time the post was published *///'<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>',
							/* the author of the post *///'<span class="by">'.__( 'by', 'bonestheme').'</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link( get_the_author_meta( 'ID' ) ) . '</span>'
                    	//); ?>
					</p>
				</header>

				<section class="entry-content cf">
					<?php //the_content(); ?>
				</section>
				</article>

			<?php //endwhile; ?>
			<?php //else : ?>
				<article id="post-not-found" class="hentry cf">
					<header class="article-header">
						<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
					</section>
				</article>
			<?php //endif; ?>

	<div class="slider">
		<ul class="slides">
		<li>
			<img src="http://lorempixel.com/580/250/nature/1"> <!-- random image -->
			<div class="caption center-align">
			<h3>This is our big Tagline!</h3>
			<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
			</div>
		</li>
		<li>
			<img src="http://lorempixel.com/580/250/nature/2"> <!-- random image -->
			<div class="caption left-align">
			<h3>Left Aligned Caption</h3>
			<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
			</div>
		</li>
		<li>
			<img src="http://lorempixel.com/580/250/nature/3"> <!-- random image -->
			<div class="caption right-align">
			<h3>Right Aligned Caption</h3>
			<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
			</div>
		</li>
		<li>
			<img src="http://lorempixel.com/580/250/nature/4"> <!-- random image -->
			<div class="caption center-align">
			<h3>This is our big Tagline!</h3>
			<h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
			</div>
		</li>
		</ul>
	</div>

	<a href="<?php echo get_post_type_archive_link( 'inflable' ); ?>">ARCHIVO DE INFLABLES</a>
	<a href="<?php echo get_post_type_archive_link( 'mantita' ); ?>">ARCHIVO DE MANTITAS</a>
	<a href="<?php echo get_post_type_archive_link( 'sombrero' ); ?>">ARCHIVO DE SOMBREROS</a>
	<a href="<?php echo get_post_type_archive_link( 'bolsas' ); ?>">ARCHIVO DE BOLSAS</a>
	<a href="<?php echo get_post_type_archive_link( 'accesorio' ); ?>">ARCHIVO DE ACCESORIOS</a>

	<!-- Product categories -->
	<div class="row">
		<div class="col s12 m4">
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
		<div class="col s12 m4">
			<div class="card">
				<div class="card-image">
					<img src="http://lorempixel.com/250/250/nature/2">
					<span class="card-title">Card Title</span>
				</div>
				<div class="card-content">
					<p>I am a very simple card. I am good at containing small bits of information.
					I am convenient because I require little markup to use effectively.</p>
				</div>
				<div class="card-action">
						<a href="<?php echo get_post_type_archive_link( 'lentes' ); ?>"></a>

				</div>
			</div>
		</div>
		<div class="col s12 m4">
			<div class="card">
				<div class="card-image">
					<img src="http://lorempixel.com/250/250/nature/3">
					<span class="card-title">Card Title</span>
				</div>
				<div class="card-content">
					<p>I am a very simple card. I am good at containing small bits of information.
					I am convenient because I require little markup to use effectively.</p>
				</div>
				<div class="card-action">
					<a href="#">This is a link</a>
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
