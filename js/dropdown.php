<script type="text/javascript"><!--
//Auto submit for dropdowns
	var dropdown1 = document.getElementById("states");
	var dropdown2 = document.getElementById("tax");	
	if (dropdown2 == null) {
		function onCatChange() {
			if ( dropdown1.options[dropdown1.selectedIndex].index > 0 ) {
				location.href = custom.templateDir+"<?php echo $listingType;?>"+dropdown1.options[dropdown1.selectedIndex].value;
			}
		}		
		dropdown1.onchange = onCatChange;		
	} 
	if (dropdown2 != null) {
		function onCatChangea() {
			if ( dropdown1.options[dropdown1.selectedIndex].index > 0 ) {
				if ( dropdown2.options[dropdown2.selectedIndex].index > 0 ) {
					location.href = custom.templateDir+"<?php echo $listingType;?>"+dropdown2.options[dropdown2.selectedIndex].value+"/"+dropdown1.options[dropdown1.selectedIndex].value;
				}
			}
		}
		function onCatChangeb() {
			if ( dropdown2.options[dropdown2.selectedIndex].index > 0 ) {
				if ( dropdown1.options[dropdown1.selectedIndex].index > 0 ) {
					location.href = custom.templateDir+"<?php echo $listingType;?>"+dropdown2.options[dropdown2.selectedIndex].value+"/"+dropdown1.options[dropdown1.selectedIndex].value;
				}
			}
		}
		dropdown1.onchange = onCatChangea;
		dropdown2.onchange = onCatChangeb;
	}
--></script>	