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
	<header class="header" id="header">
		<img src="<?php echo esc_html( get_template_directory_uri() ) . '/library/images/azulcaribe.jpg'; ?>" class="logo" alt="">
		<!--<img src="menu-hamburger2.svg" class="menu-hamburger" alt="">-->

		<svg class="menu-hamburger" id="menu-hamburger-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 32 22.5" enable-background="new 0 0 32 22.5" xml:space="preserve">
			<title>Mobile Menu</title>
			<g class="svg-menu-toggle">
				<path class="bar" d="M20.945,8.75c0,0.69-0.5,1.25-1.117,1.25H3.141c-0.617,0-1.118-0.56-1.118-1.25l0,0
					c0-0.69,0.5-1.25,1.118-1.25h16.688C20.445,7.5,20.945,8.06,20.945,8.75L20.945,8.75z">
				</path>
				<path class="bar" d="M20.923,15c0,0.689-0.501,1.25-1.118,1.25H3.118C2.5,16.25,2,15.689,2,15l0,0c0-0.689,0.5-1.25,1.118-1.25 h16.687C20.422,13.75,20.923,14.311,20.923,15L20.923,15z">
				</path>
				<path class="bar" d="M20.969,21.25c0,0.689-0.5,1.25-1.117,1.25H3.164c-0.617,0-1.118-0.561-1.118-1.25l0,0
					c0-0.689,0.5-1.25,1.118-1.25h16.688C20.469,20,20.969,20.561,20.969,21.25L20.969,21.25z">
				</path>
				<!-- needs to be here as a 'hit area' -->
				<rect width="60px" height="60px" fill="none"></rect>
			</g>
		</svg>

		<div class="main-menu" mobile-hidden="true">
			<ul class="main-menu-ul">
				<li class="main-menu-li"><a class="main-menu-a" href="#">Link0</a></li>
				<li class="main-menu-li"><a class="main-menu-a" href="#">Link1</a></li>
				<li class="main-menu-li"><a class="main-menu-a" href="#">Link2</a></li>
				<li class="main-menu-li"><a class="main-menu-a" href="#">Link3</a></li>
				<li class="main-menu-li"><a class="main-menu-a" href="#">Link4</a></li>
				<li class="main-menu-dropdown">
					<label class="main-menu-a">Dropdown</label>
					<ul class="main-menu-li-ul">
						<li class="main-menu-li-ul-li"><a href="" class="main-menu-li-ul-li-a">Sublink</a></li>
						<li class="main-menu-li-ul-li"><a href="" class="main-menu-li-ul-li-a">Sublink</a></li>
						<li class="main-menu-li-ul-li"><a href="" class="main-menu-li-ul-li-a">Sublink</a></li>
						<li class="main-menu-li-ul-li"><a href="" class="main-menu-li-ul-li-a">Sublink</a></li>
					</ul>
				</li>
				<li class="main-menu-li"><a class="main-menu-a" href="#">Link5</a></li>
				<li class="main-menu-li"><a class="main-menu-a" href="#">Link6</a></li>
				<li class="main-menu-dropdown">
					<label class="main-menu-a">Dropdown</label>
					<ul class="main-menu-li-ul">
						<li class="main-menu-li-ul-li"><a href="" class="main-menu-li-ul-li-a">Sublink</a></li>
						<li class="main-menu-li-ul-li"><a href="" class="main-menu-li-ul-li-a">Sublink</a></li>
						<li class="main-menu-li-ul-li"><a href="" class="main-menu-li-ul-li-a">Sublink</a></li>
						<li class="main-menu-li-ul-li"><a href="" class="main-menu-li-ul-li-a">Sublink</a></li>
					</ul>
				</li>
				<li class="main-menu-li"><a class="main-menu-a" href="#">Link7</a></li>
				<li class="main-menu-li"><a class="main-menu-a" href="#">Link8</a></li>
			</ul>
		</div>
	</header>

<!--<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">-->
<!--
	<div id="container">
-->
