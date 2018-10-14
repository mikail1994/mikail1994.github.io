<?php get_header(); ?>
	<div class="search-post">
		<h1 class="post-title"><?php printf( __( 'Search Results for: %s', 'bunny'), get_search_query()); ?></h1>		
		<?php get_search_form(); ?>
		<br/>
	</div>
			<?php while ( have_posts() ) : the_post(); ?> 					
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<div class="post-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(get_option('date_format'));?></a></div>
				<?php bunny_breadcrumbs();?>					
				<?php   if (strpos($post->post_content,'[gallery') === false){
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
get_footer(); ?> 