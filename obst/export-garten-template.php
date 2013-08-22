<?php
/**
	Template Name: Export-Garten
*/

$url = '/var/www/vhosts/linzwiki.at/obst/wp-content/export/obstgarten.tmp.js';

//$foutput = (file_exists($url)) ? fopen($url, "w") : fopen($url, "w+");
$foutput = fopen($url, "w");
fwrite($foutput, 'var garten = ['.PHP_EOL);

//total amount: wp_count_posts('garten')->publish = 1

writeGartenJS($foutput);

//stop to write geojson file
fwrite($foutput, '];'.PHP_EOL);
fclose($foutput);

function writeGartenJS($foutput) {

	$my_query = new WP_Query('post_type=garten&order=ASC&orderby=ID');

	if ( have_posts() ) {

		$n = 1;

		while ($my_query->have_posts()) {

			$my_query->the_post();

			//$id = get_post_meta(get_the_ID(), 'baumid', true);
			$titel = get_the_title();
			$content = get_the_content();
			$coord = get_post_meta(get_the_ID(), 'koordinaten', true);
			$link = get_post_meta(get_the_ID(), 'link', true);

			//get comment count
			$comments = get_post(get_the_ID())->comment_count;
			//get foto count
			$coms = get_comments(array('post_id' => get_the_ID()));
			$fotos = 0;
			foreach ($coms as $com) {
				$images = get_comment_meta($com->comment_ID, 'comment_image', true);
				if ($images) $fotos++;
			}

			fwrite($foutput, "[".$n.", '".$titel."', '".$coord."', '".$link."', ".$comments.", ".$fotos.", ''],".PHP_EOL);	

			$n++;
		}
		echo $n." datasets written to json file ".$url."<br>";
	}
}
?>
