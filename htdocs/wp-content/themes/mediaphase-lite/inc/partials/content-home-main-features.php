<?php
/**
 * The template part for displaying main features section on the front page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */
global $wp_customize;
$mediaphase_display_main_features = get_theme_mod( 'mediaphase_main_features_show', 'yes' );
if ( $mediaphase_display_main_features === 'yes' ) :
	?>

	<div id="mainfeatures">
		<div class="wrap">
			<div class="featuretitle"><h2><?php echo esc_html( get_theme_mod( 'mediaphase_main_features_title' ) ); ?></h2></div>

			<img src="<?php echo esc_url( get_theme_mod( 'mediaphase_main_features_bg_image' ) ); ?>" alt=""
				 class="mainfeaturesimage"/>

			<div class="mainfeaturesleft">
				<?php
				if ( !empty( $wp_customize ) && $wp_customize->is_preview() && !get_theme_mod( 'mediaphase_content_set', false ) ) {
				?>
					<div class="featurewidget hideme">
						<div class="featurewidgeticon">
							<a href="#"><i class="fa-camera fa"></i></a>
						</div>
						<div class="featurewidgettext">
							<h2 class="featurewidgettitle">Feature 1</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>
						</div>
					</div>
					<div class="featurewidget hideme">
						<div class="featurewidgeticon">
							<a href="#"><i class="fa-check fa"></i></a>
						</div>
						<div class="featurewidgettext">
							<h2 class="featurewidgettitle">Feature 2</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>
						</div>
					</div>
				<?php
				} else if ( is_active_sidebar( 'mediaphase-main-features-left' ) ) {
					dynamic_sidebar( 'mediaphase-main-features-left' );
				}
				?>
			</div>
			<div class="mainfeaturesright">
				<?php
				if ( !empty( $wp_customize ) && $wp_customize->is_preview() && !get_theme_mod( 'mediaphase_content_set', false ) ) {
				?>
					<div class="featurewidget hideme">
						<div class="featurewidgeticon">
							<a href="#"><i class="fa-eye fa"></i></a>
						</div>
						<div class="featurewidgettext">
							<h2 class="featurewidgettitle">Feature 3</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>
						</div>
					</div>
					<div class="featurewidget hideme">
						<div class="featurewidgeticon">
							<a href="#"><i class="fa-info fa"></i></a>
						</div>
						<div class="featurewidgettext">
							<h2 class="featurewidgettitle">Feature 4</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>
						</div>
					</div>
				<?php
				} else if ( is_active_sidebar( 'mediaphase-main-features-right' ) ) {
					dynamic_sidebar( 'mediaphase-main-features-right' );
				}
				?>
			</div>
		</div>

	</div><!-- End #mainfeatures -->
<?php endif;