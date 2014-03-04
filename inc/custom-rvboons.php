<?php
/**************
CUSTOM POST TYPE
**************/
function custom_post_type_rvboons() {
	$labels = array(
		'name'                => _x( 'RV Boondocks', 'Post Type General Name', 'tabula_rasa' ),
		'singular_name'       => _x( 'RV Boondock', 'Post Type Singular Name', 'tabula_rasa' ),
		'menu_name'           => __( 'RV Boondock', 'tabula_rasa' ),
		'parent_item_colon'   => __( 'Parent RV Boondock:', 'tabula_rasa' ),
		'all_items'           => __( 'All RV Boondocks', 'tabula_rasa' ),
		'view_item'           => __( 'View RV Boondock', 'tabula_rasa' ),
		'add_new_item'        => __( 'Add New RV Boondock', 'tabula_rasa' ),
		'add_new'             => __( 'New RV Boondock', 'tabula_rasa' ),
		'edit_item'           => __( 'Edit RV Boondock', 'tabula_rasa' ),
		'update_item'         => __( 'Update RV Boondock', 'tabula_rasa' ),
		'search_items'        => __( 'Search RV Boondocks', 'tabula_rasa' ),
		'not_found'           => __( 'No RV Boondocks found', 'tabula_rasa' ),
		'not_found_in_trash'  => __( 'No RV Boondocks found in Trash', 'tabula_rasa' ),
	);

	$rewrite = array(
		'slug'                => 'rv-boondock',
		'with_front'          => true,
		'pages'               => false,
		'feeds'               => false,
	);

	$args = array(
		'label'               => __( 'rvboons', 'tabula_rasa' ),
		'description'         => __( 'RV Boondock pages', 'tabula_rasa' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'comments', 'revisions' ),
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
		'capability_type'     => 'rvboon',
	);

	register_post_type( 'rvboons', $args );
}
// Hook into the 'init' action
add_action( 'init', 'custom_post_type_rvboons', 0 );

/**************
TAXONOMIES
**************/
/** Boondocks
-------------------------------------------------------------- */
function custom_taxonomy_rvboons()  {

	$labels = array(
		'name'                       => _x( 'Types', 'Taxonomy General Name', 'tabula_rasa' ),
		'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'tabula_rasa' ),
		'all_items'                  => __( 'All Types', 'tabula_rasa' ),
		'new_item_name'              => __( 'New Type Name', 'tabula_rasa' ),
		'add_new_item'               => __( 'Add New type', 'tabula_rasa' ),
		'edit_item'                  => __( 'Edit Type', 'tabula_rasa' ),
		'update_item'                => __( 'Update Type', 'tabula_rasa' ),
		'search_items'               => __( 'Search Types', 'tabula_rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'map_meta_cap'				=> true,
		'capability_type'     => 'rvboon',
	);
	register_taxonomy( 'boons', 'rvboons', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_rvboons', 0 );

/**************
META BOXES MAP
**************/
function add_map_rvboons() {
    add_meta_box( 'map_meta_box',
        'Your Location',
        'display_map_meta_box',
        'rvboons', 'side', 'default'
    );
}
add_action( 'admin_init', 'add_map_rvboons' );

/**************
META BOXES
**************/
/** RV Boondocks
-------------------------------------------------------------- */
function boons_type_metaboxes( $meta_boxes ) {
	$prefix = 'boon_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'boons_type_metabox',
		'title' => 'Type of Boondock',
		'pages' => array('rvboons'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(				
			array(
				'name'    => 'Boondocks',
				'desc'    => '',
				'id'      => $prefix . 'types',
				'taxonomy' => 'boons', //Enter Taxonomy Slug
				'type' => 'taxonomy_multicheck',
			),						
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'boons_type_metaboxes' );

function rvboons_info_metaboxes( $meta_boxes ) {
	$prefix = 'boon_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'boon_info_metabox',
		'title' => 'Basic Information',
		'pages' => array('rvboons'), // post type
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
			array(
				'name'    => 'Overnight Parking',
				'desc'    => '',
				'id'      => $prefix . 'overnight',
				'type'    => 'checkbox',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'rvboons_info_metaboxes' );
?>