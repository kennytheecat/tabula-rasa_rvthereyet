<?php
/*
Tabula Rasa functions and definitions
*/

/************* INCLUDE NEEDED FILES ***************/
require_once('inc/functions-base.php');
/*
inc/functions-base.php
	- tr_launch()
	- head cleanup (remove rsd, uri links, junk css, ect)
	- tr_remove_wp_ver_css_js( $src )
		remove WP version from scripts
		remove injected CSS for recent comments widget
		remove injected CSS from recent comments widget
		remove injected CSS from gallery
	- SCRIPTS & ENQUEUEING
		- tr_scripts_and_styles()
	- Theme Support
		- add_theme_support('post-thumbnails')
		- add_theme_support( 'custom-background' )
		- add_theme_support('automatic-feed-links')
		- add_theme_support( 'post-formats' )
		- add_theme_support( 'menus' )
		- register_nav_menus()
	- MENUS & NAVIGATION
		- tr_main_nav()
		- tr_sec_nav()
		- tr_footer_links()
		- tr_main_nav_fallback()
		- tr_sec_nav_fallback()
		- tr_footer_links_fallback()
	- Active Sidebars
		- tr_register_sidebars()
	- Implement the Custom Header feature
	- removing <p> from around images
	- ADDING META DATA FUNCTIONS	
	 - tr_content_nav( $html_id )
		// Displays navigation to next/previous pages when applicable.		
	- tr_get_the_author_posts_link()
		// This is a modified the_author_posts_link() which just returns the link.	
	- of_get_option($name, $default = false)
		// Options panel related
	- Custom Meta Box Setup
	- Standard Embed size
*/
require_once('inc/functions-site.php');
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
*/
require_once('inc/functions-comments.php');
/*
inc/functions-comments.php
	- COMMENT LAYOUT
		- tr_comment( $comment, $args, $depth )	
	- THE COMMENT FORM
		- save_comment_meta_data( $comment_id )
		- save_park_vote_fields($comment_id)
	- COMMENTS IN THE ADMIN SECTION
		- extend_comment_add_meta_box()
		- extend_comment_meta_box ( $comment )
		- extend_comment_edit_metafields( $comment_id )
		- delete_park_votes( $comment_id )
		- trash_park_votes( $comment_id )
		- approve_park_votes( $comment_id )
		- set_comment_columns( $columns )
		- myplugin_comment_column( $column, $comment_ID )
*/ 
require_once('inc/functions-widgets.php'); 
/*
inc/functions-blog.php
	- rv_blogger_widget()
	- facebook_box()
	- add_your_blog()
	- register_widgets()
*/ 
// include various custom post types ans taxonomies
require_once('inc/custom-rvparks.php');
require_once('inc/custom-rvdumps.php');
require_once('inc/custom-rvboons.php');
require_once('inc/assets/array_statenames.php');
require_once('inc/functions-admin.php'); // this comes turned off by default
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
// If this is a function that you do not want to lose when you change themes, DO NOT put it in this file! 

/*********************************************************
EVEYTHING BELOW THIS LINE IS THEME SPECIFIC!!
********************************************************/
function tr_theme_specific_support() {
	// default thumb size
	//set_post_thumbnail_size(125, 125, true);
	//add_image_size('recent-blog-thumb', 180, 100, true);	
	add_image_size('blog-thumb', 220, 130, true);	
	add_image_size('listing-blog-thumb', 275, 100, true);	
	add_image_size('rvparks-blog-thumb', 320, 150, true);	
	add_image_size('featured-thumb', 100, 100, true);
	add_image_size('gallery-thumb', 320, 250, true);
	add_image_size('gallery-full', 800, 9999);	

	// This removes the annoying […] to a Read More link
	function tr_excerpt_more($more) {
		global $post;
		// edit here if you like
		return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'tabula_rasa') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'tabula_rasa') .'</a>';
	}	
	add_filter('excerpt_more', 'tr_excerpt_more');
	
	// Deregister styles
	function tr_deregister_styles() {
		wp_deregister_style( 'portfolio_slideshow' );
		//wp_deregister_style( 'fancybox' );
		wp_deregister_style( 'ps-photoswipe-style' );
		wp_deregister_style( 'wordpress-popular-posts' );
		wp_deregister_style( 'adminscript' );
		//wp_deregister_style( 'dashicons' );
		//wp_deregister_style( 'admin-bar' );
	}
	add_action( 'wp_print_styles', 'tr_deregister_styles', 100 );

	// Deregister scripts
	function tr_deregister_scripts() {
		//wp_deregister_script( 'scrollable' );
		//wp_deregister_script( 'fancybox' );
		//wp_deregister_script( 'ps-photoswipe-script' );
		//wp_deregister_script( 'cycle' );
		wp_deregister_script( 'portfolio-slideshow' );
	}
	add_action( 'wp_print_scripts', 'tr_deregister_scripts', 100 );
	
	// Enqueue scripts
	function tr_theme_specific_scripts_and_styles() {
		wp_register_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800|Open+Sans+Condensed:700', array(), '' );
		wp_enqueue_style( 'google-fonts' );
		//wp_register_script('google_maps', '//maps.googleapis.com/maps/api/js?&sensor=false', array(), '');
		//wp_enqueue_script( 'google_maps' );
		//wp_register_script( 'infobubble', get_stylesheet_directory_uri() . '/js/infobubble.js', array(), '' );	
		//wp_enqueue_script( 'infobubble' );		
		//wp_register_script( 'markercluster', get_stylesheet_directory_uri() . '/js/markercluster.js', array(), '' );
		//wp_enqueue_script( 'markercluster' );		
		//wp_register_script('spiderfier', get_stylesheet_directory_uri() .'inc/maps-admin/js/oms.min.js', array('google_maps'), '0.2.5', true);
		//wp_register_script('styled-marker', get_stylesheet_directory_uri() .'inc/maps-admin/js/StyledMarker.js', array('google_maps'), '0.5', true);
		//wp_enqueue_script( 'styled-marker' );	
		//wp_register_script('geotag-postmap', get_stylesheet_directory_uri() . 'inc/maps-admin/js/geo-tag.postmap.js', array('jquery', 'google_maps', 'spiderfier', 'styled-marker'), '0.9.4', true);
		//wp_register_style('geotag-postmap', get_stylesheet_directory_uri() .'inc/maps-admin/css/geo-tag.postmap.css', array(), '0.9.6', 'screen');	
		//wp_register_script('scripts', get_stylesheet_directory_uri() .'/js/scripts.js', array(), '', true );
		//wp_enqueue_script( 'scripts' );	
		// enables dropdowns to be clickable and go to url selected
	}
	add_action('wp_enqueue_scripts', 'tr_theme_specific_scripts_and_styles', 999);	
}	
add_action('after_setup_theme','tr_theme_specific_support', 16);
?>