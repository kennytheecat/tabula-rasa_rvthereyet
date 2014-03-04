<?php
$post_id = $post->ID;
$post_type = get_post_type();
if ( 'rvparks' == $post_type ) {
	$field_value = 'park';
	$post_type_name = 'RV Park';
	$listing_slug = 'rv-parks';
	$listing_slug_name = 'RV Parks';
}
if ( 'rvdumps' == $post_type ) {
	$field_value = 'dump';
	$post_type_name = 'RV Dump';
	$listing_slug = 'rv-dumps';
	$listing_slug_name = 'RV Dumps';
}
if ( 'rvboons' == $post_type ) {
	$field_value = 'boon';
	$post_type_name = 'RV Boondock';
	$listing_slug = 'rv-boondocks';
	$listing_slug_name = 'RV Boondocks';
}
$values = get_post_meta( $post_id );
$status = $values['park_status'][0];

/* Basic Info Section
*******************************/
$name = get_the_title();
$type = $values['park_type'][0];	
$boon_types = wp_get_object_terms( $post_id, 'boons' );
$boon_type = $boon_types[0]->slug;
$boon_type_name = $boon_types[0]->name;
$address = $values[$field_value. '_address'][0];
$city = $values[$field_value. '_city'][0];
$lc_city = str_replace( '\'', '', strtolower( $city) );
$lc_city = str_replace( ' ', '-', strtolower( $lc_city) );
$state = wp_get_object_terms( $post_id, 'states' );
$lc_state = $state[0]->slug;
$state = $state[0]->name;
$state_abr = array_search($state, $StateNames);
$coords = unserialize($values[$field_value. '_coords'][0] );
$lat = $coords[$field_value. '_lat']; 
$lng = $coords[$field_value. '_lng'];
$meta2 = get_post_meta( $post_id);
$meta3 = unserialize($meta2[$field_value. '_basic2'][0] );
$phone1 = $meta3[$field_value. '_phone1'];
$phone2 = $meta3[$field_value. '_phone2'];
$fax = $meta3['park_fax'];
$email = $meta3['park_email'];					
$web = $meta3['park_web'];
$status = wp_get_object_terms( $post_id, 'status_levels' );
$status = $status[0]->slug;
if (strpos( $web, 'http://') !== false) {
    $web = str_replace ( 'http://', '', $web );
}

if ($type == 'STE') { 
	$basic_info .= '<p class="type">STATE PARK</p>'; 
} 
if ($type == 'FED') { 
	$basic_info .= '<p class="type">FEDERAL/NATIONAL PARK</p>'; 
} 
if ($type == 'PUB') { 
	$basic_info .= '<p class="type">CITY/COUNTY PARK</p>';
}
if ( 'rvparks' == $post_type ) {
	$ratings = unserialize($values['park_vote_fields'][0]);
	$vote_tally = $ratings[0];
	$vote_avg = $ratings[1];
	if ( $vote_avg == 0 ) { 
		$ratings_text_class = 'ratings_text_none'; 
	} else {
		$ratings_text_class = 'ratings_text'; 	
	}
}
$basic_info .= '
<h1 itemprop="name">' . $name . '</h1>
	<div class="ratings_mobile">
		<div id="ratings">' .
			get_star_rating($vote_avg, 'small') . '
		</div>
		<div class="' . $ratings_text_class . '">
			<span class="rating">
				<meta itemprop="ratingValue" content="' . $vote_avg . '">' . $vote_avg . ' out of 5
			</span>
			based on
			<span itemprop="reviewCount">' . $vote_tally . '</span> ratings.
		</div>
	</div>
<address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
	<p>
		<span itemprop="streetAddress">' . $address . '</span><br />
		<span itemprop="addressLocality">' . $city . '</span>, <span itemprop="addressRegion">' . $state_abr . '</span>
		<span itemprop="postalCode">' . $zip . '</span><br />
		GPS Coords: ' . $lat . ', ' . $lng . '<br />';
		if ( $phone1 != '') {
			$basic_info .= 'Phone: <span itemprop="telephone">' . $phone1 . '</span><br />';
		}
		if ( $phone2 != '') {
			$basic_info .= 'Phone 2: ' . $phone2 . '<br />';
		}
		if ( $fax != '') {
			$basic_info .= 'Fax: ' . $fax . '<br />';
		}
		if ( $email != '') {
			$basic_info .= '<a href="mailto:' . $email . 'subject=Inquiry%20via%20RVThereYet">Email this RV Park</a><br />';
		}
		if ( $status > 1 ) {
			$basic_info .= '<a href="http://' . $web . '" target="_blank">' . $web . '</a>';
		} else {
			$basic_info .= $web;
		}
	$basic_info .= '	
	</p>
