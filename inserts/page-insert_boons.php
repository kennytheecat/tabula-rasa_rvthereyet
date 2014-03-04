<?php
/*
Template Name: Function: Insert Boondocks
*/
get_header();

$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
	$parks_query = $wpdb->get_results( "SELECT * FROM rvty_rvstops WHERE state = '$submited_state' ORDER BY name ASC" );
	$i=1;
	$starting_ids = array();
	foreach ($parks_query as $park) {
		if ( 	$park->name == 'WAL-MART' ||
					$park->name == 'WAL-MART SUPERCENTER' ||
					$park->name == 'FLYING J' ||
					$park->name == 'LOVES' ||
					$park->name == 'PILOT'
				) {
			$name = ucwords(strtolower($park->name));
			if ( $name == 'Wal-mart' || $name == 'Wal-mart Supercenter' ) {
				$name = str_replace ('al-m', 'al-M', $name);
			}
			$name_lc = strtolower( $name );
			$name_lc = str_replace( ' ', '-', $name_lc );
			$term = term_exists( $name, "boons"); 
			$new_type = $term['term_id'];			
			$address = ucwords(strtolower($park->address));
			$city = ucwords(strtolower($park->city));
			$city_lc = strtolower( $city );
			$city_lc = str_replace( ' ', '-', $city_lc );
			// use StateNames array to get long version of state name
			$state = $park->state;
			$state = $StateNames[$submited_state];
			$state = term_exists( $state, 'states' );
			$zip = $park->zip;
			$phone1 = $park->phone1;
			$lat = $park->lat;
			if ( $lat == 0 ) { continue; }
			$lng = $park->lon;
			if ( $lng == 0 ) { continue; }
			$coords = array( 'boon_lat' => $lat, 'boon_lng' => $lng );
			$overnight = $park->overnight;
			if ( $overnight == 'NO' ) { $overnight = 'on'; }
			
			// Create post object
			$my_post = array(
				'post_title'    => $name,
				'post_name'			=> $name_lc . '-' . $city_lc,
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_author'   => 2,
				'post_type'   => 'rvboons'
			);

			// Insert the post into the database
			$post_id = wp_insert_post( $my_post, $wp_error );
			wp_set_post_terms( $post_id, $new_type, 'boons' ); 
			if ( $address != '' ) { add_post_meta( $post_id, 'boon_address', $address ); }
			if ( $city != '' ) { add_post_meta( $post_id, 'boon_city', $city ); }
			wp_set_post_terms( $post_id, $state, 'states' );
			if ( $zip != '' ) { add_post_meta( $post_id, 'boon_zip', $zip ); }
			if ( $phone1 != '' ) { add_post_meta( $post_id, 'boon_phone1', $phone1 ); }
			if ( $coords != '' ) { add_post_meta( $post_id, 'boon_coords', $coords ); }
			if ( $overnight != '' ) { add_post_meta( $post_id, 'boon_overnight', $overnight ); }
			
			/** Save Nearby RV Boondocks
			********************************/
			$post_type = 'rvboons';
			$wpdb->query( $wpdb->prepare( 
				"
					INSERT INTO rvty_geodata
					( post_id, geo_latitude, geo_longitude, post_type )
					VALUES ( %d, %f, %f, %s )
				", 
				$post_id,
				$lat,
				$lng,
				$post_type
			) );	
			$starting_ids[] = $post_id;
		}
	}	

	/* Nearby RV Boondock Coords
	***********************************************/
	foreach ($starting_ids as $starting_id) {
		$current_park = $wpdb->get_results( 
				"
				 SELECT *  
				 FROM rvty_geodata
				 WHERE post_id = '$starting_id'
				"
		);
		$post_id = $current_park[0]->post_id;
		$lat = $current_park[0]->geo_latitude;
		if ( $lat == 0 ) { continue; }
		$lng = $current_park[0]->geo_longitude;
		if ( $lng == 0 ) { continue; }
		$post_type = 'rvboons';
		$field_value = 'boon';		
		nearbyLocations ( $post_id, $post_type, $field_value, $lat, $lng, 1 );	
	}
} else {
	echo 'balls!';
}
?>
<form method="post" action="">
<br /><br />
<input type="text" name="submited_state" size="4" />&nbsp; 
<input type="submit" name="submit" value="Insert the new Posts" />
</form>
<br /><br />
<?php get_footer(); ?>