<?php
/*
Template Name: Function: Insert Dumps
*/
get_header();

$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
	$dumps_query = $wpdb->get_results( "SELECT * FROM rvty_rvdumps WHERE state = '$submited_state' ORDER BY name ASC" );
	$i=1;
	$starting_ids = array();
	foreach ($dumps_query as $dump) {
		$name_lc = strtolower($dump->name);
		$name = ucwords( $name_lc );
		$name = str_replace( 'Rv', 'RV', $name );
		$name_lc = str_replace( ' ', '-', $name_lc );
		$address = ucwords(strtolower($dump->address));
		$city_lc = strtolower( $dump->city );
		$city = ucwords( $city_lc );
		$city_lc = str_replace( ' ', '-', $city_lc );
		// use StateNames array to get long version of state name
		$state = $dump->state;
		$state = $StateNames[$submited_state];
		$state = term_exists($state, 'states');
		$zip = $dump->zip;
		$lat = $dump->lat;
		if ( $lat == 0 ) { continue; }
		$lng = $dump->lon;
		if ( $lng == 0 ) { continue; }
		
		$coords = array( 'dump_lat' => $lat, 'dump_lng' => $lng );
		$openseason = $dump->openseason;
		$opentime = $dump->opentime;
		$dumpfee = $dump->dumpfee;
		$regcost = $dump->regcost;
		$water = $dump->water;
		
		
		
		
		$new_dates = array();
		$new_water = array();
		
		//Set up for open dates
		if ( !empty( $openseason ) ) {
			if ( $openseason == 'APR TO NOV' ) { 
				$new_dates['open_month'] = 4;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 11;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'APR TO OCT' ) { 
				$new_dates['open_month'] = 4;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 10;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'All Year' ) { 
				$new_dates['open_month'] = 1;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 12;
				$new_dates['close_day'] = 31;
			}
			if ( $openseason == 'April to November' ) { 
				$new_dates['open_month'] = 4;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 11;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'April to October' ) { 
				$new_dates['open_month'] = 4;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 10;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'April to September' ) { 
				$new_dates['open_month'] = 4;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 9;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'June to August' ) { 
				$new_dates['open_month'] = 6;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 8;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'June to September' ) { 
				$new_dates['open_month'] = 6;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 9;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'MAR TO NOV' ) { 
				$new_dates['open_month'] = 3;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 11;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'MAR TO OCT' ) { 
				$new_dates['open_month'] = 3;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 10;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'MAY TO OCT' ) { 
				$new_dates['open_month'] = 5;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 10;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'MAY TO SEP' ) { 
				$new_dates['open_month'] = 5;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 9;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'March to December' ) { 
				$new_dates['open_month'] = 3;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 12;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'March to November' ) { 
				$new_dates['open_month'] = 3;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 11;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'March to October' ) { 
				$new_dates['open_month'] = 3;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 10;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'March to September' ) { 
				$new_dates['open_month'] = 3;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 9;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'May to November' ) { 
				$new_dates['open_month'] = 5;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 11;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'May to October' ) { 
				$new_dates['open_month'] = 5;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 10;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'May to September' ) { 
				$new_dates['open_month'] = 5;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 9;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'SPRING TO NOV' ) { 
				$new_dates['open_month'] = 3;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 11;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'September to November' ) { 
				$new_dates['open_month'] = 9;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 11;
				$new_dates['close_day'] = 1;
			}
			if ( $openseason == 'YEAR ROUND' ) { 
				$new_dates['open_month'] = 1;
				$new_dates['open_day'] = 1;
				$new_dates['close_month'] = 12;
				$new_dates['close_day'] = 31;
			}
		}
		
		//Set up for open times
		$dump_days_open = '';
		$dump_hours_open = '';
		$dump_hours_close = '';
		if ( !empty( $opentime ) ) {
			if ( $opentime == '24 HOURS' ) {
				$dump_hours_open = '12:00 AM';
				$dump_hours_close = '12:00 AM';
			}
			if ( $opentime == '6:00AM - 10:00PM' ) {
				$dump_hours_open = '6:00 AM';
				$dump_hours_close = '10:00 PM';
			}
			if ( $opentime == '6:00AM TO 6:00PM' ) {
				$dump_hours_open = '6:00 AM';
				$dump_hours_close = '6:00 PM';
			}
			if ( $opentime == '6:30AM TO 10:00PM' ) {
				$dump_hours_open = '6:30 AM';
				$dump_hours_close = '10:00 PM';
			}
			if ( $opentime == '7:00AM - 10:00PM' ) {
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '10:00 PM';
			}
			if ( $opentime == '7:00AM - 4:30PM' ) {
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '4:30 PM';
			}
			if ( $opentime == '7:00AM - 5:00PM' ) {
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '5:00 PM';
			}
			if ( $opentime == '7:00AM - 9:00PM' ) {
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '9:00 PM';
			}
			if ( $opentime == '7:00AM TO 5:00PM' ) {
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '5:00 PM';
			}
			if ( $opentime == '7:00AM TO 6:00PM' ) {
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '6:00 PM';
			}
			if ( $opentime == '7:00AM TO 7:00PM' ) {
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '7:00 PM';
			}
			if ( $opentime == '7:00AM TO 8:00PM' ) {
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '8:00 PM';
			}
			if ( $opentime == '7:30AM - 3:00PM' ) {
				$dump_hours_open = '7:30 AM';
				$dump_hours_close = '3:00 PM';
			}
			if ( $opentime == '7:30AM - 3:30PM' ) {
				$dump_hours_open = '7:30 AM';
				$dump_hours_close = '3:30 PM';
			}
			if ( $opentime == '7:30AM - 4:30PM' ) {
				$dump_hours_open = '7:30 AM';
				$dump_hours_close = '4:30 PM';
			}
			if ( $opentime == '8:00AM TO 4:30PM' ) {
				$dump_hours_open = '8:00 AM';
				$dump_hours_close = '4:30 PM';
			}
			if ( $opentime == '8:30AM - 4:30PM' ) {
				$dump_hours_open = '8:30 AM';
				$dump_hours_close = '4:30 PM';
			}
			if ( $opentime == '9:00AM - 10:00PM' ) { 
				$dump_hours_open = '9:00 AM';
				$dump_hours_close = '10:00 PM';
			}
			if ( $opentime == '9:00AM - 5:00PM' ) { 
				$dump_hours_open = '9:00 AM';
				$dump_hours_close = '5:00 PM';
			}
			if ( $opentime == 'MONDAY TO FRIDAY' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
			}
			if ( $opentime == 'MONDAY TO FRIDAY / 7:00AM TO 3:00PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '3:00 PM';
			}
			if ( $opentime == 'MONDAY TO FRIDAY / 7:00AM TO 3:30PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '3:30 PM';
			}
			if ( $opentime == 'MONDAY TO FRIDAY / 7:00AM TO 4:00PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_hours_open = '7:00 AM';
				$dump_hours_close = '4:00 PM';
			}
			if ( $opentime == 'MONDAY TO FRIDAY / 7:30AM TO 3:00PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_hours_open = '7:30 AM';
				$dump_hours_close = '3:00 PM';
			}
			if ( $opentime == 'MONDAY TO FRIDAY / 8:00AM TO 4:00PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_hours_open = '8:00 AM';
				$dump_hours_close = '4:00 PM';
			}
			if ( $opentime == 'MONDAY TO FRIDAY / 8:00AM TO 5:00PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_hours_open = '8:00 AM';
				$dump_hours_close = '5:00 PM';
			}
			if ( $opentime == 'MONDAY TO FRIDAY / 8:00AM TO 6:00PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_hours_open = '8:00 AM';
				$dump_hours_close = '6:00 PM';
			}
			if ( $opentime == 'MONDAY TO FRIDAY / 9:00AM TO 3:00PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_hours_open = '9:00 AM';
				$dump_hours_close = '3:00 PM';
			}
			if ( $opentime == 'MONDAY TO FRIDAY / 9:00AM TO 5:00PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_hours_open = '9:00 AM';
				$dump_hours_close = '5:00 PM';
			}
			if ( $opentime == 'MONDAY TO SATURDAY / 8:00AMTO4:00PM' ) { 
				$dump_days_open = 'Monday, Tuesday, Wednesday, Thursday, Friday, Saturday';
				$dump_hours_open = '8:00 AM';
				$dump_hours_close = '4:00 PM';
			}
			if ( $opentime == 'MONDAY TO SATURDAY / 8:30AM TO 5:00PM' ) { 
				$dump_days_open[] = 'Mo';
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_days_open[] = 'Sa';
				$dump_hours_open = '8:30 AM';
				$dump_hours_close = '5:00 PM';
			}
			if ( $opentime == 'TUESDAY TO SATURDAY / 8:00AM TO 5:00PM' ) { 
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_days_open[] = 'Fr';
				$dump_days_open[] = 'Sa';
				$dump_hours_open = '8:00 AM';
				$dump_hours_close = '5:00 PM';
			}
			if ( $opentime == 'TUESDAY TO THURSDAY / 9:00AM TO 2:00PM' ) { 
				$dump_days_open[] = 'Tu';
				$dump_days_open[] = 'We';
				$dump_days_open[] = 'Th';
				$dump_hours_open = '9:00 AM';
				$dump_hours_close = '2:00 PM';
			}		
		}
		
		//Setup for dumpfee
		$dump_fee = '';
		$dump_reg_guest_fee = '';
		if ( !empty( $dumpfee ) ) {
			if ( $dumpfee == '$1.00 ' ) { 
				$dump_fee = '1.00';
			}
			if ( $dumpfee == '$10.00 ' ) { 
				$dump_fee = '10.00';
			}
			if ( $dumpfee == '$15.00 ' ) { 
				$dump_fee = '15.00';
			}
			if ( $dumpfee == '$2.00 ' ) { 
				$dump_fee = '2.00';
			}
			if ( $dumpfee == '$25.00 ' ) { 
				$dump_fee = '25.00';
			}
			if ( $dumpfee == '$3.00 ' ) { 
				$dump_fee = '3.00';
			}
			if ( $dumpfee == '$4.00 ' ) { 
				$dump_fee = '4.00';
			}
			if ( $dumpfee == '$4.50 ' ) { 
				$dump_fee = '4.50';
			}
			if ( $dumpfee == '$5.00 ' ) { 
				$dump_fee = '5.00';
			}
			if ( $dumpfee == '$6.00 ' ) { 
				$dump_fee = '6.00';
			}
			if ( $dumpfee == '$7.00 ' ) { 
				$dump_fee = '7.00';
			}
			if ( $dumpfee == '1' ) { 
				$dump_fee = '1.00';
			}
			if ( $dumpfee == '10' ) { 
				$dump_fee = '10.00';
			}
			if ( $dumpfee == '10.00 OR FREE WITH P' ) { 
				$dump_fee = '10.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '15' ) { 
				$dump_fee = '15.00';
			}
			if ( $dumpfee == '15.00 OR FREE WITH F' ) { 
				$dump_fee = '15.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '2' ) { 
				$dump_fee = '2.00';
			}
			if ( $dumpfee == '2.00 OR 1.00 WITH PU' ) { 
				$dump_fee = '2.00';
				$dump_reg_guest_fee = '1.00';
			}
			if ( $dumpfee == '2.00 OR FREE IF CAMP' ) { 
				$dump_fee = '2.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '2.00 OR FREE WITH FU' ) { 
				$dump_fee = '2.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '2.00 W/O GAS FILL-UP' ) { 
				$dump_fee = '2.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '2.50 OR 5.00 WITH FI' ) { 
				$dump_fee = '2.50';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '2.50 OR FREE WITH FU' ) { 
				$dump_fee = '2.50';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '20' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == '25' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == '26.75 (ONE NIGHT FEE' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == '3' ) { 
				$dump_fee = '3.00';
			}
			if ( $dumpfee == '3.00 OR FREE WITH FI' ) { 
				$dump_fee = '3.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '3.00 OR FREE WITH FU' ) { 
				$dump_fee = '3.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '3.00; FREE WITH PURC' ) { 
				$dump_fee = '3.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '4' ) { 
				$dump_fee = '4.00';
			}
			if ( $dumpfee == '5' ) { 
				$dump_fee = '5.00';
			}
			if ( $dumpfee == '5.00 DONATION' ) { 
				$dump_fee = '5.00';
			}
			if ( $dumpfee == '5.00 FOR NON-CAMPERS' ) { 
				$dump_fee = '5.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '5.00 OR 1.00 WITH FI' ) { 
				$dump_fee = '5.00';
				$dump_reg_guest_fee = '1.00';
			}
			if ( $dumpfee == '5.00 OR 3.00 WITH FU' ) { 
				$dump_fee = '5.00';
				$dump_reg_guest_fee = '3.00';
			}
			if ( $dumpfee == '5.00 OR FREE WITH FU' ) { 
				$dump_fee = '5.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '5.00 TO GET KEY; PAD' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == '5.00 WITHOUT GAS OR ' ) { 
				$dump_fee = '5.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '5.00 WITHOUT PURCHAS' ) { 
				$dump_fee = '5.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '5.00; ALSO A ANNUAL ' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == '5.35' ) { 
				$dump_fee = '5.00';
			}
			if ( $dumpfee == '6' ) { 
				$dump_fee = '6.00';
			}
			if ( $dumpfee == '6.00 FOR NON-CAMPERS' ) { 
				$dump_fee = '6.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '7' ) { 
				$dump_fee = '7.00';
			}
			if ( $dumpfee == '7.00 FOR NON-CAMPERS' ) { 
				$dump_fee = '7.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '7.00 OR 5.00 WITH FU' ) { 
				$dump_fee = '7.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '7.00 OR FREE WITH FU' ) { 
				$dump_fee = '7.00';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == '8' ) { 
				$dump_fee = '8.00';
			}
			if ( $dumpfee == '8.5' ) { 
				$dump_fee = '8.5';
			}
			if ( $dumpfee == 'DONATION' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == 'Donation' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == 'FOR CAMPERS ONLY' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'FREE' ) { 
				$dump_fee = 'Free';
			}
			if ( $dumpfee == 'FREE FOR CAMPERS' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'FREE FOR CAMPERS OR ' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'FREE FOR ROUTE 66 ME' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == 'FREE IF PURCHASE FUE' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'FREE IF YOU ARE CAMP' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'FREE OR' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == 'FREE TO REGISTERED C' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'FREE TO RENTERS OR 5' ) { 
				$dump_fee = '';
			}
			if ( $dumpfee == 'FREE WITH FILL-UP. O' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'FREE WITH FUEL FILL-' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'Free' ) { 
				$dump_fee = 'Free';
			}
			if ( $dumpfee == 'PRIVATE FOR ELKS MEM' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'PRIVATE FOR ESCAPEE ' ) { 
				$dump_fee = '';
				$dump_reg_guest_fee = 'Free';
			}
			if ( $dumpfee == 'free' ) { 
				$dump_fee = 'Free';
			}
		}
		
		//Setup for regcost
		if ( !empty( $regcost ) ) {
			if ( $regcost == 'Free' ) { 
				$dump_reg_guest_fee = 'Free';
			}		
		}
		
		//Setup for water
		if ( !empty( $water ) ) {
			if ( $water == 'Has water bib for flushing' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'a fresh water supply is at hand' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'drinking water available' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'drinking water available; water is off during winter' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'drinking water is available' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'fresh water' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'fresh water available' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'good water' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'has a water hose for cleanup' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'no hose or water for flushing that we know of' ) { 
				$term = term_exists("No Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'no rinse water' ) { 
				$term = term_exists("No Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'no rinse water avalable' ) { 
				$term = term_exists("No Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'no water' ) { 
				$term = term_exists("No Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'no water available' ) { 
				$term = term_exists("No Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'non-potable rinsing for sewage hose, hose provided' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'non-potable water for rinsing available' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'potable and non-potable water available; no water in winter' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'potable and rinse water available' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'potable available; water may be off during winter' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'potable water' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'potable water available' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'potable water; dump site includes city water' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'potable water; has potable water but does not have a water hose connection needed by most motorhomes' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse and potable water available' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse hose available' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water and potable water available' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water and separate fresh water; good water' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water at RV dump; potable water at convience store' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water available' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water available at sani dump; potable drink water is available from gas bar' ) { 
				$term = term_exists("Potable Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water available, very high water pressure, open very slowly' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water is available; no safe potable water supply' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water only' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water only, no potable water' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water only; water is turned off during winter; 2009-09-20 water is broken, needs underground r' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water, 6 foot hose' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinse water, no potable water' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'rinsing water only; only short hose available & no way to connect longer hose to rinse tank complete' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'separate potable and rinse water' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'seperate rinse & (fresh) potable water' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'water available' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'water available, potable water on request' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'water available, supply your own rinse hose' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'water available; no hoses' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'water for washing purposes only, not for consumption' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'water is off during winter' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'water tap with non-potable water for recharging' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
			if ( $water == 'water to the facility is shut off once the temperature starts dipping below freezing overnight' ) { 
				$term = term_exists("Rinse Water", "dump_water");
				$new_water[] = $term['term_id'];
			}
		}
		// Create post object
		$my_post = array(
			'post_title'    => $name,
			'post_name'			=> $name_lc . '-' . $city_lc,
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_author'   => 2,
			'post_type'   => 'rvdumps'
		);
		// Insert the post into the database
		echo $post_id = wp_insert_post( $my_post, $wp_error );
		wp_set_post_terms( $post_id, $state, 'states' );
		add_post_meta( $post_id, 'dump_address', $address );
		add_post_meta( $post_id, 'dump_city', $city );
		add_post_meta( $post_id, 'dump_zip', $zip );
		if ( $coords != '' ) { add_post_meta( $post_id, 'dump_coords', $coords ); }
		if ( !empty( $openseason ) ) { add_post_meta( $post_id, 'dump_season', $new_dates ); }
		if ( $dump_hours_open != '' ) { add_post_meta( $post_id, 'dump_hours_open', $dump_hours_open ); }
		if ( $dump_hours_close != '' ) { add_post_meta( $post_id, 'dump_hours_close', $dump_hours_close ); }
		if ( !empty ($dump_days_open ) ) { add_post_meta( $post_id, 'dump_days_open', $dump_days_open ); }
		if ( $dump_fee != '' ) { add_post_meta( $post_id, 'dump_fee', $dump_fee ); }
		if ( $dump_reg_guest_fee != '' ) { add_post_meta( $post_id, 'dump_reg_guest_fee', $dump_reg_guest_fee ); }
		wp_set_post_terms( $post_id, $new_water, 'dump_water' );
		
		/** Save Nearby RV Dumps
		********************************/	
		$post_type = 'rvdumps';
		$wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO rvty_geodata
				( post_id, geo_latitude, geo_longitude, post_type )
				VALUES ( %d, %f, %f, %s )
			", 
			$post_id,
			$lat,
			$lng,
			$post_type
		) );	
		$starting_ids[] = $post_id;
	}
	
	/* Nearby RV Dump Coords
	***********************************************/
	foreach ($starting_ids as $starting_id) {
		$starting_id . '<br />';
		$current_park = $wpdb->get_results( 
				"
				 SELECT *  
				 FROM rvty_geodata
				 WHERE post_id = '$starting_id'
				"
		);
		$post_id = $current_park[0]->post_id;
		$lat = $current_park[0]->geo_latitude;
		if ( $lat == 0 ) { continue; }
		$lng = $current_park[0]->geo_longitude;
		if ( $lng == 0 ) { continue; }
		$post_type = 'rvdumps';
		$field_value = 'dump';
		nearbyLocations ( $post_id, $post_type, $field_value, $lat, $lng, 1 );
	}
} else {
	echo 'balls!';
}

?>
<form method="post" action="">
<br /><br />
<input type="text" name="submited_state" size="4" />&nbsp; 
<input type="submit" name="submit" value="Insert the new Posts" />
</form>
<br /><br />
<?php get_footer(); ?>