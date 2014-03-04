<?php
/*
inc/admin.php
	- check_user_role($roles,$user_id=NULL)
	- Grab status for RV parks
	- get_current_post_type()
	- Add admin-user to admin body class
	- ADMIN SCRIPTS
		- load_custom_wp_admin_style()
	- ADMIN BAR
		- Mods admin bar edit option for current user only
		- Remove Admin bar except for admin
		- Change Howdy to Welcome on admin bar
	- CUSTOM LOGIN PAGE
		- calling your own login css so you can style it
		- changing the logo link from wordpress.org to your site
		- changing the alt text on the logo to show your site name
	- DASHBOARD WIDGETS
		- disable_default_dashboard_widgets()
	- ADMIN PAGES
		- my_remove_menu_pages()
	- ADMIN FOOTER
		- custom_admin_footer()
		- my_footer_version()
	- MOD COMMENT PRIVELAGES
		- remove_comment_edit($actions, $comment)
		- Unset contact methods on profile
	- USER EDIT PAGE MODS
		- rvparks_updated_messages( $messages )
		- remove edit screen metaboxes
		- editor box mods
			- reposition editor box
			- Puts editor functions into meta box
			- Modifying TinyMCE editor to remove unused items.
			- TinyMCE: First line toolbar customizations
		- Feature Image Box Mods
		- Add gallery meta box
		- Map Meta box
		- Save map info into rvty_geodata
	- LIST PAGE MODS
		- Users
			- columns_head_only_users( $columns )
			- columns_content_only_users( $value, $column_name, $id )
			- my_sortable_users_column( $columns )
			- my_orderby_users( $query )
		- RV Parks
			- columns_head_only_rvparks( $columns )
			- columns_content_only_rvparks( $column_name, $post_id )
			- my_sortable_rvparks_column( $columns )
			- my_orderby_parks( $query )
		- RV Dumps
			- columns_head_only_rvdumps( $columns )
			- columns_content_only_rvdumps( $column_name, $post_id )
			- my_sortable_rvdumps_column( $columns )
			- my_orderby_dumps( $query )
		- RV Boons
			- columns_head_only_rvboons( $columns )
			- columns_content_only_rvboons( $column_name, $post_id )
			- my_sortable_rvboons_column( $columns )
			- my_orderby_boons( $query )
	- GALLERY MODS
		- Remove Media Library Tab
	- POST PAGE MODS
		- disable_metaboxes()
		- makes posts only visible by authors			
*/

//Check User Role 
function check_user_role($roles,$user_id=NULL) {
	// Get user by ID, else get current user
	if ($user_id)
		$user = get_userdata($user_id);
	else
		$user = wp_get_current_user();
	// No user found, return
	if (empty($user))
		return FALSE;
	// Append administrator to roles, if necessary
	//if (!in_array('administrator',$roles))
		//$roles[] = 'administrator';
	// Loop through user roles
	foreach ($user->roles as $role) {
		// Does user have role
		if (in_array($role,$roles)) {
			return TRUE;
		}
	}
	// User not in roles
	return FALSE;
}

// Grab status for RV parks
function check_status($wpid) {
	global $wpdb;
	//$status = $wpdb->get_var( $wpdb->prepare( "SELECT park_status FROM rvty_parks WHERE wpid = $wpid" ) );
	$status = wp_get_object_terms( $post->ID, 'status_levels' );
$status = $status[0]->slug;
	return $status;
}

// gets the current post type in the WordPress Admin
function get_current_post_type() {
  global $post, $typenow, $current_screen;
	
  //we have a post so we can just get the post type from that
  if ( $post && $post->post_type )
    return $post->post_type;
    
  //check the global $typenow - set in admin.php
  elseif( $typenow )
    return $typenow;
    
  //check the global $current_screen object - set in sceen.php
  elseif( $current_screen && $current_screen->post_type )
    return $current_screen->post_type;
  
  //lastly check the post_type querystring
  elseif( isset( $_REQUEST['post_type'] ) )
    return sanitize_key( $_REQUEST['post_type'] );
	
  //we do not know the post type!
  return null;
}

