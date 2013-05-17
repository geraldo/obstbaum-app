<?php
/**
 * The Template for displaying all single posts.
 *
 * @package obst
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<a class="close-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">×</a>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single-baum' ); ?>

			<?php //obst_content_nav( 'nav-below' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
