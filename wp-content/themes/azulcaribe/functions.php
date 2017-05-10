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
}
add_action( 'after_setup_theme', 'azulcaribe_init' );

function azulcaribe_custom_post_type()
{
    register_post_type('azulcaribe_productos',
                       [
                           'labels'      => [
                               'name'          => __('Productos'),
                               'singular_name' => __('Producto'),
                               'search_items'      => __( 'Buscar producto', 'textdomain' ),
		                       'all_items'         => __( 'Todos los productos', 'textdomain' ),
		                       'parent_item'       => __( 'Parent product', 'textdomain' ),
		                       'parent_item_colon' => __( 'Parent product:', 'textdomain' ),
		                       'edit_item'         => __( 'Editar producto', 'textdomain' ),
		                       'update_item'       => __( 'Actualizar Bikini', 'textdomain' ),
		                       'add_new_item'      => __( 'Add New Bikini', 'textdomain' ),
		                       'new_item_name'     => __( 'New Bikini Name', 'textdomain' ),
		                       'menu_name'         => __( 'Bikini', 'textdomain' ),
                           ],
                           'public'      => true,
                           'has_archive' => true,
                           'menu_position' => 5,
                       ]
    );
}
add_action('init', 'azulcaribe_custom_post_type');

function create_products_taxonomies() {
  $labels = array(
		'name'              => _x( 'Bikinis', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Bikini', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Bikini', 'textdomain' ),
		'all_items'         => __( 'All Bikinis', 'textdomain' ),
		'parent_item'       => __( 'Parent Bikini', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Bikini:', 'textdomain' ),
		'edit_item'         => __( 'Edit Bikini', 'textdomain' ),
		'update_item'       => __( 'Update Bikini', 'textdomain' ),
		'add_new_item'      => __( 'Add New Bikini', 'textdomain' ),
		'new_item_name'     => __( 'New Bikini Name', 'textdomain' ),
		'menu_name'         => __( 'Bikini', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'bikini' ),
	);

  register_taxonomy( 'Bikini', 'azulcaribe_productos', $args );
}

add_action( 'init', 'create_products_taxonomies', 0 );
