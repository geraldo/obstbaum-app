function loadMap() {
	var mapboxTiles = L.tileLayer('https://{s}.tiles.mapbox.com/v3/geraldo.map-cekfhhly/{z}/{x}/{y}.png');
	var mapboxSatellite = L.tileLayer('https://{s}.tiles.mapbox.com/v3/geraldo.hej3b3ge/{z}/{x}/{y}.png');
	var mapboxTerrain = L.tileLayer('https://{s}.tiles.mapbox.com/v3/geraldo.hej56206/{z}/{x}/{y}.png');
	var center = new L.LatLng(48.30, 14.30);

	var map = new L.Map('map', {center: center, zoom: 13, layers: [mapboxTiles]});

	var baseMaps = {
		"Standard": mapboxTiles,
		"Terrain": mapboxTerrain,
		"Satellit": mapboxSatellite
	};
	L.control.layers(baseMaps, null, {position: 'topleft'}).addTo(map);

	var markers = new L.MarkerClusterGroup();

	var greenIcon = L.icon({
		iconUrl: 'leaflet051/images/leaf-green.png',
		shadowUrl: 'leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var apfelIcon = L.icon({
		iconUrl: 'leaflet051/images/leaf-Apfel.png',
		shadowUrl: 'leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var birneIcon = L.icon({
		iconUrl: 'leaflet051/images/leaf-Birne.png',
		shadowUrl: 'leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var kastanieIcon = L.icon({
		iconUrl: 'leaflet051/images/leaf-Edelkastanie.png',
		shadowUrl: 'leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var kirscheIcon = L.icon({
		iconUrl: 'leaflet051/images/leaf-Kirsche.png',
		shadowUrl: 'leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var nuesseIcon = L.icon({
		iconUrl: 'leaflet051/images/leaf-Nüsse.png',
		shadowUrl: 'leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var zwetschkeIcon = L.icon({
		iconUrl: 'leaflet051/images/leaf-Zwetschke.png',
		shadowUrl: 'leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});

	for (var i = 0; i < obstPoints.length; i++) {
		var a = obstPoints[i];
		if (a[10]=='Apfel') var baumIcon = apfelIcon;
		else if (a[10]=='Birne') var baumIcon = birneIcon;
		else if (a[10]=='Edelkastanie') var baumIcon = kastanieIcon;
		else if (a[10]=='Kirsche') var baumIcon = kirscheIcon;
		else if (a[10]=='Nüsse') var baumIcon = nuesseIcon;
		else if (a[10]=='Zwetschke') var baumIcon = zwetschkeIcon;
		else var baumIcon = greenIcon;
		var marker = new L.Marker(new L.LatLng(a[2], a[3]), { icon: baumIcon });
		marker.bindPopup("<b>"+a[1]+"</b><br><br>Gattung: "+a[4]+"<br>Art: "+a[5]+"<br>Sorte: "+a[6]+"<br>Kategorie: "+a[10]+"<br><br>Baumhöhe: "+a[7]+"m<br>Schirmdurchmesser: "+a[8]+"m<br>Stammumfang: "+a[9]+"cm"+"<br><br>Reif von: "+a[11]+"<br>Reif bis: "+a[12]).openPopup();
		markers.addLayer(marker);
	}
	map.addLayer(markers);
	L.control.locate({
		title: "Zeige mir meinen aktuellen Standpunkt",
		popupText: ["Du bist im Umkreis von ", " von diesem Punkt."],
	}).addTo(map);

	var obstbaumgarten1 = L.polygon([
		[48.30132, 14.26418],
		[48.30278, 14.26275],
		[48.30243, 14.2622],
		[48.30195, 14.26269],
		[48.30166, 14.26354]
	], {
		color: 'red',
	    fillColor: '#f03',
		fillOpacity: 0.6
	}).addTo(map);
	obstbaumgarten1.bindPopup("<b>Obstbaumgarten Margarethen am Freinberg</b><br><br>Angelegt 1998<br>Größe 7.700 m²<br>ca. 100 Bäume<br><br><a href='http://linz.pflueckt.at/#/obstbaumgarten-margarethenweg/'>Details anzeigen</a>");

	var obstbaumgarten2 = L.polygon([
		[48.27878, 14.29093],
		[48.27858, 14.29093],
		[48.27862, 14.29128],
		[48.27886, 14.29157],
		[48.27897, 14.29145]
	], {
		color: 'red',
	    fillColor: '#f03',
		fillOpacity: 0.6
	}).addTo(map);
	obstbaumgarten2.bindPopup("<b>Obstbaumgarten Hummelhofwald</b><br><br>Angelegt 2007<br>Größe 1.500 m²");

	var obstbaumgarten3 = L.polygon([
		[48.33427, 14.30074],
		[48.33425, 14.30089],
		[48.33463, 14.30085],
		[48.33476, 14.30115],
		[48.33484, 14.30075]
	], {
		color: 'red',
	    fillColor: '#f03',
		fillOpacity: 0.6
	}).addTo(map);
	obstbaumgarten3.bindPopup("<b>Obstbaumgarten Feuerwache Nord</b><br><br>Angelegt 2008<br>Größe 450 m²");

	var obstbaumgarten4 = L.polygon([
		[48.33475, 14.3049],
		[48.33484, 14.305],
		[48.33515, 14.30421],
		[48.33498, 14.30409]
	], {
		color: 'red',
	    fillColor: '#f03',
		fillOpacity: 0.6
	}).addTo(map);
	obstbaumgarten4.bindPopup("<b>Obstbaumgarten Biesenfeld</b><br><br>Angelegt 2009<br>Größe 1.000 m²");

	var obstbaumgarten5 = L.polygon([
		[48.33832, 14.28993],
		[48.33818, 14.28944],
		[48.33905, 14.28878],
		[48.33914, 14.28892],
		[48.33952, 14.28901],
		[48.33974, 14.28954],
		[48.33931, 14.28949],
		[48.33889, 14.28959]
	], {
		color: 'red',
	    fillColor: '#f03',
		fillOpacity: 0.6
	}).addTo(map);
	obstbaumgarten5.bindPopup("<b>Obstbaumgarten Kampmüllerweg</b><br><br>Angelegt 2013<br>Größe 11.000 m²");

	var popup = L.popup();
	function onMapClick(e) {
		popup
		    .setLatLng(e.latlng)
		    .setContent("You clicked the map at " + e.latlng.toString())
		    .openOn(map);
	}
	map.on('click', onMapClick);
}

