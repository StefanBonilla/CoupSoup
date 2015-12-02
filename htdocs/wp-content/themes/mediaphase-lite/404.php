<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package mediaphase
 */
get_header();
get_template_part( 'inc/partials/content', 'inner-navigation-404' );
?>

	<div id="main">
		<div class="wrap">
			<?php
			get_sidebar();
			get_template_part( 'inc/partials/content', '404' );
			?>
		</div>
	</div>
<?php get_footer();

