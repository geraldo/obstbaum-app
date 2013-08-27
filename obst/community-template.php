<?php
/**
 * Template Name: Community
 *
 * @package obst
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<a class="close-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">×</a>

		<div class="entry-content">
			<div id="tabs">
			<ul>
			<li><a href="#tabs-1">PfückerInnen</a></li>
			<li><a href="#tabs-2">Bäume</a></li>
			<li><a href="#tabs-3">Kommentare</a></li>
			</ul>
			<div id="tabs-1">

				<h3><a name="aktivste-benutzer">Aktivste PfückerInnen</a></h3>
				<?php 
					$query = "SELECT COUNT(comment_author) AS comment_comments, comment_author, comment_author_url, user_id FROM $wpdb->comments WHERE comment_approved='1' GROUP BY comment_author ORDER BY comment_comments DESC LIMIT 10";
					$authors = $wpdb->get_results($query);

					if ($authors) {
						echo '<ol>';
						foreach ($authors as $author) {
							echo '<li>';
							show_user($author->comment_author, $author->comment_author_url);
							//count comments
							echo ': '.$author->comment_comments.' Kommentar';
							echo ($author->comment_comments<>1) ? 'e' : '';

							//count comment images
							$comments = get_comments(array('user_id' => $author->user_id));
							$num = 0;
							foreach ($comments as $comment) {
								$images = get_comment_meta($comment->comment_ID, 'comment_image', true);
								if ($images) $num++;
							}
							if ($num > 0) {
								echo ', ' . $num . ' Foto';
								echo ($num<>1) ? 's' : '';
							}

							//count votes
							$votes = $wpdb->get_var("SELECT COUNT(*) FROM wp_gdsr_votes_log WHERE user_id=$author->user_id");
							if ($votes > 0) {
								echo ', ' . $votes . ' Bewertung';
								echo ($votes<>1) ? 'en' : '';
							}

							echo '</li>';
						}
						echo '</ol>';
					}
				?>

				<h3><a name="neueste-benutzer">Neueste PfückerInnen</a></h3>
				<ol>
				<?php
					$blogusers = get_users('blog_id=1&orderby=ID&order=DESC&role=subscriber&number=10');
					foreach ($blogusers as $user) {
						echo '<li>';
						show_user($user->user_nicename, $user->user_url, $user->first_name, $user->last_name);
						echo date(" [j.n.Y", strtotime($user->user_registered)).']';
						echo '</li>';
					}
				?>
				</ol>

				</div>
				<div id="tabs-2">

				<h3><a name="interessante-baeume">Interessanteste Bäume</a></h3>
				<?php 
					$query = "SELECT ID,post_title,comment_count FROM $wpdb->posts WHERE post_type='baum' AND comment_count<>0 ORDER BY comment_count DESC LIMIT 10";
					$baeume = $wpdb->get_results($query);
					if ($baeume) {
						echo '<ol>';
						foreach ($baeume as $baum) {
							$id = $baum->ID-899;
							//count comments
							echo '<li>'.$baum->post_title.' [<a href="'.esc_url( home_url( '/' ) ).'baum/'.$id.'">#'.$id.'</a>]: ';
							echo $baum->comment_count.' Kommentar';
							echo ($baum->comment_count<>1) ? 'e' : '';

							//count comment images
							$comments = get_comments(array('post_id' => $baum->ID));
							$num = 0;
							foreach ($comments as $comment) {
								$images = get_comment_meta($comment->comment_ID, 'comment_image', true);
								if ($images) $num++;
							}
							if ($num > 0) {
								echo ', ' . $num . ' Foto';
								echo ($num<>1) ? 's' : '';
							}

							//count votes
							$votes = $wpdb->get_var("SELECT COUNT(*) FROM wp_gdsr_votes_log WHERE id=$baum->ID");
							if ($votes > 0) {
								echo ', ' . $votes . ' Bewertung';
								echo ($votes<>1) ? 'en' : '';
							}
							echo '</li>';
						}
						echo '</ol>';
					}
				?>

				<h3><a name="obstbaumgaerten">Obstbaumgärten</a></h3>
				<?php 
					$query = "SELECT ID,post_title,comment_count,post_name FROM $wpdb->posts WHERE post_type='garten' ORDER BY comment_count DESC LIMIT 10";
					$gaerten = $wpdb->get_results($query);
					if ($gaerten) {
						echo '<ol>';
						foreach ($gaerten as $garten) {
							$url = $garten->post_name;
							//count comments
							echo '<li><a href="'.esc_url( home_url( '/' ) ).'garten/'.$url.'">'.$garten->post_title.'</a>';
							if ($garten->comment_count > 0) {
								echo ': '.$garten->comment_count.' Kommentar';
								echo ': '.($garten->comment_count<>1) ? 'e' : '';
							}

							//count comment images
							$comments = get_comments(array('post_id' => $garten->ID));
							$num = 0;
							foreach ($comments as $comment) {
								$images = get_comment_meta($comment->comment_ID, 'comment_image', true);
								if ($images) $num++;
							}
							if ($num > 0) {
								echo ', ' . $num . ' Foto';
								echo ($num<>1) ? 's' : '';
							}
							echo '</li>';
						}
						echo '</ol>';
					}
				?>

				<h3><a name="beste-fruechte">Beste Früchte</a></h3>
				<?php 
					wp_gdsr_render_rating_results(array('template_id' => 48, 'select' => 'baum', 'rows' => 10, 'min_votes' => 1));
				?>
				<?php 
					/*query_posts(array('gdsr_sort' => 'rating', 'gdsr_order' => 'DESC', 'showposts' => 10)); 
					while ( have_posts() ) : the_post();
						echo '<li>';
						the_title();
						echo '</li>';
					endwhile;
					wp_reset_query();*/
				?>

				<!--<h3>Neueste Bewertungen</h3>
				<?php 
					//wp_gdsr_render_rating_results(array('template_id' => 48, 'select' => 'baum', 'min_votes' => 1));
				?>-->

				</div>
				<div id="tabs-3">

				<h3><a name="kommentare">Neueste Kommentare</a></h3>
				<ol>
				<?php 
					$args = array(
						'status' => 'approve',
						'number' => '10'
					);
					$comments = get_comments($args);
					foreach($comments as $comment) :
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
						echo get_avatar( $comment, 40 );
						echo '<em>';
						show_user($comment->comment_author, $comment->comment_author_url);
						echo '</em> sagt am ';
						echo date(" j.n.Y", strtotime($comment->comment_date_gmt));
						echo ' über <em>';
						echo $post->post_title.' [<a href="'.esc_url( home_url( '/' ) ).$type.'/'.$post->post_name.'">#'.$post->post_name.'</a>]';
						echo '</em><br />'.apply_filters('the_content', $comment->comment_content);
						echo '</li>';
					endforeach;
				?>
				</ol>

				</div>
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#tabs").tabs();
	});
</script>


<?php
	function show_user($name, $url, $first=null, $last=null) {
		if ($url && $url != "") echo '<a href="'.$url.'">'.$name.'</a>';
		else echo $name;
		if ($first || $last) echo ' ('.$first.' '.$last.')';
	}
?>

<?php get_footer(); ?>
