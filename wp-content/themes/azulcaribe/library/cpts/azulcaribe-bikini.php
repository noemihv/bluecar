<?php
define('RELATED_HIERARCHY', array(
	'min_total'   => 10,
	'bikini'     => 6,
	// 'mantita' => 4,
));

add_action( 'init', 'azulcaribe_bikini' );
add_action( 'rest_api_init', 'azulcaribe_bikini_rest_api_init' );
add_action( 'add_meta_boxes', 'bikini_meta_boxes' );
add_action( 'save_post', 'save_bikini_price_meta_box', 10, 2 );
add_action( 'save_post', 'save_bikini_color0_meta_box' );

// ------- BIKINI POST TYPE -------
function azulcaribe_bikini() {
	$labels = array(
		'name'              => __( 'Bikinis' ),
		'singular_name'     => __( 'Bikini' ),
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
	// route to fetch all pages.
	register_rest_route(
		'azulcaribe/v1',
		'/bikinis/pages',
		array(
			'methods'  => 'GET',
			'callback' => 'azulcaribe_rest_api_get_bikinis_pages',
		)
	);
	// route to get a single bikini.
	register_rest_route(
		'azulcaribe/v1',
		'/bikinis/(?P<uuid>[a-zA-Z0-9-]+)',
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
	// route to get a single bikini's related content.
	register_rest_route(
		'azulcaribe/v1',
		'/bikinis/(?P<uuid>[a-zA-Z0-9-]+)/related',
		array(
			'methods'  => 'GET',
			'callback' => 'azulcaribe_rest_api_fetch_single_bikini_related',
			'args' => array(
				'uuid' => array(
					'validate_callback' => 'azulcaribe_bikini_uuid_validation',
				),
			),
		)
	);
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
		$post_to_return['title'] = get_the_title( $post_to_return_raw->ID );
		$post_to_return['description'] = get_the_excerpt( $post_to_return_raw->ID );

		// fetch colors
		$colors_info = array();

		// fetch colors info
		for ( $i = 0; $i < 10; $i++ ) {
			// check if color actually exists
			if ( array_key_exists( 'color' . $i . '_name', $meta ) && null !== $meta['color' . $i . '_name'][0]) {
				$tmp_color = array();
				$tmp_color['name']      = $meta['color' . $i . '_name'][0];
				$tmp_color['hexa']      = array_key_exists( 'color' . $i . '_hexa', $meta ) ? $meta['color' . $i . '_hexa'][0] : null;
				$tmp_color['sizes']     = array_key_exists( 'color' . $i . '_sizes', $meta ) ? $meta['color' . $i . '_sizes'][0] : null;
				$tmp_color['inventory'] = array_key_exists( 'color' . $i . '_inventory', $meta ) ? $meta['color' . $i . '_inventory'][0] : null;
				$tmp_color['image']     = array_key_exists( 'color' . $i . '_image', $meta ) ? $meta['color' . $i . '_image'][0] : null;

				// append to colors info array
				$colors_info['color' . $i] = $tmp_color;
			}
		}

		$post_to_return['colors'] = $colors_info;
	} else {
		$errors = 'Not found';
	}

	return [
		'data' => $post_to_return,
		'errors' => $errors,
	];
}

function azulcaribe_rest_api_fetch_single_bikini_related ( $data ) {
	// get bikini object first
	$bikini = azulcaribe_rest_api_fetch_single_bikini( $data );
	$tags = '';

	// check if bikini has tags.
	if ( $bikini['tags'] ) {
		foreach ( $bikini['tags'] as $tag ) {
			if ( '' !== $tags ) $tags .= ',';
			$tags .= $tag;
		}
	}

	// start the loop to fetch related content based on the defined hierarchy
	foreach( RELATED_HIERARCHY as $hierarchy ) {
		$fetcher_object = null;

		if ( 'min_total' !== $hierarchy ) {
			// create fetcher obj
			switch ($hierarchy) {
				case 'bikini':
					
					break;
				default:
					
					break;
			}
		}
	}

	return [
		'bikini' => $bikini,
		'data' => array(),
		'errors' => array(),
	];
}

/**
 * Fetch all bikinis according to req params.
 * If no req params are present, default to specific values 
 * and perform the query that way.
 *
 * @param WP_REST_Request $request
 * @return void
 */
function azulcaribe_rest_api_fetch_bikinis (WP_REST_Request $request) {
	$offset = 0;
	$per_page = 10;
	$sort_by = 'price';
	$sort_order = 'ASC';
	$objects_to_return = array();
	$errors = array();
	$filter_tags = '';
	$filter_price_range = '';
	$filter_exclude = '';

	// parse query string params.
	if ( $request->get_param( 'offset' ) ) $offset = intval( $request->get_param( 'offset' ));
	if ( $request->get_param( 'per_page' ) ) $per_page = intval( $request->get_param( 'per_page' ) );
	if ( $request->get_param( 'sort_by' ) ) $sort_by = $request->get_param( 'sort_by' );
	if ( $request->get_param( 'sort_order' ) ) $sort_order = $request->get_param( 'sort_order' );
	if ( $request->get_param( 'filter_tags' ) ) $filter_tags = $request->get_param( 'filter_tags' );
	if ( $request->get_param( 'filter_price_range' ) ) $filter_price_range = $request->get_param('filter_price_range'); // format should be: [ x<>y | <x | >x ]
	if ( $request->get_param( 'filter_exclude' ) ) $filter_exclude = $request->get_param('filter_exclude'); // exclude by uuid

	$query_args = array(
		'post_type'      => 'bikini',
		'orderby'        => 'meta_value_num',
		'meta_key'       => $sort_by,
		'order'          => $sort_order,
		'posts_per_page' => $per_page,
		'offset'         => $offset,
	);

	// append tag filter if specified in the query str params.
	if ( '' !== $filter_tags ) {
		$query_args['tag'] = $filter_tags;
	}

	if ( '' !== $filter_exclude ) {
		$query_args['meta_query'] = array();
		$filter_exclude_arr = explode(',', $filter_exclude);
		foreach ($filter_exclude_arr as $exclude) {
			$to_add = array(
				'key'     => 'uuid',
				'value'   => $filter_exclude,
				'compare' => 'NOT IN',
			);
			array_push( $query_args['meta_query'], $to_add );
		} 
	}

	if ( '' !== $filter_price_range ) {
		// determine which case it is
		if ( strpos( $filter_price_range, '<>' ) ) { // means BETWEEN
			$price0 = intval( explode( '<>', $filter_price_range )[0] );
			$price1 = intval( explode( '<>', $filter_price_range )[1] );
			$max = max($price0, $price1);
			$min = min($price0, $price1);
			$to_add = array(
				'key'     => 'price',
				'type'    => 'numeric',
				'compare' => 'BETWEEN',
				'value'   => array($min, $max),
			);

			if (!$query_args['meta_query']) $query_args['meta_query'] = array();

			array_push($query_args['meta_query'], $to_add);

		} elseif ( strpos( $filter_price_range, '<' ) || strpos( $filter_price_range, '>' ) ) {
			echo 'here';
			if ( strpos(  $filter_price_range, '<' ) ) { // means LESS THAN
				$price = intval( explode( '<', $filter_price_range )[1] );
				$compare = '<=';
			} else { // means GREATER THAN
				$price = intval( explode( '>', $filter_price_range )[1] );
				$compare = '>=';
			}
			$query_args['meta_query'] = array(
				array(
					'key'     => 'price',
					'type'    => 'numeric',
					'compare' => $compare,
					'value'   => $price,
				)
			);
		} else { // means invalid format
			// do nothing
		}

	}
	// var_dump($query_args);

	$query = new WP_Query( $query_args );

	if ( $query->have_posts() ) {
		foreach ( $query->posts as $cur_post ) {
			$tmp_obj_as_arr = array();
			$meta = get_post_meta( $cur_post->ID );
			$price = floatval( $meta['price'][0] );
			$tags = get_the_tags( $cur_post->ID );
			$uuid = array_key_exists( 'uuid', $meta ) ?  $meta['uuid'][0] : '';
			$title = get_the_title( $cur_post->ID );
			$colors_info = array();

			// fetch colors info
			for ( $i = 0; $i < 10; $i++ ) {
				// check if color actually exists
				if ( array_key_exists( 'color' . $i . '_name', $meta ) && null !== $meta['color' . $i . '_name'][0]) {
					$tmp_color = array();
					$tmp_color['color' . $i . '_name']      = $meta['color' . $i . '_name'][0];
					$tmp_color['color' . $i . '_hexa']      = array_key_exists( 'color' . $i . '_hexa', $meta ) ? $meta['color' . $i . '_hexa'][0] : null;
					$tmp_color['color' . $i . '_sizes']     = array_key_exists( 'color' . $i . '_sizes', $meta ) ? $meta['color' . $i . '_sizes'][0] : null;
					$tmp_color['color' . $i . '_inventory'] = array_key_exists( 'color' . $i . '_inventory', $meta ) ? $meta['color' . $i . '_inventory'][0] : null;
					$tmp_color['color' . $i . '_image']     = array_key_exists( 'color' . $i . '_image', $meta ) ? $meta['color' . $i . '_image'][0] : null;

					// append to colors info array
					$colors_info['color' . $i] = $tmp_color;
				}
			}
			
			// create bikini obj
			$tmp_obj_as_arr['price']  = $price;
			$tmp_obj_as_arr['uuid']   = $uuid;
			$tmp_obj_as_arr['title']  = $title;
			$tmp_obj_as_arr['colors'] = $colors_info;
			$tmp_obj_as_arr['tags'] = $tags;

			// finally, append bikini obj to results
			array_push( $objects_to_return, $tmp_obj_as_arr );
		} // End foreach().
	} // End if().

	// return response
	$response = [
		'data' => $objects_to_return,
		'errors' => $errors,
	];

	return $response;
}

function azulcaribe_bikini_uuid_validation ( $param ) {
	return true;
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

	// colors.
	add_meta_box(
		'bikini_colors',
		'Colores',
		'render_bikini_color0_meta_box',
		'bikini',
		'normal',
		'low'
	);
}

// -------- COLORS RELATED.
function render_bikini_color0_meta_box ( $post ) {
	$meta = get_post_custom( $post->ID );
	wp_nonce_field( basename( __FILE__ ), 'bikini_colors' );

	for ( $i = 0; $i < 10; $i ++ ) {
		$cur_color_name = isset( $meta['color' . $i . '_name'] ) ? $meta['color' . $i . '_name'][0] : '';
		$display_cur_color_div = ( null === $cur_color_name || ( '' === $cur_color_name && 0 !== $i ) ) ? 'none' : 'block';
		$cur_color_hexa = isset( $meta['color' . $i . '_hexa'] ) ? $meta['color' . $i . '_hexa'][0] : '';
		$cur_color_sizes = isset( $meta['color' . $i . '_sizes'] ) ? $meta['color' . $i . '_sizes'][0] : '';
		$cur_color_inventory = isset( $meta['color' . $i . '_inventory'][0] ) ? $meta['color' . $i . '_inventory'][0] : '';
		$cur_color_image = isset( $meta['color' . $i . '_image'][0] ) ? $meta['color' . $i . '_image'][0] : '';
		?>

		<div id="bikini-color<?php echo esc_html( $i ) ?>-div" name="bikini-color<?php echo esc_html( $i ) ?>-div" style="display:<?php echo esc_html( $display_cur_color_div ) ?>">
			<br>
			<button id="<?php echo esc_html( $i ) ?>" class="delete-color-btn button button-primary" style="float: right;">X</button>
			<h3>Color <?php echo esc_html( $i + 1 ) ?></h3>
			<div>
				<h4>Nombre del color:</h4>
				<input type="text" name="color<?php echo esc_html( $i ) ?>_name" id="color<?php echo esc_html( $i ) ?>_name" placeholder="Color" value="<?php echo esc_html( $cur_color_name ); ?>">
			</div>
			
			<div>
				<h4>Hexadecimal del color:</h4>
				<input type="text" name="color<?php echo esc_html( $i ) ?>_hexa" id="color<?php echo esc_html( $i ) ?>_hexa" placeholder="Hexadecimal" value="<?php echo esc_html( $cur_color_hexa ); ?>">
			</div>
			
			<div>
				<h4>Tallas</h4>
				<input type="text" name="color<?php echo esc_html( $i ) ?>_sizes" id="color<?php echo esc_html( $i ) ?>_sizes" placeholder="Tallas" value="<?php echo esc_html( $cur_color_sizes ); ?>">
			</div>

			<div>
				<h4>Inventario</h4>
				<input type="text" name="color<?php echo esc_html( $i ) ?>_inventory" id="color<?php echo esc_html( $i ) ?>_inventory" placeholder="" value="<?php echo esc_html( $cur_color_inventory ); ?>"><span>unidades</span>
			</div>

			<div>
				<h4>Imagen</h4>
				<input type="text" name="color<?php echo esc_html( $i ) ?>_image" id="color<?php echo esc_html( $i ) ?>_image" placeholder="URL" value="<?php echo esc_html( $cur_color_image ) ?>">
			</div>
			<hr>
			<br>
		</div>

		<?php
	}
	?>
	<button id="add-color-btn" class="button button-primary button-large">Agregar color</button>
<?php
}

// -------- SAVE COLORS-RELATED STUFF.
function save_bikini_color0_meta_box ( $post_id ) {
	global $post;
	$meta = array();
	// Verify nonce.
	if ( ! isset( $_POST['bikini_colors'] ) || ! wp_verify_nonce( $_POST['bikini_colors'], basename( __FILE__ ) ) ) {
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

	for ( $i = 0; $i < 10; $i ++ ) {
		// Save color-n name.
		if ( isset( $_POST['color' . $i . '_name'] ) && '' !== $_POST['color' . $i . '_name']) {
			$meta['color' . $i . '_name'] = $_POST['color' . $i . '_name'];
		} else {
			$meta['color' . $i . '_name'] = null;
		}

		// Save color-n hexa.
		if ( isset( $_POST['color' . $i . '_hexa'] ) && '' !== $_POST['color' . $i . '_hexa']) {
			$meta['color' . $i . '_hexa'] = $_POST['color' . $i . '_hexa'];
		} else {
			$meta['color' . $i . '_hexa'] = null;
		}

		// Save sizes for color-n.
		if ( isset( $_POST['color' . $i . '_sizes'] ) && '' !== $_POST['color' . $i . '_sizes']) {
			$meta['color' . $i . '_sizes'] = $_POST['color' . $i . '_sizes'];
		} else {
			$meta['color' . $i . '_sizes'] = null;
		}

		// Save color-n inventory.
		if ( isset( $_POST['color' . $i . '_inventory'] ) && '' !== $_POST['color' . $i . '_inventory']) {
			$meta['color' . $i . '_inventory'] = $_POST['color' . $i . '_inventory'];
		} else {
			$meta['color' . $i . '_inventory'] = null;
		}

		// Save color-n image
		if ( isset( $_POST['color' . $i . '_image'] ) && '' !== $_POST['color' . $i . '_image']) {
			$meta['color' . $i . '_image'] = $_POST['color' . $i . '_image'];
		} else {
			$meta['color' . $i . '_image'] = null;
		}
	}

	foreach ( $meta as $key => $value ) {
		update_post_meta( $post->ID, $key, $value );
	}
}

// -------- PRICES RELATED.
function render_bikini_price_meta_box( $post ) {
	$meta = get_post_custom( $post->ID );
	$price = isset( $meta['price'][0] ) ? $meta['price'][0] : '';

	wp_nonce_field( basename( __FILE__ ), 'bikini_price' );
	?>
	
	<span>$</span><input name="bikini_price_field" id="bikini_price_field" type="text" value="<?php echo esc_html( $price ); ?>">

	<?php
}

// -------- SAVE PRICE.
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

	$meta['price'] = ( isset( $_POST['bikini_price_field'] ) ) ? floatval( $_POST['bikini_price_field'] ) : 0;

	$old_uuid = get_post_meta( $post_id )['uuid'];
	if ( ! $old_uuid ) $meta['uuid'] = wp_generate_uuid4();

	foreach ( $meta as $key => $value ) {
		update_post_meta( $post->ID, $key, $value );
	}
}
