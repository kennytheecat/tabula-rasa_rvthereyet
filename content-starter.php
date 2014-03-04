<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<?php 
global $starter_tax_nav; 
global $listing_slug; 
global $starter_blogs_heading; 
echo $starter_tax_nav; 
?>		
<script type="text/javascript">
<!--


var listingSlug = <?php echo '/' . $listing_slug . '/'; ?>;

jQuery( document ).ready(function() {
        dropdownOnChange( listingSlug );
    });

//--></script>			
<!-- MAP -->
<section class="starter_map">
	<div></div>
	<!--<img src="<?php bloginfo('template_directory'); ?>/images/us_map_green_trans.png" alt="United States Map" usemap="#usamap">-->
</section>
<!-- CALL TO ACTION -->
<section class="calltoaction">
	<div></div>
	<!--<img src="<?php bloginfo('template_directory'); ?>/images/calltoaction.png" />-->
</section>				
<!-- BLOGS -->
<section class="starter_blogs">
	<h2><?php echo $starter_blogs_heading; ?></h2>
		<?php blog_list('', 5, 200, 'blog-thumb');?>
</section>
<!-- REVIEWS -->
<section class="starter_reviews">
	<h2>Recent RV Park Reviews</h2>
	<?php
	$args = array(
		'status' => 'approve',
		'number' => '5',
		'parent' => 0,
		'meta_key' => 'rvp_vote',
		'meta_value' => array (3,4,5),
	);
	echo get_recent_reviews ( $args, 'yes' );
	?>
</section>