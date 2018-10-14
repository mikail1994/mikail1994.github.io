<?php get_header(); ?>
	<?php
		while (have_posts() ) : the_post(); 
			get_template_part( 'content', get_post_format() ); 
		endwhile; 
			
		if( get_next_posts_link() ){
			echo '<div class="newer-posts">';
			next_posts_link(__('Next page &rarr;', 'bunny'));
			echo '</div>'; 
		}
		if( get_previous_posts_link() ){
			echo '<div class="older-posts">';
			previous_posts_link(__('&larr; Previous page','bunny'));
			echo '</div>'; 
		}
		?>
<?php get_footer(); ?>