<?php
class BikiniFetcher {
	public static function getBikinis ( $request ) {
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

	public static function getSingleBikini ( $data ) {
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

	public static function getSingleBikiniRelated ( $data ) {
		// get bikini object first
		$bikini = self::getSingleBikini( $data );
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

	public static function getBikiniPages ($request) {
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
}
