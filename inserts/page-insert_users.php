<?php
/*
Template Name: Function: Insert RVTY Users
*/
get_header();
/*
Select rvty users databse
grarb data
insert into new databse, keep id
select rvty_postsmeat databse for email
if user email equals postmeta email, grab postid
insert inot post author field new author id
else display list of missing emails
*/

//$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
	$parks_query = $wpdb->get_results( "SELECT * FROM rvty_parks WHERE state = '$submited_state' ORDER BY name ASC" );
	$i=1;
	foreach ($parks_query as $park) {
	}
}
?>
<form method="post" action=""> <?php //echo esc_attr($_SERVER['REQUEST_URI']); ?>
<br /><br />
<!--<input type="text" name="submited_state" size="4" />&nbsp; -->
<input type="submit" name="submit" value="Insert the new Users" />
</form>
<br /><br />
<?php get_footer(); ?>