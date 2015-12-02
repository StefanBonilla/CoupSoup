<?php
/**
 * The template part for displaying a middle ribbon on the front page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */

$mediaphase_display_middle_ribbon = get_theme_mod( 'mediaphase_middle_ribbon_show', 'yes' );
if ( $mediaphase_display_middle_ribbon === 'yes' ) :
	?>

	<div id="ribbon" class="midribbon">
		<div class="wrap">
			<?php echo mediaphase_esc_html( get_theme_mod( 'mediaphase_middle_ribbon_text' ) ); ?>
		</div>
		<!-- End #wrap -->
	</div>

<?php endif;
