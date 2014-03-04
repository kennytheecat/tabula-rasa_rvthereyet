<?php
/*
Template Name: Function: Insert Parks Details
*/
include_once("header.php");
?>

<?php
$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
	$parks_query = $wpdb->get_results( $wpdb->prepare("SELECT * FROM rvty_parks WHERE state = '$submited_state' ORDER BY name ASC") );
	foreach ($parks_query as $park) {
		$name = $park->name;
		$address = $park->address;
		$city = $park->city;
		// use StateNames array to get long version of state name
		$state = $park->state;
		$state = $StateNames[$submited_state];
		print_r( term_exists($state, 'rv-parks') );
		$zip = $park->zip;
		$lat = $park->lat;
		$lon = $park->lon;
		$phone1 = $park->phone1;
		$phone2 = $park->phone2;
		$fax = $park->fax;
		$email = $park->email;
		$website = $park->website;
		$activities = $park->activities;
		$features = $park->features;
		$sitetypes = $park->sitetypes;
		$atmosphere = $park->atmosphere;
		$rates = $park->rates;
		$cost = $park->cost;
		$clubs = $park->clubs;
		$dates = $park->dates;
		$status = $park->status;
		$type = $park->type;
		
		// Create post object
		$my_post = array(
			'post_title'    => $name,
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_author'   => 2,
			'post_type'   => 'rvparks'
		);

		// Insert the post into the database
		$post_id = wp_insert_post( $my_post, $wp_error );
		wp_set_post_terms( $post_id, $state, 'rv-parks' );
		add_post_meta( $post_id, 'park_address', $address );
		add_post_meta( $post_id, 'park_city', $city );
		add_post_meta( $post_id, 'park_zip', $zip );
		add_post_meta( $post_id, 'park_lat', $lat );
		add_post_meta( $post_id, 'park_lon', $lon );
		add_post_meta( $post_id, 'park_phone1', $phone1 );		
		add_post_meta( $post_id, 'park_phone2', $phone2 );
		add_post_meta( $post_id, 'park_fax', $fax );
		add_post_meta( $post_id, 'park_email', $email );
		add_post_meta( $post_id, 'park_web', $website );
		add_post_meta( $post_id, 'park_activities', $activities );
		add_post_meta( $post_id, 'park_features', $features );		
		add_post_meta( $post_id, 'park_sitetypes', $sitetypes );
		add_post_meta( $post_id, 'park_atmosphere', $atmosphere );
		add_post_meta( $post_id, 'park_rates', $rates );
		add_post_meta( $post_id, 'park_cost', $cost );
		add_post_meta( $post_id, 'park_clubs', $clubs );
		add_post_meta( $post_id, 'park_dates', $dates );
		add_post_meta( $post_id, 'park_status', $status );
		add_post_meta( $post_id, 'park_type', $type ); 
		
		echo "{$state} and {$tid} and {$tax} updated<br />";
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