</address>';

if ( 'rvparks' == $post_type ) {				
	/* Ratings Section
	*******************************/
	/*
	$ratings = unserialize($values['park_vote_fields'][0]);
	$vote_tally = $ratings[0];
	$vote_avg = $ratings[1];
	*/
	$ratings_section = '
	<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
	 <span class="ratings_name">' . $name . '</span><br />
		<div id="ratings">' .
			get_star_rating($vote_avg, 'large') . '
		</div>
		<div class="' . $ratings_text_class . '">
			<span class="rating">
				<meta itemprop="ratingValue" content="' . $vote_avg . '">' . $vote_avg . ' out of 5
			</span>
			based on
			<span itemprop="reviewCount">' . $vote_tally . '</span> ratings.
		</div>
	</div>
	<div class="review_button" >
		<a href="#review_box"> Read Reviews for this RV Park</a>
	</div>
	<div id="facebook_badge">
	</div>';
} else {
	/* Additional Information
	*******************************/
	/** RV Boons **/
	if ( 'rvboons' == $post_type ) {
		$overnight = $values['boon_overnight'][0];
		$additional_info = '<h2>Overnight Parking is</h2>';
		if ( $overnight == 'on' ) {
			$additional_info .= '<p>Not Allowed</p>';
		} else {
			$additional_info .= '<p>Allowed</p>';
		}
	}
	/** RV Dumps **/
	if ( 'rvdumps' == $post_type ) {
		// Set up variables
		/** Open Dates **/
		$dump_season = $values['dump_season'][0];
		if ( !empty( $dump_season ) ) {
			$dates = unserialize($values['dump_season'][0]);
			$open_dates = $dates['open_month'] . '/' . $dates['open_day'] . ' through ' . $dates['close_month'] . '/' . $dates['close_day'];
			if ( $open_dates == '1/1 through 12/31' ) { $open_dates = 'All Year'; }
			if ( $open_dates == '1/1 through 1/1' ) { $open_dates = 'stop'; }
		} else { $open_dates = 'stop';}
		/** Open Days **/
		$dump_days_open = $values['dump_days_open'][0];
		if ( !empty ( $dump_days_open ) ) {
			$dump_days_open = unserialize($values['dump_days_open'][0]);
			$open_days = '<ul>';
			foreach ( $dump_days_open as $dump_day ) {
				$open_days .= '<li>' . $dump_day . '</li>';
			}	
			$open_days .= '</ul>';
		} else { $open_days = 'stop'; }
		/** Open Hours **/
		$dump_hours_open = $values['dump_hours_open'][0];
		$dump_hours_close = $values['dump_hours_close'][0];
		if ( $dump_hours_open != 'None Selected' && $dump_hours_close != 'None Selected' ) {
			if ( $dump_hours_open != '' && $dump_hours_close != '' ) {
				$open_hours = $dump_hours_open . ' to ' . $dump_hours_close;
				if ( $open_hours == '12:00 AM to 12:00 AM' ) { 
					$open_hours = '24 Hours'; 
				}
			} else { $open_hours = 'stop';}
		} else { $open_hours = 'stop';}
		/** Dump Fees **/
		$dump_fee = $values['dump_fee'][0];
		$dump_reg_guest_fee = $values['dump_reg_guest_fee'][0];
		/** Water Availability **/
		$cats = wp_get_object_terms($post_id, 'dump_water');
		if ( !empty ( $cats ) ) {	
			$dump_water = '<ul>';
			foreach ( $cats as $cat ) {
				$dump_water .= '<li>' . $cat->name . '</li>';
			}
			$dump_water .= '</ul>';
		} else { $dump_water = 'stop';}
		
		// Set up rv Dump Information Section
		$additional_info = '<h2>RV Dump Details</h2>';
		if ( $open_dates != 'stop' || $open_days != 'stop' || $open_hours != 'stop' || $dump_fee != '' || $dump_reg_guest_fee != '' || $dump_water != 'stop' ) {
			if (  $open_dates != 'stop' ) {
				$additional_info .= '<div><span>Open Dates: </span>' . $open_dates . '</div>';
			}
			if ( $open_days != 'stop' ) {
				$additional_info .= '<div class="ul"><span>Open Days: </span>' . $open_days . '</div>';
			}
			if ( $open_hours != 'stop' ) {
				$additional_info .= '<div><span>Open Hours: </span>' . $open_hours . '</div>';
			}			
			if ( $dump_fee != '' ){
				$additional_info .= '<div><span>Dump Fee: </span>' . $dump_fee . '</div>';
			}		
			if ( $dump_reg_guest_fee != '' ) {
				$additional_info .= '<div><span>Fee for registered guests: </span>' . $dump_reg_guest_fee . '</div>';
			}	
			if (  $dump_water != 'stop' ) {
				$additional_info .= '<div class="ul"><span>Water: </span>' . $dump_water. '</div>';
			}			
		} else {
			$additional_info .= 'No RV Dump information has been provided';
		}
	}	
}

