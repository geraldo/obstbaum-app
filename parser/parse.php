<?php
/*
 * Read csv file and write content to geojson file
**/
$fin = 'obst.csv';
$fout = 'obst.js';
//$fin = 'FME_BaumdatenBearbeitet_OGD.csv';
//$fout = 'alle.js';

/* http://sourceforge.net/projects/proj4php/ */
include_once("proj4php/proj4php.php");

//write to geojson file
//format: ["name", long, lat],
$foutput = fopen($fout, 'w');
fwrite($foutput, 'var obstPoints = ['.PHP_EOL);

//open .csv file and read line by line
//format: Fläche;BaumNr;Gattung;Art;Sorte;NameDeutsch;Höhe;Schirmdurchmesser;Stammumfang;Typ;XPos;YPos
$lines = file($fin);
foreach ($lines as $n => $line) {
	if ($n > 0) {
		$tokens = explode(';',$line);
		$title = trim($tokens[5]);
		$lat = trim($tokens[10]);
		$long = trim($tokens[11]);
		$point = tmerc2wgs84($lat,$long);
		$lat = $point->x;
		$long = $point->y;
		//echo "<p>".htmlentities($title)." [".$long."/".$lat."]</p>";
		fwrite($foutput, "['".$title."', ".$long.", ".$lat."],".PHP_EOL);
	}
}
echo $n." datasets written to geojson file";

//stop to wrtie geojson file
fwrite($foutput, '];'.PHP_EOL);

/* Fix issue reading a URL with a non-UTF-8 encoding that is later displayed improperly since file_get_contents() related to it as UTF-8 */
function file_get_contents_utf8($fn) {
     $content = file_get_contents($fn);
      return mb_convert_encoding($content, 'UTF-8',
          mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
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
