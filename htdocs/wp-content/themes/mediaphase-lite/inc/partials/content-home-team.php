<?php
/**
 * The template part for displaying team section on the front page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mediaphase
 */

$mediaphase_display_meet_the_team = get_theme_mod( 'mediaphase_meet_the_team_show', 'yes' );
if ( $mediaphase_display_meet_the_team === 'yes' ) :
	?>

	<div id="team">
		<div class="wrap">
			<div class="featuretitle"><h2><?php echo esc_html( get_theme_mod( 'mediaphase_meet_the_team_title' ) ); ?></h2></div>
			<p class="teamintro"><?php echo mediaphase_esc_html( get_theme_mod( 'mediaphase_meet_the_team_text' ) ); ?></p>

			<div id="teammembers">
				<?php
				global $wp_customize;
				if ( !empty( $wp_customize ) && $wp_customize->is_preview() && !get_theme_mod( 'mediaphase_content_set', false ) ) {
				?>
					<div class="member hideme">
						<img src="<?php echo get_template_directory_uri()?>/img/staff1.jpg" class="memberphoto">
						<h3 class="membertitle">Member 1</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan
							auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>

						<div class="teamsocial">
							<a href="http://twitter.com"><span class="screen-reader-text">http://twitter.com</span></a>
							<a href="http://facebook.com"><span	class="screen-reader-text">http://facebook.com</span></a>
							<a href="http://linkedin.com"><span	class="screen-reader-text">http://linkedin.com</span></a>
							<a href="http://dribbble.com"><span	class="screen-reader-text">http://dribbble.com</span></a>
							<a href="http://plus.google.com"><span class="screen-reader-text">http://plus.google.com</span></a>
						</div>
					</div>
					<div class="member hideme">
						<img src="<?php echo get_template_directory_uri()?>/img/staff2.jpg" class="memberphoto">
						<h3 class="membertitle">Member 2</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan
							auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>

						<div class="teamsocial">
							<a href="http://twitter.com"><span class="screen-reader-text">http://twitter.com</span></a>
							<a href="http://facebook.com"><span	class="screen-reader-text">http://facebook.com</span></a>
							<a href="http://linkedin.com"><span	class="screen-reader-text">http://linkedin.com</span></a>
							<a href="http://dribbble.com"><span	class="screen-reader-text">http://dribbble.com</span></a>
							<a href="http://plus.google.com"><span class="screen-reader-text">http://plus.google.com</span></a>
						</div>
					</div>
					<div class="member hideme">
						<img src="<?php echo get_template_directory_uri()?>/img/staff3.jpg" class="memberphoto">
						<h3 class="membertitle">Member 3</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan
							auctor, felis eros condimentum quam, non porttitor est urna vel neque</p>

						<div class="teamsocial">
							<a href="http://twitter.com"><span class="screen-reader-text">http://twitter.com</span></a>
							<a href="http://facebook.com"><span	class="screen-reader-text">http://facebook.com</span></a>
							<a href="http://linkedin.com"><span	class="screen-reader-text">http://linkedin.com</span></a>
							<a href="http://dribbble.com"><span	class="screen-reader-text">http://dribbble.com</span></a>
							<a href="http://plus.google.com"><span class="screen-reader-text">http://plus.google.com</span></a>
						</div>
					</div>
				<?php
				} else if ( is_active_sidebar( 'mediaphase-team' ) ) {
					dynamic_sidebar( 'mediaphase-team' );
				}
				?>
			</div>
			<!-- End #teammembers -->

		</div>
		<!-- End #wrap -->
	</div><!-- End #team -->
<?php endif;