/* Featured Park
*******************************/
$feat_parks = feat_parks_query( $state ); 
if ( empty ($feat_parks ) ) { 
	$featured_park = '
	<h2>Featured  ' . $state . ' RV Park</h2>
	<div class="feat_parks no_feat_parks">
		<p>Sorry, there are no featured parks in ' . $state . '</p>
		<p>
			<a href="http://rvthereyetdirectory.com/advertise/">Become the first featured park in ' .$state . '!</a>
		</p>
	</div>';
	 } else { 
		$featured_park = '<h2>Featured  ' . $state . ' RV Park</h2>';
	  $featured_park .= $feat_parks;
		/*$num_parks = count( $feat_parks );
		$featured_park = '<h2>Featured  ' . $state . ' RV Park</h2>';
		if ( $num_parks == 1 ) {
			$featured_park .= $feat_parks[0]; 
		}	
		if ( $num_parks > 1 ) {
			shuffle($feat_parks); 
			$rand_keys = array_rand($feat_parks, $num_parks);
			$featured_park .=  $feat_parks[$rand_keys[0]];
		} */
	}
	$featured_park .= '<span class="shadow-left"></span>
	<span class="shadow-right"></span>';
					

/* Photo Gallery / Google Ad
*******************************/
$args = array(
	'post_mime_type' => 'image',
	'post_parent' => $post_id,
	'post_type' => 'attachment'
);
$images = get_children( $args );
if ($status > 2 && !empty( $images ) ){
	$photo_gallery_or_ad .= '<section class="photo_gallery">';
	$photo_gallery_or_ad .=  do_shortcode( '[portfolio_slideshow slideheight="250"]' ); 
	$photo_gallery_or_ad .=  '</section>';
} else { 
	$photo_gallery_or_ad .= '
	<div class="ad_area_aside">
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-7445595777186624";
		/* 300 X 250 */
		google_ad_slot = "6142264556";
		google_ad_width = 300;
		google_ad_height = 250;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<script type="text/javascript">
		try{document.getElementsByName("googleSearchFrame")[0].height=250;}catch(e){}
		</script>
	</div>';
}

/* Coordinates / Map Section
*******************************/
$altcamps = $values[$field_value. '_nearbys'][0];
$altcamps = unserialize($altcamps);	

$google_map = '<div id="map"';
if (!empty( $images ) ){ 
	$google_map .= ' class="isphoto"';
}
$google_map .= ' style="height: ';
if (!empty( $images ) ){ 
	$google_map .= '307';
} else { 
	$google_map .= '256'; 
}
$google_map .= 'px;"></div>';

