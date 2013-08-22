<?php
/**
	Template Name: Export
*/

$url = '/var/www/vhosts/linzwiki.at/obst/wp-content/export/obstexport.tmp.js';
//$foutput = (file_exists($url)) ? fopen($url, "w") : fopen($url, "w+");
$foutput = fopen($url, "w");
fwrite($foutput, 'var obst = ['.PHP_EOL);

//total amount: wp_count_posts('baum')->publish = 2095

writeBaumJS($foutput, 700, 0);
writeBaumJS($foutput, 700, 700);
writeBaumJS($foutput, 695, 1400);

//stop to write geojson file
fwrite($foutput, '];'.PHP_EOL);
fclose($foutput);

function writeBaumJS($foutput, $num, $offset) {

	$my_query = new WP_Query('post_type=baum&posts_per_page='.$num.'&offset='.$offset.'&order=ASC&orderby=ID');

	if ( have_posts() ) {

		$n = $offset+1;

		while ($my_query->have_posts()) {

			$my_query->the_post();

			//$id = get_post_meta(get_the_ID(), 'baumid', true);
			$titel = get_the_title();
			$lat = get_post_meta(get_the_ID(), 'lat', true);
			$long = get_post_meta(get_the_ID(), 'long', true);
			$gattung = ucfirst(get_post_meta(get_the_ID(), 'gattung', true));
			$art = get_post_meta(get_the_ID(), 'art', true);
			if ($art == '.' || $art == '') $art = '';
			else $art = ' '.$art;
			$sorte = ucfirst(get_post_meta(get_the_ID(), 'sorte', true));
			$kategorie = ucfirst(get_post_meta(get_the_ID(), 'kat', true));

			//get rating
			$rating = wp_gdsr_rating_article(get_the_ID())->rating;
			//get comment count
			$comments = get_post(get_the_ID())->comment_count;
			//get foto count
			$coms = get_comments(array('post_id' => get_the_ID()));
			$fotos = 0;
			foreach ($coms as $com) {
				$images = get_comment_meta($com->comment_ID, 'comment_image', true);
				if ($images) $fotos++;
			}

			fwrite($foutput, "[".$n.", '".$titel."', ".$lat.", ".$long.", '".$gattung.$art."', '".$sorte."', '".$kategorie."', ".$rating.", ".$comments.", ".$fotos.", ''],".PHP_EOL);	

			$n++;
		}
		echo $n." datasets written to json file ".$url."<br>";
	}
}
?>
