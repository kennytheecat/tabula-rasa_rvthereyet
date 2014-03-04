<?php
/**
Template Name: Listing Pages RV Clubs
 */
get_header();

if ( get_query_var( 'clubs' ) ) {
	$club = get_query_var( 'clubs' );
	$uc_club = ucwords( str_replace( '-', ' ', $club ) );
	$tax1 = 'clubs';
}
if ( get_query_var( 'states' ) ) {
	$lc_state = get_query_var( 'states' );
}
if ( get_query_var( 'cities' ) ) {
	$city_term = get_query_var( 'cities' );
	$tax1 = 'cities';
	$lc_city = $city_term;
}
$city = ucwords( str_replace( '-', ' ', $lc_city ) );
$city_main = $city;
$state = ucwords( str_replace( '-', ' ', $lc_state ) );

$city_clubs = array();
$found_clubs = array();
$not_found_clubs = array();
$not_found_clubs_cities = array();
$list_parks_nearby_array = array();

$args = array(
	'posts_per_page'  => -1,
	'orderby'         => 'meta_value',
	'order'           => 'ASC',
	'meta_key'        => 'park_city',
	'post_type'       => 'rvparks',
	'states'        	=> $state,
	'post_status'     => 'publish'
); 
$cat_posts = get_posts( $args );

foreach( $cat_posts as $post ) {
	// Get basic info for listings
	$marker_html = '';
	$custom_fields = get_post_custom( $post->ID );
	$address = $custom_fields['park_address'][0];
	$city = $custom_fields['park_city'][0];
	$lc_city = str_replace( ' ', '-', strtolower( $city ) );
	$zip = $custom_fields['park_zip'][0];	

	// create listing for parks that have the club
	if( has_term( $club, 'clubs', $post->ID ) ) {
	
		// Add title and address if this is city club listing
		if ( !empty ( $city_term ) ) {
			$marker_html = get_the_title() . '<br />' . 
			$address . '<br />';
		}
		
		// Create markers for map - only for camps with clubs
		$marker_html .= $city . ', ' . $state . '<br />';
		$coords = unserialize($custom_fields['park_coords'][0] );
		$lat = $coords['park_lat']; 
		$lng = $coords['park_lng'];
		$markers[] = "var point = new google.maps.LatLng($lat,$lng); var image = '" . get_template_directory_uri() . "/inc/maps/icons/green.png';  var marker = createMarker(point,'$marker_html', image)"; 
		
		// If this is a city page, do more stuff
		if ( !empty ( $city_term ) ) {
			
			// If this is the same city that is in the url
			if ( $city_term == $lc_city ) {
				$ratings = unserialize($custom_fields['park_vote_fields'][0]);
				$vote_avg = $ratings[1];
				$list_cities .= '	<li><a href="' .get_permalink( $post->ID ). '">' . get_the_title( $post->ID ) . '</a><br />' . get_star_rating($vote_avg, 'small') . '<br /></li>';
				$main_lat = $lat;
				$main_lng = $lng;
			} else {
				// Create an array of park ids that match the club but are not in the city url
				$not_found_clubs_listings[] = $post->ID;
			}
		} else {
			// It's not a city listing, so list city names that have clubs
			$list_cities .= '	<li><a href="' .home_url() . '/rv-clubs/' . $club . '/' . $lc_state . '/' . $lc_city . '/">' . $city . '</a></li>';
		}
		$city_clubs[] = $city;
		$found_clubs[] = $lat;
		$previous_city = $city;	
	} else { // End matching club section
		// It does not have a matching club, so create array of ids of non matching parks
		if ( !empty( $city_term ) ) { continue; }
		if ( empty ( $city_term ) && $city == $previous_city ) { continue; }
		$not_found_clubs_listings[] = $post->ID;
	}
}

// If a club state listing
if ( empty ( $city_term ) ) {
	foreach( $not_found_clubs_listings as $not_found_club_id ) {
		$custom_fields = get_post_custom( $not_found_club_id );
		$coords = unserialize($custom_fields['park_coords'][0] );
		$city = $custom_fields['park_city'][0];
		$lc_city = str_replace( ' ', '-', strtolower( $city ) );	
		$bounds = 1;
		$not_found_lat = $coords['park_lat']; 
		
		$listed_city = '';
		foreach ( $found_clubs as $fc ) {
			if ( in_array( $city, $city_clubs) ) { continue; }
			if ( empty ( $city_term ) && $city == $previous_city ) { break; }
			$found_lat = $fc;
			if ( $found_lat <= $not_found_lat + $bounds || $found_lat >= $not_found_lat - $bounds ) {
				if ( $listed_city != 'yes' ) {
					$list_parks_nearby .= '	<li><a href="' .home_url() . '/rv-clubs/' . $club . '/' . $lc_state . '/' . $lc_city . '/">' . $city . '</a></li>';
					$listed_city = 'yes';
				}
			}
		}
		$previous_city = $city;	
	}	
}

if ( !empty ( $city_term ) ) {
	foreach ( $not_found_clubs_listings as $not_found_club_id ) {
		$custom_fields = get_post_custom( $not_found_club_id );
		$coords = unserialize($custom_fields['park_coords'][0] );
		$lat = $coords['park_lat']; 
		$lng = $coords['park_lng'];
		$alt_distance = distance($main_lat, $main_lng, $lat, $lng, "M");
		$ratings = unserialize($custom_fields['park_vote_fields'][0]);
		$vote_avg = $ratings[1];
		$list_parks_nearby2 = '<li><a href="' .get_permalink( $not_found_club_id ). '">' . get_the_title( $not_found_club_id ) . '</a><br />' . $alt_distance . ' miles away<br />' . get_star_rating($vote_avg, 'small') . '<br /></li><hr />';
		$list_parks_nearby_array[$alt_distance] = $list_parks_nearby2;
	}
	ksort($list_parks_nearby_array);
	foreach( $list_parks_nearby_array as $list_parks_test ) {
		$list_parks_nearby .= $list_parks_test;
	}
}
?>
	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<div id="rv2p_row2_col1">
				<h2>
					<?php 
					if ( !empty ( $city_term ) ) {
						echo $uc_club . ' RV Parks in ' . $city_main;
					} else { 
						echo $uc_club . ' RV Parks in ' . $city_main;
					} 
					?>
				</h2>
				<ul>
					<?php 
					echo $list_cities; 
					echo '<li><h3>Nearby ' . $uc_club . ' RV Parks: </h3></li>';
					echo $list_parks_nearby;
					?>
				</ul>
			</div>
			<?php
			/* Start the Loop */
			$previousLevel = '';
			?>	
			<div id="rv2p_row2_col2">	
			<h2>RV Parks in <?php echo $state; ?></h2>
				<section id="archive_rvpark_gmap_wrapper" >
					<div id="map">
					<?php include('inc/maps/map_page-rv2pages.php');  ?>
					</div>
				</section> <!-- #map_wrapper -->
			</div>
			<div id="rv2p_row2_col3">	
				<section id="ad_area_aside">
					<h2><?php echo $state; ?> RV Blogs</h2>
						<?php blog_list($state, 2, 160, 'listing-blog-thumb'); ?>
				</section>			
			</div> <!-- end id="rv2p_row1_col2" -->			
			<section class="review_columns">
			<h2>Recent Comments</h2>
			<?php 
			$args = array(
				'status' => 'approve',
				'number' => '4',
				'parent' => 0,
			);
			echo get_recent_reviews ( $args );
			?>
			</section>
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_footer(); ?>