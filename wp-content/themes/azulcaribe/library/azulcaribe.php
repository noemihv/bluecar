<?php
/**
 * Registers and enqueues all the styles and scripts
 *
 * @return void
 */
function azulcaribe_admin_scripts_and_styles () {
	wp_register_script( 'azulcaribe-bikinis-js', get_template_directory_uri() . '/library/js/cpts-init/bikinis.js', array( 'jquery' ) );
	wp_enqueue_script( 'azulcaribe-bikinis-js' );
}

function azulcaribe_scripts_and_styles() {
	// Register styles.
	wp_register_style( 'azulcaribe-materialize-css', '//cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css', array(), '', 'all' );
	wp_register_style( 'azulcaribe-material-icons', '//fonts.googleapis.com/icon?family=Material+Icons', array(), '', 'all' );
	wp_register_style( 'azulcaribe-own', get_stylesheet_directory_uri() . '/library/css/style.css', array(), 'all' );

	// Register scripts.
	wp_register_script( 'azulcaribe-materialize-js', '//cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js', array( 'jquery' ) );
	wp_register_script( 'azulcaribe-fontawesome-js', 'https://use.fontawesome.com/a474d294a6.js', array() );

	// Enqueue styles.
	wp_enqueue_style( 'azulcaribe-materialize-css' );
	wp_enqueue_style( 'azulcaribe-material-icons' );
	wp_enqueue_style( 'azulcaribe-own' );

	// Enqueue scripts.
	wp_enqueue_script( 'azulcaribe-materialize-js' );
	wp_enqueue_script( 'azulcaribe-fontawesome-js' );
}

/**
 * This function contains all the setup required to run materialize DOM init.
 *
 * @return void
 */
function azulcaribe_dom_init() {
	wp_register_script( 'azulcaribe-home-js-init', get_template_directory_uri() . '/library/js/dom-init/home.js', array( 'jquery' ) );
	wp_enqueue_script( 'azulcaribe-home-js-init' );

	// enqueue script for bikini archive.
	if ( is_post_type_archive( 'bikini' ) ) {
		wp_register_script( 'azulcaribe-archive-bikini-js-init', get_template_directory_uri() . '/library/js/dom-init/archive-bikini.js', array( 'jquery' ) );
		wp_enqueue_script( 'azulcaribe-archive-bikini-js-init' );
	}
}

/**
 * This function enqueues the JS related to menu animation
 *
 * @return void
 */
function azulcaribe_menu() {
	wp_register_script( 'azulcaribe-menu-js', get_template_directory_uri() . '/library/js/menu/menu.js', array( 'jquery' ) );
	wp_enqueue_script( 'azulcaribe-menu-js' );
}

/**
 * This function will enqueue the Headroom minified script from the vendor folder
 *
 * @return void
 */
function azulcaribe_headroom() {
	wp_register_script( 'azulcaribe-headroom-js', get_template_directory_uri() . '/library/js/vendor/headroom.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'azulcaribe-headroom-js' );
}

/**
 * Add several WP support features for Azulcaribe theme.
 *
 * @return void
 */
function azulcaribe_theme_support() {

	// wp thumbnails (sizes handled in functions.php).
	add_theme_support( 'post-thumbnails' );

	// wp custom background (thx to @bransonwerner for update).
	add_theme_support(
		'custom-background',
		array(
		'default-image' => '',    // background image default.
		'default-color' => '',    // background color default (dont add the #).
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => '',
		)
	);

	// rss thingy.
	add_theme_support( 'automatic-feed-links' );

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/.
	// adding post format support.
	add_theme_support(
		'post-formats',
		array(
			'aside',             // title less blurb.
			'gallery',           // gallery of images.
			'link',              // quick link to other site.
			'image',             // an image.
			'quote',             // a quick quote.
			'status',            // a Facebook like status update.
			'video',             // video.
			'audio',             // audio.
			'chat',              // chat transcript.
		)
	);

	// wp menus.
	add_theme_support( 'menus' );

	// registering wp3+ menus.
	register_nav_menus(array(
			'top-bar-nav'   => __( 'Top Bar Menu', 'bonestheme' ),    // top bar in header
			'main-nav'      => __( 'The Main Menu', 'bonestheme' ),   // main nav in header
			'footer-links'  => __( 'Footer Links', 'bonestheme' ),    // secondary nav in footer
	));

	// Enable support for HTML5 markup.
	add_theme_support('html5', array(
		'comment-list',
		'search-form',
		'comment-form',
	));
} /* end azulcaribe theme support */
