<?php
global $wp;
$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
$lc_city = get_query_var( 'cities' );
$lc_state = get_query_var( 'states' );
$city = ucwords( str_replace( '-', ' ', $lc_city ) );
$state = ucwords( str_replace( '-', ' ', $lc_state ) );
$tax_cat_club = get_query_var( 'clubs' );
$club = ucwords( str_replace( '-', ' ', $tax_cat_club ) );
$club = str_replace( 'Usa', 'USA', $club );
$club = str_replace( 'Koa', 'KOA', $club );
$tax_cat_boon = get_query_var( 'boons' );
$boon = ucwords( str_replace( '-', ' ', $tax_cat_boon  ) );
$boon = ucwords( str_replace( 'l M', 'l-M', $boon  ) );
$can_link = '<link rel="canonical" href="' . $current_url . '" />';
$can_link = explode('?', $can_link);
$can_link = $can_link[0] . '/">';
if (strpos( $can_link, '/>/">') !== false) {
    $can_link = str_replace ( '" />/">', '/">', $can_link );
}


if ( is_single() ) {
	$values = get_post_meta( $post->ID );
	if ( is_singular( 'rvparks' ) ) {
		$city = $values['park_city'][0];		
	}
	if ( is_singular( 'rvdumps' ) ) {
		$city = $values['dump_city'][0];
	}
	if ( is_singular( 'rvboons' ) ) {
		$city = $values['boon_city'][0];
	}	
	$lc_city = str_replace( ' ', '-', strtolower( $city ) );
	$state = wp_get_object_terms( $post->ID, 'states' );
	$lc_state = $state[0]->slug;
	$state = $state[0]->name;
	$name = get_the_title();
}
// Title Tag
if (is_page('rv-parks')) { 
	$title_info = 'Every RV Park in the United States and Canada - '; 
	$meta_content = 'RV camping directory providing listings for every RV park, campground, or resort in the USA and Canada including National and State parks.';
}	elseif ( is_page('rv-blogs') ) { 
	$title_info = 'RV Blogs about the United States and Canada - '; 
	$meta_content = 'RV blogs from around the globe from RVers detailing their travels';
} elseif (is_page('rv-boondocks')) { 
	$title_info = 'Every RV Boondock in the United States and Canada - '; 
	$meta_content = 'RV overnight parking and location information';
}	elseif (is_page('rv-dumps')) { 
	$title_info = 'Every RV Dump in the United States and Canada - '; 
	$meta_content = 'Free and paid details about every RV dump in the United States and Canada';
}	elseif (is_page('rv-clubs')) { 
	$title_info = 'Every RV Club in the United States and Canada - '; 
	$meta_content = 'RV parks that honor ' . $club . ' in the United States and Canada';  
}	elseif (is_page('rv-snowbirds')) { 
	$title_info = 'Every Snowbird RV Park in the United States and Canada - '; 
	$meta_content = 'RV snowbird destinations in the United States and Canada';
} elseif ( 'rvparks' == get_post_type() ) {
	$title_info =  $name . ' in ' . $city . ', ' . $state . ' - ';
	$meta_content = 'RV park reviews and information about ' . $name . ' in ' . $city . ', ' . $state;
} elseif ( 'rvdumps' == get_post_type() ) {
	$title_info =  $name . ' in ' . $city . ', ' . $state . ' - ';
	$meta_content = 'RV Dump reviews and information about ' . $name . ' in ' . $city . ', ' . $state;
} elseif ( 'rvboons' == get_post_type() ) {
	$title_info =  $name . ' in ' . $city . ', ' . $state . ' - ';
	$meta_content = 'RV Boondock reviews and information about ' . $name . ' in ' . $city . ', ' . $state;
} elseif (is_page('listings')) { 
	if (strpos($current_url,'rv-parks') !== false) {
		$title_info =  'Every RV Park in ';
		$meta_content = 'RV park reviews and information about every campground in ';
	}
	if (strpos($current_url,'rv-dumps') !== false) {
		$title_info =  'Every RV Dump in ';
		$meta_content = 'Free and paid details about every RV dump in ';
	}	
	if (strpos($current_url,'rv-snowbirds') !== false) {
		$title_info =  'Every RV Snowbird Park in ';
		$meta_content = 'RV snowbird destinations in ';
	}
	if (strpos($current_url,'rv-clubs') !== false) {
		$title_info =  'Every ' . $club . ' in ';
		$meta_content = 'RV parks that honor ' . $club. ' in ';  
	}
	if (strpos($current_url,'rv-boondocks') !== false) {
		$title_info =  'Every ' . $boon . ' in ';
		$meta_content = 'RV overnight parking and location information about every ' . $boon . ' in ';
	}	
	if ( get_query_var( 'cities' ) ) {
		$title_info .=  $city . ', ';
		$meta_content .=  $city . ', ';
	}
	if ( get_query_var( 'states' ) ) {
		$title_info .=  $state . ' - ';
		$meta_content .=  $state;
	}
} else {
	$title_info = wp_title('-', false, 'right');
	$meta_content = wp_title('-', false, 'right'); 
} 
$title_info .= get_bloginfo('name');
?>