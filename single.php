<?php get_header(); ?>
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="post-title"><?php the_title(); ?></h1>
				<div class="post-date"><?php echo get_the_date(get_option('date_format'));?></div>
				<?php
				if ( is_attachment() ) {
					echo '<div class="fullimg">' . wp_get_attachment_image('','full'). '</div>';
					if ( ! empty( $post->post_excerpt ) ) :
							echo '<br /><p>' . the_excerpt() .'</p>';
					endif; 					
					next_image_link();
					previous_image_link();
				} else {
					the_content();
					wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages: ', 'bunny' ), 'after' => '</div>' ) ); 
					}
				bunny_meta();
				?>	
			</div>
<?php
endwhile;
next_post_link('<div class="newer-posts">%link &rarr;</div>');
previous_post_link('<div class="older-posts">&larr; %link </div>');
comments_template( '', true ); 
get_footer(); 
?>