<?php
/**
* @package WordPress
* @subpackage Starkers HTML5
*/
?>
<?php
//Include Admin Functions
include_once (TEMPLATEPATH . '/functions-admin.php');
?>
<?php
define("THEME_DIR", get_template_directory_uri());  
//REMOVE GENERATOR META TAG
remove_action('wp_head', 'wp_generator');  
  
//Enqueue Styles 
add_action( 'wp_enqueue_scripts', 'enqueue_styles' ); 
function enqueue_styles() {  
	/** REGISTER css/screen.css **/  
	wp_register_style( 'reset-style', THEME_DIR . '/style/css/reset.css', array(), '1', 'all' );
	wp_enqueue_style( 'reset-style' );
	wp_register_style( 'layout-style', THEME_DIR . '/style/css/layout.css', array(), '1', 'all' );
	wp_enqueue_style( 'layout-style' );
	wp_register_style( 'admin-style', THEME_DIR . '/style_wp_admin.css', array(), '1', 'all' );
	wp_enqueue_style( 'admin-style' );
	wp_register_style( 'main-style', THEME_DIR . '/style.css', array(), '1', 'all' );
	wp_enqueue_style( 'main-style' );	
	wp_register_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:700', array(), '1', 'all' );
	wp_enqueue_style( 'google-fonts' );
}
	
//Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );    
function enqueue_scripts() {  
/** Register Html5 Shim **/  
wp_register_script( 'html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array( 'jquery' ), '1', false );  
wp_enqueue_script( 'html5-shim' ); 	
}  
?>
<?php
add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );
function my_deregister_javascript() {
	if ( 'rvparks' != get_post_type() ){
		wp_deregister_script( 'scrollable' );
		wp_deregister_script( 'portfolio-slideshow' );
		wp_deregister_script( 'fancybox' );
		wp_deregister_script( 'ps-photoswipe-script' );
		wp_deregister_script( 'cycle' );
	}
}
add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
function my_deregister_styles() {
wp_deregister_style( 'ps-photoswipe-style' );
	if ( 'rvparks' != get_post_type() ){
		wp_deregister_style( 'portfolio_slideshow' );
		wp_deregister_style( 'fancybox' );	
	}	
}
?>
<?php //Came with the default install
add_theme_support( 'automatic-feed-links' );

//Hide Email From Spambots
function security_remove_emails($content) {
    $pattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/i';
    $fix = preg_replace_callback($pattern,"security_remove_emails_logic", $content);

    return $fix;
}
function security_remove_emails_logic($result) {
    return antispambot($result[1]);
}
add_filter( 'the_content', 'security_remove_emails', 20 );
add_filter( 'widget_text', 'security_remove_emails', 20 );