$i = 1;
foreach ($altcamps as $key => $value ) {
	if ( $i >= 5 ) { continue; } $i++;
		$alt_id = $key;
		$alt_distance = $value;
		$alt_name = $wpdb->get_var( "SELECT post_title FROM rvty_posts WHERE ID = $alt_id" );
		$alt_values = get_post_meta( $alt_id );
		$alt_address = $alt_values[$field_value. '_address'][0];
		$alt_city = $alt_values[$field_value. '_city'][0];
		$feat_state = array_search($state, $StateNames);
		$campcoords = $wpdb->get_results( "SELECT * FROM rvty_geodata WHERE post_id = $alt_id" );		
		foreach ( $campcoords as $campcoord) {
			$alt_lat = $campcoord->geo_latitude;
			$alt_lng = $campcoord->geo_longitude;
		}						
		$marker_html = '<p>' . esc_attr( $alt_name ) . '<br />' . esc_attr( $alt_address ) . '<br />' . $alt_city . ', ' . $state_abr . '<br /><a href="' .get_permalink( $alt_id ). '">View ' . get_the_title( $alt_id ) . ' Details</a><br />Driving directions: <br /><a href="http://maps.google.com/maps?daddr=' . $alt_lat . ',' . $alt_lng . '" target="_blank">To here</a>|<a href="http://maps.google.com/maps?saddr=' . $alt_lat . ',' . $alt_lng . '" target="_blank">From here</a></p>';
		$marker_image = 'nearby2.png';
		// Check boons for overnight parking
		if ( $listing_slug == 'rv-boondocks' ) {
		$alt_overnight = $alt_values['boon_overnight'][0];
			if ( $alt_overnight == 'on' ) {
				$marker_image = 'no_overnight_nearby.png';
			}
		}	
		// Check for free dumps
		if ( $listing_slug == 'rv-dumps' ) {
		$alt_free_dump = $alt_values['dump_fee'][0];
			if ( $alt_free_dump == 'Free' ) {
				$marker_image = 'free_dump_nearby.png';
			} 
		}		
		$markers[] = "var point = new google.maps.LatLng($alt_lat,$alt_lng); var image = '" . get_template_directory_uri() . "/inc/maps/icons/$marker_image'; var marker = createMarker(point,'$marker_html', image)";
	}
	
$marker_image = 'main3.png';	
// Check boons for overnight parking
if ( $listing_slug == 'rv-boondocks' ) {
	if ( $overnight == 'on' ) {
		$marker_image = 'no_overnight_main.png';
	}
}
// Check for free dumps
if ( $listing_slug == 'rv-dumps' ) {
	if ( $dump_fee == 'Free' ) {
		$marker_image = 'free_dump_main.png';
	} 
}		
$marker_html = '<p>' . esc_attr(  $name ) . '<br />' . esc_attr( $address ) . '<br />' . esc_attr( $city ) . ', ' . $state_abr . '<br />Driving directions: <br /><a href="http://maps.google.com/maps?daddr=' . $lat . ',' . $lng . '" target="_blank">To here</a>|<a href="http://maps.google.com/maps?saddr=' . $lat . ',' . $lng . '" target="_blank">From here</a></p>';
$markers[] = "var point = new google.maps.LatLng($lat,$lng); var image = '" . get_template_directory_uri() . "/inc/maps/icons/$marker_image'; var zimp = 500; var marker = createMarker(point,'$marker_html', image, zimp)"; 

