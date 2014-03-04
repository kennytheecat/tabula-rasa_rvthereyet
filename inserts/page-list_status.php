<?php
/*
Template Name: Function: List Status Level 1s
*/
get_header();

//$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
	$status_query = $wpdb->get_results( "SELECT * FROM rvty_term_relationships WHERE term_taxonomy_id = 2081" );
	$i=1;
	foreach ($status_query as $status) {
		$post_id = $status->object_id;
		$parks_query = $wpdb->get_results( "SELECT * FROM rvty_posts WHERE ID = $post_id" );
		
		foreach ($parks_query as $park) {
			$post_id = $park->ID;
			$post_title = $park->post_title;
			echo $post_id . '|' . $post_title . '<br />';
		}
	}
} else {
	echo 'balls!';
}
?>
<form method="post" action=""> <?php //echo esc_attr($_SERVER['REQUEST_URI']); ?>
<br /><br />
<input type="submit" name="submit" value="Insert the new Posts" />
</form>
<br /><br />
<?php get_footer(); ?>