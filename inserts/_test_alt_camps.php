<?php
/*
Template Name: Function: Test Add Alt Camps
*/
get_header();

$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
	$parks_query = $wpdb->get_results( "SELECT * FROM rvty_parks WHERE state = '$submited_state' ORDER BY name ASC" );
	$i=1;
	foreach ($parks_query as $park) {
		$post_id = $park->wpid;
		$lat = $park->lat;
		if ( $lat == 0 ) { continue; }
		$lng = $park->lon;
		if ( $lng == 0 ) { continue; }

		/** Save Nearby RV Parks
		********************************/		
		$wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO rvty_geodata
				( post_id, geo_latitude, geo_longitude )
				VALUES ( %d, %f, %f )
			", 
			$post_id,
			$lat,
			$lng
		) );	
		echo 'id: ' . $post_id . 'lat: ' .$lat . 'lng: ' . $lng . '<br />';
		
		if ( $i <= 10 ) { $redo_array[] = $post_id; }
		$MilesArray = array();
		$bounding_distance = 1;
		$nearbys = $wpdb->get_results( 
				"
				 SELECT *  
				 FROM rvty_geodata
				 WHERE (
						geo_latitude BETWEEN ($lat - $bounding_distance) AND ($lat + $bounding_distance) AND geo_longitude BETWEEN ($lng - $bounding_distance) AND ($lng + $bounding_distance) 
					)
				"
		);		
		foreach ($nearbys as $nearby) {
			$alt_id = $nearby->post_id;
			$alt_lat = $nearby->geo_latitude;
			$alt_lng = $nearby->geo_longitude;
			if ($post_id != $alt_id) {
				$Miles = distance($lat, $lng, $alt_lat, $alt_lng, "M");
				$MilesArray[$alt_id] = $Miles;
			}
		}
		asort($MilesArray);
		if(count($MilesArray)>10){
			$MilesArrayChunk = array_chunk($MilesArray, 10, true);
			$ALTCGArray = $MilesArrayChunk[0];
		} else {
			$ALTCGArray = $MilesArray;
		}
		print_r( $ALTCGArray );
		echo '<br />';
		//update_post_meta( $post_id, 'alt_camps', $ALTCGArray);
	}
} else {
	echo 'balls!';
}
?>
<form method="post" action=""> <?php //echo esc_attr($_SERVER['REQUEST_URI']); ?>
<br /><br />
<input type="text" name="submited_state" size="4" />&nbsp; 
<input type="submit" name="submit" value="Insert the new Posts" />
</form>
<br /><br />
<?php get_footer(); ?>