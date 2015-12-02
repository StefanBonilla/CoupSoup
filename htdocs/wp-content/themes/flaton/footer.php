<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package flaton
 */
?>

	</div><!-- #content -->
</div>

	<footer id="colophon" class="site-footer" role="contentinfo">
	<?php
		global $flaton;
		if( $flaton['footer-widgets'] ) : ?>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<?php get_template_part('footer','widgets'); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="sixteen columns">
					<div class="site-info">
						<?php do_action( 'flaton_credits' ); ?>
					</div><!-- .site-info -->
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
