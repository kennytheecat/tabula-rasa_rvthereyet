<nav id="sec_nav">
	<div class="menu-header">
		<ul id="menu-sec_menu_home" class="menu">
			<?php if (is_page(array('cities',  'rv-stops', 'rv-clubs', 'rv-dumps', 'rv-snowbirds') ) || is_singular( 'rvparks' ) || get_query_var( 'cities' ) ) { ?>
				<li id="menu-item-state" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home">
					<a href="<?php echo home_url(); ?>/rv-parks/<?php echo $lc_state; ?>/"><?php echo $state; ?> RV Parks</a>
				</li>
			<?php } ?>
			<?php if ( is_singular( 'rvparks' ) ){ ?>
				<li id="menu-item-city" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home">
					<a href="<?php echo home_url(); ?>/rv-parks/<?php echo $lc_state . '/' . $lc_city . '/">'?><?php echo $city; ?> RV Parks</a>	
				</li>
			<?php } ?>
		</ul>
		<div class="dropdown_section">
			<?php 
			$args = array(
				'taxonomy'  => 'states',
				'show_option_none' => 'RV Parks in...',
				'order' => 'ASC',
				'orderby' => 'NAME'
			); 
			wp_dropdown_categories( $args ); ?> 
<script type="text/javascript"><!--
    var dropdown = document.getElementById("cat");
    function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
			location.href = "<?php echo get_option('home');
?>/rv-parks/"+dropdown.options[dropdown.selectedIndex].text.toLowerCase();
		}
    }
    dropdown.onchange = onCatChange;
--></script>			
		</div>
	</div>
</nav>