<?php
/**************
CUSTOM POST TYPE
**************/
function custom_post_type_rvparks() {
	$labels = array(
		'name'                => _x( 'RV Parks', 'Post Type General Name', 'tabula_rasa' ),
		'singular_name'       => _x( 'RV Park', 'Post Type Singular Name', 'tabula_rasa' ),
		'menu_name'           => __( 'RV Park', 'tabula_rasa' ),
		'parent_item_colon'   => __( 'Parent RV Park:', 'tabula_rasa' ),
		'all_items'           => __( 'All RV Parks', 'tabula_rasa' ),
		'view_item'           => __( 'View RV Park', 'tabula_rasa' ),
		'add_new_item'        => __( 'Add New RV Park', 'tabula_rasa' ),
		'add_new'             => __( 'New RV Park', 'tabula_rasa' ),
		'edit_item'           => __( 'Edit RV Park', 'tabula_rasa' ),
		'update_item'         => __( 'Update RV Park', 'tabula_rasa' ),
		'search_items'        => __( 'Search RV Parks', 'tabula_rasa' ),
		'not_found'           => __( 'No RV Parks found', 'tabula_rasa' ),
		'not_found_in_trash'  => __( 'No RV Parks found in Trash', 'tabula_rasa' ),
	);

	$rewrite = array(
		'slug'                => 'rv-park',
		'with_front'          => true,
		'pages'               => false,
		'feeds'               => false,
	);

	$args = array(
		'label'               => __( 'rvparks', 'tabula_rasa' ),
		'description'         => __( 'RV Park pages', 'tabula_rasa' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'author',  'thumbnail', 'comments', 'revisions' ),
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
		'capability_type'     => 'rvpark',
	);

	register_post_type( 'rvparks', $args );
}
// Hook into the 'init' action
add_action( 'init', 'custom_post_type_rvparks', 0 );