// Add admin-user to admin body class
function add_admin_class_to_admin_body($classes) {
    if (is_user_logged_in() && !current_user_can('manage_options')) {
        $classes .= 'not-admin-user ';
				
				global $post;
				$status = wp_get_object_terms( $post->ID, 'status_levels' );
				$status = $status[0]->slug;
				if ( $status == 1 ) { $classes .= 'status-1 '; }
				if ( $status == 2 ) { $classes .= 'status-2 '; }
				if ( $status == 3 ) { $classes .= 'status-3 '; }
				if ( $status == 4 ) { $classes .= 'status-4 '; }
    }
    return $classes;
}
add_filter('admin_body_class','add_admin_class_to_admin_body');

/************* ADMIN SCRIPTS **************/

function load_custom_wp_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/admin.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
	global $pagenow; // for map stuff
	if ( $pagenow == 'post.php' ) {
		// Google map stuff for admin post pages
		wp_register_script('google_maps', 'http://maps.googleapis.com/maps/api/js?sensor=false', false, '3', true);
		wp_enqueue_script( 'google_maps' );
		wp_register_script('jquery_autocomplete', get_template_directory_uri() . '/inc/maps-admin/js/jquery.autocomplete.min.js', array('jquery'), false, true);
		wp_enqueue_script( 'jquery_autocomplete' );
		wp_register_script('geoinfo', get_template_directory_uri() . '/inc/maps-admin/js/geo-tag.geoinfo.js', array('jquery', 'google_maps', 'jquery_autocomplete'), '0.9.6', true);
		wp_enqueue_script( 'geoinfo' );
		wp_register_style('jquery_autocomplete_css', get_template_directory_uri() . '/inc/maps-admin/css/jquery.autocomplete.css', false, '0.9.6', 'screen');
		wp_enqueue_style( 'jquery_autocomplete_css' );	
		wp_register_style('geotag_admin', get_template_directory_uri() . '/inc/maps-admin/css/admin.css', array(), '0.9.6', 'screen');	
		wp_enqueue_style( 'geotag_admin' );
	}
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

/************* ADMIN BAR **************/
// Mods admin bar edit option for current user only
function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo'); 
	if(!current_user_can('administrator')) {
		$wp_admin_bar->remove_menu('new-content');
		$wp_admin_bar->remove_menu('search');
		$wp_admin_bar->remove_menu('comments');		
		global $post;
		$author = $post->post_author;
		$user_id = get_current_user_id();
		if ($author != $user_id) { 
			$wp_admin_bar->remove_menu('edit');
		}
	}
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

// Remove Admin bar except for admin
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remove_admin_bar');

// Change Howdy to Welcome on admin bar
function replace_howdy( $wp_admin_bar ) {
	$my_account=$wp_admin_bar->get_node('my-account');
	$newtitle = str_replace( 'Howdy,', 'Welcome,', $my_account->title );
	$wp_admin_bar->add_node( array(
			'id' => 'my-account',
			'title' => $newtitle,
	) );
}
add_filter( 'admin_bar_menu', 'replace_howdy',25 );

/************* CUSTOM LOGIN PAGE *****************/
// calling your own login css so you can style it
function login_css() {
	wp_enqueue_style( 'login_css', get_template_directory_uri() . '/css/login.css', false );
}
add_action( 'login_enqueue_scripts', 'login_css', 10 );

// changing the logo link from wordpress.org to your site
function login_url() {  return home_url(); }
add_filter('login_headerurl', 'login_url');

// changing the alt text on the logo to show your site name
function login_title() { return get_option('blogname'); }
add_filter('login_headertitle', 'login_title');

