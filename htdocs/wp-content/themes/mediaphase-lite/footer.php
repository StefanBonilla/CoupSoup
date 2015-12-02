<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package mediaphase
 */
?>

<div id="backtotop">
	<div class="wrap">
		<a href="#"><i class="fa fa-chevron-up"></i></a>
	</div>
	<!-- End #wrap -->
</div>

<div id="footer">
	<div class="wrap">
		<?php
		global $wp_customize;
		if ( !empty( $wp_customize ) && $wp_customize->is_preview() && !get_theme_mod( 'mediaphase_content_set', false ) ) {
			the_widget( 'WP_Widget_Recent_Posts', array(), array(
				'before_widget' => '<div class="footerwidget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="footerwidgettitle">',
				'after_title'   => '</h4>',
			) );

			the_widget( 'WP_Widget_Recent_Comments', array(), array(
				'before_widget' => '<div class="footerwidget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="footerwidgettitle">',
				'after_title'   => '</h4>',
			) );

			the_widget( 'WP_Widget_Meta', array(), array(
				'before_widget' => '<div class="footerwidget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="footerwidgettitle">',
				'after_title'   => '</h4>',
			) );
		} else if ( is_active_sidebar( 'mediaphase-footer' ) ) {
			dynamic_sidebar( 'mediaphase-footer' );
		}
		?>
	</div>
	<!-- End #wrap -->
</div>


<div id="bottom">
	<div class="wrap">
		<a href="<?php echo esc_url( home_url() ); ?>" rel="home">
			<?php
			$mediaphase_display_footer_logo = get_theme_mod( 'mediaphase_footer_logo_show', 'no' );
			if ( $mediaphase_display_footer_logo === 'yes' ) {
				echo '<img src="' . esc_url( get_theme_mod( 'mediaphase_footer_logo_image' ) ) . '" class="bottomlogo"/>';
			} else {
				echo '<span class="bottomlogo">&nbsp;</span>';
			}
			?>
			<p class="bottomtext">
				<a rel="generator"
				   href="<?php echo esc_url( __( 'http://wordpress.org/', 'mediaphase-lite' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'mediaphase-lite' ), 'WordPress' ); ?></a> <?php printf( __( 'Theme: %1$s by %2$s.', 'mediaphase-lite' ), 'Mediaphase Lite', '<a href="http://themefurnace.com" rel="designer">ThemeFurnace</a>' ); ?>
			</p>
	</div>
	<!-- End #wrap -->
</div>

</div><!-- End .container -->

<?php wp_footer(); ?>

</body>
</html>
