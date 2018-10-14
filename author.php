<?php get_header(); 
$bunny_curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
?>
	<h1 class="archive-title"><?php printf( __('About %s','bunny'), $bunny_curauth->display_name); ?></h1>
		<div class="author-info">
			<div class="author-avatar">
				<?php
				if (get_avatar($bunny_curauth->user_email, 60)){
					echo get_avatar($bunny_curauth->user_email, 60); 
				}else{
					echo '<i class="avataroff fa"></i>';
				}
				?>
				</div>
				<div class="author-description">
					<?php echo $bunny_curauth->description;	?>
				</div>
			</div>
		<h1 class="archive-title"><?php printf( __( 'View all posts by %s', 'bunny' ), $bunny_curauth->display_name ); ?></h1>
		<?php
		while ( have_posts() ) : the_post(); ?> 
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<div class="post-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(get_option('date_format'));?></a></div>
			    <?php bunny_breadcrumbs();?>
					<?php
					if (strpos($post->post_content,'[gallery') === false){
					   if ( has_post_thumbnail()) {
							the_post_thumbnail();
					   }
					}
					the_content(); 
					wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages: ', 'bunny' ), 'after' => '</div>' ) ); 
					bunny_meta();
					?>						
			</div>
<?php
endwhile; 
next_posts_link('<div class="newer-posts">'. __('Next page &rarr;', 'bunny') . '</div>'); 
previous_posts_link('<div class="older-posts">' . __('&larr; Previous page','bunny') . '</div>'); 
get_footer();
?> 