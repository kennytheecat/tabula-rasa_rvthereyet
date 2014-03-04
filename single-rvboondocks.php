<?php
/**
 * @package WordPress
 * @subpackage Starkers HTML5
 */
get_header(); 
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<?php 
		if (have_posts()) : while (have_posts()) : the_post(); 
		require_once('inc/init-single.php');
		?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="listing_nav">
				<?php echo $listing_nav; ?>
			</div>		
			<!-- BASIC INFORMATION -->
			<section id="basicinfo" itemscope itemtype="http://schema.org/LocalBusiness">
				<?php echo $basic_info; ?>
			</section>
			<!-- ADDITIONAL INFORMATION -->
			<div class="additional_info">
				<?php echo $additional_info; ?>
			</div>
			<!-- FEATURED PARK -->
			<section id="rvpark_featured_parks">
				<?php echo $featured_park; ?>				
			</section>
			<div class="float_share <?php if ( is_admin_bar_showing() ) {echo 'float_share_admin'; } ?>">
				<?php if ( function_exists( 'floating_social_bar' ) ) floating_social_bar( array( 'facebook' => true, 'google' => true, 'twitter' => true, 'pinterest' => true ) ); ?>
			</div>
			<!-- PHOTO GALLERY OR AD -->
			<div id="photo_gallery_or_ad">
				<?php echo $photo_gallery_or_ad; ?>
			</div>
			<!-- MAP -->
			<div class="map_wrapper">
				<?php
				echo $google_map; 
				include('inc/maps/map.php');
				echo '</div>';
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
			
			<!-- REVIEWS -->
			<div id="review_box">	
				<h2>Reviews for <?php echo $name; ?></h2>
				<?php comments_template(); ?>
			</div>		
			<!-- RV BLOGS -->
			<div id="rvblogs">	
				<h2><?php echo $state; ?> RV Blogs</h2>
				<?php //blog_list('', 5, 200, 'blog-thumb');
				blog_list($state, 5, 200, 'rvparks-blog-thumb');?>
			</div>
		</article>
	<?php endwhile; else: ?>
	<p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->				
<?php get_footer(); ?>