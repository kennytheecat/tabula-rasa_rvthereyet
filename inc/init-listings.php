<?php
/* Grab the variables passed from the url
******************************************/
/** STATES **/
if ( get_query_var( 'states' ) ) {
	$lc_state = get_query_var( 'states' );
	$state = ucwords( str_replace( '-', ' ', $lc_state ) );
}
/** CITIES **/
if ( get_query_var( 'cities' ) ) {
	$city_term = get_query_var( 'cities' );
	$tax1 = 'cities';
	$lc_city_main = $city_term;
	$city_main = ucwords( str_replace( '-', ' ', $lc_city_main ) );
}
/** CLUBS **/
if ( get_query_var( 'clubs' ) ) {
	$tax_cat = get_query_var( 'clubs' );
	$club = ucwords( str_replace( '-', ' ', $tax_cat ) );
	$club = str_replace( 'Usa', 'USA', $club );
	$club = str_replace( 'Koa', 'KOA', $club );
	$tax1 = 'clubs';
}
/** BOONS **/
if ( get_query_var( 'boons' ) ) {
	$tax_cat = get_query_var( 'boons' );
	$club = ucwords( str_replace( '-', ' ', $tax_cat  ) );
	$club = ucwords( str_replace( 'l M', 'l-M', $club  ) );
	$tax1 = 'rvboons';
}

/* Initial setup of variables from url
*****************************************/
global $wp;
$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
/** BOONS **/
if (strpos($current_url,'rv-boondocks') !== false) {
	$listing_slug = 'rv-boondocks';
	$listing_slug_name = 'RV Boondocks';
	$field_value = 'boon';
	$listing_name = $club . ' RV Boondocks';	
	$tax_slug = 'boons';
	$dropdown_phrase = 'Select a RV Boondocking Type...';
}
/** CLUBS **/
if (strpos($current_url,'rv-clubs') !== false) {
	$listing_slug = 'rv-clubs';
	$listing_slug_name = 'RV Clubs';
	$field_value = 'park';
	$listing_name = $club . ' Parks';	
	$tax_slug = 'clubs';
	$dropdown_phrase = 'Select a RV Club...';
}
/** DUMPS **/
if (strpos($current_url,'rv-dumps') !== false) {
	$listing_slug = 'rv-dumps';
	$field_value = 'dump';
	$listing_name = 'RV Dumps';	
}
/** PARKS **/
if (strpos($current_url,'rv-parks') !== false) {
	$listing_slug = 'rv-parks';
	$field_value = 'park';
	$listing_name = 'RV Parks';
}
/** SNOWS **/
if (strpos($current_url,'rv-snowbirds') !== false) {
	$listing_slug = 'rv-snowbirds';
	$field_value = 'park';
	$listing_name = 'RV Snowbird Parks';	
	$tax_cat = 'snowbird-friendly';
	$tax_slug = 'atmospheres';
}

/* Create heading for listings pages - $list_heading, $listing_map_heading, $listing_blogs_heading
****************************************************/
// If is a city page
if ( !empty ( $city_term ) ) {
	$list_heading .= $listing_name;
	$listing_map_heading .= '<h2>' . $listing_name . ' near ' . $city_main . ', ' . $state . '</h2>';
	if ( $listing_slug == 'rv-boondocks' ) {
		$listing_map_heading .= '<p><img class="no_overnight" src="' . get_template_directory_uri() . '/inc/maps/icons/no_overnight.png" />indicates "No Overnight Parking"</p>';
	}
	if ( $listing_slug == 'rv-dumps' ) {
		$listing_map_heading .= '<p><img class="free_dump" src="' . get_template_directory_uri() . '/inc/maps/icons/free_dump.png" />indicates a "Free RV Dump"</p>';
	}	
} else { // If is a state page
	$list_heading = $state . ' Cities';
	$listing_map_heading .= '<h2>' . $listing_name . ' in ' . $state . '</h2>';
}
$listing_blogs_heading = $state . ' RV Blogs';
	