//Connect To Rv Blog Network
$newdb = new wpdb('thirdlaw_rvblogs', 'h3CnqSF7BY', 'thirdlaw_rvblogs', '50.22.66.60');
$newdb->show_errors(); 
?>
<?php
add_action( 'wpcf7_before_send_mail', 'my_conversion' );
function my_conversion( $contact_form )
{
$honeypot = $contact_form->posted_data["add-honeypot"];
if ($honeypot != '')
{$honeypot = 'CharlieChcikens';}
}
?>
<?php // hook add_query_vars function into query_vars
add_filter('query_vars', 'add_query_vars');
function add_query_vars($aVars) {
	$aVars[] .= 'var_state';
	$aVars[] .= 'var_city';
	$aVars[] .= 'var_clubs';
	$aVars[] .= 'var_stops';
	$aVars[] .= 'rvparks';  // represents the name of the variable as shown in the URL
	return $aVars;
}
// when adding new rewrites, permalinks need to be refreshed in the admin
// ([A-Z][a-z]+)  ([a-z][^/]+)  original - ([^/]+)
add_filter('init', 'add_rewrite_rules');
function add_rewrite_rules() {
	add_rewrite_rule(
		'rv-park/([^/]+)/?$', 'index.php?rvparks=$matches[1]', 'top'
	);
	add_rewrite_rule(
		'rv-parks/([^/]+)/?$', 'index.php?pagename=states&var_state=$matches[1]', 'top'
	);
	add_rewrite_rule(	
		'rv-parks/([^/]+)/([^/]+)/?$', 'index.php?pagename=cities&var_state=$matches[1]&var_city=$matches[2]', 'top'
	);
	add_rewrite_rule(
		'rv-snowbirds/([^/]+)/?$', 'index.php?pagename=rv-snowbirds&var_state=$matches[1]', 'top'
	);
	add_rewrite_rule(
		'rv-dumps/([^/]+)/?$', 'index.php?pagename=rv-dumps&var_state=$matches[1]', 'top'
	);
	add_rewrite_rule(
		'rv-stops/([^/]+)/([^/]+)/?$',  'index.php?pagename=rv-stops&var_state=$matches[1]&var_stops=$matches[2]', 'top'
	);
	add_rewrite_rule(
		'rv-clubs/([^/]+)/([^/]+)/?$', 'index.php?pagename=rv-clubs&var_state=$matches[1]&var_clubs=$matches[2]', 'top'
	);
}
?>
<?php
add_action('template_redirect', 'wpse64535_maybe_fix');
function wpse64535_maybe_fix()
{
    if(get_query_var('var_state') || get_query_var('var_city'))
    {
        remove_action('wp_head', 'rel_canonical');
        add_action('wp_head', 'wpse64535_fix_canonical');
    }
}

function wpse64535_fix_canonical()
{
    $link = home_url('rv-parks/');
		if (is_page('rv-dumps')) {$link = home_url('rv-dumps/');}
		if (is_page('rv-snowbirds')) {$link = home_url('rv-snowbirds/');}
		if (is_page('rv-clubs')) {$link = home_url('rv-clubs/');}
		if (is_page('rv-stops')) {$link = home_url('rv-stops/');}		
    // might want to validate these before just using them?
    if($state = get_query_var('var_state'))
        $link .= "{$state}/";
    if($city = get_query_var('var_city'))
        $link .= "{$city}/";
    if($clubs = get_query_var('var_clubs'))
        $link .= "{$clubs}/";				
    if($stops = get_query_var('var_stops'))
        $link .= "{$stops}/";
    echo '<link rel="canonical" href="' . esc_url($link) . '" />';
}
?>
<?php //Get State Variable
function get_url_var($the_url_var) {
	global $wp_query;
	if(isset($wp_query->query_vars["$the_url_var"])) {
		$URLvar = urldecode($wp_query->query_vars["$the_url_var"]);
		$URLvar = strtolower($URLvar);
	}	
	return $URLvar;
}	
?>
<?php // Create custom post type 
add_action('init', 'rv_parks_register');
function rv_parks_register() {
	$labels = array(
	'name' => _x('RV Parks', 'post type general name'),
	'singular_name' => _x('RV Park Item', 'post type singular name'),
	'add_new' => _x('Add New', 'rv_parks item'),
	'add_new_item' => __('Add New RV Park'),
	'edit_item' => __('Edit RV Park'),
	'new_item' => __('New RV Park'),
	'view_item' => __('View RV Parks'),
	'search_items' => __('Search RV Parks'),
	'not_found' => __('Nothing found'),
	'not_found_in_trash' => __('Nothing found in Trash'),
	'parent_item_colon' => ''
	);
	$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'query_var' => true,
    'rewrite' => array(  
        'slug'=>'rv-park',  
        'with_front'=> false,  
        'feed'=> true,  
        'pages'=> true  
    ),
	'capability_type' => 'post',
	'hierarchical' => false,
	'menu_position' => 5,
	'supports' => array('title', 'editor', 'thumbnail', 'comments')
	); 
	register_post_type( 'rvparks' , $args );
}
?>
<?php //Addmarker Thumbnail Support 
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' ); 
}
add_image_size('featured-thumb', 100, 100, true);
add_image_size('gallery-thumb', 290, 250, true);
add_image_size('gallery-full', 800, 9999);

