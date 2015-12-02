<?php
/**
 * Template name: Homepage
 *
 * The main template file.
 *
 * @package mediaphase
 */

get_header();

?>

	<div id="main">
		<div class="wrap">
			<!-- sidebar for blog -->
			<?php get_sidebar(); ?>
			<!-- end sidebar for blog -->

			<!-- content -->
			<?php
			$mediaphase_paged = get_query_var( 'paged', 1 );
			$mediaphase_current_page = $mediaphase_paged > 0 ? '&paged=' . $mediaphase_paged : '';
			$mediaphase_main_posts = new WP_Query( '&post_type=post&post_status=publish' . $mediaphase_current_page );

			if ( $mediaphase_main_posts->have_posts() ) :
				while ( $mediaphase_main_posts->have_posts() ) :
					$mediaphase_main_posts->the_post();
					get_template_part( 'inc/partials/content', 'blog-default' );
				endwhile;

				mediaphase_pagination($mediaphase_main_posts);
				wp_reset_query();

			else:
				get_template_part( 'inc/partials/content', 'none' );
			endif;

			?>
			<!-- end content -->
		</div>
	</div>

<?php

get_template_part( 'inc/partials/content', 'home-bottom-ribbon' );
get_template_part( 'inc/partials/content', 'home-logos' );

get_footer();