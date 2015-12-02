<?php
/**
 * The template for displaying all single posts.
 *
 * @package mediaphase
 */


get_header();
get_template_part( 'inc/partials/content', 'inner-navigation' );
?>

	<div id="main">
		<div class="wrap">
			<?php
			get_sidebar();

			while ( have_posts() ) :
				the_post();
				get_template_part( 'inc/partials/content', 'single' );
				get_template_part( 'inc/partials/content', 'authorbox' );
				comments_template();

			endwhile;
			?>
		</div>
	</div>

<?php
get_template_part( 'inc/partials/content', 'home-bottom-ribbon' );
get_template_part( 'inc/partials/content', 'home-logos' );

get_footer();