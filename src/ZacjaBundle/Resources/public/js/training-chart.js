window.onload = function () {
	var speed = [];
	var ele = []

	$(gpx).each(function(key, gpx){
		var s = parseFloat(gpx['speed']);
		speed.push({x: new Date(gpx['time'] * 1000), y: s})
	});

	$(gpx).each(function(key, gpx){
		ele.push({x: new Date(gpx['time'] * 1000), y: parseFloat(gpx['ele'])})
	});

	var chart = new CanvasJS.Chart("trainingChartContainer",
		{
			animationEnabled: true,
			zoomEnabled: true,
			axisY :{
				includeZero: false
			},
			toolTip: {
				shared: "true"
			},
			data: [
				{
					type: "spline",
					showInLegend: true,
					name: "Speed",
					markerSize: 0,
					dataPoints: speed
				},
				{
					type: "spline",
					showInLegend: true,
					name: "Elevation",
					markerSize: 0,
					dataPoints: ele
				}
			]
		});

	chart.render();
}