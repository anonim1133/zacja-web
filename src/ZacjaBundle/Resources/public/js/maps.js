function mapInitialize() {
	if($('#last_conquers_list a').length > 0) {
		var latlon = $($('#last_conquers_list a')[0]).attr('href').replace('#', '').split(',');
		var title = $($('#last_conquers_list a')[1]).text() + ' - ' + $($('#last_conquers_list a')[0]).text();

		var myLatlng = new google.maps.LatLng(latlon[0], latlon[1]);
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
}

function mapAddPoint(lat, lon, title) {
	marker.setPosition( new google.maps.LatLng( lat, lon ) );
	marker.setTitle(title);
	map.panTo( new google.maps.LatLng( lat, lon ) );
	map.setZoom(16);
}
google.maps.event.addDomListener(window, 'load', mapInitialize);

  ////////////////////
 //    Training    //
////////////////////


function mapTrainingInitialize() {
	if($('#training-map-canvas').length > 0){
		gpx = $.parseJSON(gpx);

		var myLatlng = new google.maps.LatLng(gpx[0]['lat'],gpx[0]['lon']);
		var mapOptions = {
			zoom: 16,
			center: myLatlng
		}
		map = new google.maps.Map(document.getElementById('training-map-canvas'), mapOptions);

		var polyCords = [];

		$(gpx).each(function(index, element){
			polyCords.push(new google.maps.LatLng(gpx[index]['lat'], gpx[index]['lon']));
		});

		var polyPath = new google.maps.Polyline({
			path: polyCords,
			geodesic: true,
			strokeColor: '#FF0000',
			strokeOpacity: 1.0,
			strokeWeight: 2
		});

		polyPath.setMap(map);


		//finding center
		var bounds = new google.maps.LatLngBounds();
		for (i = 0; i < polyCords.length; i++) {
			bounds.extend(polyCords[i]);
		}

		map.fitBounds(bounds);
	}
}


google.maps.event.addDomListener(window, 'load', mapTrainingInitialize);