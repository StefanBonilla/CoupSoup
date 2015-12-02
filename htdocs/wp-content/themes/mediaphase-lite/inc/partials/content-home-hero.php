<?php
/**
 * The template part for displaying a hero banner on the front page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */

$mediaphase_display_hero_banner = get_theme_mod( 'mediaphase_hero_show', 'yes' );
if ( $mediaphase_display_hero_banner === 'yes' ) :
	?>

	<div id="hero">
		<div class="wrap">
			<div id="herocontent">
				<h1 id="herotitle"><?php echo esc_html( get_theme_mod( 'mediaphase_hero_title' ) ); ?></h1>

				<div id="herotext"><?php echo mediaphase_esc_html( get_theme_mod( 'mediaphase_hero_text' ) ); ?></div>
			</div>
			<!-- End #herocontent -->
		</div>
		<!-- End #wrap -->
	</div><!-- End #hero -->

<?php endif;