/************* DASHBOARD WIDGETS *****************/
// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');
	remove_meta_box('w3tc_pagespeed', 'dashboard', 'core');
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
	remove_meta_box('dashboard_activity', 'dashboard', 'core');
}
if(!current_user_can('administrator')) {
	add_action('admin_menu', 'disable_default_dashboard_widgets'); 
}

/************* ADMIN PAGES *****************/
function my_remove_menu_pages() {
	if(!current_user_can('administrator')) {
		remove_menu_page('index.php'); // Dashboard
		remove_menu_page('edit.php'); //Posts
		remove_menu_page('tools.php'); // Tools
		remove_menu_page('edit-comments.php'); // Comments
		remove_menu_page('edit.php?post_type=portfolio_slideshow'); // Slideshow
		remove_menu_page('post-new.php?post_type=rvparks'); // Add New RV Park
		remove_menu_page('upload.php'); // Media
		remove_menu_page('edit.php?post_type=pricing-table'); // Pricing Table
		remove_submenu_page( 'edit.php?post_type=rvparks', 'post-new.php?post_type=rvparks' );
		remove_submenu_page( 'edit.php?post_type=rvparks', 'edit.php?post_type=rvparks' );
		remove_submenu_page( 'edit.php?post_type=rvdumps', 'post-new.php?post_type=rvdumps' );
		remove_submenu_page( 'edit.php?post_type=rvdumps', 'edit.php?post_type=rvdumps' );		
	}
}
add_action( 'admin_menu', 'my_remove_menu_pages' );

/********* ADMIN FOOTER **********************/
function custom_admin_footer() {
	_e('<span id="footer-thankyou">Developed by <a href="http://third-law.com" target="_blank">Third Law Web Design</a></span>. Built using Tabula Rasa.', 'tabula_rasa');
}
add_filter('admin_footer_text', 'custom_admin_footer');

function my_footer_version() { return ''; }
add_filter( 'update_footer', 'my_footer_version', 11 );
//!! Not sure if I need this or if it is already taken care of elsewhere
add_filter('the_generator', 'wpbeginner_remove_version');

/********* MOD COMMENT PRIVELAGES **********************/
//$status = check_status($post->ID);
// Comments
function remove_comment_edit($actions, $comment) {
	if(!current_user_can('administrator')) {	
		$user_id = get_current_user_id();
		global $post;
$status = wp_get_object_terms( $post->ID, 'status_levels' );
$status = $status[0]->slug;
			if ($status > 2) {
			//enables reply only
			if ($comment->user_id != $user_id) {
				unset($actions['edit']);
				unset($actions['quickedit']);
				unset($actions['trash']);			
				unset($actions['spam']);
				unset($actions['approve']);	
				unset($actions['unapprove']);					
			}
			// enables edit amd trash only
			if ($comment->user_id == $user_id) {
				unset($actions['quickedit']);			
				unset($actions['spam']);
				unset($actions['approve']);	
				unset($actions['unapprove']);
				unset($actions['reply']);					
			}	
			// enables edit only
			if ($comment->comment_parent != 0) {
				unset($actions['quickedit']);			
				unset($actions['spam']);				
				unset($actions['approve']);	
				unset($actions['unapprove']);
				unset($actions['reply']);					
			}
		} else {
			unset($actions['edit']);	
			unset($actions['quickedit']);			
			unset($actions['spam']);				
			unset($actions['approve']);	
			unset($actions['unapprove']);
			unset($actions['reply']);	
			unset($actions['trash']);				
		}
	}
	return $actions;
}
add_filter('comment_row_actions', 'remove_comment_edit', 1, 2);

// Unset contact methods on profile
function my_user_contactmethods($user_contactmethods){  
  unset($user_contactmethods['yim']);  
  unset($user_contactmethods['aim']);  
  unset($user_contactmethods['jabber']);    
  return $user_contactmethods;  
} 
add_filter('user_contactmethods', 'my_user_contactmethods');

