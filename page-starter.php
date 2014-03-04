<?php
/**
Template Name: Starter
 */
get_header(); 
include("inc/init-starter.php");
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php get_template_part( 'content', 'starter' ); ?>
		</div><!-- #content -->
	</div><!-- #primary -->			
<?php get_footer(); ?>