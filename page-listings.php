<?php
/**
Template Name: Listings
 */
get_header();
include("inc/init-listings.php");
?>				
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<div class="listing_nav">
				<?php echo $listing_nav; ?>
			</div>
			<?php 
			echo $tax_nav;
			?>		
			<script type="text/javascript">
			<!--
			var listingSlug = <?php echo '/' . $listing_slug . '/'; ?>;
			jQuery( document ).ready(function() {
				dropdownOnChange( listingSlug );
			});
			//--></script>	
			<?php 
			if ( $nothing_found == 'yes' ) { ?>
				<div class="nothing_found">
				<?php echo $nothing_found_heading; ?>
				</div>
			<?php }	?>
			<!-- LISTINGS -->
			<div class="list">
			<?php if ( $nothing_found != 'yes' ) { ?>
				<h2><?php echo $list_heading; ?></h2>	
				<ul>
					<?php echo $listing; ?>
				</ul>
			<?php } ?>
			</div>
			<!-- MAP -->
			<div class="listing_map">	
				<?php 
				if ( $nothing_found != 'yes' ) {
				echo $listing_map_heading; 
				?>		
				<section class="map_wrapper" >
					<div id="map">
						<?php include('inc/maps/map.php');  ?>
					</div>
				</section>
				<?php } ?>
			</div>
			<!-- BLOGS -->
			<?php 
			$feat_parks = feat_parks_query($state); 
			if ( !empty ($feat_parks ) ) { ?>
				<div class="listing_featured_parks">
					<h2>Featured <?php echo $state; ?> RV Park</h2>
					<?php //$num_parks = count( $feat_parks );
					echo $feat_parks;
					/*if ( $num_parks == 1 ) {
						echo $featured_park .= $feat_parks[0] . "\n"; 
					}	
					if ( $num_parks > 1 ) {
						shuffle($feat_parks); 
						$rand_keys = array_rand($feat_parks, $num_parks);
						echo $featured_park .= $feat_parks[$rand_keys[0]] . "\n";
					}*/	?>
					<span class="shadow-left"></span>
					<span class="shadow-right"></span>					
				</div>			
			<?php } ?>
			<div class="listing_blogs">	
				<h2><?php echo $listing_blogs_heading; ?></h2>
					<?php 
					if ( !empty ($feat_parks ) ) {
						if ( $nothing_found == 'yes' ) { 				
						} else {
							blog_list($state, 2, 70, 'listing-blog-thumb');
						}
					} elseif ( $nothing_found == 'yes' ) { 
						blog_list($state, 1, 180, 'listing-blog-thumb');
					} else {
						blog_list($state, 2, 180, 'listing-blog-thumb');
					}
					?>
			</div>
			<!-- REVIEWS -->
			<div class="listing_reviews">
				<h2>Recent Comments</h2>
				<?php echo get_recent_reviews ( $lc_state ); ?>
			</div>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>