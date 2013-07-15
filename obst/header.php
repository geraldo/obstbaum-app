<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package obst
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<link rel="stylesheet" href="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/leaflet.css" />
	<link rel="stylesheet" href="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/MarkerCluster.css" />
	<link rel="stylesheet" href="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/MarkerCluster.Default.css" />
	<link rel="stylesheet" href="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/L.Control.Locate.css" />

	<!--[if lte IE 8]>
		<link rel="stylesheet" href="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/leaflet.ie.css" />
		<link rel="stylesheet" href="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/MarkerCluster.Default.ie.css" />
		<link rel="stylesheet" href="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/L.Control.Locate.ie.css"/>
	<![endif]-->

	<script src="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/leaflet.js"></script>
	<script src="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/leaflet.markercluster-src.js"></script>
	<script src="<?php echo esc_url( home_url( '/' ) ); ?>static/leaflet051/L.Control.Locate.js" ></script>

	<script src="<?php echo esc_url( home_url( '/' ) ); ?>static/obst.js" type="text/javascript"></script>
	<?php wp_head(); ?>
	<script src="<?php echo esc_url( home_url( '/' ) ); ?>static/map.php" type="text/javascript"></script>
</head>

<body <?php body_class(); ?> onload="loadMap();">
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>

	<header id="masthead" class="site-header" role="banner">
		<nav id="site-navigation" class="navigation-main" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Menü', 'obst' ); ?></h1>
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'obst' ); ?>"><?php _e( 'Skip to content', 'obst' ); ?></a></div>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="main" class="site-main">

	<div id="map"></div>

