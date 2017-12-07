<?php
/**
 * This file contains all the functions to setup the WP site.
 */

require_once( 'library/azulcaribe.php' );
require_once( 'library/cpts/azulcaribe-bikini.php' );
require_once( 'library/taxonomies/custom-taxonomies.php' );

/**
 * Contains all the setup steps for Azulcaribe theme.
 *
 * @return void
 */
function azulcaribe_init() {
    add_action( 'wp_enqueue_scripts', 'azulcaribe_scripts_and_styles', 999 );
    add_action( 'admin_enqueue_scripts', 'azulcaribe_admin_scripts_and_styles', 999 );
	add_action( 'wp_enqueue_scripts', 'azulcaribe_dom_init', 999 );
	add_action( 'wp_enqueue_scripts', 'azulcaribe_menu', 999 );
	add_action( 'wp_enqueue_scripts', 'azulcaribe_headroom', 999 );

	// add support for several features in WP admin.
	azulcaribe_theme_support();
}
add_action( 'after_setup_theme', 'azulcaribe_init' );


// ------- LENTES POST TYPE -------

function azulcaribe_lentes()
{
    register_post_type('lentes',
                       [
                           'labels'      => [
                               'name'          => __('Lentes'),
                               'singular_name' => __('Lentes'),
                               'search_items'      => __( 'Buscar lentes', 'textdomain' ),
		                       'all_items'         => __( 'Todos los lentes', 'textdomain' ),
		                       'parent_item'       => __( 'Parent product', 'textdomain' ),
		                       'parent_item_colon' => __( 'Parent product:', 'textdomain' ),
		                       'edit_item'         => __( 'Editar lentes', 'textdomain' ),
		                       'update_item'       => __( 'Actualizar lentes', 'textdomain' ),
		                       'add_new_item'      => __( 'Agregar nuevos lentes', 'textdomain' ),
		                       'new_item_name'     => __( 'Nuevo nombre de lentes', 'textdomain' ),
		                       'menu_name'         => __( 'Lentes', 'textdomain' ),
                               'rewrite' => array( 'slug' => 'lentes' ),
                           ],
                           'public'      => true,
                           'has_archive' => true,
                           'menu_position' => 5,
                       ]
    );
}
add_action('init', 'azulcaribe_lentes');

// ------- /LENTES POST TYPE -------

function azulcaribe_inflable()
{
    register_post_type('inflable',
                       [
                           'labels'      => [
                               'name'          => __('Inflables'),
                               'singular_name' => __('Infable'),
                               'search_items'      => __( 'Buscar inflables', 'textdomain' ),
		                       'all_items'         => __( 'Todos los inflables', 'textdomain' ),
		                       'parent_item'       => __( 'Parent product', 'textdomain' ),
		                       'parent_item_colon' => __( 'Parent product:', 'textdomain' ),
		                       'edit_item'         => __( 'Editar inflable', 'textdomain' ),
		                       'update_item'       => __( 'Actualizar inflable', 'textdomain' ),
		                       'add_new_item'      => __( 'Agregar nuevo inflable', 'textdomain' ),
		                       'new_item_name'     => __( 'Nuevo nombre de inflable', 'textdomain' ),
		                       'menu_name'         => __( 'Inflables', 'textdomain' ),
                               'rewrite' => array( 'slug' => 'inflable' ),
                           ],
                           'public'      => true,
                           'has_archive' => true,
                           'menu_position' => 5,
                       ]
    );
}
add_action('init', 'azulcaribe_inflable');

function azulcaribe_mantita()
{
    register_post_type('mantita',
                       [
                           'labels'      => [
                               'name'          => __('Mantas de playa'),
                               'singular_name' => __('Manta de playa'),
                               'search_items'      => __( 'Buscar mantas de playa', 'textdomain' ),
		                       'all_items'         => __( 'Todas las mantas de playa', 'textdomain' ),
		                       'parent_item'       => __( 'Parent product', 'textdomain' ),
		                       'parent_item_colon' => __( 'Parent product:', 'textdomain' ),
		                       'edit_item'         => __( 'Editar manta de playa', 'textdomain' ),
		                       'update_item'       => __( 'Actualizar manta de playa', 'textdomain' ),
		                       'add_new_item'      => __( 'Agregar nuevas manta de playa', 'textdomain' ),
		                       'new_item_name'     => __( 'Nuevo nombre de manta de playa', 'textdomain' ),
		                       'menu_name'         => __( 'Mantas de playa', 'textdomain' ),
                           ],
                           'public'      => true,
                           'has_archive' => true,
                           'menu_position' => 5,
                           'rewrite' => array( 'slug' => 'mantitas' ),
                       ]
    );
}
add_action('init', 'azulcaribe_mantita');

