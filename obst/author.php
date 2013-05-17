<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package obst
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<a class="close-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">×</a>

			<?php
			$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

			"<h3>Benutzername: ".$curauth->nickname."</h3>";

			$current_user = wp_get_current_user(); if ( $current_user->ID == $curauth->ID ) : ?>
				<p>Hallo <?php echo $curauth->nickname; ?>, <a href="<?php esc_url( home_url( '/' ) ); ?>wp-admin/profile.php">bearbeite dein Profil</a>.</p>
				<p><a href="<?php esc_url( home_url( '/' ) ); ?>wp-login.php?action=logout">Abmelden</a></p>
				<hr>
			<?php endif; ?>

			<h3><?php echo $curauth->nickname; ?></h3>

			<p><strong>Name:</strong> <?php echo $curauth->user_firstname." ".$curauth->user_lastname; ?></p>
		
			<p><strong>Webseite:</strong> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
		
			<p><strong>Über mich:</strong> <?php echo $curauth->user_description; ?></p>

			<h3>Aktivitäten</h3>

			<p><strong>Bewertungen:</strong></p>

			<p><strong>Kommentare:</strong></p>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
