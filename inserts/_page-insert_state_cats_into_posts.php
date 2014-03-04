<?php
/*
Template Name: Function: Insert State Cats Into Posts
*/
include_once("header.php");
?>

<?php
$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
	$parks_query = $wpdb->get_results( $wpdb->prepare("SELECT wpid FROM rvty_parks WHERE state LIKE '$submited_state%%' ORDER BY name ASC") );
	foreach ($parks_query as $parks) {
		$wpid = $parks->wpid;
		
		// use StateNames array to get long version of state name
		$state = $StateNames[$submited_state];
		
		$termid_query = $wpdb->get_results( $wpdb->prepare("SELECT term_id FROM rvty_terms WHERE name = '$state' LIMIT 1") );
		foreach ($termid_query as $termid) {
			$termid_val = $termid->term_id;
			
			$termtax_query = $wpdb->get_results( $wpdb->prepare("SELECT term_taxonomy_id FROM rvty_term_taxonomy WHERE term_id = '$termid_val' LIMIT 1") );
			foreach ($termtax_query as $termtax) {
				$termtax_val = $termtax->term_taxonomy_id;
			}
		}
		$wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->term_relationships ( object_id, term_taxonomy_id, term_order ) VALUES ( %d, %d, %d )", $wpid, $termtax_val, 0 ) );
		
		echo "{$wpid} - {$state} and {$termid_val} and {$termtax_val} updated<br />";
	}
} else {
	echo 'balls!';
}

?>
<form method="post" action=""> <?php //echo esc_attr($_SERVER['REQUEST_URI']); ?>
<br /><br />
<input type="text" name="submited_state" size="4" />&nbsp; 
<input type="submit" name="submit" value="Insert the new Posts" />
</form>
<br /><br />
<?php get_footer(); ?>