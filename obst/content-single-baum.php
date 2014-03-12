<?php
/**
 * @package obst
 */

function startsWith($haystack, $needle){
    return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle){
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}

function getReife($date) {
	if (startsWith($date, '01')) $d = 'Anfang';
	else if (startsWith($date, '15')) $d = 'Mitte';
	else if (startsWith($date, '30') || startsWith($date, '31')) $d = 'Ende';

	$month = substr($date, 3);
	$d .= ' '.__( date("F", mktime(0, 0, 0, $month, 10)) );
	return $d;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<!--<script type='text/javascript' src='http://linz.pflueckt.at/wp-content/plugins/comment-images/js/plugin.min.js?ver=3.5.1'></script>-->

<?php
echo '<script type="text/javascript">
					jQuery(document).ready(function($) {
						console.log("ok");
						$("#commentform").attr("enctype", "multipart/form-data");
					});
					</script>';
?>

		<?php $id_value = get_post_meta(get_the_ID(), 'baumid', true); ?>

		<h1 class="entry-title"><?php the_title(); echo ' [#'.$id_value."]"; ?></h1>

		<?php
		 $args = array(
		   'post_type' => 'attachment',
		   'numberposts' => -1,
		   'post_status' => null,
		   'post_parent' => $post->ID
		  );

		  $attachments = get_posts( $args );
			 if ( $attachments ) {
				echo '<div id="rotator" style="float:right">';
				foreach ( $attachments as $attachment ) {
				   echo wp_get_attachment_image( $attachment->ID, 'thumbnail', false, array(
						'title'	=> apply_filters( 'the_title', $attachment->post_title ),
						'class'	=> "attachment-thumbnail",
						'alt'   => trim(strip_tags( get_post_meta($attachment->ID, '_wp_attachment_image_alt', true) )),
					));
				  }
				echo '</div>';
				echo '<script type="text/javascript">
					jQuery(document).ready(function($) {
						if ($("#rotator").children().length) {
							$("#rotator").cycle({ 
								fx: "fade",
								timeout: 5000,
								speed: 1000,
								pause: 1,
								fit: 1
							});
						}
					});
					</script>';
			 }
		 ?>

		<?php echo '<img style="float:right; margin-right:20px;" src="/static/leaflet051/images/leaf-'.get_post_meta(get_the_ID(), 'kat', true).'.png" />'; ?>

		<?php 
			//get values
			$lat_value = get_post_meta(get_the_ID(), 'lat', true);
			$long_value = get_post_meta(get_the_ID(), 'long', true);
			$id_value2 = $id_value - 1;
			//Gattung
			$gattung_value = get_post_meta(get_the_ID(), 'gattung', true);
			$art_value = get_post_meta(get_the_ID(), 'art', true);
			if ($art_value == '.') $art_value = '';
			if($gattung_value != '' || $art_value != '') echo "<p>" . ucfirst($gattung_value) . " " . $art_value . "</p>"; 
			//Sorte
			$sorte_value = get_post_meta(get_the_ID(), 'sorte', true);
			if ($sorte_value == '.') $sorte_value = '';
			if($sorte_value != '') echo "<p>Sorte: " . ucfirst($sorte_value) . "</p>"; 
			echo '<br />';
			//Reif von
			$date1_value = get_post_meta(get_the_ID(), 'reifvon', true);
			if($date1_value != '') echo "<p>Reif von " . getReife($date1_value); 
			//Reif bis
			$date2_value = get_post_meta(get_the_ID(), 'reifbis', true);
			if($date2_value != '') echo " bis " . getReife($date2_value) . "</p>"; 				
			echo '<br />';
			//Baumhöhe
			$baumhoehe_value = get_post_meta(get_the_ID(), 'baumhoehe', true);
			if($baumhoehe_value != '' && $baumhoehe_value != '.') echo "<p>Baumhöhe: " . $baumhoehe_value . " m, "; 
			//Schirmdurchmesser
			$schirmdurchmesser_value = get_post_meta(get_the_ID(), 'schirmdurchmesser', true);
			if($schirmdurchmesser_value != '' && $schirmdurchmesser_value != '.') echo "Schirmdurchmesser: " . $schirmdurchmesser_value . " m, "; 
			//Stammumfang
			$stammumfang_value = get_post_meta(get_the_ID(), 'stammumfang', true);
			if($stammumfang_value != '' && $stammumfang_value != '.') echo "Stammumfang: " . $stammumfang_value . " cm</p><br />"; 

			//Anzeigebutton
			echo '<p><a class="abutton" href="'.esc_url( home_url( '/' ) ).'" onclick="map.setView(new L.LatLng('.$lat_value.','.$long_value.'), 18, false);map.on(\'zoomend\', function(e) {markersArray['.$id_value2.'].openPopup()});">Zeige #'.$id_value.'</a></p><br />';
		
			//Koordinaten
			echo '<p>Koordinaten:';
			if($lat_value != '' && $long_value != '') echo ' N ' . round($lat_value,5) . ' E ' . round($long_value,5);

			//URL
			$url = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			echo '</p><p><a href="'.$url.'">'.$url.'</a></p>';
		?>
		</ul>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'obst' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
