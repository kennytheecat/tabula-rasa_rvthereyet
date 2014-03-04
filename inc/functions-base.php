<?php
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

// we're firing all out initial functions at the start
function tr_launch() {
    // launching operation cleanup
    add_action('init', 'tr_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'tr_rss_version');
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'tr_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'tr_remove_recent_comments_style', 1);
    // clean up gallery output in wp
    add_filter('gallery_style', 'tr_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'tr_scripts_and_styles', 999);
    // launching this stuff after theme setup
    tr_theme_support();

    // adding sidebars to Wordpress (these are created in functions.php)
    add_action( 'widgets_init', 'tr_register_sidebars' );
    // adding the tr search form (created in functions.php)
   // add_filter( 'get_search_form', 'tr_wpsearch' );

    // cleaning up random code around images
    add_filter('the_content', 'tr_filter_ptags_on_images');
    // cleaning up excerpt
    //add_filter('excerpt_more', 'tr_excerpt_more');
} /* end tr ahoy */
add_action('after_setup_theme','tr_launch', 16);

/*********************
WP_HEAD GOODNESS
The default wordpress head is a mess. Let's clean it up by removing all the junk we don't need.
*********************/

function tr_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	//remove canonical links
	remove_action('wp_head', 'rel_canonical');
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  add_filter( 'style_loader_src', 'tr_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  add_filter( 'script_loader_src', 'tr_remove_wp_ver_css_js', 9999 );
} /* end tr head cleanup */

// remove WP version from scripts
function tr_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove WP version from RSS
function tr_rss_version() { return ''; }

// remove injected CSS for recent comments widget
function tr_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function tr_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function tr_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function tr_scripts_and_styles() {
  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
  if (!is_admin()) {

    // modernizr (without media query polyfill)
    //wp_register_script( 'tabula_rasa-modernizr', get_stylesheet_directory_uri() . '/js/modernizr.custom.min.js', array(), '2.5.3', false );

    // comment reply script for threaded comments
    //if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
   //   wp_enqueue_script( 'comment-reply.min' );
   // }

		//dont know if this styled right
		/*	if ( is_singular() && wp_attachment_is_image() ) {
			wp_enqueue_script( 'Tabula Rasa-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
		} */
		
    // register main stylesheet
    wp_register_style( 'tabula_rasa-stylesheet', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );
		
    //adding scripts file in the footer
    wp_register_script( 'tabula_rasa-js', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), '', true );
		
		//Adds JavaScript for handling the navigation menu hide-and-show behavior.
		//wp_enqueue_script( 'tr-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

		//wp_enqueue_script( 'tr-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

    // enqueue styles and scripts
    //wp_enqueue_script( 'tabula_rasa-modernizr' );
    wp_enqueue_style( 'tabula_rasa-stylesheet' );

    // ie-only style sheet
    wp_register_style( 'tabula_rasa-ie-only', get_stylesheet_directory_uri() . '/css/ie.css', array(), '' );	
		wp_enqueue_style('tabula_rasa-ie-only', get_stylesheet_directory_uri() . "/css/ie.css", array(), '' );
   //$wp_styles->add_data( 'tabula_rasa-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet
		
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'tabula_rasa-js' );
		wp_localize_script('tabula_rasa-js', 'custom', array(
        'templateDir' => home_url() ));
    //wp_enqueue_script( 'tr-navigation' );
    //wp_enqueue_script( 'tr-skip-link-focus-fix' );
  }
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function tr_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');
	
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();	

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
	    array(
	    'default-image' => '',  // background image default
	    'default-color' => '', // background color default (dont add the #)
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => ''
	    )
	);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'audio',             // audio
			'chat',               // chat transcript
			'gallery',           // gallery of images
			'image',             // an image
			'link',              // quick link to other site
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video'             // video
		)
	);

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'tabula-rasa' ),   // main nav in header
			'sec-nav' => __( 'The Secondary Menu', 'tabula-rasa' ),   // secondary nav in header
			'footer-links' => __( 'Footer Links', 'tabula-rasa' ), // secondary nav in footer
			'social' => __( 'Social', 'tabula-rasa' ) // secondary nav in footer
		)
	);
} /* end tr_theme_support() */

