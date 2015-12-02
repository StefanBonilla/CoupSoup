<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
				get_template_part( 'inc/partials/content', 'page' );
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;
			?>
		</div>
	</div>

<?php
get_template_part( 'inc/partials/content', 'home-bottom-ribbon' );
get_template_part( 'inc/partials/content', 'home-logos' );

get_footer();
