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
	$(document).on("click", "a[href^='"+siteUrl+"']:not([href*='/wp-admin/']):not([href*='/wp-login.php']):not([href$='/feed/'])", function() {
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
			//rebind when loaded!
			$(".gdsr_rating_as > a").on("click", function(){gdsr_rating_standard(this)});
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
    });
    $(window).trigger('hashchange');
});

