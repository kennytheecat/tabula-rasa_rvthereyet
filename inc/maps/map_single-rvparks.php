<script type="text/javascript">
function initialize() {
	var myLatlng = new google.maps.LatLng(34.555204, -112.467148);
	var contentString = '<?php echo $marker_html ?>';	
	var myOptions = {
		center: myLatlng,
		zoom: 13,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var map = new google.maps.Map(document.getElementById("map"), myOptions);

	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title:"Name"
	});
			
	google.maps.event.addListener(marker, 'click', function() {
		infoBubble.setContent(contentString);
		infoBubble.open(map, marker)
	});		
}
	var infoBubble = new InfoBubble({
		minHeight: 60,
		minWidth: 250,
		padding: 15,
		borderRadius: 10,
		borderWidth: 4, 
		borderColor: '#fff',
		backgroundColor: '#fff',
		backgroundImage: '',		
		background: '#685 url(<?php bloginfo('template_directory'); ?>/graphics/paper_2_trans.png)',		
		backgroundClassName: 'phoney',	
		arrowSize: 15,
		arrowPosition: 50,
		arrowStyle: 0
	});
			</script>	