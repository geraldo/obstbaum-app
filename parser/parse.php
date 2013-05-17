<?php
/*
 * Read csv file and write content to geojson file
**/
$fin = 'baeume-obst.csv';
$fout = 'obst.js';
//$fin = 'baeume-alle.csv';
//$fout = 'alle.js';

/* http://sourceforge.net/projects/proj4php/ */
include_once("proj4php/proj4php.php");

//write to geojson file
//format: ["name", long, lat],
$foutput = fopen($fout, 'w');
fwrite($foutput, 'var obstPoints = ['.PHP_EOL);

//open .csv file and read line by line
//format: Fläche;BaumNr;Gattung;Art;Sorte;NameDeutsch;Höhe;Schirmdurchmesser;Stammumfang;Typ;XPos;YPos;Kategorie;Reifvon;Reifbis
$lines = file($fin);
foreach ($lines as $n => $line) {
	if ($n > 0) {
		$tokens = explode(';',$line);
		$gattung = trim($tokens[2]);
		$art = trim($tokens[3]);
		if ($art == '.') $art = '';
		$sorte = trim($tokens[4]);
		if ($sorte == '.') $sorte = '';
		$title = trim($tokens[5]);
		$hoehe = trim($tokens[6]);
		$schirm = trim($tokens[7]);
		$stamm = trim($tokens[8]);
		$lat = trim($tokens[10]);
		$long = trim($tokens[11]);
		$kat = trim($tokens[12]);
		$date1 = trim($tokens[13]);
		$date2 = trim($tokens[14]);
		$point = tmerc2wgs84($lat,$long);
		$lat = $point->x;
		$long = $point->y;

		//echo "<p>".htmlentities($title)." [".$long."/".$lat."]</p>";

		// long version for static map
		//fwrite($foutput, "[".$n.", '".$title."', ".$long.", ".$lat.", '".$gattung."', '".$art."', '".$sorte."', ".$hoehe.", ".$schirm.", ".$stamm.", '".$kat."', '".$date1."', '".$date2."'],".PHP_EOL);	//extended version with all data for static map

		//short version for wordpress map
		fwrite($foutput, "[".$n.", '".$title."', ".$long.", ".$lat.", '".$kat."'],".PHP_EOL);	
	}
}
echo $n." datasets written to geojson file";

//stop to wrtie geojson file
fwrite($foutput, '];'.PHP_EOL);

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