/* Setup Listing menus
*****************************************************/
if ( !empty ( $city_term ) ) {
		if ( $listing_slug == 'rv-dumps' || $listing_slug == 'rv-snowbirds' || $listing_slug == 'rv-parks' ) {
			$listing_nav = '<p><a href="' .home_url() . '/' . $listing_slug . '/">' . $listing_name . ' >></a> <a href="' .home_url() . '/' . $listing_slug . '/' . $lc_state . '/">' . $state . ' ' . $listing_name . '<a></p>';
		} else {
			$listing_nav = '<p><a href="' .home_url() . '/' . $listing_slug . '/">' . $listing_slug_name . ' >></a> <a href="' .home_url() . '/' . $listing_slug . '/' . $lc_state . '/' . $tax_cat . '/">' . $state . ' ' . $listing_name . '<a></p>';
		}	
}

/* Setup Dropdown menus
*****************************************************/
if ( $listing_slug == 'rv-parks' || $listing_slug == 'rv-snowbirds' || $listing_slug == 'rv-dumps') {
	$tax_nav = '<div class="tax_nav">' . dropdown ( 'states', 'states', 'Choose a State...' ) . '</div>';
} else {
	$double_slugs = 'yes';
		$tax_nav = '<div class="tax_nav">' . dropdown ( $tax_slug, 'tax', $dropdown_phrase ) . dropdown ( 'states', 'states', 'Choose a State...' ) . '</div>';
}

/* Setup arrays for nearby locations
*************************************************/
$nearby_listings_array = array();

/* Setup counters for RV Park pages specifically
*************************************************/
$alt_camp_counter = 1; // Counter for alt camps so it only works once
$location_count = 0;// Counter to make sure alt camps only display a total of ten camps

