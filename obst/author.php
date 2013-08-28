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

				$current_user = wp_get_current_user(); 

				if ( $current_user->ID == $curauth->ID ) {
					echo '<p>Hallo <em>'.$curauth->nickname.'</em>, <a href="'.esc_url( home_url( '/' ) ).'/wp-admin/profile.php">bearbeite dein Profil</a>.</p>';
					echo '<p><a href="'.esc_url( home_url( '/' ) ).'/wp-login.php?action=logout">Abmelden</a></p><hr>';
				}

				echo '<h3>'.$curauth->display_name;
				if (!empty($curauth->first_name) || !empty($curauth->last_name)) echo ' ('.$curauth->first_name.' '.$curauth->last_name.')';
				echo '</h3>';
				echo get_avatar( $curauth->ID, 100 );
				echo '<br />';

				if (!empty($curauth->user_firstname) || !empty($curauth->user_lastname)) {
					echo '<p><strong>Name:</strong> '.$curauth->user_firstname.' '.$curauth->user_lastname.'</p>';
				}
		
				if (!empty($curauth->user_url)) {
					echo '<p><strong>Webseite:</strong> <a href="'.$curauth->user_url.'">'.$curauth->user_url.'</a></p>';
				}
		
				if (!empty($curauth->user_description)) {
					echo '<p><strong>Über mich:</strong> '.$curauth->user_description.'</p>';
				}

			?>

			<br />
			<h3>Kommentare</h3>

			<?php 
				$args = array(
					'user_id' => $curauth->ID,
					'status' => 'approve'
				);
				$comments = get_comments($args);

				if ($comments) {

					echo '<ol>';
					foreach($comments as $comment) {
						echo '<li class="new_comment">';
						$post = get_post($comment->comment_post_ID);
						$type = $post->post_type;
						if ($type != 'baum' && $type != 'garten' && $type == 'post') {
							$type = 'blog';
						}
						//comment image
						$images = get_comment_meta($comment->comment_ID, 'comment_image', true);
						if ($images) {
							$args = array(
							   'post_type' => 'attachment',
							   'numberposts' => -1,
							   'post_status' => null,
							   'post_parent' => $post->ID,
							   'author' => $comment->user_id
							  );
							$imgs = get_posts( $args );
							if ($imgs) {
								foreach($imgs as $img) {
									if ($images['url'] == $img->guid) {
										echo wp_get_attachment_image( $img->ID, array(75,75), false, array(
											'title'	=> apply_filters( 'the_title', $img->post_title ),
											'class'	=> "attachment-thumbnail alignright",
											'alt'   => trim(strip_tags( get_post_meta($img->ID, '_wp_attachment_image_alt', true) )),
										));
									}
								}
							}
						}
						//comment
						echo '<em>';
						show_user($comment->comment_author);
						echo '</em> sagt am ';
						echo date(" j.n.Y", strtotime($comment->comment_date_gmt));
						echo ' über <em>';

						if ($type == 'baum')
							echo $post->post_title.' [<a href="'.esc_url( home_url( '/' ) ).$type.'/'.$post->post_name.'">#'.$post->post_name.'</a>]';
						else
							echo '<a href="'.esc_url( home_url( '/' ) ).$type.'/'.$post->post_name.'">'.$post->post_title.'</a>';

						echo '</em><br />'.apply_filters('the_content', $comment->comment_content);
						echo '</li>';
					}
					echo '</ol>';
				}
				else {
					echo '<p>Bisher noch keine</p>';
				}

			?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php
	function show_user($name, $first=null, $last=null) {
		echo $name;
		if ($first || $last) echo ' ('.$first.' '.$last.')';
	}
?>

<?php get_footer(); ?>
