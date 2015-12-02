<?php
/**
 * The template for displaying search results pages.
 *
 * @package mediaphase
 */


get_header();
get_template_part( 'inc/partials/content', 'inner-navigation-search' );
?>

	<div id="main">
		<?php
		get_sidebar();
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'inc/partials/content', 'blog-default' );
			endwhile;
			mediaphase_pagination();
		else :
			get_template_part( 'inc/partials/content', 'none' );
		endif;
		?>
	</div><!-- #main -->

<?php
get_template_part( 'inc/partials/content', 'home-bottom-ribbon' );
get_template_part( 'inc/partials/content', 'home-logos' );

get_footer();
