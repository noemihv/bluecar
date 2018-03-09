<?php
class BikiniFetcher {
	const RELATED_HIERARCHY = array(
		'min_total'   => 10,
		'bikini'      => 6,
		// 'mantita' => 4,
	);

	public static function fetch ($query_args) {
		$objects_to_return = array();
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
				$description = get_the_excerpt( $cur_post->ID );

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
				
				// create bikini obj
				$tmp_obj_as_arr['price']       = $price;
				$tmp_obj_as_arr['uuid']        = $uuid;
				$tmp_obj_as_arr['title']       = $title;
				$tmp_obj_as_arr['colors']      = $colors_info;
				$tmp_obj_as_arr['tags']        = $tags;
				$tmp_obj_as_arr['description'] = $description;

				// finally, append bikini obj to results
				array_push( $objects_to_return, $tmp_obj_as_arr );
			} // End foreach().
		} // End if().

		return $objects_to_return;
	}

	private static function buildQueryArgs ( $params ) {
		$offset = 0;
		$per_page = 10;
		$sort_by = 'price';
		$sort_order = 'ASC';
		$objects_to_return = array();
		$filter_tags = '';
		$filter_price_range = '';
		$filter_exclude = '';
		$uuid = '';

		// parse query string params.
		if ( array_key_exists('offset', $params) ) $offset = intval( $params['offset']);
		if ( array_key_exists('per_page', $params) ) $per_page = intval( $params['per_page'] );
		if ( array_key_exists('sort_by', $params) ) $sort_by = $params['sort_by'];
		if ( array_key_exists('sort_order', $params) ) $sort_order = $params['sort_order'];
		if ( array_key_exists('filter_tags', $params) ) $filter_tags = $params['filter_tags'];
		if ( array_key_exists('filter_price_range', $params) ) $filter_price_range = $params['filter_price_range']; // format should be: [ x<>y | <x | >x ]
		if ( array_key_exists('filter_exclude', $params) ) $filter_exclude = $params['filter_exclude']; // exclude by uuid
		if ( array_key_exists('uuid', $params) ) $uuid = $params['uuid']; // include uuid

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

		// check if there is a filter exclude and build meta_query appropriately
		if ( '' !== $filter_exclude ) {
			$filter_exclude_arr = explode(',', $filter_exclude);
			foreach ($filter_exclude_arr as $exclude) {
				$to_add = array(
					'key'     => 'uuid',
					'value'   => $filter_exclude,
					'compare' => 'NOT IN',
				);

				if ( !array_key_exists('meta_query', $query_args ) ) $query_args['meta_query'] = array();

				array_push( $query_args['meta_query'], $to_add );
			} 
		}

		// check if there is a uuid and build meta_query appropriately
		if ( '' !== $uuid ) {
			$to_add = array(
				'key'     => 'uuid',
				'value'   => $uuid,
				'compare' => 'IN',
			);

			if ( !array_key_exists('meta_query', $query_args ) ) $query_args['meta_query'] = array();

			array_push($query_args['meta_query'], $to_add);
		}

		// check if there is a filter price range and build meta_query appropriately
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

				if ( !array_key_exists('meta_query', $query_args ) ) $query_args['meta_query'] = array();

				array_push($query_args['meta_query'], $to_add);

			} elseif ( strpos( $filter_price_range, '<' ) || strpos( $filter_price_range, '>' ) ) {
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

		return $query_args;
	}

	public static function getBikinis ( $request ) {
		$errors = array();
		$query_args = self::buildQueryArgs( $request->get_params() );
		$objects_to_return = self::fetch($query_args); // execute query

		if ( count( $objects_to_return ) === 0 ) array_push($errors, 'not found');

		// return response
		$response = [
			'data' => $objects_to_return,
			'errors' => $errors,
		];

		return $response;
	}

	public static function getSingleBikini ( $data ) {
		$errors = array();
		$params = array(
			'uuid' => $data['uuid'],
		);
		$post_to_return = null;
		$args = self::buildQueryArgs($params);

		$post_to_return = self::fetch($args); // execute query
		$response = [
			'data' => null,
			'errors' => 'Not found'
		];

		if ( count( $post_to_return ) > 0 ) {
			$response = [
				'data' => $post_to_return[0],
				'errors' => $errors,
			];
		}

		return $response;
	}

	public static function getSingleBikiniRelated ( $data ) {
		// get bikini object first
		$bikini = self::getSingleBikini( $data )['data'];

		if ( !$bikini ) {
			return array(
				'bikini' => null,
				'data' => null,
				'errors' => array(
					'not found',
				)
			);
		}

		$tags = '';
		$related_content = array();
		$filter_exclude = $bikini['uuid'];

		// check if bikini has tags and create str query param if so.
		if ( $bikini['tags'] ) {
			foreach ( $bikini['tags'] as $tag ) {
				if ( '' !== $tags ) $tags .= ',';
				$tags .= $tag->slug;
			}
		}

		// start the loop to fetch related content based on the defined hierarchy
		foreach( self::RELATED_HIERARCHY as $postType => $amount ) {
			if ( 'min_total' !== $postType ) {
				// create fetcher obj
				switch ($postType) {
					case 'bikini':
						$related_content['bikinis'] = Array();
						$params = array(
							'filter_tags'    => $tags,
							'per_page'       => $amount,
							'filter_exclude' => $filter_exclude,
						);
						$query_args = self::buildQueryArgs( $params );
						$bikinis = self::fetch( $query_args );
						$related_content['bikinis'] = array_merge( $related_content['bikinis'], $bikinis );

						// check if total amount did match the expected number for type
						$fetched_amount = count( $bikinis );
						if ( $fetched_amount < $amount ) {
							// add excludes per ID to remaining objects.
							foreach ($bikinis as $fetched_bikini) {
								$filter_exclude .= ',' . $fetched_bikini['uuid'];
							}
							$params = array(
								'per_page'       => $amount - $fetched_amount,
								'filter_exclude' => $filter_exclude,
							);

							$query_args = self::buildQueryArgs( $params );
							$remaining_bikinis = self::fetch( $query_args );
							$related_content['bikinis'] = array_merge( $related_content['bikinis'], $remaining_bikinis );
						}

						break;
					default:
						break;
				}
			}
		}

		return [
			'bikini' => $bikini,
			'data' => $related_content,
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
