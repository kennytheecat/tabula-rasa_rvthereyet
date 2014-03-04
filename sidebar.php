<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area aside1" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
			<?php dynamic_sidebar( 'sidebar-1' ); ?>			
			<!-- i.e. 
			<aside id="archives" class="widget">
				<h1 class="widget-title"><?php _e( 'Archives', 'tabula_rasa' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>
			-->
		</div><!-- #secondary -->
	<?php endif; ?>
	<div class="widget-area aside2" role="complementary">
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div class="first front-widgets">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- .first -->
	<?php endif; ?>	
	</div>		