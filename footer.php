</div>
<?php 
	if (is_active_sidebar(1)){
	echo '<div class="footer"><ul>';
		dynamic_sidebar(1);
	echo '</ul></div>';
	}
?>
<div class="clear"></div>
<div id="kaninsmall" class="kaninsmall"></div>
<?php
/*Add easter eggs*/
if( get_theme_mod( 'bunny_easter_eggs' ) <> '') {
	echo '<div class="egg2"></div>
	<div class="egg1"></div>';		
}

wp_footer(); ?>
</body>
</html>