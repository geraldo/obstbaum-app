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

			<h3>Beste Bäume</h3>
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

			<h3>Aktivste Benutzer</h3>
			<?php 
				$query = "SELECT COUNT(comment_author) AS comment_comments, comment_author, comment_author_url FROM $wpdb->comments GROUP BY comment_author ORDER BY comment_comments DESC LIMIT 10";
				$authors = $wpdb->get_results($query);
				if ($authors) {
					echo '<ol>';
					foreach ($authors as $author) {
						echo '<li>';
						show_user($author->comment_author, $author->comment_author_url);
						echo ': '.$author->comment_comments.' Kommentar';
						echo ($author->comment_comments<>1) ? 'e' : '';
						echo '</li>';
					}
					echo '</ol>';
				}
			?>

			<h3>Aktivste Bäume</h3>
			<?php 
				$query = "SELECT ID,post_title,comment_count FROM $wpdb->posts WHERE post_type='baum' AND comment_count<>0 ORDER BY comment_count DESC LIMIT 10";
				$baeume = $wpdb->get_results($query);
				if ($baeume) {
					echo '<ol>';
					foreach ($baeume as $baum) {
						$id = $baum->ID-899;
						echo '<li><a href="'.esc_url( home_url( '/' ) ).'baum/'.$id.'">'.$baum->post_title.'</a>: ';
						echo $baum->comment_count.' Kommentar';
						echo ($baum->comment_count<>1) ? 'e' : '';
						echo '</li>';
					}
					echo '</ol>';
				}
			?>

			<h3>Neueste Kommentare</h3>
			<ul>
			<?php 
				$comments = get_comments('number=10');
				foreach($comments as $comment) :
					echo '<li>';
					show_user($comment->comment_author, $comment->comment_author_url);
					echo ' sagt am ';
					echo date(" j.n.Y", strtotime($comment->comment_date_gmt));
					echo ' über ';
					$baum = get_post($comment->comment_post_ID);
					echo '<a href="'.esc_url( home_url( '/' ) ).'baum/'.$baum->post_name.'">'.$baum->post_title.'</a>';
					echo '<br />'.strip_tags($comment->comment_content);
					echo '</li>';
				endforeach;
			?>
			</ul>

			<h3>Neueste Benutzer</h3>
			<ul>
			<?php
				$blogusers = get_users('blog_id=1&orderby=ID&order=DESC&role=subscriber&number=10');
				foreach ($blogusers as $user) {
					echo '<li>';
					show_user($user->user_nicename, $user->user_url, $user->first_name, $user->last_name);
					echo date(" [j.n.Y", strtotime($user->user_registered)).']';
					echo '</li>';
				}
			?>
			</ul>

			<!--<h3>Neueste Bewertungen</h3>
			<?php 
				//wp_gdsr_render_rating_results(array('template_id' => 48, 'select' => 'baum', 'min_votes' => 1));
			?>-->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php
	function show_user($name, $url, $first=null, $last=null) {
		if ($url && $url != "") echo '<a href="'.$url.'">'.$name.'</a>';
		else echo $name;
		if ($first || $last) echo ' ('.$first.' '.$last.')';
	}
?>

<?php //get_footer(); ?>
