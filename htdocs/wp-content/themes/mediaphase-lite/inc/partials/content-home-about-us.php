<?php
/**
 * The template part for displaying about us section on the front page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */

$mediaphase_display_about_us = get_theme_mod( 'mediaphase_about_us_show', 'yes' );
if ( $mediaphase_display_about_us === 'yes' ) :
	?>

	<div id="aboutus">
		<div class="wrap">
			<div class="featuretitle"><h2><?php echo esc_html( get_theme_mod( 'mediaphase_about_us_title' ) ); ?></h2></div>
			<p><?php echo esc_html( get_theme_mod( 'mediaphase_about_us_text' ) ); ?></p>
		</div>
		<!-- End #wrap -->
	</div><!-- End #aboutus -->
<?php endif;