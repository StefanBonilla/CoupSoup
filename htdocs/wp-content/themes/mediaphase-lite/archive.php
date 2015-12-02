<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */

get_header();

get_template_part( 'inc/partials/content', 'inner-navigation-archive' );
?>

	<div id="main">
		<div class="wrap">
			<?php
			get_sidebar();
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'inc/partials/content', 'archives' );
				endwhile;
				mediaphase_pagination();
			else :
				get_template_part( 'inc/partials/content', 'none' );
			endif;
			?>
		</div>
	</div>
<?php get_footer();
