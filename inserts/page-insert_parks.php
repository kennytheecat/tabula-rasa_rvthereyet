<?php
/*
Template Name: Function: Insert Parks
*/
get_header();

$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
	$parks_query = $wpdb->get_results( "SELECT * FROM rvty_parks WHERE state = '$submited_state' ORDER BY name ASC" );
	$i=1;
	foreach ($parks_query as $park) {
		$old_wpid = $park->wpid;
		$status = $park->status;
		$type = $park->type;	
		$name = $park->name;
		$address = $park->address;
		$city = $park->city;
		// use StateNames array to get long version of state name
		$state = $park->state;
		$state = $StateNames[$submited_state];
		$state = term_exists( $state, 'states' );
		$zip = $park->zip;
		$phone1 = $park->phone1;
		$phone2 = $park->phone2;
		$fax = $park->fax;
		$email = $park->email;
		$web = $park->website;
		$basic2 = array( 'park_phone1' => $phone1, 'park_phone2' => $phone2,'park_fax' => $fax,'park_email' => $email,'park_web' => $web );
		$lat = $park->lat;
		if ( $lat == 0 ) { continue; }
		$lng = $park->lon;
		if ( $lng == 0 ) { continue; }
		$coords = array( 'park_lat' => $lat, 'park_lng' => $lng );
		
		$new_activities = array();
		$new_features = array();
		$new_hookups = array();
		$new_accommodations = array();
		$new_other_camping = array();
		$new_atmospheres = array();
		$new_rates = array();
		$new_dates = array();
		$new_clubs = array();
		$new_discounts = array();
		$new_filters = array();
		$new_filters = array();
		
		$activities = $park->activities;
		if ( $activities != '' ) {
			$activities = explode('|', $activities);
			foreach ( $activities as $activity ) {
				if ( $activity == 1  ) { // Arcade
					$term = term_exists( 'Arcade/Game Room', 'activities' );
					$new_activities[] = $term['term_id']; //73
				}
				if ( $activity == 3  ) { // Basketball
					$term = term_exists( 'Basketball', 'activities' );
					$new_activities[] = $term['term_id']; //73
				}
				if ( $activity == 7  ) { // Billiards
				if ( $activity == 9  ) { // Boat-Limited
					$same_boat = 'yes';
				if ( $activity == 10 ) { // Boat-Power
					if ( $same_boat != 'yes' ) {
						$same_boat = 'yes';
					}
				if ( $activity == 11 ) { // Boat-Paddle
				if ( $activity == 12 ) { // Boat-Watercraft
					if ( $same_boat != 'yes' ) {
						$same_boat = 'yes';
						$term = term_exists("Boating", "activities"); 
					}
				if ( $activity == 13 ) { // Chapel Services
				if ( $activity == 14 ) { // Climbing
				if ( $activity == 17 ) { // Education Activities
					$term = term_exists("Planned Activities", "activities"); 
				if ( $activity == 19 ) { // Family Activities
						$same_activity = 'yes';
						$term = term_exists("Planned Activities", "activities"); 
					}
				if ( $activity == 20 ) { // Fishing
					$term = term_exists( 'Fishing', 'activities' );
					$new_activities[] = $term['term_id']; //81
				}
				if ( $activity == 21 ) { // Fly Fishing
				if ( $activity == 23 ) { // Golfing
				if ( $activity == 25 ) { // Hiking
				if ( $activity == 26 ) { // Horseback Riding
				if ( $activity == 27 ) { // Horseshoes
				if ( $activity == 28 ) { // Hot Springs
				if ( $activity == 30 ) { // Mini Golf
				if ( $activity == 33 ) { // Ping Pong
				if ( $activity == 34 ) { // River Rafting
				if ( $activity == 38 ) { // Senior Activities
					if ( $same_activity != 'yes' ) {
						$same_activity = 'yes';
						$term = term_exists("Planned Activities", "activities");
						$new_activities[] = $term['term_id'];
					}
				if ( $activity == 39 ) { // Shuffleboard
				if ( $activity == 41 ) { // Ski-Cross Country
					$same_ski = 'yes';
					$term = term_exists("Skiing", "activities"); 
					$new_activities[] = $term['term_id'];//100
				}
				if ( $activity == 42 ) { // Ski-Downhill
					if ( $same_ski != 'yes' ) {
						$same_ski = 'yes';
						$term = term_exists("Skiing", "activities"); 
						$new_activities[] = $term['term_id'];
					}
				}
				if ( $activity == 43 ) { // Snowboarding
				if ( $activity == 44 ) { // Snowmobiling
				if ( $activity == 45 ) { // Surfing
				if ( $activity == 46 ) { // Swimming
					$same_swim = 'yes';
				if ( $activity == 47 ) { // Tennis
				if ( $activity == 49 ) { // Tubing
				if ( $activity == 50 ) { // Volleyball
			}
		}
		
		$features = $park->features;
		if ( $features != '' ) {
			$features = explode('|', $features);
			foreach ( $features as $feature ) {		
				if ( $feature == 0  ) { // 50 Amp Availability
						$same_50 = 'yes';
						$term = term_exists("50 Amp", "hookups"); 
						$new_hookups[] = $term['term_id'];
						$new_filters[] = $term['term_id'];
				if ( $feature == 1  ) { // BBQ Facilities
				if ( $feature == 3  ) { // Boat Ramp
				if ( $feature == 4  ) { // Boat Rentals
				if ( $feature == 5  ) { //Cabins/Rentals
				if ( $feature == 6  ) { // Cable TV
				if ( $feature == 7  ) { // Campfire Pits
				if ( $feature == 8  ) { // Camp Store
					$same_store = 'yes';
				if ( $feature == 9  ) { 
				if ( $feature == 10 ) { // Courtesy Dock
				if ( $feature == 11 ) { //Diner/Snack Bar
					if ( $same_store != 'yes' ) {
						$same_store = 'yes';
					}
				if ( $feature == 12 ) { // Dump Station
					$new_filters[] = $term['term_id'];					
				if ( $feature == 14 ) { // Forest Areas
				if ( $feature == 15 ) { // Full Hookups
					$same_full_hookups = 'yes';
				if ( $feature == 16 ) { 
				if ( $feature == 17 ) { 
					$same_group = 'yes';
				if ( $feature == 18 ) { 
					if ( $same_group != 'yes' ) {			
						$same_group = 'yes';
				}
				if ( $feature == 19 ) { 
				if ( $feature == 20 ) { 
					$same_corral = 'yes';
				if ( $feature == 21 ) { 
				if ( $feature == 22 ) { //Hot Tub
					$same_tubsauna = 'yes';
				if ( $feature == 23 ) { // Internet Access
				if ( $feature == 24 ) { // Lake
				if ( $feature == 25 ) { //Laundry
				if ( $feature == 26 ) { // Livestock Corrals
					if ( $same_corral = 'yes' ) {
						$same_corral = 'yes';
					}
				if ( $feature == 27 ) { // LP Gas
				if ( $feature == 28 ) { // Ocean
				if ( $feature == 31 ) { // Pavillion
				if ( $feature == 33 ) { // Picnic Area
				if ( $feature == 34 ) { // Playground
				if ( $feature == 35 ) { 
					if ( $same_swim = 'yes' ) {
						$same_swim = 'yes';
					}
				if ( $feature == 36 ) { 
					$same_pull = 'yes';
				if ( $feature == 37 ) { // Recreation Hall
				if ( $feature == 38 ) { 
				if ( $feature == 39 ) { 
				if ( $feature == 40 ) { // River Access
				if ( $feature == 41 ) { 
					if ( $same_tubsauna = 'yes' ) {
						$same_tubsauna = 'yes';
					}
				if ( $feature == 43 ) { 
					if ( $same_tubsauna = 'yes' ) {
						$same_tubsauna = 'yes';
					}
				if ( $feature == 45 ) { // RV Storage
				if ( $feature == 46 ) { // Bike Rentals
				if ( $feature == 47 ) { // Kitchen
				if ( $feature == 48 ) { 
					if ( $same_activity = 'yes' ) {
						$same_activity = 'yes';
					}
				if ( $feature == 49 ) { // Fitness Center
				if ( $feature == 50 ) { 
				if ( $feature == 51 ) { // WiFi
					$new_filters[] = $term['term_id'];
				if ( $feature == 52 ) { 
					$same_big = 'yes';
					$new_filters[] = $term['term_id'];
				if ( $feature == 53 ) { 
					$same_pet = 'yes';
					$new_filters[] = $term['term_id'];
			}
		}
		
		$sitetypes = $park->sitetypes;
		if ( $sitetypes != '' ) {
			$sitetypes = explode('|', $sitetypes);
			$park_num = '';
			if ( $sitetypes[0] != 0 ) {
				$park_num = $sitetypes[0];
			}
			if ( $sitetypes[1] != 0 ) {
				if ( $same_full_hookups != 'yes' ) {
					$same_full_hookups = 'yes';
					$term = term_exists("Full Hookups", "hookups"); 
					$new_hookups[] = $term['term_id'];
				}
			}		
			if ( $sitetypes[2] != 0 ) {
				if ( $same_pull = 'yes' ) {
					$same_pull = 'yes';
					$term = term_exists("Pull Through Sites", "accommodations"); 
					$new_accommodations[] = $term['term_id'];
				}
			}
			if ( $sitetypes[3] != 0 ) {
				$term = term_exists("Paved Sites", "accommodations"); 
				$new_accommodations[] = $term['term_id'];
			}	
			if ( $sitetypes[4] != 0 ) {
				if ( $same_50 != 'yes' ) {
					$same_50 = 'yes';
					$term = term_exists("50 Amp", "hookups"); 
					$new_hookups[] = $term['term_id'];
					$new_filters[] = $term['term_id'];
				}
			}
			if ( $sitetypes[5] != 0 ) {
				if ( $same_big = 'yes' ) {
					$same_big = 'yes';
					$term = term_exists("Big Rig Capable", "accommodations"); 
					$new_accommodations[] = $term['term_id'];
					$new_filters[] = $term['term_id'];
				}
			}		
			if ( $sitetypes[6] != 0 ) {
				$term = term_exists("Tent Sites", "other_camping"); 
				$new_other_camping[] = $term['term_id'];
				$new_filters[] = $term['term_id'];
			}					
			}
		
		$atmospheres = $park->atmosphere;
		if ( $atmospheres != '' ) {
			$atmospheres = explode('|', $atmospheres);
			foreach ( $atmospheres as $atmosphere ) {
				if ( $atmosphere == 0  ) { // 24hr Courtesy Patrol
					$term = term_exists("24hr Courtesy Patrol", "features"); 
					$new_features[] = $term['term_id'];
				}
				if ( $atmosphere == 1  ) { // Adult Park
					$term = term_exists("Adult 21 And Over", "atmospheres"); 
					$new_atmospheres[] = $term['term_id'];
				}
				if ( $atmosphere == 2  ) { // Family Park
					$term = term_exists("Family Friendly", "atmospheres"); 
					$new_atmospheres[] = $term['term_id'];
				}
				if ( $atmosphere == 3  ) { // 55+ Park
					$term = term_exists("Age Restricted (55+)", "atmospheres"); 
					$new_atmospheres[] = $term['term_id'];
				}
				if ( $atmosphere == 4  ) { // Pets Welcome
					if ( $same_pet = 'yes' ) {
						$same_pet = 'yes';
						$term = term_exists("Pet Friendly", "atmospheres"); 
						$new_atmospheres[] = $term['term_id'];
						$new_filters[] = $term['term_id'];
					}
				}
				if ( $atmosphere == 9  ) { // Snowbird Friendly
					$term = term_exists("Snowbird Friendly", "atmospheres"); 
					$new_atmospheres[] = $term['term_id'];
					$new_filters[] = $term['term_id'];
				}
			}
		}
		
		$rates = $park->rates;
		if ( $rates != '' ) {
			$rates = explode('|', $rates);
			foreach ( $rates as $rate ) {
				if ( $rate == 1  ) {
					$term = term_exists("Groups", "discounts"); 
					$new_discounts[] = $term['term_id'];
				}
				if ( $rate == 2  ) { // Credit Cards Accptd
					$term = term_exists("Credit Cards Accepted", "payments"); 
					$new_rates[] = $term['term_id'];
				}
				if ( $rate == 3  ) {
					$term = term_exists("Monthly Stay", "discounts"); 
					$new_discounts[] = $term['term_id'];
				}
			}
		}
		
		$cost = $park->cost;
		if ( $cost != '' ) {
			$cost = explode('|', $cost);
			$rates_full = '';
			$rates_dry = '';
			if ( $cost[0] != 0 ) {
				$rates_full = $cost[0];
			}
			if ( $cost[6] != 0 ) {
				$rates_dry = $cost[6];
			}		
		} else {
			$rates_full = '';
			$rates_dry = '';		
		}
		
		$dates = $park->dates;
		if ( !empty( $dates ) ) {
			$dates1 = explode('-', $dates);
			$dates2 = explode('/', $dates1[0]);
			$dates3 = explode('/', $dates1[1]);
			$new_dates['open_month'] = $dates2[0];
			$new_dates['open_day'] = $dates2[1];
			$new_dates['close_month'] = $dates3[0];
			$new_dates['close_day'] = $dates3[1];		
		}
		
		$clubs = $park->clubs;
		if ( $clubs != '' ) {
			$clubs = explode('|', $clubs);
			foreach ( $clubs as $club ) {
				if ( $club == 'x'  ) { 
					$term = term_exists("Good Sam Club", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 1  ) {
					$term = term_exists("Happy Campers", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 2  ) {
					$term = term_exists("Camp Club USA", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 3  ) {
					$term = term_exists("Passport America", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 4  ) {
					$term = term_exists("Adventure Camping Network", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 5  ) { 
					$term = term_exists("Adventure Outdoor Resorts", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 6  ) { 
					$term = term_exists("Best Parks in America", "clubs"); 
					$new_clubs[] = $term['term_id'];
				} 
				if ( $club == 7  ) {
					$term = term_exists("Coast to Coast", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 8  ) { 
					$term = term_exists("Encore", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 9  ) { 
					$term = term_exists("Enjoy America", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 10  ) { 
					$term = term_exists("Escapees", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 11  ) {
					$term = term_exists("C2C Good Neighbor Parks", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 12  ) {
					$term = term_exists("KOA", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 13  ) {
					$term = term_exists("KM Resorts of America", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 14  ) {
					$term = term_exists("Thousand Trails", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 15  ) { 
					$term = term_exists("TT Leisure Time Resorts", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 16  ) { 
					$term = term_exists("TT Mid-Atlantic Resorts", "clubs"); 
					$new_clubs[] = $term['term_id'];
				} 
				if ( $club == 17  ) {
					$term = term_exists("TT NACO", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 18  ) { 
					$term = term_exists("TT Outdoor World", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 19  ) { 
					$term = term_exists("TT ELS Park Pass", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 20  ) { 
					$term = term_exists("North American Camping Club", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 21  ) {
					$term = term_exists("Outdoor Adventures", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 22  ) {
					$term = term_exists("FMCA", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 23  ) {
					$term = term_exists("Recreation USA", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 24  ) {
					$term = term_exists("Resort Parks International", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 25  ) { 
					$term = term_exists("Resorts of Destinction", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 26  ) { 
					$term = term_exists("Sunbelt USA", "clubs"); 
					$new_clubs[] = $term['term_id'];
				} 
				if ( $club == 27  ) {
					$term = term_exists("Sunrise Resorts", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 28  ) { 
					$term = term_exists("Western Horizon Resorts", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 29  ) { 
					$term = term_exists("Premier RV Resorts", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 30  ) { 
					$term = term_exists("Outdoor Resorts of America", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 31  ) {
					$term = term_exists("Yogi Bears Jellystone Park", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 32  ) {
					$term = term_exists("AAA", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 33  ) {
					$term = term_exists("AARP", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
				if ( $club == 34  ) {
					$term = term_exists("Guests First RV Resorts", "clubs"); 
					$new_clubs[] = $term['term_id'];
				}
			}
		}
		
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
		if ( $status != '' ) { add_post_meta( $post_id, 'park_status', $status ); }
		if ( $type != '' ) { add_post_meta( $post_id, 'park_type', $type ); } 
		if ( $address != '' ) { add_post_meta( $post_id, 'park_address', $address ); }
		if ( $city != '' ) { add_post_meta( $post_id, 'park_city', $city ); }
		wp_set_post_terms( $post_id, $state, 'states' );
		if ( $zip != '' ) { add_post_meta( $post_id, 'park_zip', $zip ); }
		if ( $basic2 != '' ) { add_post_meta( $post_id, 'park_basic2', $basic2 ); }
		if ( $coords != '' ) { add_post_meta( $post_id, 'park_coords', $coords ); }
		wp_set_post_terms( $post_id, $new_activities, 'activities' );
		wp_set_post_terms( $post_id, $new_features, 'features' );
		if ( $park_num != '' ) { add_post_meta( $post_id, 'park_numberofsites', $park_num ); }
		wp_set_post_terms( $post_id, $new_hookups, 'hookups' );
		wp_set_post_terms( $post_id, $new_accommodations, 'accommodations' );
		wp_set_post_terms( $post_id, $new_other_camping, 'other_camping' );
		wp_set_post_terms( $post_id, $new_atmospheres, 'atmospheres' );
		wp_set_post_terms( $post_id, $new_rates, 'payments' );
		if ( $rates_full != '' ) { add_post_meta( $post_id, 'park_rates_full', $rates_full ); }
		if ( $rates_dry != '' ) { add_post_meta( $post_id, 'park_rates_dry', $rates_dry ); }
		if ( !empty( $dates ) ) { add_post_meta( $post_id, 'park_season', $new_dates ); }
		wp_set_post_terms( $post_id, $new_clubs, 'clubs' );
		wp_set_post_terms( $post_id, $new_discounts, 'discounts' );
		wp_set_post_terms( $post_id, $new_filters, 'filters' );		

/*		echo "{$post_id} and {$name} and {$city} updated<br />";
		if ( $new_activities ) {
			echo 'activities: ';
			print_r($new_activities);
			echo '<br />';
		}
		if ( $new_features ) {
			echo 'features: ';
			print_r($new_features);
			echo '<br />';
		}
		if ( $new_hookups ) {
			echo 'hookups: ';
			print_r($new_hookups);
			echo '<br />';
		}
		if ( $new_accommodations ) {
			echo 'accommodations: ';
			print_r($new_accommodations);
			echo '<br />';
		}
		if ( $new_other_camping ) {
			echo 'other_camping: ';
			print_r($new_other_camping);
			echo '<br />';
		}	
		if ( $new_atmospheres ) {
			echo 'atmospheres: ';
			print_r($new_atmospheres);
			echo '<br />';
		}
		if ( $new_rates ) {
			echo 'rates: ';
			print_r($new_rates);
			echo '<br />';
		}	
		if ( $new_dates ) {
			echo 'dates: ';
			print_r($new_dates);
			echo '<br />';
		}		
		if ( $new_clubs ) {
			echo 'clubs: ';
			print_r($new_clubs);
			echo '<br />';
		}			
		if ( $new_discounts ) {
			echo 'discounts: ';
			print_r($new_discounts);
			echo '<br />';
		}
	*/	
		/** Comments
		********************************/
		$comments_query = $wpdb->get_results( "SELECT * FROM rvty_comments_copy WHERE comment_post_ID = '$old_wpid' ORDER BY comment_date ASC" );
		if ( !empty( $comments_query ) ) {
			$ratings_array = array();
			foreach($comments_query as $comment) {
				$old_comment_id = $comment->comment_ID;
				$data = array(
					'comment_post_ID' => $post_id,
					'comment_author' => $comment->comment_author,
					'comment_author_email' => $comment->comment_author_email,
					'comment_author_url' => $comment->comment_author_url,
					'comment_date' => $comment->comment_date,
					'comment_date_gmt' => $comment->comment_date_gmt,
					'comment_content' => $comment->comment_content,
					'comment_approved' => $comment->comment_approved,
					'user_id' => $comment->user_id,						
				);
				$new_comment_id = wp_insert_comment($data);
				$rvp_vote = $wpdb->get_var( "SELECT meta_value FROM rvty_commentmeta_copy WHERE comment_id = '$old_comment_id'" );
				//$rvp_vote = get_comment_meta( $comment_id, 'rvp_vote', true );
				add_comment_meta( $new_comment_id, 'rvp_vote', $rvp_vote );	
				$ratings_array[] = $rvp_vote;
			}
			$vote_tally = count($ratings_array);
			$vote_sum = array_sum($ratings_array);
			$vote_avg = round($vote_sum / $vote_tally);
			$vote_fields = array( $vote_tally, $vote_avg );
			update_post_meta( $post_id, 'park_vote_fields', $vote_fields );			
		}

	
		/** Save Nearby RV Parks
		********************************/		
		$post_type = 'rvparks';
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
	
	/* Nearby Park Coords
	***********************************************/
	foreach ($starting_ids as $starting_id) {
		echo $starting_id . '<br />';
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
		$post_type = 'rvparks';
		$field_value = 'park';
		nearbyLocations ( $post_id, $post_type, $field_value, $lat, $lng, 1 );
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