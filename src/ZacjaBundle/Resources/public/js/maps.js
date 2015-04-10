function mapInitialize() {
	var latlon = $($('#last_conquers_list a')[0]).attr('href').replace('#', '').split(',');
	var title = $($('#last_conquers_list a')[1]).text() + ' - ' + $($('#last_conquers_list a')[0]).text();

	var myLatlng = new google.maps.LatLng(latlon[0],latlon[1]);
	var mapOptions = {
		zoom: 16,
		center: myLatlng
	}
	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: title
	});
}

function mapAddPoint(lat, lon, title) {
	marker.setPosition( new google.maps.LatLng( lat, lon ) );
	marker.setTitle(title);
	map.panTo( new google.maps.LatLng( lat, lon ) );
	map.setZoom(16);
}

google.maps.event.addDomListener(window, 'load', mapInitialize);