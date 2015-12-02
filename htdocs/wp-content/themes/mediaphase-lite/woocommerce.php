<?php
/**
 * The template for displaying WooCommerce Pages
 * @package mediaphase
 */

get_header();
get_template_part( 'inc/partials/content', 'inner-navigation' );
?>

	<div id="main">
		<div class="wrap">
			<?php
			get_sidebar();
			?>
			<div class="singlepost">
				<div class="content">
					<?php
					woocommerce_content();
					?>
				</div>
			</div>
		</div>
	</div>


<?php
get_template_part( 'inc/partials/content', 'home-bottom-ribbon' );
get_template_part( 'inc/partials/content', 'home-logos' );

get_footer();