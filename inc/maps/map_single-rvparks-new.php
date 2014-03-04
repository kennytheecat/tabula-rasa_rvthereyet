<script type="text/javascript">
// Creating a MarkerClusterer object and adding the markers array to it  
var center = null;
var map = null;
var bounds = new google.maps.LatLngBounds();
function initialize() {
  var myOptions = {
    zoom: 8,
    center: new google.maps.LatLng(54.40624,-124.25916),
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById("map"), myOptions);
 
  google.maps.event.addListener(map, 'click', function() {
		getDirections();
		infowindow.close();
	});
  // Add markers to the map
	<?php foreach ($markers as $marker){ echo $marker; ?> 
	<?php } ?>
	<?php if ( is_page( cities ) )	{ ?>
		var mcOptions = {gridSize: 30, maxZoom: 15}	
		var markerclusterer = new MarkerClusterer(map, markers, mcOptions);
	<?php } ?>
	center = bounds.getCenter();
	map.fitBounds(bounds);
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
 
var infowindow = new google.maps.InfoWindow({ 
	size: new google.maps.Size(150,50)
});

var markers = [];	
function createMarker(latlng, html, image) {
	var contentString = html;
	var marker = new google.maps.Marker({
		position: latlng,
		map: map,
		icon: image,
		zIndex: Math.round(latlng.lat()*-100000)<<5
	});
	bounds.extend(latlng);
	google.maps.event.addListener(marker, 'click', function() {
		infoBubble.setContent(contentString);
		infoBubble.open(map, marker)
	});
	markers.push(marker);
}		
</script>