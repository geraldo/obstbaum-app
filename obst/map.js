var map, markers, markersArray, catApfel, catBirne, catKastanie, catKirsche, catNuesse, catZwetschke, catSonstiges, polygonArray;

function loadMap() {
	var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/60ec3a9d598e4c919b3ceda2344e0b19/94190/256/{z}/{x}/{y}.png',
		cloudmadeAttribution = '',
		cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
		latlng = new L.LatLng(48.30, 14.30);

	var greenIcon = L.icon({
		iconUrl: '/wp-content/themes/obst/leaflet051/images/leaf-green.png',
		shadowUrl: '/wp-content/themes/obst/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95], // size of the icon
		shadowSize:   [50, 64], // size of the shadow
		iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
		shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
	});
	var apfelIcon = L.icon({
		iconUrl: '/wp-content/themes/obst/leaflet051/images/leaf-Apfel.png',
		shadowUrl: '/wp-content/themes/obst/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var birneIcon = L.icon({
		iconUrl: '/wp-content/themes/obst/leaflet051/images/leaf-Birne.png',
		shadowUrl: '/wp-content/themes/obst/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var kastanieIcon = L.icon({
		iconUrl: '/wp-content/themes/obst/leaflet051/images/leaf-Edelkastanie.png',
		shadowUrl: '/wp-content/themes/obst/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var kirscheIcon = L.icon({
		iconUrl: '/wp-content/themes/obst/leaflet051/images/leaf-Kirsche.png',
		shadowUrl: '/wp-content/themes/obst/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var nuesseIcon = L.icon({
		iconUrl: '/wp-content/themes/obst/leaflet051/images/leaf-Nüsse.png',
		shadowUrl: '/wp-content/themes/obst/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var zwetschkeIcon = L.icon({
		iconUrl: '/wp-content/themes/obst/leaflet051/images/leaf-Zwetschke.png',
		shadowUrl: '/wp-content/themes/obst/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});

	map = new L.Map('map', {center: latlng, zoom: 13, layers: [cloudmade], attributionControl: false});
	markers = new L.MarkerClusterGroup({spiderfyDistanceMultiplier: 2.2, maxClusterRadius: 60, disableClusteringAtZoom: 18});

	catApfel = new L.LayerGroup();
	catBirne = new L.LayerGroup();
	catKastanie = new L.LayerGroup();
	catKirsche = new L.LayerGroup();
	catNuesse = new L.LayerGroup();
	catZwetschke = new L.LayerGroup();
	catSonstiges = new L.LayerGroup();

	markersArray = new Array();
	
	for (var i = 0; i < obst.length; i++) {
		var a = obst[i];
		var cat = a[6];

		if (cat=='Apfel') var baumIcon = apfelIcon;
		else if (cat=='Birne') var baumIcon = birneIcon;
		else if (cat=='Edelkastanie') var baumIcon = kastanieIcon;
		else if (cat=='Kirsche') var baumIcon = kirscheIcon;
		else if (cat=='Nüsse') var baumIcon = nuesseIcon;
		else if (cat=='Zwetschke') var baumIcon = zwetschkeIcon;
		else var baumIcon = greenIcon;

		var marker = new L.Marker(new L.LatLng(a[2], a[3]), { icon: baumIcon });
		var rating = 120 / 5 * a[7]; 
		if ( a[8] == 1) var comment = "Kommentar";
		else var comment = "Kommentare";
		if ( a[9] == 1) var foto = "Foto";
		else var foto = "Fotos";
		marker.bindPopup("<b>"+a[1]+" [#"+a[0]+"]</b><br><br><div style='text-align:left; padding: 0; margin: 0; background: url(http://linz.pflueckt.at/wp-content/plugins/gd-star-rating/stars/oxygen/stars24.png); height: 24px; width: 120px;'><div style='background: url(http://linz.pflueckt.at/wp-content/plugins/gd-star-rating/stars/oxygen/stars24.png) bottom left; padding: 0; margin: 0; height: 24px; width: "+a[7]+"px;'></div></div><br>"+a[8]+" "+comment+", "+a[9]+" "+foto+"<br><br><a href='/#/baum/"+a[0]+"'>Details anzeigen</a>");
		markersArray.push(marker);

		if (cat=='Apfel') catApfel.addLayer(marker);
		else if (cat=='Birne') catBirne.addLayer(marker);
		else if (cat=='Edelkastanie') catKastanie.addLayer(marker);
		else if (cat=='Kirsche') catKirsche.addLayer(marker);
		else if (cat=='Nüsse') catNuesse.addLayer(marker);
		else if (cat=='Zwetschke') catZwetschke.addLayer(marker);
		else catSonstiges.addLayer(marker);
	}

	markers.addLayer(catApfel);
	markers.addLayer(catBirne);
	markers.addLayer(catKastanie);
	markers.addLayer(catKirsche);
	markers.addLayer(catNuesse);
	markers.addLayer(catZwetschke);
	markers.addLayer(catSonstiges);

	map.addLayer(markers);

	L.control.locate({
		title: "Zeige mir meinen aktuellen Standpunkt",
		popupText: ["Du bist im Umkreis von ", " von diesem Punkt."],
	}).addTo(map);

	/* load Obstbaumgärten */
	polygonArray = new Array();

	for (var i = 0; i < garten.length; i++) {
		var g = garten[i];
		var obstgarten = L.polygon(g[3], {
			color: 'red',
			fillColor: '#649650',
			fillOpacity: 0.6
		}).addTo(map);
		obstgarten.bindPopup("<b>"+g[1]+"</b><br><br>"+g[2]+"<br><br><a href='http://linz.pflueckt.at/#/garten/"+g[4]+"'>Details anzeigen</a>");
		polygonArray.push(obstgarten);
	}
}

function showLayers(layers) {
	markers.clearLayers();
	for (var i = 0; i < layers.length; i++) {
		if (layers[i] == 'Apfel') markers.addLayer(catApfel);
		else if (layers[i] == 'Birne') markers.addLayer(catBirne);
		else if (layers[i] == 'Kastanie') markers.addLayer(catKastanie);
		else if (layers[i] == 'Kirsche') markers.addLayer(catKirsche);
		else if (layers[i] == 'Nuesse') markers.addLayer(catNuesse);
		else if (layers[i] == 'Zwetschke') markers.addLayer(catZwetschke);
		else if (layers[i] == 'Sonstiges') markers.addLayer(catSonstiges);
	}
	map.addLayer(markers);
}
