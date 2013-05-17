function loadMap() {
	var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/60ec3a9d598e4c919b3ceda2344e0b19/94190/256/{z}/{x}/{y}.png',
		cloudmadeAttribution = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
		cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
		latlng = new L.LatLng(48.30, 14.30);

	var map = new L.Map('map', {center: latlng, zoom: 13, layers: [cloudmade]});

	var markers = new L.MarkerClusterGroup();

	var greenIcon = L.icon({
		iconUrl: 'leaflet051/images/leaf-green.png',
		shadowUrl: 'leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95], // size of the icon
		shadowSize:   [50, 64], // size of the shadow
		iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
		shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
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
}

