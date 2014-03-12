/*
	http://www.deluxeblogtips.com/2010/05/how-to-ajaxify-wordpress-theme.html
*/

jQuery(document).ready(function($) {
	$('#menu-top li').click(function() {
		$('#menu-top li').each(function() {
			$(this).removeClass('current-menu-item');
		});
		$(this).addClass('current-menu-item');
	});

    var $mainContent = $("#primary"),
    siteUrl = top.location.protocol.toString() + "//" + top.location.host.toString(),
    url = '';
	$(document).on("click", "a[href^='"+siteUrl+"']:not([href*='/wp-admin/']):not([href*='/wp-login.php']):not([href$='/feed/']):not([href*='/wp-content/uploads/']):not([href*='/wp-content/plugins/'])", function() {
		if ($.browser.msie && $.browser.version != 10.0) {
			var myie = "/" + this.pathname;
			location.hash = myie;
		}
		else {
			location.hash = this.pathname;
		}
		return false;
	});
    $("#searchform").submit(function(e) {
		location.hash = '?s=' + $("#s").val();
		e.preventDefault();
    });
    $(window).bind('hashchange', function(){
		url = window.location.hash.substring(1);
		if (!url || url.indexOf("comment")!= -1 || url.indexOf("respond")!= -1 || url.indexOf("wpcf7")!= -1) {
			return;
		}
		url = url + " #content";
		$mainContent.animate({opacity: "0.1"}).html('<img style="padding:20px;" src="http://linz.pflueckt.at/wp-content/themes/obst/images/ajax-loader.gif" />').load(url, function() {
			$mainContent.animate({opacity: "1"});

			//rebind javascript functions when loaded!
			//jQuery(document).ready() doesn't get triggered using AJAX

			//rating
			$(".gdsr_rating_as > a").on("click", function(){gdsr_rating_standard(this)});

			//cycle
			if ($("#rotator").children().length) {
				$("#rotator").cycle({ 
					fx: "fade",
					timeout: 5000,
					speed: 1000,
					pause: 1,
					fit: 1
				});
			}

			//tabs
			$("#tabs").tabs();

			//blog
			if (url.indexOf("blog")!= -1) {
				$("p").each(function() {
					$(this).css('margin-bottom','20px');
				});
			}

			//datatable
			if (url.indexOf("suche")!= -1) {
				$('#primary').css('width','980');
				//load js
				$.getScript(window.location.protocol+"//"+window.location.host+"/wp-content/themes/obst/js/jquery.dataTables.min.js")
					.done(function(script, textStatus) {
						//console.log( textStatus );

						//apply data table
						$('#obsttable').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="obst"></table>' );
						$('#obst').dataTable( {
							"aaData": obst,
							"aoColumns": [
								{ "sTitle": "#" },
								{ "sTitle": "Name" },
								{ "sTitle": "lat", "bSearchable": false, "bVisible": false },
								{ "sTitle": "long", "bSearchable": false, "bVisible": false },
								{ "sTitle": "Botanischer Name" },
								{ "sTitle": "Sorte" },
								{ "sTitle": "Kategorie" },
								{ "sTitle": "Bewertung" },
								{ "sTitle": "Kommentare" },
								{ "sTitle": "Fotos" },
								{ "bSearchable": false, "sWidth": "75px", "bSortable": false, "fnRender": function(oObj) { var id=oObj.aData[0]-1; return '<a class="abutton" href="http://linz.pflueckt.at/" onclick="map.setView(new L.LatLng('+oObj.aData[2]+','+oObj.aData[3]+'), 18, false);map.on(\'zoomend\', function(e) {markersArray['+id+'].openPopup()});">Zeige #'+oObj.aData[0]+'</a>'; } }
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
							"aaSorting": [[ 8, "desc" ]],
							"sPaginationType": "full_numbers",
							"bAutoWidth": false
						} );

					})
					.fail(function(jqxhr, settings, exception) {
					//console.log( "Triggered ajaxError handler. "+exception );
				});
			}
			else {
				var w = $(window).width();
				if (w>600) $('#primary').css('width','600');
				else $('#primary').css('width',w);
			}
		});
    });
    $(window).trigger('hashchange');
});

