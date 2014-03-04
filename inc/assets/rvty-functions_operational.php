<?php
global $wpdb;
$parks_query = $wpdb->get_results( $wpdb->prepare("SELECT userid, name FROM rvty_parks WHERE state = 'CT' ORDER BY city ASC") );
foreach ($parks_query as $parks) {
$userid = $parks_query->userid;
$name = $parks_query->name;
echo $userid;
}
?>