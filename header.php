<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="header">
	<div id="header-menu" class="menu-background" role="navigation"><?php wp_nav_menu( array( 'theme_location' => 'header' ) ); ?></div>
	<div class="logo"><img src="<?php echo get_template_directory_uri()?>/images/cloud-large.png" height="146px" width="316px" alt="<?php wp_title( '|', true, 'right' ); ?>" /></div>
	<h1 class="site-title" id="headline"><?php bloginfo( 'name' ); ?></h1>
	<h2 class="site-description" id="tagline"><?php bloginfo( 'description' ); ?></h2>
</div>

<div id="sol" class="sol"></div>
<div id="far-clouds" class="far-clouds stage"></div>
<div id="near-clouds" class="near-clouds stage"></div>

<div id="kaninf" class="kaninf"></div>
<div id="grass" class="grass"></div>
<div class="wrapper">
