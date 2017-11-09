<?php
// ------- BIKINI POST TYPE -------
function azulcaribe_bikini() {
	$labels = array(
		'name'          => __( 'Bikinis' ),
		'singular_name' => __( 'Bikini' ),
		'search_items'      => __( 'Buscar bikini', 'textdomain' ),
		'all_items'         => __( 'Todos los bikinis', 'textdomain' ),
		'parent_item'       => __( 'Parent product', 'textdomain' ),
		'parent_item_colon' => __( 'Parent product:', 'textdomain' ),
		'edit_item'         => __( 'Editar bikini', 'textdomain' ),
		'update_item'       => __( 'Actualizar Bikini', 'textdomain' ),
		'add_new_item'      => __( 'Agregar nuevo Bikini', 'textdomain' ),
		'new_item_name'     => __( 'Nuevo nombre de bikini', 'textdomain' ),
		'menu_name'         => __( 'Bikini', 'textdomain' ),
	);

	$args = array(
		'labels'               => $labels,
		'public'               => true,
		'publicly_queryable'   => true,
		'show_ui'              => true,
		'show_in_menu'         => true,
		'show_in_rest'         => true,
		'query_var'            => true,
		'taxonomies'           => array( 'post_tag' ),
		'rewrite'              => array(
			'slug' => 'bikini',
		),
		'capability_type'      => 'post',
		'has_archive'          => true,
		'hierarchical'         => false,
		'menu_position'        => null,
		'supports'             => array( 'title', 'thumbnail', 'excerpt' ),
	);

	register_post_type( 'bikini', $args );
}
add_action( 'init', 'azulcaribe_bikini' );
add_action( 'rest_api_init', 'azulcaribe_bikini_rest_api_init' );
add_action( 'add_meta_boxes', 'bikini_meta_boxes' );
add_action( 'save_post', 'save_bikini_price_meta_box', 10, 2 );
add_action( 'save_post', 'save_bikini_sizes_meta_box', 10, 2 );
add_action( 'save_post', 'save_bikini_inventory_meta_box', 10, 2 );

function azulcaribe_bikini_rest_api_init() {
	// route to get all bikinis
	register_rest_route(
		'azulcaribe/v1',
		'/bikinis',
		array(
			'methods'  => 'GET',
			'callback' => 'azulcaribe_rest_api_fetch_bikinis',
		)
	);
	// route to get a single bikini.
	register_rest_route(
		'azulcaribe/v1',
		'/bikinis/single/(?P<uuid>[a-zA-Z0-9-]+)',
		array(
			'methods'  => 'GET',
			'callback' => 'azulcaribe_rest_api_fetch_single_bikini',
			'args' => array(
				'uuid' => array(
					'validate_callback' => 'azulcaribe_bikini_uuid_validation',
				),
			),
		)
	);
	// route to fetch all pages.
	register_rest_route(
		'azulcaribe/v1',
		'/bikinis/pages',
		array(
			'methods'  => 'GET',
			'callback' => 'azulcaribe_rest_api_get_bikinis_pages',
		)
	);
}

function azulcaribe_rest_api_fetch_single_bikini ( $data ) {
	$errors = null;
	$post_to_return = null;
	$args = array(
		'post_type'  => 'bikini',
		'meta_query' => array(
			array(
				'key'     => 'uuid',
				'value'   => $data['uuid'],
				'compare' => 'IN',
			),
		),
	);
	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		$post_to_return_raw = $query->posts[0];
		$tags = get_the_terms( $post_to_return_raw->ID, 'post_tag' );
		$meta = get_post_meta( $post_to_return_raw->ID );
		$post_to_return = array();
		$post_to_return['tags'] = $tags;
		$post_to_return['price'] = $meta['price'][0];
		$post_to_return['sizes'] = $meta['sizes'][0];
		$post_to_return['title'] = get_the_title( $post_to_return_raw->ID );
		$post_to_return['description'] = get_the_excerpt( $post_to_return_raw->ID );
		$post_to_return['thumbnail'] = get_the_post_thumbnail_url( $post_to_return_raw->ID );
	} else {
		$errors = 'Not found';
	}

	return [
		'data' => $post_to_return,
		'errors' => $errors,
	];
}

function azulcaribe_bikini_uuid_validation ( $param ) {
	return true;
}

function azulcaribe_rest_api_get_bikinis_pages ( WP_REST_Request $request ) {
	$query_str_params = $request->get_params();
	$data = array();
	$errors = array();

	if ( ! array_key_exists( 'per_page', $query_str_params ) ) { // validate that required params are in query string.
		array_push( $errors, 'Invalid query string parameters' );
	}

	if ( empty( $errors ) ) {
		$per_page = intval( $query_str_params['per_page'] );
		$query_args = array(
			'post_type' => 'bikini',
			'posts_per_page' => -1,
		);

		$query = new WP_Query( $query_args );

		$num_of_pages = intval( $query->post_count / $per_page );
		$to_add = ( $query->post_count % $per_page === 0 ) ? 0 : 1;
		$num_of_pages += $to_add;

		array_push( $data, [
			'num_of_pages' => $num_of_pages,
		] );
	}

	return [
		'data' => $data,
		'errors' => $errors,
	];
}

