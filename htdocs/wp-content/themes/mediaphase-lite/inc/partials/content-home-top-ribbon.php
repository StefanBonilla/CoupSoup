<?php
/**
 * The template part for displaying a top ribbon on the front page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */

$mediaphase_display_top_ribbon = get_theme_mod( 'mediaphase_top_ribbon_show', 'yes' );
if ( $mediaphase_display_top_ribbon === 'yes' ) :
	?>

	<div id="ribbon" class="topribbon">
		<div class="wrap">
			<p><?php echo mediaphase_esc_html( get_theme_mod( 'mediaphase_top_ribbon_text' ) ); ?></p>
		</div>
		<!-- End #wrap -->
	</div>

<?php endif;