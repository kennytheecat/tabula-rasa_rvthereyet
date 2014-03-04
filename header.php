<!doctype html>
<?php 
require_once('inc/init-header.php');
?>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />

		<!-- Google Chrome Frame for IE -->
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title><?php echo $title_info; //wp_title( '|', true, 'right' ); ?></title>
		<meta name="description" content="<?php echo $meta_content; ?>">

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> -->

		<!-- icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<!-- or, set /favicon.ico for IE10 win -->

		
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<?php echo $can_link; ?>
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
		<?php if ( is_singular( 'rvparks' ) || is_singular( 'rvdumps' ) || is_singular( 'rvboons' ) || is_page('listings') )  { ?>
			<script src = "//maps.googleapis.com/maps/api/js?&sensor=false"></script>	
		<?php } ?>
		
		<?php if ( is_singular( 'rvparks' ) ) { 
		$status = wp_get_object_terms( $post->ID, 'status_levels' );
		$status = $status[0]->slug;
	if ( $status > 2 ) { ?>
			<!-- Portfolio Slideshow-->
			<link rel="stylesheet" type="text/css" href="http://rvthereyetdirectory.com/wp-content/plugins/portfolio-slideshow-pro/css/portfolio-slideshow.min.css">
			<noscript><link rel="stylesheet" type="text/css" href="http://rvthereyetdirectory.com/wp-content/plugins/portfolio-slideshow-pro/css/portfolio-slideshow-noscript.css?ver=1.8.7" /></noscript><style type="text/css">.centered .ps-next {} .scrollable {height:50px;} .ps-prev {top:30px} .ps-next {top:-35px} .slideshow-wrapper .pscarousel img {margin-right:8px !important; margin-bottom:8px !important;}</style><script type="text/javascript">/* <![CDATA[ */var psTimeout = new Array(); psAudio = new Array(); var psAutoplay = new Array(); var psDelay = new Array(); var psFluid = new Array(); var psTrans = new Array(); var psRandom = new Array(); var psCarouselSize = new Array(); var touchWipe = new Array(); var psPagerStyle = new Array(); psCarousel = new Array(); var psSpeed = new Array(); var psLoop = new Array(); var psClickOpens = new Array(); /* ]]> */</script>
			<!--//Portfolio Slideshow-->
	<?php 
	} 
}
?>
		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- drop Google Analytics Here -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40278930-1', 'rvthereyetdirectory.com');
  ga('send', 'pageview');

</script>		
		<!-- end analytics -->

	</head>

<body <?php body_class(); ?>">
<?php //echo facebook_creds();  ?>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="inner-header">
			<div class="site-branding">
				<!--<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1> -->
				<div itemscope itemtype="http://schema.org/Organization" class="logo">
					<a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<div>
					
					<!--<img itemprop="logo" src="<?php echo bloginfo('template_url'); ?>/images/logo.png" alt="" />-->
					
						</div>
					</a>
				</div>
				<!--<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2> -->
				<div id="big_banner">
					<p class="header-login">
						<?php 
						if( is_user_logged_in() ) {
						global $current_user;
						get_currentuserinfo();
						?>
						Welcome, <a href="<?php echo get_edit_user_link(); ?>"><?php echo $current_user->display_name; ?></a>
						<?php } else { ?> 
						<a href="<?php echo bloginfo( 'url' ); ?>/wp-login.php/">Login</a>
						<?php } ?>
					</p>
					<?php tr_social_nav(); ?>
					<?php //echo big_banner(); ?>
				</div>
			</div>

			<nav id="site-navigation" class="main-navigation" role="navigation">
			<h1 class="logo"><div><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"></a></div></h1>
			<h3 class="menu-toggle"><?php _e( 'Menu', 'tabula_rasa' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'tabula_rasa' ); ?>"><?php _e( 'Skip to content', 'tabula_rasa' ); ?></a>
				<?php tr_main_nav(); ?>
			</nav><!-- #site-navigation -->

			<?php $header_image = get_header_image();
			if ( ! empty( $header_image ) ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
			<?php endif; ?>
		</div>
		</header><!-- #masthead -->

	<div id="main" class="site-main">