if ( 'rvparks' == $post_type ) {
	/* Advert Section
	*******************************/
	if ($status < 3) {
		$advert = '<h3>This RV park is a basic listing. <a href="http://rvthereyetdirectory.com/advertise/">Click here to purchase an Enhanced Listing!</a></h3>';
	} else {
		$advert = '<h3>This RV park is a basic listing. <a href="http://rvthereyetdirectory.com/advertise/">Click here to purchase an Enhanced Listing!</a></h3>';
	}

	/* Details Section
	*******************************/
	function details_list ( $post_id, $taxonomy_name ) {
		if ( $taxonomy_name == 'clubs') { include ('assets/array_clubs.php'); }
		$cats = wp_get_object_terms($post_id, $taxonomy_name);
		if ( !empty ( $cats ) ) {
			$list = '<ul class="details_list ' . $taxonomy_name . '">';
			if ( $taxonomy_name == 'clubs') {
				foreach ( $cats as $cat ) {		
					$list .= '<li><a href="' . $cluburls[$cat->slug] . '"><img src="' . get_template_directory_uri() . '/images/clubs/' . $cat->slug . '.jpg"></a></li>';
				}
			} else {
				foreach ( $cats as $cat ) {
					$list .= '<li>' . $cat->name . '</li>';
				}		
			}
			$list .= '</ul>';
			return $list;
		} else {
			//echo $taxonomy_name . ': empty<br />';
			$list = 'stop';
			return $list;
		}
	}

	function other_details_list ( $cats ) {
		if ( !empty ( $cats ) ) {
			$list = '<ul class="details_list ' . $taxonomy_name . '">';
			foreach ( $cats as $cat ) {
				$list .= '<li>' . $cat . '</li>';
			}
			$list .= '</ul>';
			$healthy = array("rates_options_dry", "rates_options_stay", "rates_charges_50amp", "rates_charges_pullthrough", "rates_charges_wifi");
			$yummy   = array("Dry Hookups Not Offered", "Extended Stay Discounts", "50 Amp Sites", "Pull Through Sites", "Wifi");
			$list = str_replace($healthy, $yummy, $list);		
			return $list;
		} else {
			$list = 'stop';
			return $list;
		}
	}

	// Park Details
	$details_count = 2; // Start details count to keep nearby camps from being too long
	/** Open Dates **/
	$dates = $values['park_season'][0];
	if ( !empty($dates) ) {
		$dates = unserialize($values['park_season'][0]);
		$dates = $dates['open_month'] . '/' . $dates['open_day'] . ' through ' . $dates['close_month'] . '/' . $dates['close_day'];
		if ( $dates == '1/1 through 12/31' ) { $dates = 'All Year'; }
		if ( $dates == '1/1 through 1/1' ) { $dates = 'stop'; }
		if ( $dates == '/ through /' ) { $dates = 'stop'; }
	} else { $dates = 'stop';}
	$features = details_list ( $post_id, 'features' );
	$activities = details_list ( $post_id, 'activities' );
	$atmospheres = details_list ( $post_id, 'atmospheres' );	
		
	if ( $dates != 'stop' || $features != 'stop' || $activities != 'stop' || $atmospheres != 'stop' ) { 
		$park_details_proceed = 'go';
		$details_count = $details_count + 2;
	}
	$park_details_header = '<h2>RV Park Details</h2>';
	$dates_list = '<h3>RV Park Open Dates: </h3><p>' . $dates . '</p>';
	$features_list = '<h3>Features</h3>' . $features;
	$activities_list = '<h3>Activities</h3>' . $activities;
	$atmospheres_list = '<h3>Atmosphere</h3>' . $atmospheres;
	$park_no_details = '<p>This campground has not provided RV Park details.</p>';

	//RV Sites
	$site_num = $values['park_numberofsites'][0];
	$hookups = details_list( $post_id, 'hookups' );
	$accommodations = details_list ( $post_id, 'accommodations' );
	$other_camping = details_list ( $post_id, 'other_camping' );
	// Setup Site variables to pass
	if (  !empty( $site_num ) || $hookups != 'stop' || $accommodations != 'stop' || $other_camping != 'stop' ) { 
		$site_details_proceed = 'go';
		$details_count = $details_count + 2;
	}
	$site_details_header = '<h2>RV Site Details</h2>';
	$site_num_list .= '<h3>Number of RV Sites: </h3><p>' . $site_num . '</p>';
	$site_hookups_list .= '<h3>Site Hookups</h3>' . $hookups;
	$site_accommodations_list .= '<h3>Site Accommodations</h3>' . 		$accommodations;
	$site_other_camping_list .= '<h3>Other Camping Types</h3>' . 		$other_camping;
	$site_no_details = '<p>This campground has not provided RV Site details.</p>';

	//Rate Information
	$rates_full = $values['park_rates_full'][0];
	$rates_dry = $values['park_rates_dry'][0];
	$rates_tent = $values['park_rates_tent'][0];
	$rates_charges = unserialize( $values['park_rates_charges'][0] );
	$rates_charges = other_details_list ( $rates_charges );
	$payments = details_list ( $post_id, 'payments' );	
	$discounts = details_list ( $post_id, 'discounts' );	

	//Set up rate variables to pass
	if ( $rates_full != '' || $rates_dry != '' || $rates_tent != '' || $rates_charges != 'stop' || $payments != 'stop' || $discounts != 'stop' ) {
		$rate_details_proceed = 'go';
		$details_count = $details_count + 2;
	}
	$rates_details = '<h2>Rate Information</h2>';
	if ( $rates_full != '' || $rates_dry != '' || $rates_tent != '') { 	$rates_info = '<h3>Typical Daily Rate for: </h3>';
	}
	if ( $rates_full != '') {
		$rates_info .= 'Full Hookup: $' . $rates_full . '<br />';
	}
	if ( $rates_dry != '') {
		$rates_info .= 'Dry Camping: $' . $rates_dry . '<br />';
	} 
	if ( $rates_tent != '') {
		$rates_info .= 'Tent Camping: $' . $rates_tent . '<br />';
	} 
	$payments_list .= '<h3>Payment Methods</h3>' . $payments;
	$discounts_list .= '<h3>Discounts Accepted</h3>' . $discounts;
	$rates_charges_list .= '<h3>Additional Charges for </h3>' . $rates_charges;
	$rates_no_details = '<p>This campground has not provided RV Rate details.</p>';

	// Club Details
	//$clubs = $values['park_clubs'][0];
	//$clubs = details_list( 'clubs' );
	$clubs = details_list( $post_id, 'clubs' );
	if ( $clubs != 'stop' ) { 
		$club_details_proceed = 'go'; 
		$details_count = $details_count + 2;
	}
	$club_details_header = '<h2>RV Clubs</h2>';
	$clubs_list = $clubs;

	$club_no_details = '<p>This campground has not provided RV Club information.</p>';
}
/* Description or Nearby
*******************************/
/** Description or Nearby is below details section to get the correct $details count **/
if ( $status > 2 && $post->post_content != "" ) {
	$description_or_nearby = '<div class="description"><h2>RV Park Description</h2><p>' . 
	get_the_content() . '</p></div>';
} else {
	$description_or_nearby = '<div class="nearby"><h2>Nearby ' . $post_type_name . 's</h2><ul>';
	
	// Counter so number of detail section correspond with nearby parks
	$i = 1;
	if ( 'rvparks' != $post_type ) { $details_count = 8;}
	foreach ($altcamps as $key => $value ) {
		if ( $details_count >= $i ) {
			$alt_id = $key;
			$alt_distance = $value;
			$altcamp = $wpdb->get_results( "SELECT * FROM rvty_posts WHERE ID = $alt_id" );
			foreach ( $altcamp as $altc) {
				$custom_fields = get_post_meta( $alt_id );
				$alt_city = $custom_fields[$field_value.'_city'][0];
				$alt_lc_city = strtolower( str_replace( ' ', '-',  $alt_city ) );
				$alt_tax_cat = strtolower( str_replace( ' ', '-', $altc->post_title  ) );
				$alt_tax_cat = str_replace( 'l m', 'l-m', $alt_tax_cat  );				
				$ratings = unserialize($custom_fields['park_vote_fields'][0]);
				$vote_avg = $ratings[1];				
				$description_or_nearby .= '<li><a href="' . get_permalink( $alt_id ) . '">' . $altc->post_title . '</a><br /><a href="' .home_url() . '/' . $listing_slug . '/';
				if ( 'rvboons' == $post_type ) {
					$description_or_nearby .= $alt_tax_cat ;
				}
				$description_or_nearby .= '/' . $lc_state . '/' . $alt_lc_city . '/">' . $alt_city . '</a><br />' . $alt_distance . ' miles away<br />';
				if ( 'rvparks' == $post_type ) {
					$description_or_nearby .= get_star_rating($vote_avg, 'small') . '<br />';
				}
				$description_or_nearby .= '</li>';			
			}
			$i++;
		}
	}
	$description_or_nearby .= '</ul></div>';
}

