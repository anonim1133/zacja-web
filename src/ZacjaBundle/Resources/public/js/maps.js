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

		var myLatLng = new google.maps.LatLng(gpx[0]['lat'],gpx[0]['lon']);
		var mapOptions = {
			zoom: 16,
			center: myLatLng
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


		var icon = {
			path: 'M 299.8,61.6 177.9,168.4 168.9,246.2 105.2,346 168.8,398.4 414.8,345 345.7,251.2 245.1,191.6 Z',
			fillColor: '#33CCFF',
			fillOpacity: 0.8,
			scale: 0.1,
			strokeColor: '#33CCFF',
			anchor: new google.maps.Point(256,256),
			strokeWeight: 2
		};

		marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			icon: icon
		});
	}
}

function moveMarker( position ) {
	marker.setPosition( new google.maps.LatLng( gpx[position]['lat'], gpx[position]['lon'] ) );

};




google.maps.event.addDomListener(window, 'load', mapTrainingInitialize);