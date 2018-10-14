jQuery(document).ready(function($) {
	$('#far-clouds').pan({fps: 30, speed: 0.5, dir: 'left', depth: 30});
	$('#near-clouds').pan({fps: 30, speed: 0.7, dir: 'right', depth: 70}); 
	$('#kaninf').sprite({fps: 1.8, no_of_frames: 8, speed: 1});
}); 

function arc($radius,$radius_tag) {
	var $headline = jQuery('#headline');
	var $tagline = jQuery('#tagline');
	WebFont.load({
		google: {
			families: ['Oswald','Open Sans Condensed']
			},
			fontactive:function(fontFamily, fontDescription) {
				init();
			},
			fontinactive:function(fontFamily, fontDescription) {
				init();
			}
		});
	function init() {
		$headline.show().arctext({radius: $radius});
		$tagline.show().arctext({radius: $radius_tag});
	};
};


	