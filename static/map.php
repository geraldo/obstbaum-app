<?php
	//Let's set the header straight
	header('Content-type: text/javascript');

	//Get the WP-specifics, so that we can use constants and what not
	//$home_dir = preg_replace('^wp-content/themes/[a-z0-9\-/]+^', '', getcwd());
	//include($home_dir . 'wp-load.php');
	//include('/home/geraldko/public_html/obst/wp-load.php');
	include('/var/www/vhosts/linzwiki.at/obst/wp-load.php');
	//include('/var/www/obst/wp-load.php');
?>

var map, markers, markersArray, catApfel, catBirne, catKastanie, catKirsche, catNuesse, catZwetschke, catSonstiges;

function loadMap() {
	var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/60ec3a9d598e4c919b3ceda2344e0b19/94190/256/{z}/{x}/{y}.png',
		cloudmadeAttribution = '',
		cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
		latlng = new L.LatLng(48.30, 14.30);

	var greenIcon = L.icon({
		iconUrl: '/static/leaflet051/images/leaf-green.png',
		shadowUrl: '/static/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95], // size of the icon
		shadowSize:   [50, 64], // size of the shadow
		iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
		shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
	});
	var apfelIcon = L.icon({
		iconUrl: '/static/leaflet051/images/leaf-Apfel.png',
		shadowUrl: '/static/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var birneIcon = L.icon({
		iconUrl: '/static/leaflet051/images/leaf-Birne.png',
		shadowUrl: '/static/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var kastanieIcon = L.icon({
		iconUrl: '/static/leaflet051/images/leaf-Edelkastanie.png',
		shadowUrl: '/static/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var kirscheIcon = L.icon({
		iconUrl: '/static/leaflet051/images/leaf-Kirsche.png',
		shadowUrl: '/static/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var nuesseIcon = L.icon({
		iconUrl: '/static/leaflet051/images/leaf-Nüsse.png',
		shadowUrl: '/static/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});
	var zwetschkeIcon = L.icon({
		iconUrl: '/static/leaflet051/images/leaf-Zwetschke.png',
		shadowUrl: '/static/leaflet051/images/leaf-shadow.png',
		iconSize:     [38, 95],
		shadowSize:   [50, 64],
		iconAnchor:   [22, 94],
		shadowAnchor: [4, 62],
		popupAnchor:  [-3, -76]
	});

	<?php 
		$ratings = 'var ratings=[';
		$comments = 'var comments=[';
		$fotos = 'var fotos=[';

		for ($i=0; $i<wp_count_posts('baum')->publish; $i++) {
			$id = $i+900;	//wordpress offset
			if (function_exists("wp_gdsr_rating_article")) {
				if ($i>0) $ratings .= ',';
				$ratings .= wp_gdsr_rating_article($id)->rating;
			}
			if ($i>0) $comments .= ',';
			$comments .= get_post($id)->comment_count;

			//count fotos
			$coms = get_comments(array('post_id' => $id));
			$numFotos = 0;
			foreach ($coms as $com) {
				$images = get_comment_meta($com->comment_ID, 'comment_image', true);
				if ($images) $numFotos++;
			}
			if ($i > 0) $fotos .= ',';
			$fotos .= $numFotos;
		}

		$ratings .= "];";
		$comments .= "];";
		$fotos .= "];";

		echo $ratings.PHP_EOL;
		echo $comments.PHP_EOL;
		echo $fotos.PHP_EOL;
	?>

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
	
	for (var i = 0; i < obstPoints.length; i++) {
		var a = obstPoints[i];
		var cat = a[4];

		if (cat=='Apfel') var baumIcon = apfelIcon;
		else if (cat=='Birne') var baumIcon = birneIcon;
		else if (cat=='Edelkastanie') var baumIcon = kastanieIcon;
		else if (cat=='Kirsche') var baumIcon = kirscheIcon;
		else if (cat=='Nüsse') var baumIcon = nuesseIcon;
		else if (cat=='Zwetschke') var baumIcon = zwetschkeIcon;
		else var baumIcon = greenIcon;

		var marker = new L.Marker(new L.LatLng(a[2], a[3]), { icon: baumIcon });
		var rating = 120 / 5 * ratings[i]; 
		if ( comments[i] == 1) var comment = "Kommentar";
		else var comment = "Kommentare";
		if ( fotos[i] == 1) var foto = "Foto";
		else var foto = "Fotos";
		marker.bindPopup("<b>"+a[1]+"</b> (Baum "+a[0]+")<br><br><div style='text-align:left; padding: 0; margin: 0; background: url(http://obst.linzwiki.at/wp-content/plugins/gd-star-rating/stars/oxygen/stars24.png); height: 24px; width: 120px;'><div style='background: url(http://obst.linzwiki.at/wp-content/plugins/gd-star-rating/stars/oxygen/stars24.png) bottom left; padding: 0; margin: 0; height: 24px; width: "+rating+"px;'></div></div><br>"+comments[i]+" "+comment+", "+fotos[i]+" "+foto+"<br><br><a href='/#/baum/"+a[0]+"'>Details anzeigen</a>");
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
