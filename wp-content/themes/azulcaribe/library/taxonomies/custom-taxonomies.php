<?php
function azulcaribe_taxonomies() {
	$labels = [
		'name'              => _x( 'Etiquetas', 'taxonomy general name' ),
		'singular_name'     => _x( 'Etiqueta', 'taxonomy singular name' ),
		'search_items'      => __( 'Buscar Etiquetas' ),
		'all_items'         => __( 'Todas las Etiquetas' ),
		'edit_item'         => __( 'Editar Etiqueta' ),
		'update_item'       => __( 'Actualizar Etiqueta' ),
		'add_new_item'      => __( 'Agregar Etiqueta' ),
		'new_item_name'     => __( 'Nombre de una nueva Etiqueta' ),
		'menu_name'         => __( 'Etiqueta' ),
	];
	$args = [
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'etiqueta' ],
	];
	register_taxonomy( 'course', [ 'post' ], $args );
}

add_action( 'init', 'azulcaribe_taxonomies' );