function azulcaribe_rest_api_fetch_bikinis( WP_REST_Request $request ) {
	// execute query according to params.
	// these are the only accepted params, everything else will be ignored.
	$sort_by = $request->get_param( 'sort_by' );
	$order = $request->get_param( 'order' );
	$filter_by_key = $request->get_param( 'filter_by_key' );
	$filter_by_val = $request->get_param( 'filter_by_val' );
	$per_page = $request->get_param( 'per_page' );
	$offset = $request->get_param( 'offset' );
	$errors = array();
	$objects_to_return = array();
	$query_str_params = $request->get_params();

	// validate query params.
	if ( ! array_key_exists( 'offset', $query_str_params ) ) {
		array_push( $errors, 'offset is a required query param' );
	}
	if ( ! array_key_exists( 'per_page', $query_str_params ) ) {
		array_push( $errors, 'per_page is a required query param' );
	}

	if ( empty( $errors ) ) {
		$query_args = array(
			'post_type' => 'bikini',
			'meta_key'  => $sort_by,
			'order'     => $order,
			'orderby'   => 'meta_value_num',
			'posts_per_page' => $per_page,
			'offset' => $offset,
		);

		$query = new WP_Query( $query_args );

		if ( $query->have_posts() ) {
			foreach ( $query->posts as $cur_post ) {
				$tmp_obj_as_arr = array();
				$meta = get_post_meta( $cur_post->ID );
				$price = $meta['price'][0];
				$sizes = $meta['sizes'][0];
				$uuid = array_key_exists( 'uuid', $meta ) ?  $meta['uuid'][0] : '';
				$title = get_the_title( $cur_post->ID );
				$thumbnail = get_the_post_thumbnail_url( $cur_post->ID );

				// check if bikini matches the filter criteria.
				if ( $filter_by_key ) {
					if ( 'sizes' === $filter_by_key ) {
						$required_sizes_arr = explode( ',', $filter_by_val );
						$actual_sizes_arr = explode( ',', $sizes );
						foreach ( $required_sizes_arr as $size ) {
							if ( in_array( $size, $actual_sizes_arr, true ) ) {
								$tmp_obj_as_arr['title'] = $title;
								$tmp_obj_as_arr['price'] = $price;
								$tmp_obj_as_arr['sizes'] = $sizes;
								$tmp_obj_as_arr['uuid'] = $uuid;

								array_push( $objects_to_return, $tmp_obj_as_arr );
							}
						}
					}
				} else {
					$tmp_obj_as_arr['title'] = $title;
					$tmp_obj_as_arr['price'] = $price;
					$tmp_obj_as_arr['sizes'] = $sizes;
					$tmp_obj_as_arr['uuid'] = $uuid;
					$tmp_obj_as_arr['thumbnail'] = $thumbnail;

					array_push( $objects_to_return, $tmp_obj_as_arr );
				}
			}
		} // End if().
	} // End if().

	$response = [
		'data' => $objects_to_return,
		'errors' => $errors,
	];

	return $response;

}

function bikini_meta_boxes() {
	// price.
	add_meta_box(
		'bikini_price',
		'Precio',
		'render_bikini_price_meta_box' ,
		'bikini',
		'normal',
		'low'
	);

	// sizes.
	add_meta_box(
		'bikini_sizes',
		'Tallas',
		'render_bikini_sizes_meta_box',
		'bikini',
		'normal',
		'low'
	);

	// inventory.
	add_meta_box(
		'bikini_inventory',
		'Inventario',
		'render_bikini_inventory_meta_box',
		'bikini',
		'side',
		'low'
	);
}

// -------- PRICES RELATED.
function render_bikini_price_meta_box( $post ) {
	$meta = get_post_custom( $post->ID );
	$price = isset( $meta['price'][0] ) ? $meta['price'][0] : '';

	wp_nonce_field( basename( __FILE__ ), 'bikini_price' );
	?>
	
	<input name="bikini_price_field" id="bikini_price_field" type="text" value=" <?php echo esc_html( $price ); ?> ">

	<?php
}

