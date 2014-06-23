<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main -->
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer_wrap">
	<?php tr_main_nav(); ?>
	<!--<div class="site-info">
			<?php do_action( 'tr_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'tabula-rasa' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'tabula-rasa' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'tabula-rasa' ), 'WordPress' ); ?></a>
		</div>--><!-- .site-info -->
		</div>


	</footer><!-- #colophon -->

</div><!-- #page -->
<?php wp_footer(); ?>
<?php if ( is_singular( 'rvparks' ) ) { 
	global $status; 
	if ( $status > 2 ) { ?>
		<script type='text/javascript'>/* <![CDATA[ */ var portfolioSlideshowOptions = { psFancyBox:true, psHash:false, psThumbSize:'75', psFluid:false, psTouchSwipe:true, psKeyboardNav:true, psBackgroundImages:false, psInfoTxt:'of' };/* ]]> */</script>
		<script type='text/javascript' src='<?php echo home_url(); ?>/wp-content/plugins/portfolio-slideshow-pro/js/scrollable.min.js'></script>
		<script type='text/javascript' src='<?php echo home_url(); ?>/wp-content/plugins/portfolio-slideshow-pro/js/portfolio-slideshow.min.js'></script>
		<script type='text/javascript' src='<?php echo home_url(); ?>/wp-content/plugins/portfolio-slideshow-pro/js/fancybox/jquery.fancybox-1.3.4.pack.js'></script>
		<script type='text/javascript' src='<?php echo home_url(); ?>/wp-content/plugins/portfolio-slideshow-pro/js/code.photoswipe.jquery-3.0.4.min.js'></script>
		<script type='text/javascript' src='<?php echo home_url(); ?>/wp-content/plugins/portfolio-slideshow-pro/js/jquery.cycle.all.min.js'></script>
		<!--<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/js/portfolio-gallery.js'></script>-->
		<!--

		-->
	<?php 
	} 
}
?>
</body>
</html>