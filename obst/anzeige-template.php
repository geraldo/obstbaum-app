<?php
/**
 * Template Name: Anzeige
 *
 * @package obst
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<a class="close-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">×</a>

			<h3>Anzeige/Filter</h3>

				<p>Welche Bäume sollen angezeigt werden?</p>
				<br />
				<form id="filter">
				<p><input type="checkbox" checked="checked" value="Apfel" onchange="jQuery(function($){var cats=new Array();$('input:checked:not(input[value=Keine]):not(input[value=Alle])').each(function(){cats.push($(this).val());});showLayers(cats);});" /> Äpfel</p>
				<p><input type="checkbox" checked="checked" value="Birne" onchange="jQuery(function($){var cats=new Array();$('input:checked:not(input[value=Keine]):not(input[value=Alle])').each(function(){cats.push($(this).val());});showLayers(cats);});" /> Birnen</p>
				<p><input type="checkbox" checked="checked" value="Kastanie" onchange="jQuery(function($){var cats=new Array();$('input:checked:not(input[value=Keine]):not(input[value=Alle])').each(function(){cats.push($(this).val());});showLayers(cats);});" /> Edelkastanien</p>
				<p><input type="checkbox" checked="checked" value="Kirsche" onchange="jQuery(function($){var cats=new Array();$('input:checked:not(input[value=Keine]):not(input[value=Alle])').each(function(){cats.push($(this).val());});showLayers(cats);});" /> Kirschen</p>
				<p><input type="checkbox" checked="checked" value="Nuesse" onchange="jQuery(function($){var cats=new Array();$('input:checked:not(input[value=Keine]):not(input[value=Alle])').each(function(){cats.push($(this).val());});showLayers(cats);});" /> Nüsse</p>
				<p><input type="checkbox" checked="checked" value="Zwetschke" onchange="jQuery(function($){var cats=new Array();$('input:checked:not(input[value=Keine]):not(input[value=Alle])').each(function(){cats.push($(this).val());});showLayers(cats);});" /> Zwetschken</p>
				<br />
				<p><input type="checkbox" checked="checked" value="Sonstiges" onchange="jQuery(function($){var cats=new Array();$('input:checked:not(input[value=Keine]):not(input[value=Alle])').each(function(){cats.push($(this).val());});showLayers(cats);});" /> Sonstige</p>
				<br />
				<p><button type="button" onclick="jQuery(function($){$('#filter').find(':checkbox').prop('checked', 'checked');$('#filter').find('input[value=Keine]').prop('checked', '');showLayers(['Apfel','Birne','Kastanie','Kirsche','Nuesse','Sonstiges','Zwetschke']);});">Alle</button> 
				<button type="button" onclick="jQuery(function($){$('#filter').find(':checkbox').prop('checked', '');$('#filter').find('input[value=Keine]').prop('checked', 'checked');map.removeLayer(markers);});">Keine</button></p>
				<br />
				<p><a class="abutton" href="<?php echo esc_url( home_url( '/' ) ); ?>">Anzeigen</a></p>
				</form>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php //get_footer(); ?>