function save_bikini_price_meta_box( $post_id ) {
	global $post;
	// Verify nonce.
	if ( ! isset( $_POST['bikini_price'] ) || ! wp_verify_nonce( $_POST['bikini_price'], basename( __FILE__ ) ) ) {
		return $post_id;
	}
	// Check Autosave.
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
		return $post_id;
	}
	// Don't save if only a revision.
	if ( isset( $post->post_type ) && 'revision' === $post->post_type ) {
		return $post_id;
	}
	// Check permissions.
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post_id;
	}

	$meta['price'] = ( isset( $_POST['bikini_price_field'] ) && is_numeric( $_POST['bikini_price_field'] ) ) ? $_POST['bikini_price_field'] : 0;
	$meta['uuid'] = wp_generate_uuid4();

	foreach ( $meta as $key => $value ) {
		update_post_meta( $post->ID, $key, $value );
	}
}

// -------- SIZES RELATED.
function render_bikini_sizes_meta_box( $post ) {
	$meta = get_post_custom( $post->ID );
	// $price = isset( $meta['price'][0] ) ? $meta['price'][0] : '';
	$xs_checked = ( isset( $meta['sizes'] ) && in_array( 'xs', explode( ',', $meta['sizes'][0] ), true ) )? 'checked' : '';
	$s_checked  = ( isset( $meta['sizes'] ) && in_array( 's',  explode( ',', $meta['sizes'][0] ), true ) )? 'checked' : '';
	$m_checked  = ( isset( $meta['sizes'] ) && in_array( 'm',  explode( ',', $meta['sizes'][0] ), true ) )? 'checked' : '';
	$l_checked  = ( isset( $meta['sizes'] ) && in_array( 'l',  explode( ',', $meta['sizes'][0] ), true ) )? 'checked' : '';
	$xl_checked = ( isset( $meta['sizes'] ) && in_array( 'xl', explode( ',', $meta['sizes'][0] ), true ) )? 'checked' : '';

	wp_nonce_field( basename( __FILE__ ), 'bikini_sizes' );
	?>
	
	<input name="sizes[]" id="sizes" value="xs" type="checkbox" <?php echo esc_html( $xs_checked ); ?>>XS<br>
	<input name="sizes[]" id="sizes" value="s" type="checkbox" <?php echo esc_html( $s_checked ); ?>>S<br>
	<input name="sizes[]" id="sizes" value="m" type="checkbox" <?php echo esc_html( $m_checked ); ?>>M<br>
	<input name="sizes[]" id="sizes" value="l" type="checkbox" <?php echo esc_html( $l_checked ); ?>>L<br>
	<input name="sizes[]" id="sizes" value="xl" type="checkbox" <?php echo esc_html( $xl_checked ); ?>>XL<br>

	<?php
}

function save_bikini_sizes_meta_box( $post_id ) {
	global $post;
	// Verify nonce.
	if ( ! isset( $_POST['bikini_sizes'] ) || ! wp_verify_nonce( $_POST['bikini_sizes'], basename( __FILE__ ) ) ) {
		return $post_id;
	}
	// Check Autosave.
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ){
		return $post_id;
	}
	// Don't save if only a revision.
	if ( isset( $post->post_type ) && 'revision' === $post->post_type ) {
		return $post_id;
	}
	// Check permissions.
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post_id;
	}

	if ( isset( $_POST['sizes'] ) ) {
		$meta['sizes'] = '';
		foreach ( $_POST['sizes'] as $size ) {
			if ( '' !== $meta['sizes'] ) {
				$meta['sizes'] .= ',';
			}
			$meta['sizes'] .= $size;
		}
	}

	foreach ( $meta as $key => $value ) {
		update_post_meta( $post->ID, $key, $value );
	}
}

// -------- INVENTORY RELATED.
function render_bikini_inventory_meta_box( $post ) {
	$meta = get_post_custom( $post->ID );
	$inventory = isset( $meta['inventory'][0] ) ? $meta['inventory'][0] : 0;

	wp_nonce_field( basename( __FILE__ ), 'bikini_inventory' );
	?>
	
	<input name="bikini_inventory_field" id="bikini_inventory_field" type="text" value=" <?php echo esc_html( $inventory ); ?> ">
	<label for="bikini_inventory_field">Unidades</label>

	<?php
}

function save_bikini_inventory_meta_box( $post_id ) {
	global $post;
	// Verify nonce.
	if ( ! isset( $_POST['bikini_inventory'] ) || ! wp_verify_nonce( $_POST['bikini_inventory'], basename( __FILE__ ) ) ) {
		return $post_id;
	}
	// Check Autosave.
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ){
		return $post_id;
	}
	// Don't save if only a revision.
	if ( isset( $post->post_type ) && 'revision' === $post->post_type ) {
		return $post_id;
	}
	// Check permissions.
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post_id;
	}

	$meta['inventory'] = isset( $_POST['bikini_inventory_field'] ) ? $_POST['bikini_inventory_field'] : 0;

	foreach ( $meta as $key => $value ) {
		update_post_meta( $post->ID, $key, $value );
	}
}
