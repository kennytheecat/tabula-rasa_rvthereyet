<?php
get_header(); 
?>
<?php 
$state = single_cat_title( '', false );
?>
<?php 
$args = array(
	'posts_per_page'  => 50,
	'orderby'         => 'meta_value',
	'order'           => 'ASC',
	'meta_key'        => 'dump_city',
	'post_type'       => 'rvdumps',
	'rv-dumps'        => $state,
	'post_status'     => 'publish'
); 

$cat_posts = get_posts( $args );
foreach( $cat_posts as $post ) : ?>
	<?php 

	$custom_fields = get_post_custom( $post->ID );
	
	$address = $custom_fields['dump_address'][0];
	$city = $custom_fields['dump_city'][0];
	$zip = $custom_fields['dump_zip'][0];
	$lat = $custom_fields['dump_lat'][0];
	$lon = $custom_fields['dump_lon'][0];
	
	$marker_html = 'Name<br />' . 
	$address . '<br />' . 
	$city . ', ' . $state . '<br />';			
	
	$markers[] = "var point = new google.maps.LatLng($lat,$lon); var marker = createMarker(point,'$marker_html')"; 
	// End Markers
	// Start forming list
	if ($city != $previousLevel) {
		if ($previousLevel != "") {
			$list .= '</ul></section>';
		}
		$h1_a_listing = '<a href="' .home_url() . '/rv-parks/' . $state . '/' . $city . '/">' . $city . '</a>';			
		$list .= '||<section><h2>' . $h1_a_listing . '</h2><ul>';
		$previousLevel = $city;
	}
	$h2_a_listing = '<a href="#">' . get_the_title() . '</a>';  
	$list .= '<li>' . $h2_a_listing . '</li>';	
	// End listing formation
	?>
<?php endforeach; ?>
	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<div id="rv2p_row1_col1">
				<div class="dropdown_section">
					<?php 
					$args = array(
						'taxonomy'  => 'rv-dumps',
						'show_option_none' => 'RV Dumps in...',
						'order' => 'ASC',
						'orderby' => 'NAME'
					); 
					wp_dropdown_categories( $args ); ?> 
					<script type="text/javascript"><!--
						var dropdown = document.getElementById("cat");
						function onCatChange() {
							if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
								location.href = "<?php echo get_option('home') . '/rv-dumps';?>/"+dropdown.options[dropdown.selectedIndex].text;
							}
						}
						dropdown.onchange = onCatChange;
				--></script>
				</div>
			</div>
			<div id="rv2p_row1_col2">
				<section id="page_info">
					<h2>RV Dumps in <?php echo $state; ?></h2>
				<?php echo $page_info; ?>
				</section>
			</div>
			<div id="rv2p_row2_col1">
				<section id="ad_area_aside">
					<h2>ADS GO HERE</h2>
					<?php //echo $ad_area_aside; ?>
				</section>
			</div>	
			<?php
			/* Start the Loop */
			$previousLevel = '';
			?>	
			<div id="rv2p_row2_col2">	
			<?php //if ($no_results == false) { ?>
				<section id="archive_rvpark_gmap_wrapper" >
					<div id="map">
					<?php include('inc/maps/map_page-rv2pages.php');  ?>
					</div>
				</section> <!-- #map_wrapper -->
			<?php //} ?>
			</div> <!-- end id="rv2p_row1_col2" -->			
			<section class="list">
				<?php 
				//echo $list;
				$listing_columns_exploded = explode("||", $list);
				echo $listing_links = deats($listing_columns_exploded, 4); ?>
			</section> 
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_footer(); ?>