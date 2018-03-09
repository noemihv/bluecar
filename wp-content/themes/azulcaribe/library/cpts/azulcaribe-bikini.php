<?php
include_once( get_template_directory() . '/library/helpers/BikiniFetcher.php' );

add_action( 'init', 'azulcaribe_bikini' );
add_action( 'rest_api_init', 'azulcaribe_bikini_rest_api_init' );
add_action( 'add_meta_boxes', 'bikini_meta_boxes' );
add_action( 'save_post', 'save_bikini_price_meta_box', 10, 2 );
add_action( 'save_post', 'save_bikini_type_meta_box', 10, 1 );
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
	$result = BikiniFetcher::getBikiniPages( $request );
	return $result;
}

function azulcaribe_rest_api_fetch_single_bikini ( $data ) {
	$result = BikiniFetcher::getSingleBikini( $data );
	return $result;
}

function azulcaribe_rest_api_fetch_single_bikini_related ( $data ) {
	$result = BikiniFetcher::getSingleBikiniRelated( $data );
	return $result;
}

/**
 * Fetch all bikinis according to req params.
 * If no req params are present, default to specific values 
 * and perform the query that way.
 *
 * @param WP_REST_Request $request
 * @return Object $result - coming from the fetcher class.
 */
function azulcaribe_rest_api_fetch_bikinis (WP_REST_Request $request) {
	$result = BikiniFetcher::getBikinis( $request );
	return $result;
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

	// type.
	add_meta_box(
		'bikini_type',
		'Tipo',
		'render_bikini_type_meta_box' ,
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

// -------- TYPE RELATED.
function render_bikini_type_meta_box( $post ) {
	$meta = get_post_custom( $post->ID );
	$type = isset( $meta['type'][0] ) ? $meta['type'][0] : 'bikini';

	wp_nonce_field( basename( __FILE__ ), 'bikini_type' );
	?>

	<input type="radio" name="bikini_type_rb" id="bikini_type_rb" value="bikini" <?php if ( $type === 'bikini' ) echo esc_html( 'checked' ); ?>> Bikini <br>
  <input type="radio" name="bikini_type_rb" id="bikini_type_rb" value="trikini" <?php if ( $type === 'trikini' ) echo esc_html( 'checked' ); ?>> Trikini <br>
  <input type="radio" name="bikini_type_rb" id="bikini_type_rb" value="onepiece" <?php if ( $type === 'onepiece' ) echo esc_html( 'checked' ); ?>> Una pieza
	<?php
}

// --------- SAVE BIKINI TYPE.
function save_bikini_type_meta_box( $post_id ) {
	global $post;
	// Verify nonce.
	if ( ! isset( $_POST['bikini_type'] ) || ! wp_verify_nonce( $_POST['bikini_type'], basename( __FILE__ ) ) ) {
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

	$meta['type'] = ( isset( $_POST['bikini_type_rb'] ) ) ? $_POST['bikini_type_rb'] : '';

	foreach ( $meta as $key => $value ) {
		update_post_meta( $post->ID, $key, $value );
	}
}