/* Setup loop arguments
*************************************************/
$args = array(
	'posts_per_page'  => -1,
	'orderby'         => 'meta_value title',
	'order'           => 'ASC',
	'meta_key'        => $field_value.'_city',
	'post_type'       => 'rv'.$field_value.'s',
	'states'        	=> $state,
	'post_status'     => 'publish'
); 
$cat_posts = get_posts( $args );
foreach( $cat_posts as $post ) {
	$custom_fields = get_post_custom( $post->ID );

	/* If search term is not found, skip to next listing.
	*******************************************************/
	
	/**** FOR RV PARKS ONLY ****/
	if ( $listing_slug == 'rv-parks' ) {
		// if is city page
		if ( !empty ( $city_term ) ) {
			// if city in the url DOES NOT matches the current city
			$city_check = str_replace( '\'', '', strtolower( $custom_fields['park_city'][0] ) );
			$city_check = str_replace( ' ', '-', strtolower( $city_check ) );			
			if ( $city_term != $city_check ) {
				continue; 
			}
		}
	}
	if ( $listing_slug == 'rv-boondocks' || $listing_slug == 'rv-clubs' ||$listing_slug == 'rv-snowbirds' ) {
		if( !has_term( $tax_cat, $tax_slug, $post->ID ) ) {
			if ( $tax_cat == 'all' || $tax_cat == 'all-wal-mart') {
			// let it go through
			} else {
				continue;
			}
			if ( $tax_cat == 'all-wal-mart') {
				if( has_term( 'wal-mart', $tax_slug, $post->ID ) || has_term( 'wal-mart-supercenter', $tax_slug, $post->ID ) ) {
					// let it go through
				} else {
					continue;
				}			
			}
		}
	}
	
	/* Beginning of Main Cycle
	*********************************************/
	
	//Get post meta data
	$address = $custom_fields[$field_value.'_address'][0];
	$city = $custom_fields[$field_value.'_city'][0];
	$lc_city = str_replace( '\'', '', strtolower( $city ) );
	$lc_city = str_replace( ' ', '-', strtolower( $lc_city ) );
	$zip = $custom_fields[$field_value.'_zip'][0];
	$coords = unserialize($custom_fields[$field_value.'_coords'][0] );
	$lat = $coords[$field_value.'_lat']; 
	$lng = $coords[$field_value.'_lng'];
	
	/* Create Main Listing 
	*****************************************************/
	//If state page and current city is not the samea s the previous city
	if ( empty ( $city_term ) && $city != $previous_city ) {
		$list_cities .= '	<li><a href="' .home_url() . '/' . $listing_slug . '/';
		$list_cities .= $lc_state . '/' . $lc_city . '/';
		// If this has two dropdowns, it adds 1 more section in the url
		if ( $double_slugs == 'yes' ) { $list_cities .= $tax_cat . '/'; }
		$list_cities .= '">' . $city . '</a></li>';
	} else { // If is a city page
		// If this is the same city that is in the url
		if ( $city_term == $lc_city ) {
			// If this is a rv park, rv club, or rv snow add ratings, otherwise, skip.
			if ( $listing_slug == 'rv-parks' || $listing_slug == 'rv-clubs' || $listing_slug == 'rv-snowbirds'  ) {
				$ratings = unserialize($custom_fields[$field_value.'_vote_fields'][0]);
				$vote_avg = $ratings[1];	
			}
			$list_cities .= '<li>';
			if ( $listing_slug == 'rv-boondocks' ) {
				$overnight = $custom_fields['boon_overnight'][0];
				if ( $overnight == 'on' ) {
					$list_cities .= '<img class="no_overnight" src="' . get_template_directory_uri() . '/inc/maps/icons/no_overnight.png" />';
				}
			}	
			if ( $listing_slug == 'rv-dumps' ) {
				$free_dump = $custom_fields['dump_fee'][0];
				if ( $free_dump == 'Free' ) {
					$list_cities .= '<img class="free_dump" src="' . get_template_directory_uri() . '/inc/maps/icons/free_dump.png" />';
				}
			}				
			$list_cities .= '<a href="' . get_permalink() . '">';
			/*if ( $listing_slug == 'rv-boondocks' ) {
				$list_cities .= $club;
			} else { */
				$list_cities .= get_the_title();
			//}
			$list_cities .= '</a><br />';
			// If this is a rv park, rv club, or rv snow add ratings, otherwise, skip.
			if ( $listing_slug == 'rv-parks' || $listing_slug == 'rv-clubs' || $listing_slug == 'rv-snowbirds'  ) {
				$list_cities .= get_star_rating($vote_avg, 'small') . '<br />';
			}
			$list_cities .= '</li>';
			// Count the number of locations that are in this city
			$location_count++;
		} else {
			//Create array of listings that match the term but not the city for later use
			$nearby_listings_array[] = $post->ID;
			//skip the rest of the function if not a match in the current city
			continue;
		}
	}
	// If is a state page and the previous city equals the current city, go to the next listing
	if ( empty ( $city_term ) && $city == $previous_city ) { continue; }
	// Set previous city to the current city
	$previous_city = $city;	
	
	/* Create Main Markers for map
	*****************************************************/
	$marker_html = '<p>';
	// If is a city page			
	if ( !empty ( $city_term ) ) {	
		$marker_html .= get_the_title() . '<br />' . 
		esc_attr( $address ) . '<br />';
	}
	$marker_html .= esc_attr( $city ) . ', ' . $state . '<br />';
	// If is a city page			
	if ( !empty ( $city_term ) ) {	
		$marker_html .= '<a href="' .get_permalink( $post->ID ). '">View ' . get_the_title() . ' Details</a><br />';
	}
	$marker_html .= '<a href="' .home_url() . '/' . $listing_slug . '/';
	$marker_html .= $lc_state . '/' . $lc_city . '/';
	// If this has two dropdowns, it adds 1 more section in the url
	if ( $double_slugs == 'yes' ) { $marker_html .= $tax_cat . '/'; }
	$marker_html .= '">View ' . $listing_name . ' in ' . esc_attr( $city ) . '</a></p>';
	$marker_image = 'main3.png';
	// Check boons for overnight parking
	if ( $listing_slug == 'rv-boondocks' ) {
		if ( $overnight == 'on' ) {
			$marker_image = 'no_overnight_main.png';
		} 
	}	
	// Check dumps for overnight parking
	if ( $listing_slug == 'rv-dumps' ) {
		if ( $free_dump == 'Free' ) {
			$marker_image = 'free_dump_main.png';
		} 
	}	
	$markers[] = "var point = new google.maps.LatLng($lat,$lng); var image = '" . get_template_directory_uri() . "/inc/maps/icons/$marker_image';  var zimp = 500; var marker = createMarker(point,'$marker_html', image, zimp)"; 
	// Get coords of last city to match to use in the nearby listings
	$main_lat = $lat;
	$main_lng = $lng;	
	
	/* RV PARKS & RV DUMPS ONLY - Get the matching parks list of alt camps for later use
	***************************************************/
	if ( $listing_slug == 'rv-parks' || $listing_slug == 'rv-dumps' ) {
		if (! empty ( $city_term ) ) {
			// Get Nearby Camps		
			// Counter is so this only cycles through the first match, otherwise you get all the alt camps for every match
			if ( $alt_camp_counter == 1 ) {
				$alt_camp_counter++;
				// Get post_id of nearby camps
				$altcamps = $custom_fields[$field_value.'_nearbys'][0];
			}
		}
	}
}
// If no matches
if ( $main_lat == '' ) { $nothing_found = 'yes'; }

