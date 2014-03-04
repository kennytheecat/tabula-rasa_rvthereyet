<?php
/**************
CUSTOM POST TYPE
**************/
function custom_post_type_rvdumps() {
	$labels = array(
		'name'                => _x( 'RV Dumps', 'Post Type General Name', 'tabula_rasa' ),
		'singular_name'       => _x( 'RV Dump', 'Post Type Singular Name', 'tabula_rasa' ),
		'menu_name'           => __( 'RV Dump', 'tabula_rasa' ),
		'parent_item_colon'   => __( 'Parent RV Dump:', 'tabula_rasa' ),
		'all_items'           => __( 'All RV Dumps', 'tabula_rasa' ),
		'view_item'           => __( 'View RV Dump', 'tabula_rasa' ),
		'add_new_item'        => __( 'Add New RV Dump', 'tabula_rasa' ),
		'add_new'             => __( 'New RV Dump', 'tabula_rasa' ),
		'edit_item'           => __( 'Edit RV Dump', 'tabula_rasa' ),
		'update_item'         => __( 'Update RV Dump', 'tabula_rasa' ),
		'search_items'        => __( 'Search RV Dumps', 'tabula_rasa' ),
		'not_found'           => __( 'No RV Dumps found', 'tabula_rasa' ),
		'not_found_in_trash'  => __( 'No RV Dumps found in Trash', 'tabula_rasa' ),
	);

	$rewrite = array(
		'slug'                => 'rv-dump',
		'with_front'          => true,
		'pages'               => false,
		'feeds'               => false,
	);

	$args = array(
		'label'               => __( 'rvdumps', 'tabula_rasa' ),
		'description'         => __( 'RV Dump pages', 'tabula_rasa' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'author', 'comments', 'revisions' ),
		//'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'icon.png',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'map_meta_cap'				=> true,
		'capability_type'     => 'rvdump',
	);

	register_post_type( 'rvdumps', $args );
}
// Hook into the 'init' action
add_action( 'init', 'custom_post_type_rvdumps', 0 );

/**************
TAXONOMIES
**************/