/** USER EDIT PAGE MODS **/
function rvparks_updated_messages( $messages ) {
	$messages['rvparks'] = array(
	0 => '', // Unused. Messages start at index 1.
	1 => sprintf( __('RV Park updated. <a href="%s">View RV Park</a>'), esc_url( get_permalink($post_ID) ) ),
	2 => __('Custom field updated.'),
	3 => __('Custom field deleted.'),
	4 => __('RV Park updated.'),
	/* translators: %s: date and time of the revision */
	5 => isset($_GET['revision']) ? sprintf( __('RV Park restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	6 => sprintf( __('RV Park published. <a href="%s">View RV Park</a>'), esc_url( get_permalink($post_ID) ) ),
	7 => __('RV Park saved.'),
	8 => sprintf( __('RV Park submitted. <a target="_blank" href="%s">Preview RV Park</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	9 => sprintf( __('RV Park scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview RV Park</a>'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	10 => sprintf( __('RV Park draft updated. <a target="_blank" href="%s">Preview RV Park</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter('post_updated_messages', 'rvparks_updated_messages');

// remove edit screen metaboxes
function remove_default_page_screen_metaboxes() {
	if(!current_user_can('manage_options')) {
		remove_meta_box( 'commentstatusdiv','rvparks','normal' );
		remove_meta_box( 'commentstatusdiv','rvdumps','normal' );
		remove_meta_box( 'commentsdiv','rvdumps','normal' );
		remove_meta_box('slugdiv', 'rvparks', 'default');
		//remove_meta_box('rvp_adminonly_metabox', 'rvparks', 'side');
	}
	remove_meta_box('postimagediv', 'rvparks', 'side');
	//add_meta_box('postimagediv', 'rvparks', 'side', 'high');
}
add_action('admin_menu','remove_default_page_screen_metaboxes');


// Editor Box Mods
// reposition editor box

function action_add_meta_boxes() {
	global $_wp_post_type_features;
	if (isset($_wp_post_type_features['rvparks']['editor']) && $_wp_post_type_features['rvparks']['editor']) {
		unset($_wp_post_type_features['rvparks']['editor']);
		add_meta_box(
			'description_section',
			__('RV Park Description'),
			'inner_custom_box',
			'rvparks', 'side', 'low'
		);
	}
}
add_action( 'add_meta_boxes', 'action_add_meta_boxes', 0 );

// Puts editor functions into meta box
function inner_custom_box( $post ) {
	global $post;
$status = wp_get_object_terms( $post->ID, 'status_levels' );
$status = $status[0]->slug;
	if ( $status > 2 ) { 
		the_editor($post->post_content);
	} else {
		echo 'RV Park description is only available to RV Parks with Enhanced Listings.<br /><a href="http://rvthereyetdirectory.com/advertise/">Purchase an Enhanced Listing today!</a>';
	}
}

// Modifying TinyMCE editor to remove unused items.
function customformatTinyMCE($init) {
	// Add block format elements you want to show in dropdown
	$init['theme_advanced_blockformats'] = 'p,pre,h1,h2,h3,h4';
	$init['theme_advanced_disable'] = 'strikethrough,underline,forecolor,justifyfull';
	return $init;
}

// TinyMCE: First line toolbar customizations
if( !function_exists('base_extended_editor_mce_buttons') ){
	if(!current_user_can('administrator')) {
		function base_extended_editor_mce_buttons($buttons) {
			// The settings are returned in this array. Customize to suite your needs.
			return array(
				'bold', 'italic', 'justifyleft', 'justifycenter', 'justifyright', 'spellchecker'
			);
			/* WordPress Default
			return array( 'bold', 'italic', 'strikethrough', 'separator', 'bullist', 'numlist', 'blockquote', 'separator', 'justifyleft', 'justifycenter', 'justifyright', 'separator', 'link', 'unlink', 'wp_more', 'separator', 'spellchecker', 'fullscreen', 'wp_adv'
			); */
		}
		add_filter("mce_buttons", "base_extended_editor_mce_buttons", 0);
	}
}

// Feature Image Box Mods
function custom_admin_post_thumbnail_html( $content ) {
	$post_type = get_current_post_type();
		global $post;
$status = wp_get_object_terms( $post->ID, 'status_levels' );
//print_r ( $status );
//echo $post_id;
$status = $status[0]->slug;
		//$values = get_post_meta( $post->ID );
		//echo $status = $values['park_status'][0];
		//echo $status;
		if( $post_type == 'rvparks' ) {
			if ( $status > 3 ) { 
				echo 'After clicking on "Set Featured Image", go to the gallery, choose the image you want to use, and click "show". Scroll to the bottom and click "Use as featured image".';
				$content = $content;
				//echo $status;
			} else { 
				$content = 'Featured Image is only available to RV Parks with Featured Listings.<br /><a href="http://rvthereyetdirectory.com/advertise/">Purchase a Featured Listing today!</a>';
			//	echo $status;
			}
		}
		return $content;
}
add_filter( 'admin_post_thumbnail_html', 'custom_admin_post_thumbnail_html' );

// Add gallery meta box
function gallery_box() {
	add_meta_box('gallery_field', 'Photo Gallery', 'gallery_show_box', 'rvparks', 'side', 'low');
}
add_action('admin_menu', 'gallery_box');

// Display gallery meta box
function gallery_show_box() {
	global $post;
$status = wp_get_object_terms( $post->ID, 'status_levels' );
$status = $status[0]->slug;
	if ( $status > 2 ) { 
		$args = array(
			'post_type' => 'attachment',
			'post_status' => 'inherit',
			'post_parent' => $post->ID,
			'post_mime_type' => 'image',
			'numberposts' => -1,
			'order' => 'ASC',
			'orderby' => 'menu_order',
		);
		$attachments = get_children( $args );

		echo '<p><a href="media-upload.php?post_id=' . $post->ID .'&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=715" id="add_image" class="thickbox" title="' . __( 'Add Image', 'gallery-metabox' ) . '">' . __( 'Upload Images', 'gallery-metabox' ) . '</a> | <a href="media-upload.php?post_id=' . $post->ID .'&amp;type=image&amp;tab=gallery&amp;TB_iframe=1&amp;width=640&amp;height=715" id="manage_gallery" class="thickbox" title="' . __( 'Manage Gallery', 'gallery-metabox' ) . '">' . __( 'Manage Gallery', 'gallery-metabox' ) . '</a></p>';

		if ($attachments) {
			foreach($attachments as $attachment) {
				$admin_gallery .= '<a href="' . wp_get_attachment_url( $attachment->ID, 'gallery-full' ) . '" >' . wp_get_attachment_image( $attachment->ID, 'featured-thumb' ) . '</a>';
			}
		}
		echo $admin_gallery;
	} else {
		echo 'A Photo Gallery is only available to RV Parks with Enhanced Listings.<br /><a href="http://rvthereyetdirectory.com/advertise/">Purchase an Enhanced Listing today!</a>';
	}
}

/* Map Stuff
-------------------------------------------------------------- */

/****** MAP META BOX ****/
function display_map_meta_box() {
	global $wpdb;
	global $post;
	$post_type = get_post_type();
	if ( 'rvparks' == $post_type ) {
		$field_value = 'park';
	}
	if ( 'rvdumps' == $post_type ) {
		$field_value = 'dump';
	}
	if ( 'rvboons' == $post_type ) {
		$field_value = 'boon';
	}	
	$values = get_post_meta( $post->ID);
	$values = unserialize($values[$field_value . '_coords'][0] );	
	$lat = $values[$field_value . '_lat'];
	$lng = $values[$field_value . '_lng'];
  $map_meta_box = '
	<table>
			<tr>
					<td>
						<input type="text" name="' . $field_value . '_lat" id="lat" size="10" style="width:10em;" value="' .$lat . '"/>&nbsp;&nbsp;
					</td>
					<td>
						<input type="text" name="' . $field_value . '_lng" id="lng" size="10" style="width:10em;" value="' . $lng . '" />&nbsp;&nbsp;&nbsp;
					</td>
			</tr>
	</table>
	<br style="clear:both;" />
	<div id="map_address" style="padding: 5px 0 5px 5px; ">Map Address: </div>
	<div id="map" style="height:250px; width:100%; padding:0px; margin:0px;"></div>';
	echo $map_meta_box;
}

/******** SAVE MAP INFO IN RVTY_GEODATA ************/
function save_map_fields( $rvparks_id, $rvparks) {
	//if ( !is_page() ) {
	global $wpdb;
	global $post;
	$post_type = get_post_type();
	if ( 'rvparks' == $post_type ) {
		$field_value = 'park';
	}
	if ( 'rvdumps' == $post_type ) {
		$field_value = 'dump';
	}
	if ( 'rvboons' == $post_type ) {
		$field_value = 'boon';
	}	
	if ( $post_type == 'rvparks' || $post_type == 'rvdumps' || $post_type == 'rvboons' ) {
		$lat = $_POST[$field_value . '_lat'];
		$lng = $_POST[$field_value . '_lng'];
		$post_id = $post->ID;
		$is_there = $wpdb->get_row("SELECT post_id FROM rvty_geodata WHERE post_id = $post_id");
		if ( $is_there->post_id != '' ) {
			$wpdb->update( 
				'rvty_geodata', 
				array( 
					'post_id' => $post_id,	// string
					'geo_latitude' => $lat,	// string
					'geo_longitude' => $lng,	// integer (number) 
					'post_type' => $post_type,	// integer (number) 
				), 
				array( 'post_id' => $post_id ), 
				array( 
					'%d',	// value1
					'%f',	// value1
					'%f',	// value2
					'%s'	// value2
				), 
				array( '%d' ) 
			);
			$coords = array( $field_value.'_lat' => $lat, $field_value.'_lng' => $lng );
			if ( $coords != '' ) { update_post_meta( $post_id, $field_value.'_coords', $coords ); }
			
		}	else {
		/** Save Nearby Locations
		********************************/	
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
			$coords = array( $field_value.'_lat' => $lat, $field_value.'_lng' => $lng );
			if ( $coords != '' ) { add_post_meta( $post_id, $field_value.'_coords', $coords ); }		
		}
		nearbyLocations ( $post_id, $post_type, $field_value, $lat, $lng, 1 );
	//}
}
}
add_action( 'save_post', 'save_map_fields', 10, 2 ); 


/*************** LIST PAGE MODS ********************/
  
// Users
function columns_head_only_users( $columns ) {  
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'username' => __( 'Username' ),
		'name' => __( 'Name' ),
		'email' => __( 'Email' ),
		'role' => __( 'Role' ),
		'linkedto' => __( 'Associated with:' ),
	);
	return $columns;
}
add_filter('manage_users_columns', 'columns_head_only_users', 10);

function columns_content_only_users( $value, $column_name, $id ) {
global $wpdb;
	if ($column_name == 'linkedto') {
		//return $id; 
			$parks_query = $wpdb->get_results( "SELECT * FROM rvty_posts WHERE post_author = '$id' ORDER BY ID ASC" );
			//return $parks_query;
			foreach ($parks_query as $park) {
				$linkedto = '<a href="http://localhost/rvthereyetdirectory.com/wp-admin/post.php?post=' . $park->ID . '&action=edit">' . $park->post_title . '</a>' .$park->post_author;
				return $linkedto;
			}
	}
}
add_action('manage_users_custom_column', 'columns_content_only_users', 10, 3);

function my_sortable_users_column( $columns ) {  
    $columns['linkedto'] = 'linkedto';  
    return $columns;  
}
add_filter( 'manage_users_sortable_columns', 'my_sortable_users_column' );  

function my_orderby_users( $query ) {  
global $wpdb;
	if( ! is_admin() )  
			return;  
	$orderby = $query->get( 'orderby');  
	if( 'linkedto' == $orderby ) {  
			//$query->set('meta_key', 'linkedto');  
			$query->set('orderby', $park->post_title );  
	}
}  
add_action( 'pre_get_posts', 'my_orderby_users' ); 

// RV Parks
function columns_head_only_rvparks( $columns ) { 
	if( current_user_can( 'administrator' ) ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'RV Park' ),
			'taxonomy-states' => __( 'State' ),
			'park_city' => __( 'City' ),
			'taxonomy-status_levels' => __( 'Status' ),
			'date' => __( 'Date' )
		);
	} else {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'RV Park' ),
			'taxonomy-states' => __( 'State' ),
			'park_city' => __( 'City' ),
			'date' => __( 'Date' )
		);	
	}
	return $columns;
}
add_filter('manage_rvparks_posts_columns', 'columns_head_only_rvparks', 10);

function columns_content_only_rvparks( $column_name, $post_id ) {
	global $post;
	$post_id = $post->ID;	
	$values = get_post_meta( $post_id );
	if ($column_name == 'park_city') {
		echo $city = $values['park_city'][0];
	}
}
add_action('manage_rvparks_posts_custom_column', 'columns_content_only_rvparks', 10, 2);

function my_sortable_rvparks_column( $columns ) {  
    $columns['park_city'] = 'park_city';  
    $columns['taxonomy-status_levels'] = 'taxonomy-status_levels';  
    return $columns;  
}
add_filter( 'manage_edit-rvparks_sortable_columns', 'my_sortable_rvparks_column' );  

function my_orderby_parks( $query ) {  
	if( ! is_admin() )  
			return;  
	$orderby = $query->get( 'orderby');  
	if( 'park_city' == $orderby ) {  
			$query->set('meta_key', 'park_city');  
			$query->set('orderby','meta_value');  
	}  
	/*if( 'status' == $orderby ) {  
			$query->set('meta_key', 'park_status');  
			$query->set('orderby','meta_value');  
	}  */
}  
add_action( 'pre_get_posts', 'my_orderby_parks' ); 

// RV Dumps
function columns_head_only_rvdumps( $columns ) {  
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'RV Dump' ),
		'taxonomy-states' => __( 'State' ),
		'dump_city' => __( 'City' ),
		'taxonomy-dump_water' => __( 'Water' ),
		'date' => __( 'Date' )
	);
	return $columns;
}
add_filter('manage_rvdumps_posts_columns', 'columns_head_only_rvdumps', 10);

