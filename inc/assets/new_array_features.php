Find: \$new_activities\[\] = (.*);\}
Replace: \r\t\t\t\t\$term = term_exists\("TERM", "activities"\); \r\t\t\t\t\$new_activities\[\] = \$term['term_id']\;//$1\r\t\t\t\}


<?php
$park_activities_arr = array(
23"Golfing",
);
$park_features_arr = array(
15"Full Hookups",
16"Gasoline",
17"Group Area",
18"Groups Welcome",
19"Handicapped",
20"Horse Facilities",
21"Hot Showers",
22"Hot Tub",
29"OHV Trails",
30"Other Lodging",
32"Phone",
35"Pool",
36"Pull-through Sites",
38"Restaurant",
39"Repair Services",
41"Suana",
42"Sewer Hookups",
43"Spa",
44"Trailhead",
48"Planned Activities",
50"Satellite TV",
52"Big Rig Capable",
53"Pets Allowed"
);

$park_sitetypes_arr = array(
"RV Sites",
"Full Hookups",
"Pull-throughs",
"Paved Sites",
"50 Amp Capable",
"Big Rig Capable",
"Tent Sites"
);
$park_atmosphere_arr = array(
5"Quiet Atmosphere",
6"Resort Atmosphere",
7"Rural Setting",
8"Urban Setting",
);
$park_rates_arr = array(
0"Affiliation Discounts",
1"Group Discounts",
3"Monthly Rates",
4"Seasonal Rates"
);
$park_cost_arr = array(
"Daily - Full Hookup",
"Weekly - Full Hookup",
"Monthly Full Hookup",
"Daily - Partial",
"Weekly - Partial",
"Monthly - Partial",
"Daily - Dry",
"Weekly - Dry",
"Monthly - Dry"
);

		$atmospheres = explode('|', atmospheres);
		foreach ( $atmospheres as $atmosphere ) {
			if ( $atmosphere == 0  ) { 
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			}
			if ( $atmosphere == 1  ) {
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			}
			if ( $atmosphere == 2  ) {
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			}
			if ( $atmosphere == 3  ) {
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			}
			if ( $atmosphere == 4  ) {
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			}
			if ( $atmosphere == 5  ) { 
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			}
			if ( $atmosphere == 6  ) { 
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			} 
			if ( $atmosphere == 7  ) {
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			}
			if ( $atmosphere == 8  ) { 
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			}
			if ( $atmosphere == 9  ) { 
				$term = term_exists("TERM", "atmospheres"); 
				$new_atmospheres[] = $term['term_id'];
			}
		}
?>