//Changes Default Icon_Dir Dir To Theme /Graphics Dir 
add_filter( 'icon_dir', 'my_theme_icon_directory' );
add_filter( 'icon_dir_uri', 'my_theme_icon_uri' );
function my_theme_icon_directory( $icon_dir ) {
	return get_stylesheet_directory() . '/graphics';
}
function my_theme_icon_uri( $icon_dir ) {
	return get_stylesheet_directory_uri() . '/graphics'; 
}
//Came with the default install
/**
* Conditional Page/Post Navigation Links
* http://www.ericmmartin.com/conditional-pagepost-navigation-links-in-wordpress-redux/
* If more than one page exists, return TRUE.
*/
function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}
?>
<?php //DROPDOWN
function dropdown($default_line="RV Parks in...", $page_slug) {
	$StateSelect = "<select onChange=\"if(this.selectedIndex)window.location.href=(this.options[this.selectedIndex].value)\" name=\"state\" size=\"1\">\n<option value=''>$default_line</option>\n";

	global $StateNames;
	foreach($StateNames as $StateAbb=>$StateName){
		$WpFullStateName = strtolower( str_replace(" ", "-", $StateName) );
		$StateSelect .= "<option value='http://rvthereyetdirectory.com/$page_slug/$WpFullStateName'>$StateName</option>\n";
	}
	$StateSelect .="</select>";
	return $StateSelect;
}
?>
<?php //DOUBLE DROPDOWN
function double_dropdown($default_line="RV Parks in...", $default_line2, $page_slug, $value2) {
	$first_select = "<select onChange=\"if(this.selectedIndex)window.location.href=(this.options[this.selectedIndex].value)\" name=\"state\" size=\"1\">\n<option value=''>$default_line</option>\n";
	global $StateNames;
	foreach($StateNames as $StateAbb=>$StateName){
		$WpFullStateName = strtolower( str_replace(" ", "-", $StateName) );
		$first_select .= "<option value='http://rvthereyetdirectory.com/$page_slug/$WpFullStateName/$value2'>$StateName</option>\n";
	}
	$first_select .="</select>";
	
	global $state_wp;
	$second_select = "<select onChange=\"if(this.selectedIndex)window.location.href=(this.options[this.selectedIndex].value)\" name=\"second\" size=\"1\">\n<option value=''>$default_line2</option>\n";
	if (is_page('rv-clubs')) { global $ClubNames; $array2 = $ClubNames;}
	if (is_page('rv-stops')) { global $Retailers; $array2 = $Retailers;}
	foreach($array2 as $key=>$value){
		$wpvalue = strtolower( str_replace(" ", "-", $value) );
		$second_select .= "<option value='http://rvthereyetdirectory.com/$page_slug/$state_wp/$wpvalue'>$value</option>\n";
	}
	$second_select .="</select>";
	$dropdown_array = array($first_select, $second_select);
	return $dropdown_array;
}
?>
<?php //Featured Parks Query
function feat_parks_query($rvp_state) {
	global $wpdb;
	$feat_parks_query = $wpdb->get_results( $wpdb->prepare("SELECT wpid, name, address, city, state, status FROM rvty_parks WHERE state = '$rvp_state' AND status > 3") );
	foreach ($feat_parks_query as $feat_park) {
		$feat_wpid = $feat_park->wpid;
		$feat_wp_park_link = get_permalink( $feat_wpid );
		$feat_wp_park_link = str_replace('?rvparks=', 'rv-park/', $feat_wp_park_link );	
		$feat_name = $feat_park->name;
		$feat_address = $feat_park->address;	
		$feat_city = $feat_park->city;
		$feat_state = $feat_park->state;			
		$feat_status = $feat_park->status;
		$args = array(
			'status' => 'approve',
			'post_id' => $feat_wpid, // use post_id, not post_ID
		);
		$comments = get_comments($args);
		if ($comments != NULL) {	
			foreach($comments as $comment) {
				$ratings_array[] = get_comment_meta( $comment->comment_ID, 'rvp_vote', true );
			}
			$votes = count($ratings_array);
			$vote_sum = array_sum($ratings_array);
			$rating_num = round($vote_sum / $votes);
			$feat_star_rating = get_star_rating($rating_num, 'small');
		} else {
			$rating_num = 0;
			$feat_star_rating = get_star_rating($rating_num, 'small');
		}
		$feat_parks[] = '<div class="feat_parks"><a href="' . $feat_wp_park_link . '">' . get_the_post_thumbnail($feat_wpid, 'featured-thumb') . '<h2 class="h1">' . $feat_name . '</h2>' . $feat_address . '<br />' . $feat_city . ', ' . $feat_state . '<br />'. $feat_star_rating . '<br/></a></div><span class="shadow-left"></span><span class="shadow-right"></span>';
	}
return $feat_parks;
}
?>
<?php //Comments
// This is the new comment markup - edit as you feel necessary
function html5_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $wpid;
	global $name;
	$meta_values = get_comment_meta( $comment->comment_ID, 'rvp_vote', true );
	$star_rating = get_star_rating($meta_values, 'small');
	if ($meta_values == 1) {$vote = '&#9733;&#10032;&#10032;&#10032;&#10032;';}
	if ($meta_values == 2) {$vote = '&#9733;&#9733;&#10032;&#10032;&#10032;';}
	if ($meta_values == 3) {$vote = '&#9733;&#9733;&#9733;&#10032;&#10032;';}
	if ($meta_values == 4) {$vote = '&#9733;&#9733;&#9733;&#9733;&#10032;';}
	if ($meta_values == 5) {$vote = '&#9733;&#9733;&#9733;&#9733;&#9733;';}

	$args = array(
		'numberposts' => 1,
		'order'=> 'ASC',
		'orderby'=> 'menu_order',
		'post_mime_type' => 'image',
		'post_parent' => $wpid,
		'post_status' => null,
		'post_type' => 'attachment'
	);	
	$attachments = get_children( $args );
	if ($attachments) {
		foreach($attachments as $attachment) {
			$fb_photo = wp_get_attachment_url( $attachment->ID, 'gallery-thumb' );
		}
	} else { 
		$fb_photo = get_bloginfo("template_directory") . '/graphics/logo_trans_100.png';
	}
	$feed_text = get_comment_text();
	$comment_author = get_comment(get_comment_ID())->user_id;
	$current_user = get_current_user_id();
	?>
	<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>"itemprop="review" itemscope itemtype="http://schema.org/Review">
		<div class="comment_wrap">
			<header class="comment-author vcard">
				<div class="comment_col1">
					<?php 
					if ($comment->comment_parent == 0) {
					echo get_avatar($comment,$size='60',$default='', $alt='Facebook Avatar' ); 
					}
					?>
					<span itemprop="author">
					<?php if ($comment->comment_parent != 0) {
					echo '<h2>' . $name . ' Response: </h2>';
					} else {
					printf( get_comment_author_link()); 
					echo '</span>';
					edit_comment_link(__('(Edit)'),' ','');
					}
					?><br />
							<?php comment_date(); ?><br />
						<div class="comment-meta commentmetadata"></div>
					<div class="comment_star" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
					<?php 
					if ($comment->comment_parent == 0) {
					echo $star_rating; 
					echo '<meta itemprop="ratingValue" content="' . $meta_values . '">';
					}
					?>
					</div> 
				</div>
			<?php 
			if ($comment->comment_parent == 0) {
			echo '<div class="comment_col2">';
				if ($comment_author == $current_user) {
					//link to post facebook feed.
					$wp_park_link = get_permalink( $wpid );
					$wp_park_link = str_replace('?rvparks=', 'rv-park/', $wp_park_link ); 
					echo '<a href="https://www.facebook.com/dialog/feed?
					app_id=107256345975330&
					link=' . $wp_park_link . '&
					picture=' . $fb_photo . '&
					name=' . $name . '&
					caption=' . $vote . '&
					description=' . $feed_text . '&
					redirect_uri=' . $wp_park_link . '" class="comment_fb">Post your review to Facebook</a>'; 
				}
			echo '</div>';	
			}	
			?>
			</header>
			<?php
			echo '<div class="comment_text_wrap" itemprop="description">';
			if ($comment->comment_approved == '0') { ?>
			<em><?php _e('Your comment is awaiting moderation.') ?></em>
			<?php 
			} else {
				echo get_comment_text();
			}
			echo '</div>';
			?>
		</div>
		<div class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?> </div>
