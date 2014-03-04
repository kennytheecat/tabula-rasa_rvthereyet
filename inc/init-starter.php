<?php
global $wp;
$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
global $current_url;
if (strpos($current_url,'rv-parks') !== false || strpos($current_url,'rv-park') !== false || is_front_page() ) {
	$starter_tax_nav_mobile = '<div class="starter_tax_nav_mobile">' . dropdown ( 'states', 'states', 'Find RV Parks in the United States', ' size=10' ) . '</div>';
	$starter_tax_nav = '<div class="starter_tax_nav">' . dropdown ( 'states', 'states', 'Find RV Parks in the United States' ) . '</div>';
	$listing_slug = 'rv-parks';
	$starter_blogs_heading = 'Recent RV Blogs';	
	$error_name = 'RV Park';
}
if (strpos($current_url,'rv-dumps') !== false || strpos($current_url,'rv-dump') !== false ) {
	$starter_tax_nav_mobile = '<div class="starter_tax_nav_mobile">' . dropdown ( 'states', 'states', 'Find RV Dumps in the United States', ' size=10' ) . '</div>';
	$starter_tax_nav = '<div class="starter_tax_nav">' . dropdown ( 'states', 'states', 'Find RV Dumps in the United States' ) . '</div>';
	$listing_slug = 'rv-dumps';
	$starter_blogs_heading = 'Recent RV Blogs';
	$error_name = 'RV Dump';	
}
if (strpos($current_url,'rv-snowbirds') !== false ) {
	$starter_tax_nav_mobile = '<div class="starter_tax_nav_mobile">' . dropdown ( 'states', 'states', 'Find Snowbird RV Parks in the United States', ' size=10' ) . '</div>';
	$starter_tax_nav = '<div class="starter_tax_nav">' . dropdown ( 'states', 'states', 'Find Snowbird RV Parks in the United States' ) . '</div>';
	$listing_slug = 'rv-snowbirds';
	$starter_blogs_heading = 'Recent RV Blogs';		
}
if (strpos($current_url,'rv-clubs') !== false) {
	$starter_tax_nav_mobile = '<div class="starter_tax_nav_mobile">' . dropdown ( 'states', 'states', 'Find RV Clubs in the United States', ' size=5' ) . dropdown ( 'clubs', 'tax', 'Select a RV Club...', ' size=5' ) . '</div>';
	$starter_tax_nav = '<div class="starter_tax_nav">' . dropdown ( 'states', 'states', 'Find RV Clubs in the United States' ) . dropdown ( 'clubs', 'tax', 'Select a RV Club...' ) . '</div>';
	$listing_slug = 'rv-clubs';
	$starter_blogs_heading = 'Recent RV Blogs';	
}
if (strpos($current_url,'rv-boondocks') !== false || strpos($current_url,'rv-boondock') !== false ) {
	$starter_tax_nav_mobile = '<div class="starter_tax_nav_mobile">' . dropdown ( 'states', 'states', 'Find RV Boondocks in the United States', ' size=5' ) . dropdown ( 'boons', 'tax', 'Select a RV Boondocking Type...', ' size=5' ) . '</div>';
	$starter_tax_nav = '<div class="starter_tax_nav">' . dropdown ( 'states', 'states', 'Find RV Boondocks in the United States' ) . dropdown ( 'boons', 'tax', 'Select a RV Boondocking Type...' ) . '</div>';
	$listing_slug = 'rv-boondocks';
	$starter_blogs_heading = 'Recent RV Blogs';	
	$error_name = 'RV Boondock';
}
?>