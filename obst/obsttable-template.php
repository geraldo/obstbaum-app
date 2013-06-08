<?php
/**
 * Template Name: Obsttable
 *
 * @package obst
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<a class="close-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">×</a>

			<div class="entry-content">

				<style type="text/css" title="currentStyle">
					@import "<?php echo get_stylesheet_directory_uri(); ?>/layouts/demo_table.css";
				</style>
				<script type="text/javascript" language="javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.dataTables.min.js"></script>
				<script type="text/javascript" language="javascript" src="<?php echo esc_url( home_url( '/' ) ); ?>static/obstTable.js"></script>

				<div id="obsttable"></div>

			</div>

		</div><!-- #content -->
	</div><!-- #primary -->

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#obsttable').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="obst"></table>' );
		$('#obst').dataTable( {
			"aaData": obst,
			"aoColumns": [
				{ "sTitle": "#" },
				{ "sTitle": "Titel" },
				{ "sTitle": "lat", "bSearchable": false, "bVisible": false },
				{ "sTitle": "long", "bSearchable": false, "bVisible": false },
				{ "sTitle": "Botanischer Name" },
				{ "sTitle": "Sorte" },
				{ "sTitle": "Kategorie" },
				{ "bSearchable": false, "bSortable": false, "fnRender": function(oObj) { var id=oObj.aData[0]-1; return '<a class="abutton" href="<?php echo esc_url( home_url( "/" ) ) ?>" onclick="map.setView(new L.LatLng('+oObj.aData[2]+','+oObj.aData[3]+'), 18, false);map.on(\'zoomend\', function(e) {markersArray['+id+'].openPopup()});">Zeige #'+oObj.aData[0]+'</a>'; } }
			],
			"oLanguage": {
						"sLengthMenu": "Zeige _MENU_ Datensätze pro Seite",
						"sZeroRecords": "Nichts gefunden - sorry",
						"sInfo": "Zeigt _START_ bis _END_ von _TOTAL_ Datensätzen",
						"sInfoEmpty": "Zeigt 0 bis 0 von 0 Datensätzen",
						"sInfoFiltered": "(gefiltert von insgesamt _MAX_ Datensätzen)",
						"sSearch" : "Suche:",
						"oPaginate": {
								"sPrevious": "Vorige Seite",
								"sNext": "Nächste Seite",
								"sFirst": "Erste Seite",
								"sLast": "Letzte Seite"
							  }
					},
			"aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
			"iDisplayLength": 20,
			"sPaginationType": "full_numbers",
			"bAutoWidth": false
		} );	
	});
</script>

<?php get_footer(); ?>
