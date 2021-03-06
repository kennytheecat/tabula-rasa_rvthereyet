<?php // WP 404 ALERTS @ http://wp-mix.com/wordpress-404-email-alerts/
 
// set status
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
 
// site info
$blog  = get_bloginfo('name');
$site  = get_bloginfo('url') . '/';
$email = get_bloginfo('admin_email');
 
// theme info
if (!empty($_COOKIE["nkthemeswitch" . COOKIEHASH])) {
     $theme = clean($_COOKIE["nkthemeswitch" . COOKIEHASH]);
} else {
     $theme_data = wp_get_theme();
     $theme = clean($theme_data->Name);
}
 
// referrer
if (isset($_SERVER['HTTP_REFERER'])) {
     $referer = clean($_SERVER['HTTP_REFERER']);
} else {
     $referer = "undefined";
}
// request URI
if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER["HTTP_HOST"])) {
     $request = clean('http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
} else {
     $request = "undefined";
}
// query string
if (isset($_SERVER['QUERY_STRING'])) {
     $string = clean($_SERVER['QUERY_STRING']);
} else {
     $string = "undefined";
}
// IP address
if (isset($_SERVER['REMOTE_ADDR'])) {
     $address = clean($_SERVER['REMOTE_ADDR']);
} else {
     $address = "undefined";
}
// user agent
if (isset($_SERVER['HTTP_USER_AGENT'])) {
     $agent = clean($_SERVER['HTTP_USER_AGENT']);
} else {
     $agent = "undefined";
}
// identity
if (isset($_SERVER['REMOTE_IDENT'])) {
     $remote = clean($_SERVER['REMOTE_IDENT']);
} else {
     $remote = "undefined";
}
// log time
$time = clean(date("F jS Y, h:ia", time()));
 
// sanitize
function clean($string) {
     $string = rtrim($string); 
     $string = ltrim($string); 
     $string = htmlentities($string, ENT_QUOTES); 
     $string = str_replace("\n", "<br>", $string);
 
     if (get_magic_quotes_gpc()) {
          $string = stripslashes($string);
     } 
     return $string;
}
 
$message = 
     "TIME: "            . $time    . "\n" . 
     "*404: "            . $request . "\n" . 
     "SITE: "            . $site    . "\n" . 
     "THEME: "           . $theme   . "\n" . 
     "REFERRER: "        . $referer . "\n" . 
     "QUERY STRING: "    . $string  . "\n" . 
     "REMOTE ADDRESS: "  . $address . "\n" . 
     "REMOTE IDENTITY: " . $remote  . "\n" . 
     "USER AGENT: "      . $agent   . "\n\n\n";
 
//mail($email, "404 Alert: " . $blog . " [" . $theme . "]", $message, "From: $email"); 
 
?>
<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header(); 
include("inc/init-starter.php");	
if ( $starter_tax_nav == '' ) { 
	$error_name = 'RV Blog';
}
?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Sorry, the ' . $error_name . ' you are looking for is no longer here. Other ' . $error_name  . 's can be found below.', 'tabula-rasa' ); ?></h1>
				</header>
	<div id="primary" class="content-area<?php if ( $starter_tax_nav == '' ) { echo ' blog404'; }  ?>">
		<div id="content" class="site-content" role="main">
			<!--<article id="post-0" class="post error404 no-results not-found"> -->

				<?php 
				if ( $starter_tax_nav != '' ) { 
					get_template_part( 'content', 'starter' ); 
				} else {
$args = array(
	'post_type' => 'post'
);
$the_query = new WP_Query( $args );				
					if ( $the_query->have_posts() ) : 
						while ( $the_query->have_posts() ) : $the_query->the_post();			
							get_template_part( 'content', 'blog' );
						endwhile; 
							tr_content_nav( 'nav-below' );
						else : 
							get_template_part( 'content', 'none' );
					endif;				
				}
				?>
			<!-- </article> --><!-- #post-0 -->
		</div><!-- #content -->
	</div><!-- #primary -->		
	<?php
	if ( $starter_tax_nav == '' ) { 
		get_sidebar(); 
	}
 get_footer(); 
 ?>