function azulcaribe_sombrero()
{
    register_post_type('sombrero',
                       [
                           'labels'      => [
                               'name'          => __('Sombreros'),
                               'singular_name' => __('Sombrero'),
                               'search_items'      => __( 'Buscar sombreros', 'textdomain' ),
		                       'all_items'         => __( 'Todos los sombreros', 'textdomain' ),
		                       'parent_item'       => __( 'Parent product', 'textdomain' ),
		                       'parent_item_colon' => __( 'Parent product:', 'textdomain' ),
		                       'edit_item'         => __( 'Editar sombrero', 'textdomain' ),
		                       'update_item'       => __( 'Actualizar sombrero', 'textdomain' ),
		                       'add_new_item'      => __( 'Agregar sombrero', 'textdomain' ),
		                       'new_item_name'     => __( 'Nuevo nombre de sombrero', 'textdomain' ),
		                       'menu_name'         => __( 'Sombreros', 'textdomain' ),
                           ],
                           'public'      => true,
                           'has_archive' => true,
                           'menu_position' => 5,
                           'rewrite' => array( 'slug' => 'sombrero' ),
                       ]
    );
}
add_action('init', 'azulcaribe_sombrero');

function azulcaribe_bolsas()
{
    register_post_type('bolsas',
                       [
                           'labels'      => [
                               'name'          => __('Bolsas de playa'),
                               'singular_name' => __('Bolsa de playa'),
                               'search_items'      => __( 'Buscar bolsas de playa', 'textdomain' ),
		                       'all_items'         => __( 'Todas las bolsas de playa', 'textdomain' ),
		                       'parent_item'       => __( 'Parent product', 'textdomain' ),
		                       'parent_item_colon' => __( 'Parent product:', 'textdomain' ),
		                       'edit_item'         => __( 'Editar bolsa de playa', 'textdomain' ),
		                       'update_item'       => __( 'Actualizar bolsa de playa', 'textdomain' ),
		                       'add_new_item'      => __( 'Agregar bolsa de playa', 'textdomain' ),
		                       'new_item_name'     => __( 'Nuevo nombre de bolsa de playa', 'textdomain' ),
		                       'menu_name'         => __( 'Bolsas de playa', 'textdomain' ),
                           ],
                           'public'      => true,
                           'has_archive' => true,
                           'menu_position' => 5,
                           'rewrite' => array( 'slug' => 'bolsas' ),
                       ]
    );
}
add_action('init', 'azulcaribe_bolsas');

function azulcaribe_accesorio()
{
    register_post_type('accesorio',
                       [
                           'labels'      => [
                               'name'          => __('Accesorios'),
                               'singular_name' => __('Accesorio'),
                               'search_items'      => __( 'Buscar accesorios', 'textdomain' ),
		                       'all_items'         => __( 'Todos los accesorios', 'textdomain' ),
		                       'parent_item'       => __( 'Parent product', 'textdomain' ),
		                       'parent_item_colon' => __( 'Parent product:', 'textdomain' ),
		                       'edit_item'         => __( 'Editar accesorio', 'textdomain' ),
		                       'update_item'       => __( 'Actualizar accesorio', 'textdomain' ),
		                       'add_new_item'      => __( 'Agregar accesorio', 'textdomain' ),
		                       'new_item_name'     => __( 'Nuevo nombre de accesorio', 'textdomain' ),
		                       'menu_name'         => __( 'Accesorios', 'textdomain' ),
                           ],
                           'public'      => true,
                           'has_archive' => true,
                           'menu_position' => 5,
                           'rewrite' => array( 'slug' => 'accesorio' ),
                       ]
    );
}
add_action('init', 'azulcaribe_accesorio');

// Show posts of 'post', 'bikini' and 'lentes' post types on home page

function add_my_post_types_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array('bikini', 'lentes','inflable', 'mantita', 'sombrero','bolsas','accesorio' ) );
  return $query;
}
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

// add support for featured images:
add_theme_support( 'post-thumbnails' );