/* RV PARKS & RV DUMPS ONLY - Setup new loop for nearby locations
***************************************************/
if ( ( $listing_slug == 'rv-parks' || $listing_slug == 'rv-dumps' ) && $nothing_found != 'yes' ) {
	// City pages only
	if (! empty ( $city_term ) ) {
		// Grab array of alt camps from previous loop
		$altcamps = unserialize($altcamps);	
		// Subtract the number of parks in the city ($location_count) from 10 so only a total of 10 is displayed
		//$alt_location_count = 10 - $location_count;
		//$alt_location_counter = 1;
		// key is the id of the camp, value is the miles away from the main camp
		foreach ($altcamps as $key => $value ) {
			//$alt_location_counter++;
			// If the alt rv park is higher then the tenth one, skip
			//if ( $alt_location_counter > $alt_location_count ) { continue; }
			$alt_id = $key;
			$alt_distance = $value;
			// Get the name of the alt park
			$alt_name = $wpdb->get_var( "SELECT post_title FROM rvty_posts WHERE ID = $alt_id"	);
			// Get post meta of nearby camps
			$alt_values = get_post_meta( $alt_id );					
			//Create markers for nearby camps
			$alt_address = $alt_values[$field_value.'_address'][0];
			$alt_city = $alt_values[$field_value.'_city'][0];
			$alt_lc_city = str_replace( '\'', '', strtolower( $alt_city ) );					
			$alt_lc_city = str_replace( ' ', '-', strtolower( $alt_lc_city ) );
			// If alt camp is from this city, skip
			if ( $city_term == $alt_lc_city ) { continue; }
			$feat_state = array_search($state, $StateNames);
			// Grab lat and lng from rvty_geodata table
			$campcoords = $wpdb->get_results( "SELECT * FROM rvty_geodata WHERE post_id = $alt_id");		
			foreach ( $campcoords as $campcoord) {
				$alt_lat = $campcoord->geo_latitude;
				$alt_lng = $campcoord->geo_longitude;
			}
			$marker_html = '<p>' .esc_attr( $alt_name ) . '<br />' . 
			$alt_address . '<br />' . $alt_city . ', ' . $state . '<br />';
			$marker_html = '<a href="' .get_permalink( $alt_id ). '">View ' . get_the_title( $alt_id ) . ' Details</a><br />';
			$marker_html .= '<a href="' .home_url() . '/' . $listing_slug . '/' . $lc_state . '/' . $alt_lc_city . '/">View ' . $listing_name . ' in ' . $alt_city . '</a></p>';
			$marker_image = 'nearby2.png';
			// Check dumps for overnight parking
			if ( $listing_slug == 'rv-dumps' ) {
			$free_dump = $alt_values['dump_fee'][0];
				if ( $free_dump == 'Free' ) {
					$marker_image = 'free_dump_nearby.png';
				} 
			}
			$markers[] = "var point = new google.maps.LatLng($alt_lat,$alt_lng); var image = '" . get_template_directory_uri() . "/inc/maps/icons/$marker_image';  var marker = createMarker(point,'$marker_html', image)";
			
			/* Create listing for nearby camps
			*****************************************************/
			$list_parks_nearby .= '	<li>';
			if ( $listing_slug == 'rv-dumps' ) {
			if ( $free_dump == 'Free' ) {
				$list_parks_nearby .= '<img class="free_dump" src="' . get_template_directory_uri() . '/inc/maps/icons/free_dump.png" />';
				}
			}			
			$list_parks_nearby .= '<a href="' . get_permalink( $alt_id ) . '">' . esc_attr( $alt_name ) . '</a><br />';
			$list_parks_nearby .= '<a href="' .home_url() . '/' . $listing_slug . '/' . $lc_state . '/' . $alt_lc_city . '/">' . $alt_city . '</a><br />';
			$list_parks_nearby .= $alt_distance . ' miles away<br />';
			// Don't do ratings stuff for rv dumps or rv boons pages
			if ( $listing_slug == 'rv-parks' || $listing_slug == 'rv-clubs' || $listing_slug == 'rv-snowbirds'  ) {
				$ratings = unserialize($alt_values['park_vote_fields'][0]);
				$vote_avg = $ratings[1];			
				$list_parks_nearby .= get_star_rating($vote_avg, 'small') . '<br />';
			}
			$list_parks_nearby .= '</li><hr />';
			$list_parks_nearby_array[$alt_distance] = $list_parks_nearby;			
		}
	} 

} else { 		
	if ( $location_count > 10 ) { $location_count = 10;}
	$location_count = 10 - $location_count;
	/* Setup arrays for nearby locations
	*************************************************/
	$list_parks_nearby_array = array();
		
	/* Setup new loop for nearby locations
	**************************************************/

	// Only City pages
	if ( !empty ( $city_term ) ) {
		// $nearby_listings_array consists of listings that matched but were not in the current city
		foreach ( $nearby_listings_array as $nearby_listings_id ) {
			$custom_fields = get_post_custom( $nearby_listings_id );
			$coords = unserialize($custom_fields[$field_value.'_coords'][0] );
			$lat = $coords[$field_value.'_lat']; 
			$lng = $coords[$field_value.'_lng'];
			// Perform distance function to calcualte mileage away from main park
			$alt_distance = distance($main_lat, $main_lng, $lat, $lng, "M");
			if ( $alt_distance < 120 ) {
				$make10array[$alt_distance] = $nearby_listings_id;
			}
		}
		if ( $location_count == 0 ) { $make10array = ''; }
		if ( !empty ( $make10array ) ) {
			// sort array by key - closest to farthest by mileage
			ksort($make10array);
			// Cut array down to ten alt locations
			if ( count ( $make10array ) > $location_count ) {
				$make10arrayChunk = array_chunk($make10array, $location_count, true);
				$make10array = $make10arrayChunk[0];
			}
			foreach ( $make10array as $alt_distance => $make10array_id ) {
				$custom_fields = get_post_custom( $make10array_id );
				$coords = unserialize($custom_fields[$field_value.'_coords'][0] );
				$lat = $coords[$field_value.'_lat']; 
				$lng = $coords[$field_value.'_lng'];
				$city = $custom_fields[$field_value.'_city'][0];
				$lc_city = str_replace( '\'', '', strtolower( $city ) );
				$lc_city = str_replace( ' ', '-', strtolower( $lc_city ) );
				$overnight = $custom_fields['boon_overnight'][0];
				// Don't do ratings stuff for rv dumps or rv boons pages
				if ( $listing_slug == 'rv-parks' || $listing_slug == 'rv-clubs' || $listing_slug == 'rv-snowbirds'  ) {
					$ratings = unserialize($custom_fields[$field_value.'_vote_fields'][0]);
					$vote_avg = $ratings[1];
				}
				// Build nearby listing list
				$list_parks_nearby .= '<li>';
				if ( $listing_slug == 'rv-boondocks' ) {
					if ( $overnight == 'on' ) {
						$list_parks_nearby .= '<img class="no_overnight" src="' . get_template_directory_uri() . '/inc/maps/icons/no_overnight.png" />';
					}
				}
				$list_parks_nearby .= '<a href="' .get_permalink( $make10array_id ). '">';
				// If a boondock location, display the type of boondock follwed by the city
			/*	if ( $listing_slug == 'rv-boondocks' ) {
					$list_parks_nearby .= $club . '</a><br />';
				} else { */
					$list_parks_nearby .= get_the_title( $make10array_id ) . '</a><br />'; 
			//	}
				$list_parks_nearby .= '<a href="' .home_url() . '/' . $listing_slug . '/';
				$list_parks_nearby .= $lc_state . '/' . $lc_city . '/';
				// If this has two dropdowns, it adds 1 more section in the url
				if ( $double_slugs == 'yes' ) { $list_parks_nearby .= $tax_cat . '/'; }
				$list_parks_nearby .= '">' . $city . '</a>';
				$list_parks_nearby .= '<br />' . $alt_distance . ' miles away<br />';
				// Don't do ratings stuff for rv dumps or rv boons pages
				if ( $listing_slug == 'rv-parks' || $listing_slug == 'rv-clubs' || $listing_slug == 'rv-snowbirds'  ) {
					$list_parks_nearby .= get_star_rating($vote_avg, 'small') . '<br />';
				}
				$list_parks_nearby .= '</li><hr />';

				/* Create Main Markers for map - only for camps with dumps
				*****************************************************/
				$address = $custom_fields[$field_value.'_address'][0];
				$city = $custom_fields[$field_value.'_city'][0];
				$lc_city = str_replace( '\'', '', strtolower( $city ) );
				$lc_city = str_replace( ' ', '-', strtolower( $lc_city ) );
				$zip = $custom_fields[$field_value.'_zip'][0];		
				$marker_html = '<p>';
				// If is a city page			
				if ( !empty ( $city_term ) ) {	
					$marker_html .= get_the_title( $make10array_id ) . '<br />' . esc_attr( $address ) . '<br />';
				}
				$marker_html .= $city . ', ' . $state . '<br />';
				// If is a city page			
				if ( !empty ( $city_term ) ) {	
					$marker_html .= '<a href="' .get_permalink( $make10array_id ). '">View ' . get_the_title( $make10array_id ) . ' Details</a><br />';
				}
				$marker_html .= '<a href="' .home_url() . '/' . $listing_slug . '/';
				$marker_html .= $lc_state . '/' . $lc_city . '/';
				// If this has two dropdowns, it adds 1 more section in the url
				if ( $double_slugs == 'yes' ) { $marker_html .= $tax_cat . '/'; }
				$marker_html .= '">View ' . $listing_name . ' in ' . $city . '</a></p>';
				$marker_image = 'nearby2.png';
				// Check boons for overnight parking
				if ( $listing_slug == 'rv-boondocks' ) {
					if ( $overnight == 'on' ) {
						$marker_image = 'no_overnight_nearby.png';
					} 
				}
				$markers[] = "var point = new google.maps.LatLng($lat,$lng); var image = '" . get_template_directory_uri() . "/inc/maps/icons/$marker_image';  var marker = createMarker(point,'$marker_html', image)"; 		
			}
		}
	}
}
/* Setup Final varaibles for listing section
**************************************************/
$listing = $list_cities; 
if ( !empty ( $city_term ) && !empty ( $list_parks_nearby ) ) {
	$listing .= '<li><h3>Nearby ' . $listing_name . ': </h3></li>' . $list_parks_nearby;
}

/* Create heading for listings pages if not found - $list_heading, $listing_map_heading, $listing_blogs_heading
****************************************************/
if ( $nothing_found == 'yes' ) {
	// If is a city page
	if ( !empty ( $city_term ) ) {
		$list_heading .= $listing_name;
		$nothing_found_heading .= '<h2>Sorry, no ' . $listing_name . ' were found near ' . $city_main . ', ' . $state . '</h2>';
	} else { // If is a state page
		$list_heading = $state . ' Cities';
		$nothing_found_heading = '<h2>Sorry, no ' . $listing_name . ' were found  in ' . $state . '</h2>';
	}
}
?>