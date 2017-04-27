<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
	<meta charset="utf-8">

	<?php // force Internet Explorer to use the latest rendering engine available. ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php wp_title( '' ); ?></title>

	<?php // mobile meta (hooray!). ?>
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/). ?>
	<link rel="apple-touch-icon" href="<?php echo esc_html( get_template_directory_uri() ); ?>/library/images/azulcaribe.jpg">
	<link rel="icon" href="<?php echo esc_html( get_template_directory_uri() ); ?>/favicon.png">
	<!--[if IE]>
		<link rel="shortcut icon" href="<?php echo esc_html( get_template_directory_uri() ); ?>/favicon.ico">
	<![endif]-->
	<?php // or, set /favicon.ico for IE10 win. ?>
	<meta name="msapplication-TileColor" content="#f01d4f">
	<meta name="msapplication-TileImage" content="<?php echo esc_html( get_template_directory_uri() ); ?>/library/images/win8-tile-icon.png">
		<meta name="theme-color" content="#121212">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php // wordpress head functions. ?>
	<?php wp_head(); ?>
	<?php // end of wordpress head. ?>

	<?php // drop Google Analytics Here. ?>
	<?php // end analytics. ?>

</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

	<div id="container">

		<header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

			<div id="inner-header" class="wrap cf">
			</div>
		</header>
		<nav>
			<div class="nav-wrapper">
			<a href="#!" class="brand-logo">Logo</a>
			<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
			<ul class="right hide-on-med-and-down">
				<li><a href="sass.html">Sass</a></li>
				<li><a href="badges.html">Components</a></li>
				<li><a href="collapsible.html">Javascript</a></li>
				<li><a href="mobile.html">Mobile</a></li>
			</ul>
			<ul class="side-nav" id="mobile-demo">
				<li><a href="sass.html">Sass</a></li>
				<li><a href="badges.html">Components</a></li>
				<li><a href="collapsible.html">Javascript</a></li>
				<li><a href="mobile.html">Mobile</a></li>
			</ul>
			</div>
		</nav>