/* Setup Listing menus
*****************************************************/
if ( $listing_slug == 'rv-dumps' || $listing_slug == 'rv-parks' ) {
	$listing_nav = '<p><a href="' .home_url() . '/' . $listing_slug . '/">' . $listing_slug_name . ' >></a> <a href="' .home_url() . '/' . $listing_slug . '/' . $lc_state . '/">' . $state . ' ' . $listing_slug_name . ' >></a> <a href="' .home_url() . '/' . $listing_slug . '/' . $lc_state . '/' . $lc_city . '/">' . $city . ', ' . $state . ' ' . $listing_slug_name . '</a></p>';
}
if ( $listing_slug == 'rv-boondocks' ) {
	$listing_nav = '<p><a href="' .home_url() . '/' . $listing_slug . '/">' . $listing_slug_name . ' >></a> <a href="' .home_url() . '/' . $listing_slug . '/' . $lc_state . '/' . $boon_type . '/">' . $state . ' ' . $boon_type_name . ' '. $listing_slug_name . ' >></a> <a href="' .home_url() . '/' . $listing_slug . '/' . $lc_state . '/' . $lc_city . '/' . $boon_type . '/">' . $city . ', ' . $state . ' ' . $boon_type_name . ' '. $listing_slug_name . '</a></p>';
}
?>