/**************
TAXONOMIES
**************/
/** States
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_states()  {
	$labels = array(
		'name'                       => _x( 'States', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'State', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All States', 'tabula_rasa' ),
		'new_item_name'              => __( 'New State Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New State', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit State', 'tabula_rasa' ),
		'update_item'                => __( 'Update State', 'tabula_rasa' ),
		'search_items'               => __( 'Search states', 'tabula_rasa' ),
	);

	$args = array(
		'labels'                     => $labels,
		'show_admin_column'          => true,
		'hierarchical'               => true,
	);

	register_taxonomy( 'states', array( 'post', 'rvparks', 'rvdumps', 'rvboons' ) , $args );
}
// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_states', 0 );

/** Status Levels
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_status_levels()  {

	$labels = array(
		'name'                       => _x( 'Status Levels', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Status Level', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Status Levels', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Status Level Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Status Level', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Status Level', 'tabula_rasa' ),
		'update_item'                => __( 'Update Status Level', 'tabula_rasa' ),
		'search_items'               => __( 'Search status level', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'show_admin_column'          => true,
		'hierarchical'               => true,
	);
	register_taxonomy( 'status_levels', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_status_levels', 0 );

/** Park Types
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_types()  {

	$labels = array(
		'name'                       => _x( 'Park Types', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Park Type', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Park Types', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Park Type Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Park Type', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Park Type', 'tabula_rasa' ),
		'update_item'                => __( 'Update Park Type', 'tabula_rasa' ),
		'search_items'               => __( 'Search park types', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'types', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_types', 0 );

/** Features
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_features()  {

	$labels = array(
		'name'                       => _x( 'Features', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Feature', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Features', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Feature Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Feature', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Feature', 'tabula_rasa' ),
		'update_item'                => __( 'Update Feature', 'tabula_rasa' ),
		'search_items'               => __( 'Search features', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'features', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_features', 0 );

/** Activities
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_activities()  {

	$labels = array(
		'name'                       => _x( 'Activities', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Activity', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Activities', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Activity Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Activity', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Activity', 'tabula_rasa' ),
		'update_item'                => __( 'Update Activity', 'tabula_rasa' ),
		'search_items'               => __( 'Search activities', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'activities', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_activities', 0 );

/** Atmospheres
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_atmospheres()  {

	$labels = array(
		'name'                       => _x( 'Atmospheres', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Atmosphere', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Atmospheres', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Atmosphere Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Atmosphere', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Atmosphere', 'tabula_rasa' ),
		'update_item'                => __( 'Update Atmosphere', 'tabula_rasa' ),
		'search_items'               => __( 'Search atmospheres', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'atmospheres', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_atmospheres', 0 );

/** Payment Methods
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_payments()  {

	$labels = array(
		'name'                       => _x( 'Payments', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Payment', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Payments', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Payment Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New payment', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Payment', 'tabula_rasa' ),
		'update_item'                => __( 'Update Payment', 'tabula_rasa' ),
		'search_items'               => __( 'Search Payments', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'payments', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_payments', 0 );

/** Discounts
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_discounts()  {

	$labels = array(
		'name'                       => _x( 'Discounts', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Discount', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Discounts', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Discount Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Discount', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Discount', 'tabula_rasa' ),
		'update_item'                => __( 'Update Discount', 'tabula_rasa' ),
		'search_items'               => __( 'Search Discounts', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'discounts', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_discounts', 0 );

/** Clubs
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_clubs()  {

	$labels = array(
		'name'                       => _x( 'Clubs', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Club', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Clubs', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Club Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New club', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Club', 'tabula_rasa' ),
		'update_item'                => __( 'Update Club', 'tabula_rasa' ),
		'search_items'               => __( 'Search Clubs', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'clubs', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_clubs', 0 );

/** Site Hookups
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_hookups()  {

	$labels = array(
		'name'                       => _x( 'Hookups', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Hookup', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Hookups', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Hookup Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Hookup', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Hookup', 'tabula_rasa' ),
		'update_item'                => __( 'Update Hookup', 'tabula_rasa' ),
		'search_items'               => __( 'Search Hookups', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'hookups', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_hookups', 0 );

/** Site Accommodations
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_accommodations()  {

	$labels = array(
		'name'                       => _x( 'Accommodations', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Accommodation', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Accommodations', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Accommodation Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Accommodation', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Accommodation', 'tabula_rasa' ),
		'update_item'                => __( 'Update Accommodation', 'tabula_rasa' ),
		'search_items'               => __( 'Search Accommodations', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'accommodations', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_accommodations', 0 );

/** Other Site Types
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_other_camping()  {

	$labels = array(
		'name'                       => _x( 'Other Camping', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Other Camping', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Other Camping', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Other Camping Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Other Camping', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Other Camping', 'tabula_rasa' ),
		'update_item'                => __( 'Update Other Camping', 'tabula_rasa' ),
		'search_items'               => __( 'Search Other Camping', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'other_camping', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_other_camping', 0 );

/** Filters
-------------------------------------------------------------- */
function custom_taxonomy_rvparks_filters()  {

	$labels = array(
		'name'                       => _x( 'Filters', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Filter', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Filters', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Filter Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New Filter', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Filter', 'tabula_rasa' ),
		'update_item'                => __( 'Update Filter', 'tabula_rasa' ),
		'search_items'               => __( 'Search Filters', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
	);
	register_taxonomy( 'filters', 'rvparks', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvparks_filters', 0 );

/***********************************
META BOXES
************************************/

/** Admin Only Information
-------------------------------------------------------------- */
function rvp_adminonly_metaboxes( $meta_boxes ) {
	$prefix = 'park_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'rvp_adminonly_metabox',
		'title' => 'Admin Only',
		'pages' => array('rvparks'), // post type
		'context' => 'side',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name'     => 'Status',
				'desc'     => '',
				'id'       => $prefix . 'status',
				'type'     => 'taxonomy_radio',
				'taxonomy' => 'status_levels', // Taxonomy Slug
			),
			array(
				'name'     => 'Type',
				'desc'     => '',
				'id'       => $prefix . 'type',
				'type'     => 'taxonomy_select',
				'taxonomy' => 'types', // Taxonomy Slug
			),			
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'rvp_adminonly_metaboxes' );			

/** Basic Information
-------------------------------------------------------------- */
function rvp_basicinfo_metaboxes( $meta_boxes ) {
	$prefix = 'park_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'rvp_basicinfo_metabox',
		'title' => 'Basic Information',
		'pages' => array('rvparks'), // post type
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
				'id'       => $prefix . 'state',
				'taxonomy' => 'states', //Enter Taxonomy Slug
				'type' => 'taxonomy_select',
			),			
			array(
				'name'    => 'Zipcode',
				'desc'    => '',
				'id'      => $prefix . 'zip',
				'type'    => 'text',
			),
			array(
				'name'    => '',
				'desc'    => '',
				'id'      => $prefix . 'basic2',
				'type'    => 'basic2',
			),	
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'rvp_basicinfo_metaboxes' );

/** Custom Metaboxes - Basic Info ( Secondary )
*************************************/
function rrh_cmb_render_basic2( $field ) {
	global $post;
	$meta2 = get_post_meta( $post->ID);
	$meta3 = unserialize($meta2['park_basic2'][0] );
	$phone1 = $meta3['park_phone1'];
	$phone2 = $meta3['park_phone2'];
	$fax = $meta3['park_fax'];
	$email = $meta3['park_email'];					
	$web = $meta3['park_web'];					
	if( empty( $meta2 ) && !empty( $field['std'] ) ) $meta2 = $field['std'];
	echo '<input class="cmb_text_medium" type="text" name="', $field['id'], '[park_phone1]" id="', $field['id'], '_phone1" value="', '' !== $phone1 ? $phone1 : $field['std'], '" /><span class="cmb_metabox_description">Phone 1: </span><br />';
	echo '<input class="cmb_text_medium" type="text" name="', $field['id'], '[park_phone2]" id="', $field['id'], '_phone2" value="', '' !== $phone2 ? $phone2 : $field['std'], '" /><span class="cmb_metabox_description">Phone 2: </span><br />';
	echo '<input class="cmb_text_medium" type="text" name="', $field['id'], '[park_fax]" id="', $field['id'], '_fax" value="', '' !== $fax ? $fax : $field['std'], '" /><span class="cmb_metabox_description">Fax: </span><br />';
	echo '<input class="cmb_text_medium" type="text" name="', $field['id'], '[park_email]" id="', $field['id'], '_email" value="', '' !== $email ? $email : $field['std'], '" /><span class="cmb_metabox_description">Email: </span><br />';
	echo '<input class="cmb_text_medium" type="text" name="', $field['id'], '[park_web]" id="', $field['id'], '_web" value="', '' !== $web ? $web : $field['std'], '" /><span class="cmb_metabox_description">Website: </span><br />';
}
add_action( 'cmb_render_basic2', 'rrh_cmb_render_basic2', 10, 2 );

/**************
META BOXES MAP
**************/
function add_map_rvparks() {
    add_meta_box( 'map_meta_box',
        'Your Location',
        'display_map_meta_box',
        'rvparks', 'side', 'core'
    );
}
add_action( 'admin_init', 'add_map_rvparks' );

/** RV Site Details
-------------------------------------------------------------- */
function rvp_site_details_metaboxes( $meta_boxes ) {
	$prefix = 'park_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'rvp_site_details_metabox',
		'title' => 'RV Site Details',
		'pages' => array('rvparks'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => '# of RV Sites',
				'desc' => '',
				'id'   => $prefix . 'numberofsites',
				'type' => 'text_small',
			),		
			array(
				'name'    => 'Site Hookups',
				'desc'    => '',
				'id'      => $prefix . 'hookups',
				'type'		=> 'taxonomy_multicheck',
				'taxonomy'	=> 'hookups', 
			),		
			array(
				'name'    => 'Site Accommodations',
				'desc'    => '',
				'id'      => $prefix . 'accommodations',
				'type' => 'taxonomy_multicheck',
				'taxonomy' => 'accommodations', //Enter Taxonomy Slug
			),			
			array(
				'name'    => 'Other Camping Types',
				'desc'    => '',
				'id'      => $prefix . 'other_camping',
				'type'		=> 'taxonomy_multicheck',
				'taxonomy'	=> 'other_camping', 
			),			
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'rvp_site_details_metaboxes' );

/** RV Park Rates
-------------------------------------------------------------- */
function rvp_park_rates_metaboxes( $meta_boxes ) {
	$prefix = 'park_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'rvp_park_rates_metabox',
		'title' => 'RV Park Rates',
		'pages' => array('rvparks'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(		
			array(
				'name'    => 'Full Hookups',
				'desc'    => '',
				'id'      => $prefix . 'rates_full',
				'type' => 'text_money',
			),
			array(
				'name'    => 'Dry / No Hookups',
				'desc'    => '',
				'id'      => $prefix . 'rates_dry',
				'type' => 'text_money',
			),
			array(
				'name'    => 'Tent Sites',
				'desc'    => '',
				'id'      => $prefix . 'rates_tent',
				'type' => 'text_money',
			),
			array(
				'name'    => 'Additional Charges for:',
				'desc'    => '',
				'id'      => $prefix . 'rates_charges',
				'type'    => 'multicheck',
				'options' => array(
					'rates_charges_50amp' => '50 Amp Sites',
					'rates_charges_pullthrough' => 'Pull Through Sites',
					'rates_charges_wifi' => 'Wifi',
				),
			),	
			array(
				'name'    => 'Payment Method',
				'desc'    => '',
				'id'      => $prefix . 'payment',
				'taxonomy' => 'payments', //Enter Taxonomy Slug
				'type' => 'taxonomy_multicheck',
			),
			array(
				'name'    => 'Discounts for:',
				'desc'    => '',
				'id'      => $prefix . 'discount',
				'taxonomy' => 'discounts', //Enter Taxonomy Slug
				'type' => 'taxonomy_multicheck',
			),			
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'rvp_park_rates_metaboxes' );

/** RV Park Details
-------------------------------------------------------------- */
function rvp_park_details_metaboxes( $meta_boxes ) {
	$prefix = 'park_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'rvp_park_details_metabox',
		'title' => 'RV Park Details',
		'pages' => array('rvparks'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'RV Park Open Dates',
				'desc'    => 'Enter 1/1 12/31 to display "Year Round"',
				'id'      => $prefix . 'season',
				'type'    => 'park_season',
			),
			array(
				'name'    => 'Activities',
				'desc'    => '',
				'id'      => $prefix . 'activities',
				'taxonomy' => 'activities', //Enter Taxonomy Slug
				'type' => 'taxonomy_multicheck',
			),			
			array(
				'name'    => 'Features',
				'desc'    => '',
				'id'      => $prefix . 'features',
				'taxonomy' => 'features', //Enter Taxonomy Slug
				'type' => 'taxonomy_multicheck',
			),				
			array(
				'name'    => 'Atmosphere',
				'desc'    => '',
				'id'      => $prefix . 'atmosphere',
				'taxonomy' => 'atmospheres', //Enter Taxonomy Slug
				'type' => 'taxonomy_multicheck',
			),										
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'rvp_park_details_metaboxes' );

/** Custom Metaboxes - Park Seasons
*************************************/
add_action( 'cmb_render_park_season', 'rrh_cmb_render_park_season', 10, 2 );
function rrh_cmb_render_park_season( $field ) {
	global $post;
	$meta2 = get_post_meta( $post->ID);
	$meta3 = unserialize($meta2['park_season'][0] );
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

/** RV Park Clubs
-------------------------------------------------------------- */
function rvp_park_clubs_metaboxes( $meta_boxes ) {
	$prefix = 'park_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'rvp_park_clubs_metabox',
		'title' => 'RV Clubs This Park Honors',
		'pages' => array('rvparks'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(				
			array(
				'name'    => 'Clubs',
				'desc'    => '',
				'id'      => $prefix . 'clubs',
				'taxonomy' => 'clubs', //Enter Taxonomy Slug
				'type' => 'taxonomy_multicheck',
			),						
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'rvp_park_clubs_metaboxes' );
?>