function columns_content_only_rvdumps( $column_name, $post_id ) {
global $post;
$post_id = $post->ID;
	if ($column_name == 'dump_city') {
		$values = get_post_meta( $post_id );
		echo $city = $values['dump_city'][0];
	}
}
add_action('manage_rvdumps_posts_custom_column', 'columns_content_only_rvdumps', 10, 2);

function my_sortable_rvdumps_column( $columns ) {  
    $columns['dump_city'] = 'dump_city';  
    return $columns;  
}
add_filter( 'manage_edit-rvdumps_sortable_columns', 'my_sortable_rvdumps_column' );  

function my_orderby_dumps( $query ) {  
	if( ! is_admin() )  
			return;  
	$orderby = $query->get( 'orderby');  
	if( 'dump_city' == $orderby ) {  
			$query->set('meta_key', 'dump_city');  
			$query->set('orderby','meta_value');  
	}  
}  
add_action( 'pre_get_posts', 'my_orderby_dumps' ); 

// RV Boons
function columns_head_only_rvboons( $columns ) {  
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'RV Boondocks' ),
		'taxonomy-states' => __( 'State' ),
		'boon_city' => __( 'City' ),
		'date' => __( 'Date' )
	);
	return $columns;
}
add_filter('manage_rvboons_posts_columns', 'columns_head_only_rvboons', 10);

