<?php
/*
inc/functions-site.php
	- tr_site_specific_support
		set_post_thumbnail_size	
	- add_query_vars_filter( $vars )
	- add_rewrite_rules()
	- register_taxonomy_for_object_type
	- feat_parks_query($state)
	- get_recent_reviews ( $args, $starter = 'no' )
	- dropdown ( $dd_tax, $dd_name, $dd_phrase )
	- include_template_function( $template_path )
	- distance($lat1, $lng1, $lat2, $lng2, $unit)
	- nearbyLocations ( $post_id, $post_type, $field_value, $current_lat, $current_lng, $bounding_distance )
	- get_star_rating($rating_num, $size)
	- blog_list($state, $posts_per_page, $excerpt_length, $thumbnail)
	- facebook_creds()
	- mod search for just blog posts
	- remove styles for syndicated blogs
*/
function tr_site_specific_support() {
	// default thumb size
	//set_post_thumbnail_size(125, 125, true);
}
/** Rewrites and Query Vars
*****************************************/
/****** add_query_vars *************/
function add_query_vars_filter( $vars ){
  $vars[] = "state";
  $vars[] = "cities";
  $vars[] = "clubs";
  $vars[] = "dumps";
  $vars[] = "boons";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

/***** add_rewrite_rules ***********/
// ([A-Z][a-z]+)  ([a-z][^/]+)  original - ([^/]+)
function add_rewrite_rules() {
	add_rewrite_rule(
		'rv-parks/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]', 'top'
	);	
	add_rewrite_rule(
		'rv-parks/([^/]+)/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]&cities=$matches[2]', 'top'
	);
	add_rewrite_rule(
		'rv-dumps/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]', 'top'
	);	
	add_rewrite_rule(
		'rv-dumps/([^/]+)/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]&cities=$matches[2]', 'top'
	);	
	add_rewrite_rule(
		'rv-clubs/([^/]+)/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]&clubs=$matches[2]', 'top'
	);
	add_rewrite_rule(
		'rv-clubs/([^/]+)/([^/]+)/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]&cities=$matches[2]&clubs=$matches[3]', 'top'
	);	
	add_rewrite_rule(
		'rv-snowbirds/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]', 'top'
	);	
	add_rewrite_rule(
		'rv-snowbirds/([^/]+)/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]&cities=$matches[2]', 'top'
	);
	add_rewrite_rule(
		'rv-boondocks/([^/]+)/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]&boons=$matches[2]', 'top'
	);
	add_rewrite_rule(
		'rv-boondocks/([^/]+)/([^/]+)/([^/]+)/?$', 'index.php?pagename=listings&states=$matches[1]&cities=$matches[2]&boons=$matches[3]', 'top'
	);	
}
add_filter('init', 'add_rewrite_rules');

/* Register State Tazonomy for ever post type
***********************************************/
register_taxonomy_for_object_type( 'states', 'posts' ); 
register_taxonomy_for_object_type( 'states', 'rvparks' ); 
register_taxonomy_for_object_type( 'states', 'rvdumps' ); 
register_taxonomy_for_object_type( 'states', 'rvboons' );
 
//Featured Parks Query
function feat_parks_query($state) {
	$term = term_exists( $state, 'states' );
	$feat_state = $term['term_slug'];
	$args = array(
		'post_type' 			=> 'rvparks',
		'states'         	=> $state,
		'status_levels'		=> 4,
		'post_status'     => 'publish',
		'posts_per_page'  => 1,
		'orderby' 				=> 'rand',
	); 
	$feat_parks = '';
		
	$feat_parks_query = new WP_Query( $args );
	while ($feat_parks_query->have_posts()) : $feat_parks_query->the_post();
	$feat_id = get_the_ID();
	$values = get_post_meta( $feat_id );
	$feat_address = $values['park_address'][0];
	$feat_city = $values['park_city'][0];
	$ratings = unserialize($values['park_vote_fields'][0]);
	$vote_avg = $ratings[1];			
	$feat_star_rating = get_star_rating($vote_avg, 'small');		

	$feat_parks .= '<div class="feat_parks"><a href="' . get_permalink( $feat_id ) . '">' . get_the_post_thumbnail($feat_id, 'featured-thumb') . '<span class="h1">' . esc_attr( get_the_title( $feat_id ) ) . '</span><br />' . $feat_address . '<br />' . $feat_city . ', ' . $state . '<br />'. $feat_star_rating . '<br/></a></div>';
	
	endwhile;
	wp_reset_postdata();	
	
	return $feat_parks;
} 

// Recent Reviews
function get_recent_reviews ( $args, $starter = 'no' ) {
	global $wpdb;
	global $comment;
	if ( $starter == 'no' ) {
		// Posts per page setting
		$ppp = 10; //get_option('posts_per_page'); // either use the WordPress global Posts per page setting or set a custom one like $ppp = 10;
		$custom_offset = 0; // If you are dealing with your custom pagination, then you can calculate the value of this offset using a formula

		// category (can be a parent category)
		$state = term_exists( $args, 'states' );
		$category_parent = $state['term_id'];

		// lets fetch sub categories of this category and build an array
		$categories = get_terms( 'states', array( 'child_of' => $category_parent, 'hide_empty' => false ) );
		$category_list =  array( $category_parent );
		foreach( $categories as $term ) {
		 $category_list[] = (int) $term->term_id;
		}

		// fetch posts in all those categories
		$posts = get_objects_in_term( $category_list, 'states' );

		$sql = "SELECT comment_ID, comment_date, comment_content, comment_post_ID
		 FROM {$wpdb->comments} WHERE
		 comment_post_ID in (".implode(',', $posts).") AND comment_approved = 1
		 ORDER by comment_date DESC LIMIT $ppp OFFSET $custom_offset";

		$comments_list = $wpdb->get_results( $sql );	
	}
	if ( $starter == 'yes' ) { $comments_list = get_comments($args); }
	$excerpt_length = 240;
	$i = 0;
	foreach($comments_list as $comment) : 
	$comment_text = get_comment_text();
	$text = strip_tags($comment_text);
		if (strlen($text) > $excerpt_length) :
		$text = substr( $text, 0, $excerpt_length - 3 ).'...';
		endif;
	$meta_values = get_comment_meta( $comment->comment_ID, 'rvp_vote', true );
	$star_rating = get_star_rating($meta_values, 'small');
	$comment_link =  str_replace('?rvparks=', 'rv-park/', get_permalink($comment->comment_post_ID) );

	if ($meta_values > 2 ) {
		$i++;
		if ( $i < 4 || $starter == 'yes') {
			$recent_reviews .= '
			<article  id="comment-' . get_comment_ID() . '">
				<div class="comment_wrap">
					<header class="comment-meta comment-author vcard">
						<div class="comment_col1">	' . 
						get_avatar($comment,60, '', $alt = 'Facebook Avatar'  ) . '
						<div class="comment_info"><a href="' . $comment_link . '">' . get_the_title($comment->comment_post_ID) . '</a><br />' . get_comment_date() . '<br />' . 
						$star_rating . '
						</div>
						</div>
					</header>
					<div class="comment_text_wrap">' . 
					$text . '
					</div>
				</div>
			</article>';
		}
	}
	endforeach;
	return $recent_reviews;
}

/** Dropdown
***********************************/
function dropdown ( $dd_tax, $dd_name, $dd_phrase, $size = '' ) {
	$args = array(
		'taxonomy'  => $dd_tax,
		'order' => 'ASC',
		'orderby' => 'NAME',
		'name' => $dd_name
	);
	$categories = get_categories( $args );
	
	$select = '';
	$select .= '
	<div class="dropdown_section">
		<select name="' . $dd_name . '" id="' . $dd_name . '" class="postform"' . $size . '>
		<option value="-1">' . $dd_phrase . '</option>';
		if ( $dd_tax == 'boons' ) {
			$select .= '<option value="all">All Boondocks</option>';
		}
		foreach($categories as $category){
			if($category->count > 0){
				$select.= '<option value="' . $category->slug . '">' . $category->name . '</option>';
			}
		}
		if ( $dd_tax == 'boons' ) {
			$select .= '<option value="all-wal-mart">All Wal-Marts Combined</option>';
		}		
		$select .= '</select>';
	$select .= '</div>';
	return $select;
}

/** Direct Custom Post Types to the right section - Not sure if this is needed
***********************************/
function include_template_function( $template_path ) {
	if ( get_post_type() == 'rvparks' ) {
		if ( is_single() ) {
			// checks if the file exists in the theme first,
			// otherwise serve the file from the plugin
			if ( $theme_file = locate_template( array ( 'single-rvparks.php' ) ) ) {
					$template_path = $theme_file;
			} else {
					$template_path = plugin_dir_path( __FILE__ ) . '/single-rvparks.php';
			}
		}
	/*	elseif ( is_archive() ) {
			if ( $theme_file = locate_template( array ( 'archive-rvparks.php' ) ) ) {
				$template_path = $theme_file;
			} else { 
				$template_path = plugin_dir_path( __FILE__ ) . '/archive-rvparks.php';
			}
		} */
	}
	if ( get_post_type() == 'rvdumps' ) {
		if ( is_single() ) {
			// checks if the file exists in the theme first,
			// otherwise serve the file from the plugin
			if ( $theme_file = locate_template( array ( 'single-rvdumps.php' ) ) ) {
					$template_path = $theme_file;
			} else {
					$template_path = plugin_dir_path( __FILE__ ) . '/single-rvdumps.php';
			}
		}
		elseif ( is_archive() ) {
			if ( $theme_file = locate_template( array ( 'archive-rvdumps.php' ) ) ) {
				$template_path = $theme_file;
			} else { 
				$template_path = plugin_dir_path( __FILE__ ) . '/archive-rvdumps.php';
			}
		}
	}	
	if ( get_post_type() == 'rvboons' ) {
		if ( is_single() ) {
			// checks if the file exists in the theme first,
			// otherwise serve the file from the plugin
			if ( $theme_file = locate_template( array ( 'single-rvboondocks.php' ) ) ) {
					$template_path = $theme_file;
			} else {
					$template_path = plugin_dir_path( __FILE__ ) . '/single-rvboondocks.php';
			}
		}
		elseif ( is_archive() ) {
			if ( $theme_file = locate_template( array ( 'archive-rvboondocks.php' ) ) ) {
				$template_path = $theme_file;
			} else { 
				$template_path = plugin_dir_path( __FILE__ ) . '/archive-rvboondocks.php';
			}
		}
	}	
	return $template_path;
}
add_filter( 'template_include', 'include_template_function', 1 );

/** Distance Calculation
-------------------------------------------------------------- */
function distance($lat1, $lng1, $lat2, $lng2, $unit) {
	$theta = $lng1 - $lng2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	if ( $unit == "K" ) {
	 return round ( ($miles * 1.609344), 1 );
	} elseif ( $unit == "N" ) {
	 return round ( ($miles * 0.8684), 1 );
	} else {
	 return round ( $miles, 1 );
	}
}

/** Get Nearby Locations
-------------------------------------------------------------- */
function nearbyLocations ( $post_id, $post_type, $field_value, $current_lat, $current_lng, $bounding_distance ) {
	global $wpdb;
	$MilesArray = array();
	$nearbys = $wpdb->get_results( 
		"
		 SELECT *  
		 FROM rvty_geodata
		 WHERE (
				geo_latitude BETWEEN ($current_lat - $bounding_distance) AND ($current_lat + $bounding_distance) AND geo_longitude BETWEEN ($current_lng - $bounding_distance) AND ($current_lng + $bounding_distance) AND post_type = '$post_type'
			)
		"
	);	
	foreach ($nearbys as $nearby) {
		$alt_id = $nearby->post_id;
		$alt_lat = $nearby->geo_latitude;
		$alt_lng = $nearby->geo_longitude;
		if ( $post_id != $alt_id ) {
			$Miles = distance($current_lat, $current_lng, $alt_lat, $alt_lng, "M");
			$Miles = number_format($Miles, 1);
			$MilesArray[$alt_id] = $Miles;
		}
	}
	asort($MilesArray);
	if ( count ( $MilesArray ) > 9 ) {
		$MilesArrayChunk = array_chunk( $MilesArray, 9, true );
		$ALTCGArray = $MilesArrayChunk[0];
	} else {
		$ALTCGArray = $MilesArray;
	}
	update_post_meta( $post_id, $field_value . '_nearbys', $ALTCGArray );
}

// Grab Star Rating
function get_star_rating($rating_num, $size) {
	$full_star = '<div class="rating_star"><div class="rating_star_full_' . $size . '"></div></div>';
	$blank_star = '<div class="rating_star"><div class="rating_star_blank_' . $size . '"></div></div>';
	$star_rating = "";
	for($i=1; $i<=$rating_num; $i++){
	$star_rating .= $full_star;
	}
	if($rating_num < 5){
		for($i=1; $i<=(5-$rating_num); $i++){
		$star_rating .= $blank_star;
		}
	}
	if($rating_num == 0 ){
		$star_rating ='<div class="not_rated"><div class="not_rated_' . $size . '"></div></div>';
	}
	return $star_rating;
}

// Blog Display Template
function blog_list($state, $posts_per_page, $excerpt_length, $thumbnail) {
	$term = term_exists( $state, 'states' );
	$blog_state = $term['term_id'];
	$args = array(
		'cat'         => $blog_state,
		'post_status'     => 'publish',
		'posts_per_page'  => $posts_per_page,
	); 
	?>
	<ul class="blog_list">
		<?php
			$archive_query = new WP_Query( $args );
			while ($archive_query->have_posts()) : $archive_query->the_post(); 
			$blog_excerpt = get_the_excerpt();
			$text = strip_tags($blog_excerpt);
			if (strlen($text) > $excerpt_length) :
			$text = substr( $text, 0, $excerpt_length - 3 ).'...';
			endif;
		?>
		<li>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><h3><?php the_title(); ?></h3><?php the_post_thumbnail( $thumbnail ); ?><p><?php echo $text; ?></p></a>
		</li>
		<?php endwhile; ?>
	</ul>
<?php }

// Facebook Credentials
function facebook_creds() {
	$facebook_creds = '
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'facebook-jssdk\'));</script>';
	
	return $facebook_creds;
}
// mod search for just blog posts
function SearchFilter($query) {
	if (!is_admin()) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
	}
}
add_filter('pre_get_posts','SearchFilter');

// remove styles for syndicated blogs
function the_content_filter( $content ) {
    $content = preg_replace('#<p.*?>(.*?)</p>#i', '<p>\1</p>', $content);
    $content = preg_replace('#<span.*?>(.*?)</span>#i', '<span>\1</span>', $content);
    $content = preg_replace('#<ol.*?>(.*?)</ol>#i', '<ol>\1</ol>', $content);
    $content = preg_replace('#<ul.*?>(.*?)</ul>#i', '<ul>\1</ul>', $content);
    $content = preg_replace('#<li.*?>(.*?)</li>#i', '<li>\1</li>', $content);
    return $content;
}
add_filter( 'the_content', 'the_content_filter', 20 );
?>