<?php
/**
 * The template part for displaying sub features section on the front page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */

$mediaphase_display_sub_features = get_theme_mod( 'mediaphase_sub_features_show', 'yes' );
if ( $mediaphase_display_sub_features === 'yes' ) :
	?>
	<div id="subfeatures">

		<div class="wrap">
			<?php
			global $wp_customize;
			if ( !empty( $wp_customize ) && $wp_customize->is_preview() && !get_theme_mod( 'mediaphase_content_set', false ) ) {
			?>
				<div class="featurewidget hideme">
					<div class="featurewidgeticon">
						<a href="#"><i class="fa-camera fa"></i></a>
					</div>
					<div class="featurewidgettext">
						<h2 class="featurewidgettitle">Sub Feature 1</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p><a class="button red">Read More <i class="fa fa-chevron-circle-right"></i></a>
					</div>
				</div>
				<div class="featurewidget hideme">
					<div class="featurewidgeticon">
						<a href="#"><i class="fa-check fa"></i></a>
					</div>
					<div class="featurewidgettext">
						<h2 class="featurewidgettitle">Sub Feature 2</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p><a class="button red">Read More <i class="fa fa-chevron-circle-right"></i></a>
					</div>
				</div>
				<div class="featurewidget hideme">
					<div class="featurewidgeticon">
						<a href="#"><i class="fa-eye fa"></i></a>
					</div>
					<div class="featurewidgettext">
						<h2 class="featurewidgettitle">Sub Feature 3</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p><a class="button red">Read More <i class="fa fa-chevron-circle-right"></i></a>
					</div>
				</div>
			<?php
			} else if ( is_active_sidebar( 'mediaphase-sub-features' ) ) {
				dynamic_sidebar( 'mediaphase-sub-features' );
			}
			?>
		</div>
		<!-- End #wrap -->
	</div><!-- End #subfeatures -->
<?php endif;