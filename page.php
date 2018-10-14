<?php get_header(); ?>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="post-title"><?php the_title(); ?></h1>
				<?php 
				bunny_breadcrumbs();
				the_content();
				wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages: ', 'bunny' ), 'after' => '</div>' ) );
				?>					
				<br />
				<div class="page-link"><?php edit_post_link(' <i class="edit-links fa"></i> '); ?></div>
			</div>
<?php
endwhile;
comments_template( '', true );
get_footer(); 
?>