function columns_content_only_rvboons( $column_name, $post_id ) {
global $post;
$post_id = $post->ID;
	if ($column_name == 'boon_city') {
		$values = get_post_meta( $post_id );
		echo $city = $values['boon_city'][0];
	}
}
add_action('manage_rvboons_posts_custom_column', 'columns_content_only_rvboons', 10, 2);

function my_sortable_rvboons_column( $columns ) {  
    $columns['boon_city'] = 'boon_city';  
    return $columns;  
}
add_filter( 'manage_edit-rvboons_sortable_columns', 'my_sortable_rvboons_column' );  

function my_orderby_boons( $query ) {  
	if( ! is_admin() )  
			return;  
	$orderby = $query->get( 'orderby');  
	if( 'boon_city' == $orderby ) {  
			$query->set('meta_key', 'boon_city');  
			$query->set('orderby','meta_value');  
	}  
}  
add_action( 'pre_get_posts', 'my_orderby_boons' ); 

//GALLERY MODS

//Remove Media Library Tab
function remove_medialibrary_tab($tabs) {
	if ( !current_user_can( 'administrator' ) ) {
		unset($tabs['library']);
		unset($tabs['type_url']);
		return $tabs;
	} else {
		return $tabs;
	}
}
add_filter('media_upload_tabs','remove_medialibrary_tab');
		
