<?php
/*
Template Name: Function: Insert Nearby Parks

*/
get_header();

$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
	$parks_query = $wpdb->get_results( "SELECT * FROM rvty_parks WHERE state = '$submited_state' ORDER BY name ASC" );
	$i=1;
	foreach ($parks_query as $park) {
		if ( !empty ( $park->name ) ) {
			echo $post_id = $park->wpid;
			echo ' - ' . $submited_state . '<br />';
			$current_park = $wpdb->get_results( 
				"
				 SELECT *  
				 FROM rvty_geodata
				 WHERE post_id = '$post_id'
				"
			);
			//$post_id = $current_park[0]->post_id;
			$lat = $current_park[0]->geo_latitude;
			if ( $lat == 0 ) { continue; }
			$lng = $current_park[0]->geo_longitude;
			if ( $lng == 0 ) { continue; }
			$post_type = 'rvparks';
			$field_value = 'park';
			nearbyLocations ( $post_id, $post_type, $field_value, $lat, $lng, 1 );
		}
	}
} else {
	echo 'balls!';
}
?>
<form method="post" action=""> <?php //echo esc_attr($_SERVER['REQUEST_URI']); ?>
<br /><br />
<input type="text" name="submited_state" size="4" />
<input type="submit" name="submit" value="Insert the new Posts" />
</form>
<br /><br />
<?php get_footer(); ?>