<?php
/**
 * This file contains all the functions to setup the WP site.
 */

require_once( 'library/azulcaribe.php' );

/**
 * Contains all the setup steps for Azulcaribe theme.
 *
 * @return void
 */
function azulcaribe_init() {
	add_action( 'wp_enqueue_scripts', 'azulcaribe_scripts_and_styles', 999 );
	add_action( 'wp_enqueue_scripts', 'azulcaribe_dom_init', 999 );
	add_action( 'wp_enqueue_scripts', 'azulcaribe_menu', 999 );
	add_action( 'wp_enqueue_scripts', 'azulcaribe_headroom', 999 );

	// add support for several features in WP admin.
	azulcaribe_theme_support();
}
add_action( 'after_setup_theme', 'azulcaribe_init' );
