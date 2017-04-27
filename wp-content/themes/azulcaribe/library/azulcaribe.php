<?php
/**
 * Registers and enqueues all the styles and scripts
 *
 * @return void
 */
function azulcaribe_scripts_and_styles() {
	// Register styles.
	wp_register_style( 'azulcaribe-materialize-css', '//cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css', array(), '', 'all' );
	wp_register_style( 'azulcaribe-material-icons', '//fonts.googleapis.com/icon?family=Material+Icons', array(), '', 'all' );

	// Register scripts.
	wp_register_script( 'azulcaribe-materialize-js', '//cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js', array( 'jquery' ) );

	// Enqueue styles.
	wp_enqueue_style( 'azulcaribe-materialize-css' );
	wp_enqueue_style( 'azulcaribe-material-icons' );

	// Enqueue scripts.
	wp_enqueue_script( 'azulcaribe-materialize-js' );
}

/**
 * This function contains all the setup required to run materialize DOM init.
 *
 * @return void
 */
function azulcaribe_dom_init() {
	wp_register_script( 'azulcaribe-home-js-init', get_template_directory_uri() . '/library/dom-init/home.js', array( 'jquery' ) );
	wp_enqueue_script( 'azulcaribe-home-js-init' );
}