/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function tr_main_nav() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'container_class' => 'menu clearfix',           // class of container (should you choose to use it)
    	'menu' => __( 'The Main Menu', 'tabula-rasa' ),  // nav name
    	'menu_class' => 'nav-menu',         // adding custom nav class
    	'theme_location' => 'main-nav',                 // where it's located in the theme
    	'before' => '',                                 // before the menu
			'after' => '',                                  // after the menu
			'link_before' => '',                            // before each link
			'link_after' => '',                             // after each link
			'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'tr_main_nav_fallback'      // fallback function
	));
} /* end tr_main_nav() */

// the secondary menu
function tr_sec_nav() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'container_class' => 'menu clearfix',           // class of container (should you choose to use it)
    	'menu' => __( 'The Secondar Menu', 'tabula-rasa' ),  // nav name
    	'menu_class' => 'nav sec-nav clearfix',         // adding custom nav class
    	'theme_location' => 'sec-nav',                 // where it's located in the theme
    	'before' => '',                                 // before the menu
			'after' => '',                                  // after the menu
			'link_before' => '',                            // before each link
			'link_after' => '',                             // after each link
			'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'tr_sec_nav_fallback'      // fallback function
	));
} /* end tr_sec_nav() */

// the footer menu (should you choose to use one)
function tr_footer_links() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => '',                              // remove nav container
    	'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
    	'menu' => __( 'Footer Links', 'tabula-rasa' ),   // nav name
    	'menu_class' => 'nav footer-nav clearfix',      // adding custom nav class
    	'theme_location' => 'footer-links',             // where it's located in the theme
    	'before' => '',                                 // before the menu
			'after' => '',                                  // after the menu
			'link_before' => '',                            // before each link
			'link_after' => '',                             // after each link
			'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'tr_footer_links_fallback'  // fallback function
	));
} /* end tr_footer_links() */

function tr_social_nav() {
	wp_nav_menu(
		array(
			'theme_location'  => 'social',
			'container'       => 'div',
			'container_id'    => 'menu-social',
			'container_class' => 'menu',
			'menu_id'         => 'menu-social-items',
			'menu_class'      => 'menu-items',
			'depth'           => 1,
			'link_before'     => '<span class="screen-reader-text">',
			'link_after'      => '</span>',
			'fallback_cb'     => '',
		)
	);
}

// this is the fallback for header menu
function tr_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => 'nav top-nav clearfix',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                            // before each link
        'link_after' => ''                             // after each link
	) );
}

// this is the fallback for secondary menu
function tr_sec_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => 'nav sec-nav clearfix',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                            // before each link
        'link_after' => ''                             // after each link
	) );
}

// this is the fallback for footer menu
function tr_footer_links_fallback() {
	/* you can put a default here if you like */
}

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function tr_register_sidebars() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'tabula-rasa' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'tabula-rasa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
	'name'          => __( 'Secondary Widget Area', 'tabula-rasa' ),
	'id'            => 'sidebar-2',
	'description'   => __( 'Appears on posts and pages in the sidebar.', 'tabula-rasa' ),
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h3 class="widget-title">',
	'after_title'   => '</h3>',
) );
	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. 

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php
	*/	
}

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function tr_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

/********************************************************
ADDING META DATA FUNCTIONS
********************************************************/
if ( ! function_exists( 'tr_content_nav' ) ) :
/**
Display navigation to next/previous pages when applicable
 */
function tr_content_nav( $html_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $html_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'tabula-rasa' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'tabula-rasa' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'tabula-rasa' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'tabula-rasa' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'tabula-rasa' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $html_id ); ?> -->
	<?php
}
endif; // tr_content_nav

/*
This is a modified the_author_posts_link() which just returns the link.
This is necessary to allow usage of the usual l10n process with printf().
 */
function tr_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}
/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 */

if ( !function_exists( 'of_get_option' ) ) {
	function of_get_option($name, $default = false) {
		$optionsframework_settings = get_option('optionsframework');
		
		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];
		if ( get_option($option_name) ) {
			$options = get_option($option_name);
		}
		if ( isset($options[$name]) ) {
			return $options[$name];
		} else {
			return $default;
		}
	}
}

/** Custom Meta Box Setup
********************************************************/
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'metabox/init.php' );
	}
}
add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );

/* Standard Embed size
*********************************************************/
function wpse_76102_new_embed_size() {
    // adjust these pixel values to your needs
    return array( 'width' => 600, 'height' => 400 );
}
add_filter( 'embed_defaults', 'wpse_76102_new_embed_size' );
?>