<?php
/**
 * @package WordPress
 * @subpackage Starkers HTML5
 */
get_header(); 
require_once('inc/init-single.php');
?>	
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<?php 
		if (have_posts()) : while (have_posts()) : the_post(); 

		?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">	
			<div class="listing_nav">
				<?php echo $listing_nav; ?>
			</div>			
			<!-- BASIC INFORMATION -->
			<section id="basicinfo" itemscope itemtype="http://schema.org/LocalBusiness">
				<?php echo $basic_info; ?>
			</section>
			<!-- RATINGS INFORMATION -->
			<div class="ratings_section">
				<?php echo $ratings_section; ?>
			</div>
			<!-- FEATURED PARK -->
			<section id="rvpark_featured_parks">
				<?php echo $featured_park; ?>				
			</section>
			<div class="float_share <?php if ( is_admin_bar_showing() ) {echo 'float_share_admin'; } ?>">
				<?php if ( function_exists( 'floating_social_bar' ) ) floating_social_bar( array( 'facebook' => true, 'google' => true, 'twitter' => true, 'pinterest' => true ) ); ?>
			</div>
			<!-- PHOTO GALLERY OR AD -->
			<div class="mobile_ad">
				<?php echo $mobile_ad; ?>
			</div>
			<div id="photo_gallery_or_ad">
				<?php echo $photo_gallery_or_ad; ?>
			</div>
			<!-- MAP -->
			<div class="map_wrapper">
				<?php
				echo $google_map; 
				include('inc/maps/map.php');
				?>
			</div>
			
			<!-- ADVERT SECTION -->
			<div id="rvty_advert">
				<?php echo $advert; ?>
			</div>
			
			<!-- DESCRIPTION OR NEARBY PARKS -->
			<div class="description_or_nearby">
				<?php echo $description_or_nearby; ?>
			</div>
			<!-- DETAILS LIST -->
			<div id="details_wrap" class="top_background">
			
				<!-- Park Details -->
				<div class="park_details">
					<?php 
					echo $park_details_header;
					if ( $park_details_proceed != 'go' ) { echo $park_no_details; } ?>
					<div class="dates">
						<?php if ( $dates != 'stop' ) { echo $dates_list; }?>
					</div>
					<div class="features">
						<?php if ( $features != 'stop' ) { echo $features_list; }?>
					</div>
					<div class="activities">
						<?php if ( $activities != 'stop' ) { echo $activities_list; } ?>
					</div>
					<div class="atmospheres">
						<?php if ( $atmospheres != 'stop' ) { echo $atmospheres_list; } ?>
					</div>
				</div>
				
				<!-- Site Details -->
				<div class="site_details">
					<?php 
					echo $site_details_header;
					if ( $site_details_proceed != 'go') { echo $site_no_details; } ?>
					<div class="site_num">
						<?php if ( $site_num != '') { echo $site_num_list; }?>
					</div>
					<div class="hookups">
						<?php if ( $hookups != 'stop' ) { echo $site_hookups_list; }?>
					</div>
					<div class="accommodations">
						<?php if ( $accommodations != 'stop' ) { echo $site_accommodations_list; }?>
					</div>
					<div class="other_camping">
						<?php if ( $other_camping != 'stop' ) {  echo $site_other_camping_list; }?>
					</div>
				</div>
				
				<!-- Rate Information -->
				<div class="rate_details">
					<?php 
					echo $rates_details;
					if ( $rate_details_proceed != 'go') { echo $rates_no_details;  } ?>
					<div class="rates">
						<?php if ( $rates_info != '') { echo $rates_info; } ?>
					</div>
					<div class="rates_charges">
						<?php if ( $rates_charges != 'stop' ) { echo $rates_charges_list; } ?>
					</div>					
					<div class="payments">
						<?php if ( $payments != 'stop' ) { echo $payments_list; } ?>
					</div>
					<div class="discounts">
						<?php if ( $discounts != 'stop' ) { echo $discounts_list; } ?>
					</div>
				</div>
				
				<!-- Club Details -->
				<div class="club_details">
					<?php 
					echo $club_details_header;
					if ( $club_details_proceed != 'go' ) { echo $club_no_details; }  ?>
					<?php if ( $clubs != 'stop' ) { echo $clubs_list; }?>
				</div>
			</div> <!-- end .details_wrap -->		
			
			<!-- REVIEWS -->
			<div id="review_box">	
				<h2>Reviews for <?php echo $name; ?></h2>
				<?php comments_template( '/comments-rvparks.php' ); ?>
			</div>		
			<!-- RV BLOGS -->
			<div id="rvblogs">	
				<h2><?php echo $state; ?> RV Blogs</h2>
				<?php blog_list($state, 5, 200, 'rvparks-blog-thumb'); ?>
			</div>
		</article>
		<?php endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->				
<?php get_footer(); ?>