<?php } //end of html5 function ?>
<?php
if ( ! is_admin() ) {
		add_action( 'comment_post', 'save_comment_meta_data' );
		function save_comment_meta_data( $comment_id ) {
			add_comment_meta( $comment_id, 'rvp_vote', $_POST[ 'vote' ] );
		}
		add_filter( 'preprocess_comment', 'verify_comment_meta_data' );
		function verify_comment_meta_data( $commentdata ) {
			if ( ! isset( $_POST['vote'] ) )
				wp_die( __( 'Error: please fill the required field (vote).' ) );
			return $commentdata;
		} 
	}
		// Changes the trailing </li> into a trailing </article>
		function close_comment() { ?>
	</article>
<?php }	?>
<?php
/**
 * *
 Blog Functions
 **
 */
 
automatic_feed_links();
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h1 class="widgettitle">',
		'after_title' => '</h1>',
	));
}
?>
<?php //added functions
add_theme_support( 'post-thumbnails' );
add_image_size( 'rvthereyet', 180, 105, true ); 
//Partners & Friends
function br() {
register_sidebar_widget('Friends & Partners', 'my_text_widget5');
}
function my_text_widget5() { ?>
<?php
$display_admins = false;
$order_by = 'display_name'; // 'nicename', 'email', 'url', 'registered', 'display_name', or 'post_count'
$role = 'author'; // 'subscriber', 'contributor', 'editor', 'author' - leave blank for 'all'
//$avatar_size = 32;
$hide_empty = false; // hides authors with zero posts
if(!empty($display_admins)) {
	$blogusers = get_users('orderby='.$order_by.'&role='.$role);
} else {
	$admins = get_users('role=administrator');
	$exclude = array();
	foreach($admins as $ad) {
		$exclude[] = $ad->ID;
	}
	$exclude = implode(',', $exclude);
	$blogusers = get_users('exclude='.$exclude.'&orderby='.$order_by.'&role='.$role);
}
$authors = array();
foreach ($blogusers as $bloguser) {
	$user = get_userdata($bloguser->ID);
	if(!empty($hide_empty)) {
		$numposts = count_user_posts($user->ID);
		if($numposts < 1) continue;
	}
	$authors[] = (array) $user;
}
echo '<ul class="contributors">';
foreach($authors as $author) {
	$display_name = $author['data']->display_name;
	//$avatar = get_avatar($author['ID'], $avatar_size);
	$author_profile_url = get_author_posts_url($author['ID']);
	echo '<li><a href="', $author_profile_url, '" class="contributor-link">', $display_name, '</a></li>';
}
echo '</ul>';
?>
<?php
}
add_action('widgets_init', 'br');
?>
<?php
/**
 * Redirect non-admins to the homepage after logging into the site.
 *
 * @since 	1.0
 */
function soi_login_redirect( $redirect_to, $request, $user  ) {
	return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : site_url();
} // end soi_login_redirect
add_filter( 'login_redirect', 'soi_login_redirect', 10, 3 );
?>