<?php
/**
	Template Name: Import
*/

/* http://sourceforge.net/projects/proj4php/ */
include_once("/var/www/obst/static/parse/proj4php/proj4php.php");

$lines = file("http://localhost/obst/static/parse/baeume-obst.csv");

foreach ($lines as $baumid => $line) {
	if ($baumid > 0) {
		$tokens = explode(';',$line);
		$gattung = trim($tokens[2]);
		$art = trim($tokens[3]);
		$sorte = trim($tokens[4]);
		$title = trim($tokens[5]);
		$baumhoehe = trim($tokens[6]);
		$schirmdurchmesser = trim($tokens[7]);
		$stammumfang = trim($tokens[8]);
		$lat = trim($tokens[10]);
		$long = trim($tokens[11]);
		$point = tmerc2wgs84($lat,$long);
		$lat = $point->y;
		$long = $point->x;
		$kat = trim($tokens[12]);
		$reifvon = trim($tokens[13]);
		$reifbis = trim($tokens[14]);

		//insert posts into wordpress
		$post = array(
			'post_author' => 1,
			'post_name' => $baumid,
			'post_status' => 'publish',
			'post_title' => $title,
			'post_type' => 'baum',
		);  

		//write to WP
		$id = wp_insert_post($post);
		//echo "SAVED WITH ID:".$id."<br>";

		//add meta data
		add_post_meta($id, 'baumid', $baumid);
		add_post_meta($id, 'lat', $lat);
		add_post_meta($id, 'long', $long);
		add_post_meta($id, 'gattung', $gattung);
		add_post_meta($id, 'art', $art);
		add_post_meta($id, 'sorte', $sorte);
		add_post_meta($id, 'kat', $kat);
		add_post_meta($id, 'baumhoehe', $baumhoehe);
		add_post_meta($id, 'schirmdurchmesser', $schirmdurchmesser);
		add_post_meta($id, 'stammumfang', $stammumfang);
		add_post_meta($id, 'reifvon', $reifvon);
		add_post_meta($id, 'reifbis', $reifbis);
	}
}

/* Convert Transverse Mercator Projection to Longitude/Latitude using library proj4php */
function tmerc2wgs84($xpos, $ypos) {
	$proj4 = new Proj4php();
	// EPSG:31255 http://spatialreference.org/ref/epsg/31255/proj4js/
	// had to change x correction to: x_0=0
	$projTMERC = new Proj4phpProj('EPSG:31255',$proj4);
	$projWGS84 = new Proj4phpProj('EPSG:4326',$proj4);

	$pointSrc = new proj4phpPoint($xpos,$ypos);
	//echo "Source : ".$pointSrc->toShortString()." in TMERC<br>";
	$pointDest = $proj4->transform($projTMERC,$projWGS84,$pointSrc);
	//echo "Conversion : ".$pointDest->toShortString()." in WGS84<br><br>";

	return $pointDest;
}

?>