/** Water
-------------------------------------------------------------- */
function custom_taxonomy_rvdumps_water()  {
	$labels = array(
		'name'                       => _x( 'Water', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Water', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'menu_name'                  => __( 'Water', 'tabula_rasa' ),
		'all_items'                  => __( 'All Water', 'tabula_rasa' ),
		'parent_item'                => __( 'Parent Water', 'tabula_rasa' ),
		'parent_item_colon'          => __( 'Parent Water:', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Water Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Water', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Water', 'tabula_rasa' ),
		'update_item'                => __( 'Update Water', 'tabula_rasa' ),
		'separate_items_with_commas' => __( 'Separate water with commas', 'tabula_rasa' ),
		'search_items'               => __( 'Search water', 'tabula_rasa' ),
		'add_or_remove_items'        => __( 'Add or remove water', 'tabula_rasa' ),
		'choose_from_most_used'      => __( 'Choose from the most used water', 'tabula_rasa' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);

	register_taxonomy( 'dump_water', 'rvdumps', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvdumps_water', 0 );

/***********************************
META BOXES
************************************/

/** Basic Information
-------------------------------------------------------------- */
function rvd_basicinfo_metaboxes( $meta_boxes ) {
	$prefix = 'dump_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'rvd_basicinfo_metabox',
		'title' => 'Basic Information',
		'pages' => array('rvdumps'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name'    => 'Address',
				'desc'    => '',
				'id'      => $prefix . 'address',
				'type'    => 'text',
			),
			array(
				'name'    => 'City',
				'desc'    => '',
				'id'      => $prefix . 'city',
				'type'    => 'text',
			),
			array(
				'name'     => 'State',
				'desc'     => '',
				'id'       => 'rvp_state',
				'type'     => 'taxonomy_select',
				'taxonomy' => 'states', // Taxonomy Slug
			),			
			array(
				'name'    => 'Zipcode',
				'desc'    => '',
				'id'      => $prefix . 'zip',
				'type'    => 'text',
			),	
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'rvd_basicinfo_metaboxes' );

/** Additional Information
-------------------------------------------------------------- */
function rvd_addinfo_metaboxes( $meta_boxes ) {
	$prefix = 'dump_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'rvd_addinfo_metabox',
		'title' => 'Additional Information',
		'pages' => array('rvdumps'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name'    => 'RV Dump Open Dates',
				'desc'    => 'Enter 1/1 12/31 to display "Year Round"',
				'id'      => $prefix . 'season',
				'type'    => 'dump_season',
			),
			array(
				'name'    => 'RV Dump Open Days',
				'desc'    => '',
				'id'      => $prefix . 'days_open',
				'type'    => 'multicheck',
				'options' => array(
					'Su' => 'Sunday',
					'Mo' => 'Monday',
					'Tu' => 'Tuesday',
					'We' => 'Wednedday',
					'Th' => 'Thursday',
					'Fr' => 'Friday',					
					'Sa' => 'Saturday',	
				),
			),			
			array(
				'name'    => 'RV Dump Opening Hour',
				'desc'    => 'Enter 12:00 AM in both fields to display "24 Hours"',
				'id'      => $prefix . 'hours_open',
				'type'    => 'open_hours',
			),
			array(
				'name'    => 'RV Dump Closing Hour',
				'desc'    => '',
				'id'      => $prefix . 'hours_close',
				'type'    => 'close_hours',
			),			
			array(
				'name'    => 'Dump Fee',
				'desc'    => '',
				'id'      => $prefix . 'fee',
				'type'    => 'text_money',
			),	
			array(
				'name'    => 'Register Guest Dump Fee',
				'desc'    => '',
				'id'      => $prefix . 'reg_guest_fee',
				'type'    => 'text_money',
			),		
			array(
				'name'    => 'Water Availability',
				'desc'    => '',
				'id'      => $prefix . 'water',
				'taxonomy' => 'dump_water', //Enter Taxonomy Slug
				'type' => 'taxonomy_multicheck',
			),			
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'rvd_addinfo_metaboxes' );			
			
/**************
META BOXES MAP
**************/
function add_map_rvdumps() {
    add_meta_box( 'map_meta_box',
        'Your Location',
        'display_map_meta_box',
        'rvdumps', 'side', 'high'
    );
}
add_action( 'admin_init', 'add_map_rvdumps' );

/** Custom Metaboxes - Open Hours
*************************************/
add_action( 'cmb_render_open_hours', 'rrh_cmb_render_open_hours', 10, 2 );
function rrh_cmb_render_open_hours( $field ) {
	global $post;
	$meta2 = get_post_meta( $post->ID);
	$meta3 = $meta2['dump_hours_open'][0];		
		/* If multicheck this can be multiple values */ 
	if( empty( $meta2 ) && !empty( $field['std'] ) ) $meta2 = $field['std'];
	echo '<select name="', $field['id'], '" id="', $field['id'], $field['id'], '">';
	$hours_open = array( 'None Selected','12:00 AM','12:30 AM','1:00 AM','1:30 AM','2:00 AM','2:30 AM','3:00 AM','3:30 AM','4:00 AM','4:30 AM','5:00 AM','5:30 AM','6:00 AM','6:30 AM','7:00 AM','7:30 AM','8:00 AM','8:30 AM','9:00 AM','9:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','1:00 PM','1:30 PM','2:00 PM','2:30 PM','3:00 PM','3:30 PM','4:00 PM','4:30 PM','5:00 PM','5:30 PM','6:00 PM','6:30 PM','7:00 PM','7:30 PM','8:00 PM','8:30 PM','9:00 PM','9:30 PM','10:00 PM','10:30 PM','11:00 PM','11:30 PM','12:00 AM' );
	foreach ($hours_open as $key => $value) {
		echo '<option value="', $value, '"', $meta3 == $value ? ' selected="selected"' : '', '>', $value, '</option>';
	}
	echo '</select>';
}

/** Custom Metaboxes - close Hours
*************************************/
add_action( 'cmb_render_close_hours', 'rrh_cmb_render_close_hours', 10, 2 );
function rrh_cmb_render_close_hours( $field ) {
	global $post;
	$meta2 = get_post_meta( $post->ID);
	$meta3 = $meta2['dump_hours_close'][0];		
		/* If multicheck this can be multiple values */ 
	if( empty( $meta2 ) && !empty( $field['std'] ) ) $meta2 = $field['std'];
	echo '<select name="', $field['id'], '" id="', $field['id'], $field['id'], '">';
	$hours_close = array( 'None Selected','12:00 AM','12:30 AM','1:00 AM','1:30 AM','2:00 AM','2:30 AM','3:00 AM','3:30 AM','4:00 AM','4:30 AM','5:00 AM','5:30 AM','6:00 AM','6:30 AM','7:00 AM','7:30 AM','8:00 AM','8:30 AM','9:00 AM','9:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','1:00 PM','1:30 PM','2:00 PM','2:30 PM','3:00 PM','3:30 PM','4:00 PM','4:30 PM','5:00 PM','5:30 PM','6:00 PM','6:30 PM','7:00 PM','7:30 PM','8:00 PM','8:30 PM','9:00 PM','9:30 PM','10:00 PM','10:30 PM','11:00 PM','11:30 PM','12:00 AM' );
	foreach ($hours_close as $key => $value) {
		echo '<option value="', $value, '"', $meta3 == $value ? ' selected="selected"' : '', '>', $value, '</option>';
	}
	echo '</select>';
}

/** Custom Metaboxes - Dump Seasons
*************************************/
add_action( 'cmb_render_dump_season', 'rrh_cmb_render_dump_season', 10, 2 );
function rrh_cmb_render_dump_season( $field ) {
	global $post;
	$meta2 = get_post_meta( $post->ID);
	$meta3 = unserialize($meta2['dump_season'][0] );
	//$meta3 = unserialize( $meta2[0] );
	$open_month = $meta3['open_month'];
	$open_day = $meta3['open_day'];
	$close_month = $meta3['close_month'];
	$close_day = $meta3['close_day'];					
		/* If multicheck this can be multiple values */ 
		//if ( $meta2 == '' ) { $meta2 = array(); }
	if( empty( $meta2 ) && !empty( $field['std'] ) ) $meta2 = $field['std'];
	echo '<select name="', $field['id'], '[open_month]" id="', $field['id'], $field['id'], '">';
	$months = array(1,2,3,4,5,6,7,8,9,10,11,12);
	foreach ($months as $key => $value) {
		echo '<option value="', $value, '"', $open_month == $value ? ' selected="selected"' : '', '>', $value, '</option>';
	}
	echo '</select>';
	if( empty( $meta2 ) && !empty( $field['std'] ) ) $meta2 = $field['std'];
	echo '<select name="', $field['id'], '[open_day]" id="', $field['id'], $field['id'], '">';
	$days = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
	foreach ($days as $key => $value) {
		echo '<option value="', $value, '"', $open_day == $value ? ' selected="selected"' : '', '>', $value, '</option>';
	}
	echo '</select>';
	if( empty( $meta2 ) && !empty( $field['std'] ) ) $meta2 = $field['std'];
	echo '<select name="', $field['id'], '[close_month]" id="', $field['id'], $field['id'], '">';
	$months = array(1,2,3,4,5,6,7,8,9,10,11,12);
	foreach ($months as $key => $value) {
		echo '<option value="', $value, '"', $close_month == $value ? ' selected="selected"' : '', '>', $value, '</option>';
	}
	echo '</select>';
	if( empty( $meta2 ) && !empty( $field['std'] ) ) $meta2 = $field['std'];
	echo '<select name="', $field['id'], '[close_day]" id="', $field['id'], $field['id'], '">';
	$days = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
	foreach ($days as $key => $value) {
		echo '<option value="', $value, '"', $close_day == $value ? ' selected="selected"' : '', '>', $value, '</option>';
	}
	echo '</select>';
}
?>