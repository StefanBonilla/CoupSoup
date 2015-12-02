<?php 
	add_action( 'flaton_credits', 'flaton_display_credits' );

	function flaton_display_credits() { 
		printf( __('Proudly powered by %s', 'flaton'), '<a href="http://wordpress.org">WordPress</a>'); ?>
		<span class="sep"> | </span>
		<?php printf( __( 'Theme: %1$s by %2$s', 'flaton' ), 'FlatOn', '<a href="http://www.webulousthemes.com/" rel="designer">Webulous Themes</a>' );
	}