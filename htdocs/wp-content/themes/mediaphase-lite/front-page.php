<?php
/**
 * Front page template - show either custom page, or default posts page
 *
 * @package mediaphase
 */

if ( 'page' === get_option( 'show_on_front' ) ) :
	get_header();

	get_template_part( 'inc/partials/content', 'home-hero' );
	get_template_part( 'inc/partials/content', 'home-top-ribbon' );
	get_template_part( 'inc/partials/content', 'home-main-features' );
	get_template_part( 'inc/partials/content', 'home-sub-features' );
	get_template_part( 'inc/partials/content', 'home-about-us' );
	get_template_part( 'inc/partials/content', 'home-middle-ribbon' );
	get_template_part( 'inc/partials/content', 'home-team' );
	get_template_part( 'inc/partials/content', 'home-news' );
	get_template_part( 'inc/partials/content', 'home-bottom-ribbon' );
	get_template_part( 'inc/partials/content', 'home-logos' );

	get_footer();
else :
	include( get_home_template() );
endif;