/********* POST PAGE MODS ******************/
function disable_metaboxes() {
	//remove_meta_box('statesdiv', 'post', 'side');
	remove_meta_box('statesdiv', 'rvparks', 'side');
	remove_meta_box('statesdiv', 'rvdumps', 'side');
	remove_meta_box('statesdiv', 'rvboons', 'side');
	remove_meta_box('status_levelsdiv', 'rvparks', 'side');
	remove_meta_box('typesdiv', 'rvparks', 'side');
	remove_meta_box('featuresdiv', 'rvparks', 'side');
	remove_meta_box('activitiesdiv', 'rvparks', 'side');
	remove_meta_box('paymentsdiv', 'rvparks', 'side');
	remove_meta_box('discountsdiv', 'rvparks', 'side');
	remove_meta_box('clubsdiv', 'rvparks', 'side');
	remove_meta_box('hookupsdiv', 'rvparks', 'side');
	remove_meta_box('atmospheresdiv', 'rvparks', 'side');
	remove_meta_box('accommodationsdiv', 'rvparks', 'side');
	remove_meta_box('other_campingdiv', 'rvparks', 'side');
	remove_meta_box('filtersdiv', 'rvparks', 'side');
	remove_meta_box('fsb-social-bar-rvparks', 'rvparks', 'normal');
	remove_meta_box('fsb-social-bar-post', 'post', 'normal');
	remove_meta_box('fsb-social-bar-rvdumps', 'rvdumps', 'normal');
	remove_meta_box('dump_waterdiv', 'rvdumps', 'side');
	remove_meta_box('postimagediv', 'rvdumps', 'side');
	remove_meta_box('boonsdiv', 'rvboons', 'side');
	remove_meta_box('postimagediv', 'rvboons', 'side');
	
	// Keep if admin, remove if not
	if(!current_user_can('administrator')) {
		//remove_meta_box('rvp_adminonly_metabox', 'rvparks', 'side');
	}
}
add_action('admin_menu', 'disable_metaboxes', 9999); 
if(!current_user_can('administrator')) {
}

//makes posts only visible by authors
function posts_for_current_author($query) {
	global $pagenow;
	if( 'edit.php' != $pagenow || !$query->is_admin )
			return $query;
	if( !current_user_can( 'administrator' ) ) {
		 global $user_ID;
		 $query->set('author', $user_ID );
	}
	return $query;
}
add_filter('pre_get_posts', 'posts_for_current_author');
?>