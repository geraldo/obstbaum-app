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

		<h1 class="entry-title">Baum <?php $id_value = get_post_meta(get_the_ID(), 'baumid', true); echo $id_value.": "; the_title(); ?></h1>

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
			//Art
			$art_value = get_post_meta(get_the_ID(), 'art', true);
			if($art_value != '' && $art_value != '.') echo "<p>Art: " . ucfirst($art_value) . "</p>"; 
			//Gattung
			$gattung_value = get_post_meta(get_the_ID(), 'gattung', true);
			if($gattung_value != '' && $gattung_value != '.') echo "<p>Gattung: " . ucfirst($gattung_value) . "</p>"; 
			//Sorte
			$sorte_value = get_post_meta(get_the_ID(), 'sorte', true);
			if($sorte_value != '' && $sorte_value != '.') echo "<p>Sorte: " . ucfirst($sorte_value) . "</p>"; 
			//Kategorie
			$kat_value = get_post_meta(get_the_ID(), 'kat', true);
			if($kat_value != '' && $kat_value != '.') echo "<p>Kategorie: " . ucfirst($kat_value) . "</p>"; 
			echo '<br />';
			//Reif von
			$date1_value = get_post_meta(get_the_ID(), 'reifvon', true);
			if($date1_value != '' && $date1_value != '.') echo "<p>Reif von " . getReife($date1_value); 
			//Reif bis
			$date2_value = get_post_meta(get_the_ID(), 'reifbis', true);
			if($date2_value != '' && $date2_value != '.') echo " bis " . getReife($date2_value) . "</p>"; 				
			echo '<br />';
			//Baumhöhe
			$baumhoehe_value = get_post_meta(get_the_ID(), 'baumhoehe', true);
			if($baumhoehe_value != '' && $baumhoehe_value != '.') echo "<p>Baumhöhe: " . $baumhoehe_value . " m, "; 
			//Schirmdurchmesser
			$schirmdurchmesser_value = get_post_meta(get_the_ID(), 'schirmdurchmesser', true);
			if($schirmdurchmesser_value != '' && $schirmdurchmesser_value != '.') echo "Schirmdurchmesser: " . $schirmdurchmesser_value . " m, "; 
			//Stammumfang
			$stammumfang_value = get_post_meta(get_the_ID(), 'stammumfang', true);
			if($stammumfang_value != '' && $stammumfang_value != '.') echo "Stammumfang: " . $stammumfang_value . " cm</p>"; 
		
			//Koordinaten
			echo '<br /><p>Koordinaten:';
			$lat_value = get_post_meta(get_the_ID(), 'lat', true);
			$long_value = get_post_meta(get_the_ID(), 'long', true);
			$id_value2 = $id_value - 1;
			if($lat_value != '' && $long_value != '') echo ' N ' . round($lat_value,5) . ' E ' . round($long_value,5);
			echo ' <a class="abutton" href="'.esc_url( home_url( '/' ) ).'" onclick="map.setView(new L.LatLng('.$lat_value.','.$long_value.'), 18, false);map.on(\'zoomend\', function(e) {markersArray['.$id_value2.'].openPopup()});">Zeige Baum '.$id_value.'</a></p>';
			$url = 'http://'.$_SERVER["SERVER_NAME"].'/#'.$_SERVER["REQUEST_URI"];
			echo '<a href="'.$url.'">'.$url.'</a>';
		?>
		</ul>

		<div class="entry-meta">
			<?php //obst_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php //wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'obst' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'obst' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'obst' ) );

			if ( ! obst_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'obst' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'obst' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'obst' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'obst' );
				}

			} // end check for categories on this blog

			/*printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);*/
		?>

		<?php edit_post_link( __( 'Edit', 'obst' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
